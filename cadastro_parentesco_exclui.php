<?php  session_start(); //carrega variaveis com dados para acessar o banco de dados   Include('conexao_free.php');  mysqli_set_charset($con,'UTF8');     //verifica se o usuário esta habilitado para usar a rotina   $matricula_m  =$_SESSION['matricula_m'];  $programa='122';  $_SESSION['programa_m']=$programa;    $confere = "SELECT matricula,programa  FROM permissoes  WHERE ((matricula='$matricula_m') and (programa='$programa'))";  $query = mysqli_query($con,$confere) or die ("Não foi possivel acessar o banco - Rotina Cadastro Destinos");  $achou = mysqli_num_rows($query);  If ($achou == 0 ) {       ?>          <script language="javascript"> window.location.href=("entrada.php")            alert('Você não está autorizado a acessar esta rotina.');          </script>       <?php  }  else {	    	$codigo           ='';    $descricao        ='';       $resp_grava='';	  }     function get_post_action($name){     $params = func_get_args();     foreach ($params as $name) {        if (isset($_POST[$name])) {            return $name;        }     }  }?><html>  <title>Cadastro_parentesco_exclui.php</title>  <head>  <body>   <style>		body, p, div, td, input, select, textarea {			font-family: verdana,arial,helvetica;			font-size:12px;			color:#000000;			text-decoration: none;		}		input,textarea {			@if (is.ie) {				color: #efefef; background-color:#F0F8FF; border: 1px solid #6495ED ;				/*border-top-width: 1px; border-right-width: 1px; border-bottom-width: 1px; border-left-width: 1px; */			}		}		textarea { overflow:auto }	</style>  </head>  <div id="geral" align="center">    <body topmargin="0" leftmargin="0" rightmargin="0" bottommargin="0" marginheight="0" marginwidth="0" bgcolor="#FFFFFF">     <table border="0" width="100%" bgcolor="#000000" cellspacing="0" cellpadding="0">      <tr>        <td width="20%" height="100" background="img/topleft.jpg"></td>        <td width="658" height="110"> <img border="0" src="img/cabecalho_free_jazz.jpg" width="658" height="110" border="0"></td>        <td width="15%" height="110">        <p align="right"><img border="0" src="img/topright.jpg" width="160" height="110" border="0"></td>     </tr>    </table>    <table border="0" width="100%" cellspacing="0" cellpadding="0" background="img/blue.jpg">     <tr>       <td width="50%">         <p align="left"><font face="Arial" size="2" color="#FFFFFF"><b>Sistema de Gerenciamento da Logística de Encomendas</b></font></td>       <td width="50%">         <p align="right"><font face="Arial" size="2" color="#FFFFFF"><b>Cadastro Parentesco - Alteração</b></font></td>     </tr>   <table width="100%" border="0" cellspacing="0" cellpadding="0">       <tr>         <td colspan="1" align="left" width="45%"><INPUT type=button size="3" value="Ajuda"               onClick="window.open('mostra_ajuda.php','janela_1',               'scrollbars=yes,resizable=yes,width=400,height=700');" style="width:100;height:30;color=red;font: bold 16px Arial;">         </td>         <td colspan="1" color="white" align="right" width="45%" height="70"><a href="entrada.php"><img src="img/porta.gif" border="none"></td>       </tr>   </table>  <table width="80%" heigth="300" align="center">     <tr>       <td>         <form method="POST" action="cadastro_parentesco_exclui.php" border="20">            <?php               echo "<center><Font size=\"2\" face=\"ARIAL\">Selecione Parentesco..:</font>";                              $resultado = mysqli_query ($con,"SELECT codigo,descricao FROM parentesco");               echo "<select name='codigo' class='caixa' align=\"center\">\n";               while($linha = mysqli_fetch_row($resultado))  {                  printf("<option value='$linha[0]'>$linha[0] - $linha[1] </option>\n");               }            ?>              <input name="mostra" type="submit" value="Mostra"></center>            </td>           </tr>         </form>   </table>  <?php     switch (get_post_action('exclui','mostra')) {         case 'mostra':             $codigo                =$_POST['codigo'];             $_SESSION['codigo_m']  =$_POST['codigo'];                          $verifi="SELECT codigo,descricao             FROM parentesco WHERE codigo ='$codigo'";             $query = mysqli_query($con,$verifi) or die ("Não foi possivel acessar o banco");             $total = mysqli_num_rows($query);             for($ic=0; $ic<$total; $ic++){               $row = mysqli_fetch_row($query);               $codigo          = $row[0];               $descricao       = $row[1];             }             break;         case 'exclui':               $codigo              =$_SESSION['codigo_m'];               $descricao           =$_POST['descricao'];			   			   //verifica se tem movimento com este parentesco			   $consulta = "SELECT parentesco FROM remessa WHERE parentesco='$codigo'";               $query = mysqli_query($con,$consulta) or die ("Não foi possivel acessar o banco");               $total = mysqli_num_rows($query);               if($total == 0) {                                 $exclusao = "DELETE FROM parentesco WHERE codigo='$codigo'";                               if (mysqli_query($con,$exclusao)) {                     $resp_grava="Esclusão bem sucedida";                  }                  else {                     $resp_grava="Problemas na Esclusão";                  }				  $codigo                 = '';                  $descricao              = '';			   }			   else {				 ?>                 <script language="javascript"> window.location.href=("cadastro_servicos_exclui.php")                     alert('Existem movimentos com esta codigo Parentesco. Para exclui-lo, exclua primeiro os respectivos movimentos.');                 </script>                 <?php    			 }         break;         default:     }  ?>  <body leftmargin="10" topmargin="10" marginwidth="10" marginheight="10">  <form name="cadastro" action="cadastro_parentesco_altera.php" method="post">  <table width="50%" border="1" cellpadding="5" cellspacing="0" bordercolor="#6495ED">		<tr>			<td><b>Codigo :</b></td>			<td><?php echo "$codigo"; ?></td>		</tr>		<tr>			<td><b>Descricao da Função :</b></td>			<td><input type="text" id="descricao" name="descricao" value ="<?php echo "$descricao";?>" size="50" maxlength="50"></td>		</tr>        <tr>            <td><INPUT type=button value="Parentescos Cadastrados"               onClick="window.open('mostra_parentesco_cadastrado.php','janela_1',               'scrollbars=yes,resizable=yes,width=600,height=400');">            </td>			<td>				<div align="right">				<input name="exclui" type="submit" value="Excluir">				</div>			</td>		</tr>	</table>	</form>    <table width="100%" border="0" cellspacing="0" cellpadding="0">      <tr>        <td color="white" align="center" width="900" height="45" colspan="8" ><?php echo "$resp_grava";?></td>      </tr>    </table>    <table width="100%" border="0" cellspacing="0" cellpadding="0">     <tr>       <td color="white" align="left" width="100%" height="30">     </tr>    </table>    <table border="0" width="100%" cellspacing="0" cellpadding="0" background="img/blue.jpg">      <tr>        <td width="100%" height="25" align="center"></font><font color="white" size="1" face="Arial">COPYRIGHT NUNESTECH Tecnologia em Sistemas Ltda</font></td>     </tr>    </table>  </div></body></html>