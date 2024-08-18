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
 <TITLE>mostra_precos_cadastrados.php</TITLE>

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
    <td colspan="5" align="center"><font face="arial" size="2"><b>PREÇOS CADASTRADOS</b></font></td>
 </tr>
 <tr>
     <td width="10%" align="center"><b>CODIGO</b></td>
     <td width="35%" align="center"><b>NOME SERVIÇO</b></td>
     <td width="20%" align="center"><b>CLIENTE</b></td>
     <td width="35%" align="center"><b>NOME CLIENTE</b></td>
 </tr>
<?php
      mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
      mysql_select_db($banco_d) or die ("Banco de dados inexistente");

      $resultado = mysql_query ("SELECT servi_cli.codigo_se,serv_ati.descri_se,servi_cli.codi_cli,cli_for.nome
                   FROM servi_cli,cli_for,serv_ati
                   WHERE ((servi_cli.codi_cli=cli_for.cnpj_cpf)
                   AND (servi_cli.codigo_se=serv_ati.codigo_se))
                   ORDER BY servi_cli.codi_cli,servi_cli.codigo_se");
      $total = mysql_num_rows($resultado);

      for($i=0; $i<$total; $i++){
         $dados = mysql_fetch_row($resultado);
         $codigo_se  =$dados[0];
	     $descri_se  =$dados[1];
	     $codi_cli   =$dados[2];
	     $nome_cli   =$dados[3];
	     
	     echo "<tr>";
	     echo "<td width=\"10%\" align=\"left\"><font size=\"2\" face=\"arial\">$codigo_se</font></td>";
	     echo "<td width=\"35%\" align=\"left\"><font size=\"2\" face=\"arial\">$descri_se</font></td>";
	     echo "<td width=\"20%\"><font size=\"2\" face=\"arial\">$codi_cli</font></td>";
	     echo "<td width=\"35%\"><font size=\"2\" face=\"arial\">$nome_cli</font></td>";
         echo "</tr>";
       }
?>
</table>
</div>
</BODY>
</HTML>
