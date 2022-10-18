<?php


error_reporting(E_ALL);
ini_set("display_errors", 1 );

function GeraNomeRandomico($codigo){
	$CaracteresAceitos = 'abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789';
	$max = strlen($CaracteresAceitos)-1;
	$salt = null;
	for($i=0; $i < 10; $i++) {
		$salt .= $CaracteresAceitos{mt_rand(0, $max)};
	}
	return md5($salt.$codigo);
}

function RetornaInstrucoes($linguagem) {
	switch($linguagem) {
		case 'c':
			$extensao = 'c';
			$comando = 'gcc';
			break;
		case 'p':
			$extensao = 'p';
			$comando = 'projeto.py';
			break;
		case 'cpp':
			$extensao = 'cpp';
			$comando = 'g++';
			break;
		case 'java':
			$extensao = 'java';
			$comando = 'javac';
			break;
		case 'python2':
			$extensao = 'py';
			$comando = 'python2';
			break;
		case 'python3':
			$extensao = 'py';
			$comando = 'python3';
			break;
	}
	return $extensao."|||".$comando;
}


//DEBUG
/*echo '------------POST--------------';
echo '<pre>';
print_r($_POST);
echo '</pre>';*/

/*
echo '1234567890<br>';
 
echo '<pre>';
print_r($_FILES);
echo '</pre>';
 */
