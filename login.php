<?php
session_start();
require_once "config.php";
session_unset();
$name = $pass = "";
$name_err = $pass_err = "";
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Имя:";
    } else{
        $name = $input_name;
    }
    $input_pass = trim($_POST["pass"]);
    if(empty($input_pass)){
        $pass_err = "Пароль:";
    } else{
        $pass = md5($input_pass);
    }    
    
    
        $sql = "SELECT * from users where username=? and password=(SELECT MD5(?))";
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "ss", $param_name, $param_pass);
            $param_name = $name;
            $param_pass = $input_pass;
        if(mysqli_stmt_execute($stmt)){
          $result = mysqli_stmt_get_result($stmt);
         if(mysqli_num_rows($result) == 1){
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    $email = $row["email"];
                    $role = $row["role"];
                    session_unset();
                    $_SESSION['name'] = $name;
                    $_SESSION['pass'] = $pass;
                    $_SESSION['email'] = $email; 
                    $_SESSION['role'] = $role; 
            header('location: index.php');
                exit();
              }
            else{
                echo "Неверное имя или пароль.";
            }
        }
        else {
          echo "Что то пошло не так.";
        }
      
mysqli_stmt_close($stmt);
}

mysqli_close($link);}
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
<nav class="navbar navbar-inverse col-lg-12">
  <div class="container-fluid">
    <div class="navbar">
      <a class="navbar-brand" href="#">Forum</a>
    </div>
    <ul class="nav navbar-nav">
      <li><a class="btn" href="index.php">Главная</a></li>
      <li><a class="btn" href="quests.php">Вопросы</a></li>
      <?if(isset($_SESSION['name'])) echo "<li><a class='btn' href='profile.php'>Профиль<sup>(".$_SESSION['name'].")</sup></a></li>";?>
      <? if($_SESSION['role']=="supadmin"){echo "

      <li><a class='btn' href='admin.php'>Администраторы</a></li>";}?>
      <? if(!$_SESSION['name']){
        echo "
      <li><a class='btn active' href='login.php'>Войти</a></li>
      <li><a class='btn' href='sign.php'>Регистрация</a></li>";}?>
      <? if($_SESSION['name']){
        echo "
      <li><a class='btn' href='login.php'>Выйти</a></li>";}?>
    </ul>
  </div>
</nav>
    

<div class="content col-lg-12">

<br><br><br>
 <form action="" method="post">
<input type="text" name="name" placeholder="Имя"><hr>
<input type="password" name="pass" placeholder="Пароль"><hr>
<input type="submit" value="Войти">
</form>

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