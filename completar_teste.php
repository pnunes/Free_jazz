<?php
  session_start();
  $base_d     =$_SESSION['base_d'];
  $banco_d    =$_SESSION['banco_d'];
  $usuario_d  =$_SESSION['usuario_d'];
  $senha_d    =$_SESSION['senha_d'];

  $con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
  $res = mysql_select_db($banco_d) or die ("Banco de dados inexistente");

  $q=strtolower ($_GET["q"]);

  $sql = "SELECT localiza FROM destino WHERE localiza like '%" . $q . "%'";

  $query = mysql_query($sql);// or die ("Erro". mysql_query());

  while($reg=mysql_fetch_array($query)){

	//if (srtpos(strtolower($reg['nom_lista']),$q !== false){
		echo $reg["localiza"]."|".$reg["localiza"]."\n";
//	}
}
?>
