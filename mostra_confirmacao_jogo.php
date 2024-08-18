<?php
  session_start();

 //carrega variaveis com dados para acessar o banco de dados

  $base_d     =$_SESSION['base_d'];
  $banco_d    =$_SESSION['banco_d'];
  $usuario_d  =$_SESSION['usuario_d'];
  $senha_d    =$_SESSION['senha_d'];

  include ("campo_calendario.php");

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
             $data_jogo                 =$_POST['data_jogo'];
             $_SESSION['data_jogo_i']   =$data_jogo;
         break;
      default:
  }
?>

<HTML>
<HEAD>
 <TITLE>mostra_mensalidade_por_membro.php</TITLE>

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

<form name="cadastro" id="cadastro" method="POST" action="mostra_confirmacao_jogo.php" border="20">
<INPUT type=button value="Fechar janela" onClick="window.close();">
 <table width="500" heigth="300" align="center">
     <tr>
        <td><b>Data do Jogo :</b></td>
        <td>
           <input type="text" name="data_jogo" size="12" maxlength="12" id="data_jogo">
           <input TYPE="button" NAME="btndata_jogo" VALUE="..." Onclick="javascript:popdate('document.cadastro.data_jogo','pop1','150',document.cadastro.data_jogo.value)">
           <span id="pop1" style="position:absolute"></span>
           <input name="mostra" type="submit" value="Mostra"></center>
        </td>
     </tr>
 </table>
 </form>
<table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#DEB887">
 <tr>
    <td colspan="4" align="center"><font face="arial" size="2"><b>MEMBROS QUE CONFIRMARAM PRESENÇA NO JOGO DE :<?php echo "$data_jogo"; ?></b></font></td>
 </tr>
 <tr>
     <td width="10%" align="center"><b>CODIGO</b></td>
     <td width="60%" align="center"><b>NOME</b></td>
     <td width="30%" align="center"><b>POSIÇÃO</b></td>
 </tr>
<?php
      $data_jogo    =$_SESSION['data_jogo_i'];
      
      //mudando formato da data para comparar

      $data_jogo  = explode("/",$data_jogo);
      $v_data_jogo = $data_jogo[2]."-".$data_jogo[1]."-".$data_jogo[0];
                
      $con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
      $res = mysql_select_db($banco_d) or die ("Banco de dados inexistente");

      $seleciona="SELECT jogos.codigo_membro,cad_membro.nome,cad_membro.posicao
      FROM jogos,cad_membro
      WHERE ((jogos.data_jogo='$v_data_jogo')
      AND (jogos.codigo_membro=cad_membro.codigo))";
      $query_1 = mysql_db_query($banco_d,$seleciona,$con) or die ("Não foi possivel acessar o banco");
      $total_1 = mysql_num_rows($query_1);

      for($ic=0; $ic<$total_1; $ic++){
        $row = mysql_fetch_row($query_1);
        $codigo_membro      = $row[0];
        $nome_membro        = $row[1];
        $posicao            = $row[2];
        echo "<tr>";
        echo "<td width=\"10%\"><font size=\"2\" face=\"arial\">$codigo_membro</font></td>";
        echo "<td width=\"60%\"><font size=\"2\" face=\"arial\">$nome_membro</font></td>";
        echo "<td width=\"30%\"><font size=\"2\" face=\"arial\">$posicao</font></td>";
        echo "</tr>";
     }
?>
</table>
</div>
</BODY>
</HTML>
