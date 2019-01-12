<?php include_once '../config.php';
//get images id and generate ids array
$idArray = explode(",",$_POST['ids']);
//update images order
$count = 1;
foreach ($idArray as $id){
    $data   =   array('img_order'=>$count);
    $update = $db->update(TB_IMG,$data,array('id'=>$id));
    $count ++;
}
echo '1';
?>