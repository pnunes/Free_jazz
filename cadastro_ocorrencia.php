<?php  session_start();  //carrega variaveis com dados para acessar o banco de dados   Include('conexao_free.php');  mysqli_set_charset($con,'UTF8');     //verifica se o usuário esta habilitado para usar a rotina   $matricula_m  =$_SESSION['matricula_m'];  $programa='015';  $_SESSION['programa_m']=$programa;    $confere = "SELECT matricula,programa  FROM permissoes  WHERE ((matricula='$matricula_m') and (programa='$programa'))";  $query = mysqli_query($con,$confere) or die ("Não foi possivel acessar o banco - Rotina Cadastro Destinos");  $achou = mysqli_num_rows($query);  If ($achou == 0 ) {       ?>          <script language="javascript"> window.location.href=("entrada.php")            alert('Você não está autorizado a acessar esta rotina.');          </script>       <?php  }  else {	    	$codigo           ='';    $descricao        ='';    $volta_lista      ='';      $resp_grava='';	  }   ?><html>  <title>Cadastro_ocorrencias.php</title>  <head>  </head>  <body>  <div id="geral" align="center">    <body topmargin="0" leftmargin="0" rightmargin="0" bottommargin="0" marginheight="0" marginwidth="0" bgcolor="#FFFFFF">     <table border="0" width="100%" bgcolor="#000000" cellspacing="0" cellpadding="0">      <tr>        <td width="20%" height="100" background="img/topleft.jpg"></td>        <td width="658" height="110"> <img border="0" src="img/cabecalho_free_jazz.jpg" width="658" height="110" border="0"></td>        <td width="15%" height="110">        <p align="right"><img border="0" src="img/topright.jpg" width="160" height="110" border="0"></td>     </tr>    </table>    <table border="0" width="100%" cellspacing="0" cellpadding="0" background="img/blue.jpg">     <tr>       <td width="50%">         <p align="left"><font face="Arial" size="2" color="#FFFFFF"><b>Sistema de Gerenciamento da Logística de Encomendas</b></font></td>       <td width="50%">         <p align="right"><font face="Arial" size="2" color="#FFFFFF"><b>Cadastro de Ocorrências - Inclusão</b></font></td>     </tr>   </table>   <table width="100%" border="0" cellspacing="0" cellpadding="0">       <tr>         <td colspan="1" align="left" width="45%"><INPUT type=button size="3" value="Ajuda"               onClick="window.open('mostra_ajuda.php','janela_1',               'scrollbars=yes,resizable=yes,width=400,height=700');" style="width:100;height:30;color=red;font: bold 16px Arial;">         </td>         <td colspan="1" color="white" align="right" width="45%" height="70"><a href="entrada.php"><img src="img/porta.gif" border="none"></td>       </tr>   </table>  <?php    $resp_grava='';    if (isset($_POST['codigo'])) {        $codigo            =$_POST['codigo'];        $descricao         =$_POST['descricao'];        $volta_lista       =$_POST['volta_lista'];		        $volta_lista      =Strtoupper($volta_lista);                $codigo = sprintf("%02d", $codigo);                $verifi="SELECT codigo FROM ocorrencia WHERE codigo='$codigo'";        $query = mysqli_query($con,$verifi) or die ("Não foi possivel acessar o banco");        $achou = mysqli_num_rows($query);        If ($achou > 0 ) {        ?>        <script language="javascript"> window.location.href=("cadastro_ocorrencia.php")            alert('Já existe ocorrencia cadastrada com o codigo informado.');        </script>        <?php        }        else {          $inclusao = "INSERT INTO ocorrencia (codigo, descricao,volta_lista)          values('$codigo','$descricao','$volta_lista')";          if (mysqli_query($con,$inclusao) or die ("Não foi possivel usar a tabela pessoa: ".mysqli_errno($con)." - ".mysqli_error($con))) {             $resp_grava="Inclusão bem sucedida";            }            else {             $resp_grava="Problemas na Inclusão";            }		    $codigo           ='';            $descricao        ='';            $volta_lista      ='';        }           }  ?>  <style>		body, p, div, td, input, select, textarea {			font-family: verdana,arial,helvetica;			font-size:12px;			color:#000000;			text-decoration: none;		}		input,textarea {			@if (is.ie) {				color: #efefef; background-color:#F0F8FF; border: 1px solid #6495ED ;				/*border-top-width: 1px; border-right-width: 1px; border-bottom-width: 1px; border-left-width: 1px; */			}		}		textarea { overflow:auto }	</style>  </head>  <body leftmargin="10" topmargin="10" marginwidth="10" marginheight="10">  <table width="100%" border="0" cellspacing="0" cellpadding="0">      <tr>         <td color="white" align="left" width="100%" height="35">      </tr>    </table>  <form name="cadastro" id="cadastro" action="cadastro_ocorrencia.php" method="post">	<table width="50%" border="1" cellpadding="5" cellspacing="0" bordercolor="#6495ED">		<tr>			<td><b>Codigo :</b></td>			<td><input type="text" name="codigo" size="2" maxlength="2" id="codigo"></td>		</tr>		<tr>			<td><b>Descrição :</b></td>			<td><input type="text" name="descricao" size="50" maxlength="50" id="descricao"></td>		</tr>		<tr>			<td><b>Baixar sem entrega(S/N) :</b></td>			<td><input type="text" name="volta_lista" size="1" maxlength="1" id="volta_lista"></td>		</tr>        <tr>            <td><INPUT type=button value="Ocorrências Cadastradas"               onClick="window.open('mostra_ocorrencias_cadastradas.php','janela_1',               'scrollbars=yes,resizable=yes,width=600,height=400');">            </td>			<td>				<div align="right">				<input name="grava" type="submit" value="Gravar">				</div>			</td>		</tr>	</table>	 </form>	<table width="100%" border="0" cellspacing="0" cellpadding="0">      <tr>        <td color="white" align="center" width="900" height="45" colspan="8" ><?php echo "$resp_grava";?></td>      </tr>    </table>    <table width="100%" border="0" cellspacing="0" cellpadding="0">      <tr>         <td color="white" align="left" width="100%" height="30">      </tr>    </table>    <table border="0" width="100%" cellspacing="0" cellpadding="0" background="img/blue.jpg">      <tr>        <td width="100%" height="25" align="center"></font><font color="#000000" size="1" face="Arial">COPYRIGHT NUNESTECH Tecnologia em Sistemas Ltda</font></td>     </tr>   </table> </div></body></html>