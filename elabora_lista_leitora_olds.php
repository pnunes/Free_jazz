<?php
  session_start();

   function get_post_action($name) {
    $params = func_get_args();
    foreach ($params as $name) {
        if (isset($_POST[$name])) {
            return $name;
        }
    }
   }

   $base_d     =$_SESSION['base_d'];
   $banco_d    =$_SESSION['banco_d'];
   $usuario_d  =$_SESSION['usuario_d'];
   $senha_d    =$_SESSION['senha_d'];

   //carrega variaveis com dados para acessar o banco de dados

   $matricula_m  =$_SESSION['matricula_m'];
   $programa='35';
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
  
   switch (get_post_action('gera','imprime','grava')) {
        case 'gera':
              $entregador                 =$_POST['entregador'];
              $dt_lista                   =$_POST['dt_envio'];
              //Apaga dados da sessão relativas a remessa anterior
              $ultimo = "SELECT * FROM nu_reme_manu ORDER BY numero DESC LIMIT 1";

              $query = mysql_db_query($banco_d,$ultimo,$con) or die ("Não foi possivel acessar o banco");
              $total = mysql_num_rows($query);
              for($ic=0; $ic<$total; $ic++){
                  $row = mysql_fetch_row($query);
                  $n_reme           = $row[0];
              }

                 $_SESSION['n_reme']  =$n_reme;

                 $mes_ano            =Substr(date("d-m-Y"),3,7);
                 $n_remessa          =$n_reme+1;

                 $_SESSION['n_reme']  =$n_remessa;

                 if (strlen($n_remessa)==1) {
                    $v_n_remessa='0000000'.$n_remessa.$mes_ano;
                 }
                 if (strlen($n_remessa)==2) {
                    $v_n_remessa='000000'.$n_remessa.$mes_ano;
                 }
                 if (strlen($n_remessa)==3) {
                    $v_n_remessa='00000'.$n_remessa.$mes_ano;
                 }
                 if (strlen($n_remessa)==4) {
                    $v_n_remessa='0000'.$n_remessa.$mes_ano;
                 }
                 if (strlen($n_remessa)==5) {
                    $v_n_remessa='000'.$n_remessa.$mes_ano;
                 }
                 if (strlen($n_remessa)==6) {
                    $v_n_remessa='00'.$n_remessa.$mes_ano;
                 }
                 if (strlen($n_remessa)==7) {
                    $v_n_remessa='0'.$n_remessa.$mes_ano;
                 }
                 if (strlen($n_remessa)==8) {
                    $v_n_remessa=$n_remessa.$mes_ano;
                 }

                 //Retira os traços da string

                 $v_n_remessa    =str_replace('-','',$v_n_remessa);

                 $_SESSION['v_n_remessa_m']   =$v_n_remessa;
                 $_SESSION['dt_envio_m']      =$dt_lista;
                 $_SESSION['entregador_m']    =$entregador;

        break;

        case 'imprime':
               $v_nu_lista    =$_SESSION['v_n_remessa_m'];
                //Conta o número de entregas do entregador para mostrar no relatório
               mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
               mysql_select_db($banco_d) or die ("Banco de dados inexistente");
               $contagem=mysql_query("SELECT COUNT(remessa_envio) AS numero FROM remessa
               WHERE remessa_envio='$v_nu_lista'");
               $total = mysql_num_rows($contagem);
               for($i=0; $i<$total; $i++){
                 $dados = mysql_fetch_row($contagem);
                 $numero      =$dados[0];
               }
               $_SESSION['numero_m']        =$numero;
               require_once("gera_relat_remessa_envio.php");
               gera_relat_remessa_envio();
          break;
          
          case 'grava':
               $v_n_remessa    =$_SESSION['v_n_remessa_m'];
               $n_hawb     =$_POST['n_hawb'];
               $remessa    =$_SESSION['v_n_remessa_m'];
               if (($n_hawb<>'') and ($remessa<>'')) {
                   $resp_grava='';
                   $con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
                   $res = mysql_select_db($banco_d) or die ("Banco de dados inexistente");

                   $verifi="SELECT controle,n_hawb,dt_lista
                   FROM remessa
                   WHERE n_hawb='$n_hawb'";
                   $query = mysql_db_query($banco_d,$verifi,$con) or die ("Não foi possivel acessar o banco");
                   $total = mysql_num_rows($query);

                   //Verifica se omovimento foi lançado

                   If ($total == 0 ) {
                      $n_hawb='';
                      ?>
                      <script language="javascript"> window.location.href=("envia_fisico_remessa.php")
                       alert('Esta HAWB não foi lançada no sistema (BIP 1)! Verifique.');
                      </script>
                      <?php
                   }
                   else {
                      for($ic=0; $ic<$total; $ic++){
                         $mostra = mysql_fetch_row($query);
                         $controle       = $mostra[0];
                         $n_hawb         = $mostra[1];
                         $dt_lista_c     = $mostra[2];
                      }
                      $_SESSION['controle_m']    =$controle;
                      $_SESSION['n_hawb_m']      =$n_hawb;

                      //Pega nome entregador na tabela pessoa
                      $entregador   =$_SESSION['entregador_m'];
                      mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
                      mysql_select_db($banco_d) or die ("Banco de dados inexistente");

                      $resultado = mysql_query ("SELECT nome FROM pessoa WHERE matricula='$entregador'");
                      $total = mysql_num_rows($resultado);

                      for($i=0; $i<$total; $i++){
                        $dados = mysql_fetch_row($resultado);
                        $nome_entregador      =$dados[0];
                      }
                      $_SESSION['nome_entregador_m']   =$nome_entregador;

                      //Verifica se a HAWB já foi lançada em alguma outra lista deentrega

                      If ($dt_lista_c <>'0000-00-00') {
                         $n_hawb='';
                         ?>
                           <script language="javascript"> window.location.href=("envia_fisico_remessa.php")
                             alert('HAWB já incluida em lista de entrega ! Verifique.');
                           </script>
                         <?php
                      }
                      If ($dt_lista_c=='0000-00-00') {

                          //Grava movimento
                          
                          $dt_lista         =$_SESSION['dt_envio_m'];
                          $controle         =$_SESSION['controle_m'];
                          $v_n_remessa      =$_SESSION['v_n_remessa_m'];
                          $entregador       =$_SESSION['entregador_m'];
                          
                          $dt_lista  = explode("/",$dt_lista);
                          $v_dt_lista = $dt_lista[2]."-".$dt_lista[1]."-".$dt_lista[0];

                          $con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
                          $res = mysql_select_db($banco_d) or die ("Banco de dados inexistente");

                          $alteracao = "UPDATE remessa SET dt_lista='$v_dt_lista',
                          nu_lista='$v_n_remessa',entregador='$entregador'
                          WHERE controle='$controle'";

                          if (mysql_db_query($banco_d,$alteracao,$con)) {

                              //Atualiza a tabela log_operação sistema

                              $programa     =$_SESSION['programa_m'];
                              $matricula_m  =$_SESSION['matricula_m'];
                              $n_hawb       =$_SESSION['n_hawb_m'];

                              $con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
                              $res = mysql_select_db($banco_d) or die ("Banco de dados inexistente");

                              $inclui="INSERT INTO log_operacao_sistema(matricula,tarefa_executada,data,hora,rotina,n_hawb)
                              VALUES('$matricula_m','Elabora Lista Envio HAWB Origem','$data','$hora','$programa','$n_hawb')";
                              mysql_db_query($banco_d,$inclui,$con);

                           //////////////////Atualiza a tabela de histórico HAWB /////////////////////////////////
                              $atualiza="INSERT INTO controle_reentrega (n_hawb,dt_evento,ocorrencia)
                              VALUES('$n_hawb','$v_dt_lista','HAWB em rotade entrega.')";
                              mysql_db_query($banco_d,$atualiza,$con);

                              $resp_grava="Gravação bem sucedida !";

                              //Atualiza a tabela de controle de numero de remessas

                              $n_remes=   $_SESSION['n_reme'];

                              $con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
                              $res = mysql_select_db($banco_d) or die ("Banco de dados inexistente");

                              $verifi="SELECT numero FROM nu_reme_manu WHERE numero='$n_remes'";
                              $query = mysql_db_query($banco_d,$verifi,$con) or die ("Não foi possivel acessar o banco_2");
                              $achou = mysql_num_rows($query);

                              If ($achou == 0 ) {
                                 $atualiza = "INSERT INTO nu_reme_manu(numero,dt_remessa)
                                 values('$n_remes','$v_dt_envio')";

                                 mysql_db_query($banco_d,$atualiza,$con);
                              }
                              $n_hawb      ='';
                              $controle    ='';
                              unset($_SESSION['controle_m']);
                              $v_n_remessa  =$_SESSION['v_n_remessa_m'];
                           }
                           else {
                              $resp_grava="Problemas na gravação!";
                           }


                    }
                  }
               }
               else {
                 ?>
                 <script language="javascript"> window.location.href=("envia_fisico_remessa.php")
                      alert('Você tem que definir uma data e gerar um número de remessa.');
                   </script>
                 <?php
               }
          break;
   }
   include ("campo_calendario.php");

   $codi_barra =$_POST['cod_barra'];
   $remessa    =$_SESSION['v_n_remessa_m'];
   if (($codi_barra<>'') and ($remessa<>'')) {
       $resp_grava='';
       $con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
       $res = mysql_select_db($banco_d) or die ("Banco de dados inexistente");

       $verifi="SELECT controle,n_hawb,dt_lista
       FROM remessa
       WHERE cod_barra='$codi_barra'";
       $query = mysql_db_query($banco_d,$verifi,$con) or die ("Não foi possivel acessar o banco");
       $total = mysql_num_rows($query);

       //Verifica se omovimento foi lançado

       If ($total == 0 ) {
          $codi_barra='';
          ?>
          <script language="javascript"> window.location.href=("envia_fisico_remessa.php")
           alert('Esta HAWB não foi lançada no sistema (BIP 1)! Verifique.');
          </script>
          <?php
       }
       else {
          for($ic=0; $ic<$total; $ic++){
             $mostra = mysql_fetch_row($query);
             $controle       = $mostra[0];
             $n_hawb         = $mostra[1];
             $dt_lista_c     = $mostra[2];
          }
          $_SESSION['controle_m']    =$controle;
          $_SESSION['n_hawb_m']      =$n_hawb;

          //Pega nome entregador na tabela pessoa
          $entregador   =$_SESSION['entregador_m'];
          mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
          mysql_select_db($banco_d) or die ("Banco de dados inexistente");

          $resultado = mysql_query ("SELECT nome FROM pessoa WHERE matricula='$entregador'");
          $total = mysql_num_rows($resultado);

          for($i=0; $i<$total; $i++){
            $dados = mysql_fetch_row($resultado);
            $nome_entregador      =$dados[0];
          }
          $_SESSION['nome_entregador_m']   =$nome_entregador;

          //Verifica se a HAWB já foi lançada em alguma outra lista deentrega

          If ($dt_lista_c <>'0000-00-00') {
             $codi_barra='';
             ?>
               <script language="javascript"> window.location.href=("envia_fisico_remessa.php")
                 alert('HAWB já incluida em lista de entrega ! Verifique.');
               </script>
             <?php
          }
          If ($dt_lista_c=='0000-00-00') {

              //Grava movimento

              $dt_lista         =$_SESSION['dt_envio_m'];
              $controle         =$_SESSION['controle_m'];
              $v_n_remessa      =$_SESSION['v_n_remessa_m'];
              $entregador       =$_SESSION['entregador_m'];

              $dt_lista  = explode("/",$dt_lista);
              $v_dt_lista = $dt_lista[2]."-".$dt_lista[1]."-".$dt_lista[0];

              $con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
              $res = mysql_select_db($banco_d) or die ("Banco de dados inexistente");

              $alteracao = "UPDATE remessa SET dt_lista='$v_dt_lista',
              nu_lista='$v_n_remessa',entregador='$entregador'
              WHERE controle='$controle'";

              if (mysql_db_query($banco_d,$alteracao,$con)) {

                  //Atualiza a tabela log_operação sistema

                  $programa     =$_SESSION['programa_m'];
                  $matricula_m  =$_SESSION['matricula_m'];
                  $n_hawb       =$_SESSION['n_hawb_m'];

                  $con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
                  $res = mysql_select_db($banco_d) or die ("Banco de dados inexistente");

                  $inclui="INSERT INTO log_operacao_sistema(matricula,tarefa_executada,data,hora,rotina,n_hawb)
                  VALUES('$matricula_m','Elabora Lista Envio HAWB Origem','$data','$hora','$programa','$n_hawb')";
                  mysql_db_query($banco_d,$inclui,$con);

               //////////////////Atualiza a tabela de histórico HAWB /////////////////////////////////
                  $atualiza="INSERT INTO controle_reentrega (n_hawb,dt_evento,ocorrencia)
                  VALUES('$n_hawb','$v_dt_lista','HAWB em rotade entrega.')";
                  mysql_db_query($banco_d,$atualiza,$con);

                  $resp_grava="Gravação bem sucedida !";

                  //Atualiza a tabela de controle de numero de remessas

                  $n_remes=   $_SESSION['n_reme'];

                  $con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
                  $res = mysql_select_db($banco_d) or die ("Banco de dados inexistente");

                  $verifi="SELECT numero FROM nu_reme_manu WHERE numero='$n_remes'";
                  $query = mysql_db_query($banco_d,$verifi,$con) or die ("Não foi possivel acessar o banco_2");
                  $achou = mysql_num_rows($query);

                  If ($achou == 0 ) {
                     $atualiza = "INSERT INTO nu_reme_manu(numero,dt_remessa)
                     values('$n_remes','$v_dt_envio')";

                     mysql_db_query($banco_d,$atualiza,$con);
                  }
                  $n_hawb      ='';
                  $controle    ='';
                  unset($_SESSION['controle_m']);
                  $v_n_remessa  =$_SESSION['v_n_remessa_m'];
               }
               else {
                  $resp_grava="Problemas na gravação!";
               }


        }
      }
   }

?>
<html>
  <title>elabora_lista_leitora.php</title>
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
   <script>
       function salva(campo){
            cadastro.submit()
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

   
   </script>
  </head>
  <div id="geral" align="center">
    <body onkeydown="desabilitaCtrlJ(event)" topmargin="0" leftmargin="0" rightmargin="0" bottommargin="0" marginheight="0" marginwidth="0" bgcolor="#FFFFFF">
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
         <p align="right"><font face="Arial" size="2" color="#FFFFFF"><b>Elabora Lista de Entrega Com Leitora</b></font></td>
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
   <form method="POST" name="cadastro" action="elabora_lista_leitora.php" border="20" align="center">
      <table width="80%" heigth="300">
        <tr>
            <td colspan="3" align="center">
			 <?php
              $adm_m        =$_SESSION['adm_m'];
              $depto        =$_SESSION['depto_m'];
              if ($adm_m=='N') {
                  echo "<Font size=\"2\" face=\"ARIAL\">Entregador..:</font>";
                  $entregador   =$_SESSION['entregador_m'];
                  mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
                  mysql_select_db($banco_d) or die ("Banco de dados inexistente");
                  ?>
                  <select name="entregador">
                  <?php
                   $resultado ="SELECT matricula,nome FROM pessoa WHERE depto='$depto'";
                   $resul = mysql_db_query($banco_d,$resultado,$con) or die ("Não foi possivel acessar o banco");
                   while ( $linha = mysql_fetch_array($resul)) {
                      $select = $entregador == $linha[0] ? "selected" : "";
                      echo "<option value=\"". $linha[0] . "\" $select>" . $linha[1] . "</option>";
                   }
                  ?>
                  </select>
              <?php
              }
              if ($adm_m=='S') {
                  echo "<Font size=\"2\" face=\"ARIAL\">Entregador..:</font>";
                  $entregador   =$_SESSION['entregador_m'];
                  mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
                  mysql_select_db($banco_d) or die ("Banco de dados inexistente");
                  ?>
                  <select name="entregador">
                  <?php
                   $resultado ="SELECT matricula,nome FROM pessoa";
                   $resul = mysql_db_query($banco_d,$resultado,$con) or die ("Não foi possivel acessar o banco");
                   while ( $linha = mysql_fetch_array($resul)) {
                      $select = $entregador == $linha[0] ? "selected" : "";
                      echo "<option value=\"". $linha[0] . "\" $select>" . $linha[1] . "</option>";
                   }
                  ?>
                  </select>
              <?php
              }
              ?>
            </td>
        </tr>
        <tr>
          <?php $v_dt_envio  =$_SESSION['dt_envio_m'];?>
          <td colspan="3"  align="center">
            <b>Data da Lista :</b>
            <input type="text" name="dt_envio" value ="<?php echo "$v_dt_envio";?>" size="12" maxlength="12" id="dt_envio">
            <input TYPE="button" NAME="btndt_envio" VALUE="..." Onclick="javascript:popdate('document.cadastro.dt_envio','pop1','150',document.cadastro.dt_envio.value)">
            <span id="pop1" style="position:absolute"></span>
          </td>
        </tr>
        <tr>
			<td  align="center"><b>Numero da Lista :</b>
			<?php $v_n_remessa      =$_SESSION['v_n_remessa_m'];?>
			<input name="remessa_envio" type="text" value ="<?php echo "$v_n_remessa";?>" size="17" maxlength="17" id="remessa_envio"><input name="gera" type="submit" value="Gera Remessa"></td></td>
		</tr>
      </table>
       <table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#4169E1">
         <tr>
           <td colspan="7" align="center"><font face="arial" size="2"><b>LISTA DE ENTREGA DE :<?php echo "$nome_cliente";?></b></font></td>
         </tr>
         <tr>
           <td width="2%" align="center"><b>N.</b></td>
           <td width="5%" align="center"><b>N. HAWB</b></td>
           <td width="24%" align="center"><b>NOME</b></td>
           <td width="24%" align="center"><b>RUA</b></td>
           <td width="5%" align="center"><b>NUMERO</b></td>
           <td width="20%" align="center"><b>BAIRRO</b></td>
           <td width="15%" align="center"><b>CIDADE</b></td>
         </tr>
        <?php
         $v_n_remessa   =$_SESSION['v_n_remessa_m'];
         mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
         mysql_select_db($banco_d) or die ("Banco de dados inexistente");

         $resultado = mysql_query ("SELECT n_hawb,nome_desti,rua_desti,
         numero_desti,bairro_desti,cidade_desti
         FROM remessa
         WHERE ((remessa_envio='$v_n_remessa')
         AND(remessa_envio<>''))");
         $total = mysql_num_rows($resultado);
         $ni=0;
         for($i=0; $i<$total; $i++){
          $dados = mysql_fetch_row($resultado);
          $n_hawb            =$dados[0];
          $nome_desti        =$dados[1];
          $rua_desti         =$dados[2];
          $numero_desti      =$dados[3];
          $bairro_desti      =$dados[4];
          $cidade_desti      =$dados[5];
          $ni=$i+1;
          echo "<tr>";
            echo "<td width=\"2%\" align=\"left\"><font size=\"1\" face=\"arial\">$ni</font></td>";
            echo "<td width=\"5%\" align=\"left\"><font size=\"1\" face=\"arial\">$n_hawb</font></td>";
            echo "<td width=\"24%\"><font size=\"1\" face=\"arial\">$nome_desti</font></td>";
            echo "<td width=\"24%\"><font size=\"1\" face=\"arial\">$rua_desti</font></td>";
            echo "<td width=\"5%\"><font size=\"1\" face=\"arial\">$numero_desti</font></td>";
            echo "<td width=\"20%\"><font size=\"1\" face=\"arial\">$bairro_desti</font></td>";
            echo "<td width=\"15%\"><font size=\"1\" face=\"arial\">$cidade_desti</font></td>";
         echo "</tr>";
       }
    ?>
    <tr>
      <td colspan="7">
        <div align="right">
         <input name="imprime" type="submit" value="Imprimir">
        </div>
      </td>
    </tr>
  </form>
  <body leftmargin="10" topmargin="10" marginwidth="10" marginheight="10">
  <form name="cadastro_1" action="elabora_lista_leitora.php" method="post">
	<table width="50%" border="1" cellpadding="5" cellspacing="0" bordercolor="#4169E1">
         <tr>
           <td align="center" colspan="3"><b>Codigo Barras:</b>
           <input type="text" name="cod_barra" id="cod_barra" size="50" maxlength="50" onChange="salva(this)"></td>
         </tr>
         <tr>
           <td><b>Número da HAWB:</b></td>
           <td><input type="text" name="n_hawb" class="campo" id="n_hawb" size="30" maxlength="30"><input name="grava" type="submit" value="Grava"></td></td>
	     </tr>
         <!-- Coloca foco no primeiro campo codigo de barras do formulário -->
         
         <script language="JavaScript">
            document.getElementById('cod_barra').focus()
         </script>
   	</table>
  </form>
  </div>
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

