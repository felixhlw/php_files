
  
<?php
include_once "base.php";
if(!empty($_POST)){  
/*     if(isset($_FILES['file']) && !empty($_POST) && !empty($_POST['notes'])) { */
        /* if(!empty($_POST) && !empty($_FILES) ){  */   
            $id=$_POST['id'];
            $notes=$_POST['notes'];
            $sql="select * from files where id='$id'";
            $origin=$pdo->query($sql)->fetch();
            $origin_path=$origin['path'];
            $origin_file=$origin['name'];
            if (!empty($_FILES['file'])) {
                
                if (!empty($_FILES['file']['name'])) {
                    $filename=$_FILES['file']['name'];
                    $type=$_FILES['file']['type'];
                }else{
                    $filename=$origin_file;
                    $type=$origin['type'];
                }
                $path="./upload/";
                $updateTime=date("Y-m-d H:i:s");
                move_uploaded_file($_FILES['file']['tmp_name'] , $path.$filename );
                //刪除原本的檔案
                //unlink($origin_file);
                //更新資料
                $sql="update files set name='$filename',type='$type',update_time='$updateTime',path='$path',notes='$notes' where id='$id'";
            }else{
                $type=$origin['type'];
                $filename=$origin['name'];
                $path=$origin['path'];
                $updateTime=date("Y-m-d H:i:s");
                $sql="update files set update_time='$updateTime',path='$path',notes='$notes' where id='$id'";

            }
            $result=$pdo->exec($sql);
            if($result==1){
                echo "更新成功";
                header("location:manage.php");
            }else{
                echo "DB有誤";
            }
        
 

        }

$id=$_GET['id'];
$sql="select * from files where id='$id'";
$data=$pdo->query($sql)->fetch();
?>
<style>
table{
  border-collapse:collapse;
}
td{
  padding:5px;
  border:1px solid #ccc;
}
</style>
<form action="edit_file.php?id=<?=$data['id'];?>" method="post" enctype="multipart/form-data">
<table>
    <tr>
        <td colspan="2">
            <img src="<?=$data['path'].$data['name'];?>" style="width:200px;height:200px">
        </td>

    </tr>
    <tr>
        <td>name</td>
        <td><?=$data['name'];?></td>
    </tr>
    <tr>
        <td>path</td>
        <td><?=$data['path'];?></td>
    </tr>
    <tr>
        <td>type</td>
        <td><?=$data['type'];?></td>
    </tr>
    <tr>
        <td>create_time</td>
        <td><?=$data['create_time'];?></td>
    </tr>
</table><br>
更新檔案:<input type="file" name="file"><br><br>
標題:<input type="text" name="title" value="<?=$data['notes'];?>"><br><br>
說明:<textarea name="notes" id="notes" cols="30" rows="10"></textarea>
<input type="hidden" name="id" value="<?=$data['id'];?>">
<input type="submit" value="更新">
</form>