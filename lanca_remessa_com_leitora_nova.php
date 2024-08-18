<?php
  session_start();

   /////////////////////////////////RECUPERA VARIAVEIS DE MEMÓRIA PARA ACESSO AO BANCO DE DADOS///////////////////////////

   $base_d     =$_SESSION['base_d'];
   $banco_d    =$_SESSION['banco_d'];
   $usuario_d  =$_SESSION['usuario_d'];
   $senha_d    =$_SESSION['senha_d'];

   //Abre conexão com o banco

   $con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
   $res = mysql_select_db($banco_d) or die ("Banco de dados inexistente");

  ////////////////////////////////////////CONTROLA O ACESSO DO USUARIO A ROTINA/////////////////////////////////////////

  $matricula_m  =$_SESSION['matricula_m'];
  $programa='35';
  $_SESSION['programa_m']=$programa;

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

    //////////////////////////////////FUNÇÃO QUE CONTROLA O GET ACTION /////////////////////////////////////////

       function get_post_action($name) {
        $params = func_get_args();
        foreach ($params as $name) {
            if (isset($_POST[$name])) {
                return $name;
            }
        }
       }

/////////////////////////////////CARREGA A FUNÇÃO CALENDÁRIO E FUNÇÃO PEGA CEP/////////////////////////////////
  include ("pega_cep.php");
  include ("campo_calendario.php");

  ////////////////////////////////////LIMPA AS VARIAVEIS FIXAS AOENTRAR NA ROTINA /////////////////////////////

 if ($_SESSION['entrada_m']=='S')  {
      unset($_SESSION['n_remessa_m']);
      $n_remessa='';
      unset($_SESSION['escritorio_m']);
      $escritorio='';
      unset($_SESSION['codi_cli_m']);
      $codi_cli='';
      unset($_SESSION['codi_cli_m']);
      $codi_cli='';
      unset($_SESSION['servico_m']);
      $codi_servi ='';
      unset($_SESSION['servi_m']);

      $_SESSION['dt_remessa_m']   =date('d/m/Y');

      $_SESSION['entrada_m']='N';
   }


