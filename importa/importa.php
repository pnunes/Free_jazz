<?php
/*
esta funciomando para txt e csv, pode funcionar para outros arquivos, mais so testei estes
voce devera alterar os dados de conecção do bando de dados
altera a nome da tabela que voce esta usando, e o nome do arquivo
o arquivo deve estar na mesma pasta deste arquivo php
*/

$conexao = mysql_connect("localhost", "root");
if($conexao)
{
mysql_select_db("nome do banco", $conexao) or die("O banco solicitado não pode ser utilizado :  . mysql_error()");
}
else{echo "não foi possivel estabelecer uma conecção";}

//========================================

$tabela = "texto"; //tabela do banco
$arquivo = 'teste.txt';// aquivo a ver importado txt ou
//$arquivo = 'teste.csv';// aquivo a ser importado csv do execel

$arq = fopen($arquivo,'r');// le o arquivo txt

while(!feof($arq))
for($i=0; $i<1; $i++){
	if ($conteudo = fgets($arq)){//se extrair uma linha e não for false
		$ll++; // $ll recebe mais 1 ==== em quanto o existir linha sera somada aqui
		$linha = explode(';', $conteudo);// divide por coluna onde tiver ponto e virgula
	}

	$sql = "INSERT INTO $tabela (TESTE1, TESTE2, TESTE3) VALUES ('$linha[0]', '$linha[1]', '$linha[2]')";
	$result = mysql_query($sql) or die(mysql_error());
	$linha = array();// linpa o array de $linha e volta para o for
}
echo "quantidade de linhas importadas = ".$ll;

?>
