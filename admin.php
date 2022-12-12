<?php
session_start();
require_once "config.php";
$name = "";
//print_r($_POST);
if(isset($_POST['upgrade']) && isset($_POST['name'])){
  $name = trim($_POST['name']);
if($_POST['upgrade']=="Повысить"){
        $sql = "UPDATE users SET role = 'admin' where username = ?";
        if($stmt = mysqli_prepare($link, $sql)){
          mysqli_stmt_bind_param($stmt, "s", $param_username);
            $param_username = $name;

        if(mysqli_stmt_execute($stmt)){
            header("location: admin.php");
            exit();
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
     mysqli_stmt_close($stmt); 
    }
    
}
elseif($_POST['upgrade']=="Понизить"){

$sql1 = "UPDATE users SET role = 'user' where username = ?";
        if($stmt1 = mysqli_prepare($link, $sql1)){
          mysqli_stmt_bind_param($stmt1, "s", $param_username);
            $param_username = $name;

        if(mysqli_stmt_execute($stmt1)){
            header("location: admin.php");
            exit();
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
     mysqli_stmt_close($stmt1); 
    }
}
}


?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name = "viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
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
      <?if(isset($_SESSION['name'])) echo "<li><a class='btn' href='profile.php'>Профиль<sup>(".$_SESSION['name'].")</sup></a></li>";?>
<?if($_SESSION['role']=="supadmin"){echo "

      <li><a class='btn active' href='admin.php'>Администраторы</a></li>";}?>
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
                            
                                $sql= "SELECT id,username,role FROM users where role = 'admin'";
                    if($result = mysqli_query($link, $sql)){
                        if(mysqli_num_rows($result) > 0){
                            echo "<ul class='nav'><li >Админы:</li>";
                                    
                                while($row = mysqli_fetch_array($result)){
                                    
                                       echo "<li><a class='btn' href='profile.php?id=". $row['id']; echo "' title='View Record' >".$row['username']." <span>".$row['role']."</span> </a></li>";

                                    
                                }
                                echo "</ul> <hr><hr>";

                            // Free result set
                            mysqli_free_result($result);
                        } 
                    }
                     $sql1 = "SELECT id,username,role FROM users";
                    if($result1 = mysqli_query($link, $sql1)){
                        if(mysqli_num_rows($result1) > 0){
                            echo "<table border='solid' class='table nav'><li >Пользователи:</li>";
                                    
                                while($row = mysqli_fetch_array($result1)){
                                  
                                    if($row['username']!="creator"){
                                       echo "<tr><td><a class='btn' href='profile.php?id=". $row['id']; echo "'  >".$row['username']." </a></td><td><span> Роль:".$row['role']."</span></td>";
                                       
                                        echo "<form action='admin.php' method='post'><td>
                                       <input type='text' name='name'  hidden value=".$row['username'].">";
                                       if($row['role']=="user"){
                                        echo "
                                       <input type='submit' name='upgrade' value='Повысить' >";
                                       } elseif($row['role']=="admin"){
                                        echo "
                                       <input type='submit' name='upgrade' value='Понизить'>";
                                       }
                                        echo "</td></form></tr>";
                                     
                                   } 
                                }
                                echo "</table> <hr><hr>";

                            // Free result set
                            mysqli_free_result($result1);
                        } 
                    }

 mysqli_close($link);
                    ?> 



  </div>
  <div class="col-lg-3">
    fdgh
  </div>
</div>
        <footer class="col-lg-12 navbar-inverse fixed-bottom">
           
               <hr>
                <p class="pull-left" style="color: white;">АУЭС © 2020</p>
                <p class="pull-right" style="color: white;">Наши контакты: +77473812507</p>
               
        
        </footer>
</body>
</html>