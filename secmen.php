
<!DOCTYPE html>
 <html>
<body>
<?php
require_once("veritabanibaglantisi.php");

if(!isset($_SESSION)) {
       session_start();
}     
if(!isset($_SESSION['secmen_id']))
    {
        header("location:login.php");
    }


    $secmen=$_SESSION['secmen_id'];
    //$tc=$_SESSION['tc'];

    $secmenigetir="SELECT *FROM secmen where secmen_id='$secmen'";
    $secmenibul=$baglanti->query($secmenigetir);
    ?>
   
    <?php
	 foreach ($secmenibul as $key => $value) {
 	?>
 	<form>
 		<table>
            <p><h3>SEÇMENE AİT BİLGİLER</h3></p>
 		    <p><b>Seçmen Tc Kimlik Numarası:</b><?php echo $_SESSION['tc'];?></p>
 	 		<p><b>Seçmen Adı:</b><?php echo $value['ad'];?></p>
 	 		<p><b>Seçmen Soyadı:</b><?php echo $value['soyad'];?></p>
 	 		<p><b>Telefon:</b><?php echo $value['telefon'];?></p>
 	 		<p><b>Seçmenin Adresi:</b><?php echo $value['adres'];?></p>
        </table>
     </form>
 <?php
}
 ?>
</body>
</html>
    
