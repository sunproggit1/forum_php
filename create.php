<?php
session_start();
//require_once "config.php";


$connect = new PDO('mysql:host=127.0.0.1;dbname=forum', 'root', '');
/*
$comment = "";
//print_r($_SESSION);
$count = 0;

$theme = $_SESSION['theme'];
$name = $_SESSION['name'];
if(isset($_POST['comment']) && !empty($_POST['comment'])){

$comment = trim($_POST["comment"]);

$theme = trim($_POST["theme"]);
$name = trim($_POST["name"]);

       $sql = "INSERT INTO comments(theme, username, comment) VALUES (?, ?, ?)";
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "sss", $param_theme, $param_name, $param_comm);
            
            $param_theme = $theme;
            $param_name = $name;
            $param_comm = $comment;

            if(mysqli_stmt_execute($stmt)){
             $sql1 = "UPDATE quests set comcount = (SELECT COUNT(*) as count from comments where theme=?) where theme=?";
        if($stmt1 = mysqli_prepare($link, $sql1)){
            mysqli_stmt_bind_param($stmt1, "ss", $param1_theme, $param2_theme);
            $param1_theme = $theme;
            $param2_theme = $theme;
            if(mysqli_stmt_execute($stmt1)){
            } else{
                echo "Ошибка.";
            }
        mysqli_stmt_close($stmt1);}
                header("location: comment.php");
                exit();
            } else{
                echo "Ошибка.";
            }
        mysqli_stmt_close($stmt);}
        
} */

$error = '';
$comment_name = '';
$comment_content = '';
$theme = '';

if(empty($_POST["comment_name"]))
{
 $error .= '<p class="text-danger">Name is required</p>';
}
else
{
 $comment_name = $_POST["comment_name"];
}

if(empty($_POST["theme"]))
{
 $error .= '<p class="text-danger">Theme is required</p>';
}
else
{
 $theme = $_POST["theme"];
}

if(empty($_POST["comment_content"]))
{
 $error .= '<p class="text-danger">Comment is required</p>';
}
else
{
 $comment_content = $_POST["comment_content"];
}


if($error == '')
{


 $query = "
 INSERT INTO comments 
 (parent_id, theme, username, comment) 
 VALUES (:parent_id, :theme, :username, :comment)";

 /* $query2 = "
 UPDATE  comments  SET parent_id=(:parent_id), theme=(:theme), username=(:username), comment=(:comment)";*/
 
 $statement = $connect->prepare($query);
 $statement->execute(
  array(
   ':parent_id' => $_POST["comment_id"],
   ':theme'    => $theme,
   ':username' => $comment_name,
   ':comment'    => $comment_content
  )
 );
    $query1="UPDATE quests set comcount = (SELECT COUNT(*) as count from comments where theme='$theme') where theme='$theme'";

$statement = $connect->prepare($query1);

$statement->execute();
 
 $error = '<label class="text-success">Comment Added</label>';
}

$data = array(
 'error'  => $error
);

echo json_encode($data);





?>
