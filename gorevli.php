<?php
date_default_timezone_set('Europe/Istanbul');
if(!isset($_SESSION)) {
       session_start();
}     
if(!isset($_SESSION['secmen_id']))
    {
        header("location:login.php");
    }
      require_once("veritabanibaglantisi.php");
    
?>
<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="css/mainstyle2.css">
  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>  
  <script type="text/javascript" src="js/musteri.js"></script>
  <script type="text/javascript" src="js/kullaniciadikontrol.js"></script>
  <script type="text/javascript" src="js/sifrekontrol.js"></script>
</head>
<body>
  
  <b><?php echo"E_seçime Hoşgeldiniz!" ?></b><br/>
  <b><?php echo $_SESSION['secmen_adi'];?></b>
  <b><?php echo $_SESSION['secmen_soyadi'];?></b><br/><br/>
  <b class="bcolor"><?php echo date('Y.m.d H:i:s');?></b>

<ul>
    <li><a href="gorevli.php?link=1">Anasayfa</a></li>
    <li><a href="gorevli.php?link=5">Sonuçlar</a></li>
    <li><a href="gorevli.php?link=6">Güvenli Çıkış</a></li>

</ul>
      <div class="arkaplan">
<?php
        if(isset($_REQUEST['link'])){
           $link=$_REQUEST['link'];
 }
         else
         {
            $link=0;
              }
    switch($link){
    case 1 :
    include("gorevliilk.php");
    break;
    case 5 :include("sonuc.php");
    break;
    case 6 :include("logout.php");
    break;
    default:
                    }
    $zaman=date('Y/m/d');

    ?>

    </div>
  </body>
  </html>
