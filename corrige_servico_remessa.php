<?php
  session_start();

//carrega variaveis com dados para acessar o banco de dados

  $base_d     =$_SESSION['base_d'];
  $banco_d    =$_SESSION['banco_d'];
  $usuario_d  =$_SESSION['usuario_d'];
  $senha_d    =$_SESSION['senha_d'];

  $nome_m       =$_SESSION['nome_m'];
  $matricula_m  =$_SESSION['matricula_m'];
  $programa='73';
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
  include ("campo_calendario.php");

  function get_post_action($name)
   {
    $params = func_get_args();

    foreach ($params as $name) {
        if (isset($_POST[$name])) {
            return $name;
        }
    }
   }
?>

<title>corrige_servico_remessa.php</title>
  <head>
  </head>
  <body>
  <div id="geral" align="center">
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
         <p align="right"><font face="Arial" size="2" color="#FFFFFF"><b>Altera código serviço remessa</b></font></td>
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
  <?php
  
   switch (get_post_action('processa')) {
      case 'processa':

             // Seleciona movimento noperiodo informado
             $n_remessa   =$_POST['n_remessa'];
             $servico     =$_POST['servico'];

             $con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
             $res = mysql_select_db($banco_d) or die ("Banco de dados inexistente");

             $coleta="SELECT n_remessa,codi_cli,classe_cep,n_hawb
             FROM remessa
             WHERE n_remessa='$n_remessa'
             ORDER BY n_remessa,codi_cli,classe_cep";
             
             $query_1 = mysql_db_query($banco_d,$coleta,$con) or die ("Não foi possivel acessar o banco 1");
             $achou = mysql_num_rows($query_1);
             
             If ($achou == 0) {
                 ?>
                 <script language="javascript"> window.location.href=("corrige_servico_remessa.php")
                    alert('Não há movimento com o número da remessa informado! Verifique.');
                 </script>
                 <?php
             }
             else {
                 while($linha=mysql_fetch_array($query_1)) {

                      $remessa      = $linha['n_remessa'];
                      $cliente      = $linha['codi_cli'];
                      $classe_cep   = $linha['classe_cep'];
                      $n_hawb       = $linha['n_hawb'];

                      if ($linha['n_remessa']<>'' and $linha['codi_cli']<>'' and $servico<>'' and $linha['classe_cep']<>'' and $linha['classe_cep']<>'04')  {

                           $con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
                           $res = mysql_select_db($banco_d) or die ("Banco de dados inexistente");
                              

                           $pegava="SELECT valor FROM tabela_preco
                           WHERE ((codi_cli='$cliente') AND (tipo_servi='$servico') AND (classe_cep='$classe_cep'))";
                           $query_2 = mysql_db_query($banco_d,$pegava,$con) or die ("Não foi possivel acessar o banco 2");
                           $total = mysql_num_rows($query_2);

                           for($ic=0; $ic<$total; $ic++){
                                $row = mysql_fetch_row($query_2);
                                $valor        = $row[0];
                           }

                           $grava="UPDATE remessa SET tipo_servi='$servico', valor='$valor' WHERE n_hawb='$n_hawb'";
                           mysql_db_query($banco_d,$grava,$con);


                      }
                 }
                 
             }
             
      break;
      default:
      }

  ?>
  <body leftmargin="10" topmargin="10" marginwidth="10" marginheight="10">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
         <td color="white" align="left" width="100%" height="35">
      </tr>
    </table>
  <form name="cadastro" id="cadastro" action="corrige_servico_remessa.php" method="post">
	<table width="30%" border="1" cellpadding="5" cellspacing="0" bordercolor="#6495ED">
        <tr>
			<td><b>Número da Remessa :</b></td>
			<td><input name="n_remessa" type="text" value ="<?php echo "$n_remessa";?>" size="20" maxlength="20" id="n_remessa"></td>
		</tr>
		<tr>
           <td><b>Serviço :</b></td>
           <td>
              <?php
               mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
               mysql_select_db($banco_d) or die ("Banco de dados inexistente");

               ?>
               <select name="servico">
               <?php
                $sql3 = "SELECT codigo_se,descri_se
                FROM serv_ati";
                $resulo = mysql_db_query($banco_d,$sql3,$con) or die ("Não foi possivel acessar o banco");
                while ( $linha = mysql_fetch_array($resulo)) {
                    $select = $codigo_se == $linha[0] ? "selected" : "";
                    echo "<option value=\"". $linha[0] . "\" $select>". $linha[0] . " - " . $linha[1] . "</option>";
               }
              ?>
              </select>
            </td>
		</tr>
        <tr>
			<td>
				<div align="right">
				<input name="processa" type="submit" value="Processar">
				</div>
			</td>
		</tr>
	</table>
  </form>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="center" color="white" width="900" height="45" colspan="7" ><?php echo "$resp_grava";?></td>
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
