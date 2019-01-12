# Multi Files Uploader PHP

<!-- wp:paragraph -->
<p>To achieve this task we can use a very famous JQuery Plugin <a href="https://www.dropzonejs.com/">Dropzone.js</a>. </p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>I am going to show you, how you can create your own Dropzone and reorder your images.<br>Before we go you need to understand why we use Drag &amp; Drop feature to upload images, The answer is very simple because it is very user-friendly.<br></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>If your site is user-friendly then more user visits your site and every user upload images easily and confidently.<br>Follow below steps to create such a beautiful image uploader.</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2>Create before start:</h2>
<!-- /wp:heading -->

<!-- wp:list -->
<ul><li>Create a MySQL table with the name of images.</li><li>Into your main folder Create the following folder.<ul><li>ajax<ul><li>action-z.ajax.php</li><li>update.php</li></ul></li><li>dropzone [<em>Download dropzone lib. </em><a href="https://gitlab.com/meno/dropzone"><em>Download link</em></a>]<ul><li>dropzone.css</li><li>dropzone.js</li></ul></li><li><del>images</del> <em>[if you are using dropzone CDN then ignore this folder]</em></li><li>uploads</li></ul></li><li>Into your main folder create the following files.<ul><li>index.php</li><li>config.php</li><li>Database.php [<em>It is a DB class lib </em><a href="https://bitbucket.org/snippets/zaidbinkhalid/LeajAa"><em>Download link</em></a>]</li></ul></li></ul>
<!-- /wp:list -->

<!-- wp:heading -->
<h2>Step 1</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Create MySQL Table by using below query.</p>
<!-- /wp:paragraph -->

<!-- wp:syntaxhighlighter/code {"language":"sql"} -->
<pre class="wp-block-syntaxhighlighter-code">CREATE TABLE `images` (
  `id` int(11) NOT NULL,
  `img_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `img_order` int(5) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `status` enum('1','0') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1'
);
--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`);
--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;</pre>
<!-- /wp:syntaxhighlighter/code -->

<!-- wp:paragraph -->
<p>If you already have a Table then change table name into config.php. at line number 25.</p>
<!-- /wp:paragraph -->

<!-- wp:syntaxhighlighter/code {"language":"php"} -->
<pre class="wp-block-syntaxhighlighter-code">/*** TB DEFINE ***/
define('TB_IMG','images');</pre>
<!-- /wp:syntaxhighlighter/code -->

<!-- wp:heading -->
<h2>Step 2</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Create a <g class="gr_ gr_9 gr-alert gr_gramm gr_inline_cards gr_run_anim Grammar only-ins doubleReplace replaceWithoutSep" id="9" data-gr-id="9">config.php</g> file and set up your DB with right credentials. If you are working on a local server then use below code.</p>
<!-- /wp:paragraph -->

<!-- wp:syntaxhighlighter/code {"language":"php"} -->
<pre class="wp-block-syntaxhighlighter-code">&lt;?php
session_start();
define('HOST', 'ofline');
error_reporting(0);
if(HOST == 'online'){
	define('DB_NAME', '');
	define('DB_USER', '');
	define('DB_PASSWORD', '');
	define('DB_HOST', 'localhost');
	define('HOME_URL','https://learncodeweb/');
	define("HOME_PATH",'https://learncodeweb/');
	define("HOME_AJAX",HOME_URL.'ajax/');
	
}else{
	define('DB_NAME', 'learncodeweb');
	define('DB_USER', 'root');
	define('DB_PASSWORD', '');
	define('DB_HOST', 'localhost');
	define('HOME_URL','http://localhost/drop-reorder-image/');
	define("HOME_PATH",'http://localhost/drop-reorder-image/');
	define("HOME_AJAX",HOME_URL.'ajax/');
}

/*** TB DEFINE ***/
define('TB_IMG','images');

/*** DB INCLUDES ***/
include_once 'Database.php';

/*** DB CONNECTION ***/
$dsn		= 	"mysql:dbname=".DB_NAME.";host=".DB_HOST."";
$pdo		=	'';
try {$pdo 	= 	new PDO($dsn, DB_USER, DB_PASSWORD);} catch (PDOException $e) {echo "Connection failed: " . $e->getMessage();}

/*Classes*/
$db			=	new Database($pdo);
?></pre>
<!-- /wp:syntaxhighlighter/code -->

<!-- wp:heading -->
<h2>Step 3</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Create a index.php file and add below code into your head tag.</p>
<!-- /wp:paragraph -->

