<?php
  session_start();

 //carrega variaveis com dados para acessar o banco de dados

  $base_d     =$_SESSION['base_d'];
  $banco_d    =$_SESSION['banco_d'];
  $usuario_d  =$_SESSION['usuario_d'];
  $senha_d    =$_SESSION['senha_d'];

?>

<HTML>
<HEAD>
 <TITLE>mostra_parentesco_cadastrado.php</TITLE>

 <style>
		body, p, div, td, input, select, textarea {
			font-family: verdana,arial,helvetica;
			font-size:12px;
			color:#000000;
			text-decoration: none;
		}
		input,textarea {
			@if (is.ie) {
				color: #efefef; background-color:#F0F8FF; border: 1px solid #6495ED ;
				/*border-top-width: 1px; border-right-width: 1px; border-bottom-width: 1px; border-left-width: 1px; */
			}
		}
		textarea { overflow:auto }
	</style>

</HEAD>

<BODY>

<FORM>
<INPUT type=button value="Fechar janela" onClick="window.close();">
</FORM>
<table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#4169E1">
 <tr>
    <td colspan="3" align="center"><font face="arial" size="2"><b>PESSOAS CADASTRADAS</b></font></td>
 </tr>
 <tr>
     <td width="15%" align="center"><b>CODIGO</b></td>
     <td width="50%" align="center"><b>NOME</b></td>
     <td width="35%" align="center"><b>LOGIN</b></td>
 </tr>
<?php
      mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
      mysql_select_db($banco_d) or die ("Banco de dados inexistente");

      $resultado = mysql_query ("SELECT matricula,nome,usuario
                   FROM pessoa ORDER BY matricula");
      $total = mysql_num_rows($resultado);

      for($i=0; $i<$total; $i++){
         $dados = mysql_fetch_row($resultado);
	     $matricula       =$dados[0];
	     $nome            =$dados[1];
	     $usuario         =$dados[2];
	     echo "<tr>";
	     echo "<td width=\"15%\" align=\"left\"><font size=\"2\" face=\"arial\">$matricula</font></td>";
	     echo "<td width=\"50%\"><font size=\"2\" face=\"arial\">$nome</font></td>";
	     echo "<td width=\"35%\"><font size=\"2\" face=\"arial\">$usuario</font></td>";
         echo "</tr>";
       }
?>
</table>
</div>
</BODY>
</HTML>
