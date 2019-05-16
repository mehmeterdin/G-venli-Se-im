
<!DOCTYPE html>
<html>
<head>
</head>

<?php
if(!isset($_SESSION)) {
       session_start();
}     
if(!isset($_SESSION['secmen_id']))
    {
        header("location:login.php");
    }

    ?>
<body>

	<p><b>BİLGİLENDİRME</b></p>
	<p>ELEKTRONİK SEÇİM SİSTEMİNE HOŞGELDİNİZ!</p>
	<p>LÜTFEN SİSTEME GİRİŞ YAPTIKTAN SONRA BİLGİLERİNİZİN DOĞRULUĞUNU <b>"SEÇMEN BİLGİLERİ"</b> KISMINDAN" KONTROL EDİNİZ!</p>
	<p><b>UYARI</b></p>
	<p>SADECE 1 OY KULLANMA HAKKINIZ VARDIR!</p>

</body>
</html>


