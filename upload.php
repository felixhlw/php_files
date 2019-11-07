<?php
/**
 * 1.建立表單
 * 2.建立處理檔案程式
 * 3.搬移檔案
 * 4.顯示檔案列表
 */
/* if (!empty($_POST)) {   /* 注意:form 的 input 起碼要有一筆 text 的type，才會有post資訊喔 --> */  
if (!empty($_FILES) && $_FILES['img']['error']==0) { /*可用這方式避免form 中沒有post的資料 */
    
    echo "有POST的資料";
    echo "<br>";
    echo $_FILES['img']['error'];
    echo "<br>";
    echo $_FILES['img']['tmp_name'];
    echo "<br>";
    echo $_FILES['img']['type'];
    echo "<br>";
    echo $_FILES['img']['size'];
    echo "<br>";
    move_uploaded_file($_FILES['img']['tmp_name'],"./img/".$_FILES['img']['name']);
 }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>檔案上傳</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>


 <h1 class="header">檔案上傳練習</h1>
 <!----建立你的表單及設定編碼----->


 <form action="upload.php" method="post" enctype="multipart/form-data">
檔案：<input type="file" name="img" ><br>
檔案說明：<input type="text" name="desc"><br> <!-- 注意:要有text 的type，才會有post資訊喔 -->
<input type="submit" value="上傳">
</form>




<!----建立一個連結來查看上傳後的圖檔---->  

<br><br>
<a href="./img/">查看上傳的檔案</a>8

</body>
</html>