<?php
  session_start();

   //carrega variaveis com dados para acessar o banco de dados

  $base_d     =$_SESSION['base_d'];
  $banco_d    =$_SESSION['banco_d'];
  $usuario_d  =$_SESSION['usuario_d'];
  $senha_d    =$_SESSION['senha_d'];

  $escritorio_m =$_SESSION['depto_m'];
  $matricula_m  =$_SESSION['matricula_m'];
  $programa='43';
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
   $dt_remessa       = date('d/m/Y');
   $_SESSION['dt_remessa_m']   =$dt_remessa;
   
?>
<html>
  <title>inclui_remessa_reentrega.php</title>
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
          var n_hawb = cadastro.n_hawb.value;
          var n_remessa = cadastro.n_remessa.value;
          var rua_desti = cadastro.rua_desti.value;
          var numero_desti = cadastro.numero_desti.value;
          var bairro_desti = cadastro.numero_desti.value;
          var cidade_desti = cadastro.numero_desti.value;
          if (n_hawb == "") {
             alert('O campo da HAWB não foi preenchido! Verifique.');
             cadastro.n_hawb.focus();
             return false;
          }
          if (n_remessa == "") {
             alert('O campo NÚMERO DA REMESSA não foi preenchido! Verifique.');
             cadastro.n_remessa.focus();
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
         <p align="right"><font face="Arial" size="2" color="#FFFFFF"><b>Inclusão de reentrega</b></font></td>
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
        
    switch (get_post_action('grava','busca','localiza','ativa_ser','pega')) {
      case 'pega':
           $n_hawb     =$_POST['n_hawb'];

           if ($n_hawb<>'') {
             $_SESSION['n_hawb_m']    =$n_hawb;
             //localiza o registro

             $con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
             $res = mysql_select_db($banco_d) or die ("Banco de dados inexistente");

             $localiza = "SELECT cod_barra,n_hawb,date_format(dt_remessa,'%d/%m/%Y'),codi_cli,n_remessa,
             escritorio,co_servico,codigo_desti,nome_desti,cep_desti,rua_desti,numero_desti,comple_desti,
             bairro_desti,cidade_desti,estado_desti,qtdade,controle,classe_cep,valor,reentrega
             FROM remessa
             WHERE n_hawb='$n_hawb'";

             $query = mysql_db_query($banco_d,$localiza,$con) or die ("Não foi possivel acessar o banco 1");
             $total = mysql_num_rows($query);

             If ($total > 0 ) {
                for($ic=0; $ic<$total; $ic++){
                   $mostra = mysql_fetch_row($query);
                   $codi_barra     = $mostra[0];
                   $n_hawb         = $mostra[1];
                   $dt_remessa     = $mostra[2];
                   $codi_cli       = $mostra[3];
                   $n_remessa      = $mostra[4];
                   $escritorio     = $mostra[5];
                   $co_servico     = $mostra[6];
                   $codigo_desti   = $mostra[7];
                   $nome_desti     = $mostra[8];
                   $cep            = $mostra[9];
                   $rua_desti      = $mostra[10];
                   $numero_desti   = $mostra[11];
                   $comple_desti   = $mostra[12];
                   $bairro_desti   = $mostra[13];
                   $cidade_desti   = $mostra[14];
                   $estado_desti   = $mostra[15];
                   $qtdade         = $mostra[16];
                   $controle       = $mostra[17];
                   $classe_cep     = $mostra[18];
                   $valor          = $mostra[19];
                   $reentrega      = $mostra[20];

                   $_SESSION['controle_m']    =$controle;
                   
                   $_SESSION['codi_cli_m']    =$codi_cli;
                   $_SESSION['escritorio_m']  =$escritorio;
                   $_SESSION['dt_remessa_m']  =$dt_remessa;
                   $_SESSION['n_remessa_m']   =$n_remessa;
                   $_SESSION['codi_barra_m']  =$codi_barra;
                   $_SESSION['co_servico_m']  =$co_servico;
                   $_SESSION['qtdade_m']      =$qtdade;
                   $_SESSION['nome_desti_m']  =$nome_desti;
                   $_SESSION['codigo_desti_m']=$codigo_desti;
                   $_SESSION['cep_m']         =$cep;
                   $_SESSION['rua_desti_m']   =$rua_desti;
                   $_SESSION['numero_desti_m']=$numero_desti;
                   $_SESSION['comple_desti_m']=$comple_desti;
                   $_SESSION['bairro_desti_m']=$bairro_desti;
                   $_SESSION['cidade_desti_m']=$cidade_desti;
                   $_SESSION['estado_desti_m']=$estado_desti;
                   $_SESSION['classe_cep_m']  =$classe_cep;
                   $_SESSION['valor_m']       =$valor;
                   $_SESSION['reentrega_m']   =$reentrega;
                }

             }
             else {
                $n_hawb='';
                ?>
                 <script language="javascript"> window.location.href=("lanca_remessa_com_leitora.php")
                   alert('HAWB Não Localizada! Verifique.');
                 </script>
                <?php
             }
        }
        $codi_cli        =$_SESSION['codi_cli_m'];
        $escritorio      =$_SESSION['escritorio_m'];
        $dt_remessa      =$_SESSION['dt_remessa_m'];
        $v_n_remessa     =$_SESSION['v_n_remessa_m'];
      break;
      case 'ativa_ser':
           $escritorio                       =$_POST['escritorio'];
           $dt_remessa                       =$_POST['dt_remessa'];
           $codi_cli                         =$_POST['codi_cli'];
           $co_servico                       =$_POST['tipo_servi'];
           
           //recupera o que está na memoria para não perder os dados já alterados
           $_SESSION['escritorio_m']   =$escritorio;
           $_SESSION['dt_remessa_m']   =$dt_remessa;
           $_SESSION['codi_cli_m']     =$codi_cli;
           $_SESSION['co_servico_m']   =$co_servico;
           
           $n_remessa                  =$_SESSION['n_remessa_m'];
           $codi_barra                 =$_SESSION['codi_barra_m'];
           $qtdade                     =$_SESSION['qtdade_m'];
           $nome_desti                 =$_SESSION['nome_desti_m'];
           $codigo_desti               =$_SESSION['codigo_desti_m'];
           $cep                        =$_SESSION['cep_m'];
           $rua_desti                  =$_SESSION['rua_desti_m'];
           $numero_desti               =$_SESSION['numero_desti_m'];
           $comple_desti               =$_SESSION['comple_desti_m'];
           $bairro_desti               =$_SESSION['bairro_desti_m'];
           $cidade_desti               =$_SESSION['cidade_desti_m'];
           $estado_desti               =$_SESSION['estado_desti_m'];
           $classe_cep                 =$_SESSION['classe_cep_m'];
           $valor                      =$_SESSION['valor_m'];
           $reentrega                  =$_SESSION['reentrega_m'];
      break;
      
      case 'localiza':
           $codi_barra                  =$_POST['cod_barra'];
           $co_servico                  =$_POST['tipo_servi'];
           $n_hawb                      =$_POST['n_hawb'];
           $nome_desti                  =$_POST['nome_desti'];
           $codigo_desti                =$_POST['codigo_desti'];
           $qtdade                      =$_POST['qtdade'];
           $_SESSION['nome_desti_m']    =$nome_desti;
           $v_nome_desti                =trim($nome_desti);
           $_SESSION['n_hawb_m']        =$n_hawb;
           $v_n_remessa                 =$_POST['n_remessa'];
           $_SESSION['n_remessa_m']     =$v_n_remessa;
           $_SESSION['tipo_servi_m']    =$tipo_servi;

           $con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
           $res = mysql_select_db($banco_d) or die ("Banco de dados inexistente");

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
           }
           $escritorio      =$_SESSION['escritorio_m'];
           $dt_remessa      =$_SESSION['dt_remessa_m'];
           $codi_cli        =$_SESSION['codi_cli_m'];
           $v_n_remessa     =$_SESSION['v_n_remessa_m'];
           $codi_barra      =$_SESSION['codi_barra_m'];
           $v_n_remessa     =$_SESSION['n_remessa_m'];

           //Se localizar os dados do destino grava na memoria
           
           $_SESSION['codigo_desti_m']    =$codigo_desti ;
           $_SESSION['nome_desti_m']      =$nome_desti;
           $_SESSION['cep_m']             =$cep ;
           $_SESSION['rua_desti_m']       =$rua_desti;
           $_SESSION['bairro_desti_m']    =$bairro_desti;
           $_SESSION['cidade_desti_m']    =$cidade_desti ;
           $_SESSION['estado_desti_m']    =$estado_desti;
           $_SESSION['classe_cep_m']      =$classe_cep;
      break;
      
      case 'busca':
           $cep                         =$_POST['cep'];
           $nome_desti                  =$_POST['nome_desti'];
           $codigo_desti                =$_POST['codigo_desti'];
           $qtdade                      =$_POST['qtdade'];
           $_SESSION['qtdade_m']        =$qtdade;
           $_SESSION['nome_desti_m']    =$nome_desti;
           $_SESSION['codigo_desti_m']  =$codigo_desti;
           unset($_SESSION['rua_desti_m']);
           unset($_SESSION['comple_desti_m']);
           unset($_SESSION['bairro_desti_m']);
           unset($_SESSION['cidade_desti_m']);
           unset($_SESSION['estado_desti_m']);
           unset($_SESSION['cep']);
           
           pega_cep($cep);

           $escritorio      =$_SESSION['escritorio_m'];
           $dt_remessa      =$_SESSION['dt_remessa_m'];
           $codi_cli        =$_SESSION['codi_cli_m'];
           $co_servico      =$_SESSION['co_servico_m'];
           $n_remessa       =$_SESSION['n_remessa_m'];
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
           $classe_cep      =$_SESSION['classe_cep_m'];
           $valor           =$_SESSION['valor_m'];
           $reentrega       =$_SESSION['reentrega_m'];
           
           $_SESSION['cep_m']         =$cep;
           $_SESSION['rua_desti_m']   =$rua_desti;
           $_SESSION['bairro_desti_m']=$bairro_desti;
           $_SESSION['cidade_desti_m']=$cidade_desti;
           $_SESSION['estado_desti_m']=$estado_desti;
           
      break;
      
      case 'grava':
           $controle        =$_SESSION['controle_m'];
           $codi_cli        =$_POST['codi_cli'];
           $n_remessa       =$_POST['n_remessa'];
           $escritorio      =$_POST['escritorio'];
           $co_servico      =$_POST['tipo_servi'];
           $codi_barra      =$_POST['cod_barra'];
           $codigo_desti    =$_POST['codigo_desti'];
           $qtdade          =$_POST['qtdade'];
           $nome_desti      =$_POST['nome_desti'];
           $cep             =$_POST['cep'];
           $rua_desti       =$_POST['rua_desti'];
           $numero_desti    =$_POST['numero_desti'];
           $comple_desti    =$_POST['comple_desti'];
           $bairro_desti    =$_POST['bairro_desti'];
           $cidade_desti    =$_POST['cidade_desti'];
           $estado_desti    =$_POST['estado_desti'];
           $dt_remessa      =$_POST['dt_remessa'];
           $comple_desti    =$_POST['comple_desti'];
           $n_hawb          =$_POST['n_hawb'];
           $classe_cep      =$_POST['classe_cep'];
           $valor           =$_POST['valor'];
           $reentrega       ='R';
           
           $n_hawb='R'.$n_hawb;
           
           if ($qtdade=='') {
               $qtdade=1;
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
            else {
                $con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
                $res = mysql_select_db($banco_d) or die ("Banco de dados inexistente");

                //Pega valor do serviço na tabela de preços

                $pegava="SELECT valor FROM tabela_preco
                WHERE ((codi_cli='$codi_cli') AND (tipo_servi='$tipo_servi') AND (classe_cep='$classe_cep'))";
                $query_2 = mysql_db_query($banco_d,$pegava,$con) or die ("Não foi possivel acessar o banco 2");
                $total = mysql_num_rows($query_2);

                for($ic=0; $ic<$total; $ic++){
                   $row = mysql_fetch_row($query_2);
                   $valor        = $row[0];
                }

            }
           
           //mudando formato da data para gravar na tabela

           $dt_remessa  = explode("/",$dt_remessa);
           $v_dt_remessa = $dt_remessa[2]."-".$dt_remessa[1]."-".$dt_remessa[0];

           if ($n_hawb<>'') {
              $con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
              $res = mysql_select_db($banco_d) or die ("Banco de dados inexistente");

              //Verifica se o a HAWB já foi lançada

              $localiza = "SELECT n_hawb
              FROM remessa
              WHERE n_hawb='$n_hawb'";

              $query = mysql_db_query($banco_d,$localiza,$con) or die ("Não foi possivel acessar o banco 1");
              $achou = mysql_num_rows($query);

              If ($achou > 0 ) {
                $n_hawb='';
                ?>
                 <script language="javascript"> window.location.href=("inclui_remessa_reentrega.php")
                   alert('HAWB já foi reincluida ! Verifique.');
                 </script>
                <?php
              }
              else {
             
                 $inclusao= "INSERT INTO remessa (codi_cli,n_remessa,escritorio,co_servico,cod_barra,codigo_desti,
                 nome_desti,cep_desti,rua_desti,numero_desti,bairro_desti,cidade_desti,estado_desti,dt_remessa,
                 qtdade,comple_desti,n_hawb,classe_cep,valor,reentrega) VALUES ('$codi_cli','$n_remessa','$escritorio',
                 '$co_servico','$codi_barra','$codigo_desti','$nome_desti','$cep','$rua_desti','$numero_desti','$bairro_desti',
                 '$cidade_desti','$estado_desti','$v_dt_remessa','$qtdade','$comple_desti','$n_hawb','$classe_cep','$valor',
                 '$reentrega')";

                 if (mysql_db_query($banco_d,$inclusao,$con)) {
                    $resp_grava="Reinclusão bem sucedida";

                    unset($_SESSION['codigo_desti_m']);
                    $codigo_desti          ='';
                    unset($_SESSION['nome_desti_m']);
                    $nome_desti            ='';
                    unset($_SESSION['cep_m']);
                    $cep                   ='';
                    unset($_SESSION['rua_desti_m']);
                    $rua_desti             ='';
                    $numero_desti          ='';
                    unset($_SESSION['bairro_desti_m']);
                    $bairro_desti          ='';
                    unset($_SESSION['cidade_desti_m']);
                    $cidade_desti          ='';
                    unset($_SESSION['estado_desti_m']);
                    $estado_desti          ='';
                    unset($_SESSION['dt_remessa_m']);
                    $dt_remessa            ='';
                    unset($_SESSION['codi_cli_m']);
                    $codi_cli              ='';
                    unset($_SESSION['escritorio_m']);
                    $escritorio            ='';
                    unset($_SESSION['n_remessa_m']);
                    $v_n_remessa           ='';
                    unset($_SESSION['co_servico_m']);
                    $co_servico            ='';
                    unset($_SESSION['codi_barra_m']);
                    $codi_barra            ='';
                    $comple_desti          ='';
                    unset($_SESSION['n_hawb_m']);
                    $n_hawb                ='';
                    unset($_SESSION['qtdade_m']);
                    $qtdade                ='';
                    unset($_SESSION['controle_m']);
                    unset($_SESSION['classe_cep_m']);
                    $valor                 ='';
                    unset($_SESSION['valor_m']);
                 }
                 else {
                    $resp_grava="Problemas na Reinclusão";
                 }
              }
           }
           break;
           default:
    }
      //Preenche os campos já com os valores digitados
     ?>
    <form method="POST" name="cadastro" action="inclui_remessa_reentrega.php" border="20" align="center">
    <body leftmargin="10" topmargin="10" marginwidth="10" marginheight="10">
	<table width="70%" border="1" cellpadding="5" cellspacing="0" bordercolor="#4169E1">
        <tr>
            <?php $n_remessa    =$_SESSION['n_remessa_m'];?>
			<td><b>Número da Remessa:</b></td>
			<td><input type="text" name="n_remessa" value ="<?php echo "$n_remessa";?>" size="17" maxlength="17" id="n_remessa"></td>
		</tr>
        <tr>
           <?php $n_hawb    =$_SESSION['n_hawb_m'];?>
           <td><b>Número da HAWB :</b></td>
           <td><input type="text" name="n_hawb" id="n_hawb" value ="<?php echo "$n_hawb";?>" size="14" maxlength="14"><input name="pega" type="submit" value="Mostra dados"></td>
 	    </tr>
 	    <!-- Coloca foco no primeiro campo codigo de barras do formulário -->
        <script language="JavaScript">
            document.getElementById('n_hawb').focus()
        </script>
        <tr>
           <?php $codi_barra    =$_SESSION['codi_barra_m'];?>
           <td><b>Codigo Barras :</b></td>
           <td><input type="text" name="cod_barra" id="cod_barra" value ="<?php echo "$codi_barra";?>" size="60" maxlength="60" onChange="salva(this)"></td>
        </tr>
		<tr>
           <td><b>Escritório :</b></td>
           <td>
              <?php
               $adm_m        =$_SESSION['adm_m'];
               if ($adm_m=='N') {
                   $escritorio    =$_SESSION['depto_m'];
               }
               if ($adm_m=='S') {
                   $escritorio    =$_SESSION['escritorio_m'];
               }
               mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
               mysql_select_db($banco_d) or die ("Banco de dados inexistente");

               ?>
              <select name="escritorio">
              <?php
                $escritorio    =$_SESSION['escritorio_m'];
                $sql1 = "SELECT codigo,nome FROM regi_dep";
                $resula = mysql_db_query($banco_d,$sql1,$con) or die ("Não foi possivel acessar o banco");
                while ( $linha = mysql_fetch_array($resula)) {
                    $select = $escritorio == $linha[0] ? "selected" : "";
                    echo "<option value=\"". $linha[0] . "\" $select>" . $linha[1] . "</option>";
              }
              ?>
            </select>
            </td>
		</tr>
		<tr>
          <td><b>Data Remessa</b> :</b></td>
          <td>
            <input type="text" name="dt_remessa" value ="<?php echo "$dt_remessa";?>" size="12" maxlength="12" id="dt_remessa">
            <input TYPE="button" NAME="btndt_remessa" VALUE="..." Onclick="javascript:popdate('document.cadastro.dt_remessa','pop1','150',document.cadastro.dt_remessa.value)">
            <span id="pop1" style="position:absolute"></span>
          </td>
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
            </td>
		</tr>
		<tr>
           <td><b>Serviço :</b></td>
           <td>
              <?php
               $co_servico      =$_SESSION['co_servico_m'];
               mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
               mysql_select_db($banco_d) or die ("Banco de dados inexistente");

               ?>
               <select name="tipo_servi">
               <?php
                $sql3 = "SELECT codigo_se,descri_se FROM serv_ati";
                $resulo = mysql_db_query($banco_d,$sql3,$con) or die ("Não foi possivel acessar o banco");
                while ( $linha = mysql_fetch_array($resulo)) {
                    $select = $co_servico == $linha[0] ? "selected" : "";
                    echo "<option value=\"". $linha[0] . "\" $select>" . $linha[1] . "</option>";
               }
              ?>
            </select>
            </td>
		</tr>
		<tr>
           <?php $qtdade    =$_SESSION['qtdade_m'];?>
           <td><b>Qtdade Serviço :</b></td>
           <td><input name="qtdade" type="text" id="qtdade" value ="<?php echo "$qtdade";?>" size="6" maxlength="6"></td>
        </tr>
        <tr>
           <?php $valor    =$_SESSION['valor_m'];?>
           <td><b>Valor Serviço :</b></td>
           <td><input name="valor" type="text" id="valor" value ="<?php echo "$valor";?>" size="6" maxlength="6"></td>
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
           <td><input type="text" name="codigo_desti" id="codigo_desti" value ="<?php echo "$codigo_desti";?>" size="14" maxlength="14"></td>
		</tr>
		<tr>
           <?php $cep    =$_SESSION['cep_m'];?>
           <td><b>CEP Destino :</b></td>
           <td><input name="cep" type="text" id="cep" value ="<?php echo "$cep";?>" size="9" maxlength="9"><input name="busca" type="submit" value="Busca Endereço"></td>
        </tr>
        <tr>
		  <td><b>Classe CEP :</b></td>
           <td>
			  <?php
               $classe_cep    =$_SESSION['classe_cep_m'];
               mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
               mysql_select_db($banco_d) or die ("Banco de dados inexistente");

               echo "<select name=\"classe_cep\">";
               $sql3 = "SELECT codigo,descricao FROM classe_cep";
               $resulo = mysql_db_query($banco_d,$sql3,$con) or die ("Não foi possivel acessar o banco");
               while ( $linha = mysql_fetch_array($resulo)) {
                    $select = $classe_cep == $linha[0] ? "selected" : "";
                    echo "<option value=\"". $linha[0] . "\" $select>" . $linha[1] ."</option>";
               }
              ?>
              </select>
           </td>
		</tr>
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
           <?php $reentrega    =$_SESSION['reentrega_m'];?>
           <td><b>Para Reentrega : </b></td>
           <td><input name="reentrega" type="text" id="reentrega" value ="<?php echo "$reentrega";?>" size="3" maxlength="3">(Prrencher com'R')</td>
        </tr>
		<tr>
          <td><INPUT type=button value="Consulta HAWB"
               onClick="window.open('consulta_remessa_por_hawb_tela.php','janela_1',
               'scrollbars=yes,resizable=yes,width=800,height=400');">
          </td>
		  <td colspan="2">
		     <div align="right">
			   <input name="grava" type="submit" onclick="return validar()" value="Reincluir">
			 </div>
		  </td>
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

