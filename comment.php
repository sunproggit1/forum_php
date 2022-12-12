<?php
session_start();
require_once "config.php";
$comment = $question = "";
//print_r($_SESSION);
$count = 0;
if(isset($_POST['theme'])){ 
$theme = $_POST['theme'];
unset($_SESSION['theme']);
$_SESSION['theme'] = $_POST['theme'];

unset($_SESSION['question']);
$_SESSION['question'] = $_POST['question'];
}

$theme = $_SESSION['theme'];
$name = $_SESSION['name'];
$question = $_SESSION['question'];


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
  <div class="col-lg-3 col-md-offset alert alert-info">
    Недавние вопросы: <br> 
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
             <blockquote><q>Тема: <? echo $theme;?></q></blockquote>
              <br>
              <blockquote> <? echo $question;?></blockquote>
              <br><br><br>
                  <div >

                    <?
   if($_SESSION['name']) echo '
   <form method="POST" id="comment_form" enctype="multipart/form-data">
    <div class="form-group">
     <input type="text" hidden name="comment_name" id="comment_name" value="'.$_SESSION['name'].'"/>  
     <textarea name="comment_content" id="comment_content" class="form-control" placeholder="Ввести комментарий" rows="5"></textarea>
     <input type="text" hidden name="theme" id="theme" value="'.$_SESSION['theme'].'">
    </div>
    <div class="form-group">
     <input type="hidden" name="comment_id" id="comment_id" value="0" />
     <input type="submit" name="submit" id="submit" class="btn btn-info" value="Submit" />
    </div>
   </form>';

?>
   <span id="comment_message"></span>
   <br />
   <div id="display_comment"></div>
  </div>
<br><br><br>


<script>

$(document).ready(function(){
 
 $('#comment_form').on('submit', function(event){
  event.preventDefault();
  var form_data = $(this).serialize();
  $.ajax({
   url:"create.php",
   method:"POST",
   data:form_data,
   dataType:"JSON",
   success:function(data)
   {
    if(data.error != '')
    {
     $('#comment_form')[0].reset();
     $('#comment_message').html(data.error);
     $('#comment_id').val('0');
     
     load_comment();
    }
   }
  })
 });
 load_comment();

 function load_comment()
 {
  $.ajax({
   url:"fetch_comment.php",
   method:"POST",
   success:function(data)
   {
    $('#display_comment').html(data);
   }
  })
 }
 $(document).on('click', '.reply', function(){
  var comment_id = $(this).attr("id");
  $('#comment_id').val(comment_id);
  $('#comment_name').focus();
 });
 
 let timer = setInterval(6000, load_comment);
});
</script>


  </div>
  <div class="col-lg-3 col-md-offset">
   
  </div>
</div>
        <footer class="col-lg-12 navbar-inverse">
           
               <hr>
                <p class="pull-left" style="color: white;">АУЭС © 2020</p>
                <p class="pull-right" style="color: white;">Наши контакты: +77473812507</p>
               
        
        </footer>
        <?
 mysqli_close($link);
 ?>
</body>
</html>