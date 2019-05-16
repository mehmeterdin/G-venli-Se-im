
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
<?php
$toplam1 = 0;
		$toplam2 = 0;
		$toplam3 = 0;

		$query="SELECT cc1 from sonuc";
        $cc1=$baglanti->query($query);
        
        foreach ($cc1 as $key => $value) {
        	$toplam1 += $value['cc1'];
        }
		$scc1 =  $toplam1 % 524309;
		//Veri tabanından cc1 verileri alınıp hesi toplanıp bu değişkene atanacak. Verilen değer örnek amaçlı
		$query	="SELECT cc2 from sonuc";
		 $cc2=$baglanti->query($query);//Veri tabanından cc2 verileri alınıp hesi toplanıp bu değişkene atanacak. Verilen değer örnek amaçlı
		foreach ($cc2 as $key => $value) {
        	$toplam2 += $value['cc2'];
        }
		$scc2 =  $toplam2 % 524309;
		$query="SELECT cc3  from sonuc";
		 $cc3=$baglanti->query($query);//Veri tabanından cc3 verileri alınıp hesi toplanıp bu değişkene atanacak. Verilen değer örnek amaçlı
		foreach ($cc3 as $key => $value) {
        	$toplam3 += $value['cc3'];
        }
        $scc3 =  $toplam3 % 524309;
        
        echo "Gizli Değer 1 : $scc1 </br>";
        echo "Gizli Değer 2 : $scc2 </br>";
        echo "Gizli Değer 3 : $scc3 </br>";
?>
</body>
</html>