<!-- wp:syntaxhighlighter/code {"language":"xml"} -->
<pre class="wp-block-syntaxhighlighter-code">&lt;link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
&lt;link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
&lt;link rel="stylesheet" href="dropzone/dropzone.css" type="text/css"></pre>
<!-- /wp:syntaxhighlighter/code -->

<!-- wp:paragraph -->
<p>Add JavaScript files and code before body tag close.<br></p>
<!-- /wp:paragraph -->

<!-- wp:syntaxhighlighter/code {"language":"xml"} -->
<pre class="wp-block-syntaxhighlighter-code">&lt;script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js">&lt;/script>
&lt;script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js">&lt;/script>
&lt;script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous">&lt;/script>
&lt;script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous">&lt;/script>
&lt;script src="dropzone/dropzone.js">&lt;/script></pre>
<!-- /wp:syntaxhighlighter/code -->

<!-- wp:syntaxhighlighter/code {"language":"jscript"} -->
<pre class="wp-block-syntaxhighlighter-code">$(document).ready(function(){
	$('.reorder').on('click',function(){
		$("ul.nav").sortable({ tolerance: 'pointer' });
		$('.reorder').html('Save Reordering');
		$('.reorder').attr("id","updateReorder");
		$('#reorder-msg').slideDown('');
		$('.img-link').attr("href","javascript:;");
		$('.img-link').css("cursor","move");
		$("#updateReorder").click(function( e ){
			if(!$("#updateReorder i").length){
				$(this).html('').prepend('&lt;i class="fa fa-spin fa-spinner">&lt;/i>');
				$("ul.nav").sortable('destroy');
				$("#reorder-msg").html( "Reordering Photos - This could take a moment. Please don't navigate away from this page." ).removeClass('light_box').addClass('notice notice_error');
	
				var h = [];
				$("ul.nav li").each(function() {  h.push($(this).attr('id').substr(9));  });
				
				$.ajax({
					type: "POST",
					url: "&lt;?php echo HOME_AJAX; ?>update.php",
					data: {ids: " " + h + ""},
					success: function(data){
						if(data==1 || parseInt(data)==1){
							//window.location.reload();
						}
					}
				});	
				return false;
			}		
			e.preventDefault();		
		});
	});
	
	$(function() {
      $("#myDrop").sortable({
        items: '.dz-preview',
        cursor: 'move',
        opacity: 0.5,
        containment: '#myDrop',
        distance: 20,
        tolerance: 'pointer',
      });

      $("#myDrop").disableSelection();
    });
	
	//Dropzone script
	Dropzone.autoDiscover = false;
	
	var myDropzone = new Dropzone("div#myDrop", 
	{ 
		 paramName: "files", // The name that will be used to transfer the file
		 addRemoveLinks: true,
		 uploadMultiple: true,
		 autoProcessQueue: false,
		 parallelUploads: 50,
		 maxFilesize: 5, // MB
		 acceptedFiles: ".png, .jpeg, .jpg, .gif",
		 url: "ajax/action-z.ajax.php",
	});
	
	myDropzone.on("sending", function(file, xhr, formData) {
	  var filenames = [];
	  
	  $('.dz-preview .dz-filename').each(function() {
		filenames.push($(this).find('span').text());
	  });
	
	  formData.append('filenames', filenames);
	});
	
	/* Add Files Script*/
	myDropzone.on("success", function(file, message){
		$("#msg").html(message);
		setTimeout(function(){window.location.href="index.php"},200);
	});
	 
	myDropzone.on("error", function (data) {
		 $("#msg").html('&lt;div class="alert alert-danger">There is some thing wrong, Please try again!&lt;/div>');
	});
	 
	myDropzone.on("complete", function(file) {
		myDropzone.removeFile(file);
	});
	 
	$("#add_file").on("click",function (){
		myDropzone.processQueue();
	});
	
});</pre>
<!-- /wp:syntaxhighlighter/code -->

<!-- wp:paragraph -->
<p>In index body past below code.</p>
<!-- /wp:paragraph -->

<!-- wp:syntaxhighlighter/code {"language":"xml"} -->
<pre class="wp-block-syntaxhighlighter-code">&lt;div class="container">
	&lt;div class="dropzone dz-clickable" id="myDrop">
		&lt;div class="dz-default dz-message" data-dz-message="">
			&lt;span>Drop files here to upload&lt;/span>
		&lt;/div>
	&lt;/div>
	&lt;input type="button" id="add_file" value="Add" class="btn btn-primary mt-3">
