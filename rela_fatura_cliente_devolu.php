<?php
  session_start();

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
    switch (get_post_action('gera')) {

         case 'gera':
              $mes_ano                =$_POST['mes_ano'];
              
              //Gera o total do faturamento para mostrar no relatório
              $con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
              $res = mysql_select_db($banco_d) or die ("Banco de dados inexistente");
              
              $ver= "SELECT * FROM faturamento
              WHERE faturamento.mes_ano='$mes_ano'";
              $verifica = mysql_db_query($banco_d,$ver,$con) or die ("Não foi possivel acessar o banco 2");
              $conta = mysql_num_rows($verifica);
              
              if(empty($conta)) {
                 ?>
                  <script language="javascript"> window.location.href=("rela_fatura_cliente.php")
                      alert('Não foi processado o faturamento para o MÊS e CLIENTE informados . Verifique.');
                  </script>
                 <?php
              }
              else {
              
                 //PEGA O CODIGO DO CLIENTE DO FATURAMENTO
                 $consulta ="SELECT DISTINCT codi_cli
                 FROM faturamento
                 WHERE mes_ano='$mes_ano'";
                 $vtotal = mysql_db_query($banco_d,$consulta,$con) or die ("Não foi possivel acessar o banco 2");
                 $qtotal = mysql_num_rows($vtotal);

                 for($ic=0; $ic<$qtotal; $ic++){
                     $row = mysql_fetch_row($vtotal);
                     $cliente          = $row[0];
                 }

              
                 //CALCULA O VALOR TORAL DO FATURAMENTO
                 $soma = "SELECT sum(vl_fatu) AS tot_fatu
                 FROM faturamento
                 WHERE ((mes_ano='$mes_ano')
                 AND (codi_cli='$cliente'))";
                 $vtotal = mysql_db_query($banco_d,$soma,$con) or die ("Não foi possivel acessar o banco 2");
                 $total = mysql_num_rows($vtotal);

                 for($ic=0; $ic<$total; $ic++){
                     $row = mysql_fetch_row($vtotal);
                     $v_soma          = $row[0];
                 }

                 //CALCULA A QUANTIDADE DE HAWB
                 $contar = "SELECT sum(qtdade) AS tot_hawb
                 FROM faturamento
                 WHERE ((mes_ano='$mes_ano')
                 AND (codi_cli='$cliente'))";
                 $vtotal = mysql_db_query($banco_d,$contar,$con) or die ("Não foi possivel acessar o banco 2");
                 $qtotal = mysql_num_rows($vtotal);

                 for($ic=0; $ic<$qtotal; $ic++){
                     $row = mysql_fetch_row($vtotal);
                     $v_totalh          = $row[0];
                 }
                 //Formata o número no padrão xx.xxx,xx para mostrar

                 $v_soma = number_format($v_soma, 2, ',', '.');

                 //Pega o nome do cliente

                 $pega = "SELECT nome FROM cli_for WHERE cnpj_cpf='$cliente'";
                 $query = mysql_db_query($banco_d,$pega,$con) or die ("Não foi possivel acessar o banco");
                 $total = mysql_num_rows($query);
                 for($ic=0; $ic<$total; $ic++){
                      $row = mysql_fetch_row($query);
                      $nome_cli          = $row[0];
                 }

                 $_SESSION['nome_cli_m']  =$nome_cli;
                 $_SESSION['cliente_m']   =$cliente;
                 $_SESSION['mes_ano_m']   =$mes_ano;
                 $_SESSION['v_soma_m']    =$v_soma;
                 $_SESSION['v_total_m']   =$v_totalh;
                 require_once("gera_relat_fatura_cliente_devolu.php");
                 gera_relat_fatura_cliente_devolu();
              }
           break;
         default:
    }

  //carrega variaveis com dados para acessar o banco de dados

  $base_d     =$_SESSION['base_d'];
  $banco_d    =$_SESSION['banco_d'];
  $usuario_d  =$_SESSION['usuario_d'];
  $senha_d    =$_SESSION['senha_d'];

  $matricula_m  =$_SESSION['matricula_m'];
  $programa='057';
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
?>

<HTML>
<HEAD>
 <TITLE>rela_fatura_cliente.php</TITLE>
</HEAD>
<BODY>
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
  <div id="geral" align="center">
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
         <p align="right"><font face="Arial" size="2" color="#FFFFFF"><b>Relatório de Faturamento Por Cliente</b></font></td>
     </tr>
   </table>
   <table width="100%" border="0" cellspacing="0" cellpadding="0">
       <tr>
         <td colspan="1" align="left" width="45%"><INPUT type=button size="3" value="Ajuda"
               onClick="window.open('mostra_ajuda.php','janela_1',
               'scrollbars=yes,resizable=yes,width=400,height=700');" style="width:100;height:30;color=red;font: bold 16px Arial;">
         </td>
         <td colspan="1" color="white" align="right" width="45%" height="70"><a href="entrada.php"><img src="img/porta.gif" border="none"></td>
       </tr>
   </table>
   <table width="70%" border="1" cellpadding="5" cellspacing="0" bordercolor="#6495ED">
        <form name="cadastro" method="POST" action="rela_fatura_cliente_devolu.php" border="20">
          <tr>
           <td colspan="2">
            <?php
               echo "<center><Font size=\"2\" face=\"ARIAL\">Selecione Faturamento...:</font>";

               mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
               mysql_select_db($banco_d) or die ("Banco de dados inexistente");

               $resultado = mysql_query ("SELECT DISTINCT faturamento.mes_ano,cli_for.nome
               FROM faturamento,cli_for
               WHERE faturamento.codi_cli=cli_for.cnpj_cpf
               ORDER BY faturamento.mes_ano,cli_for.nome");
               echo "<select name='mes_ano' class='caixa' align=\"center\">\n";

               while($linha = mysql_fetch_row($resultado))  {
                  printf("<option value='$linha[0]'>$linha[0] - $linha[1]</option>\n");
               }
            ?>
            </td>
          </tr>
          <tr>
			<td colspan="2">
				<div align="right">
				<input name="gera" type="submit" value="Gerar">
				</div>
			</td>
		</tr>
        </form>
  </table>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td color="white" align="center" width="900" height="45" colspan="8" ><?php echo "$resp_grava";?></td>
      </tr>
  </table>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
       <td color="white" align="left" width="100%" height="30">
     </tr>
  </table>
  <table border="0" width="100%" cellspacing="0" cellpadding="0" background="img/blue.jpg">
      <tr>
        <td width="100%" height="25" align="center"></font><font color="white" size="1" face="Arial">©&nbsp; COPYRIGHT NUNESTECH Tecnologia em Sistemas Ltda</font></td>
     </tr>
  </table>
</BODY>
</HTML>
