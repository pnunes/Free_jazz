<?php
  session_start();

 //carrega variaveis com dados para acessar o banco de dados

  $base_d     =$_SESSION['base_d'];
  $banco_d    =$_SESSION['banco_d'];
  $usuario_d  =$_SESSION['usuario_d'];
  $senha_d    =$_SESSION['senha_d'];

  function get_post_action($name) {
    $params = func_get_args();
    foreach ($params as $name) {
        if (isset($_POST[$name])) {
            return $name;
        }
    }
  }
  switch (get_post_action('mostra')) {
         case 'mostra':
             $ano                 =$_POST['ano'];
             $_SESSION['ano_i']   =$ano;
         break;
      default:
  }
?>

<HTML>
<HEAD>
 <TITLE>mostra_saldo_cadastrado.php</TITLE>

 <style>
		body, p, div, td, input, select, textarea {
			font-family: verdana,arial,helvetica;
			font-size:12px;
			color:#000000;
			text-decoration: none;
		}
		input,textarea {
			@if (is.ie) {
				color: #efefef; background-color:#FFE4B5; border: 1px solid #DEB887;
				/*border-top-width: 1px; border-right-width: 1px; border-bottom-width: 1px; border-left-width: 1px; */
			}
		}
		textarea { overflow:auto }
	</style>

</HEAD>

<BODY>

<form method="POST" action="mostra_saldo_cadastrado.php" border="20">
<INPUT type=button value="Fechar janela" onClick="window.close();">
 <table width="500" heigth="300" align="center">
        <tr>
           <td><b>Ano de competência :</b></td>
           <td>
           <SELECT NAME="ano" SIZE="1">
               <OPTION VALUE="2011">2011</OPTION>
               <OPTION VALUE="2012">2012</OPTION>
               <OPTION VALUE="2013">2013</OPTION>
               <OPTION VALUE="2014">2014</OPTION>
               <OPTION VALUE="2015">2015</OPTION>
               <OPTION VALUE="2016">2016</OPTION>
               <OPTION VALUE="2017">2017</OPTION>
               <OPTION VALUE="2018">2018</OPTION>
               <OPTION VALUE="2019">2019</OPTION>
               <OPTION VALUE="2020">2020</OPTION>
           </SELECT>
           <input name="mostra" type="submit" value="Mostra"></center>
           </td>
        </tr>
   </table>
 </form>
<table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#DEB887">
 <tr>
    <td colspan="4" align="center"><font face="arial" size="2"><b>MENSALIDADES DO MEMBRO :<?php echo "$nome"; ?></b></font></td>
 </tr>
 <tr>
     <td width="20%" align="center"><b>MÊS COMPETENCIA</b></td>
     <td width="15%" align="center"><b>SALDO INI.</b></td>
     <td width="15%" align="center"><b>SALDO FINAL</b></td>
     <td width="50%" align="center"><b>OBSERVAÇÃO</b></td>
 </tr>
<?php
      $ano    =$_SESSION['ano_i'];
      $con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
      $res = mysql_select_db($banco_d) or die ("Banco de dados inexistente");


      $verifi="SELECT mes,saldo_inicio,saldo_fim,observacao
      FROM controle_saldo WHERE ano='$ano'";
      $query = mysql_db_query($banco_d,$verifi,$con) or die ("Não foi possivel acessar o banco");
      $total = mysql_num_rows($query);

      for($ic=0; $ic<$total; $ic++){
        $row = mysql_fetch_row($query);
        $mes             = $row[0];
        $saldo_inicio    = $row[1];
        $saldo_fim       = $row[2];
        $observacao      = $row[3];
        
        //Altera formato para mostrar valor
        $saldo_inicio   = number_format($saldo_inicio, 2, ',', '.');
        $saldo_fim      = number_format($saldo_fim, 2, ',', '.');
        
        echo "<tr>";
        echo "<td width=\"20%\"><font size=\"2\" face=\"arial\">$mes</font></td>";
        echo "<td width=\"15%\"><font size=\"2\" face=\"arial\">$saldo_inicio</font></td>";
        echo "<td width=\"15%\"><font size=\"2\" face=\"arial\">$saldo_fim</font></td>";
        echo "<td width=\"15%\"><font size=\"2\" face=\"arial\">$observacao </font></td>";
        echo "</tr>";
     }
?>
</table>
</div>
</BODY>
</HTML>
