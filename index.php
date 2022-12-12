<?php
session_start();
require_once "config.php";
print_r($_SESSION);
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
      <a class="navbar-brand" href="index.php">Forum</a>
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
                    mysqli_close($link); 

                    ?>
  </div>
  <div class="col-lg-6">
    <audio id="myAudio" >
  <source src="audio/G2.mid" type="audio/midi">
  Your browser does not support the audio tag.
</audio>
  <button onclick="playAudio()">play</button>
  <button onclick="pauseAudio()">pause</button>
<script>
  var x = document.getElementById("myAudio");

function playAudio() {
  x.play();
}

function pauseAudio() {
  x.pause();
}
 /* 
  scene = new THREE.scene();
  camera = new THREE.PerspectiveCamera(45, window.innerWidth, window.innerHeight, 0.1, 1000);
  camera.position.z = 10;

  renderer = new THREE.WebGLRenderer({alpha: true, antialias: true});
  renderer.setSize(1280, 720);

  renderer.domElement.setAttribute("id", "Fridgeobj");
  document.body.insertBefore(renderer.domElement, document.body.firstChild);

  const aLight = new THREE.AmbientLight(0x404040, 1.2);
  scene.add(aLight);
  const pLight = new THREE.AmbientLight(0xFFFFFF, 1.2);
  pLight.position.set(0, -3, 7);
  scene.add(pLight); 

  const helper = new THREE.PointLightHelper(pLight);
  scene.add(helper);

  let loader = new THREE.GLTFLoader();
  let obj = null;

  loader.load("/images/fridge.skp", function(gltf){
  obg = gltf;
  obj.scene.scale.set(1.3, 1.3, 1.3);
  scene.add(obj.scene);
});

function animate() {
  requestAnimationFrame(animate);

  if(obj)
    obj.scene.rotation.y+=0.03;

  renderer.render(scene, camera);
}
animate();*/
</script>

<p>Правила форума, указанные ниже, обязательны для выполнения всеми участниками форума без исключений. <br>
Правила отдельных форумов являются дополнениями к общим правилам форума. <br>
Администрация оставляет за собой право изменять правила без уведомления. <br>
Дополнения и изменения правил начинают действовать с момента их опубликования. <br></p>
<blockquote> Регистрация:</blockquote>  
<p>Запрещается использовать для отображения на форумах имена (логин, имя), подписи содержащие нецензурную лексику, адреса веб-сайтов, e-mail и т.п.</p>
<blockquote> Запрещено:</blockquote>  
<ul>
   <li>Публиковать заведомо ложнyю инфоpмацию.</li>
   <li>Использовать мат и/или грубые выражения (в том числе в замаскированной форме).</li>
   <li>Оскорблять кого-либо в прямой или косвенной форме, высказывать неуважение и/или хамить участникам форума.</li>
   <li>Рекламировать в сообщениях, подписях или аватарах любые товары и услуги без специального разрешения администрации форума.</li>
   <li>Создавать одинаковые темы или сообщения в разных форумах.</li>
   <li>Создавать темы с вопросами, ответы на которые даны в теме FAQ.</li>
   <li>Создавать новые темы с названиями, не отражающими суть проблемы или вопроса.</li>
   <li>Вести разговор на "вольные темы" (флеймить), создавать темы, не соответствующие данному форуму, или отсылать сообщения, не соответствующие обсуждаемой теме (оффтопик).</li>
   <li>Публиковать ссылки на нелицензионное коммерческое програмное обеспечение (варез), программы для его взлома (краки) и генераторы ключей, а также на материалы, защищённые авторскими правами (книги, музыка, видео и прочее).</li>
   <li>Создавать сообщения, не несущие конкретной смысловой нагрузки в контексте обсуждаемой темы (флуд).</li>
   <li>Создавать сообщения, содержащие "аффтарскую" речь, специально сделанные ошибки; злостно несоблюдать правила русского языка.</li>
   <li>Создавать в подписях ссылки на сайты, не отвечающие тематике форума.</li>
   <li>Cоздавать сообщения ЗАГЛАВНЫМИ или заглавными и прописными буквами вперемешку ("вОт ТаКиМ оБрАзОм"), излишнее выделение текста в целях привлечения внимания полужирным шрифтом, курсивом, подчёркиванием, отличным от стандартного для сообщений форума цветом, шрифтом, размером шрифта.</li>
   <li>Самовольное модерирование. Т.е. когда некий участник форума, не являющийся модератором данного форума, делает замечания другим участникам.</li>
   <li>Обсуждать наказания, сделанные модератором или администратором.</li>
</ul>
  </div>
  <div class="col-lg-3">
    

  </div>
</div>
        <footer class="col-lg-12 navbar-inverse fixed-bottom">
           
               <hr>
                <p class="pull-left" style="color: white;">АУЭС © 2020</p>
                <p class="pull-right" style="color: white;">Наши контакты: +77473812507</p>
               
        
        </footer>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r123/three.min.js"></script>

        <script src="https://cdnjs.rawgit.com/mrdoob/three.js/master/examples/js/loaders/GLTFLoader.js"></script>
</body>
</html>