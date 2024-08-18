<?php
  session_start();
  $descricao     =$_SESSION['descricao_m'];

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Galeria Simples usando PHP</title>


<!--
###################################
##			Estilos              ##
###################################
-->
<style>
body {
	text-align:center;
	margin:0;
	padding:0;
}
div {
	padding:13px;
	display:block;
	border:1px solid #ddd;
	background:#eee;
	font-size:10px;
	font-family:Arial, Helvetica, sans-serif;
	color:#999;
	margin:0 auto;
}
div.thumb {
	float:left;
	margin:0 14px 14px 0;
	padding:0;
}
div.thumb a {
	float:left;
	padding:13px;
}
div.thumb a:hover {
	background:#b70000;
}
div.thumb img {
	width:100px;
	height:100px;
}
div p {
	padding:8px 0 0px;
	margin:0;
}
div a {
	color:#666;
	text-transform:uppercase;
	text-decoration:none;
	font-weight:bold;
}
div a:hover {
	color:#b70000;
	text-decoration:underline
}
</style>
</head>
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
   <tr>
     <td colspan="1" color="white" align="right" width="45%" height="70"><a href="seleciona_fotos_evento.php"><img src="img/porta.gif" border="none"></td>
   </tr>
   <tr>
     <td colspan="1" color="white" align="center"><font face="arial" size="4"><?php echo "$descricao";?></font></td>
     <p>&nbsp;
   </tr>
 </table>

<!--
#################################
##			LÛgica             ##
#################################
-->
<?php
	
	//URL onde o arquivo PHP vai ficar
	//$url_galeria = "http://www.toprated.com.br/galeria.php";
	$url_galeria = "http://www.mastersdobosque.com.br/galeria.php";

	//URL onde as fotos v„o ficar
	//$pasta_fotos = "fotos_galeria";
	 $pasta_fotos   =$_SESSION['nome_pasta_m'];
	//inicio da funcao
	
	$fotos = array();
	
	//Loop que percorre a pasta das imagens e armazena o nome de todos os arquivos
	foreach(glob($pasta_fotos . '/{*_p.jpg,*_p.gif}', GLOB_BRACE) as $image) {	
			
			$fotos[] = $image;
		
	}
	
	//Verifica se deve exibir a lista ou uma foto
	if ($_GET["image"] == "") {
		
		//Faz o loop pelo folder de imagens
		for($i=0; $i < count($fotos); $i++) {	
									
			//Cria cada uma das thumbs dentro de uma <div> com link para a imagem grande
			echo "<div class='thumb'>";
			echo "<a href='" . $url_galeria . "?image=" . $i . "'>";
			echo "<img src='" . $fotos[$i] . "'>";
			echo "</a>";
			echo "</div>";
		
		}

	} else {
			
			//Guarda o nome da imagem para montar o link da imagem grande
			$foto_g = explode("_p", $fotos[$_GET["image"]]);
			
			//Configura os links de pr√≥xima e anterior
			if ( $_GET["image"] == 0 ) { $anterior = ""; } else { $anterior = $_GET["image"] - 1; }
			if ( $_GET["image"] == count($fotos)-1 ) { $proxima = ""; } else { $proxima = $_GET["image"] + 1; }
			
			//Quando solicitada uma imagem em particular, monta a <div> e insere a imagem grande de acordo com o link
			echo "<div>";
			echo "<a href='" . $url_galeria . "?image=" . $proxima . "'>";
			echo "<img src='" . $foto_g[0] . "_g" . $foto_g[1] . "'>";
			echo "</a>";
			echo "<p><a href='" . $url_galeria . "?image=" . $anterior . "'>Foto anterior</a> | <a href='" . $url_galeria . "'>Voltar para a galeria</a> | <a href='" . $url_galeria . "?image=" . $proxima . "'>Pr√≥xima foto</a></p>";
			echo "</div>";
			
	}

?>
</body>
</html>
