 
<!DOCTYPE html>
<html>
<head>
	  <link rel="stylesheet" href="css/aday.css">
	 
	  <link rel="stylesheet" href="css/login.css">
</head>

<body>
<form method = "post">
   		
		   <table>
		   <tr>
			   <td><label >Gizli Değer 1:</label></td>
			   <td><input type="text" name="scc1" required="required" ></td>
		   </tr>
		   <tr>
			   <td><label >Gizli Değer 2:</label></td>
			   <td><input type="text" class="harf" name="scc2" required="required" ></td>
		   </tr>
		   <tr>
			   <td><label >Gizli Değer 3:</label></td>
			   <td><input type="text" class="harf" name="scc3" required="required" ></td>
		   </tr>
		   <tr>
			   <td><button name="sonuclar" id="sonuclar">SONUÇLAR</button></td>
		   </tr>
		   </table>
	   </form>
<?php
 require_once("veritabanibaglantisi.php");
if(!isset($_SESSION)) {
       session_start();
}     
if(!isset($_SESSION['secmen_id']))
    {
        header("location:login.php");
    }

			   $i=1;
			   $aday[$i]="aday1";
					
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


				 <?php
                   $i++;
			    echo "</tr>";
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

		if (empty( $_POST['aday']))
		{
			echo "<b>LÜTFEN DESTEKLEDİĞİNİZ ADAYI SEÇİNİZ!</b>";
		}
		else{

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

	            $adaySonuc[0] = boolToInt($aday1Bool,5);
				$adaySonuc[1] = boolToInt($aday2Bool,5);
				$adaySonuc[2] = boolToInt($aday3Bool,5);
				$adaySonuc[3] = boolToInt($aday4Bool,5);

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



		?>




		
		<?php
						$i=0;
				echo "</br><b>SONUÇ LİSTESİ</b></br>";
					$query="SELECT * from aday";
	        		$adayyazdir=$baglanti->query($query);
			foreach ($adayyazdir as $key => $value)
			 {
        	    echo "<tr>";
		        echo "</br>-------------------------</br>";
		        echo "<td>".$value['aday_ad']."&nbsp;&nbsp;</td><td>".$value['aday_soyad']."</td>:&nbsp;";
		        echo  $adaySonuc[$i];// nerde nasıl gösterilmek istenirse 
                echo"</tr>";
                       $i=$i+1;   
             }
        		echo "</br>-------------------------</br>";
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
		
	/*	$q01 = ($scc1 * (2 / (2 - 1))) + ($scc2 * (1 / (1 - 2))) ;
		$q01 = check($q01);
		$q02 = ($scc1 * (3 / (3 - 1))) + ($scc3 * (1 / (1 - 3))) ;
		$q02 = check($q02);
		$q03 = ($scc2 * (3 / (3 - 2))) + ($scc3 * (2 / (2 - 3))) ;
		$q03 = check($q03);
		if ($q01==$q02 && $q01 == $q03) {
			return $q01; // doğru sonuç dönüyor
		}else{
			return -1; // hata olduğunu belli etmek amaçlı -1 döndürüyorum 
		}
		*/
		$q00 = ((((0-2)*(0-3))/((1-2)*(1-3)))*$scc1) + ((((0-1)*(0-3))/((2-1)*(2-3)))*$scc2) + ((((0-1)*(0-2))/((3-1)*(3-2)))*$scc3);
		
		$q00 = check($q00);

		return $q00;
		
	}
	

	function oyKullan($aday){
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


	if(array_key_exists('sonuclar',$_POST)){
		//echo "<script type='text/javascript'>alert('aaa');</script>";
		sonuclariAcikla();
	 }


?>


</form>
</body>
</html>
