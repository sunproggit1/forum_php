<?php
session_start();
//fetch_comment.php

$theme = $_SESSION['theme'];

$connect = new PDO('mysql:host=127.0.0.1;dbname=forum', 'root', '');

$query = "SELECT c1.id,c1.parent_id, c1.theme, c1.username, c1.comment, c1.date, u.id 
FROM comments c1, users u WHERE c1.theme = '$theme' AND c1.username = u.username AND c1.parent_id = '0' ORDER BY c1.id DESC";
/*
$query = "
SELECT * FROM comments
WHERE theme = '$theme' AND parent_id = '0' 
ORDER BY id DESC
";*/
$statement = $connect->prepare($query);

$statement->execute();

$result = $statement->fetchAll();
$output = '';
foreach($result as $row)
{

 $output .= '
 <div class="panel panel-default">
  <div class="panel-heading">By <b><a href="profile.php?id='.$row["6"].'">'.$row["username"].'</a></b> on <i>'.$row["date"].'</i></div>
  <div class="panel-body">'.strip_tags($row["comment"]).'</div>
  <div class="panel-footer" align="right">'; 

  if($_SESSION['role']=='supadmin' || ($_SESSION['role']=='admin' && $row['username']!='creator') || $_SESSION['name']==$row['username'] ){

    $output .='<a href="delete.php?id='.$row["0"].'" class="pull-right glyphicon glyphicon-remove"></a>';}
  
  if($_SESSION['name']==$row['username'] && $row["comment"]!="<em>Этот комментарий был удален.</em>"){
    $output .='<a href="update.php?id='.$row["0"].'" class="pull-right glyphicon glyphicon-pencil"></a>';}

    $output .='<button type="button" class="btn btn-default reply" id="'.$row["0"].'">Reply</button></div>
 </div>
 ';
 $output .= get_reply_comment($connect, $row["0"]);
}

echo $output;

function get_reply_comment($connect, $parent_id = 0, $marginleft = 0)
{
 $query = "
 SELECT * FROM comments WHERE parent_id = '".$parent_id."'
 ";
 $output = '';
 $statement = $connect->prepare($query);

 $statement->execute();
 $result = $statement->fetchAll();
 $count = $statement->rowCount();
 if($parent_id == 0)
 {
  $marginleft = 0;
 }
 else
 {
  $marginleft = $marginleft + 48;
 }
 if($count > 0)
 {
  foreach($result as $row)
  {

 $query1 = "
 SELECT id FROM users WHERE username = '".$row["username"]."'
 ";
 $output = '';
 $statement1 = $connect->prepare($query1);

 $statement1->execute();
 $result1 = $statement1->fetchAll();
 $count1 = $statement1->rowCount();
 if($count1 > 0){foreach($result1 as $row1)
  {$id = $row1['id'];}}
   $output .= '
   <div class="panel panel-default" style="margin-left:'.$marginleft.'px">
    <div class="panel-heading">By <b><a href="profile.php?id='.$id.'">'.$row["username"].'</a></b> on <i>'.$row["date"].'</i></div>
    <div class="panel-body">'.strip_tags($row["comment"]).'</div>
    <div class="panel-footer" align="right">'; 

  if($_SESSION['role']=='supadmin' || ($_SESSION['role']=='admin' && $row['username']!='creator') || $_SESSION['name']==$row['username'] ){
    $output .='<a href="delete.php?id='.$row["id"].'" class="pull-right glyphicon glyphicon-remove"></a>';}
  
  if($_SESSION['name']==$row['username'] && $row["comment"]!="<em>Этот комментарий был удален.</em>"){
    $output .='<a href="update.php?id='.$row["id"].'" class="pull-right glyphicon glyphicon-pencil"></a>';}

    $output .='<button type="button" class="btn btn-default reply" id="'.$row["id"].'">Reply</button></div>
   </div>
   ';
   $output .= get_reply_comment($connect, $row["id"], $marginleft);
  }
 }
 return $output;
}

?>
