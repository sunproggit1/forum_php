<?php
session_start();
require_once "config.php";
$name = $email = $role = $theme = $question = $image = "";

$id = $comcount = 0;
if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
 
    $input_id = trim(intval($_GET["id"]));
    
        $id = $input_id;
    
 $sql = "SELECT * from users where id=?";
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "i", $param_id);
            $param_id = intval($id);
        if(mysqli_stmt_execute($stmt)){
          $result = mysqli_stmt_get_result($stmt);
         if(mysqli_num_rows($result) > 0){
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    $name =  $row["username"];
                    $email = $row["email"];
                    $role = $row["role"];
              }
            else{
                echo "Неверный идентификатор.";
            }
        }
        else {
          echo "Что то пошло не так.";
        }
      
mysqli_stmt_close($stmt);
}
}
elseif(isset($_SESSION["name"]) && empty(trim($_GET["id"])))
{

                    $name =  $_SESSION["name"];
                    $email = $_SESSION["email"];
                    $role = $_SESSION["role"];

}


if (isset($_POST["submit1"]))
 {
     #retrieve file title
        $title = $_POST["filetitle"];
     
    #file name with a random number so that similar dont get replaced
     $pname = rand(1000,10000)."_".$_FILES["file"]["name"];
 
    #temporary file name to store file
    $tname = $_FILES["file"]["tmp_name"];
   
     #upload directory path
$uploads_dir = 'profileimg';
    #TO move the uploaded file to specific location
    move_uploaded_file($tname, './'.$uploads_dir.'/'.$pname);

    $sql = "SELECT * FROM fileup where username = '".$_SESSION["name"]."'";
if($stmt =  mysqli_prepare($link, $sql)){
  if(mysqli_stmt_execute($stmt)){
    $result = mysqli_stmt_get_result($stmt);
  if(mysqli_num_rows($result) > 0){

    $sql1 = "UPDATE fileup SET title = '$title',image ='$pname' where username = '".$name."'";
     if($stmt1 =  mysqli_prepare($link, $sql1)){
  if(mysqli_stmt_execute($stmt1)){
     unset($_FILES);
}
mysqli_stmt_close($stmt1);
}
}
else {
    $sql3 = "INSERT into fileup(username,title,image) VALUES('".$_SESSION["name"]."','$title','$pname')";
 //UPDATE users SET avatarimg='1' 
    if(mysqli_query($link,$sql3)){
 unset($_FILES);
    //echo "File Sucessfully uploaded";
    
    }
    else{
        echo "Error";
    }
  }
  header("location:profile.php");
    exit();
}
mysqli_stmt_close($stmt);}

}

 
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name = "viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="css/style.css">
    <title>Форум</title>
    
</head>
<body>
<nav class="col-lg-12 navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar">
      <a class="navbar-brand" href="#">Forum</a>
    </div>
   <ul class="nav navbar-nav">
      <li><a class="btn" href="index.php">Главная</a></li>
      <li><a class="btn" href="quests.php">Вопросы</a></li>
      <?
      if(isset($_SESSION['name'])) echo "<li><a class='btn active' href='profile.php'>Профиль<sup>(".$_SESSION['name'].")</sup></a></li>
      ";?>
      <? if($_SESSION['role']=="supadmin"){echo "
      <li><a class='btn' href='admin.php'>Администраторы</a></li>";}?>
      <? if(!$_SESSION['name']){
        echo "
      <li><a class='btn' href='login.php'>Войти</a></li>
      <li><a class='btn' href='sign.php'>Регистрация</a></li>";}?>
      <? if($_SESSION['name']){
        echo "
      <li><a class='btn' href='login.php'>Выйти</a></li>";}?>
    </ul>  </div>
</nav>
    

<div class="content col-lg-12">
   <table class="table">
     <tr>
       <td colspan="3">
         <p>
    
    <?if($name == $_SESSION['name'])echo "Мой профиль"; else echo "Профиль:";?>

     

    <div class="alert alert-info">
      <?
      echo "Имя: <em style='color:#26ac1b;'>".$name."</em>\n";
      echo "Статус: <em style='color:#26ac1b;'>".$role."</em>\n";
   
 $sql = "SELECT u.username,u.email,u.role,q.theme,q.question,q.comcount from users u, quests q where u.username = q.username AND u.username=?";
        if($stmt1 = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt1, "s", $param_name);
            $param_name = $name;
        if(mysqli_stmt_execute($stmt1)){
          $result = mysqli_stmt_get_result($stmt1);
         if(mysqli_num_rows($result) > 0){
          echo "<div class='panel  panel-heading' >Вопросы:</div>";
                    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                    echo "<div class='panel panel-footer'>".$row['theme']."(Комментарии: ".$row['comcount'].")</div>";
                                     }
              }
            else{
                echo "Нет вопросов.";
            }
        }
        else {
          echo "Что то пошло не так.";
        }
      
mysqli_stmt_close($stmt1);
}

      
      ?>

</div>
   </p>
       </td><td>
        <form action = "" id="profileform" style="display:none;
  background-color: #cee7f4;"class="form-popup" class="panel panel-default" method="post" enctype="multipart/form-data">
                                        <label>Title</label>
                                        <input type="text" name="filetitle">
                                        <label>File Upload</label>
                                        <input type="File" name="file">
                                        <button type="button" id="profilebtn" onclick='closeForm()'>Закрыть</button>
                                        <input type="submit" name="submit1">
                                              </form>
             <script type="text/javascript">
              function openForm() {
                    document.getElementById('profileform').style.display = "table";
                  }

              function closeForm() {
                    document.getElementById('profileform').style.display = "none";
                  }
            
            </script>
           
        <?
 $sql1 = "SELECT * FROM fileup where username = '".$name."'";
                    if($result1 = mysqli_query($link, $sql1)){
                      if(mysqli_num_rows($result1) > 0) {
                          while($row = mysqli_fetch_array($result1, MYSQLI_ASSOC)){
                                    if($name == $_SESSION['name']){
                                      echo "<button type='button' id='profilebtn' onclick='openForm()'>Добавить фотографию</button>";
                                    }
                                    //<button type='button' id='profilebtn' onclick='openForm()'>Добавить фотографию</button>
                                         echo "
                                         <div class='panel panel-default'>
                                       <div>".$row['title']."</div>
                                       <img width='250px' class='thumbnail' style='margin: 7px 0 7px 7px;' src='profileimg/".$row['image']."'>
                                       </div>";
                                       
                                     
                                   }
                                 }
                                 elseif(mysqli_num_rows($result1) < 1 && $name == $_SESSION['name']){
                                  echo '<button type="button" id="profilebtn" onclick="openForm()">Добавить фотографию</button>';
                                 }
                                

                            // Free result set
                            mysqli_free_result($result1);
                         
                    } 

mysqli_close($link);
 
 ?>
 </td>
     </tr>
     
   </table>
   

    

<br><br><br>
<br><br><br>
<br><br><br>
</div>
        <footer class="col-lg-12 navbar-inverse">
           
               <hr>
                <p class="pull-left" style="color: white;">АУЭС © 2020</p>
                <p class="pull-right" style="color: white;">Наши контакты: +77473812507</p>
               
        
        </footer>

</body>
</html>

