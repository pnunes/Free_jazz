<?php
  session_start();

 //carrega variaveis com dados para acessar o banco de dados

  $base_d     =$_SESSION['base_d'];
  $banco_d    =$_SESSION['banco_d'];
  $usuario_d  =$_SESSION['usuario_d'];
  $senha_d    =$_SESSION['senha_d'];
  
  //Recupera o número da HAWBda memória
  
  
  function get_post_action($name) {
    $params = func_get_args();
    foreach ($params as $name) {
        if (isset($_POST[$name])) {
            return $name;
        }
    }
  }
  
  $matricula_m  =$_SESSION['matricula_m'];
  $programa='105';
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
?>

<HTML>
 <HEAD>
  <TITLE>Altera_detalhes_entrega.php</TITLE>

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
    <script language="JavaScript">
        <!-- LE CAMPO DO CODIGO DE BARRA E SUMETE-->

       function salva(campo){
            cadastro.submit();
       }
       <!-- FUNÇÃO PARA DESABILITAR O CRTL+J-->

       function retornoCodbar(evt, valor){
        <!--ENTER = 13 -->
        if (window.event){
           var tecla = window.event.keyCode;
           if(tecla==13){
             <!--alert('Código de barras: '+valor);-->
             window.event.returnValue = false;
           }
        }
        else{
           var tecla = (evt.which) ? evt.which : evt.keyCode;
           if(tecla==13){
              <!--alert('Código de barras: '+valor);-->
             evt.preventDefault();
           }
        }
       }

       function desabilitaCtrlJ(evt){
          //ctrl+j == true+106
          //ctrl+J == true+74
          if (window.event){ //IE
             var ctrl = event.ctrlKey;
             var tecla = window.event.keyCode;
             if((ctrl==true)&&((tecla==106)||(tecla==74))){
                window.event.returnValue = false;
             }
          }
          else{ //Firefox
             var ctrl = evt.ctrlKey;
             var tecla = (evt.which) ? evt.which : evt.keyCode;
             if((ctrl==true)&&((tecla==106)||(tecla==74))){
                evt.preventDefault();
             }
          }
       }
    </script>
  </HEAD>
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
         <p align="right"><font face="Arial" size="2" color="#FFFFFF"><b>Altera Eventos na Entrega - Alteração</b></font></td>
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
<BODY>
  <?php
  switch (get_post_action('grava','mostra','seleciona')) {
         case 'mostra':
             $n_hawb                =$_POST['n_hawb'];
             $_SESSION['n_hawb_b']  =$n_hawb;
         break;
         
         case 'seleciona':
             $controle      =$_POST['ocorre'];
             $_SESSION['controle_b']  =$controle;
             $localiza = "SELECT date_format(dt_evento,'%d/%m/%Y'),ocorrencia,ordem
             FROM controle_reentrega
             WHERE controle='$controle'";
             $query = mysql_db_query($banco_d,$localiza,$con) or die ("Não foi possivel acessar o banco");
             $total = mysql_num_rows($query);

             for($ic=0; $ic<$total; $ic++){
               $row = mysql_fetch_row($query);
               $dt_evento     = $row[0];
               $ocorrencia    = $row[1];
               $ordem         = $row[2];
             }
             
         break;
         
         case 'grava':
             $ocorrencia       =$_POST['ocorrencia'];
             $dt_evento        =$_POST['dt_evento'];
             $controle         =$_SESSION['controle_b'];
             $ordem            =$_POST['ordem'];
             //mudando formato da data para gravar na tabela

             $dt_evento  = explode("/",$dt_evento);
             $v_dt_evento = $dt_evento[2]."-".$dt_evento[1]."-".$dt_evento[0];


             $con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
             $res = mysql_select_db($banco_d) or die ("Banco de dados inexistente");

             $altera = "UPDATE controle_reentrega SET ocorrencia='$ocorrencia',
             dt_evento='$v_dt_evento',ordem='$ordem'
             WHERE controle='$controle'";

             if (mysql_db_query($banco_d,$altera,$con)) {
                $resp_grava="Alteração bem sucedida";
                $ocorrencia         = '';
                $dt_evento          = '';
                $ordem              = '';
            }
            else {
                $resp_grava="Problemas na Alteração";
            }
         break;
         default:
  }
     
     $codi_barra     =$_POST['cod_barra'];

     if (empty($codi_barra)) {
        ?>
          <script language="JavaScript">
             document.getElementById('cod_barra').focus();
          </script>
        <?php
     }
     else {
         $foco=1;
         $_SESSION['cod_barra_m']  =$codi_barra;
         $resp_grava='';
         $con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
         $res = mysql_select_db($banco_d) or die ("Banco de dados inexistente");

         $verifi="SELECT ocorrencia,dt_evento,n_hawb,ordem FROM controle_reentrega WHERE cod_barra='$codi_barra'";
         
         $query = mysql_db_query($banco_d,$verifi,$con) or die ("Não foi possivel acessar o banco");
         $total = mysql_num_rows($query);

         //Verifica se omovimento foi entregue

         If ($total==0) {
            $codi_barra='';
            ?>
            <script language="javascript"> window.location.href=("baixa_remessa_leitora.php")
                alert(' Não há registro de ocorrência para a HAWB informada ! Verifique.');
            </script>
            <?php
         }
         else {
            for($ic=0; $ic<$total; $ic++){
               $mostra = mysql_fetch_row($query);
               $ocorrencia     = $mostra[0];
               $dt_evento      = $mostra[1];
               $n_hawb         = $mostra[2];
               $ordem          = $mostra[3];
            }
            $_SESSION['n_hawb_b']  =$n_hawb;
         }

     }
 ?>
