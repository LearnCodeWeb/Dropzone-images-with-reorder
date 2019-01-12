<?php include_once('config.php');?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Upload Images</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <link rel="stylesheet" href="dropzone/dropzone.css" type="text/css">
</head>
<body>
	
    <div class="container">
        <div class="dropzone dz-clickable" id="myDrop">
            <div class="dz-default dz-message" data-dz-message="">
                <span>Drop files here to upload</span>
            </div>
        </div>
        <input type="button" id="add_file" value="Add" class="btn btn-primary mt-3">
    </div>
    <hr class="my-5">
    <div class="container">
    	<div id="msg" class="mb-3"></div>
        <a href="javascript:void(0);" class="btn btn-outline-primary reorder" id="updateReorder">Reorder Imgaes</a>
        <div id="reorder-msg" class="alert alert-warning mt-3" style="display:none;">
            <i class="fa fa-3x fa-exclamation-triangle float-right"></i> 1. Drag photos to reorder.<br>2. Click 'Save Reordering' when finished.
        </div>
        <div class="gallery">
            <ul class="nav nav-pills">
            <?php
				//Fetch all images from database
                $images = $db->getAllRecords(TB_IMG,'*','order by img_order ASC');
                if(!empty($images)){
                    foreach($images as $row){
                ?>
                <li id="image_li_<?php echo $row['id']; ?>" class="ui-sortable-handle mr-2 mt-2">
                    <div><a href="javascript:void(0);" class="img-link"><img src="uploads/<?php echo $row['img_name']; ?>" alt="" class="img-thumbnail" width="200"></a></div>
                </li>
                <?php
                    }
                }
            ?>
            </ul>
        </div>
    </div>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
    <script src="dropzone/dropzone.js"></script>
    <script>
		$(document).ready(function(){
			$('.reorder').on('click',function(){
				$("ul.nav").sortable({ tolerance: 'pointer' });
				$('.reorder').html('Save Reordering');
				$('.reorder').attr("id","updateReorder");
				$('#reorder-msg').slideDown('');
				$('.img-link').attr("href","javascript:;");
				$('.img-link').css("cursor","move");
				$("#updateReorder").click(function( e ){
					if(!$("#updateReorder i").length){
						$(this).html('').prepend('<i class="fa fa-spin fa-spinner"></i>');
						$("ul.nav").sortable('destroy');
						$("#reorder-msg").html( "Reordering Photos - This could take a moment. Please don't navigate away from this page." ).removeClass('light_box').addClass('notice notice_error');
			 
						var h = [];
						$("ul.nav li").each(function() {  h.push($(this).attr('id').substr(9));  });
						 
						$.ajax({
							type: "POST",
							url: "ajax/update.php",
							data: {ids: " " + h + ""},
							success: function(data){
								if(data==1 || parseInt(data)==1){
									window.location.reload();
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
				//setTimeout(function(){window.location.href="index.php"},200);
			});
			  
			myDropzone.on("error", function (data) {
				 $("#msg").html('<div class="alert alert-danger">There is some thing wrong, Please try again!</div>');
			});
			  
			myDropzone.on("complete", function(file) {
				myDropzone.removeFile(file);
			});
			  
			$("#add_file").on("click",function (){
				myDropzone.processQueue();
			});
			 
		});
	</script>
    
</body>
</html>
