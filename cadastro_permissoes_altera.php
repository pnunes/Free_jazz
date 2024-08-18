<?php
  session_start();

  //carrega variaveis com dados para acessar o banco de dados
 
  Include('conexao_free.php');
  mysqli_set_charset($con,'UTF8');
   
  //verifica se o usuário esta habilitado para usar a rotina
 
  $matricula_m  =$_SESSION['matricula_m'];
  $programa='018';
  $_SESSION['programa_m']=$programa;
  
  $confere = "SELECT matricula,programa
  FROM permissoes
  WHERE ((matricula='$matricula_m') and (programa='$programa'))";
  $query = mysqli_query($con,$confere) or die ("Não foi possivel acessar o banco - Rotina Cadastro Destinos");
  $achou = mysqli_num_rows($query);
  If ($achou == 0 ) {
       ?>
          <script language="javascript"> window.location.href=("entrada.php")
            alert('Você não está autorizado a acessar esta rotina.');
          </script>
       <?php
  }
  else {
	    
	$matricula     ='';
    $programa      ='';
    $nome_programa ='';
    $resp_grava='';	
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
  <title>Cadastro_permissoes_altera.php</title>
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
         <p align="right"><font face="Arial" size="2" color="#FFFFFF"><b>Cadastro de Permissões - Alteração</b></font></td>
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
   <table width="500" heigth="300" align="center">
     <tr>
       <td>
         <form method="POST" action="cadastro_permissoes_altera.php" border="20">
            <?php
               echo "<center><Font size=\"2\" face=\"ARIAL\">Selecione pessoa..:</font>";
               
               $resultado = mysqli_query ($con,"SELECT matricula,nome
               FROM pessoa ORDER BY nome");
               echo "<select name='pessoa' class='caixa' align=\"center\">\n";
               while($linha = mysqli_fetch_row($resultado))  {
                  printf("<option value='$linha[0]'>$linha[0] - $linha[1] </option>\n");
               }
            ?>
              <input name="mostra" type="submit" value="Mostra"></center>
         </form>
       </td>
     </tr>
   </table>
  <?php
    switch (get_post_action('grava','mostra')) {
    case 'mostra':
           $matricula   =$_POST['pessoa'];
           
           //Pega o nome da pessoa
           $verifi="SELECT nome FROM pessoa WHERE matricula='$matricula'";
           $query = mysqli_query($con,$verifi) or die ("Não foi possivel acessar o banco");
           $total = mysqli_num_rows($query);

           for($ic=0; $ic<$total; $ic++){
               $row = mysqli_fetch_row($query);
               $nome        = $row[0];
           }
  ?>
           <body leftmargin="10" topmargin="10" marginwidth="10" marginheight="10">
           <form name="cadastro" id="cadastro" action="cadastro_permissoes_altera.php" method="post">

              <table width="60%" border="1" cellpadding="5" cellspacing="0" bordercolor="#6495ED">
                 <tr>
                    <td colspan="2" align="center"><font face="arial" size="2"><b>Selecione as rotinas a serem desabilitadas para o usuario :<font color="red"><?php echo "$nome"; ?></b></font></td>
                 </tr>
                 <?php
                    
                    $sql = mysqli_query($con,"SELECT controle,matricula,programa,nome_programa
                    FROM permissoes
                    WHERE matricula='$matricula'
                    ORDER BY nome_programa");
                    
                    if (mysqli_num_rows($sql)==0) {
                        echo "Arquivo de programas está vazio";
                    }
                    else{
                      while ($x  = mysqli_fetch_array($sql)) {
                         $controle      = $x['controle'];
                         $matricula     = $x['matricula'];
                         $programa      = $x['programa'];
                         $nome_programa = $x['nome_programa'];
                         echo "<div>";
                         echo "<font face=\"arial\" size=\"1\">";
                         echo "<tr><td colspan=\"2\">";
                         echo $controle."<input type =\"checkbox\" name = \"progra[]\" id=\"progra\" value=\"$controle\">$matricula - $programa - $nome_programa";
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
      
             $num=0;
             foreach($_POST['progra'] as $controle){
             
                //Verifica se a permissão já esta gravada no arquivo

                $declara = "SELECT controle FROM permissoes WHERE controle='$controle'";
                $query = mysqli_query($con,$declara) or die ("Não foi possivel acessar o banco");
                $achou = mysqli_num_rows($query);
                If ($achou > 0 ) {
                  mysqli_query($con,"DELETE FROM permissoes WHERE controle='$controle'");
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
        <td width="100%" height="25" align="center"></font><font color="white" size="1" face="Arial">COPYRIGHT NUNESTECH Tecnologia em Sistemas Ltda</font></td>
     </tr>
</table>
 </div>
</body>
</html>

