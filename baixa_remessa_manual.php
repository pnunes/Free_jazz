<?php
  session_start();

   //carrega variaveis com dados para acessar o banco de dados

  $base_d     =$_SESSION['base_d'];
  $banco_d    =$_SESSION['banco_d'];
  $usuario_d  =$_SESSION['usuario_d'];
  $senha_d    =$_SESSION['senha_d'];

  $matricula_m  =$_SESSION['matricula_m'];
  $programa='052';
  $_SESSION['programa_m']=$programa;


  $con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conex�o");
  $res = mysql_select_db($banco_d) or die ("Banco de dados inexistente");

  $declara = "SELECT matricula,programa
  FROM permissoes
  WHERE ((matricula='$matricula_m') and (programa='$programa'))";

  $query = mysql_db_query($banco_d,$declara,$con) or die ("N�o foi possivel acessar o banco");
  $achou = mysql_num_rows($query);

  If ($achou == 0 ) {
       ?>
          <script language="javascript"> window.location.href=("entrada.php")
            alert('Voc� n�o est� autorizado a acessar esta rotina.');
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
  
  include ("campo_calendario.php");
  
   $dt_baixa       = date('d/m/Y');
   $dt_entrega     = date('d/m/Y');
   $hr_entrega     = date("H:i:s",time());
   
   $_SESSION['hr_entrega_m']     =$hr_entrega;
   $_SESSION['dt_baixa_m']       =$dt_baixa;
   $_SESSION['dt_entrega_m']     =$dt_entrega;

?>
<html>
  <title>baixa_remessa_leitora.php</title>
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
   <script language="JavaScript">
   
       <!-- FUN��O QUE VERIFICA SE CAMPOS FORAM PREENCHIDOS-->

       function validar() {
          var recebedor = cadastro.recebedor.value;
          var documento = cadastro.documento.value;
          if (recebedor == "") {
             alert('O campo recebedor n�o foi preenchido! Verifique.');
             cadastro.recebedor.focus();
             return false;
          }
          if (documento == "") {
             alert('O campo documento n�o foi preenchido! Verifique.');
             cadastro.documento.focus();
             return false;
          }
       }


   <!-- FUN��O PARA DESABILITAR O CRTL+J-->

   function retornoCodbar(evt, valor){
    <!--ENTER = 13 -->
    if (window.event){
       var tecla = window.event.keyCode;
       if(tecla==13){
         <!--alert('C�digo de barras: '+valor);-->
         window.event.returnValue = false;
       }
    }
    else{
       var tecla = (evt.which) ? evt.which : evt.keyCode;
       if(tecla==13){
          <!--alert('C�digo de barras: '+valor);-->
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

  </head>
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
         <p align="left"><font face="Arial" size="2" color="#FFFFFF"><b>Sistema de Gerenciamento da Log�stica de Encomendas</b></font></td>
       <td width="50%">
         <p align="right"><font face="Arial" size="2" color="#FFFFFF"><b>Baixa Remessa Entregue_Com Leitora</b></font></td>
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
   <body leftmargin="10" topmargin="10" marginwidth="10" marginheight="10">
   <?php

   switch (get_post_action('baixa','mostra')) {

         case 'baixa':
             $controle        =$_SESSION['controle_m'];
             $recebedor      = $_POST['recebedor'];
             $documento      = $_POST['documento'];
             $parentesco     = $_POST['parentesco'];
             $dt_entrega     = $_POST['dt_entrega'];
             $hr_entrega     = $_POST['hr_entrega'];
             $volta_lista    = $_POST['volta_lista'];
             $ocorrencia     = $_POST['ocorrencia'];
             $dt_baixa       = $_POST['dt_baixa'];

             $volta_lista    =Strtoupper($volta_lista);

             $dt_entrega  = explode("/",$dt_entrega);
             $v_dt_entrega = $dt_entrega[2]."-".$dt_entrega[1]."-".$dt_entrega[0];

             $dt_baixa  = explode("/",$dt_baixa);
             $v_dt_baixa = $dt_baixa[2]."-".$dt_baixa[1]."-".$dt_baixa[0];

             $v_dt_lista=$_SESSION['dt_lista_m'];
             
             if ($v_dt_lista<>'0000-00-00') {
                 $con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conex�o");
                 $res = mysql_select_db($banco_d) or die ("Banco de dados inexistente");

                 $alteracao = "UPDATE remessa SET recebedor='$recebedor',documento='$documento',
                 parentesco='$parentesco',dt_entrega='$v_dt_entrega',hr_entrega='$hr_entrega',
                 volta_lista='$volta_lista',ocorrencia='$ocorrencia',dt_baixa='$v_dt_baixa'
                 WHERE controle='$controle'";

                 if (mysql_db_query($banco_d,$alteracao,$con)) {

                    //Atualiza a tabela de log de opera�oes no sistema

                    $n_hawb       =$_SESSION['n_hawb_m'];
                    $matricula_m  =$_SESSION['matricula_m'];
                    $data         = date('Y/m/d');
                    $hora         = date ('H:i:s');
                    $programa     =$_SESSION['programa_m'];
                    //Atualiza a tabela log_opera��o sistema
                    $con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conex�o");
                    $res = mysql_select_db($banco_d) or die ("Banco de dados inexistente");

                    $inclui="INSERT INTO log_opera��o_sistema(matricula,tarefa_executada,data,hora,rotina,n_hawb)
                       values('$matricula_m','Baixa de hawb manual','$v_dt_baixa','$hora',
                       '$programa','$n_hawb')";
                    mysql_db_query($banco_d,$inclui,$con);
                 
                    $resp_grava="Altera��o bem sucedida";

                    $n_hawb              ='';
                    $nome_desti          ='';
                    $volta_lista         ='';
                    $ocorrencia          ='';
                    $n_tentativas        ='';
                    $nome_desti          ='';
                    $entregador          ='';
                    $nome_entregador     ='';
                    unset($_SESSION['nome_entregador_m']);
                    unset($_SESSION['controle_m']);
                 }
                 else {
                    $resp_grava="Problemas na Altera��o";
                 }
                 $deixa=1;
             }
             else {
                 ?>
                <script language="javascript"> window.location.href=("baixa_remessa_leitora.php")
                    alert('Esta HAWB n�o foi lan�ada em lista de entrega (BIP 2)! Verifique.');
                </script>
                <?php
             }
         break;

         case 'mostra':
         
              $n_hawb     =$_POST['n_hawb'];
              if ($n_hawb<>'') {
                 $resp_grava='';
                 $_SESSION['n_hawb_m']     =$n_hawb;
                 
                 $con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conex�o");
                 $res = mysql_select_db($banco_d) or die ("Banco de dados inexistente");

                 $verifi="SELECT controle,nome_desti,cep_desti,rua_desti,numero_desti,
                 comple_desti,bairro_desti,cidade_desti,estado_desti,entregador,recebedor,
                 documento,parentesco,date_format(dt_entrega,'%d/%m/%Y'),
                 hr_entrega,n_tentativas,volta_lista,dt_lista
                 FROM remessa
                 WHERE ((n_hawb='$n_hawb')
                 AND (entregador<>'')
                 AND (recebedor=''))";
                 $query = mysql_db_query($banco_d,$verifi,$con) or die ("N�o foi possivel acessar o banco");
                 $total = mysql_num_rows($query);

                 //Verifica se omovimento foi entregue

                 //Verifica se omovimento foi entregue

                  If ($total==0) {
                     $n_hawb='';
                     ?>
                     <script language="javascript"> window.location.href=("baixa_remessa_leitora.php")
                        alert('HAWB n�o consta de lista (BIP 2), portanto n�o foi entregue, ou ainda n�o foi lan�ada no sistema (BIP 1)! Verifique.');
                     </script>
                     <?php
                  }
                 else {
                    for($ic=0; $ic<$total; $ic++){
                       $mostra = mysql_fetch_row($query);
                       $controle       = $mostra[0];
                       $nome_desti     = $mostra[1];
                       $cep_desti      = $mostra[2];
                       $rua_desti      = $mostra[3];
                       $numero_desti   = $mostra[4];
                       $comple_desti   = $mostra[5];
                       $bairro_desti   = $mostra[6];
                       $cidade_desti   = $mostra[7];
                       $estado_desti   = $mostra[8];
                       $entregador     = $mostra[9];
                       $recebedor      = $mostra[10];
                       $documento      = $mostra[11];
                       $parentesco     = $mostra[12];
                       $dt_entrega     = $_SESSION['dt_entrega_m'];
                       $hr_entrega     = $_SESSION['hr_entrega_m'];
                       $n_tentativas   = $mostra[13];
                       $volta_lista    = $mostra[14];
                       $ocorrencia     = $mostra[15];
                       $dt_baixa       = $_SESSION['dt_baixa_m'];
                       $dt_lista       = $mostra[16];

                       $_SESSION['controle_m']    =$controle;
                       $_SESSION['recebedor_m']   =$recebedor;
                       $_SESSION['documento_m']   =$documento;
                       $_SESSION['parentesco_m']  =$parentesco;
                       $volta_lista               ='N';
                       $_SESSION['dt_lista_m']    =$dt_lista;
                    }
                 }

                 //Pega o nome do entregador.

                 $resultado = mysql_query ("SELECT nome
                 FROM pessoa
                 WHERE matricula='$entregador'");
                 $total = mysql_num_rows($resultado);

                 for($i=0; $i<$total; $i++){
                    $dados = mysql_fetch_row($resultado);
                    $nome_entregador       =$dados[0];
                 }
                 $_SESSION['nome_entregador_m']  =$nome_entregador;

              }
              $recebedor  =$_SESSION['recebedor_m'];
              $documento  =$_SESSION['documento_m'];
              $parentesco =$_SESSION['parentesco_m'];
         
         break;
         default:
     }

  ?>
  <form name="cadastro" action="baixa_remessa_manual.php" method="post">
	<table width="70%" border="1" cellpadding="5" cellspacing="0" bordercolor="#4169E1">
       <tr>
           <td align="center" colspan="3"><b>N�mero HAWB</b>
           <input type="text" name="n_hawb" id="n_hawb" value ="<?php echo "$codi_barra";?>" size="14" maxlength="14">
           <input name="mostra" type="submit" value="Mostra"></td>
         </tr>
         <!-- Coloca foco no primeiro campo codigo de barras do formul�rio -->
         <?php
          if ($foco == 0) { ?>
              <script language="JavaScript">
                 document.getElementById('n_hawb').focus()
              </script>
          <?php }?>
	   <tr>
			<td><b>Nome :</b></td>
			<td><?php echo "$nome_desti";?></td>
		</tr>
        <tr>
           <td><b>Entregador :</b></td>
           <td><?php echo "$entregador";?> - <?php echo "$nome_entregador";?></td>
        </tr>
        <tr>
           <td><b>Nome Recebedor :</b></td>
           <td><input type="text" name="recebedor" value ="<?php echo "$recebedor";?>" size="40" maxlength="40" id="recebedor"></td>
        </tr>
        <?php if ($foco == 1) { ?>
             <script language="JavaScript">
                document.getElementById('recebedor').focus()
             </script>
        <?php }?>
        <tr>
           <td><b>Documento Recebedor :</b></td>
           <td><input type="text" name="documento" value ="<?php echo "$documento";?>" size="30" maxlength="30" id="documento"></td>
        </tr>
        <tr>
			<td><b>Parentesco :</b></td>
            <td>
			 <?php
              mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conex�o");
              mysql_select_db($banco_d) or die ("Banco de dados inexistente");

              $resultado = mysql_query ("SELECT codigo,descricao
              FROM parentesco");
              echo "<select name='parentesco' class='caixa' align=\"left\">\n";
              while($linha = mysql_fetch_row($resultado))  {
                 printf("<option value='$linha[0]'>$linha[0] - $linha[1] </option>\n");
                 }
              ?>
              <script language="javascript">
                 var _parentesco = function( itemSelecionar){
                  parentesco = document.getElementById("parentesco");
                  for ( i =0; i < _parentesco.length; i++){
                    _parentesco[i].selected = _parentesco[i].value == itemSelecionar ? true : false;
                  }
                 }
                 Seleciona(<?php echo "$parentesco";?>);
             </script>
            </td>
        </tr>
        <tr>
          <td><b>Data da entrega :</b></td>
          <td>
            <input type="text" name="dt_entrega" value ="<?php echo "$dt_entrega";?>" size="12" maxlength="12" id="dt_entrega">
            <input TYPE="button" NAME="btndt_entrega" VALUE="..." Onclick="javascript:popdate('document.cadastro.dt_entrega','pop1','150',document.cadastro.dt_entrega.value)">
            <span id="pop1" style="position:absolute"></span>
          </td>
        </tr>
        <tr>
           <td><b>Hora da Entrega :</b></td>
           <td><input type="text" name="hr_entrega" value ="<?php echo "$hr_entrega";?>" size="10" maxlength="10" id="hr_entrega"></td>
        </tr>
        <tr>
			<td><b>Tentativas de Entrega:</b></td>
			<td><?php echo "$n_tentativas";?></td>
		</tr>
		<tr>
           <td><b>Volta a Lista :</b></td>
           <td><input type="text" name="volta_lista" value ="<?php echo "$volta_lista";?>" size="1" maxlength="1" id="volta_lista">(N - N�o, S - Sim - D - Devolver)</td>
        </tr>
         <tr>
          <td><b>Data da Baixa :</b></td>
          <td>
            <input type="text" name="dt_baixa" value ="<?php echo "$dt_baixa";?>" size="12" maxlength="12" id="dt_baixa">
            <input TYPE="button" NAME="btndt_baixa" VALUE="..." Onclick="javascript:popdate('document.cadastro.dt_baixa','pop2','150',document.cadastro.dt_baixa.value)">
            <span id="pop2" style="position:absolute"></span>
          </td>
        </tr>
        <tr>
			<td><b>Ocorr�ncia :</b></td>
            <td>
			 <?php
              mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conex�o");
              mysql_select_db($banco_d) or die ("Banco de dados inexistente");

              $resultado = mysql_query ("SELECT codigo,descricao
              FROM ocorrencia");
              echo "<select name='ocorrencia' class='caixa' align=\"left\">\n";
              while($linha = mysql_fetch_row($resultado))  {
                 printf("<option value='$linha[0]'>$linha[0] - $linha[1] </option>\n");
                 }
              ?>
              <script language="javascript">
                 var _ocorrencia = function( itemSelecionar){
                  ocorrencia = document.getElementById("ocorrencia");
                  for ( i =0; i < _ocorrencia.length; i++){
                    _ocorrencia[i].selected = _ocorrencia[i].value == itemSelecionar ? true : false;
                  }
                 }
                 Seleciona(<?php echo "$ocorrencia";?>);
             </script>
            </td>
        </tr>
		<tr>
		  <td colspan="2">
		     <div align="right">
			   <input name="baixa" type="submit" onclick="return validar()" value="Baixar">
			 </div>
		  </td>
		</tr>
	</table>
  </form>
  </div>
  <?php
      $nome_entregador  =$_SESSION['nome_entregador_m'];
	?>
    <table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#4169E1">
      <tr>
        <td colspan="6" align="center"><font face="arial" size="2"><b>LISTA ENTREGAS A BAIXAR</b></font></td>
      </tr>
      <tr>
         <td width="5%" align="center"><b>HAWB</b></td>
         <td width="25%" align="center"><b>NOME</b></td>
         <td width="25%" align="center"><b>RUA</b></td>
         <td width="5%" align="center"><b>NUMERO</b></td>
         <td width="20%" align="center"><b>BAIRRO</b></td>
         <td width="20%" align="center"><b>CIDADE</b></td>
         </tr>
      <?php
       $entregador   =$_SESSION['entregador_m'];

       mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conex�o");
       mysql_select_db($banco_d) or die ("Banco de dados inexistente");

       $resultado = mysql_query ("SELECT n_hawb,nome_desti,rua_desti,
       numero_desti,bairro_desti,cidade_desti
       FROM remessa
       WHERE ((entregador<>'')
       AND (recebedor=''))");
       $total = mysql_num_rows($resultado);

       for($i=0; $i<$total; $i++){
          $dados = mysql_fetch_row($resultado);
          $codigo_desti      =$dados[0];
          $nome_desti        =$dados[1];
          $rua_desti         =$dados[2];
          $numero_desti      =$dados[3];
          $bairro_desti      =$dados[4];
          $cidade_desti      =$dados[5];

          echo "<tr>";
            echo "<td width=\"5%\" align=\"left\"><font size=\"1\" face=\"arial\">$codigo_desti</font></td>";
            echo "<td width=\"25%\"><font size=\"1\" face=\"arial\">$nome_desti</font></td>";
            echo "<td width=\"25%\"><font size=\"1\" face=\"arial\">$rua_desti</font></td>";
            echo "<td width=\"5%\"><font size=\"1\" face=\"arial\">$numero_desti</font></td>";
            echo "<td width=\"20%\"><font size=\"1\" face=\"arial\">$bairro_desti</font></td>";
            echo "<td width=\"20%\"><font size=\"1\" face=\"arial\">$cidade_desti</font></td>";
         echo "</tr>";
       }
     ?>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td color="white" align="center" width="900" height="45" colspan="8" ><?php echo "$resp_grava";?></td>
      </tr>
  </table>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
       <td color="white" align="left" width="100%" height="40">
     </tr>
  </table>
  <table width="100%"  border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td background="img/blue.jpg" align="left" width="100%" height="45px"><center><font face="arial" size="1" color="white">Todos Direitos Reservados a NUNESTEC Tecnologia</font></td>
    </tr>
  </table>

</body>
</html>
