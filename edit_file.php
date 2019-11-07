<link rel="stylesheet" href="style.css">
<?php


$dsn="mysql:host=localhost;charset=utf8;dbname=upload";
$pdo=new PDO($dsn,"root","");

if (!empty($_POST)  ) {
/* if (!empty($_FILES) && $_FILES['file']['error']==0 ) { */

    $notes= $_POST['notes'];
    $type=$_FILES['file']['type'];
/*     $filename=$_FILES['file']['name'];  */
/*     $origin_name=$_FILES['file']['name'];
    $save_name=md5(time().$_FILES['file']['name']);     */
/*     $path="./upload/";  */
    $updateTime=date("Y-m-d H:i:s");
    $origin_name=$_FILES['file']['name'];
    $save_name=md5(time().$_FILES['file']['name']);
    switch($_FILES['file']['type']){
        case "image/jpeg":
            $subname=".jpg";
        break;
        case "image/png":
            $subname=".png";
        break;
        case "image/gif":
            $subname=".gif";
        break;
        default:
            $subname=".others";
    }
    $path="./upload/".$save_name.$subname;    
    $id=$_POST['id'];
    move_uploaded_file($_FILES['file']['tmp_name'] , $path);
    
    //刪原有檔案
    $sql="select * from files where id='$id'";
    $origin=$pdo->query($sql)->fetch();
    $origin_file=$origin['path'];
    unlink($origin_file);  // --> delete電腦中的檔案


    //更新資料
    $sql="update files set name='$origin_name', type='$type',update_time='$updateTime', notes='$notes', path='$path' where id='$id'" ;

    $result=$pdo->exec($sql);
    if ($result==1) {
        echo "資料上傳成功";
        header("location:manage.php");
    }else{
        echo"DB有誤";
    }
}

    $id=$_GET['id'];  //取得隱藏傳回的id值
    $sql="select * from files where id='$id'";
    $data=$pdo->query($sql)->fetch();

?>
<form action="edit_file.php" method="post" enctype="multipart/form-data">
<table>
    <tr>
        <td colspan=2>
        <img src="<?=$data['path'];?>" style="width:200px;height:auto">
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
        <td>說明</td>
        <td><?=$data['notes'];?></td>
    </tr>
    <tr>
        <td>create_time</td>
        <td><?=$data['create_time'];?></td>
    </tr>

</table>
更新檔案: <input type="file" name="file"><br>
<input type="hidden" name="id" value="<?=$data['id'];?>">
說明：<input type="text" name="notes" id="notes" value="<?=$data['notes'];?>"><br>
<input type="submit" value="更新">
</form>