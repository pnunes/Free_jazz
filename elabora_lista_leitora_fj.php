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

   //RECUPERAVARIAVEIS DE ACESSO AOBANCO

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

    switch (get_post_action('seleciona','imprime','grava','lista')) {
          case 'seleciona':
          
             //Seleciona o entregador e gera o número da lista dele
          
             $entregador                 =$_POST['entregador'];
             $_SESSION['entregador_m']   =$entregador;
             $dt_lista                   =$_POST['dt_lista'];
             $_SESSION['dt_lista_m']     =$dt_lista;
             
             $dt_lista  = explode("/",$dt_lista);
             $v_dt_lista = $dt_lista[2]."-".$dt_lista[1]."-".$dt_lista[0];
             $_SESSION['v_dt_lista_m']     =$v_dt_lista;
             //Pega nome entregador na tabela cli_for

             mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
             mysql_select_db($banco_d) or die ("Banco de dados inexistente");

             $resultado = mysql_query ("SELECT nome
             FROM pessoa
             WHERE matricula='$entregador'");
             $total = mysql_num_rows($resultado);

             for($i=0; $i<$total; $i++){
                $dados = mysql_fetch_row($resultado);
                $nome_entregador      =$dados[0];
             }
             $_SESSION['nome_entregador_m']   =$nome_entregador;
             
          break;
          
          case 'lista':

             //Gera número para a lista

              //Pega codigo entregador
              
              $entregador   =$_SESSION['entregador_m'];

              $con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
              $res = mysql_select_db($banco_d) or die ("Banco de dados inexistente");

              $ultimo = "SELECT * FROM controle_lista ORDER BY numero DESC LIMIT 1";
              $query = mysql_db_query($banco_d,$ultimo,$con) or die ("Não foi possivel acessar o banco");
              $total = mysql_num_rows($query);
              for($ic=0; $ic<$total; $ic++){
                  $row = mysql_fetch_row($query);
                  $numero_lista       = $row[0];
              }
              $v_numero_lista        =$numero_lista+1;
              $_SESSION['numero_lista_m']  =$v_numero_lista;
              
              //Grava o numero da lista na tabela
              
              $atualiza = "INSERT INTO controle_lista(numero,dt_lista,entregador)
              values('$v_numero_lista','$v_dt_lista','$entregador')";

              mysql_db_query($banco_d,$atualiza,$con);

          break;
          case 'grava':
               $n_hawb     =$_POST['n_hawb'];
               if ($n_hawb<>'') {
                   $entregador =$_SESSION['entregador_m'];
                   If ($entregador =='') {
                      ?>
                      <script language="javascript"> window.location.href=("elabora_lista_leitora.php")
                         alert('Você precisa selecionar um entregador e clicar no botão SELECIONAR!');
                      </script>
                      <?php
                   }
                   $resp_grava='';
                   $con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
                   $res = mysql_select_db($banco_d) or die ("Banco de dados inexistente");

                   $verifi="SELECT controle,n_tentativas,n_hawb,cod_barra
                   FROM remessa
                   WHERE n_hawb='$n_hawb'";
                   $query = mysql_db_query($banco_d,$verifi,$con) or die ("Não foi possivel acessar o banco");
                   $total = mysql_num_rows($query);

                   //Verifica se a hawb foi lançada no sistema

                   If ($total == 0 ) {
                      $n_hawb='';
                      ?>
                        <script language="javascript"> window.location.href=("elabora_lista_leitora.php")
                            alert('HAWB Não lançada no sistema !');
                        </script>
                      <?php
                   }
                   else {
                      for($ic=0; $ic<$total; $ic++){
                         $mostra = mysql_fetch_row($query);
                         $controle       = $mostra[0];
                         $n_tentativas   = $mostra[1];
                         $n_hawb         = $mostra[2];
                         $codi_barra_g   = $mostra[3];
                      }
                      $n_tentativas              =$n_tentativas+1;
                      $_SESSION['tentativas_m']  =$n_tentativas;
                      $_SESSION['controle_m']    =$controle;
                      $_SESSION['n_hawb_m']      =$n_hawb;
                      $_SESSION['cod_barra_g']   =$codi_barra_g;

                      //Verifica se a HAWB já tem entregador definido

                      $con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
                      $res = mysql_select_db($banco_d) or die ("Banco de dados inexistente");

                      $localiza = "SELECT controle,entregador
                      FROM remessa
                      WHERE controle='$controle'";

                      $query = mysql_db_query($banco_d,$localiza,$con) or die ("Não foi possivel acessar o banco 1");
                      $achou = mysql_num_rows($query);

                      for($ic=0; $ic<$total; $ic++){
                         $mostra = mysql_fetch_row($query);
                         $controle       = $mostra[0];
                         $entrega        = $mostra[1];
                      }
                      If ($entrega <>'') {
                         $codi_barra='';
                         ?>
                           <script language="javascript"> window.location.href=("elabora_lista_leitora.php")
                            alert('HAWB já lançada em lista de entrega ! Verifique.');
                           </script>
                         <?php
                      }
                      else {
                           //grava o movimento

                           $entregador      =$_SESSION['entregador_m'];
                           $v_dt_lista      =$_SESSION['v_dt_lista_m'];
                           $n_tentativas    =$_SESSION['tentativas_m'];
                           $controle        =$_SESSION['controle_m'];
                           $codi_cli        =$_SESSION['codi_cli_m'];
                           $tipo_servi      =$_SESSION['tipo_servi_m'];
                           $v_nu_lista      =$_SESSION['numero_lista_m'];
                           $estatus         ='BIP2';
                           $v_dt_lista      =$_SESSION['v_dt_lista_m'];

                           $con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
                           $res = mysql_select_db($banco_d) or die ("Banco de dados inexistente");

                           $alteracao = "UPDATE remessa SET entregador='$entregador',dt_lista='$v_dt_lista',
                           n_tentativas='$n_tentativas',nu_lista='$v_nu_lista',estatus='$estatus',
                           tipo_servi='$tipo_servi'
                           WHERE controle='$controle'";

                           if (mysql_db_query($banco_d,$alteracao,$con)) {

                              //Atualiza a tabela log_operação sistema

                              $programa     =$_SESSION['programa_m'];
                              $matricula_m  =$_SESSION['matricula_m'];
                              $hora         = date ('H:i:s');
                              $data         = date('Y-m-d');
                              $n_hawb       =$_SESSION['n_hawb_m'];
                              $codi_barra_g =$_SESSION['cod_barra_g'];

                              $con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
                              $res = mysql_select_db($banco_d) or die ("Banco de dados inexistente");

                              $inclui="INSERT INTO log_operacao_sistema(matricula,tarefa_executada,data,hora,rotina,n_hawb)
                              VALUES('$matricula_m','Elabora Lista com leitora','$data','$hora','$programa','$n_hawb')";
                              mysql_db_query($banco_d,$inclui,$con);
                              
                              //////////////////Atualiza a tabela de histórico HAWB /////////////////////////////////
                              $atualiza="INSERT INTO controle_reentrega (n_hawb,dt_evento,ocorrencia,cod_barra,ordem)
                              VALUES('$n_hawb','$v_dt_lista','Em rota de entrega.','$codi_barra_g','2')";
                              mysql_db_query($banco_d,$atualiza,$con);
                              
                              $resp_grava="Inclusão bem sucedida";

                              $codi_barra          ='';
                              $controle            ='';
                              unset($_SESSION['tentativas_m']);
                              unset($_SESSION['controle_m']);
                              unset($_SESSION['n_hawb_m']);
                              unset($_SESSION['cod_barra_g']);
                           }
                           else {
                              $resp_grava="Problemas na Inclusão";
                           }
                      }
                   }
               }
               else  {
                  ?>
                  <script language="javascript"> window.location.href=("elabora_lista_leitora.php")
                     alert('Informe um número de HAWB válido.');
                  </script>
                  <?php
               }
          break;

          case 'imprime':
               $entregador      =$_SESSION['entregador_m'];
               $v_numero_lista  =$_SESSION['numero_lista_m'];
               
               //Conta o número de entregas do entregador para mostrar no relatório
               
               mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
               mysql_select_db($banco_d) or die ("Banco de dados inexistente");
               
               $contagem=mysql_query("SELECT COUNT(n_hawb) AS numero FROM remessa
               WHERE nu_lista='$v_numero_lista'");
               $total = mysql_num_rows($contagem);
               for($i=0; $i<$total; $i++){
                 $dados = mysql_fetch_row($contagem);
                 $numero      =$dados[0];
               }
               $_SESSION['numero_m']   =$numero;
               require_once("gera_lista.php");
               gera_lista();
          break;
          default:
    }
    include ("campo_calendario.php");
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
   <script type="text/javascript">
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
      <table width="50%" border="1" cellpadding="5" cellspacing="0" bordercolor="#4169E1">
         <tr>
          <td><b>Data cadastro :</b></td>
          <td>
            <?php $dt_lista   =$_SESSION['dt_lista_m'];?>
            <input type="text" name="dt_lista" value ="<?php echo "$dt_lista";?>" size="12" maxlength="12" id="dt_lista">
            <input TYPE="button" NAME="btndt_lista" VALUE="..." Onclick="javascript:popdate('document.cadastro.dt_lista','pop1','150',document.cadastro.dt_lista.value)">
            <span id="pop1" style="position:absolute"></span>
          </td>
        </tr>
         <tr>
            <td><b>Entregador :</b></td>
            <td>
			 <?php
                  $adm    =$_SESSION['adm_m'];
                  $depto  =$_SESSION['depto_m'];
                  if ($adm=='S') {
                     $entregador   =$_SESSION['entregador_m'];
                     mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
                     mysql_select_db($banco_d) or die ("Banco de dados inexistente");
                     ?>
                     <select name="entregador">
                     <?php
                     $resultado ="SELECT matricula,nome FROM pessoa WHERE ativo='S'";
                     $resul = mysql_db_query($banco_d,$resultado,$con) or die ("Não foi possivel acessar o banco");
                     while ( $linha = mysql_fetch_array($resul)) {
                        $select = $entregador == $linha[0] ? "selected" : "";
                        echo "<option value=\"". $linha[0] . "\" $select>" . $linha[1] . "</option>";
                     }
                   }
                   if ($adm=='N') {
                     $entregador   =$_SESSION['entregador_m'];
                     mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
                     mysql_select_db($banco_d) or die ("Banco de dados inexistente");
                     ?>
                     <select name="entregador">
                     <?php
                     $resultado ="SELECT matricula,nome FROM pessoa WHERE ((ativo='S') and (depto='$depto'))";
                     $resul = mysql_db_query($banco_d,$resultado,$con) or die ("Não foi possivel acessar o banco");
                     while ( $linha = mysql_fetch_array($resul)) {
                        $select = $entregador == $linha[0] ? "selected" : "";
                        echo "<option value=\"". $linha[0] . "\" $select>" . $linha[1] . "</option>";
                     }
                   }
                    ?>
                  </select>
                  <input name="seleciona" type="submit" value="Selecionar">
            </td>
        </tr>
        <tr>
           <?php $v_nu_lista  =$_SESSION['numero_lista_m'];?>
           <td><b>Número Lista:</b></td>
           <td><input type="text" name="n_lista" class="campo" value ="<?php echo "$v_nu_lista";?>" id="n_lista"><input name="lista" type="submit" value="Gera Número Lista"></td>
		</tr>
       </table>
      <?php

       $codi_barra     =$_POST['cod_barra'];
       if ($codi_barra<>'') {
           $entregador =$_SESSION['entregador_m'];
           If ($entregador =='') {
              ?>
              <script language="javascript"> window.location.href=("elabora_lista_leitora.php")
                 alert('Você precisa selecionar um entregador e clicar no botão SELECIONAR!');
              </script>
              <?php
           }
           $v_nu_lista  =$_SESSION['numero_lista_m'];
           If ($v_nu_lista =='') {
              ?>
              <script language="javascript"> window.location.href=("elabora_lista_leitora.php")
                 alert('Você precisa gerar um número de lista!');
              </script>
              <?php
           }
           else {
               $_SESSION['cod_barra_g'] =$codi_barra;
               $resp_grava='';
               $con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
               $res = mysql_select_db($banco_d) or die ("Banco de dados inexistente");

               $verifi="SELECT controle,n_tentativas,n_hawb FROM remessa
               WHERE cod_barra='$codi_barra'";
               $query = mysql_db_query($banco_d,$verifi,$con) or die ("Não foi possivel acessar o banco");
               $total = mysql_num_rows($query);

               //Verifica se a hawb foi lançada no sistema

               If ($total == 0 ) {
                  $codi_barra='';
                  ?>
                  <script language="javascript"> window.location.href=("elabora_lista_leitora.php")
                   alert('HAWB não lançada no sistema! Verifique.');
                  </script>
                  <?php
               }
               else {
                  for($ic=0; $ic<$total; $ic++){
                     $mostra = mysql_fetch_row($query);
                     $controle       = $mostra[0];
                     $n_tentativas   = $mostra[1];
                     $n_hawb         = $mostra[2];
                  }
                  $n_tentativas              =$n_tentativas+1;
                  $_SESSION['tentativas_m']  =$n_tentativas;
                  $_SESSION['controle_m']    =$controle;
                  $_SESSION['n_hawb_m']      =$n_hawb;

                  //Verifica se a HAWB já tem entregador definido

                  $con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
                  $res = mysql_select_db($banco_d) or die ("Banco de dados inexistente");

                  $localiza = "SELECT controle,entregador
                  FROM remessa
                  WHERE controle='$controle'";

                  $query = mysql_db_query($banco_d,$localiza,$con) or die ("Não foi possivel acessar o banco");
                  $achou = mysql_num_rows($query);
                  for($ic=0; $ic<$total; $ic++){
                     $mostra = mysql_fetch_row($query);
                     $controle       = $mostra[0];
                     $entrega        = $mostra[1];
                  }

                  If ($entrega <>'') {
                      $codi_barra='';
                      ?>
                      <script language="javascript"> window.location.href=("elabora_lista_leitora.php")
                        alert('HAWB já lançada em lista de entrega ! Verifique.');
                      </script>
                      <?php
                  }
                  else {
                       //grava o movimento

                       $entregador     =$_SESSION['entregador_m'];
                       $v_dt_lista     =$_SESSION['v_dt_lista_m'];
                       $n_tentativas   =$_SESSION['tentativas_m'];
                       $controle       =$_SESSION['controle_m'];
                       $codi_cli       =$_SESSION['codi_cli_m'];
                       $tipo_servi     =$_SESSION['tipo_servi_m'];
                       $v_nu_lista     =$_SESSION['numero_lista_m'];
                       $estatus        ='BIP2';
                       $con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
                       $res = mysql_select_db($banco_d) or die ("Banco de dados inexistente");

                       $alteracao = "UPDATE remessa SET entregador='$entregador',dt_lista='$v_dt_lista',
                       n_tentativas='$n_tentativas',nu_lista='$v_nu_lista',
                       estatus='$estatus'
                       WHERE controle='$controle'";

                       if (mysql_db_query($banco_d,$alteracao,$con)) {

                          //Atualiza a tabela log_operação sistema

                          $programa     =$_SESSION['programa_m'];
                          $matricula_m  =$_SESSION['matricula_m'];
                          $hora         = date ('H:i:s');
                          $data         = date('Y-m-d');
                          $n_hawb       =$_SESSION['n_hawb_m'];
                          $codi_barra_g =$_SESSION['cod_barra_g'];
                          
                          $con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
                          $res = mysql_select_db($banco_d) or die ("Banco de dados inexistente");

                          $inclui="INSERT INTO log_operacao_sistema(matricula,tarefa_executada,data,hora,rotina,n_hawb)
                          VALUES('$matricula_m','Elabora Lista com leitora','$data','$hora','$programa','$n_hawb')";
                          mysql_db_query($banco_d,$inclui,$con);

                          $resp_grava="Inclusão bem sucedida";
                          
                          //////////////////Atualiza a tabela de histórico HAWB /////////////////////////////////
                          $atualiza="INSERT INTO controle_reentrega (n_hawb,dt_evento,ocorrencia,cod_barra,ordem)
                          VALUES('$n_hawb','$v_dt_lista','Em rota de entrega.','$codi_barra_g','2')";
                          mysql_db_query($banco_d,$atualiza,$con);

                          $codi_barra          ='';
                          $controle            ='';
                          unset($_SESSION['tentativas_m']);
                          unset($_SESSION['controle_m']);
                          unset($_SESSION['n_hawb_m']);
                          unset($_SESSION['cod_barra_g']);
                          $v_numero_lista  =$_SESSION['numero_lista_m'];
                       }
                       else {
                          $resp_grava="Problemas na Inclusão";
                       }
                  }
               }
           }
       }
       //Mostra as remessas do entregador selecionada
       $nome_entregador  =$_SESSION['nome_entregador_m'];
	   ?>
       <table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#4169E1">
         <tr>
           <td colspan="8" align="center"><font face="arial" size="2"><b>LISTA ENTREGA DE :<?php echo "$nome_entregador";?></b></font></td>
         </tr>
         <tr>
           <td width="2%" align="center"><b>N.</b></td>
           <td width="5%" align="center"><b>N. HAWB</b></td>
           <td width="24%" align="center"><b>NOME</b></td>
           <td width="24%" align="center"><b>RUA</b></td>
           <td width="5%" align="center"><b>NUMERO</b></td>
           <td width="20%" align="center"><b>BAIRRO</b></td>
           <td width="15%" align="center"><b>CIDADE</b></td>
           <td width="4%" align="center"><b>LST</b></td>
         </tr>
        <?php
         $entregador     =$_SESSION['entregador_m'];
         $v_nu_lista     =$_SESSION['numero_lista_m'];
         mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
         mysql_select_db($banco_d) or die ("Banco de dados inexistente");

         $resultado = mysql_query ("SELECT n_hawb,nome_desti,rua_desti,
         numero_desti,bairro_desti,cidade_desti,nu_lista
         FROM remessa
         WHERE ((entregador='$entregador')
         AND (nu_lista='$v_nu_lista'))");
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
          $n_lista           =$dados[6];
          $ni=$i+1;
          echo "<tr>";
            echo "<td width=\"2%\" align=\"left\"><font size=\"1\" face=\"arial\">$ni</font></td>";
            echo "<td width=\"5%\" align=\"left\"><font size=\"1\" face=\"arial\">$n_hawb</font></td>";
            echo "<td width=\"24%\"><font size=\"1\" face=\"arial\">$nome_desti</font></td>";
            echo "<td width=\"24%\"><font size=\"1\" face=\"arial\">$rua_desti</font></td>";
            echo "<td width=\"5%\"><font size=\"1\" face=\"arial\">$numero_desti</font></td>";
            echo "<td width=\"20%\"><font size=\"1\" face=\"arial\">$bairro_desti</font></td>";
            echo "<td width=\"15%\"><font size=\"1\" face=\"arial\">$cidade_desti</font></td>";
            echo "<td width=\"4%\"><font size=\"1\" face=\"arial\">$n_lista</font></td>";
         echo "</tr>";
       }
    ?>
    <tr>
     <td><INPUT type=button value="Reimprime Lista."
         onClick="window.open('reimprime_lista_dia.php','janela_1',
         'scrollbars=yes,resizable=yes,width=800,height=400');">
      </td>
      <td colspan="7">
        <div align="right">
         <input name="imprime" type="submit" value="Imprimir">
        </div>
      </td>
    </tr>
    <body leftmargin="10" topmargin="10" marginwidth="10" marginheight="10">
	<table width="50%" border="1" cellpadding="5" cellspacing="0" bordercolor="#4169E1">
       <tr>
           <td align="center" colspan="3"><b>Codigo Barras:</b>
           <input type="text" name="cod_barra" id="cod_barra" value ="<?php echo "$codi_barra";?>" size="40" maxlength="40" onChange="salva(this)"></td>
       </tr>
       <!-- Coloca foco no primeiro campo codigo de barras do formulário -->
         
       <script language="JavaScript">
            document.getElementById('cod_barra').focus()
       </script>
       <tr>
           <td><b>Número da HAWB:</b></td>
           <td><input type="text" name="n_hawb" class="campo" id="n_hawb"><input name="grava" type="submit" value="Grava"></td></td>
		</tr>
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

