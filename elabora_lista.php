<?php
  session_start();

 //carrega variaveis com dados para acessar o banco de dados

  $base_d     =$_SESSION['base_d'];
  $banco_d    =$_SESSION['banco_d'];
  $usuario_d  =$_SESSION['usuario_d'];
  $senha_d    =$_SESSION['senha_d'];

  $matricula_m  =$_SESSION['matricula_m'];
  $programa='21';
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
  function get_post_action($name) {
    $params = func_get_args();
    foreach ($params as $name) {
        if (isset($_POST[$name])) {
            return $name;
        }
    }
  }
?>
<html>
  <title>Cadastro_permissões_altera.php</title>
  <head>
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
         <p align="right"><font face="Arial" size="2" color="#FFFFFF"><b>Lista de Entrega - Elaboração</b></font></td>
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
   <form method="POST" action="elabora_lista.php" border="20">
       <table width="500" heigth="300" align="center">
         <tr>
           <td>
              <?php
               echo "<center><Font size=\"2\" face=\"ARIAL\">Entregador..:</font>";
               mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
               mysql_select_db($banco_d) or die ("Banco de dados inexistente");

               $resultado = mysql_query ("SELECT matricula,nome
               FROM pessoa ORDER BY nome");
               echo "<select name='entregador' class='caixa' align=\"center\">\n";
               while($linha = mysql_fetch_row($resultado))  {
                  printf("<option value='$linha[0]'>$linha[0] - $linha[1] </option>\n");
               }
              ?>
           </td>
         </tr>
       </table>
       <table width="500" heigth="300" align="center">
         <tr>
           <td>
             <?php
               echo "<center><Font size=\"2\" face=\"ARIAL\">Remessa..:</font>";
               mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
               mysql_select_db($banco_d) or die ("Banco de dados inexistente");

               $resultado = mysql_query ("SELECT DISTINCT remessa.n_remessa,cli_for.nome
               FROM remessa,cli_for
               WHERE remessa.codi_cli=cli_for.cnpj_cpf");
               echo "<select name='remessa' class='caixa' align=\"center\">\n";
               while($linha = mysql_fetch_row($resultado))  {
                  printf("<option value='$linha[0]'>$linha[0] - $linha[1] </option>\n");
               }
             ?>
              <input name="mostra" type="submit" value="Mostra"></center>
           </td>
         </tr>
       </table>
   </form>
   <?php
    switch (get_post_action('grava','mostra')) {
    case 'mostra':
           $n_remessa   =$_POST['remessa'];
           $entregador  =$_POST['entregador'];
           $_SESSION['entregador_m']   =$entregador;
           
           //Pega o nome da pessoa
           $verifi="SELECT nome FROM pessoa WHERE matricula='$entregador'";
           $query = mysql_db_query($banco_d,$verifi,$con) or die ("Não foi possivel acessar o banco");
           $total = mysql_num_rows($query);

           for($ic=0; $ic<$total; $ic++){
               $row = mysql_fetch_row($query);
               $nome        = $row[0];
           }
           ?>
           <body leftmargin="10" topmargin="10" marginwidth="10" marginheight="10">
           <form name="cadastro" id="cadastro" action="elabora_lista.php" method="post">

              <table width="60%" border="1" cellpadding="5" cellspacing="0" bordercolor="#6495ED">
                 <tr>
                    <td colspan="2" align="center"><font face="arial" size="2"><b>Entregador /Remessa Selecionados :<font color="red"><?php echo "$nome"; ?> / <?php echo "$n_remessa"; ?></b></font></td>
                 </tr>
                 <?php
                    $con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
                    $res = mysql_select_db($banco_d) or die ("Banco de dados inexistente");

                    $sql = mysql_query("SELECT controle,cep_desti,nome_desti,rua_desti,bairro_desti,cidade_desti
                    FROM remessa
                    WHERE ((n_remessa='$n_remessa')
                    AND (entregador=''))
                    ORDER BY cep_desti");
                    
                    if (mysql_num_rows($sql)==0) {
                        echo "Arquivo de remessa está vazio";
                    }
                    else{
                      while ($x  = mysql_fetch_array($sql)) {
                         $controle      = $x['controle'];
                         $cep_desti     = $x['cep_desti'];
                         $nome_desti    = $x['nome_desti'];
                         $rua_desti     = $x['rua_desti'];
                         $bairro_desti  = $x['bairro_desti'];
                         $cidade_desti  = $x['cidade_desti'];
                         echo "<div>";
                         echo "<font face=\"arial\" size=\"1\">";
                         echo "<tr><td colspan=\"2\">";
                         echo $controle."<input type =\"checkbox\" name = \"lista[]\" id=\"lista\" value=\"$controle\">$cep_desti - $nome_desti - $rua_desti - $bairro_desti - $cidade_desti";
                         echo "</td></tr>";
                         echo "</div>";
                      }
                    }
                 ?>
                 <tr>
                   <td colspan="2">
                      <div align="right">
	                     <input name="grava" type="submit" value="Gravar">
                      </div>
                   </td>
                 </tr>
	          </table>
             <?php

             break;
             
      case 'grava':
             $entregador  =$_SESSION['entregador_m'];
             $dt_lista    =date('Y-m-d');
             $con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
             $res = mysql_select_db($banco_d) or die ("Banco de dados inexistente");
             $num=0;
             foreach($_POST['lista'] as $controle){

                $localiza = "SELECT controle FROM remessa WHERE controle='$controle'";
                $query = mysql_db_query($banco_d,$localiza,$con) or die ("Não foi possivel acessar o banco");
                $achou = mysql_num_rows($query);
                If ($achou > 0 ) {
                  mysql_query("UPDATE remessa SET entregador='$entregador',dt_lista='$dt_lista'
                  WHERE controle='$controle'");
                }
              $num++;
             }
         break;
      default:
    }
  ?>

 	<table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td color="white" align="center" width="900" height="45" colspan="8" ><?php echo "$resp_grava";?></td>
      </tr>
    </table>
    </form>
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
 </div>
</body>
</html>

