<?php
  session_start();

  //carrega variaveis com dados para acessar o banco de dados

  $base_d     =$_SESSION['base_d'];
  $banco_d    =$_SESSION['banco_d'];
  $usuario_d  =$_SESSION['usuario_d'];
  $senha_d    =$_SESSION['senha_d'];

  $matricula_m  =$_SESSION['matricula_m'];
  $programa='053';
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


  switch (get_post_action('gera','seleciona')) {

         case 'seleciona':
              $entregador               =$_POST['entregador'];
              $_SESSION['entregador_m'] =$entregador;
         break;
         case 'gera':
              $entregador   =$_POST['entregador'];
              $dt_inicio    =$_POST['data_ini'];
              $dt_fim       =$_POST['data_fim'];
              
              $_SESSION['dt_inicio_v'] =$dt_inicio;
              $_SESSION['dt_fim_v']    =$dt_fim;
              
              $dt_inicio   = explode("/",$dt_inicio);
              $v_dt_inicio = $dt_inicio[2]."-".$dt_inicio[1]."-".$dt_inicio[0];

              $dt_fim   = explode("/",$dt_fim);
              $v_dt_fim = $dt_fim[2]."-".$dt_fim[1]."-".$dt_fim[0];
              
              $_SESSION['dt_inicio_m']    =$v_dt_inicio;
              $_SESSION['dt_fim_m']       =$v_dt_fim;
              

              //Pega o nome do entregador

              $con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
              $res = mysql_select_db($banco_d) or die ("Banco de dados inexistente");

              $pega = "SELECT nome FROM cli_for WHERE cnpj_cpf='$entregador'";
              $query = mysql_db_query($banco_d,$pega,$con) or die ("Não foi possivel acessar o banco");
              $total = mysql_num_rows($query);
              for($ic=0; $ic<$total; $ic++){
                  $row = mysql_fetch_row($query);
                  $nome_entregador          = $row[0];
              }

              mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
              mysql_select_db($banco_d) or die ("Banco de dados inexistente");
              $contagem=mysql_query("SELECT COUNT(n_remessa) AS numero FROM remessa
              WHERE ((entregador='$entregador')
              AND (dt_remessa>='$v_dt_inicio')
              AND (dt_remessa<='$v_dt_fim'))");
              $total = mysql_num_rows($contagem);
              for($i=0; $i<$total; $i++){
                 $dados = mysql_fetch_row($contagem);
                 $numero      =$dados[0];
              }
              $_SESSION['numero_m']        =$numero;
              $_SESSION['nome_entrega_m']  =$nome_entregador;
              $_SESSION['entregador_m']    =$entregador;
              require_once("gera_relat_remessa_entregador.php");
              gera_relat_remessa_entregador();
           break;
         default:
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
 <TITLE>rela_remessa_entregador.php</TITLE>
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
         <p align="right"><font face="Arial" size="2" color="#FFFFFF"><b>Relatório Remessa Por Escritorio</b></font></td>
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
        <form name="cadastro" method="POST" action="rela_remessa_entregador.php" border="20">
          <tr>
           <td colspan="2">
			 <?php
              $adm_m        =$_SESSION['adm_m'];
              $estado_m     =$_SESSION['estado_m'];
              if ($adm_m=='N') {
                  echo "<center><Font size=\"2\" face=\"ARIAL\">Entregador..:</font>";
                  $entregador   =$_SESSION['entregador_m'];
                  mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
                  mysql_select_db($banco_d) or die ("Banco de dados inexistente");
                  ?>
                  <select name="entregador">
                  <?php
                   $resultado ="SELECT cnpj_cpf,nome FROM cli_for WHERE uf='$estado_m' and ativo='S'";
                   $resul = mysql_db_query($banco_d,$resultado,$con) or die ("Não foi possivel acessar o banco");
                   while ( $linha = mysql_fetch_array($resul)) {
                      $select = $entregador == $linha[0] ? "selected" : "";
                      echo "<option value=\"". $linha[0] . "\" $select>" . $linha[1] . "</option>";
                   }
                  ?>
                  </select>
                  <input name="seleciona" type="submit" value="Selecionar"></td>
              <?php
              }
              if ($adm_m=='S') {
                  echo "<center><Font size=\"2\" face=\"ARIAL\">Entregador..:</font>";
                  $entregador   =$_SESSION['entregador_m'];
                  mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
                  mysql_select_db($banco_d) or die ("Banco de dados inexistente");
                  ?>
                  <select name="entregador">
                  <?php
                   $resultado ="SELECT cnpj_cpf,nome FROM cli_for WHERE ativo='S'";
                   $resul = mysql_db_query($banco_d,$resultado,$con) or die ("Não foi possivel acessar o banco");
                   while ( $linha = mysql_fetch_array($resul)) {
                      $select = $entregador == $linha[0] ? "selected" : "";
                      echo "<option value=\"". $linha[0] . "\" $select>" . $linha[1] . "</option>";
                   }
                  ?>
                  </select>
                  <input name="seleciona" type="submit" value="Selecionar"></td>
              <?php
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
