<?php
session_start();
require_once "config.php";
$id = $comment = "";

$theme = $_SESSION['theme'];
$name = $_SESSION['name'];
if(isset($_GET['id'])){
    $id = trim(intval($_GET['id']));
    $sql = "SELECT * from comments where id=?";
     if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "i", $param_id);
            
            $param_id = $id;
            
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);
    
                if(mysqli_num_rows($result) == 1){
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    $comment = $row["comment"];
                    $_SESSION['comment'] = $row['comment'];
                } 
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        mysqli_stmt_close($stmt);
        }
}
elseif(isset($_POST['comment']) && !empty($_POST['comment'])){
$id = trim($_POST['id']);
$comment = trim($_POST["comment"]);


       $sql = "UPDATE comments SET comment = ?  where id=?";
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "si", $param_comm, $param_id);

            $param_comm = $comment;
            $param_id = $id;

            if(mysqli_stmt_execute($stmt)){
             
             header('location: comment.php');
             exit();
            } else{
                echo "Ошибка.";
            }
        mysqli_stmt_close($stmt);}
        
} 
mysqli_close($link);
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
      <li><a class="btn active" href="index.php">Главная</a></li>
      <li><a class="btn" href="quests.php">Вопросы</a></li>
      <?if(isset($_SESSION['name'])) echo "<li><a class='btn' href='profile.php'>Профиль<sup>(".$_SESSION['name'].")</sup></a></li>";?>
      <? if($_SESSION['role']=="supadmin"){echo "

      <li><a class='btn' href='admin.php'>Администраторы</a></li>";}?>
      <? if(!$_SESSION['name']){
        echo "
      <li><a class='btn' href='login.php'>Войти</a></li>
      <li><a class='btn' href='sign.php'>Регистрация</a></li>";}?>
      <? if($_SESSION['name']){
        echo "
      <li><a class='btn' href='login.php'>Выйти</a></li>";}?>
    </ul>
  </div>
</nav>
    

<div class="content col-lg-12">


 <form class="table" action="update.php" method="post">

                      <input type="text" name="id" hidden value="<? echo $id;?>">
                      <textarea name="comment" class="form-control" ><? echo $_SESSION['comment'];?></textarea>
                      <input type="submit" name="submit" value="submit" class="btn btn-primary pull-right">
                    </form>

</div>
        <footer class="col-lg-12 navbar-inverse">
           
               <hr>
                <p class="pull-left" style="color: white;">АУЭС © 2020</p>
                <p class="pull-right" style="color: white;">Наши контакты: +77473812507</p>
               
        
        </footer>
</body>
</html>