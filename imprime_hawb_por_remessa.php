<?php  if ( session_status() !== PHP_SESSION_ACTIVE ) {    session_start();  }   //carrega variaveis com dados para acessar o banco de dados   Include('conexao_free.php');  mysqli_set_charset($con,'UTF8');      $matricula_m  =$_SESSION['matricula_m'];  $programa='093';  $_SESSION['programa_m']=$programa;  $declara = "SELECT matricula,programa FROM permissoes WHERE ((matricula='$matricula_m') and (programa='$programa'))";  $query = mysqli_query($con,$declara) or die ("Não foi possivel acessar o banco");  $achou = mysqli_num_rows($query);  If ($achou == 0 ) {       ?>          <script language="javascript"> window.location.href=("entrada.php")            alert('Você não está autorizado a acessar esta rotina.');          </script>       <?php  }  else {	 $n_remessa  ='';     $resp_grava ='';;	   }  function get_post_action($name) {    $params = func_get_args();    foreach ($params as $name) {        if (isset($_POST[$name])) {            return $name;        }    }  }?><html>  <title>imprime_hawb_por_remessa.php</title>  <head>    <script language="JavaScript">      function salva(campo){            cadastro.submit()      }	        targetCounter = 0;      function submitToSmallWindow(frm){           targetWindow = "_wnd" + targetCounter++;           window.open('', targetWindow ,'scrollbars=yes,resizable=yes,width=900, height=700');           frm.target = targetWindow;           frm.submit();       }    </script>   <style>		body, p, div, td, input, select, textarea {			font-family: verdana,arial,helvetica;			font-size:12px;			color:#000000;			text-decoration: none;		}		input,textarea {			@if (is.ie) {				color: #efefef; background-color:#F0F8FF; border: 1px solid #6495ED ;				/*border-top-width: 1px; border-right-width: 1px; border-bottom-width: 1px; border-left-width: 1px; */			}		}		textarea { overflow:auto }   </style>  </head>  <div id="geral" align="center">    <body onkeydown="desabilitaCtrlJ(event)" topmargin="0" leftmargin="0" rightmargin="0" bottommargin="0" marginheight="0" marginwidth="0" bgcolor="#FFFFFF">     <table border="0" width="100%" bgcolor="#000000" cellspacing="0" cellpadding="0">      <tr>        <td width="20%" height="100" background="img/topleft.jpg"></td>         <td width="658" height="110"><img border="0" src="img/cabecalho_free_jazz.jpg" width="890" height="115" border="0"></td>        <td width="15%" height="110">        <p align="right"><img border="0" src="img/topright.jpg" width="160" height="110" border="0"></td>     </tr>    </table>    <table border="0" width="100%" cellspacing="0" cellpadding="0" background="img/blue.jpg">     <tr>       <td width="50%">         <p align="left"><font face="Arial" size="2" color="#FFFFFF"><b>Sistema de Gerenciamento da Logística de Encomendas</b></font></td>       <td width="50%">         <p align="right"><font face="Arial" size="2" color="#FFFFFF"><b>Gera e imprime a Segunda de HAWB</b></font></td>     </tr>   </table>   <table width="100%" border="0" cellspacing="0" cellpadding="0">       <tr>         <td colspan="1" color="white" align="right" width="45%" height="70"><a href="entrada.php"><img src="img/porta.gif" border="none"></td>       </tr>   </table>   <form method="POST" name="cadastro" action="gera_imagem_hawb_por_remessa.php" border="20" align="center">       <table width="60%" align="center" border="1" cellpadding="3" cellspacing="0" bordercolor="#4169E1">           <td><b>Selecione Remessa :</b></td>           <td>              <?php               ?>               <select name="n_remessa">               <?php                $sql3 = "SELECT DISTINCT remessa.n_remessa,cli_for.nome,date_format(remessa.dt_remessa,'%d/%m/%Y')                FROM remessa,cli_for                WHERE remessa.codi_cli=cli_for.cnpj_cpf                ORDER BY remessa.dt_remessa DESC";                $result = mysqli_query($con,$sql3) or die ("Não foi possivel acessar o banco");                while ( $linha = mysqli_fetch_array($result)) {                    $select = $n_remessa == $linha[0] ? "selected" : "";                    echo "<option value=\"". $linha[0] . "\" $select>" . $linha[0] . "-" . $linha[1] . "-" . $linha[2]. "</option>";               }              ?>              </select>             <input name="gera" type="submit" value="Gerar Impressão" onclick ="javascript:submitToSmallWindow(document.cadastro)">           </td>		</tr>	</table>  </form>  </div>  <table width="100%" border="0" cellspacing="0" cellpadding="0">      <td color="white" align="center" width="900" height="45" colspan="4" ><?php echo "$resp_grava";?></td>  </table>  <table width="100%" border="0" cellspacing="0" cellpadding="0">    <tr>       <td color="white" align="left" width="100%" height="40">     </tr>  </table>  <table width="100%"  border="0" cellspacing="0" cellpadding="0">    <tr>      <td background="img/blue.jpg" align="left" width="100%" height="45px"><center><font face="arial" size="1" color="white">Todos Direitos Reservados a NUNESTEC Tecnologia</font></td>    </tr>  </table></body></html>