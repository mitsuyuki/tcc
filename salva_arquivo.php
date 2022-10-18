<?php 
/*header("Content-Type: application/force-download");
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header("Content-Type: text/plain");
//header('Content-Disposition: attachment; filename=teste.'.$_POST['linguagem']);
header('Content-Disposition: attachment; filename=teste.txt');*/

function GeraNomeRandomico($codigo){
	$CaracteresAceitos = 'abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789';
	$max = strlen($CaracteresAceitos)-1;
	$salt = null;
	for($i=0; $i < 10; $i++) {
		$salt .= $CaracteresAceitos{mt_rand(0, $max)};
	}
	return md5($salt.$codigo);
}

//echo $_POST['codigo_editor'];
//echo $_POST['linguagem_editor'];

if($linguagem == "java") {
		$arqName = "main";
	} else {
		$arqName = GeraNomeRandomico($_POST['codigo']);
	}
	$nomeCompleto = $arqName.".".$_POST['linguagem_editor'];

if(file_put_contents('/var/www/html/html/codes/'.$nomeCompleto, trim($_POST['codigo_editor']), FILE_TEXT) !== false) {
		echo 'https://mitsuyuki.org/html/codes/'.$nomeCompleto;
	}

?>