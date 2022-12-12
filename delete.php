<?php
session_start();
require_once "config.php";

$id = 0;
$theme = $_SESSION['theme'];
$name = $_SESSION['name'];
$delete = '<em>Этот комментарий был удален.</em>';
if(isset($_POST['id'])){
  $id = intval(trim(($_POST["id"])));
    if($stmt1 = mysqli_prepare($link, "SELECT comment from comments where id='$id'")){ 
      if(mysqli_stmt_execute($stmt1)){
        $result= mysqli_stmt_get_result($stmt1);
        if(mysqli_num_rows($result) > 0){
          $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
          if($row['comment'] != "$delete"){

     $sql = "UPDATE comments SET comment = '$delete' WHERE id = ?";
   
    
    if($stmt2 = mysqli_prepare($link, $sql)){
        mysqli_stmt_bind_param($stmt2, "i", $param_id);
        
        $param_id = $id;
        
        if(mysqli_stmt_execute($stmt2)){
          
            header("location: comment.php");
            exit();
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
        mysqli_stmt_close($stmt2);
      
      }
    }
    else {
      $sql2 = "DELETE FROM comments WHERE id = ?";
       
    if($stmt = mysqli_prepare($link, $sql2)){
        mysqli_stmt_bind_param($stmt, "i", $param_id);
        
        $param_id = $id;
        
        if(mysqli_stmt_execute($stmt)){
          $sql1="UPDATE quests set comcount = (SELECT COUNT(*) as count from comments where theme='$theme') where theme='$theme'";
          if($stmt3 = mysqli_prepare($link, $sql1)){
            if(mysqli_stmt_execute($stmt3)){}
              else {
                echo "Something wrong!";
              }
              mysqli_stmt_close($stmt3);
          }
 
          header("location: comment.php");
            exit();
        }
      }
          }
        }
      }
      mysqli_stmt_close($stmt1);
    }   
}
elseif (isset($_GET['id'])) {
   $id = trim(($_GET["id"]));
   unset($_SESSION['delete']);
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
      <li><a class="btn" href="index.php">Главная</a></li>
      <li><a class="btn active" href="quests.php">Вопросы</a></li>
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

<form class="table" action="delete.php" method="post">
                            <input type="text" hidden name="id" value="<?php echo $id; ?>"/>
                            <p>Удалить?</p><br>
                            <p>
                                <input type="submit" value="Да" class="btn btn-danger">
                                <a href="comment.php" class="btn btn-default">Нет</a>
                            </p>
                       
                    </form>

</div>
        <footer class="col-lg-12 navbar-inverse">
           
               <hr>
                <p class="pull-left" style="color: white;">АУЭС © 2020</p>
                <p class="pull-right" style="color: white;">Наши контакты: +77473812507</p>
               
        
        </footer>
</body>
</html>