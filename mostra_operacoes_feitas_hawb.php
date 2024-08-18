<?php
  session_start();

 //carrega variaveis com dados para acessar o banco de dados

  $base_d     =$_SESSION['base_d'];
  $banco_d    =$_SESSION['banco_d'];
  $usuario_d  =$_SESSION['usuario_d'];
  $senha_d    =$_SESSION['senha_d'];
  
  $matricula_m  =$_SESSION['matricula_m'];
  $programa='072';
  $_SESSION['programa_m']=$programa;

  $con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
  $res = mysql_select_db($banco_d) or die ("Banco de dados inexistente");

  $declara = "SELECT matricula,programa
  FROM permissoes
  WHERE ((matricula='$matricula_m') and (programa='$programa'))";

  $query = mysql_db_query($banco_d,$declara,$con) or die ("Não foi possivel acessar o banco");
  $achou = mysql_num_rows($query);

  If ($achou == 0 ) {
       ?>
          <script language="javascript"> window.location.href=("entrada.php")
            alert('Você não está autorizado a acessar esta rotina.');
          </script>
       <?php
    }

  function get_post_action($name) {
    $params = func_get_args();
    foreach ($params as $name) {
        if (isset($_POST[$name])) {
            return $name;
        }
    }
  }
  
  include("campo_calendario.php");

?>

<HTML>
<HEAD>
 <TITLE>mostra_operacoes_feitas_sistema.php</TITLE>

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
  <div id="geral" align="center">
  <body topmargin="0" leftmargin="0" rightmargin="0" bottommargin="0" marginheight="0" marginwidth="0" bgcolor="#FFFFFF">
     <table border="0" width="100%" bgcolor="#000000" cellspacing="0" cellpadding="0">
      <tr>
        <td width="20%" height="100" background="img/topleft.jpg"></td>
         <td width="658" height="110"> <img border="0" src="img/cabecalho_free_jazz.jpg" width="890" height="115" border="0"></td>
        <td width="15%" height="110">
        <p align="right"><img border="0" src="img/topright.jpg" width="160" height="110" border="0"></td>
     </tr>
    </table>
    <table border="0" width="100%" cellspacing="0" cellpadding="0" background="img/blue.jpg">
     <tr>
       <td width="50%">
         <p align="left"><font face="Arial" size="2" color="#FFFFFF"><b>Sistema de Gerenciamento da Logística de Encomendas</b></font></td>
       <td width="50%">
         <p align="right"><font face="Arial" size="2" color="#FFFFFF"><b>Consulta Operações no Sistema Por Usuário</b></font></td>
     </tr>
   </table>
   <table width="100%" border="0" cellspacing="0" cellpadding="0">
       <tr>
         <td colspan="1" color="white" align="right" width="45%" height="70"><a href="entrada.php"><img src="img/porta.gif" border="none"></td>
       </tr>
   </table>

   <form method="POST" name="cadastro" action="mostra_operacoes_feitas_hawb.php" border="20" align="center">
   <?php
     switch (get_post_action('mostra')) {

         case 'mostra':
             $n_hawb                   =$_POST['n_hawb'];
         break;
         default:
     }

   ?>
   <table width="50%" border="1" cellpadding="5" cellspacing="0" bordercolor="#4169E1">
      <tr>
        <td><b>Número HAWB :</b></td>
        <td><input type="text" name="n_hawb" id="n_hawb" value ="<?php echo "$n_hawb";?>" size="14" maxlength="14"></td>
      </tr>
      <tr>
       <td colspan="2">
         <div align="right">
    	    <input name="mostra" type="submit" value="Mostrar">
    	 </div>
       </td>
      </tr>
   </table>
   <table width="80%" border="1" cellpadding="5" cellspacing="0" bordercolor="#4169E1">
     <tr>
       <td colspan="6" align="center"><font face="arial" size="2"><b>OPERAÇÕES FEITAS COM A HAWB NÚMERO :<?php echo "$n_hawb" ?></b></font></td>
     </tr>
     <tr>
       <td width="20%" align="center"><b>OPERAÇÃO EXECUTADA</b></td>
       <td width="20%" align="center"><b>OPERADOR</b></td>
       <td width="15%" align="center"><b>SERVIÇO</b></td>
       <td width="10%" align="center"><b>DATA</b></td>
       <td width="10%" align="center"><b>HORA</b></td>
       <td width="25%" align="center"><b>ROTINA OPERADA</b></td>
     </tr>
     <?php
      mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
      mysql_select_db($banco_d) or die ("Banco de dados inexistente");

      $resultado = mysql_query ("SELECT log_operacao_sistema.tarefa_executada,pessoa.nome,
      date_format(log_operacao_sistema.data,'%d/%m/%Y'),log_operacao_sistema.hora,cad_rotinas.nome_programa
      FROM log_operacao_sistema,cad_rotinas,pessoa
      WHERE ((log_operacao_sistema.rotina=cad_rotinas.programa)
      AND (log_operacao_sistema.matricula=pessoa.matricula)
      AND (log_operacao_sistema.n_hawb='$n_hawb'))
      ORDER BY log_operacao_sistema.n_hawb,log_operacao_sistema.data,log_operacao_sistema.hora");
      $total = mysql_num_rows($resultado);

      for($i=0; $i<$total; $i++){
         $dados = mysql_fetch_row($resultado);
	     $tarefa          =$dados[0];
	     $operador        =$dados[1];
	     $data            =$dados[2];
	     $hora            =$dados[3];
	     $progra          =$dados[4];
	     $servico         =$dados[5];
	     echo "<tr>";
	     echo "<td width=\"20%\" align=\"left\"><font size=\"2\" face=\"arial\">$tarefa</font></td>";
	     echo "<td width=\"20%\"><font size=\"2\" face=\"arial\">$operador</font></td>";
	     echo "<td width=\"15%\"><font size=\"2\" face=\"arial\">$servico</font></td>";
	     echo "<td width=\"10%\"><font size=\"2\" face=\"arial\">$data</font></td>";
         echo "<td width=\"10%\"><font size=\"2\" face=\"arial\">$hora</font></td>";
         echo "<td width=\"25%\"><font size=\"2\" face=\"arial\">$progra</font></td>";
         echo "</tr>";
       }
     ?>
</table>
<table>
<tr>
  <td><INPUT type=button value="Relação de Serviços"
       onClick="window.open('mostra_servicos_cadastrados.php','janela_1',
       'scrollbars=yes,resizable=yes,width=600,height=400');">
  </td>
</tr>
</table>
</form>
</div>
</BODY>
</HTML>
