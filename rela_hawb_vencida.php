<?php
  session_start();
    $base_d     =$_SESSION['base_d'];
    $banco_d    =$_SESSION['banco_d'];
    $usuario_d  =$_SESSION['usuario_d'];
    $senha_d    =$_SESSION['senha_d'];
    
    $data                    =date("d/m/Y");
    $_SESSION['dt_hoje_m']   =$data;
    
    $depto_m   =$_SESSION['depto_m'];
    $adm_m     =$_SESSION['adm_m'];
    
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
              $data_ini   =$_POST['data_ini'];
              $data_fim   =$_POST['data_fim'];
              $escritorio =$_POST['escritorio'];
              
              
              $_SESSION['escritorio_m']   =$escritorio;
              $_SESSION['dt_inicio_v']    =$data_ini;
              $_SESSION['dt_fim_v']       =$data_fim;

              $data_ini   = explode("/",$data_ini);
              $v_data_ini = $data_ini[2]."-".$data_ini[1]."-".$data_ini[0];

              $data_fim   = explode("/",$data_fim);
              $v_data_fim = $data_fim[2]."-".$data_fim[1]."-".$data_fim[0];

              $_SESSION['data_ini_m']    =$v_data_ini;
              $_SESSION['data_fim_m']    =$v_data_fim;
              
              //Pega o nome do escritorio
              $con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
              $res = mysql_select_db($banco_d) or die ("Banco de dados inexistente");

              $local = "SELECT nome FROM regi_dep WHERE codigo='$escritorio'";
              $query_c = mysql_db_query($banco_d,$local,$con) or die ("Não foi possivel acessar o banco");
              $total = mysql_num_rows($query_c);
              for($ic=0; $ic<$total; $ic++){
                  $row = mysql_fetch_row($query_c);
                  $nome_escrito          = $row[0];
              }
              $_SESSION['nome_escrito_m']   =$nome_escrito;
              
              $v_soma=0;
              
              //Altera formato de data para comparação
              $dt_hoje  = explode("/",$data);
              $v_dt_hoje = $dt_hoje[2]."-".$dt_hoje[1]."-".$dt_hoje[0];
              $v_hoje=mktime(0,0,0,(substr($v_dt_hoje,5,2)),(substr($v_dt_hoje,8,2)),(substr($v_dt_hoje,0,4)));
              $_SESSION['v_hoje_m']    =$v_hoje;

              //Seleciona todos os  regfistros para contagem

              $con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
              $res = mysql_select_db($banco_d) or die ("Banco de dados inexistente");
              $result = mysql_query("SELECT dt_remessa
              FROM remessa
              WHERE ((dt_envio='0000-00-00')
              and (dt_remessa>='$v_data_ini')
              and (dt_remessa<='$v_data_fim')
              AND (escritorio='$escritorio'))");

              while ($row = mysql_fetch_array($result) ) {
                 $dt_remessa=mktime(0,0,0,(substr($row['dt_remessa'],5,2)),(substr($row['dt_remessa'],8,2)),(substr($row['dt_remessa'],0,4)));
                 $segundos = ($v_hoje-$dt_remessa);
                 $horas = round(($segundos/60/60));
                 if ($horas>='48') {
                   $v_soma=$v_soma+1;
                 }
              }
              //Formata o número no padrão xx.xxx,xx para mostrar
              $_SESSION['v_soma_m']     =$v_soma;
              require_once("gera_hawb_vencida.php");
              gera_hawb_vencida();
           break;
         default:
    }

  //carrega variaveis com dados para acessar o banco de dados
  
  $matricula_m  =$_SESSION['matricula_m'];
  $programa='050';
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


  include("campo_calendario.php");
?>

<HTML>
<HEAD>
 <TITLE>rela_hawb_vencida.php</TITLE>
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
         <p align="right"><font face="Arial" size="2" color="#FFFFFF"><b>Mostra HAWb´s Vencidas</b></font></td>
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
   <table width="40%" border="1" cellpadding="5" cellspacing="0" bordercolor="#6495ED">
        <form name="cadastro" method="POST" action="rela_hawb_vencida.php" border="20">
        <tr>
           <td><b>Data de hoje :</b></td>
           <td>
             <?php echo "$data";?>
           </td>
        </tr>
        <tr>
           <td><b>Escritorio :</b></td>
           <td>
              <?php

               mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
               mysql_select_db($banco_d) or die ("Banco de dados inexistente");

               ?>
              <select name="escritorio">
              <?php
              $sql_1 = "SELECT codigo,nome FROM regi_dep ORDER BY nome";
              $resultado_1 = mysql_db_query($banco_d,$sql_1,$con) or die ("Não foi possivel acessar o banco");
              while ( $linha = mysql_fetch_array($resultado_1)) {
                    $select = $escritorio == $linha[0] ? "selected" : "";
                    echo "<option value=\"". $linha[0] . "\" $select>" . $linha[1] . "</option>";
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
        <td width="100%" height="25" align="center"></font><font color="white" size="1" face="Arial">©&nbsp; COPYRIGHT NUNESTECH Tecnologia em Sistemas Ltda</font></td>
     </tr>
  </table>
</BODY>
</HTML>
