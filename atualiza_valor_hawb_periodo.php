<?php  if ( session_status() !== PHP_SESSION_ACTIVE ) {    session_start();  }    include('conexao_free.php');    //carrega variaveis com dados para acessar o banco de dados    $matricula_m  =$_SESSION['matricula_m'];  $programa='070';  $_SESSION['programa_m']=$programa;  $declara = "SELECT matricula,programa FROM permissoes  WHERE ((matricula='$matricula_m') and (programa='$programa'))";  $query = mysqli_query($con,$declara) or die ("Nãfoi possivel acessar o banco");  $achou = mysqli_num_rows($query);  If ($achou == 0 ) {       ?>          <script language="javascript"> window.location.href=("entrada.php")            alert('Você não está autorizado a acessar esta rotina.');          </script>       <?php  }  include("campo_calendario.php");    $resp_grava ='';      function get_post_action($name) {      $params = func_get_args();      foreach ($params as $name) {         if (isset($_POST[$name])) {            return $name;         }      }  }	    switch (get_post_action('atualiza')) {         case 'atualiza':              $dt_inicio              =$_POST['data_ini'];              $dt_fim                 =$_POST['data_fim'];			                //Altera formato de data para comparação			                $dt_inicio  = explode("/",$dt_inicio);              $v_dt_inicio = $dt_inicio[2]."-".$dt_inicio[1]."-".$dt_inicio[0];              $dt_fim  = explode("/",$dt_fim);              $v_dt_fim = $dt_fim[2]."-".$dt_fim[1]."-".$dt_fim[0];                            //Seleciona registros para alteração                            $seleciona = "SELECT n_hawb,dt_remessa,valor,co_servico,codi_cli,classe_cep              FROM remessa              WHERE ((dt_remessa>='$v_dt_inicio')              AND (dt_remessa<='$v_dt_fim'))";              $coleta = mysqli_query($con,$seleciona) or die ("Não foi possivel acessar o banco 2");              $achou = mysqli_num_rows($coleta);              If ($achou == 0) {                 ?>                 <script language="javascript"> window.location.href=("atualiza_valor_hawb_periodo.php")                    alert('Não há movimento lançado no período informado! Verifique.');                 </script>                 <?php             }             else {				 $registros  =0;				 $corrigidos =0;                 while($linha=mysqli_fetch_array($coleta)) {                      $codi_cli       =$linha['codi_cli'];                      $tipo_servi     =$linha['co_servico'];                      $classe_cep     =$linha['classe_cep'];                      $valor_movi     =$linha['valor'];                      $n_hawb         =$linha['n_hawb'];                                            if (($codi_cli != '') and  ($tipo_servi != '') and ($classe_cep != '') and ($classe_cep != '04')) {                                               //echo "<p>Cliente :$codi_cli - Serviço :$tipo_servi -C. CEP :$classe_cep - HAWB :$n_hawb";                                                  $procura="SELECT valor FROM tabela_preco WHERE ((codi_cli='$codi_cli') AND (tipo_servi='$tipo_servi') AND                         (classe_cep='$classe_cep'))";                                       $query = mysqli_query($con,$procura) or die ("Não foi possivel acessar o banco");                         $total = mysqli_num_rows($query);                         if ($total>0) {                            for($ic=0; $ic<$total; $ic++){                               $row = mysqli_fetch_row($query);                               $valor_tab        = $row[0];                            }                            $altera ="UPDATE remessa SET valor='$valor_tab' WHERE n_hawb='$n_hawb'";                            mysqli_query($con,$altera);							$corrigidos++;                         }                      }					  $registros++;                 }             }           break;         default:    }?><HTML><HEAD> <TITLE>atualiza_valor_hawb_periodo.php</TITLE></HEAD><BODY>  <style>		body, p, div, td, input, select, textarea {			font-family: verdana,arial,helvetica;			font-size:12px;			color:#000000;			text-decoration: none;		}		input,textarea {			@if (is.ie) {				color: #efefef; background-color:#F0F8FF; border: 1px solid #6495ED ;				/*border-top-width: 1px; border-right-width: 1px; border-bottom-width: 1px; border-left-width: 1px; */			}		}		textarea { overflow:auto }  </style>  <div id="geral" align="center">    <table border="0" width="100%" bgcolor="#000000" cellspacing="0" cellpadding="0">      <tr>        <td width="20%" height="100" background="img/topleft.jpg"></td>         <td width="658" height="110"> <img border="0" src="img/cabecalho_free_jazz.jpg" width="890" height="115" border="0"></td>        <td width="15%" height="110">        <p align="right"><img border="0" src="img/topright.jpg" width="160" height="110" border="0"></td>     </tr>    </table>    <table border="0" width="100%" cellspacing="0" cellpadding="0" background="img/blue.jpg">     <tr>       <td width="50%">         <p align="left"><font face="Arial" size="2" color="#FFFFFF"><b>Sistema de Gerenciamento da Logística de Encomendas</b></font></td>       <td width="50%">         <p align="right"><font face="Arial" size="2" color="#FFFFFF"><b>Atualiza HAWB Sem Valor</b></font></td>     </tr>   </table>   <table width="100%" border="0" cellspacing="0" cellpadding="0">       <tr>         <td colspan="1" align="left" width="45%"><INPUT type=button size="3" value="Ajuda"               onClick="window.open('mostra_ajuda.php','janela_1',               'scrollbars=yes,resizable=yes,width=400,height=700');" style="width:100;height:30;color=red;font: bold 16px Arial;">         </td>         <td colspan="1" color="white" align="right" width="45%" height="70"><a href="entrada.php"><img src="img/porta.gif" border="none"></td>       </tr>   </table>   <table width="70%" border="1" cellpadding="5" cellspacing="0" bordercolor="#6495ED">        <form name="cadastro" method="POST" action="atualiza_valor_hawb_periodo.php" border="20">          <tr>           <td><b>Data inicio :</b></td>           <td>             <input type="text" name="data_ini" size="12" maxlength="12" id="data_ini">             <input TYPE="button" NAME="btndata_ini" VALUE="..." Onclick="javascript:popdate('document.cadastro.data_ini','pop1','150',document.cadastro.data_ini.value)">             <span id="pop1" style="position:absolute"></span>           </td>          </tr>          <tr>           <td><b>Data fim :</b></td>           <td>             <input type="text" name="data_fim" size="12" maxlength="12" id="data_fim">             <input TYPE="button" NAME="btndata_fim" VALUE="..." Onclick="javascript:popdate('document.cadastro.data_fim','pop2','150',document.cadastro.data_fim.value)">             <span id="pop2" style="position:absolute"></span>           </td>          </tr>          <tr>			<td colspan="2">				<div align="right">				<input name="atualiza" type="submit" value="Atualizar">				</div>			</td>		</tr>        </form>  </table>  <table width="100%" border="0" cellspacing="0" cellpadding="0">      <tr>        <td color="white" align="center" width="900" height="45" colspan="8" ><?php echo "$resp_grava";?></td>      </tr>  </table>  <table width="100%" border="0" cellspacing="0" cellpadding="0">    <tr>       <td color="white" align="left" width="100%" height="30">     </tr>  </table>  <table border="0" width="100%" cellspacing="0" cellpadding="0" background="img/blue.jpg">      <tr>        <td width="100%" height="25" align="center"></font><font color="white" size="1" face="Arial">COPYRIGHT NUNESTECH Tecnologia em Sistemas Ltda</font></td>     </tr>  </table></BODY></HTML>