$continua = false;
/*if(isset($_FILES['arquivo']) && $_FILES['arquivo']['error'] != UPLOAD_ERR_NO_FILE) {
//SE O USUARIO ENVIOU ARQUIVO ENTAO USA O ARQUIVO
	$linguagem = $_POST['linguagem'];
	// Lista de tipos de arquivos permitidos
	// $tiposPermitidos= array('image/gif', 'image/jpeg', 'image/pjpeg', 'image/png');
	// Tamanho máximo (em bytes)
	$tamanhoPermitido = 1024 * 10000; // 500 Kb
	// O nome original do arquivo no computador do usuário
	$arqName = $_FILES['arquivo']['name'];
	// O tipo mime do arquivo. Um exemplo pode ser "image/gif"
	$arqType = $_FILES['arquivo']['type'];
	// O tamanho, em bytes, do arquivo
	$arqSize = $_FILES['arquivo']['size'];
	// O nome temporário do arquivo, como foi guardado no servidor
	$arqTemp = $_FILES['arquivo']['tmp_name'];
	// O código de erro associado a este upload de arquivo
	$arqError = $_FILES['arquivo']['error'];
	if ($arqError == 0) {
		// Verifica o tipo de arquivo enviado
		/*if (array_search($arqType, $tiposPermitidos) === false) {
			echo 'O tipo de arquivo enviado é inválido!';
		// Verifica o tamanho do arquivo enviado
		} else**********
		if ($arqSize > $tamanhoPermitido) {
			echo 'O tamanho do arquivo enviado é maior que o limite!';
			// Não houveram erros, move o arquivo
		} else {
			$pasta = __DIR__.'/codes/';
			if($linguagem == "java") {
				$arqName = "main";
			} else {
				$linguagem = pathinfo($arqName, PATHINFO_EXTENSION);
				$arqName = explode(".",$arqName);
				$arqName = GeraNomeRandomico().$arqName[0];
			}
			$dados = explode("|||", RetornaInstrucoes($linguagem));
			$extensao = $dados[0];
			$comando = $dados[1];
			$nomeCompleto = $arqName.".".$extensao;
			$upload = move_uploaded_file($arqTemp, $pasta.$nomeCompleto);
			if ($upload === false) {
				echo 'Falha no upload do arquivo. Por favor, tente novamente.';
			} else {
				//DEBUG
				//echo 'Seu arquivo foi enviado!<br />';
				$continua = true;
			}
		}
	}
} else*/ if(isset($_POST['codigo']) && !empty($_POST['codigo'])){
//SE O USUARIO NAO ENVIOU ARQUIVO ENTAO USA O CODIGO DO EDITOR
	$linguagem = $_POST['linguagem'];

	$dados = explode("|||", RetornaInstrucoes($linguagem));
	$extensao = $dados[0];
	$comando = $dados[1];

	if($linguagem == "java") {
		$arqName = "main";
	} else {
		$arqName = GeraNomeRandomico($_POST['codigo']);
	}
	$nomeCompleto = $arqName.".".$extensao;
	if(file_put_contents('/var/www/html/html/codes/'.$nomeCompleto, trim($_POST['codigo']), FILE_TEXT) !== false) {
		//DEBUG
		//echo 'UPLOAD DO ARQUIVO SUCESSO<br />';
		$continua = true;
	}
} else {
//SE O USUARIO NAO ENVIOU NENHUM DOS DOIS ENTAO MOSTRA UMA MENSAGEM DE ERRO
	echo 'Você precisa digitar o código ou enviar um arquivo!';
}
if($continua) {
	//CONTINUA CODIGO DAQUI
	
	//VERIFICA SE USUARIO ENVIOU ARQUIVO DE ENTRADA
	/*if(isset($_FILES['entrada']) && $_FILES['entrada']['error'] != UPLOAD_ERR_NO_FILE) {
		$tamanhoPermitido = 1024 * 10000; // 500 Kb
		// O nome original do arquivo no computador do usuário
		$arqNameEntrada = $_FILES['entrada']['name'];
		// O tipo mime do arquivo. Um exemplo pode ser "image/gif"
		$arqType = $_FILES['entrada']['type'];
		// O tamanho, em bytes, do arquivo
		$arqSize = $_FILES['entrada']['size'];
		// O nome temporário do arquivo, como foi guardado no servidor
		$arqTemp = $_FILES['entrada']['tmp_name'];
		// O código de erro associado a este upload de arquivo
		$arqError = $_FILES['entrada']['error'];
		if ($arqError == 0) {
			if ($arqSize > $tamanhoPermitido) {
				echo 'O tamanho do arquivo enviado é maior que o limite!';
				// Não houveram erros, move o arquivo
			} else {
				$pasta = __DIR__.'/codes/';
				$arqNameEntrada = GeraNomeRandomico().$arqNameEntrada;
				$upload = move_uploaded_file($arqTemp, $pasta.$arqNameEntrada);
				if ($upload === false) {
					echo 'Falha no upload do arquivo. Por favor, tente novamente.';
				} else {
					//DEBUG
					//echo 'Seu arquivo foi enviado!<br />';
					$continua = true;
				}
			}
		}
	} else {
		$arqNameEntrada = "";
	}*/
	$arqNameEntrada = "/var/www/html/html/entrada.txt";
	
	echo $extensao.'<br />';
	echo $comando.'<br />';
	echo $arqName.'<br />';
	
	if($extensao == 'cpp' || $extensao == 'c'){
		$comando2 = $comando.' /var/www/html/html/codes/'.$nomeCompleto." -o /var/www/html/html/codes/".$arqName." 2>&1";
	} else if($extensao == 'java') {
		$comando2 = $comando.' /var/www/html/html/codes/'.$nomeCompleto." 2>&1";
		//echo "|||||||||||||||||||||||||||||||||||||".$comando2."|||||||||||||||||||||||||||||||||||||<br />";
	} else if($comando == 'python3') {
		$comando2 = $comando.' /var/www/html/html/codes/'.$nomeCompleto." 2>&1 < ".$arqNameEntrada." > /var/www/html/html/codes/".$arqName.".txt";
	} else if($comando == 'python2') {
		$comando2 = $comando.' /var/www/html/html/codes/'.$nomeCompleto." 2>&1 < ".$arqNameEntrada." > /var/www/html/html/codes/".$arqName.".txt";
	} else if($extensao == 'p') {
		$comando2 = 'python3 /var/www/html/html/'.$comando.' /var/www/html/html/codes/'.$nomeCompleto." 2>&1";
		//echo "_________________________".$comando2."_________________________";
	}

	$output = null;
	$retval = null;
	//$output = shell_exec($comando." 2>&1");
	exec($comando2,$output,$retval);

	$compilou_sem_erro = true;
	if($retval == 0) {
		//echo 'aaaaaaaaaaaaaaaaaaaaa';
		
		if($comando == 'python3' || $comando == 'python2') {
		//echo "diff -y --strip-trailing-cr /var/www/html/html/codes/".$arqName.".txt /var/www/html/html/saida.txt";
		//echo "$retval";
			exec ("diff -sy --strip-trailing-cr /var/www/html/html/codes/".$arqName.".txt /var/www/html/html/saida.txt",$output_diff,$retval_diff);

			$total_linhas_diff = count($output_diff);
			$i_diff = 0;
			foreach($output_diff as $linha_diff) {
				//echo "for $i_diff<br />";
				if($i_diff == $total_linhas_diff - 1) {//SE ESTA NA ULTIMA LINHA DA SAIDA DO DIFF
					if(strpos($linha_diff,".txt are identical") !== false) {
						echo "ACEITO";
					} else {
						echo $linha_diff."<br />";
						echo "REJEITADO";
					}
				} else {
					echo $linha_diff."<br />";
				}
				$i_diff++;
			}
		}
	} else {
		//echo 'bbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbb';
		$compilou_sem_erro = false;
		if($comando == 'python3') {
			$output = null;
			$retval = null;
			$comando2 = $comando.' /var/www/html/html/codes/'.$nomeCompleto." 2>&1 < ".$arqNameEntrada;
			exec($comando2,$output,$retval);
		} else if($comando == 'python2') {
			$output = null;
			$retval = null;
			$comando2 = $comando.' /var/www/html/html/codes/'.$nomeCompleto." 2>&1 < ".$arqNameEntrada;
			exec($comando2,$output,$retval);
		}
		echo '<pre>';
			foreach($output as $linha) {
				$linha = str_replace("/var/www/html/html/codes/","",$linha);
				echo $linha."<br />";
			}
		echo "</pre>";
		//echo file_get_contents("/var/www/html/html/codes/".$arqName.".txt");
	}
	//DEBUG
	/*echo 'depois do comando: '.$comando2;
	echo '<br />';
	echo 'output: <br /><pre>'.var_dump($output)."</pre>";
	echo '<br />';*/
	if($compilou_sem_erro && $comando != 'python3' && $comando != 'python2') {
		//echo 'compilou<br />';
		$output = null;
		$retval = null;
		if($extensao == 'cpp' || $extensao == 'c'){
			exec ('/var/www/html/html/codes/'.$arqName.' < '.$arqNameEntrada.' > /var/www/html/html/codes/'.$arqName.'.txt',$output,$retval);
		} else if($extensao == 'java') {
			//echo "chegou";
			exec ('java -cp /var/www/html/html/codes/ main < '.$arqNameEntrada.' > /var/www/html/html/codes/'.$arqName.'.txt',$output,$retval);
		} else if($extensao == 'p') {
			//$comando.' /var/www/html/html/codes/'.$nomeCompleto." 2>&1 < ".$arqNameEntrada." > /var/www/html/html/codes/".$arqName.".txt";
			exec ('python3 /var/www/html/html/codes/'.$arqName.'.py 2>&1 < '.$arqNameEntrada.' > /var/www/html/html/codes/'.$arqName.'.txt',$output,$retval);
			//echo 'aaaaaaa';
			//echo 'python3 /var/www/html/html/codes/'.$arqName.'.py 2>&1 < '.$arqNameEntrada.' > /var/www/html/html/codes/'.$arqName.'.txt';
			//echo 'aaaaaaa';
		}
		
		if($retval == 0) {
			/*echo '<pre>';
			foreach($output as $linha) {
				$linha = str_replace("/var/www/html/html/codes/","",$linha);
				echo $linha."<br />";
			}
			echo "</pre>";*/
			//$tudo = substr($tudo, 0, -2);
			//file_put_contents("/var/www/html/html/codes/".$arqName.".txt",$tudo);
			exec ("diff -sy --strip-trailing-cr /var/www/html/html/codes/".$arqName.".txt /var/www/html/html/saida.txt",$output_diff,$retval_diff);
			//print_r($output_diff);
			$total_linhas_diff = count($output_diff);
			$i_diff = 0;
			foreach($output_diff as $linha_diff) {
				//echo "for $i_diff<br />";
				if($i_diff == $total_linhas_diff - 1) {//SE ESTA NA ULTIMA LINHA DA SAIDA DO DIFF
					if(strpos($linha_diff,".txt are identical") !== false) {
						echo "ACEITO";
					} else {
						echo $linha_diff."<br />";
						echo "REJEITADO";
					}
				} else {
					echo $linha_diff."<br />";
				}
				$i_diff++;
			}
			
			
			
			
		}
	}
}
?>
