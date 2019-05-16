
<!DOCTYPE html>
<html>
<head>
	  <link rel="stylesheet" href="css/aday.css">
	 
	  <link rel="stylesheet" href="css/login.css">
</head>

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
header('Content-type: text/html; charset=utf-8');
	require_once("veritabanibaglantisi.php");
	$listele_sorgu="SELECT * from aday";
	$listele=$baglanti->query($listele_sorgu);
	$toplam =$listele->rowCount();
	
		if($listele==true){
			?>
<form method="post">
			<?php	
					echo "<table  border='0'>";
			echo "<tr>";
			echo "<td><b><label>AD</label></b></td><td><b><label>SOYAD</label></b></td><td><b><label>PARTİ</label></b></td><td><b><label>SEÇİM</label></b></td>";
			echo"</tr>";

			   $i=1;
			   $aday[$i]="aday1";
				
		foreach ($listele as $key => $value){
              
			?>

			<?php
				echo "<tr>";
				echo "<td>".$value['aday_ad']."</td><td>".$value['aday_soyad']."&emsp; </td><td>".$value['aday_parti']."</td>";
                 
						 switch($i){
		    case 1 :
		    $aday[$i]="aday1";
		    break;
		    case 2 :
		    $aday[$i]="aday2";
		    break;
		    case 3 :
		   $aday[$i]="aday3";
		    break;
		    case 4 :
		     $aday[$i]="aday4";
		    break;
		    default:
		    case 0: $aday[$i]="";
		}
			        ?>
				 <td><p><input type=radio  name="aday"value=<?php echo $aday[$i]; ?>></p></td>
				 <?php
              // echo "<td>".$aday[$i]."</td>"; 
                   $i++;
			    echo "</tr>";
				}
               echo "</table>";
				?>
				<p><h4><button name="oy_kullan" class="icbutton">OY KULLAN</button></h4></p>

            <?php
}
   function intToBool($sayi,$sinir){
		$dizi = array();
		for ($i=0; $i < $sinir; $i++) { 
			$dizi[$i] = (($sayi >> $i) & 1);
		}
		$hazir = array_reverse($dizi);
		return $hazir;
	}
	function boolToInt($dizi,$sinir){
		$a = 0;
		for ($i=0; $i < $sinir; $i++) { 
			$a = ($a << 1) | bindec($dizi[$i]);
		}
		return $a;
	}
	function secmenCC($katsayix2,$katsayix,$index,$encodeVote){
		return (($katsayix2*$index*$index) + ($katsayix*$index) + $encodeVote) % 524309;
	}
		if(isset($_POST["oy_kullan"])){
              $secmen=$_SESSION['secmen_id'];

		if (empty( $_POST['aday']))
		{
			echo "<b>LÜTFEN DESTEKLEDİĞİNİZ ADAYI SEÇİNİZ!</b>";
		}
		else	
		{
	$adaykim=$_POST['aday'];
	if ($adaykim=="aday1"){
		oyKullan(1);
	}else
	if($adaykim=="aday2"){
      	oyKullan(2);
	}else
	if($adaykim=="aday3"){
       oyKullan(3);
	}else
	if($adaykim=="aday4"){
       oyKullan(4);
	}
	echo "<b>OYUNUZ ALINMIŞTIR.</br> KATILIMINIZ İÇİN TEŞEKKÜRLER!</b>";
}

}

function sonuclariAcikla(){
		if (-1 == q0()) {
			echo "Oy Kaçağı Tespit Edildi"; // hata yakalandı 
		}else{//hata yoksa sonuç açıklanıyor
			$kodlanmisOylamaSonucu = q0();
			$kodlanmisOylamaSonucuBool = intToBool($kodlanmisOylamaSonucu,20);
			for ($i=0; $i < 5; $i++) { 
				$aday1Bool[$i] = $kodlanmisOylamaSonucuBool[$i];		// adaylar ayrılıyor
				$aday2Bool[$i] = $kodlanmisOylamaSonucuBool[$i + 5];	// 5 er bitlik olarak
				$aday3Bool[$i] = $kodlanmisOylamaSonucuBool[$i + 10];	//
				$aday4Bool[$i] = $kodlanmisOylamaSonucuBool[$i + 15];
			}
			$aday1Sonuc = boolToInt($aday1Bool,5);
			$aday2Sonuc = boolToInt($aday2Bool,5);
			$aday3Sonuc = boolToInt($aday3Bool,5);
			$aday4Sonuc = boolToInt($aday4Bool,5);
		}
	}