<form name="cadastro" action="altera_detalhes_entrega.php" method="post">
	<table width="70%" border="1" cellpadding="5" cellspacing="0" bordercolor="#4169E1">
       <tr>
           <td align="center" colspan="3"><b>Codigo Barras:</b>
           <input type="text" name="cod_barra" id="cod_barra" value ="<?php echo "$codi_barra";?>" size="60" maxlength="60" onChange="salva(this)"></td>
       </tr>
       <?php if ($foco==0) {?>
           <!-- Coloca foco no primeiro campo codigo de barras do formulário -->
           <script language="JavaScript">
              document.getElementById('cod_barra').focus();
          </script>
        <?php }?>
       <tr>
           <td><b>Número HAWB :</b></td>
           <td><input type="text" name="n_hawb" value ="<?php echo "$n_hawb";?>" size="30" maxlength="30" id="n_hawb"><input name="mostra" type="submit" value="Busca Dados"></td>
       </tr>
       <tr>
       <td><b>Selecione Evento :</b></td>
        <td>
           <?php
               $con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
               $res = mysql_select_db($banco_d) or die ("Banco de dados inexistente");
               ?>
               <select name="ocorre">
              <?php
                $n_hawb  =$_SESSION['n_hawb_b'];
                $sql2 = "SELECT controle,n_hawb,date_format(dt_evento,'%d/%m/%Y'),ocorrencia FROM controle_reentrega WHERE n_hawb='$n_hawb'";
                $resul = mysql_db_query($banco_d,$sql2,$con) or die ("Não foi possivel acessar o banco");
                while ( $linha = mysql_fetch_array($resul)) {
                    $select = $ocorrencia == $linha[0] ? "selected" : "";
                    echo "<option value=\"". $linha[0] . "\" $select>" . $linha[0] . "-" . $linha[1] . "-" . $linha[2] . "-" . $linha[3] ."</option>";
                }
              ?>
            </select>
            <input name="seleciona" type="submit" value="Selecionar">
            </td>
         </td>
        </tr>
	    <tr>
	      <td><b>Descrição da Ocorrência :</b></td>
          <td><input type="text" name="ocorrencia" value ="<?php echo "$ocorrencia";?>" size="100" maxlength="100" id="ocorrencia"></td>
		</tr>
        <tr>
          <td><b>Data da entrega :</b></td>
          <td>
            <input type="text" name="dt_evento" value ="<?php echo "$dt_evento";?>" size="12" maxlength="12" id="dt_evento">
            <input TYPE="button" NAME="btndt_evento" VALUE="..." Onclick="javascript:popdate('document.cadastro.dt_evento','pop1','150',document.cadastro.dt_evento.value)">
            <span id="pop1" style="position:absolute"></span>
          </td>
        </tr>
        <tr>
	      <td><b>Numero Ordem :</b></td>
          <td><input type="text" name="ordem" value ="<?php echo "$ordem";?>" size="3" maxlength="3" id="ordem"></td>
		</tr>
        <tr>
			<td colspan="2">
				<div align="right">
				<input name="grava" type="submit" value="Gravar">
				</div>
			</td>
		</tr>
	</table>
  </form>
  <?php
     $n_hawb    =$_SESSION['n_hawb_b'];
	?>
    <table width="60%" border="1" cellpadding="5" cellspacing="0" bordercolor="#4169E1">
      <tr>
        <td colspan="6" align="center"><font face="arial" size="2"><b>EVENTOS RELACIONADOS A HAWB : <?php echo "$n_hawb";?></b></font></td>
      </tr>
      <tr>
         <td width="15%" align="center"><b>DATA</b></td>
         <td width="85%" align="center"><b>EVENTO</b></td>
      </tr>
      <?php
       mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
       mysql_select_db($banco_d) or die ("Banco de dados inexistente");

       $resultado = mysql_query ("SELECT ocorrencia,date_format(dt_evento,'%d/%m/%Y') FROM controle_reentrega
       WHERE n_hawb='$n_hawb' ORDER BY controle");
       $total = mysql_num_rows($resultado);

       for($i=0; $i<$total; $i++){
          $dados = mysql_fetch_row($resultado);
          $ocorrencia      =$dados[0];
          $dt_evento   =$dados[1];

          echo "<tr>";
            echo "<td width=\"15%\" align=\"left\"><font size=\"1\" face=\"arial\">$dt_evento</font></td>";
            echo "<td width=\"85%\"><font size=\"1\" face=\"arial\">$ocorrencia</font></td>";
         echo "</tr>";
       }
     ?>
    </table>
</BODY>
</HTML>
