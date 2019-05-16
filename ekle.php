<?php
require_once("veritabanibaglantisi.php");
?>
<!DOCTYPE html>
 <html>
<head>
	<link rel="stylesheet" type="text/css" href="css/login.css">
</head>
   <body background="red">
   		<p><a href="login.php" class="geri">GERİ</a></p>
   	<div id="fotografkaydet">
        <div id="img">
            <img class="img" src="img/images2.jpg">
        </div>
        </div>
   	<form id="formekle">
   		<p><h2>KAYIT SAYFASI</h2></p>
   		<table border="0">
		<tr>
	    	<td><label for="tc">TC kimlik no:</label></td>
	      	<td><input type="text" name="tc" required="required" ></td>
	    </tr>
		<tr>
	    	<td><label for="adi">Adı:</label></td>
	      	<td><input type="text" class="harf" name="secmen_ad" required="required" ></td>
	    </tr>
		<tr>
	    	<td><label for="soyadi">Soyadı:</label></td>
	      	<td><input type="text" class="harf" name="secmen_soyad" required="required" ></td>
	    </tr>
	    <tr>
	    	<td><label for="dogum">Doğum Tarihi:</label></td>
	      	<td><input type="date" name="secmen_dogum" required="required" ></td>
	    </tr>
		<tr>
	    	<td><label for="tel">Telefon no:</label></td>
	      	<td><input type="text"  name="secmen_tel" required="required" ></td>
	    </tr>
		<tr>
	    	<td><label for="adres">Adres:</label></td>
	      	<td><input type="text" class="harf" name="secmen_adres" required="required" ></td>
	    </tr>
	    <tr>
	    	<td><button class="button" name="scmkaydet">KAYDET</button></td>
	    </tr>
   		</table>

  
 <?php
if(isset($_REQUEST["scmkaydet"]))
{
	$tc=$_REQUEST["tc"];
	$ad=$_REQUEST["secmen_ad"];
	$soyad=$_REQUEST["secmen_soyad"];
	$dogum=$_REQUEST["secmen_dogum"];
	$tel=$_REQUEST["secmen_tel"];
	$adres=$_REQUEST["secmen_adres"];
	$oy=2;
	$tur="başbakanlık";
	$parti=2;
	$durum=1;

	     $ozettc=hash('sha256',$tc);
	$ekle="INSERT INTO secmen (tc,ad,soyad,dogum_tarih,telefon,adres,toplam_oy,secim_tur,oy_verilen_parti,kullanim_durumu)
						VALUES('$ozettc','$ad','$soyad','$dogum','$tel','$adres','$oy','$tur','$parti','$durum')";
		$sorgucalistir=$baglanti->query($ekle);
		if($sorgucalistir==true)
		{
		 echo "<h4>İşlem başarıyla gerçekleştirildi.</h4>";
		}
		else{
			echo "<h4>Kaydetme işlemi gerçekleştirilemedi.</h4>";
		}

}
 ?>
 </form>
  </body>
</html>
