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
    include("campo_calendario.php");
    
    switch (get_post_action('grava')) {

         case 'grava':
              $dt_inicio   =$_POST['data_ini'];
              $dt_fim      =$_POST['data_fim'];
              
              //Altera formato de data para comparação
              $dt_inicio  = explode("/",$dt_inicio);
              $v_dt_inicio = $dt_inicio[2]."-".$dt_inicio[1]."-".$dt_inicio[0];

              $dt_fim  = explode("/",$dt_fim);
              $v_dt_fim = $dt_fim[2]."-".$dt_fim[1]."-".$dt_fim[0];

              //abre conexão com o banco
              $con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
              $res = mysql_select_db($banco_d) or die ("Banco de dados inexistente");

              $coleta = "SELECT controle,cep_desti,estado_desti FROM remessa
              WHERE dt_remessa>='$v_dt_inicio' AND dt_remessa<='$v_dt_fim'";
              $query = mysql_db_query($banco_d,$coleta,$con) or die ("Não foi possivel acessar o banco 2");
              $total = mysql_num_rows($query);
              $conta=0;
              while($linha=mysql_fetch_array($query)) {
                   $raiz_cep       =Substr($linha['cep_desti'],0,5);
                   $controle       =$linha['controle'];
                   $estado         =$linha['estado_desti'];
                   //abre tabela classe de cep
                   $pega_cep = "SELECT codigo,cep_inicio,cep_fim,escritorio FROM classe_cep";
                   $query_1 = mysql_db_query($banco_d,$pega_cep,$con) or die ("Não foi possivel acessar o banco 2");
                   $total = mysql_num_rows($query_1);
                   while ($row = mysql_fetch_array($query_1)) {
                       $codigo_cla     = $row['codigo'];
                       $cep_ini        = $row['cep_inicio'];
                       $cep_fi         = $row['cep_fim'];
                       $escritorio     = $row['escritorio'];
                       if (((int)$raiz_cep>=(int)$cep_ini) and ((int)$raiz_cep<=(int)$cep_fi)) {
                          $classe_cep = $codigo_cla;
                          $base       = $escritorio;
                          echo "<p>Base :$base";
                          break;
                       }
                       else {
                          $classe_cep = '';
                          If ($estado=='SC') {
                             $base='001';
                          }
                          else {
                             $base='002';
                          }
                       }
                   }
                   if ($classe_cep<>'') {
                      $alteracao = "UPDATE remessa SET classe_cep='$classe_cep',escritorio='$base'
                      WHERE controle='$controle'";
                      if (mysql_db_query($banco_d,$alteracao,$con)) {
                         $conta=$conta+1;
                      }
                   }
                   else {
                      $alteracao = "UPDATE remessa SET classe_cep='03',escritorio='$base'
                      WHERE controle='$controle'";
                      if (mysql_db_query($banco_d,$alteracao,$con)) {
                         $conta=$conta+1;
                      }
                   }
              }
              $resp_grava="Foram alterados :".$conta." Registros";
           break;
         default:
    }

  //carrega variaveis com dados para acessar o banco de dados
  
  $matricula_m            =$_SESSION['matricula_m'];
  $programa='100';
  $_SESSION['programa_m'] =$programa;


  $con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
  $res = mysql_select_db($banco_d) or die ("Banco de dados inexistente");

  $declara = "SELECT matricula,programa
  FROM permissoes
  WHERE ((matricula='$matricula_m') and (programa='$programa'))";

  $query = mysql_db_query($banco_d,$declara,$con) or die ("Não foi possivel acessar o banco");
  $achou = mysql_num_rows($query);

  If ($achou == 0 ) {
       ?>
        <!--  <script language="javascript"> window.location.href=("entrada.php")
            alert('Você não está autorizado a acessar esta rotina.');
          </script> -->
       <?php
  }

?>

<HTML>
<HEAD>
 <TITLE>corrige_base_movimento.php</TITLE>
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
         <p align="right"><font face="Arial" size="2" color="#FFFFFF"><b>Corrige Base Movimento</b></font></td>
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
   <table width="50%" border="1" cellpadding="5" cellspacing="0" bordercolor="#6495ED" align="center">
        <form name="cadastro" method="POST" action="corrige_base_movimento.php" border="20">
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
          <tr>
			<td colspan="2">
				<div align="right">
				<input name="grava" type="submit" value="Gravar">
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
