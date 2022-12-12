<?php
session_start();
require_once "config.php";

$name = $pass = $email = $role = "";
$name_err = $pass_err = $email_err = $role_err = "";
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
    $input_email = trim($_POST["email"]);
    if(empty($input_email)){
        $email_err = "Электронная Почта:";
    } else{
        $email = $input_email;
    }
    $input_role = trim($_POST["role"]);
    if(empty($input_role)){
        $role_err = "Имя:";
    } else{
        $role = $input_role;
    }
    
    
    if(empty($name_err) && empty($email_err) && empty($pass_err)){
$sql1 = "INSERT INTO users(username,password,email,role) values(?,(SELECT MD5(?)),?,'user')";
if($stmt1 = mysqli_prepare($link, $sql1)){
    mysqli_stmt_bind_param($stmt1, "sds", $param_name, $param_pass, $param_email);
            $param_name = $name;
            $param_pass = $input_pass;
            $param_email = $email;
            if(mysqli_stmt_execute($stmt1)){
              
              session_unset();
            $_SESSION['name']=$name;
            $_SESSION['pass']=$pass;
            $_SESSION['email']=$email;
            $_SESSION['role']=$role;
                header('location: index.php');
                exit();
            } else{
                echo "Ошибка.";
            }
        
        mysqli_stmt_close($stmt1);
        }
}
mysqli_close($link);
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
  <p></p>

<br><br><br>
 <form action="sign.php" method="POST">
<input type="text" placeholder="Имя" name="name" class="form-control"><hr>
<input type="password" placeholder="Пароль"name="pass" class="form-control"><hr>
<input type="text" placeholder="Почта" name="email" class="form-control"><hr>
<input type="text" hidden name="role" value="user">
<input type="submit" value="Тіркелу">
</form>


<br><br><br>
</div>
        <footer class="col-lg-12 navbar-inverse">
           
               <hr>
                <p class="pull-left" style="color: white;">АУЭС © 2020</p>
                <p class="pull-right" style="color: white;">Наши контакты: +77473812507</p>
               
        
        </footer>
</body>
</html>