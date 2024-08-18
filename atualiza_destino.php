<?php
  session_start();

//carrega variaveis com dados para acessar o banco de dados


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

<title>faturamento.php</title>
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
         <p align="right"><font face="Arial" size="2" color="#FFFFFF"><b>Gera Faturamento</b></font></td>
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

             $con = mysql_connect('localhost', 'root', 'nunesp') or die ("Erro de conexão");
             $res = mysql_select_db('free_jazz') or die ("Banco de dados inexistente");

             $coleta="SELECT codigo_desti,nome_desti,rua_desti,cidade_desti,bairro_desti
             FROM destino
             ORDER BY codigo_desti";
             
             $query_1 = mysql_db_query('free_jazz',$coleta,$con) or die ("Não foi possivel acessar o banco 1");
             $achou = mysql_num_rows($query_1);
             $ser=0;
             while($linha=mysql_fetch_array($query_1)) {
                  $codigo_desti   =$linha['codigo_desti'];
                  $localiza       =$linha['nome_desti']." - ".$linha['rua_desti']." - ".$linha['cidade_desti']." - ".$linha['bairro_desti'];
                  
                  $con = mysql_connect('localhost', 'root', 'nunesp') or die ("Erro de conexão");
                  $res = mysql_select_db('free_jazz') or die ("Banco de dados inexistente");
                              
                  $grava="UPDATE destino SET localiza='$localiza' WHERE codigo_desti='$codigo_desti'";
                  mysql_db_query('free_jazz',$grava,$con);

                  echo "Conteúdo Localiza :$localiza";
                  $codigo_desti       = '';
                  $localiza           = '';
             }
                 
      break;
      default:
      }

  ?>
  <body leftmargin="10" topmargin="10" marginwidth="10" marginheight="10">
  <form name="cadastro" id="cadastro" action="atualiza_destino.php" method="post">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
         <td color="white" align="left" width="100%" height="35">
      </tr>
    </table>
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
