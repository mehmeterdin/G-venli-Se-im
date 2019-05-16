<?php
date_default_timezone_set('Europe/Istanbul');
if(!isset($_SESSION)) {
       session_start();
}
?>
<!DOCTYPE html>
<html>
<head>
	  <link rel="stylesheet" href="css/login.css">
</head>
<body>  
   <b class="date"><?php echo date('d.m.Y H:i:s');?></b> 
    <div id="fotograflogin">
        <div id="img">
            <img class="img" src="img/images2.jpg">
        </div>
        </div>
	<form action="login.php" method="post" id="formlogin">
    
<p><h2>E-SEÇİME HOŞGELDİNİZ!</h2></p>
<p>
	<input class="input100" type="text" name="tckimlik" placeholder="tc kimlik no" required="required">
<!--<input class="input100" type="password" name="ksifre" placeholder="şifre" required="required">-->
</p>
<p><h4><button name="girisbtn" class="button">GİRİŞ YAP</button></h4></p>
<p><a href="ekle.php" class="button">EKLE</a></p>
  
</form>
<?php require_once("veritabanibaglantisi.php");?>
	<?php
if(isset($_POST["girisbtn"]))
{
    $tc=$_REQUEST["tckimlik"];

    $ozettc=hash('sha256',$tc);
    $sorgu1="select * from secmen where tc='$ozettc'";
    $sorgu2="select * from gorevli where tc='$tc'";

    $sorgucalistir=$baglanti->query($sorgu1);
    $sorgucalistir2=$baglanti->query($sorgu2);
    
    $toplam = $sorgucalistir->rowCount();
    $toplam2 = $sorgucalistir2->rowCount();
    if($sorgucalistir==true  and $toplam==1)
    {
    	foreach ($sorgucalistir as $key => $value) {
             	$secmen_id=$value['secmen_id'];
             	$secmen_adi=$value['ad'];
             	$secmen_soyadi=$value['soyad'];
        }
        			$_SESSION['tc']=$tc;
                    $_SESSION['secmen_id']=$secmen_id;
        			$_SESSION['secmen_adi']=$secmen_adi;
        			$_SESSION['secmen_soyadi']=$secmen_soyadi;
        			$_SESSION['secmen_ip']=$_SERVER['REMOTE_ADDR'];
        			$_SESSION['sisttarih']=date("d.m.Y");
        			$_SESSION['sistsaat']=date("H:i:s");
        				header("location:mainpage.php");
    }
    else if($sorgucalistir2==true  and $toplam2==1)
    {
        foreach ($sorgucalistir2 as $key => $value) 
        {
            $gorevli_id=$value['gorevli_id'];
            $ad=$value['ad'];
            $soyad=$value['soyad'];
        }
        $_SESSION['tc']=$tc;
        $_SESSION['secmen_id']=$gorevli_id;
        $_SESSION['secmen_adi']=$ad;
        $_SESSION['secmen_soyadi']=$soyad;
        header("location:gorevli.php");
    }
    else
    {
 	    echo "<h4>Böyle bir tc kimlik numarası sistemde kayıtlı değildir.<br/> Lütfen tekrar deneyiniz!</h4>";
    }
 
}

?>
</body>
</html>