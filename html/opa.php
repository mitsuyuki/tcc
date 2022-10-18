<?php
header('Content-Type: application/json; charset=utf-8');
$arquivo = fopen("message_2.json", "r");
	while(!feof($arquivo)) {

		$linha = fgets($arquivo);
		$linha = preg_replace_callback('/\\\\u([0-9a-fA-F]{4})/', function ($match) {
			return mb_convert_encoding(pack('H*', $match[1]), 'UTF-8', 'UCS-2BE');
		}, $linha);
		echo utf8_decode($linha);

	}
	fclose($arquivo);

?>