&lt;/div>
&lt;hr class="my-5">
&lt;div class="container">
	&lt;a href="javascript:void(0);" class="btn btn-outline-primary reorder" id="updateReorder">Reorder Imgaes&lt;/a>
    &lt;div id="reorder-msg" class="alert alert-warning mt-3" style="display:none;">
		&lt;i class="fa fa-3x fa-exclamation-triangle float-right">&lt;/i> 1. Drag photos to reorder.&lt;br>2. Click 'Save Reordering' when finished.
	&lt;/div>
    &lt;div class="gallery">
        &lt;ul class="nav nav-pills">
        &lt;?php 
			//Fetch all images from database
			$images = $db->getAllRecords(TB_IMG,'*','order by img_order ASC');
			if(!empty($images)){
				foreach($images as $row){
			?>
            &lt;li id="image_li_&lt;?php echo $row['id']; ?>" class="ui-sortable-handle mr-2 mt-2">
            	&lt;div>&lt;a href="javascript:void(0);" class="img-link">&lt;img src="uploads/&lt;?php echo $row['img_name']; ?>" alt="" class="img-thumbnail" width="200">&lt;/a>&lt;/div>
            &lt;/li>
			&lt;?php
                }
            }
		?>
        &lt;/ul>
    &lt;/div>
&lt;/div></pre>
<!-- /wp:syntaxhighlighter/code -->

<!-- wp:paragraph -->
<p>Now we just need to handle requests for upload &amp; save images, and update reorder images.</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2>Step 4</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Past below snippets into ajax/action-z.ajax.php file.</p>
<!-- /wp:paragraph -->

<!-- wp:syntaxhighlighter/code {"language":"php"} -->
<pre class="wp-block-syntaxhighlighter-code">&lt;?php
include_once('../config.php');

if(!empty($_FILES['files'])){
	$n=0;
	$s=0;
	$prepareNames	=	array();
	foreach($_FILES['files']['name'] as $val)
	{
		$infoExt 		= 	getimagesize($_FILES['files']['tmp_name'][$n]);
		$s++;
		$filesName		=	str_replace(" ","",trim($_FILES['files']['name'][$n]));
		$files			=	explode(".",$filesName);
		$File_Ext   	=   substr($_FILES['files']['name'][$n], strrpos($_FILES['files']['name'][$n],'.'));
		
		if($infoExt['mime'] == 'image/gif' || $infoExt['mime'] == 'image/jpeg' || $infoExt['mime'] == 'image/png')
		{
			$srcPath	=	'../uploads/';
			$fileName	=	$s.rand(0,999).time().$File_Ext;
			$path	=	trim($srcPath.$fileName);
			if(move_uploaded_file($_FILES['files']['tmp_name'][$n], $path))
			{
				$prepareNames[]	.=	$fileName; //need to be fixed.
				$Sflag		= 	1; // success
			}else{
				$Sflag	= 2; // file not move to the destination
			}
		}
		else
		{
			$Sflag	= 3; //extention not valid
		}
		$n++;
	}
	if($Sflag==1){
		echo '{Images uploaded successfully!}';
	}else if($Sflag==2){
		echo '{File not move to the destination.}';
	}else if($Sflag==3){
		echo '{File extention not good. Try with .PNG, .JPEG, .GIF, .JPG}';
	}

	if(!empty($prepareNames)){
		$count	=	1;
		foreach($prepareNames as $name){
			$data	=	array(
							'img_name'=>$name,
							'img_order'=>$count++,
						);
			$db->insert(TB_IMG,$data);
		}
	}
}
?></pre>
<!-- /wp:syntaxhighlighter/code -->

<!-- wp:paragraph -->
<p>And for update order of the images send a request to a update.php file. Past below code into the ajax/update.php file.</p>
<!-- /wp:paragraph -->

<!-- wp:syntaxhighlighter/code {"language":"php"} -->
<pre class="wp-block-syntaxhighlighter-code">&lt;?php include_once '../config.php';
//get images id and generate ids array
$idArray = explode(",",$_POST['ids']);
//update images order
$count = 1;
foreach ($idArray as $id){
	$data	=	array('img_order'=>$count);
	$update = $db->update(TB_IMG,$data,array('id'=>$id));
	$count ++;
}
echo '1';
?></pre>
<!-- /wp:syntaxhighlighter/code -->

Thank you

Regards Zaid Bin Khalid
