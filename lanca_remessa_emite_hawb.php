<?php

  session_start();
   //carrega variaveis com dados para acessar o banco de dados

  $base_d     =$_SESSION['base_d'];
  $banco_d    =$_SESSION['banco_d'];
  $usuario_d  =$_SESSION['usuario_d'];
  $senha_d    =$_SESSION['senha_d'];

  //$escritorio_m =$_SESSION['depto_m'];

  $matricula_m  =$_SESSION['matricula_m'];
  $programa='107';
  $_SESSION['programa_m']=$programa;

  //Abre a conexão com o banco de dados

  $con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
  $res = mysql_select_db($banco_d,$con) or die ("Banco de dados inexistente");

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

  function get_post_action($name) {
    $params = func_get_args();
    foreach ($params as $name) {
        if (isset($_POST[$name])) {
            return $name;
        }
    }
  }
  include ("campo_calendario.php");
  include ("pega_cep.php");

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
  <title>lanca_remessa_emite_hawb.php</title>
  <head>
     <script type="text/javascript" src="jquery-autocomplete/lib/jquery.js"></script>
     <script type="text/javascript" src="jquery-autocomplete/lib/jquery.bgiframe.min.js"></script>
     <script type="text/javascript" src="jquery-autocomplete/lib/jquery.ajaxQueue.js"></script>
     <script type="text/javascript" src="jquery-autocomplete/lib/thickbox-compressed.js"></script>
     <script type="text/javascript" src="jquery-autocomplete/jquery.autocomplete.js"></script>
     <!--css -->
     <link rel="stylesheet" type="text/css" href="jquery-autocomplete/jquery.autocomplete.css"/>
     <link rel="stylesheet" type="text/css" href="jquery-autocomplete/lib/thickbox.css"/>
     <script type="text/javascript">
     <!-- FUNÇÃO QUE VERIFICA SE CAMPOS FORAM PREENCHIDOS-->

        function validar() {
          var n_remessa    = cadastro.n_remessa.value;
          var rua_desti    = cadastro.rua_desti.value;
          var numero_desti = cadastro.numero_desti.value;
          var bairro_desti = cadastro.numero_desti.value;
          var cidade_desti = cadastro.numero_desti.value;
          if (n_remessa == "") {
             alert('O campo NÚMERO DA REMESSA não foi preenchido! Verifique.');
             cadastro.n_remessa.focus();
             return false;
          }
          if (cep_desti == "") {
             alert('O campo CEP DO DESTINATÁRIO não foi preenchido! Verifique.');
             cadastro.cep_desti.focus();
             return false;
          }
          if (rua_desti == "") {
             alert('O campo RUA DO DESTINATÁRIO não foi preenchido! Verifique.');
             cadastro.rua_desti.focus();
             return false;
          }
          if (numero_desti == "") {
             alert('O campo NÚMERO DO DESTINATÁRIO não foi preenchido! Verifique.');
             cadastro.numero_desti.focus();
             return false;
          }
          if (bairro_desti == "") {
             alert('O campo BAIRRO DO DESTINATÁRIO não foi preenchido! Verifique.');
             cadastro.bairro_desti.focus();
             return false;
          }
          if (cidade_desti == "") {
             alert('O campo CIDADE DO DESTINATÁRIO não foi preenchido! Verifique.');
             cadastro.cidade_desti.focus();
             return false;
          }
          if (cep == "") {
             alert('O campo CEP DO DESTINATÁRIO não foi preenchido! Verifique.');
             cadastro.cep.focus();
             return false;
          }
        }
        <!-- FUNÇÃO QUE ATIVA CODIGO DE BARRAS-->

        function salva(campo){
           cadastro.submit()
        }

        <!-- FUNÇÃO PROCURA DESTINO POR NOME-->

        $(document).ready(function(){
	 	   $("#nome_desti").autocomplete("completar.php", {
	 		  width:350,
	 		  selectFirst: false
	 	   });

	    });

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
           else {
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
           if (window.event) { //IE
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
         <p align="right"><font face="Arial" size="2" color="#FFFFFF"><b>Lança Remessa Com geração de HAWB</b></font></td>
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
     <table width="80%" heigth="300">
     <?php
        $codi_barra     =$_POST['cod_barra'];
        if ($codi_barra<>'') {
             $_SESSION['codi_barra_m']   =$codi_barra;
             //Verifica se o a HAWB já foi lançada
             $localiza = "SELECT cod_barra FROM remessa
             WHERE cod_barra='$codi_barra'";
             $query = mysql_db_query($banco_d,$localiza,$con) or die ("Não foi possivel acessar o banco 1");
             $achou = mysql_num_rows($query);
             If ($achou > 0 ) {
                $codi_barra='';
                ?>
                  <script language="javascript"> window.location.href=("lanca_remessa_emite_hawb.php")
                     alert('HAWB já foi lançada.');
                  </script>
                <?php
             }
             else {
                 //Pega o codigo do destinatário e o numero da hawb
                if(strlen($codi_barra) == 26){
                   $codigo_desti          =Substr($codi_barra,0,8);
                   $codigo_desti          =intval($codigo_desti);
                   $n_hawb                =Substr($codi_barra,17,10);
                   $n_hawb                =intval($n_hawb);
                   $_SESSION['n_hawb_m']  =$n_hawb;
                   //Pega os dados do destino a parir do código extraido do codigo de barras
                   $resp_grava='';
                   $verifi="SELECT codigo_desti,nome_desti,cep_desti,rua_desti,numero_desti,
                   comple_desti,bairro_desti,cidade_desti,estado_desti,classe_cep
                   FROM destino WHERE codigo_desti='$codigo_desti'";
                   $query = mysql_db_query($banco_d,$verifi,$con) or die ("Não foi possivel acessar o banco");
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
                   }
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
                }
                $codi_barra                 =$_SESSION['codi_barra_m'];
                $n_hawb                     =$_SESSION['n_hawb_m'];
             }
        }
        $escritorio      =$_SESSION['escritorio_m'];
        $dt_remessa      =$_SESSION['dt_remessa_m'];
        $codi_cli        =$_SESSION['codi_cli_m'];
        $codi_servi      =$_SESSION['servico_m'];
        $v_n_remessa     =$_SESSION['n_remessa_m'];
        $cep_branco   =$_SESSION['cep_branco_m'];
        
    if ($cep_branco==1) {
        $escritorio      =$_SESSION['escritorio_m'];
        $dt_remessa      =$_SESSION['dt_remessa_m'];
        $codi_cli        =$_SESSION['codi_cli_m'];
        $codi_servi      =$_SESSION['servico_m'];
        $n_remessa       =$_SESSION['n_remessa_m'];
        $codi_barra      =$_SESSION['codi_barra_m'];
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
    }
    switch (get_post_action('grava','busca','localiza','ativa_ser','gera','ativa_cli')) {
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
           $_SESSION['codi_cli_m']     =$codi_cli;

           //$dt_remessa  =$_SESSION['dt_remessa_m'];

           //echo "Data Remessa :$dt_remessa";
      break;

      case 'ativa_ser':
           unset($_SESSION['servico_m']);
           unset($_SESSION['servi_m']);
           $codi_servi                       =$_POST['codigo_servi'];
           //Atribui valor 1 para a variavel que controla serviço

           $_SESSION['conservi_m']=1;

           //Guarda codigo serviço na memoria

           $_SESSION['servico_m']      =$codi_servi;
           $_SESSION['servi_m']        =$codi_servi;

           //echo "<p>Serviço :$tipo_servi";
      break;

      case 'gera':
              if($_SESSION['conservi_m']==0) {
                 ?>
                 <script language="javascript"> window.location.href=("lanca_remessa_emite_hawb.php")
                      alert('VOCÊ NÃO ATIVOU O SERVIÇO!!!! ATIVE-O E DEPOIS GERE O NÚMERO DAREMESSA.');
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
                     unset($_SESSION['n_remessa_m']);
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

                     //Zera a variavel que controla a ativação do serviço

                     $_SESSION['conservi_m']=0;

                     //Atualiza a tabela de controle de numero de remessas

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
           $n_remessa       =$_SESSION['n_remessa_m'];
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
           $n_remessa       =$_SESSION['n_remessa_m'];
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

      case 'grava':
           $codi_cli        =$_POST['codi_cli'];
           $n_remessa       =$_POST['n_remessa'];
           $escritorio      =$_POST['escritorio'];
           $codi_servi      =$_POST['codigo_servi'];
           $qtdade          =$_POST['qtdade'];
           $valor           =$_POST['valor'];
           $codigo_desti    =$_POST['codigo_desti'];
           $nome_desti      =$_POST['nome_desti'];
           $cnpj_desti      =$_POST['cnpj_desti'];
           $cep_desti       =$_POST['cep'];
           $rua_desti       =$_POST['rua_desti'];
           $numero_desti    =$_POST['numero_desti'];
           $comple_desti    =$_POST['comple_desti'];
           $bairro_desti    =$_POST['bairro_desti'];
           $cidade_desti    =$_POST['cidade_desti'];
           $estado_desti    =$_POST['estado_desti'];
           $adm_m        =$_SESSION['adm_m'];
           if ($adm_m=='N') {
              $dt_remessa =$_SESSION['dt_remessa_m'];
           }
           if ($adm_m=='S') {
              $dt_remessa                       =$_POST['dt_remessa'];
           }
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
              $_SESSION['cnpj_desti_m']    =$_POST['cnpj_desti'];
              $_SESSION['cep_desti_m']     =$_POST['cep'];
              $_SESSION['rua_desti_m']     =$_POST['rua_desti'];
              $_SESSION['numero_desti_m']  =$_POST['numero_desti'];
              $_SESSION['comple_desti_m']  =$_POST['comple_desti'];
              $_SESSION['bairro_desti_m']  =$_POST['bairro_desti'];
              $_SESSION['cidade_desti_m']  =$_POST['cidade_desti'];
              $_SESSION['estado_desti_m']  =$_POST['estado_desti'];
              $_SESSION['classe_cep']      =$_POST['classe_cep'];
              ?>
              <script language="javascript"> window.location.href=("lanca_remessa_emite_hawb.php")
                  alert('A classe de CEP destedestino está em branco, Defina a Classe de CEP, se não haverá problema no Faturamento.');
              </script>
              <?php
           }
           else {
              if ($classe_cep<>'04') {
                  //Atribui valor 1 a quantidade caso não tenha sido digitado outro valor
                  if ($qtdade=='') {
                     $qtdade=1;
                  }

                  //Pega valor do serviço na tabela de preço
                  if (($codi_cli<>'') and ($codi_servi<>'') and ($classe_cep<>'') and ($valor=='')) {
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

                    $dt_remessa  = explode("/",$dt_remessa);
                    $v_dt_remessa = $dt_remessa[2]."-".$dt_remessa[1]."-".$dt_remessa[0];

                    //Organiza os dados para gerar a HAWB

                    $_SESSION['codi_cli_m']   =$codi_cli;

                    $resultado = mysql_query ("SELECT nome FROM cli_for
                    WHERE cnpj_cpf='$codi_cli'");
                    $total = mysql_num_rows($resultado);
                    for($i=0; $i<$total; $i++){
                      $dados = mysql_fetch_row($resultado);
                      $nome_cli       =$dados[0];
                    }

                    $codi_servi   =$_SESSION['servico_m'];

                    $resultado = mysql_query ("SELECT descri_se FROM serv_ati
                    WHERE codigo_se='$codi_servi'");
                    $total = mysql_num_rows($resultado);
                    for($i=0; $i<$total; $i++){
                      $dados = mysql_fetch_row($resultado);
                      $nome_servi       =$dados[0];
                    }
                    $dt_remessa     =$_SESSION['dt_remessa_m'];
                    $d = explode("/", $dt_remessa);
                    $dia  =$d[0];
                    $mes  =$d[1];
                    $ano  =$d[2];
                    $v_dt_hawb = $dia.$mes.$ano;
                    $hr_hawb   = date ('H:i:s');
                    $v_hr_hawb = str_replace(":", "", $hr_hawb);
                    $n_hawb      =$v_dt_hawb.$v_hr_hawb;
                    $codi_barra  =$codi_cli.$v_dt_hawb.$v_hr_hawb;

                    $_SESSION['nome_cli_h']         =$nome_cli;
                    $_SESSION['nome_desti_h']       =$nome_desti;
                    $_SESSION['rua_desti_h']        =$rua_desti;
                    $_SESSION['numero_desti_h']     =$numero_desti;
                    $_SESSION['comple_desti_h']     =$comple_desti;
                    $_SESSION['bairro_desti_h']     =$bairro_desti;
                    $_SESSION['cidade_desti_h']     =$cidade_desti;
                    $_SESSION['estado_desti_h']     =$estado_desti;
                    $_SESSION['cep_desti_h']        =$cep_desti;
                    $_SESSION['cnpj_desti_h']       =$cnpj_desti;
                    $_SESSION['cod_barra_h']        =$codi_barra;
                    $_SESSION['n_hawb_h']           =$n_hawb;
                    $_SESSION['servico_h']          =$nome_servi;

                    $n_hawb          =$v_dt_hawb.$v_hr_hawb;

                    //Grava os dados na tabela remessa

                    $inclusao = "INSERT INTO remessa(
                    codi_cli,
                    n_remessa,
                    escritorio,
                    cod_barra,
                    tipo_servi,
                    codigo_desti,
                    nome_desti,
                    cep_desti,
                    cnpj_desti,
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
                    valor,
                    co_servico)
                    VALUES(
                    '$codi_cli',
                    '$n_remessa',
                    '$escritorio',
                    '$codi_barra',
                    '$codi_servi',
                    '$codigo_desti',
                    '$nome_desti',
                    '$cep_desti',
                    '$cnpj_desti',
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
                    '$valor',
                    '$codi_servi')";
                    if (mysql_db_query($banco_d,$inclusao,$con)) {

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

         //////////////////Atualiza a tabela de controle de ações no sistema ////////////////////

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

         //////////////////Atualiza a tabela de histórico HAWB /////////////////////////////////

                       $atualiza="INSERT INTO controle_reentrega (n_hawb,dt_evento,ocorrencia,cod_barra)
                       VALUES('$n_hawb','$v_dt_remessa','Recebido na Transportadora.','$codi_barra')";
                       mysql_db_query($banco_d,$atualiza,$con);
                       unset($_SESSION['codigo_desti_m']);
                       $codigo_desti          ='';
                       unset($_SESSION['nome_desti_m']);
                       $nome_desti            ='';
                       unset($_SESSION['cep_desti_m']);
                       $cep                   ='';
                       unset($_SESSION['cnpj_desti_m']);
                       $cnpj_desti            ='';
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
                       $dt_remessa            =$_SESSION['dt_remessa_m'];
                       $codi_cli              =$_SESSION['codi_cli_m'];
                       $escritorio            =$_SESSION['escritorio_m'];
                       $v_n_remessa           =$_SESSION['n_remessa_m'];
                       $codi_servi            =$_SESSION['servico_m'];
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

                       $resp_grava="Inclusão bem sucedida";
                    }
                    else {
                       $resp_grava="Problemas na Inclusão";
                    }
              }
              else{
                 ?>
                 <script language="javascript"> window.location.href=("lanca_remessa_emite_hawb.php")
                    alert('HAWB NÃO GRAVADA, pois está fora de contrato! Verifique.');
                 </script>
                 <?php
                 unset($_SESSION['codi_barra_m']);
                 $codi_barra     ='';
                 unset($_SESSION['n_hawb_m']);
                 $n_hawb         ='';
              }
           }
       break;
       default:

    }
     //Preenche os campos já com os valores digitados

     ?>
     <form method="POST" name="cadastro" action="lanca_remessa_emite_hawb.php" border="20" align="center">
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
               ?>
               <select name="codi_cli">
              <?php
                $sql2 = "SELECT cnpj_cpf,nome FROM cli_for WHERE ativo='S'";
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
                AND (tabela_preco.ativo='S')
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
	<table width="70%" border="1" cellpadding="5" cellspacing="0" bordercolor="#4169E1">
		<tr>
           <?php $qtdade    =$_SESSION['qtdade_m'];
           $codi_servi      =$_SESSION['servi_m'];
           if ($codi_servi=='0006') {
             ?>
              <td><b>Qtdade Serviço :</b></td>
              <td><input name="qtdade" type="text" id="qtdade" value ="<?php echo "$qtdade";?>" size="6" maxlength="6"></td>
             <?php
           }
           ?>

        </tr>
        <!--<tr>

			<td><b>Valor :</b></td>

			<td><input name="valor" type="text" size="20" maxlength="20" onKeydown="Formata(this,20,event,2)"></td>

		</tr>-->
        <tr>
            <?php $nome_desti    =$_SESSION['nome_desti_m'];?>
			<td><b>Nome Destino :</b></td>
			<br />
			<td><input type="text" name="nome_desti" id="nome_desti" value ="<?php echo "$nome_desti";?>" size="50" maxlength="50" class="input_forms"/><input name="localiza" type="submit" value="Busca Dados Destino"></td>
	    </tr>
		<tr>
           <?php $codigo_desti    =$_SESSION['codigo_desti_m'];?>
           <td><b>Código Destino :</b></td>
           <td><input type="text" name="codigo_desti" id="codigo_desti" value ="<?php echo "$codigo_desti";?>" size="14" maxlength="14"></td>
		</tr>
        <tr>
           <td><b>CNPJ Destino :</b></td>
           <td><input name="cnpj_desti" type="text" id="cnpj_desti" value ="<?php echo "$cnpj_desti";?>" size="20" maxlength="20"></td>
        </tr>
		<tr>
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
          <td><INPUT type=button value="Consulta HAWB"
               onClick="window.open('consulta_remessa_por_hawb_tela.php','janela_1',
               'scrollbars=yes,resizable=yes,width=800,height=400');">
          </td>
		  <td colspan="2">
		     <div align="right">
			   <input name="grava" type="submit" onclick="return validar()" value="Gravar">
			 </div>
		  </td>
		</tr>
		<tr>
            <td align="right" colspan="2"><INPUT type=button value="Imprime HAWB"
               onClick="window.open('gera_segunda_via_hawb.php','janela_1',
               'scrollbars=yes,resizable=yes,width=800,height=600');">
            </td>
		</tr>
	</table>
  </form>
  </div>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
         <td align="left" width="45%"><INPUT type=button size="3" value="Classe CEP"
               onClick="window.open('mostra_classe_cep.php','janela_1',
               'scrollbars=yes,resizable=yes,width=800,height=700');" style="width:100;height:30;color=red;font: bold 16px Arial;">
         </td>
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



