<?php  session_start();  //carrega variaveis com dados para acessar o banco de dados   Include('conexao_free.php');  mysqli_set_charset($con,'UTF8');     //verifica se o usuário esta habilitado para usar a rotina   $matricula_m  =$_SESSION['matricula_m'];  $programa='024';  $_SESSION['programa_m']=$programa;    $confere = "SELECT matricula,programa  FROM permissoes  WHERE ((matricula='$matricula_m') and (programa='$programa'))";  $query = mysqli_query($con,$confere) or die ("Não foi possivel acessar o banco - Rotina Cadastro Destinos");  $achou = mysqli_num_rows($query);  If ($achou == 0 ) {       ?>          <script language="javascript"> window.location.href=("entrada.php")            alert('Você não está autorizado a acessar esta rotina.');          </script>       <?php  }  else {	    	$codi_cli         ='';    $tipo_servi       ='';    $valor            ='';    $classe_cep       ='';    $ativo            ='';    $controle         ='';       $resp_grava='';	  }   	  function get_post_action($name)  {    $params = func_get_args();    foreach ($params as $name) {        if (isset($_POST[$name])) {            return $name;        }    }  }?><html>  <title>Cadastro_Deptos_altera.php</title>  <head>  <script LANGUAGE="Javascript">     function Limpar(valor, validos) {        var result = "";        var aux;        for (var i=0; i < valor.length; i++) {          aux = validos.indexOf(valor.substring(i, i+1));          if (aux>=0) {            result += aux;          }        }        return result;     }     function Formata(campo,tammax,teclapres,decimal) {        var tecla = teclapres.keyCode;        vr = Limpar(campo.value,"0123456789");        tam = vr.length;        dec=decimal        if (tam < tammax && tecla != 8){ tam = vr.length + 1 ; }          if (tecla == 8 )          { tam = tam - 1 ; }          if ( tecla == 8 || tecla >= 48 && tecla <= 57 || tecla >= 96 && tecla <= 105 )          {          if ( tam <= dec )          { campo.value = vr ; }          if ( (tam > dec) && (tam <= 5) ){          campo.value = vr.substr( 0, tam - 2 ) + "," + vr.substr( tam - dec, tam ) ; }          if ( (tam >= 6) && (tam <= 8) ){          campo.value = vr.substr( 0, tam - 5 ) + "." + vr.substr( tam - 5, 3 ) + "," + vr.substr( tam - dec, tam ) ;          }          if ( (tam >= 9) && (tam <= 11) ){          campo.value = vr.substr( 0, tam - 8 ) + "." + vr.substr( tam - 8, 3 ) + "." + vr.substr( tam - 5, 3 ) + "," + vr.substr( tam - dec, tam ) ; }          if ( (tam >= 12) && (tam <= 14) ){          campo.value = vr.substr( 0, tam - 11 ) + "." + vr.substr( tam - 11, 3 ) + "." + vr.substr( tam - 8, 3 ) + "." + vr.substr( tam - 5, 3 ) + "," + vr.substr( tam - dec, tam ) ; }          if ( (tam >= 15) && (tam <= 17) ){          campo.value = vr.substr( 0, tam - 14 ) + "." + vr.substr( tam - 14, 3 ) + "." + vr.substr( tam - 11, 3 ) + "." + vr.substr( tam - 8, 3 ) + "." + vr.substr( tam - 5, 3 ) + "," + vr.substr( tam - 2, tam ) ;}          }     }   </script>    <body>   <style>		body, p, div, td, input, select, textarea {			font-family: verdana,arial,helvetica;			font-size:12px;			color:#000000;			text-decoration: none;		}		input,textarea {			@if (is.ie) {				color: #efefef; background-color:#F0F8FF; border: 1px solid #6495ED ;				/*border-top-width: 1px; border-right-width: 1px; border-bottom-width: 1px; border-left-width: 1px; */			}		}		textarea { overflow:auto }	</style>  </head>  <div id="geral" align="center">    <body topmargin="0" leftmargin="0" rightmargin="0" bottommargin="0" marginheight="0" marginwidth="0" bgcolor="#FFFFFF">     <table border="0" width="100%" bgcolor="#000000" cellspacing="0" cellpadding="0">      <tr>        <td width="20%" height="100" background="img/topleft.jpg"></td>         <td width="658" height="110"> <img border="0" src="img/cabecalho_free_jazz.jpg" width="890" height="115" border="0"></td>        <td width="15%" height="110">        <p align="right"><img border="0" src="img/topright.jpg" width="160" height="110" border="0"></td>     </tr>    </table>    <table border="0" width="100%" cellspacing="0" cellpadding="0" background="img/blue.jpg">     <tr>       <td width="50%">         <p align="left"><font face="Arial" size="2" color="#FFFFFF"><b>Sistema de Gerenciamento da Logística de Encomendas</b></font></td>       <td width="50%">         <p align="right"><font face="Arial" size="2" color="#FFFFFF"><b>Cadastro Tabela Preço - Alteração</b></font></td>     </tr>   </table>   </table>   <table width="100%" border="0" cellspacing="0" cellpadding="0">       <tr>         <td colspan="1" align="left" width="45%"><INPUT type=button size="3" value="Ajuda"               onClick="window.open('mostra_ajuda.php','janela_1',               'scrollbars=yes,resizable=yes,width=400,height=700');" style="width:100;height:30;color=red;font: bold 16px Arial;">         </td>         <td colspan="1" color="white" align="right" width="45%" height="70"><a href="entrada.php"><img src="img/porta.gif" border="none"></td>       </tr>   </table>  <table width="800" heigth="300" align="center">     <tr>       <td>         <form method="POST" action="cadastro_tabela_preco_altera.php" border="20">            <?php               echo "<center><Font size=\"2\" face=\"ARIAL\">Item Alterar..:</font>";                              $resultado = mysqli_query ($con,"SELECT tabela_preco.controle,cli_for.nome,               serv_ati.descri_se,classe_cep.descricao               FROM tabela_preco,cli_for,serv_ati,classe_cep               WHERE ((tabela_preco.codi_cli=cli_for.cnpj_cpf)               AND (tabela_preco.tipo_servi=serv_ati.codigo_se)               AND (tabela_preco.classe_cep=classe_cep.codigo))");               echo "<select name='codigo' class='caixa' align=\"center\">\n";               while($linha = mysqli_fetch_row($resultado))  {                  printf("<option value='$linha[0]'>$linha[0] - $linha[1] - $linha[2] - $linha[3]</option>\n");               }            ?>              <input name="mostra" type="submit" value="Mostra"></center>            </td>           </tr>         </form>   </table>  <?php     switch (get_post_action('grava','mostra')) {         case 'mostra':             $codigo        =$_POST['codigo'];             $_SESSION['controle_m']   =$codigo;             $resp_grava='';                          $verifi="SELECT codi_cli,tipo_servi,classe_cep,valor,ativo             FROM tabela_preco WHERE controle='$codigo'";             $query = mysqli_query($con,$verifi) or die ("Não foi possivel acessar o banco");             $total = mysqli_num_rows($query);             for($ic=0; $ic<$total; $ic++){               $row = mysqli_fetch_row($query);               $codi_cli         = $row[0];               $tipo_servi       = $row[1];               $classe_cep       = $row[2];               $valor            = $row[3];               $ativo            = $row[4];             }             $valor          = number_format($valor, 2, ',', '.');         break;         case 'grava':             $controle        =$_SESSION['controle_m'];             $codi_cli        =$_POST['cliente'];             $valor           =$_POST['valor'];             $tipo_servi      =$_POST['tipo_servi'];             $classe_cep      =$_POST['classe_cep'];             $ativo           =$_POST['ativo'];                          //mudando formato do valor para gravar na tabela             if (strlen($valor)>=6) {                $valor         = str_replace(".", "", $valor);                $valor         = str_replace(",", ".", $valor);             }             if (strlen($valor)<6) {                $valor         = str_replace(",", ".", $valor);             }                          $alteracao = "UPDATE tabela_preco SET codi_cli='$codi_cli',             valor='$valor',tipo_servi='$tipo_servi',classe_cep='$classe_cep',ativo='$ativo'             WHERE controle='$controle'";                          if (mysqli_query($con,$alteracao)) {                $resp_grava="Alteração bem sucedida";             }             else {                $resp_grava="Problemas na Alteração";            }		    $codi_cli         ='';            $tipo_servi       ='';            $valor            ='';            $classe_cep       ='';            $ativo            ='';            $controle         ='';            unset($_SESSION['controle_m']);         break;         default:     }  ?>  <body leftmargin="10" topmargin="10" marginwidth="10" marginheight="10">  <form name="cadastro" action="cadastro_tabela_preco_altera.php" method="post">  <table width="50%" border="1" cellpadding="5" cellspacing="0" bordercolor="#4169E1">        <tr>           <td><b>Cliente :</b></td>           <td>              <?php                echo "<select name=\"cliente\">";                $sql1 = "SELECT cnpj_cpf,nome FROM cli_for";                $resula = mysqli_query($con,$sql1) or die ("Não foi possivel acessar o banco");                while ( $linha = mysqli_fetch_array($resula)) {                    $select = $codi_cli == $linha[0] ? "selected" : "";                    echo "<option value=\"". $linha[0] . "\" $select>" . $linha[1] . "</option>";                }               ?>               </select>            </td>		</tr>        <tr>		  <td><b>Serviço :</b></td>           <td>			  <?php                             echo "<select name=\"tipo_servi\">";               $sql3 = "SELECT codigo_se,descri_se FROM serv_ati";               $resulo = mysqli_query($con,$sql3) or die ("Não foi possivel acessar o banco");               while ( $linha = mysqli_fetch_array($resulo)) {                    $select = $tipo_servi == $linha[0] ? "selected" : "";                    echo "<option value=\"". $linha[0] . "\" $select>" . $linha[1] . "</option>";               }              ?>              </select>           </td>		</tr>         <tr>		  <td><b>Classe CEP :</b></td>           <td>			  <?php               echo "<select name=\"classe_cep\">";               $sql3 = "SELECT codigo,descricao FROM classe_cep";               $resulo = mysqli_query($con,$sql3) or die ("Não foi possivel acessar o banco");               while ( $linha = mysqli_fetch_array($resulo)) {                    $select = $classe_cep == $linha[0] ? "selected" : "";                    echo "<option value=\"". $linha[0] . "\" $select>" . $linha[1] ."</option>";               }              ?>              </select>           </td>		</tr>		<tr>			<td><b>Valor :</b></td>			<td><input name="valor" type="text" value ="<?php echo "$valor";?>" size="20" maxlength="20" onKeydown="Formata(this,20,event,2)"></td>		</tr>		<tr>			<td><b>Ativo :</b></td>			<td><input name="ativo" type="text" value ="<?php echo "$ativo";?>" size="1" maxlength="1"></td>		</tr>		<tr>            <td><INPUT type=button value="Preços Cadastrados"               onClick="window.open('mostra_precos_cadastrados.php','janela_1',               'scrollbars=yes,resizable=yes,width=600,height=400');">            </td>			<td colspan="2">				<div align="right">				<input name="grava" type="submit" value="Gravar">				</div>			</td>		</tr>	</table>	</form>    <table width="100%" border="0" cellspacing="0" cellpadding="0">      <tr>        <td colspan="1" align="left" width="100%"><INPUT type=button size="3" value="Classe CEP"               onClick="window.open('mostra_classe_cep.php','janela_1',               'scrollbars=yes,resizable=yes,width=800,height=700');" style="width:100;height:30;color=red;font: bold 16px Arial;">         </td>      </tr>    </table>    <table width="100%" border="0" cellspacing="0" cellpadding="0">     <tr>       <td color="white" align="center" width="900" height="45" colspan="8" ><?php echo "$resp_grava";?></td>     </tr>    </table>    <table border="0" width="100%" cellspacing="0" cellpadding="0" background="img/blue.jpg">      <tr>        <td width="100%" height="25" align="center"></font><font color="#000000" size="1" face="Arial">COPYRIGHT NUNESTECH Tecnologia em Sistemas Ltda</font></td>     </tr>    </table>  </div></body></html>