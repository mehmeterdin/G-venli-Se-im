
<!DOCTYPE html>
<html>
<head>
	  <link rel="stylesheet" href="css/aday.css">
	 
	  <link rel="stylesheet" href="css/login.css">
</head>

<body>

<form >
   		
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
			   <td><button name="sonuclar">SONUÇLAR</button></td>
		   </tr>
		   </table>
	   </form>

      <?php if(isset($_REQUEST["sonuclar"])){
	include("sonuc.php");
}
?>
</body>