?>
<html>
  <title>lanca_remessa_com_leitora_nova.php</title>
  <head>
      <!--------------------------BIBLIOTECAS JAVA SCRIPT PARA CAMPO AUTOCOMPLETAR---------------------->

      <script type="text/javascript" src="jquery-autocomplete/lib/jquery.js"></script>
      <script type="text/javascript" src="jquery-autocomplete/lib/jquery.bgiframe.min.js"></script>
      <script type="text/javascript" src="jquery-autocomplete/lib/jquery.ajaxQueue.js"></script>
      <script type="text/javascript" src="jquery-autocomplete/lib/thickbox-compressed.js"></script>
      <script type="text/javascript" src="jquery-autocomplete/jquery.autocomplete.js"></script>
      <!--css -->
      <link rel="stylesheet" type="text/css" href="jquery-autocomplete/jquery.autocomplete.css"/>
      <link rel="stylesheet" type="text/css" href="jquery-autocomplete/lib/thickbox.css"/>
      
      <!----------------------------------------DEFINE O ESTILO DO FORMULARIO --------------------------------->
  
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
   
       <!----------------------------------------FUNÇÃO AUTO COMPLETAR--------------------------------->
   
       $(document).ready(function(){
		$("#nome_desti").autocomplete("completar.php", {
			width:350,
			selectFirst: false
		});
	   });
   
   
      <!----------------------------------------ATIVA EXECUÇÃO DO CAMPO CODIGO DE BARRA --------------------------------->
   
       function salva(campo){
            cadastro.submit()
       }
       
      <!------------------------------------------------ DESABILITA O CTRL J ------------------------------------------------>

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
  
  <!------------------------------------------ CABEÇALHO DO FORMULÁRIO -------------------------------------------->
  
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
         <p align="right"><font face="Arial" size="2" color="#FFFFFF"><b>Lançamento de HAWB Com Leitora</b></font></td>
     </tr>
   </table>
   </table>
   
   <!------------------------------------------------ BOTÃO DE AJUDA E DE SAIDA ------------------------------------------->
   
   <table width="100%" border="0" cellspacing="0" cellpadding="0">
       <tr>
         <td colspan="1" align="left" width="45%"><INPUT type=button size="3" value="Ajuda"
               onClick="window.open('mostra_ajuda.php','janela_1',
               'scrollbars=yes,resizable=yes,width=400,height=700');" style="width:100;height:30;color=red;font: bold 16px Arial;">
         </td>
         <td colspan="1" color="white" align="right" width="45%" height="70"><a href="entrada.php"><img src="img/porta.gif" border="none"></td>
       </tr>
   </table>
   
   <!------------------------------------------------ INICIO DO FORMULARIO -------------------------------------------->
   
   <form method="POST" name="cadastro" action="lanca_remessa_com_leitora_nova.php" border="20" align="center">
      <body leftmargin="10" topmargin="10" marginwidth="10" marginheight="10">
      <?php
      
      /////////////////////////////////GETS PARA FAZER OPERAÇÕES FORA DA ROTINA/////////////////////////////////

      switch (get_post_action('ativa_ser','gera','ativa_cli','nova','localiza','busca','grava','informa')) {
          case 'ativa_cli':
               $escritorio                       =$_POST['escritorio'];
               $adm_m        =$_SESSION['adm_m'];
               if ($adm_m=='N') {
                  $dt_remessa     =$_SESSION['dt_remessa_m'];
               }
               if ($adm_m=='S') {
                  $dt_remessa                 =$_POST['dt_remessa'];
                  $_SESSION['dt_remessa_m']   =$dt_remessa;
               }
               $codi_cli                         =$_POST['codi_cli'];

               //variavel para controlar o serviço

               $_SESSION['conservi_m']=0;

               //Guarda dados fixos na memoria

               $_SESSION['escritorio_m']   =$escritorio;
               //$_SESSION['dt_remessa_m']   =$dt_remessa;
               $_SESSION['codi_cli_m']     =$codi_cli;
          break;

          case 'ativa_ser':
               $codi_servi                       =$_POST['codigo_servi'];

               //Atribui valor 1 para a variavel que controla ativação do serviço

               $_SESSION['conservi_m']=1;

               //Guarda codigo serviço na memoria

               $_SESSION['servico_m']      =$codi_servi;
               $_SESSION['servi_m']        =$codi_servi;
          break;

          case 'gera':
                  if($_SESSION['conservi_m']==0) {
                     ?>
                     <script language="javascript"> window.location.href=("lanca_remessa_com_leitora_nova.php")
                       alert('PARE, VOCÊ NÃO ATIVOU O SERVIÇO!!!! ATIVE-O E DEPOIS GERE O NÚMERO DAREMESSA.');
                     </script>
                     <?php
                  }
                  else {

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

                      $_SESSION['n_remessa_m']   =$v_n_remessa;

                      unset($_SESSION['codigo_desti_m']);
                      $codigo_desti          ='';
                      unset($_SESSION['nome_desti_m']);
                      $nome_desti            ='';
                      unset($_SESSION['cep_desti_m']);
                      $cep                   ='';
                      unset($_SESSION['rua_desti_m']);
                      $rua_desti             ='';
                      $numero_desti          ='';
                      unset($_SESSION['bairro_desti_m']);
                      $bairro_desti          ='';
                      unset($_SESSION['cidade_desti_m']);
                      $cidade_desti          ='';
                      unset($_SESSION['estado_nome_m']);
                      $estado_n              ='';
                      unset($_SESSION['estado_sigla']);
                      $estado_s              ='';
                      $codi_barra            ='';
                      $comple_desti          ='';
                      unset($_SESSION['n_hawb_m']);
                      $n_hawb                ='';

                      //Recupera os dados fixos guardados na mmoria
                      $escritorio               =$_SESSION['escritorio_m'];
                      $dt_remessa               =$_SESSION['dt_remessa_m'];
                      $codi_cli                 =$_SESSION['codi_cli_m'];
                      $codi_servi               =$_SESSION['servico_m'];
                      $v_n_remessa              =$_SESSION['n_remessa_m'];

                      $_SESSION['lupe_m']='S';

                      //Atualiza a tabela de controle número remessa
                      
                      //Altera formato da data para salvar no arqivo
                      $dt_remessa   =$_SESSION['dt_remessa_m'];
                      $dt_remessa  = explode("/",$dt_remessa);
                      $v_dt_remessa = $dt_remessa[2]."-".$dt_remessa[1]."-".$dt_remessa[0];

                      $n_remes=   $_SESSION['n_reme'];

                      $verifi="SELECT numero FROM nu_reme_manu WHERE numero='$n_remes'";
                      $query = mysql_db_query($banco_d,$verifi,$con) or die ("Não foi possivel acessar o banco_2");
                      $achou = mysql_num_rows($query);

                      If ($achou == 0 ) {
                         $atualiza = "INSERT INTO nu_reme_manu(numero,dt_remessa)
                         values('$n_remes','$v_dt_remessa')";

                         mysql_db_query($banco_d,$atualiza,$con);
                         }
                      
                  }
          break;

          case 'grava':
                   $codi_cli        =$_SESSION['codi_cli_m'];
                   $v_n_remessa     =$_SESSION['n_remessa_m'];
                   $escritorio      =$_SESSION['escritorio_m'];
                   $codi_servi      =$_SESSION['servico_m'];
                   $codi_barra      =$_SESSION['codi_barra_m'];
                   $n_hawb          =$_SESSION['n_hawb_m'];
                   $qtdade          =$_POST['qtdade'];
                   $valor           =$_POST['valor'];
                   $codigo_desti    =$_POST['codigo_desti'];
                   $nome_desti      =$_POST['nome_desti'];
                   $cep_desti       =$_POST['cep'];
                   $rua_desti       =$_POST['rua_desti'];
                   $numero_desti    =$_POST['numero_desti'];
                   $comple_desti    =$_POST['comple_desti'];
                   $bairro_desti    =$_POST['bairro_desti'];
                   $cidade_desti    =$_POST['cidade_desti'];
                   $estado_desti    =$_POST['estado_desti'];
                   $adm_m           =$_SESSION['adm_m'];
                   $dt_remessa      =$_SESSION['dt_remessa_m'];
                   $classe_cep      =$_POST['classe_cep'];


                   // Controla classe de cep em branco

                   If ($classe_cep == '' ) {
                      $_SESSION['cep_branco_m']=1;
                      if ($codi_barra<>'') {
                          $codi_barra='';
                      }
                      $_SESSION['qtdade_m']        =$_POST['qtdade'];
                      $_SESSION['valor_m']         =$_POST['valor'];
                      $_SESSION['codigo_desti_m']  =$_POST['codigo_desti'];
                      $_SESSION['nome_desti_m']    =$_POST['nome_desti'];
                      $_SESSION['cep_desti_m']     =$_POST['cep'];
                      $_SESSION['rua_desti_m']     =$_POST['rua_desti'];
                      $_SESSION['numero_desti_m']  =$_POST['numero_desti'];
                      $_SESSION['comple_desti_m']  =$_POST['comple_desti'];
                      $_SESSION['bairro_desti_m']  =$_POST['bairro_desti'];
                      $_SESSION['cidade_desti_m']  =$_POST['cidade_desti'];
                      $_SESSION['estado_desti_m']  =$_POST['estado_desti'];
                      $_SESSION['classe_cep']      =$_POST['classe_cep'];
                      ?>
                      <script language="javascript"> window.location.href=("lanca_remessa_com_leitora.php")
                        alert('A classe de CEP destedestino está em branco, Definaa a Classe de CEP, se não haverá problema no Faturamento.');
                      </script>
                      <?php
                   }
                   else {

                      //Atribui valor 1 a quantidade caso não tenha sido digitado outro valor

                      if ($qtdade=='') {
                         $qtdade=1;
                      }

                      //Pega valor do serviço na tabela de preço

                      if (($codi_cli<>'') and ($codi_servi<>'') and ($classe_cep<>'')) {
                        $pegava="SELECT valor FROM tabela_preco
                        WHERE ((codi_cli='$codi_cli') AND (tipo_servi='$codi_servi') AND (classe_cep='$classe_cep'))";
                        $query_2 = mysql_db_query($banco_d,$pegava,$con) or die ("Não foi possivel acessar o banco 2");
                        $total = mysql_num_rows($query_2);

                        for($ic=0; $ic<$total; $ic++){
                          $row = mysql_fetch_row($query_2);
                          $valor        = $row[0];
                        }
                      }

                      // alterando o formato dos valores para guardar no banco
                      if ($valor<>'') {
                         if (strlen($valor)>=6) {
                           $valor         = str_replace(".", "", $valor);
                           $valor         = str_replace(",", ".", $valor);
                         }
                        if (strlen($valor)<6) {
                           $valor         = str_replace(",", ".", $valor);
                        }
                      }
                      //mudando formato da data para gravar na tabela

                      $dt_remessa  =$_SESSION['dt_remessa_m'];

                      $dt_remessa  = explode("/",$dt_remessa);
                      $v_dt_remessa = $dt_remessa[2]."-".$dt_remessa[1]."-".$dt_remessa[0];

                      //$_SESSION['n_remessa_m']   =$v_n_remessa;

                      if ($n_hawb<>'') {

                         //Verifica se o a HAWB já foi lançada

                         $localiza  = "SELECT n_hawb
                         FROM remessa
                         WHERE n_hawb='$n_hawb'";

                         $query = mysql_db_query($banco_d,$localiza,$con) or die ("Não foi possivel acessar o banco 1");
                         $achou = mysql_num_rows($query);

                         If ($achou > 0 ) {
                            unset($_SESSION['n_hawb_m']);
                            $n_hawb='';
                            unset($_SESSION['codigo_desti_m']);
                            $codigo_desti          ='';
                            unset($_SESSION['nome_desti_m']);
                            $nome_desti            ='';
                            $escritorio               =$_SESSION['escritorio_m'];
                            $dt_remessa               =$_SESSION['dt_remessa_m'];
                            $codi_cli                 =$_SESSION['codi_cli_m'];
                            $codi_servi               =$_SESSION['servico_m'];
                            $v_n_remessa              =$_SESSION['n_remessa_m'];
                            ?>
                            <script language="javascript"> window.location.href=("lanca_remessa_com_leitora_nova.php")
                               alert('HAWB já foi lançada.');
                            </script>
                            <?php
                         }
                         else {
                            if ($classe_cep<>'04') {
                               $inclusao_1 = "INSERT INTO remessa(
                               codi_cli,
                               n_remessa,
                               escritorio,
                               cod_barra,
                               co_servico,
                               codigo_desti,
                               nome_desti,
                               cep_desti,
                               rua_desti,
                               numero_desti,
                               bairro_desti,
                               cidade_desti,
                               estado_desti,
                               dt_remessa,
                               qtdade,
                               comple_desti,
                               n_hawb,
                               classe_cep,
                               valor)
                               VALUES(
                               '$codi_cli',
                               '$v_n_remessa',
                               '$escritorio',
                               '$codi_barra',
                               '$codi_servi',
                               '$codigo_desti',
                               '$nome_desti',
                               '$cep_desti',
                               '$rua_desti',
                               '$numero_desti',
                               '$bairro_desti',
                               '$cidade_desti',
                               '$estado_desti',
                               '$v_dt_remessa',
                               '$qtdade',
                               '$comple_desti',
                               '$n_hawb',
                               '$classe_cep',
                               '$valor')";

                               if (mysql_db_query($banco_d,$inclusao_1,$con)) {

                                  //Atualiza a tabela de controle de numero de remessas

                                  $n_remes=   $_SESSION['n_reme'];

                                  $verifi="SELECT numero FROM nu_reme_manu WHERE numero='$n_remes'";
                                  $query = mysql_db_query($banco_d,$verifi,$con) or die ("Não foi possivel acessar o banco_2");
                                  $achou = mysql_num_rows($query);

                                  If ($achou == 0 ) {
                                     $atualiza = "INSERT INTO nu_reme_manu(numero,dt_remessa)
                                     values('$n_remes','$v_dt_remessa')";

                                     mysql_db_query($banco_d,$atualiza,$con);
                                  }
                                  $resp_grava="Inclusão bem sucedida";

                                  //Atualiza a tabela de destinos

                                  $consulta="SELECT codigo_desti FROM destino WHERE codigo_desti='$codigo_desti'";
                                  $query = mysql_db_query($banco_d,$consulta,$con) or die ("Não foi possivel acessar o banco 3");
                                  $achou = mysql_num_rows($query);
                                  If ($achou == 0 ) {
                                     $inclusao = "INSERT INTO destino(codigo_desti,nome_desti,cep_desti,
                                     rua_desti,numero_desti,bairro_desti,cidade_desti,
                                     estado_desti,dt_atu_cada,comple_desti,classe_cep)
                                     VALUES('$codigo_desti','$nome_desti','$cep_desti','$rua_desti',
                                     '$numero_desti','$bairro_desti','$cidade_desti',
                                     '$estado_desti','$v_dt_remessa','$comple_desti','$classe_cep')";
                                     mysql_db_query($banco_d,$inclusao,$con);
                                  }
                                  else {
                                     $alteracao = "UPDATE destino SET nome_desti='$nome_desti',cep_desti='$cep_desti',
                                     rua_desti='$rua_desti',numero_desti='$numero_desti',bairro_desti='$bairro_desti',
                                     cidade_desti='$cidade_desti',estado_desti='$estado_desti',dt_atu_cada='$v_dt_remessa',
                                     comple_desti='$comple_desti',classe_cep='$classe_cep'
                                     WHERE codigo_desti='$codigo_desti'";
                                     mysql_db_query($banco_d,$alteracao,$con);
                                  }

                                  //Atualiza a tabela de controle de ações no sistema
                                  $servico      =$_SESSION['servi_m'];
                                  $matricula_m  =$_SESSION['matricula_m'];
                                  $data         = date('Y/m/d');
                                  $hora         = date ('H:i:s');
                                  $programa     =$_SESSION['programa_m'];
                                  $incluir="INSERT INTO log_operacao_sistema (matricula,tarefa_executada,
                                  n_hawb,data,hora,rotina,servico,codi_cli,remessa)
                                  VALUES('$matricula_m','Inclusão de HAWB no Sistema','$n_hawb','$data','$hora',
                                  '$programa','$servico','$codi_cli','$v_n_remessa')";
                                  mysql_db_query($banco_d,$incluir,$con);
                               }
                               else {
                                  $resp_grava="Problemas na Inclusão";
                               }
                               unset($_SESSION['codigo_desti_m']);
                               $codigo_desti          ='';
                               unset($_SESSION['nome_desti_m']);
                               $nome_desti            ='';
                               unset($_SESSION['cep_desti_m']);
                               $cep                   ='';
                               unset($_SESSION['rua_desti_m']);
                               $rua_desti             ='';
                               unset($_SESSION['numero_desti_m']);
                               $numero_desti          ='';
                               unset($_SESSION['bairro_desti_m']);
                               $bairro_desti          ='';
                               unset($_SESSION['cidade_desti_m']);
                               $cidade_desti          ='';
                               unset($_SESSION['estado_desti_m']);
                               $estado_desti              ='';
                               unset($_SESSION['codi_barra_m']);
                               $codi_barra            ='';
                               unset($_SESSION['comple_desti_m']);
                               $comple_desti          ='';
                               unset($_SESSION['n_hawb_m']);
                               $n_hawb                ='';
                               unset($_SESSION['qtdade_m']);
                               $qtdade                ='';
                               unset($_SESSION['classe_cep']);
                               $classe_sep            ='';
                               unset($_SESSION['valor_m']);
                               $valor                 ='';
                               $_SESSION['cep_branco_m']=0;
                               
                               //////ALTERA A VARIAVEL QUE CONTROLA O FLUXO DE GRAVAÇÃO - DIRETA OU INDIRETA
                               
                               $_SESSION['forma_grava_m']='I';
                            }
                            else {
                               ?>
                               <script language="javascript"> window.location.href=("lanca_remessa_com_leitora_nova.php")
                                  alert('HAWB, não gravada, pois está fora de contrato! Verifique.');
                               </script>
                               <?php
                            }
                         }

                      }
                      else {
                         ?>
                         <script language="javascript"> window.location.href=("lanca_remessa_com_leitora_nova.php")
                           alert('Você tem que informar o número da HAWB ! Verifique.');
                         </script>
                         <?php
                      }
                   }
               break;
               case 'busca':
                   $cep                         =$_POST['cep'];
                   $nome_desti                  =$_POST['nome_desti'];
                   $codigo_desti                =$_POST['codigo_desti'];
                   $qtdade                      =$_POST['qtdade'];
                   $_SESSION['qtdade_m']        =$qtdade;
                   $_SESSION['nome_desti_m']    =$nome_desti;
                   $_SESSION['codigo_desti_m']  =$codigo_desti;


                   pega_cep($cep);

                   $escritorio      =$_SESSION['escritorio_m'];
                   $dt_remessa      =$_SESSION['dt_remessa_m'];
                   $codi_cli        =$_SESSION['codi_cli_m'];
                   $codi_servi      =$_SESSION['servico_m'];
                   $v_n_remessa     =$_SESSION['n_remessa_m'];
                   $codi_barra      =$_SESSION['codi_barra_m'];
                   $n_hawb          =$_SESSION['n_hawb_m'];
                   $qtdade          =$_SESSION['qtdade_m'];
                   $nome_desti      =$_SESSION['nome_desti_m'];
                   $codigo_desti    =$_SESSION['codigo_desti_m'];
                   $cep             =$_SESSION['cep'];
                   $rua_desti       =$_SESSION['rua'];
                   $bairro_desti    =$_SESSION['bairro'];
                   $cidade_desti    =$_SESSION['cidade'];
                   $estado_desti    =$_SESSION['estado_sigla'];
                   $classe_cep      =$_SESSION['classe_cep'];
                   $valor           =$_SESSION['valor_m'];

                   $_SESSION['rua_desti_m']      =$rua_desti;
                   $_SESSION['bairro_desti_m']   =$bairro_desti;
                   $_SESSION['cidade_desti_m']   =$cidade_desti;
                   $_SESSION['estado_desti_m']   =$estado_desti;
                   $_SESSION['cep_desti_m']      =$cep;
                   $_SESSION['classe_cep']       =$classe_cep;
               break;

               case 'nova':
                   $_SESSION['lupe_m']='S';
               break;
               
               case 'informa':
                   $n_hawb      =$_POST['n_hawb'];
                   $_SESSION['n_hawb_m']=$n_hawb;
               break;

               case 'localiza':
                   $qtdade                      =$_POST['qtdade'];
                   $n_hawb                      =$_POST['n_hawb'];
                   $_SESSION['qtdade_m']        =$qtdade;
                   if ($n_hawb<>'') {
                      $n_hawb                =$_POST['n_hawb'];
                      $_SESSION['n_hawb_m']  =$n_hawb;
                   }
                   $nome_desti                  =$_POST['nome_desti'];
                   $_SESSION['nome_desti_m']    =$nome_desti;
                   $v_nome_desti  =trim($nome_desti);

                   //Busca o destino na tabela

                   $locali="SELECT codigo_desti,nome_desti,cep_desti,rua_desti,numero_desti,
                   comple_desti,bairro_desti,cidade_desti,estado_desti,classe_cep
                   FROM destino WHERE trim(nome_desti)='$v_nome_desti'";
                   $query = mysql_db_query($banco_d,$locali,$con) or die ("Não foi possivel acessar o banco");
                   $total = mysql_num_rows($query);

                   for($ic=0; $ic<$total; $ic++){
                       $mostra = mysql_fetch_row($query);
                       $codigo_desti   = $mostra[0];
                       $nome_desti     = $mostra[1];
                       $cep            = $mostra[2];
                       $rua_desti      = $mostra[3];
                       $numero_desti   = $mostra[4];
                       $comple_desti   = $mostra[5];
                       $bairro_desti   = $mostra[6];
                       $cidade_desti   = $mostra[7];
                       $estado_desti   = $mostra[8];
                       $classe_cep     = $mostra[9];

                       //Se localizar os dados do destino grava na memoria

                       $_SESSION['codigo_desti_m']    =$codigo_desti ;
                       $_SESSION['nome_desti_m']      =$nome_desti;
                       $_SESSION['cep_desti_m']       =$cep;
                       $_SESSION['rua_desti_m']       =$rua_desti;
                       $_SESSION['numero_desti_m']    =$numero_desti;
                       $_SESSION['comple_desti_m']    =$comple_desti;
                       $_SESSION['bairro_desti_m']    =$bairro_desti;
                       $_SESSION['cidade_desti_m']    =$cidade_desti;
                       $_SESSION['estado_desti_m']    =$estado_desti;
                       $_SESSION['classe_cep']        =$classe_cep;
                   }

                   //Recupera os dados da memoria para mostrar

                   $escritorio      =$_SESSION['escritorio_m'];
                   $dt_remessa      =$_SESSION['dt_remessa_m'];
                   $codi_cli        =$_SESSION['codi_cli_m'];
                   $codi_servi      =$_SESSION['servico_m'];
                   $v_n_remessa     =$_SESSION['n_remessa_m'];
                   //$codi_barra      =$_SESSION['codi_barra_m'];
                   $n_hawb          =$_SESSION['n_hawb_m'];
                   $qtdade          =$_SESSION['qtdade_m'];
                   $nome_desti      =$_SESSION['nome_desti_m'];
                   $codigo_desti    =$_SESSION['codigo_desti_m'];
                   $cep             =$_SESSION['cep_desti_m'];
                   $rua_desti       =$_SESSION['rua_desti_m'];
                   $numero_desti    =$_SESSION['numero_desti_m'];
                   $comple_desti    =$_SESSION['comple_desti_m'];
                   $bairro_desti    =$_SESSION['bairro_desti_m'];
                   $cidade_desti    =$_SESSION['cidade_desti_m'];
                   $estado_desti    =$_SESSION['estado_desti_m'];
                   $classe_cep      =$_SESSION['classe_cep'];
                   $valor           =$_SESSION['valor_m'];
               break;
          default:
      }

      //////////// CONTROLA A ENTRADA NA DEFINIÇÃO DASVARIAVEIS FIXAS //////////////////////////////
      
      if ($_SESSION['lupe_m']='S') {
      ?>
         <table width="70%" border="1" cellpadding="5" cellspacing="0" bordercolor="#4169E1">
            <tr>
             <td><b>Escritório :</b></td>
             <td>
               <?php
               $adm_m        =$_SESSION['adm_m'];
               if ($adm_m=='N') {
                   $escritorio    =$_SESSION['depto_m'];
                   ?>
                   <select name="escritorio">
                   <?php
                    mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
                    mysql_select_db($banco_d) or die ("Banco de dados inexistente");
                    $sql1 = "SELECT codigo,nome FROM regi_dep WHERE codigo='$escritorio'";
                    $resula = mysql_db_query($banco_d,$sql1,$con) or die ("Não foi possivel acessar o banco");
                    while ( $linha = mysql_fetch_array($resula)) {
                       $select = $escritorio == $linha[0] ? "selected" : "";
                       echo "<option value=\"". $linha[0] . "\" $select>" . $linha[1] . "</option>";
                    }
               }
               if ($adm_m=='S') {
                    ?>
                    <select name="escritorio">
                    <?php
                    mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
                    mysql_select_db($banco_d) or die ("Banco de dados inexistente");
                    $sql1 = "SELECT codigo,nome FROM regi_dep";
                    $resula = mysql_db_query($banco_d,$sql1,$con) or die ("Não foi possivel acessar o banco");
                    while ( $linha = mysql_fetch_array($resula)) {
                        $select = $escritorio == $linha[0] ? "selected" : "";
                        echo "<option value=\"". $linha[0] . "\" $select>" . $linha[1] . "</option>";
                    }
               }
              ?>
              </select>
              </td>
		    </tr>
            <tr>
              <?php
    		   if ($adm_m=='N') {
                  $dt_remessa    =$_SESSION['dt_remessa_m'];
                  ?>
                  <td><b>Data Remessa</b> :</b></td>
                  <td><b><?php echo "$dt_remessa";?></b></b></td>
               <?php
               }
               if ($adm_m=='S') {
                 $dt_remessa    =$_SESSION['dt_remessa_m'];
               ?>
                 <td><b>Data Remessa</b> :</b></td>
                 <td>
                  <input type="text" name="dt_remessa" value ="<?php echo "$dt_remessa";?>" size="12" maxlength="12" id="dt_remessa">
                  <input TYPE="button" NAME="btndt_remessa" VALUE="..." Onclick="javascript:popdate('document.cadastro.dt_remessa','pop1','150',document.cadastro.dt_remessa.value)">
                  <span id="pop1" style="position:absolute"></span>
                 </td>
               <?php
               }
               ?>
            </tr>
            <tr>
              <td><b>Cliente :</b></td>
              <td>
              <?php
               $codi_cli      =$_SESSION['codi_cli_m'];
               mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
               mysql_select_db($banco_d) or die ("Banco de dados inexistente");
               ?>
               <select name="codi_cli">
              <?php
                $sql2 = "SELECT cnpj_cpf,nome FROM cli_for";
                $resul = mysql_db_query($banco_d,$sql2,$con) or die ("Não foi possivel acessar o banco");
                while ( $linha = mysql_fetch_array($resul)) {
                    $select = $codi_cli == $linha[0] ? "selected" : "";
                    echo "<option value=\"". $linha[0] . "\" $select>" . $linha[1] . "</option>";
               }
              ?>
              </select>
              <input name="ativa_cli" type="submit" value="Ativa Cliente">
              </td>
		   </tr>
           <tr>
             <td><b>Serviço :</b></td>
             <td>
              <?php
               $codi_cli        =$_SESSION['codi_cli_m'];
               $codi_servi      =$_SESSION['servico_m'];
               ?>
               <select name="codigo_servi">
               <?php
                $sql3 = "SELECT DISTINCT tabela_preco.tipo_servi, serv_ati.descri_se
                FROM tabela_preco,serv_ati
                WHERE ((tabela_preco.tipo_servi=serv_ati.codigo_se)
                AND  (tabela_preco.codi_cli='$codi_cli'))";
                $resulo = mysql_db_query($banco_d,$sql3,$con) or die ("Não foi possivel acessar o banco");
                while ( $linha = mysql_fetch_array($resulo)) {
                    $select = $codi_servi == $linha[0] ? "selected" : "";
                    echo "<option value=\"". $linha[0] . "\" $select>" . $linha[1] . "</option>";
               }
              ?>
              </select>
              <input name="ativa_ser" type="submit" value="Ativa Serviços">
             </td>
		   </tr>
		   <tr>
             <?php $v_n_remessa    =$_SESSION['n_remessa_m'];?>
		     <td><b>Número da Remessa:</b></td>
		     <td><input type="text" name="n_remessa" value ="<?php echo "$v_n_remessa";?>" size="17" maxlength="17" id="n_remessa"><input name="gera" type="submit" value="Gera Número Remessa"></td>
	       </tr>
        </table>
       <?php
       $_SESSION['lupe_m']='N';
       }

       //////////RECEBE LEITURA DOCODIGO DE BARRAS PARA PROCESSAR //////////////////////////
       
       if($_SESSION['forma_grava_m']=='D'){

           $codi_barra     =$_POST['cod_barra'];

           if (($codi_barra<>'') and ($n_hawb=='')) {
               $_SESSION['codi_barra_m']   =$codi_barra;

               //Pega o codigo do destinatário e o numero da hawb

               if(strlen($codi_barra) == 26){
                  $codigo_desti          =Substr($codi_barra,0,8);
                  $codigo_desti          =intval($codigo_desti);
                  $n_hawb                =Substr($codi_barra,17,10);
                  $n_hawb                =intval($n_hawb);
                  $_SESSION['n_hawb_m']  =$n_hawb;
               }
               else {
                  $n_hawb                =$codi_barra;
                  $_SESSION['n_hawb_m']  =$n_hawb;
               }
               //Pega os dados do destino a parir do código extraido do codigo de barras

               $resp_grava='';

               $verifi="SELECT codigo_desti,nome_desti,cep_desti,rua_desti,numero_desti,
               comple_desti,bairro_desti,cidade_desti,estado_desti,classe_cep,rede
               FROM destino WHERE codigo_desti='$codigo_desti'";
               $query = mysql_db_query($banco_d,$verifi,$con) or die ("Não foi possivel acessar o banco");
               $total = mysql_num_rows($query);
               if ($total > 0) {
                   for ($ic=0; $ic<$total; $ic++){
                       $mostra = mysql_fetch_row($query);
                       $codigo_desti   = $mostra[0];
                       $nome_desti     = $mostra[1];
                       $cep            = $mostra[2];
                       $rua_desti      = $mostra[3];
                       $numero_desti   = $mostra[4];
                       $comple_desti   = $mostra[5];
                       $bairro_desti   = $mostra[6];
                       $cidade_desti   = $mostra[7];
                       $estado_desti   = $mostra[8];
                       $classe_cep     = $mostra[9];
                       $rede           = $mostra[10];

                       /////////CARREGA A MEMORIA COM OS DADOS//////////////////

                       $_SESSION['codi_barra_m']      =$codi_barra;
                       $_SESSION['codigo_desti_m']    =$codigo_desti;
                       $_SESSION['nome_desti_m']      =$nome_desti;
                       $_SESSION['cep_desti_m']       =$cep;
                       $_SESSION['rua_desti_m']       =$rua_desti;
                       $_SESSION['numero_desti_m']    =$numero_desti;
                       $_SESSION['comple_desti_m']    =$comple_desti;
                       $_SESSION['bairro_desti_m']    =$bairro_desti;
                       $_SESSION['cidade_desti_m']    =$cidade_desti;
                       $_SESSION['estado_desti_m']    =$estado_desti;
                       $_SESSION['classe_cep']        =$classe_cep;
                       $_SESSION['rede_m']            =$rede;
                   }
                   if (($codigo_desti<>'') and ($cep<>'') and ($rua_desti<>'') and ($numero_desti<>'') and
                       ($bairro_desti<>'') and ($cidade_desti<>'') and ($estado_desti<>'') and
                       ($classe_cep<>'') and ($rede<>'R')) {
                       
                       ////////////////VERIFICA SEA HAWB REFERE-SE A SERVIÇO FORA DE CONTRATO////////////
                       
                       if ($classe_cep<>'04') {
                          ///////////////////////GRAVA DADOS NA TABELA REMESSA//////////////////////////

                          //Atribui valor 1 a quantidade caso não tenha sido digitado outro valor

                          if ($qtdade=='') {
                             $qtdade=1;
                             $_SESSION['qtdade_m']  =$qtdade;
                          }

                          //Pega valor do serviço na tabela de preço

                          $codi_cli    =$_SESSION['codi_cli_m'];
                          $codi_servi  =$_SESSION['servico_m'];
                          $classe_cep  =$_SESSION['classe_cep'];

                          if (($codi_cli<>'') and ($codi_servi<>'') and ($classe_cep<>'')) {
                              $pegava="SELECT valor FROM tabela_preco
                              WHERE ((codi_cli='$codi_cli') AND (tipo_servi='$codi_servi') AND (classe_cep='$classe_cep'))";
                              $query_2 = mysql_db_query($banco_d,$pegava,$con) or die ("Não foi possivel acessar o banco 2");
                              $total = mysql_num_rows($query_2);

                              for ($ic=0; $ic<$total; $ic++){
                                  $row = mysql_fetch_row($query_2);
                                  $valor        = $row[0];
                              }
                          }

                          // alterando o formato dos valores para guardar no banco

                          if ($valor<>'') {
                             if (strlen($valor)>=6) {
                                $valor         = str_replace(".", "", $valor);
                                $valor         = str_replace(",", ".", $valor);
                             }
                             else {
                                $valor         = str_replace(",", ".", $valor);
                             }
                          }

                          //mudando formato da data para gravar na tabela

                          $dt_remessa   =$_SESSION['dt_remessa_m'];
                          $dt_remessa   = explode("/",$dt_remessa);
                          $v_dt_remessa = $dt_remessa[2]."-".$dt_remessa[1]."-".$dt_remessa[0];
                          $_SESSION['v_dt_remessa_m']=$v_dt_remessa;
                          $n_hawb    =$_SESSION['n_hawb_m'];

                          //////////////////////RECUPERA OS DADOS DA MEMORIA PARA GRAVAR NA TABELA REMESSA////////////////

                          $codi_cli          =$_SESSION['codi_cli_m'];
                          $v_n_remessa       =$_SESSION['n_remessa_m'];
                          $escritorio        =$_SESSION['escritorio_m'];
                          $codi_barra        =$_SESSION['codi_barra_m'];
                          $codi_servi        =$_SESSION['servico_m'];
                          $codigo_desti      =$_SESSION['codigo_desti_m'];
                          $nome_desti        =$_SESSION['nome_desti_m'];
                          $cep_desti         =$_SESSION['cep_desti_m'];
                          $rua_desti         =$_SESSION['rua_desti_m'];
                          $numero_desti      =$_SESSION['numero_desti_m'];
                          $comple_desti      =$_SESSION['comple_desti_m'];
                          $bairro_desti      =$_SESSION['bairro_desti_m'];
                          $cidade_desti      =$_SESSION['cidade_desti_m'];
                          $estado_desti      =$_SESSION['estado_desti_m'];
                          $classe_cep        =$_SESSION['classe_cep'];
                          $v_dt_remessa      =$_SESSION['v_dt_remessa_m'];
                          $qtdade            =$_SESSION['qtdade_m'];
                          $n_hawb            =$_SESSION['n_hawb_m'];

                          ///////////////////////////////VRIFICA SE A HAWB JA EXISTE //////////////////////////////////
                          $localiza  = "SELECT n_hawb
                          FROM remessa
                          WHERE n_hawb='$n_hawb'";

                          $query = mysql_db_query($banco_d,$localiza,$con) or die ("Não foi possivel acessar o banco 1");
                          $achou = mysql_num_rows($query);

                          If ($achou > 0 ) {
                             unset($_SESSION['n_hawb_m']);
                             $n_hawb='';
                             ?>
                             <script language="javascript"> window.location.href=("lanca_remessa_com_leitora_nova.php")
                               alert('HAWB já foi lançada. Grava Direto');
                             </script>
                             <?php
                          }
                          else {

                             ///////////////////////////////GRAVA OS DADOS NA TABELA REMESSA///////////////////////////////

                             $inclusao = "INSERT INTO remessa(
                             codi_cli,
                             n_remessa,
                             escritorio,
                             cod_barra,
                             co_servico,
                             codigo_desti,
                             nome_desti,
                             cep_desti,
                             rua_desti,
                             numero_desti,
                             comple_desti,
                             bairro_desti,
                             cidade_desti,
                             estado_desti,
                             classe_cep,
                             dt_remessa,
                             qtdade,
                             n_hawb,
                             valor)
                             VALUES(
                             '$codi_cli',
                             '$v_n_remessa',
                             '$escritorio',
                             '$codi_barra',
                             '$codi_servi',
                             '$codigo_desti',
                             '$nome_desti',
                             '$cep_desti',
                             '$rua_desti',
                             '$numero_desti',
                             '$comple_desti',
                             '$bairro_desti',
                             '$cidade_desti',
                             '$estado_desti',
                             '$classe_cep',
                             '$v_dt_remessa',
                             '$qtdade',
                             '$n_hawb',
                             '$valor')";

                             if (mysql_db_query($banco_d,$inclusao,$con)) {

                                //Atualiza a tabela de controle de numero de remessas

                                $n_remes=   $_SESSION['n_reme'];

                                $verifi="SELECT numero FROM nu_reme_manu WHERE numero='$n_remes'";
                                $query = mysql_db_query($banco_d,$verifi,$con) or die ("Não foi possivel acessar o banco_2");
                                $achou = mysql_num_rows($query);

                                If ($achou == 0 ) {
                                    $atualiza = "INSERT INTO nu_reme_manu(numero,dt_remessa)
                                    values('$n_remes','$v_dt_remessa')";

                                    mysql_db_query($banco_d,$atualiza,$con);
                                }
                                $resp_grava="Inclusão bem sucedida";

                                //Atualiza a tabela de destinos

                                $consulta="SELECT codigo_desti FROM destino WHERE codigo_desti='$codigo_desti'";
                                $query = mysql_db_query($banco_d,$consulta,$con) or die ("Não foi possivel acessar o banco 3");
                                $achou = mysql_num_rows($query);
                                If ($achou == 0 ) {
                                   $inclusao = "INSERT INTO destino(codigo_desti,nome_desti,cep_desti,
                                   rua_desti,numero_desti,bairro_desti,cidade_desti,
                                   estado_desti,dt_atu_cada,comple_desti,classe_cep)
                                   VALUES('$codigo_desti','$nome_desti','$cep_desti','$rua_desti',
                                   '$numero_desti','$bairro_desti','$cidade_desti',
                                   '$estado_desti','$v_dt_remessa','$comple_desti','$classe_cep')";
                                   mysql_db_query($banco_d,$inclusao,$con);
                                }
                                else {
                                   $alteracao = "UPDATE destino SET nome_desti='$nome_desti',cep_desti='$cep_desti',
                                   rua_desti='$rua_desti',numero_desti='$numero_desti',bairro_desti='$bairro_desti',
                                   cidade_desti='$cidade_desti',estado_desti='$estado_desti',dt_atu_cada='$v_dt_remessa',
                                   comple_desti='$comple_desti',classe_cep='$classe_cep'
                                   WHERE codigo_desti='$codigo_desti'";
                                   mysql_db_query($banco_d,$alteracao,$con);
                                }

                                //Atualiza a tabela de controle de ações no sistema

                                $servico      =$_SESSION['servi_m'];
                                $matricula_m  =$_SESSION['matricula_m'];
                                $data         = date('Y/m/d');
                                $hora         = date ('H:i:s');
                                $programa     =$_SESSION['programa_m'];
                                $incluir="INSERT INTO log_operacao_sistema (matricula,tarefa_executada,
                                n_hawb,data,hora,rotina,servico,codi_cli,remessa)
                                VALUES('$matricula_m','Inclusão de HAWB no Sistema','$n_hawb','$data','$hora',
                                '$programa','$servico','$codi_cli','$v_n_remessa')";
                                mysql_db_query($banco_d,$incluir,$con);

                                ///////////////////////////LIMPA AS VARIÁVEIS USADAS //////////////////////////////

                                unset($_SESSION['codigo_desti_m']);
                                $codigo_desti          ='';
                                unset($_SESSION['nome_desti_m']);
                                $nome_desti            ='';
                                unset($_SESSION['cep_desti_m']);
                                $cep                   ='';
                                unset($_SESSION['rua_desti_m']);
                                $rua_desti             ='';
                                unset($_SESSION['numero_desti_m']);
                                $numero_desti          ='';
                                unset($_SESSION['bairro_desti_m']);
                                $bairro_desti          ='';
                                unset($_SESSION['cidade_desti_m']);
                                $cidade_desti          ='';
                                unset($_SESSION['estado_desti_m']);
                                $estado_desti              ='';
                                unset($_SESSION['codi_barra_m']);
                                $codi_barra            ='';
                                unset($_SESSION['comple_desti_m']);
                                $comple_desti          ='';
                                unset($_SESSION['n_hawb_m']);
                                $n_hawb                ='';
                                unset($_SESSION['qtdade_m']);
                                $qtdade                ='';
                                unset($_SESSION['classe_cep']);
                                $classe_sep            ='';
                             }
                             else {
                                $resp_grava="Problemas na Inclusão";
                             }
                          }
                       }
                       else {
                            ?>
                            <script language="javascript"> window.location.href=("lanca_remessa_com_leitora_nova.php")
                                  alert('HAWB NÃO GRAVADA, pois está fora de contrato! Verifique.');
                            </script>
                            <?php
                            unset($_SESSION['codi_barra_m']);
                            $codi_barra     ='';
                            unset($_SESSION['n_hawb_m']);
                            $n_hawb         ='';
                       }
                   }
                   else {
                     ?>
                     <table width="70%" border="1" cellpadding="5" cellspacing="0" bordercolor="#4169E1">
                        <tr>
                           <?php $qtdade    =$_SESSION['qtdade_m'];?>
                           <td><b>Qtdade Serviço :</b></td>
                           <td><input name="qtdade" type="text" id="qtdade" value ="<?php echo "$qtdade";?>" size="6" maxlength="6"></td>
                        </tr>
                        <tr>
                            <?php $nome_desti    =$_SESSION['nome_desti_m'];?>
                			<td><b>Nome Destino :</b></td>
                			<br />
                			<td><input type="text" name="nome_desti" id="nome_desti" value ="<?php echo "$nome_desti";?>" size="50" maxlength="50" class="input_forms"/><input name="localiza" type="submit" value="Busca Dados Destino"></td>
                	    </tr>
                        <tr>
                           <?php $codigo_desti    =$_SESSION['codigo_desti_m'];?>
                           <td><b>Código Destino :</b></td>
                           <td><input type="text" name="codigo_desti" id="codigo_desti" value ="<?php echo "$codigo_desti";?>" size="16" maxlength="16"></td>
                		</tr>
                        <tr>
                          <?php $cep    =$_SESSION['cep_desti_m'];?>
                          <td><b>CEP Destino(Sem Separador) :</b></td>
                          <td><input name="cep" type="text" id="cep" value ="<?php echo "$cep";?>" size="10" maxlength="10"><input name="busca" type="submit" value="Busca Endereço"></td>
                        </tr>
                        <tr>
                          <td><b>Classe CEP :</b></td>
                          <td>
                          <?php
                            $classe_cep      =$_SESSION['classe_cep'];
                          ?>
                          <select name="classe_cep">
                            <?php
                            $sql2 = "SELECT codigo,descricao FROM classe_cep";
                            $resul = mysql_db_query($banco_d,$sql2,$con) or die ("Não foi possivel acessar o banco");
                            while ( $linha = mysql_fetch_array($resul)) {
                               $select = $classe_cep == $linha[0] ? "selected" : "";
                               echo "<option value=\"". $linha[0] . "\" $select>" . $linha[1] . "</option>";
                            }
                            ?>
                          </select>
                          </td>
                		  <?php
                    	  $cep_branco   =$_SESSION['cep_branco_m'];
                    	  If ($cep_branco == 1 ) {
                    	     ?>
                    		 <script language="JavaScript">
                                document.getElementById('classe_cep').focus()
                             </script>
                   		  <?php
                          }
                          ?>
                        <tr>
                          <?php $rua_desti    =$_SESSION['rua_desti_m'];?>
               			  <td><b>Rua Destino :</b></td>
               			  <td><input type="text" name="rua_desti" value ="<?php echo "$rua_desti";?>" size="50" maxlength="50" id="rua_desti"></td>
             		    </tr>
                	    <tr>
                          <?php $numero_desti    =$_SESSION['numero_desti_m'];?>
                		  <td><b>Número Destino :</b></td>
                		  <td><input type="text" name="numero_desti" value ="<?php echo "$numero_desti";?>" size="10" maxlength="10" id="numero_desti"></td>
                	    </tr>
                	    <tr>
                          <?php $comple_desti    =$_SESSION['comple_desti_m'];?>
               			  <td><b>Complemento :</b></td>
               			  <td><input type="text" name="comple_desti" value ="<?php echo "$comple_desti";?>"size="30" maxlength="30" id="comple_desti"></td>
                	    </tr>
                	    <tr>
                          <?php $bairro_desti    =$_SESSION['bairro_desti_m'];?>
                		  <td><b>Bairro Destino :</b></td>
                		  <td><input type="text" name="bairro_desti" value ="<?php echo "$bairro_desti";?>" size="40" maxlength="40" id="bairro_desti"></td>
                        </tr>
                        <tr>
                          <?php $cidade_desti    =$_SESSION['cidade_desti_m'];?>
            			  <td><b>Cidade Destino :</b></td>
            			  <td><input type="text" name="cidade_desti" value ="<?php echo "$cidade_desti";?>" size="40" maxlength="40" id="cidade_desti"></td>
            		    </tr>
                        <tr>
                          <?php $estado_desti    =$_SESSION['estado_desti_m'];?>
                          <td><b>Estado Destino : </b></td>
                          <td><input name="estado_desti" type="text" id="estado_desti" value ="<?php echo "$estado_desti";?>" size="3" maxlength="3"></td>
                        </tr>
                        <?php $rede    =$_SESSION['rede_m'];
                        if ($rede=='R') {
                        ?>
                          <tr>
                            <td><b>Pertence Rede : </b></td>
                            <td><?php echo "$rede";?><font color="red"><b> - Destino Pertence Rede. Atualizar dados.</b></font></td>
                          </tr>
                        <?php
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
                	  }
               }
               else {
                    ?>
                      <table width="70%" border="1" cellpadding="5" cellspacing="0" bordercolor="#4169E1">
                            <tr>
                               <?php $qtdade    =$_SESSION['qtdade_m'];?>
                               <td><b>Qtdade Serviço :</b></td>
                               <td><input name="qtdade" type="text" id="qtdade" value ="<?php echo "$qtdade";?>" size="6" maxlength="6"></td>
                            </tr>
                            <tr>
                                <?php $nome_desti    =$_SESSION['nome_desti_m'];?>
                    			<td><b>Nome Destino :</b></td>
                    			<br />
                    			<td><input type="text" name="nome_desti" id="nome_desti" value ="<?php echo "$nome_desti";?>" size="50" maxlength="50" class="input_forms"/><input name="localiza" type="submit" value="Busca Dados Destino"></td>
                    	    </tr>
                    		<tr>
                               <?php $codigo_desti    =$_SESSION['codigo_desti_m'];?>
                               <td><b>Código Destino :</b></td>
                               <td><input type="text" name="codigo_desti" id="codigo_desti" value ="<?php echo "$codigo_desti";?>" size="16" maxlength="16"></td>
                    		</tr>
                            <tr>
                              <?php $cep    =$_SESSION['cep_desti_m'];?>
                              <td><b>CEP Destino(Sem Separador) :</b></td>
                              <td><input name="cep" type="text" id="cep" value ="<?php echo "$cep";?>" size="10" maxlength="10"><input name="busca" type="submit" value="Busca Endereço"></td>
                            </tr>
                            <tr>
                               <td><b>Classe CEP :</b></td>
                               <td>
                                  <?php
                                   $classe_cep      =$_SESSION['classe_cep'];
                                   ?>
                                   <select name="classe_cep">
                                    <?php
                                    $sql2 = "SELECT codigo,descricao FROM classe_cep";
                                    $resul = mysql_db_query($banco_d,$sql2,$con) or die ("Não foi possivel acessar o banco");
                                    while ( $linha = mysql_fetch_array($resul)) {
                                        $select = $classe_cep == $linha[0] ? "selected" : "";
                                        echo "<option value=\"". $linha[0] . "\" $select>" . $linha[1] . "</option>";
                                    }
                                    ?>
                                   </select>
                                </td>
                    		</tr>
                    		<?php
                    		$cep_branco   =$_SESSION['cep_branco_m'];
                    		If ($cep_branco == 1 ) {
                    		?>
                    		<script language="JavaScript">
                                document.getElementById('classe_cep').focus()
                            </script>
                    		<?php
                             }
                            ?>
                    		<tr>
                                <?php $rua_desti    =$_SESSION['rua_desti_m'];?>
                    			<td><b>Rua Destino :</b></td>
                    			<td><input type="text" name="rua_desti" value ="<?php echo "$rua_desti";?>" size="50" maxlength="50" id="rua_desti"></td>
                    		</tr>
                    		<tr>
                                <?php $numero_desti    =$_SESSION['numero_desti_m'];?>
                    			<td><b>Número Destino :</b></td>
                    			<td><input type="text" name="numero_desti" value ="<?php echo "$numero_desti";?>" size="10" maxlength="10" id="numero_desti"></td>
                    		</tr>
                    		<tr>
                                <?php $comple_desti    =$_SESSION['comple_desti_m'];?>
                    			<td><b>Complemento :</b></td>
                    			<td><input type="text" name="comple_desti" value ="<?php echo "$comple_desti";?>"size="30" maxlength="30" id="comple_desti"></td>
                    		</tr>
                    		<tr>
                                <?php $bairro_desti    =$_SESSION['bairro_desti_m'];?>
                    			<td><b>Bairro Destino :</b></td>
                    			<td><input type="text" name="bairro_desti" value ="<?php echo "$bairro_desti";?>" size="40" maxlength="40" id="bairro_desti"></td>
                    		</tr>
                    		<tr>
                                <?php $cidade_desti    =$_SESSION['cidade_desti_m'];?>
                    			<td><b>Cidade Destino :</b></td>
                    			<td><input type="text" name="cidade_desti" value ="<?php echo "$cidade_desti";?>" size="40" maxlength="40" id="cidade_desti"></td>
                    		</tr>
                            <tr>
                               <?php $estado_desti    =$_SESSION['estado_desti_m'];?>
                               <td><b>Estado Destino : </b></td>
                               <td><input name="estado_desti" type="text" id="estado_desti" value ="<?php echo "$estado_desti";?>" size="3" maxlength="3"></td>
                            </tr>
                    		<tr>
                    		  <td colspan="2">
                    		     <div align="right">
                    			   <input name="grava" type="submit" value="Gravar">
                    			 </div>
                    		  </td>
                    		</tr>
                	  </table>
                  <?php
               }
           }
           else {
              $codi_barra    =$_SESSION['codi_barra_m'];
              $n_hawb        =$_SESSION['n_hawb_m'];
              if (($codi_barra=='') and ($n_hawb<>'')) {
                  ?>
                    <table width="70%" border="1" cellpadding="5" cellspacing="0" bordercolor="#4169E1">
                        <tr>
                           <?php $qtdade    =$_SESSION['qtdade_m'];?>
                           <td><b>Qtdade Serviço :</b></td>
                           <td><input name="qtdade" type="text" id="qtdade" value ="<?php echo "$qtdade";?>" size="6" maxlength="6"></td>
                        </tr>
                        <tr>
                            <?php $nome_desti    =$_SESSION['nome_desti_m'];?>
                			<td><b>Nome Destino :</b></td>
                			<br />
                			<td><input type="text" name="nome_desti" id="nome_desti" value ="<?php echo "$nome_desti";?>" size="50" maxlength="50" class="input_forms"/><input name="localiza" type="submit" value="Busca Dados Destino"></td>
                	    </tr>
                		<tr>
                           <?php $codigo_desti    =$_SESSION['codigo_desti_m'];?>
                           <td><b>Código Destino :</b></td>
                           <td><input type="text" name="codigo_desti" id="codigo_desti" value ="<?php echo "$codigo_desti";?>" size="16" maxlength="16"></td>
                		</tr>
                        <tr>
                          <?php $cep    =$_SESSION['cep_desti_m'];?>
                          <td><b>CEP Destino(Sem Separador) :</b></td>
                          <td><input name="cep" type="text" id="cep" value ="<?php echo "$cep";?>" size="10" maxlength="10"><input name="busca" type="submit" value="Busca Endereço"></td>
                        </tr>
                        <tr>
                           <td><b>Classe CEP :</b></td>
                           <td>
                              <?php
                               $classe_cep      =$_SESSION['classe_cep'];
                               ?>
                               <select name="classe_cep">
                                <?php
                                $sql2 = "SELECT codigo,descricao FROM classe_cep";
                                $resul = mysql_db_query($banco_d,$sql2,$con) or die ("Não foi possivel acessar o banco");
                                while ( $linha = mysql_fetch_array($resul)) {
                                    $select = $classe_cep == $linha[0] ? "selected" : "";
                                    echo "<option value=\"". $linha[0] . "\" $select>" . $linha[1] . "</option>";
                                }
                                ?>
                               </select>
                            </td>
                		</tr>
                		<?php
                		$cep_branco   =$_SESSION['cep_branco_m'];
                		If ($cep_branco == 1 ) {
                		?>
                		<script language="JavaScript">
                            document.getElementById('classe_cep').focus()
                        </script>
                		<?php
                         }
                        ?>
                		<tr>
                            <?php $rua_desti    =$_SESSION['rua_desti_m'];?>
                			<td><b>Rua Destino :</b></td>
                			<td><input type="text" name="rua_desti" value ="<?php echo "$rua_desti";?>" size="50" maxlength="50" id="rua_desti"></td>
                		</tr>
                		<tr>
                            <?php $numero_desti    =$_SESSION['numero_desti_m'];?>
                			<td><b>Número Destino :</b></td>
                			<td><input type="text" name="numero_desti" value ="<?php echo "$numero_desti";?>" size="10" maxlength="10" id="numero_desti"></td>
                		</tr>
                		<tr>
                            <?php $comple_desti    =$_SESSION['comple_desti_m'];?>
                			<td><b>Complemento :</b></td>
                			<td><input type="text" name="comple_desti" value ="<?php echo "$comple_desti";?>"size="30" maxlength="30" id="comple_desti"></td>
                		</tr>
                		<tr>
                            <?php $bairro_desti    =$_SESSION['bairro_desti_m'];?>
                			<td><b>Bairro Destino :</b></td>
                			<td><input type="text" name="bairro_desti" value ="<?php echo "$bairro_desti";?>" size="40" maxlength="40" id="bairro_desti"></td>
                		</tr>
                		<tr>
                            <?php $cidade_desti    =$_SESSION['cidade_desti_m'];?>
                			<td><b>Cidade Destino :</b></td>
                			<td><input type="text" name="cidade_desti" value ="<?php echo "$cidade_desti";?>" size="40" maxlength="40" id="cidade_desti"></td>
                		</tr>
                        <tr>
                           <?php $estado_desti    =$_SESSION['estado_desti_m'];?>
                           <td><b>Estado Destino : </b></td>
                           <td><input name="estado_desti" type="text" id="estado_desti" value ="<?php echo "$estado_desti";?>" size="3" maxlength="3"></td>
                        </tr>
                		<tr>
                		  <td colspan="2">
                		     <div align="right">
                			   <input name="grava" type="submit" value="Gravar">
                			 </div>
                		  </td>
                		</tr>
            	    </table>
            	   <?php
              }
           }
       }
       ?>

       <table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#4169E1">
         <?php $v_n_remessa    =$_SESSION['n_remessa_m'];?>
         <tr>
           <td colspan="13" align="center"><font face="arial" size="2"><b>REMESSA :<?php echo "$v_n_remessa";?></b></font></td>
         </tr>
         <tr>
           <td width="2%" align="center"><b>N.</b></td>
           <td width="6%" align="center"><b>HAWB</b></td>
           <td width="5%" align="center"><b>DATA</b></td>
           <td width="8%" align="center"><b>SERVIÇO</b></td>
           <td width="8%" align="center"><b>CLIENTE</b></td>
           <td width="15%" align="center"><b>DESTINO</b></td>
           <td width="17%" align="center"><b>RUA</b></td>
           <td width="4%" align="center"><b>NUME</b></td>
           <td width="13%" align="center"><b>BAIRRO</b></td>
           <td width="13%" align="center"><b>CIDADE</b></td>
           <td width="2%" align="center"><b>UF</b></td>
           <td width="5%" align="center"><b>CEP</b></td>
           <td width="2%" align="center"><b>CL.</b></td>
         </tr>
        <?php

         $resultado = mysql_query ("SELECT remessa.n_remessa,remessa.n_hawb,date_format(remessa.dt_remessa,'%d/%m/%Y'),
         serv_ati.descri_se,cli_for.nome,remessa.nome_desti,remessa.rua_desti,remessa.numero_desti,remessa.bairro_desti,
         remessa.cidade_desti,remessa.estado_desti,remessa.classe_cep,remessa.cep_desti
         FROM remessa,serv_ati,cli_for
         WHERE ((n_remessa='$v_n_remessa')
         AND (remessa.co_servico=serv_ati.codigo_se)
         AND (remessa.codi_cli=cli_for.cnpj_cpf))");
         $total = mysql_num_rows($resultado);
         $ni=0;
         for($i=0; $i<$total; $i++){
          $dados = mysql_fetch_row($resultado);
          $n_remessa            =$dados[0];
          $v_n_hawb             =$dados[1];
          $data_remessa         =$dados[2];
          $servico              =$dados[3];
          $cliente              =$dados[4];
          $destino              =$dados[5];
          $rua                  =$dados[6];
          $numero               =$dados[7];
          $bairro               =$dados[8];
          $cidade               =$dados[9];
          $estado               =$dados[10];
          $cla_cep              =$dados[11];
          $cepe_des             =$dados[12];
          $ni=$i+1;
          echo "<tr>";
            echo "<td width=\"2%\" align=\"left\"><font size=\"1\" face=\"arial\">$ni</font></td>";
            echo "<td width=\"6%\" align=\"left\"><font size=\"1\" face=\"arial\">$v_n_hawb</font></td>";
            echo "<td width=\"5%\"><font size=\"1\" face=\"arial\">$data_remessa</font></td>";
            echo "<td width=\"8%\"><font size=\"1\" face=\"arial\">$servico</font></td>";
            echo "<td width=\"8%\"><font size=\"1\" face=\"arial\">$cliente</font></td>";
            echo "<td width=\"15%\"><font size=\"1\" face=\"arial\">$destino</font></td>";
            echo "<td width=\"17%\"><font size=\"1\" face=\"arial\">$rua</font></td>";
            echo "<td width=\"4%\"><font size=\"1\" face=\"arial\">$numero</font></td>";
            echo "<td width=\"13%\"><font size=\"1\" face=\"arial\">$bairro</font></td>";
            echo "<td width=\"13%\"><font size=\"1\" face=\"arial\">$cidade</font></td>";
            echo "<td width=\"2%\"><font size=\"1\" face=\"arial\">$estado</font></td>";
            echo "<td width=\"5%\"><font size=\"1\" face=\"arial\">$cepe_des</font></td>";
            echo "<td width=\"2%\"><font size=\"1\" face=\"arial\">$cla_cep</font></td>";
         echo "</tr>";
       }
    ?>
    <tr>
      <td colspan="6">
          <div align="left">
             <INPUT type=button value="Consulta HAWB"
             onClick="window.open('consulta_remessa_por_hawb_tela.php','janela_1',
             'scrollbars=yes,resizable=yes,width=800,height=400');">
          </div>
      </td>
      <td colspan="7">
        <div align="right">
         <input name="nova" type="submit" value="Nova Remessa">
        </div>
      </td>
    </tr>
    <table width="70%" border="1" cellpadding="5" cellspacing="0" bordercolor="#4169E1">
      <?php $_SESSION['forma_grava_m']  ='D';?>
       <tr>
           <td align="center" colspan="3"><b>Codigo Barras:</b>
               <input type="text" name="cod_barra" id="cod_barra" value ="<?php echo "$codi_barra";?>" size="40" maxlength="40" onChange="salva(this)"></td>
           </tr>

           <!-- Coloca foco no primeiro campo codigo de barras do formulário -->

           <script language="JavaScript">
                document.getElementById('cod_barra').focus()
           </script>
           <tr>
              <td><b>Número da HAWB :</b></td>
              <td><input type="text" name="n_hawb" id="n_hawb" value ="<?php echo "$n_hawb";?>" size="14" maxlength="14"><input name="informa" type="submit" value="Informa HAWB"</td>
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

