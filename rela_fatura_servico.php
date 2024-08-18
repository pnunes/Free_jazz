<?php

    if ( session_status() !== PHP_SESSION_ACTIVE ) {
      session_start();
    }
   
	include('conexao_free.php');
    
	//carrega variaveis com dados para acessar o banco de dados
    $matricula_m  =$_SESSION['matricula_m'];
    $programa='118';
    $_SESSION['programa_m']=$programa;
	
    $declara = "SELECT matricula,programa FROM permissoes WHERE ((matricula='$matricula_m') and (programa='$programa'))";
    $query = mysqli_query($con,$declara) or die ("Não foi possivel acessar o banco");
    $achou = mysqli_num_rows($query);

    If ($achou == 0 ) {
       ?>
          <script language="javascript"> window.location.href=("entrada.php")
            alert('Você não esta autorizado a acessar esta rotina.');
          </script>
       <?php
    }
	$resp_grava ='';
    
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
              $servico                =$_POST['servico'];
              $cliente                =$_POST['cliente'];
              $dt_inicio              =$_POST['data_ini'];
              $dt_fim                 =$_POST['data_fim'];

              //Altera formato de data para comparação

              $dt_inicio  = explode("/",$dt_inicio);
              $v_dt_inicio = $dt_inicio[2]."-".$dt_inicio[1]."-".$dt_inicio[0];

              $dt_fim  = explode("/",$dt_fim);
              $v_dt_fim = $dt_fim[2]."-".$dt_fim[1]."-".$dt_fim[0];

              //Pega o nome do servico
			  
              $pega = "SELECT descri_se FROM serv_ati WHERE codigo_se='$servico'";
              $query = mysqli_query($con,$pega) or die ("Não foi possivel acessar o banco");
              $total = mysqli_num_rows($query);
              for($ic=0; $ic<$total; $ic++){
                  $row = mysqli_fetch_row($query);
                  $descri_se          = $row[0];
              }
               
			  //pega o nome do cliente
              $local = "SELECT nome FROM cli_for WHERE cnpj_cpf='$cliente'";
              $query_c = mysqli_query($con,$local) or die ("Não foi possivel acessar o banco");
              $total = mysqli_num_rows($query_c);
              for($ic=0; $ic<$total; $ic++){
                  $row = mysqli_fetch_row($query_c);
                  $nome_cli          = $row[0];
              }

              $_SESSION['nome_cli_m']   =$nome_cli;
              $_SESSION['cliente_m']    =$cliente;
              $_SESSION['descri_se_m']  =$descri_se;
              $_SESSION['servico_m']    =$servico;
              $_SESSION['dt_inicio_m']  =$v_dt_inicio;
              $_SESSION['dt_fim_m']     =$v_dt_fim;
              require_once("gera_fatura_servico.php");
           break;

         default:

    }
	include("campo_calendario.php");
?>

<HTML>
<HEAD>
 <TITLE>rela_fatura_servico.php</TITLE>
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
        <p align="right"><font face="Arial" size="2" color="#FFFFFF"><b>Relatório Faturamento Serviço</b></font></td>
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
        <form name="cadastro" method="POST" action="rela_fatura_servico.php" border="20">
          <tr>
           <td colspan="2">
            <?php
               echo "<center><Font size=\"2\" face=\"ARIAL\">Selecione Serviço...:</font>";
               $resultado = mysqli_query ($con,"SELECT codigo_se,descri_se
               FROM serv_ati
               ORDER BY codigo_se");
               echo "<select name='servico' class='caixa' align=\"center\">\n";
               while($linha = mysqli_fetch_row($resultado))  {
                  printf("<option value='$linha[0]'>$linha[0] - $linha[1]</option>\n");
               }
            ?>
            </td>
          </tr>
          <tr>
           <td colspan="2">
            <?php
               echo "<center><Font size=\"2\" face=\"ARIAL\">Selecione Cliente...:</font>";
               $resultado = mysqli_query ($con,"SELECT cnpj_cpf,nome FROM cli_for
               WHERE catego='C'");
               echo "<select name='cliente' class='caixa' align=\"center\">\n";
               while($linha = mysqli_fetch_row($resultado))  {
                  printf("<option value='$linha[0]'>$linha[0] - $linha[1]</option>\n");
               }
            ?>
            </td>
          </tr>
          <tr>
           <td><b>Data inicio :</b></td>
           <td>
             <input type="text" name="data_ini" size="12" maxlength="12" id="data_ini">
             <input TYPE="button" NAME="btndata_ini" VALUE="..." Onclick="javascript:popdate('document.cadastro.data_ini','pop1','150',document.cadastro.data_ini.value)">
             <span id="pop1" style="position:absolute"></span>
           </td>
          </tr>
          <tr>
           <td><b>Data fim :</b></td>
           <td>
             <input type="text" name="data_fim" size="12" maxlength="12" id="data_fim">
             <input TYPE="button" NAME="btndata_fim" VALUE="..." Onclick="javascript:popdate('document.cadastro.data_fim','pop2','150',document.cadastro.data_fim.value)">
             <span id="pop2" style="position:absolute"></span>
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
        <td width="100%" height="25" align="center"></font><font color="white" size="1" face="Arial">COPYRIGHT NUNESTECH Tecnologia em Sistemas Ltda</font></td>
     </tr>
  </table>
</BODY>
</HTML>

