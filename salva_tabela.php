<?php
$gmtDate = gmdate("D, d M Y H:i:s");
header("Expires: {$gmtDate} GMT");
header("Last-Modified: {$gmtDate} GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("Content-Type: text/html; charset=ISO-8859-1");

$con = mysql_connect('localhost', 'root', 'nunesp') or die ("Erro de conex�o");
$res = mysql_select_db('free_jazz') or die ("Banco de dados inexistente");
import_request_variables("g");

// Atualiza��o do produto
if($_GET['acao'] == 'atualizar'){
	if(!empty($_GET['controle']) && !empty($_GET['valor'])){
		$valor = str_replace(",",".", $_GET['valor']); //troca a v�rgula por ponto
		if(is_numeric($valor)){
			$sql = mysql_query("UPDATE tb_terceiro SET valor = '".$valor."' WHERE controle = '".$_GET['controle']."'");
			$res2 = mysql_query($sql);
			echo '1';
		}else{
			echo 'Valor inv�lido';
		}
	}
}

// exclus�o de produtos
elseif($_GET['acao'] == 'excluir'){
	$sql = "DELETE FROM tb_terceiro WHERE controle = '".$_GET['cod']."'";
	$res = mysql_query($sql);
	echo '2';
}

// Cadastro de produtos
elseif($_GET['acao'] == 'cadastrar'){
	if(!empty($_GET['nome']) && !empty($_GET['preco'])){
		$preco = str_replace(",",".", $_GET['preco']);
		if(is_numeric($preco)){
			$sql = "insert into produtos (nome, preco) values ('".$_GET['nome']."', '".$preco."')";
			$res2 = mysql_query($sql);
			$novo_codigo = mysql_insert_id($con);
			
			//retorna a mensagem de confirma��o de cadasro do produto
			echo "3";
		}else{
			echo 'Pre�o inv�lido';
		}
	}else{
		echo 'Voc� deve preencher todos os campos!';
	}
}
?>
