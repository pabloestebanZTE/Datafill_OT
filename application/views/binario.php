<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<form action="Welcome/binaryf" method="post">
		<input type="text" name="num">
		<input type="submit" name="" value="ingresar">
	</form>	

	<br><br>
	<?php 
		if (isset($binario)) {
			$binario = implode("", $binario);
			print_r($binario);
		}

	 ?>


</body>
</html>