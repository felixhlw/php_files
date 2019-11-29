<?php
/**
 * 1.建立資料庫及資料表來儲存檔案資訊
 * 2.建立上傳表單頁面
 * 3.取得檔案資訊並寫入資料表
 * 4.製作檔案管理功能頁面
 */
$dsn="mysql:host=localhost;charset=utf8;dbname=upload";
$pdo= new PDO($dsn, "root", "");


if (!empty($_FILES) && $_FILES['file']['error']==0) { /*可用這方式避免form 中沒有post的資料 */
    $title= $_POST['title'];
    $notes= $_POST['notes'];
    echo "$notes";
    $type= $_FILES['file']['type'];
    $filename=$_FILES['file']['name'];
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
    $path="./upload/";
    $imgfile="./upload/" . $filename;
    
    move_uploaded_file($_FILES['file']['tmp_name'], $path . $filename);
     
    $sql="insert into files (`name`,`type`,`title`,`notes`,`path`) values ('$filename','$type','$title','$notes','$path')";    
    
    $result=$pdo->exec($sql);
    if ($result==1) {
        echo "資料上傳成功";
    }else{
        echo"DB有誤";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>檔案管理功能</title>
    <link rel="stylesheet" href="style.css">

    <style>
        a{
            padding: 2px 10px;
            border: solid 1px rgba(0,0,0,.5);
            border-radius: 20px;
            box-shadow: 0 1px 3px 0px rgba(0,0,0,.2);

        }
    </style>        

</head>
<body>
<h1 class="header">檔案管理練習</h1>
<!----建立上傳檔案表單及相關的檔案資訊存入資料表機制----->


<form action="manage.php" method="post" enctype="multipart/form-data">
檔案：<input type="file" name="file" ><br>
標題：<input type="text" name="title" id="title"><br> <!-- 注意:要有text 的type，才會有post資訊喔 -->
說明<textarea name="notes" id="" cols="30" rows="5"></textarea>
<input type="submit" value="上傳">
<br><br>
</form>


<!----透過資料表來顯示檔案的資訊，並可對檔案執行更新或刪除的工作----->


<table>
    <tr>
        <td>id</td>
        <td>name</td>
        <td>type</td>
        <td>縮圖</td>
        <td>path</td>
        <td>標題</td>
        <td>說明</td>
        <td>create time</td>
        <td>操作</td>

    </tr>
 <?php
    $sql="select * from files";
    $rows=$pdo->query($sql)->fetchAll();
    foreach ($rows as $key => $file) {
?>
    <tr>
        <td><?=$file['id'];?></td>
        <td><?=$file['name'];?></td>
        <td><?=$file['type'];?></td>
        <td><img src="<?=$file['path'] . $file['name'] ;?>" style="width:80px ;height:auto;"></td>
        <td><?=$file['path'];?></td>
        <td><?=$file['title'];?></td>
        <td><?=$file['notes'];?></td>
        <td><?=$file['create_time'];?></td>
        <td>
            <a href="edit_file.php?id=<?=$file['id'];?>">更新檔案</a>
            <a href="del_file.php?id=<?=$file['id'];?>">刪除檔案</a>
        </td>
    </tr>
<?php
    }
?>    
</table>



</body>
</html>