function check($sayi){
		$tolerance = 1.e-6;
		if ($sayi < 0) {
			$sayi += 524309;
		}
		 if($sayi != (int)$sayi){// sayı ondalıklı mı kotrolü yapılıyor
			$kesir =  $sayi - (int)$sayi; // ondalıkk kısmı ayrılıyor
			$sayi = (int)$sayi;// tam kısmı ayrılıyor
		    // ondalık kısmı rasyonel yapma aşaması başlangıcı
		    $pay=1;
		    $h2=0;
		    $payda=0;
		    $k2=1;
		    $b = 1 / $kesir;
		    do {
		        $b = 1 / $b;
		        $a = floor($b);
		        $aux = $pay;
		        $pay = $a * $pay + $h2;
		        $h2 = $aux;
		        $aux = $payda;
		        $payda = $a * $payda + $k2;
		        $k2 = $aux;
		        $b = $b - $a;
		    } while (abs($kesir-$pay/$payda) > $kesir * $tolerance);
		    // ondalık parçanın rasyonelliği tamamlandı pay ve payda diğe değişkenlere sadeleştirilip yerleştirildi
		    do{
		    	$pay += 524309;// pay payda ya tam bölünene kadar 524309 ekleniyor
		    }while ($pay % $payda != 0);
		    $sayi = $sayi + ($pay/$payda); //tam kısım ve elde edilen rasyonel kısımdan gelen tam bölmeden gelen sayı toplanıyor
		    return $sayi % 524309;
		}else{
			return $sayi % 524309;	
		}
	}
function q0(){
header('Content-type: text/html; charset=utf-8');
$servername = "localhost";
$username = "mehmet";
$password = "123456";
$dbadi="voting";
 try{
    $baglanti = new PDO("mysql:host=$servername;dbname=$dbadi;charset=utf8", $username, $password);
    //set the PDO error mode to exception
    $baglanti->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
}
catch(PDOException $e)
{
    echo "Connection failed: " . $e->getMessage();
	}
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
		
		/*$q01 = ($scc1 * (2 / (2 - 1))) + ($scc2 * (1 / (1 - 2))) ;
		$q01 = check($q01);

		$q02 = ($scc1 * (3 / (3 - 1))) + ($scc3 * (1 / (1 - 3))) ;
		$q02 = check($q02);

		$q03 = ($scc2 * (3 / (3 - 2))) + ($scc3 * (2 / (2 - 3))) ;
		$q03 = check($q03);
		*/
		$q00 = ((((0-2)*(0-3))/((1-2)*(1-3)))*$scc1) + ((((0-1)*(0-3))/((2-1)*(2-3)))*$scc2) + ((((0-1)*(0-2))/((3-1)*(3-2)))*$scc3);
		$q00 = check($q00);
		return $q00;
		//if ($q01==$q02 && $q01 == $q03) {
		//	return $q01; // doğru sonuç dönüyor
		//}else{
		//	return -1; // hata olduğunu belli etmek amaçlı -1 döndürüyorum 
		//}
	}
	function oyKullan($aday){
header('Content-type: text/html; charset=utf-8');
$servername = "localhost";
$username = "mehmet";
$password = "123456";
$dbadi="voting";
 try{
    $baglanti = new PDO("mysql:host=$servername;dbname=$dbadi;charset=utf8", $username, $password);
    $baglanti->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e)
{
    echo "Connection failed: " . $e->getMessage();
}
		$kodlanmisBinary = intToBool(0,20); // 0 olarak 20 bitlik sayý oluþturuyorum bölebilmek için
		// birleþik binaryi parçalama iþlemi
		for ($i=0; $i < 5; $i++) { 
		$aday1Bool[$i] = $kodlanmisBinary[$i];		// adaylar ayrýlýyor
		$aday2Bool[$i] = $kodlanmisBinary[$i + 5];	// 5 er bitlik olarak
		$aday3Bool[$i] = $kodlanmisBinary[$i + 10];	//
		$aday4Bool[$i] = $kodlanmisBinary[$i + 15];
		}
		if ($aday == 1) {
			 $aday1Bool[4] = 1;
			 
		}elseif ($aday == 2) {
			$aday2Bool[4] = 1;
			
		}elseif ($aday == 3) {
			$aday3Bool[4] = 1;
			
		}elseif ($aday == 4) {
			$aday4Bool[4] = 1;
		}
		// kodlanmýþ binary = toplam oy ve adaylarýn 
	$kodlanmisBinary = array_merge($aday1Bool, $aday2Bool, $aday3Bool, $aday4Bool);
	// kodlanmýþbinary decimale dönüþü ayný zamanda 1. aday için kullanýcak özel 
	//sayý Encode Vote verecek
	$secmenEncodeVote = boolToInt($kodlanmisBinary, 20);

	$secmenRandomKatsayix = rand(1,524309); // random kantasi oluþturluyor
	$secmenRandomKatsayix2 = rand(1,524309);
	$secmenCC1 =  secmenCC($secmenRandomKatsayix2,$secmenRandomKatsayix,1,$secmenEncodeVote);
	$secmenCC2 =  secmenCC($secmenRandomKatsayix2,$secmenRandomKatsayix,2,$secmenEncodeVote);
	$secmenCC3 =  secmenCC($secmenRandomKatsayix2,$secmenRandomKatsayix,3,$secmenEncodeVote);

		$ekle="INSERT INTO sonuc (cc1,cc2,cc3)
						VALUES('$secmenCC1','$secmenCC2','$secmenCC3')";
		$sorgucalistir=$baglanti->query($ekle);

	}
sonuclariAcikla();
?>
</form>
</body>
</html>
