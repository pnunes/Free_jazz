<?php
  if ( session_status() !== PHP_SESSION_ACTIVE ) {    session_start();  }    include('conexao_free.php');
  function get_post_action($name) {      $params = func_get_args();      foreach ($params as $name) {         if (isset($_POST[$name])) {            return $name;         }      }  }  $resp_grava='';
  switch (get_post_action('grava')) {
         case 'grava':
              $cep_inico              =$_POST['cep_inicio'];
              $cep_fim                =$_POST['cep_fim'];
              $classe_cep_regiao      =$_POST['classe_cep_regiao'];
              $raiz_cep_ini           =Substr($cep_inico,0,4);
              $raiz_cep_fim           =Substr($cep_fim,0,4);
              $coleta = "SELECT * FROM destino ORDER BY cep_desti";
              $query = mysqli_query($con,$coleta) or die ("Não foi possivel acessar o banco 2");
              $total = mysqli_num_rows($query);
              $conta=0;
              while($linha=mysqli_fetch_array($query)) {
                   $raiz_cep       =Substr($linha['cep_desti'],0,4);
                   $codigo_desti   =$linha['codigo_desti'];
                   if ($linha['cep_desti']<>'') {
                       if (($raiz_cep >= "$raiz_cep_ini") and ($raiz_cep <= "$raiz_cep_fim")) {
                          
                          $alteracao = "UPDATE destino SET classe_cep_regiao='$classe_cep_regiao'
                          WHERE codigo_desti='$codigo_desti'";
                          if (mysqli_query($con,$alteracao)) {
                             $conta=$conta+1;
                          }
                       }
                   }
              }
              $resp_grava="Foram alterados :".$conta." Registros";
           break;
         default:
    }
  //carrega variaveis com dados para acessar o banco de dados
  $matricula_m  =$_SESSION['matricula_m'];
  $programa='69';
  $_SESSION['programa_m']=$programa;
  
  $declara = "SELECT matricula,programa FROM permissoes
  WHERE ((matricula='$matricula_m') and (programa='$programa'))";
  $query = mysqli_query($con,$declara) or die ("Não foi possivel acessar o banco");
  $achou = mysqli_num_rows($query);
  If ($achou == 0 ) {
       ?>
          <script language="javascript"> window.location.href=("entrada.php")
            alert('Você não está autorizado a acessar esta rotina.');
          </script>
       <?php
    }
?>
<HTML>
<HEAD>
 <TITLE>cadastro_classe_cep_regiao_destino.php</TITLE>
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
         <p align="right"><font face="Arial" size="2" color="#FFFFFF"><b>Atualiza Classe CEP Região no Cadastro Destinos</b></font></td>
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
   <table width="70%" border="1" cellpadding="5" cellspacing="0" bordercolor="#6495ED">
        <form name="cadastro" method="POST" action="cadastro_classe_cep_regiao_destino.php" border="20">
          <tr>
             <td><b>CEP inicio :</b></td>
             <td>
                <input type="text" name="cep_inicio" size="12" maxlength="12" id="cep_inicio">
             </td>
          </tr>
          <tr>
             <td><b>CEP final :</b></td>
             <td>
                <input type="text" name="cep_fim" size="12" maxlength="12" id="cep_fim">
             </td>
          </tr>
          <tr>
		     <td><b>Classe CEP :</b></td>
             <td>			   <select name="classe_cep_regiao">
			     <?php            
                 $sql3 = "SELECT codigo,regiao FROM classe_cep_regiao";
                 $resulo = mysqli_query($con,$sql3) or die ("Não foi possivel acessar o banco");
                 while ( $linha = mysqli_fetch_array($resulo)) {
                    $select = $classe_cep == $linha[0] ? "selected" : "";
                    echo "<option value=\"". $linha[0] . "\" $select>" . $linha[1] ."</option>";
                 }
                 ?>
              </select>
             </td>
		  </tr>
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
        <td colspan="2" align="left" width="45%"><INPUT type=button size="3" value="Classe CEP"
               onClick="window.open('mostra_classe_cep.php','janela_1',
               'scrollbars=yes,resizable=yes,width=800,height=700');" style="width:100;height:30;color=red;font: bold 16px Arial;">
        </td>
      </tr>
      <tr>
        <td colspan="2" color="white" align="center" height="45"><?php echo "$resp_grava";?></td>
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
