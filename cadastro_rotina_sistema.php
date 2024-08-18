<?php
  session_start();

 //carrega variaveis com dados para acessar o banco de dados

  $base_d     =$_SESSION['base_d'];
  $banco_d    =$_SESSION['banco_d'];
  $usuario_d  =$_SESSION['usuario_d'];
  $senha_d    =$_SESSION['senha_d'];

  $matricula_m  =$_SESSION['matricula_m'];

  If ($matricula_m <>'15033' ) {
       ?>
          <script language="javascript"> window.location.href=("entrada.php")
            alert('Você não está autorizado a acessar esta rotina.');
          </script>
       <?php
   }
?>
<html>
  <title>cadastro_rotina_sistema.php</title>
  <head>
  </head>
  <body>
  <div id="geral" align="center">
    <body topmargin="0" leftmargin="0" rightmargin="0" bottommargin="0" marginheight="0" marginwidth="0" bgcolor="#FFFFFF">

     <table border="0" width="100%" bgcolor="#000000" cellspacing="0" cellpadding="0">
      <tr>
        <td width="20%" height="100" background="img/topleft.jpg"></td>
        <td width="658" height="110"> <img border="0" src="img/cabecalho_free_jazz.jpg" width="658" height="110" border="0"></td>
        <td width="15%" height="110">
        <p align="right"><img border="0" src="img/topright.jpg" width="160" height="110" border="0"></td>
     </tr>
    </table>
    <table border="0" width="100%" cellspacing="0" cellpadding="0" background="img/blue.jpg">
     <tr>
       <td width="50%">
         <p align="left"><font face="Arial" size="2" color="#FFFFFF"><b>Sistema de Gerenciamento da Logística de Encomendas</b></font></td>
       <td width="50%">
         <p align="right"><font face="Arial" size="2" color="#FFFFFF"><b>Cadastro de Rotinas do Sistema - Inclusão</b></font></td>
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
  <?php
    $resp_grava='';
    if (isset($_POST['programa'])) {
        $programa            =$_POST['programa'];
        $nome_programa       =$_POST['nome_programa'];

        $programa = sprintf("%03d", $programa);
        
        $con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
        $res = mysql_select_db($banco_d) or die ("Banco de dados inexistente");

        $verifi="SELECT programa FROM cad_rotinas WHERE programa='$programa'";
        $query = mysql_db_query($banco_d,$verifi,$con) or die ("Não foi possivel acessar o banco");
        $achou = mysql_num_rows($query);

        If ($achou > 0 ) {
        ?>
        <script language="javascript"> window.location.href=("entrada.php")
            alert('Já existe rotina cadastrada com o codigo informado.');
        </script>
        <?php
        }
        else {
          $inclusao = "INSERT INTO cad_rotinas (programa,nome_programa)
          values('$programa','$nome_programa')";

          if (mysql_db_query($banco_d,$inclusao,$con)) {
             $resp_grava="Inclusão bem sucedida";
             $programa           ='';
             $nome_programa      ='';
            }
           else {
             $resp_grava="Problemas na Inclusão";
           }
        }
       mysql_close ($con);
    }

  ?>
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
  </head>
  <body leftmargin="10" topmargin="10" marginwidth="10" marginheight="10">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
         <td color="white" align="left" width="100%" height="35">
      </tr>
    </table>
  <form name="cadastro" id="cadastro" action="cadastro_rotina_sistema.php" method="post">
	<table width="50%" border="1" cellpadding="5" cellspacing="0" bordercolor="#6495ED">
		<tr>
			<td><b>Codigo Programa:</b></td>
			<td><input type="text" name="programa" size="3" maxlength="3" id="programa"></td>
		</tr>
		<tr>
			<td><b>Nome Programa :</b></td>
			<td><input type="text" name="nome_programa" size="70" maxlength="70" id="nome_programa"></td>
		</tr>
        <tr>
            <td><INPUT type=button value="Rotinas Cadastradas"
               onClick="window.open('mostra_rotinas_cadastradas.php','janela_1',
               'scrollbars=yes,resizable=yes,width=600,height=400');">
            </td>
			<td>
				<div align="right">
				<input name="grava" type="submit" value="Gravar">
				</div>
			</td>
		</tr>
	</table>
	 </form>
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
        <td width="100%" height="25" align="center"></font><font color="#000000" size="1" face="Arial">©&nbsp; COPYRIGHT NUNESTECH Tecnologia em Sistemas Ltda</font></td>
     </tr>
   </table>
 </div>
</body>
</html>

