<?php
  session_start();
  $base_d     =$_SESSION['base_d'];
  $banco_d    =$_SESSION['banco_d'];
  $usuario_d  =$_SESSION['usuario_d'];
  $senha_d    =$_SESSION['senha_d'];
  
  $matricula_m  =$_SESSION['matricula_m'];
  $programa='66';
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
  
  function get_post_action($name){
    $params = func_get_args();

    foreach ($params as $name) {
        if (isset($_POST[$name])) {
            return $name;
        }
    }
}
?>
<html>
  <title>verifica_contato.php</title>
  <head>
  <body>
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
  <body topmargin="0" leftmargin="0" rightmargin="0" bottommargin="0" marginheight="0" marginwidth="0" bgcolor="#FFFFFF">

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
         <p align="right"><font face="Arial" size="2" color="#FFFFFF"><b>Gerenciamento de Contatos</b></font></td>
     </tr>
   </table>
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
  <table width="700" heigth="300" align="center">
     <!--<tr>
       <td>-->
         <form method="POST" action="verifica_contato.php" border="20">
        <!-- <p><center><input type="radio" name="ver_1" value="1"><Font size="2" face="ARIAL"> Não lidas.</font>
         <input type="radio" name="ver_1" value="2"><Font size="2" face="ARIAL">Lidas.</font>
         <input type="submit" value="Seleciona"></center>
       </td>
     </tr>-->
     <tr>
       <td>
            <?php
               echo "<center><Font size=\"2\" face=\"ARIAL\">Selecione a mensagem:</font>";

               mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
               mysql_select_db($banco_d) or die ("Banco de dados inexistente");

               $resultado = mysql_query ("SELECT controle,nome,data,lido
               FROM contato");
               echo "<select name='contato' class='caixa' align=\"center\">\n";
               while($linha = mysql_fetch_row($resultado))  {
                  printf("<option value='$linha[0]'>$linha[0]-$linha[1]-$linha[2]- $linha[3] </option>\n");
               }
            ?>
              <input name="mostra" type="submit" value="Mostra"></center>
            </td>
           </tr>
         </form>
  </table>
  <?php

     switch (get_post_action('grava','mostra')) {
         case 'mostra':
             $controle             =$_POST['contato'];
             $_SESSION['controle'] =$_POST['contato'];
             $resp_grava='';
             $con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
             $res = mysql_select_db($banco_d) or die ("Banco de dados inexistente");

             $verifi="SELECT nome,empresa,negocio,telefone,
             ende_ele,conteudo,lido,date_format(data,'%d/%m/%Y') FROM contato WHERE controle='$controle'";
             $query = mysql_db_query($banco_d,$verifi,$con) or die ("Não foi possivel acessar o banco");
             $total = mysql_num_rows($query);

             for($ic=0; $ic<$total; $ic++){
               $mostra = mysql_fetch_row($query);

               $nome           = $mostra[0];
               $empresa        = $mostra[1];
               $negocio        = $mostra[2];
               $telefone       = $mostra[3];
               $ende_ele       = $mostra[4];
               $conteudo       = $mostra[5];
               $lido           = $mostra[6];
               $data           = $mostra[7];
             }
             break;

         case 'grava':

             $lido        =$_POST['lido'];
             $controle    =$_SESSION['controle'];
             
             $con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
             $res = mysql_select_db($banco_d) or die ("Banco de dados inexistente");

             $alteracao = "UPDATE contato SET lido='$lido'
             WHERE controle='$controle'";

             if (mysql_db_query("action",$alteracao,$con)) {
                $resp_grava="Alteração bem sucedida";
                ?>
                  <script language="JavaScript">document.cadastro.reset();</script>
                <?php
             }
             else {
                $resp_grava="Problemas na Alteração";
                ?>
                  <script language="JavaScript">document.cadastro.reset();</script>
                <?php
             }
            break;
         default:
     }
  ?>

  <body leftmargin="10" topmargin="10" marginwidth="10" marginheight="10" align="center">
  <form name="verifica" action="verifica_contato.php" method="post">
   <div align="center">
	<table width="50%" border="1" cellpadding="5" cellspacing="0" bordercolor="#4169E1">
		<tr>
			<td><b>Nome :</b></td>
			<td><?php echo "$nome"; ?></td>
		</tr>
		<tr>
			<td><b>Empresa :</b></td>
			<td><?php echo "$empresa";?></td>
		</tr>
		<tr>
		   <td><b>Negócio da Empresa :</b></td>
		   <td>
             <TEXTAREA readonly NAME="objetivo" rows="4" cols="70"><?php echo "$negocio";?></TEXTAREA>
           </td>
        </tr>
		<tr>
			<td><b>Telefones :</b></td>
			<td><?php echo "$telefone";?></td>
		</tr>
		<tr>
			<td><b>Email :</b></td>
			<td><?php echo "$ende_ele";?></td>
		</tr>
        <tr>
		   <td><b>Mensagem :</b></td>
		   <td>
             <TEXTAREA readonly NAME="conteudo" rows="8" cols="70"><?php echo "$conteudo";?></TEXTAREA>
           </td>
        </tr>
		<tr>
			<td><b>Mensagem Lida(S/N) :</b></td>
			<td><input type="text" id="lido" name="lido" value ="<?php echo "$lido";?>" size="1" maxlength="1"></td>
		</tr>
		<tr>
			<td><b>Data da Mensagem :</b></td>
			<td><?php echo "$data";?></td>
		</tr>
		<tr>
			<td colspan="2">
				<div align="right">
				<input name="grava" type="submit" value="Gravar">
				</div>
			</td>
		</tr>
	</table>
  </div>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td color="white" align="center" width="900" height="45" colspan="8" ><?php echo "$resp_grava";?></td>
      </tr>
  </table>
  <table width="100%"  border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td background="img/blue.jpg" align="left" width="100%" height="45px"><center><font face="arial" size="1" color="white">Todos Direitos Reservados a NUNESTEC Tecnologia</font></td>
    </tr>
  </table>

</body>
</html>

