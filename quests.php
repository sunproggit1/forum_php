<?php
session_start();
require_once "config.php";
$theme = $question = "";
$name = $_SESSION['name'];
if(isset($_POST['question']) && !empty($_POST['question'])){
$theme = trim($_POST["theme"]);
$question = trim($_POST['question']);
unset($_SESSION['question']);
$_SESSION['question'] = $question;
       $sql = "INSERT INTO quests(username, theme, question, date) VALUES (?, ?, ?, CURRENT_TIME())";
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "sss", $param_name, $param_theme, $param_quest);
            
            $param_name = $name;
            $param_theme = $theme;
            $param_quest = $question;
            
            if(mysqli_stmt_execute($stmt)){
              unset($_SESSION['theme']);
              $_SESSION['theme'] = $theme;

              unset($_SESSION['question']);
              $_SESSION['question'] = $question;
                header("location: comment.php");
                exit();
            } else{
                echo "Ошибка.";
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
  <div class="col-lg-3 alert alert-info">
    Недавние вопросы
<?
                            
                                $sql1 = "SELECT * FROM quests ORDER BY id DESC LIMIT 10";
                    if($result1 = mysqli_query($link, $sql1)){
                        if(mysqli_num_rows($result1) > 0){
                            echo "<ul class='nav'><li >Вопросы:</li>";
                                while($row = mysqli_fetch_array($result1)){
                                             
                                        echo "<form action='comment.php' method='post'>
                                       <input type='text' hidden name='theme' value='".$row['theme']."'>
                                       <textarea hidden name='question'>".$row['question']."</textarea>
                                       <input type='submit' class='form-control' value='".$row['theme']."(".$row['comcount'].")'>
                                       </form>";


                                    
                                }
                                echo "</ul>";

                            // Free result set
                            mysqli_free_result($result1);
                        } 
                    } 

                    ?>
  </div>
  <div class="col-lg-6">
<?
                            
                                $sql1 = "SELECT * FROM quests";
                    if($result1 = mysqli_query($link, $sql1)){
                        if(mysqli_num_rows($result1) > 0){
                            echo "<ul class='nav table'><li >Вопросы:</li>";
                                    
                                while($row = mysqli_fetch_array($result1)){
                                    
                                         echo "<form action='comment.php' method='post'>
                                       <input type='text' hidden name='theme' value='".$row['theme']."'>
                                       <textarea hidden name='question'>".$row['question']."</textarea>
                                       <input type='submit' class='form-control' value='".$row['theme']."(".$row['comcount'].")'>
                                       </form>";


                                    
                                }
                                echo "</ul>";

                            // Free result set
                            mysqli_free_result($result1);
                        } 
                    } 

 mysqli_close($link);
                    ?>


<br><br><br>
<br><br><br>
<br><br><br>

  </div>
  <div class="col-lg-3">
    <form action="quests.php" method="post">
                      <input type="text" name="name" hidden value="<? echo $_SESSION['name'];?>">
                      <input type="text" name="theme" class="form-control" placeholder="Ваш вопрос">
                      <textarea name="question" class="form-control" placeholder="Ваш комментарий"></textarea>
                      <input type="submit" name="submit" class="btn btn-primary pull-right">
                    </form>
  </div>
</div>
        <footer class="col-lg-12 navbar-inverse">
           
               <hr>
                <p class="pull-left" style="color: white;">АУЭС © 2020</p>
                <p class="pull-right" style="color: white;">Наши контакты: +77473812507</p>
               
        
        </footer>
</body>
</html>