<?php  session_start();  //carrega variaveis com dados para acessar o banco de dados   Include('conexao_free.php');  mysqli_set_charset($con,'UTF8');     //verifica se o usuário esta habilitado para usar a rotina   $matricula_m  =$_SESSION['matricula_m'];  $programa='011';  $_SESSION['programa_m']=$programa;    $confere = "SELECT matricula,programa  FROM permissoes  WHERE ((matricula='$matricula_m') and (programa='$programa'))";  $query = mysqli_query($con,$confere) or die ("Não foi possivel acessar o banco - Rotina Cadastro Destinos");  $achou = mysqli_num_rows($query);  If ($achou == 0 ) {       ?>          <script language="javascript"> window.location.href=("entrada.php")            alert('Você não está autorizado a acessar esta rotina.');          </script>       <?php  }  else {	    	$codigo_se       ='';    $descri_se       ='';    $unidade         ='';	$codigo_wihus    ='';        $resp_grava='';	  }   ?><html>  <title>Cadastro_Servicos.php</title>  <head>  </head>  <body>  <div id="geral" align="center">    <body topmargin="0" leftmargin="0" rightmargin="0" bottommargin="0" marginheight="0" marginwidth="0" bgcolor="#FFFFFF">     <table border="0" width="100%" bgcolor="#000000" cellspacing="0" cellpadding="0">      <tr>        <td width="20%" height="100" background="img/topleft.jpg"></td>         <td width="658" height="110"> <img border="0" src="img/cabecalho_free_jazz.jpg" width="890" height="115" border="0"></td>        <td width="15%" height="110">        <p align="right"><img border="0" src="img/topright.jpg" width="160" height="110" border="0"></td>     </tr>    </table>    <table border="0" width="100%" cellspacing="0" cellpadding="0" background="img/blue.jpg">     <tr>       <td width="50%">         <p align="left"><font face="Arial" size="2" color="#FFFFFF"><b>Sistema de Gerenciamento da Logística de Encomendas</b></font></td>       <td width="50%">         <p align="right"><font face="Arial" size="2" color="#FFFFFF"><b>Cadastro de Serviços - Inclusão</b></font></td>     </tr>   </table>   </table>   <table width="100%" border="0" cellspacing="0" cellpadding="0">       <tr>         <td colspan="1" align="left" width="45%"><INPUT type=button size="3" value="Ajuda"               onClick="window.open('mostra_ajuda.php','janela_1',               'scrollbars=yes,resizable=yes,width=400,height=700');" style="width:100;height:30;color=red;font: bold 16px Arial;">         </td>         <td colspan="1" color="white" align="right" width="45%" height="70"><a href="entrada.php"><img src="img/porta.gif" border="none"></td>       </tr>   </table>  <?php    $resp_grava='';    if (isset($_POST['codigo_se'])) {        $codigo_se       =$_POST['codigo_se'];                //Acrecentando zero a esquerda do numero        $codigo_se = sprintf("%04d", $codigo_se);                $descri_se       =$_POST['descri_se'];        $unidade         =$_POST['unidade'];        $codigo_wihus    =$_POST['codigo_wihus'];		        $verifi="SELECT codigo_se FROM serv_ati WHERE codigo_se='$codigo_se'";        $query = mysqli_query($con,$verifi) or die ("Não foi possivel acessar o banco");        $achou = mysqli_num_rows($query);        If ($achou > 0 ) {        ?>        <script language="javascript"> window.location.href=("entrada.php")            alert('Já existe serviço cadastrado com o codigo informado.');        </script>        <?php        }        else {          $inclusao = "INSERT INTO serv_ati (codigo_se,descri_se,unidade,codigo_wihus)          values('$codigo_se','$descri_se','$unidade','$codigo_wihus')";          if (mysqli_query($con,$inclusao)) {             $resp_grava="Inclusão bem sucedida";            }           else {             $resp_grava="Problemas na Inclusão";           }		   $codigo_se       ='';           $descri_se       ='';           $unidade         ='';           $codigo_wihus    ='';        }    }  ?>  <style>		body, p, div, td, input, select, textarea {			font-family: verdana,arial,helvetica;			font-size:12px;			color:#000000;			text-decoration: none;		}		input,textarea {			@if (is.ie) {				color: #efefef; background-color:#F0F8FF; border: 1px solid #6495ED ;				/*border-top-width: 1px; border-right-width: 1px; border-bottom-width: 1px; border-left-width: 1px; */			}		}		textarea { overflow:auto }	</style>  </head>  <body leftmargin="10" topmargin="10" marginwidth="10" marginheight="10">  <table width="100%" border="0" cellspacing="0" cellpadding="0">      <tr>         <td color="white" align="left" width="100%" height="35">      </tr>    </table>  <form name="cadastro" id="cadastro" action="cadastro_servicos.php" method="post">	<table width="50%" border="1" cellpadding="5" cellspacing="0" bordercolor="#4169E1">		<tr>			<td><b>Codigo do serviço :</b></td>			<td><input type="text" name="codigo_se" size="4" maxlength="4" id="codigo_se"></td>		</tr>		<tr>			<td><b>Descrição do serviço :</b></td>			<td><input type="text" name="descri_se" size="50" maxlength="50" id="descri_se"></td>		</tr>		<tr>			<td><b>Unidade :</b></td>			<td><input type="text" name="unidade" size="10" maxlength="10" id="unidade"></td>		</tr>		<tr>			<td><b>Codigo Wihus :</b></td>			<td><input type="text" name="codigo_wihus" size="4" maxlength="4" id="codigo_wihus"></td>		</tr>		<tr>            <td><INPUT type=button value="Serviços Cadastrados"               onClick="window.open('mostra_servicos_cadastrados.php','janela_1',               'scrollbars=yes,resizable=yes,width=600,height=400');">            </td>			<td colspan="2">				<div align="right">				<input name="grava" type="submit" value="Gravar">				</div>			</td>		</tr>	</table>	 </form>	<table width="100%" border="0" cellspacing="0" cellpadding="0">      <tr>        <td color="white" align="center" width="900" height="45" colspan="8" ><?php echo "$resp_grava";?></td>      </tr>    </table>    <table width="100%" border="0" cellspacing="0" cellpadding="0">      <tr>         <td color="white" align="left" width="100%" height="150">      </tr>    </table>    <table border="0" width="100%" cellspacing="0" cellpadding="0" background="img/blue.jpg">      <tr>        <td width="100%" height="25" align="center"></font><font color="#000000" size="1" face="Arial">COPYRIGHT NUNESTECH Tecnologia em Sistemas Ltda</font></td>     </tr></table> </div></body></html>