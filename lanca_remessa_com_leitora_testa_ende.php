<?php
  session_start();

   //carrega variaveis com dados para acessar o banco de dados

  $base_d     =$_SESSION['base_d'];
  $banco_d    =$_SESSION['banco_d'];
  $usuario_d  =$_SESSION['usuario_d'];
  $senha_d    =$_SESSION['senha_d'];

  $escritorio_m =$_SESSION['depto_m'];
  $matricula_m  =$_SESSION['matricula_m'];
  $programa='38';
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
   include ("pega_cep.php");
   $dt_remessa       = date('d/m/Y');
   $_SESSION['dt_remessa_m']   =$dt_remessa;
   
?>
<html>
  <title>lanca_remessa_com_leitora.php</title>
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

     <!--Formata valor -->
    function Limpar(valor, validos) {
        var result = "";
        var aux;
        for (var i=0; i < valor.length; i++) {
          aux = validos.indexOf(valor.substring(i, i+1));
          if (aux>=0) {
            result += aux;
          }
        }
        return result;
     }

     function Formata(campo,tammax,teclapres,decimal) {
        var tecla = teclapres.keyCode;
        vr = Limpar(campo.value,"0123456789");
        tam = vr.length;
        dec=decimal

        if (tam < tammax && tecla != 8){ tam = vr.length + 1 ; }

          if (tecla == 8 )
          { tam = tam - 1 ; }

          if ( tecla == 8 || tecla >= 48 && tecla <= 57 || tecla >= 96 && tecla <= 105 )
          {

          if ( tam <= dec )
          { campo.value = vr ; }

          if ( (tam > dec) && (tam <= 5) ){
          campo.value = vr.substr( 0, tam - 2 ) + "," + vr.substr( tam - dec, tam ) ; }
          if ( (tam >= 6) && (tam <= 8) ){
          campo.value = vr.substr( 0, tam - 5 ) + "." + vr.substr( tam - 5, 3 ) + "," + vr.substr( tam - dec, tam ) ;
          }
          if ( (tam >= 9) && (tam <= 11) ){
          campo.value = vr.substr( 0, tam - 8 ) + "." + vr.substr( tam - 8, 3 ) + "." + vr.substr( tam - 5, 3 ) + "," + vr.substr( tam - dec, tam ) ; }
          if ( (tam >= 12) && (tam <= 14) ){
          campo.value = vr.substr( 0, tam - 11 ) + "." + vr.substr( tam - 11, 3 ) + "." + vr.substr( tam - 8, 3 ) + "." + vr.substr( tam - 5, 3 ) + "," + vr.substr( tam - dec, tam ) ; }
          if ( (tam >= 15) && (tam <= 17) ){
          campo.value = vr.substr( 0, tam - 14 ) + "." + vr.substr( tam - 14, 3 ) + "." + vr.substr( tam - 11, 3 ) + "." + vr.substr( tam - 8, 3 ) + "." + vr.substr( tam - 5, 3 ) + "," + vr.substr( tam - 2, tam ) ;}
          }

     }
    <!-- FUN��O QUE VERIFICA SE CAMPOS FORAM PREENCHIDOS-->

        function validar() {
          var n_hawb = cadastro.n_hawb.value;
          var n_remessa = cadastro.n_remessa.value;
          var rua_desti = cadastro.rua_desti.value;
          var numero_desti = cadastro.numero_desti.value;
          var bairro_desti = cadastro.numero_desti.value;
          var cidade_desti = cadastro.numero_desti.value;
          if (n_hawb == "") {
             alert('O campo da HAWB n�o foi preenchido! Verifique.');
             cadastro.n_hawb.focus();
             return false;
          }
          if (n_remessa == "") {
             alert('O campo N�MERO DA REMESSA n�o foi preenchido! Verifique.');
             cadastro.n_remessa.focus();
             return false;
          }
          if (rua_desti == "") {
             alert('O campo RUA DO DESTINAT�RIO n�o foi preenchido! Verifique.');
             cadastro.rua_desti.focus();
             return false;
          }
          if (numero_desti == "") {
             alert('O campo N�MERO DO DESTINAT�RIO n�o foi preenchido! Verifique.');
             cadastro.numero_desti.focus();
             return false;
          }
          if (bairro_desti == "") {
             alert('O campo BAIRRO DO DESTINAT�RIO n�o foi preenchido! Verifique.');
             cadastro.bairro_desti.focus();
             return false;
          }
          if (cidade_desti == "") {
             alert('O campo CIDADE DO DESTINAT�RIO n�o foi preenchido! Verifique.');
             cadastro.cidade_desti.focus();
             return false;
          }
          if (cep == "") {
             alert('O campo CEP DO DESTINAT�RIO n�o foi preenchido! Verifique.');
             cadastro.cep.focus();
             return false;
          }
        }

    <!-- FUN��O QUE ATIVA CODIGO DE BARRAS-->
    
    function salva(campo){
       cadastro.submit()
    }

  <!-- FUN��O PROCURA DESTINO POR NOME-->
  $(document).ready(function(){
		$("#localiza").autocomplete("completar_teste.php", {
			width:800,
			selectFirst: false
		});
	});
	
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
        else {
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
         <p align="left"><font face="Arial" size="2" color="#FFFFFF"><b>Sistema de Gerenciamento da Log�stica de Encomendas</b></font></td>
       <td width="50%">
         <p align="right"><font face="Arial" size="2" color="#FFFFFF"><b>Lan�a Remessa Com Leitora</b></font></td>
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
             $tipo_servi                 =$_POST['tipo_servi'];
             $v_n_remessa                =$_POST['n_remessa'];
             $_SESSION['codi_barra_m']   =$codi_barra;
             
             //Verifica se o a HAWB j� foi lan�ada

             $con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conex�o");
             $res = mysql_select_db($banco_d) or die ("Banco de dados inexistente");

             $localiza = "SELECT cod_barra
             FROM remessa
             WHERE cod_barra='$codi_barra'";

             $query = mysql_db_query($banco_d,$localiza,$con) or die ("N�o foi possivel acessar o banco 1");
             $achou = mysql_num_rows($query);

             If ($achou > 0 ) {
                $codi_barra='';
                $tipo_servi   =$_SESSION['tipo_servi_m'];
                $v_n_remessa  =$_SESSION['v_n_remessa_m'];
                ?>
                 <script language="javascript"> window.location.href=("lanca_remessa_com_leitora.php")
                   alert('HAWB j� foi lan�ada.');
                 </script>
                <?php
             }
             else {
             
                 //Pega o codigo do destinat�rio e o numero da hawb

                if(strlen($codi_barra) == 26){
                   $codigo_desti          =Substr($codi_barra,0,8);
                   $codigo_desti          =intval($codigo_desti);
                   $n_hawb                =Substr($codi_barra,17,10);
                   $n_hawb                =intval($n_hawb);
                   $_SESSION['n_hawb_m']  =$n_hawb;
                   
                   //Pega os dados do destino a parir do c�digo identificado
                   $resp_grava='';
                   $con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conex�o");
                   $res = mysql_select_db($banco_d) or die ("Banco de dados inexistente");

                   $verifi="SELECT codigo_desti,nome_desti,cep_desti,rua_desti,numero_desti,
                   comple_desti,bairro_desti,cidade_desti,estado_desti,classe_cep
                   FROM destino WHERE codigo_desti='$codigo_desti'";
                   $query = mysql_db_query($banco_d,$verifi,$con) or die ("N�o foi possivel acessar o banco");
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
                   $_SESSION['comple_desti_m']    =$comple_desti;
                   $_SESSION['bairro_desti_m']    =$bairro_desti;
                   $_SESSION['cidade_desti_m']    =$cidade_desti;
                   $_SESSION['estado_desti_m']    =$estado_desti;
                   $_SESSION['classe_cep']        =$classe_cep;
                }
                /*$codi_cli        =$_SESSION['codi_cli_m'];
                $escritorio      =$_SESSION['escritorio_m'];
                $dt_remessa      =$_SESSION['dt_remessa_m'];

                $tipo_servi      =$_SESSION['tipo_servi_m'];*/
                $_SESSION['v_n_remessa_m']  =$v_n_remessa;
                $codi_barra                 =$_SESSION['codi_barra_m'];
                $n_hawb                     =$_SESSION['n_hawb_m'];
             }
        }
        $codi_cli        =$_SESSION['codi_cli_m'];
        $escritorio      =$_SESSION['escritorio_m'];
        $dt_remessa      =$_SESSION['dt_remessa_m'];
        $v_n_remessa     =$_SESSION['v_n_remessa_m'];
        //$tipo_servi      =$_SESSION['tipo_servi_m'];
        
    switch (get_post_action('grava','busca','localiza','ativa_ser','gera')) {

      case 'ativa_ser':
           $escritorio                       =$_POST['escritorio'];
           $dt_remessa                       =$_POST['dt_remessa'];
           $codi_cli                         =$_POST['codi_cli'];
           $tipo_servi                       =$_POST['tipo_servi'];
           
           //Guarda dados fixos na memoria
           $_SESSION['escritorio_m']   =$escritorio;
           $_SESSION['dt_remessa_m']   =$dt_remessa;
           $_SESSION['codi_cli_m']     =$codi_cli;
           $_SESSION['tipo_servi_m']   =$tipo_servi;
           
      break;
      
      case 'gera':
              //Gera o numero da remessa
              $tipo_servi                       =$_POST['tipo_servi'];
              
              $ultimo = "SELECT * FROM nu_reme_manu ORDER BY numero DESC LIMIT 1";

              $query = mysql_db_query($banco_d,$ultimo,$con) or die ("N�o foi possivel acessar o banco");
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

                 //Retira os tra�os da string

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
                 $dt_baixa              ='';
                 
                 //Recupera os dados fixos da mmoria
                 $escritorio               =$_SESSION['escritorio_m'];
                 $dt_remessa               =$_SESSION['dt_remessa_m'];
                 $codi_cli                 =$_SESSION['codi_cli_m'];
                 $_SESSION['tipo_servi_m'] =$tipo_servi;
      break;
      
      case 'localiza':
           $codi_barra                  =$_POST['cod_barra'];
           $tipo_servi                  =$_POST['tipo_servi'];
           $n_hawb                      =$_POST['n_hawb'];
           $nome_desti                  =$_POST['nome_desti'];
           $localiza                    =$_POST['localiza'];
           $codigo_desti                =$_POST['codigo_desti'];
           $qtdade                      =$_POST['qtdade'];
           $valor                       =$_POST['valor'];
           $_SESSION['valor_m']         =$valor;
           $_SESSION['nome_desti_m']    =$nome_desti;
           $v_localiza                  =trim($localiza);
           $_SESSION['n_hawb_m']        =$n_hawb;
           $v_n_remessa                 =$_POST['n_remessa'];
           $_SESSION['n_remessa_m']     =$v_n_remessa;
           $_SESSION['tipo_servi_m']    =$tipo_servi;

           $con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conex�o");
           $res = mysql_select_db($banco_d) or die ("Banco de dados inexistente");

           $locali="SELECT codigo_desti,nome_desti,cep_desti,rua_desti,numero_desti,
           comple_desti,bairro_desti,cidade_desti,estado_desti,classe_cep
           FROM destino WHERE trim(localiza)='$v_localiza'";
           $query = mysql_db_query($banco_d,$locali,$con) or die ("N�o foi possivel acessar o banco");
           $total = mysql_num_rows($query);
           if ($total==0) {
               ?>
                 <script language="javascript"> window.location.href=("lanca_remessa_com_leitora_testa_ende.php")
                   alert('Destino n�o localizado.');
                 </script>
                <?php
           }
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
           $n_hawb          =$_SESSION['n_hawb_m'];
           $v_n_remessa     =$_SESSION['v_n_remessa_m'];
           $codi_barra      =$_SESSION['codi_barra_m'];
           $v_n_remessa     =$_SESSION['n_remessa_m'];
          // $nome_desti      =$_SESSION['nome_desti_m'];
           //Se localizar os dados do destino grava na memoria
           
           $_SESSION['codigo_desti_m']    =$codigo_desti ;
           $_SESSION['nome_desti_m']      =$nome_desti;
           $_SESSION['cep']               =$cep ;
           $_SESSION['rua']               =$rua_desti;
           $_SESSION['bairro']            =$bairro_desti;
           $_SESSION['cidade']            =$cidade_desti ;
           $_SESSION['estado_sigla']      =$estado_desti;
           $_SESSION['classe_cep']        =$classe_cep;
      break;
      
      case 'busca':
           $cep                         =$_POST['cep'];
           $nome_desti                  =$_POST['nome_desti'];
           $codigo_desti                =$_POST['codigo_desti'];
           $qtdade                      =$_POST['qtdade'];
           $_SESSION['qtdade_m']        =$qtdade;
           $_SESSION['nome_desti_m']    =$nome_desti;
           $_SESSION['codigo_desti_m']  =$codigo_desti;
           //$codigo_desti    =$_SESSION['codigo_desti_m'];
           unset($_SESSION['rua_desti_m']);
           unset($_SESSION['comple_desti_m']);
           unset($_SESSION['bairro_desti_m']);
           unset($_SESSION['cidade_desti_m']);
           unset($_SESSION['estado_desti_m']);
           unset($_SESSION['cep']);
           unset($_SESSION['classe_cep']);
           
           pega_cep($cep);

           $escritorio      =$_SESSION['escritorio_m'];
           $dt_remessa      =$_SESSION['dt_remessa_m'];
           $codi_cli        =$_SESSION['codi_cli_m'];
           $tipo_servi      =$_SESSION['tipo_servi_m'];
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
           $classe_cep      =$_SESSION['classe_cep'];
           $valor           =$_SESSION['valor_m'];
      break;
      
      case 'grava':

           $codi_cli        =$_SESSION['codi_cli_m'];
           $v_n_remessa     =$_SESSION['v_n_remessa_m'];
           $escritorio      =$_SESSION['escritorio_m'];
           $tipo_servi      =$_SESSION['tipo_servi_m'];
           $codi_barra      =$_POST['cod_barra'];
           $codigo_desti    =$_POST['codigo_desti'];
           $qtdade          =$_POST['qtdade'];
           //$valor           =$_POST['valor'];
           $nome_desti      =$_POST['nome_desti'];
           $cep_desti       =$_POST['cep'];
           $rua_desti       =$_POST['rua_desti'];
           $numero_desti    =$_POST['numero_desti'];
           $comple_desti    =$_POST['comple_desti'];
           $bairro_desti    =$_POST['bairro_desti'];
           $cidade_desti    =$_POST['cidade_desti'];
           $estado_desti    =$_POST['estado_desti'];
           $dt_remessa      =$_SESSION['dt_remessa_m'];
           $comple_desti    =$_POST['comple_desti'];
           $n_hawb          =$_POST['n_hawb'];
           $classe_cep      =$_SESSION['classe_cep'];
           
          // $dt_baixa        =$_POST['dt_baixa'];
           
           //Atribui valor 1 a quantidade caso n�o tenha sido digitado outro valor
           
           if ($qtdade=='') {
               $qtdade=1;
           }
           
           //Pega valor do servi�o na tabela de pre�o
           
           if (($codi_cli<>'') and ($tipo_servi<>'') and ($classe_cep<>'')) {
              $pegava="SELECT valor FROM tabela_preco
              WHERE ((codi_cli='$codi_cli') AND (tipo_servi='$tipo_servi') AND (classe_cep='$classe_cep'))";
              $query_2 = mysql_db_query($banco_d,$pegava,$con) or die ("N�o foi possivel acessar o banco 2");
              $total = mysql_num_rows($query_2);

              for($ic=0; $ic<$total; $ic++){
                  $row = mysql_fetch_row($query_2);
                  $valor        = $row[0];
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
            }
           //mudando formato da data para gravar na tabela

           $dt_remessa  = explode("/",$dt_remessa);
           $v_dt_remessa = $dt_remessa[2]."-".$dt_remessa[1]."-".$dt_remessa[0];
           if ($dt_baixa<>'') {
              $dt_baixa  = explode("/",$dt_baixa);
              $v_dt_baixa = $dt_baixa[2]."-".$dt_baixa[1]."-".$dt_baixa[0];
           }
           else {
              $v_dt_baixa='0000-00-00';
           }
           
           //$c_remessa            =Substr($n_remessa,0,6);
           if ($n_hawb<>'') {
              $con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conex�o");
              $res = mysql_select_db($banco_d) or die ("Banco de dados inexistente");

              //Verifica se o a HAWB j� foi lan�ada

             $localiza = "SELECT n_hawb
             FROM remessa
             WHERE n_hawb='$n_hawb'";

             $query = mysql_db_query($banco_d,$localiza,$con) or die ("N�o foi possivel acessar o banco 1");
             $achou = mysql_num_rows($query);

             If ($achou > 0 ) {
                unset($_SESSION['n_hawb_m']);
                $n_hawb='';
                unset($_SESSION['codigo_desti_m']);
                $codigo_desti          ='';
                unset($_SESSION['nome_desti_m']);
                $nome_desti            ='';
                $tipo_servi   =$_SESSION['tipo_servi_m'];
                $v_n_remessa  =$_SESSION['v_n_remessa_m'];
                ?>
                 <script language="javascript"> window.location.href=("lanca_remessa_com_leitora.php")
                   alert('HAWB j� foi lan�ada.');
                 </script>
                <?php
             }
             else {
                 $inclusao = "INSERT INTO remessa(codi_cli,n_remessa,escritorio,tipo_servi,cod_barra,codigo_desti,
                 nome_desti,cep_desti,rua_desti,numero_desti,bairro_desti,cidade_desti,
                 estado_desti,dt_remessa,qtdade,comple_desti,n_hawb,classe_cep,valor)
                 values('$codi_cli','$v_n_remessa','$escritorio','$tipo_servi','$codi_barra','$codigo_desti',
                 '$nome_desti','$cep_desti','$rua_desti','$numero_desti','$bairro_desti','$cidade_desti',
                 '$estado_desti','$v_dt_remessa','$qtdade','$comple_desti','$n_hawb','$classe_cep','$valor')";

                 if (mysql_db_query($banco_d,$inclusao,$con)) {
                    //Atualiza a tabela de controle de numero de remessas

                    $n_remes=   $_SESSION['n_reme'];

                    $con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conex�o");
                    $res = mysql_select_db($banco_d) or die ("Banco de dados inexistente");

                    $verifi="SELECT numero FROM nu_reme_manu WHERE numero='$n_remes'";
                    $query = mysql_db_query($banco_d,$verifi,$con) or die ("N�o foi possivel acessar o banco_2");
                    $achou = mysql_num_rows($query);

                    If ($achou == 0 ) {
                        $atualiza = "INSERT INTO nu_reme_manu(numero,dt_remessa)
                        values('$n_remes','$v_dt_remessa')";

                         mysql_db_query($banco_d,$atualiza,$con);
                    }
                    $resp_grava="Inclus�o bem sucedida";

                    //Atualiza a tabela de destinos
                    $con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conex�o");
                    $res = mysql_select_db($banco_d) or die ("Banco de dados inexistente");

                    $consulta="SELECT codigo_desti FROM destino WHERE codigo_desti='$codigo_desti'";
                    $query = mysql_db_query($banco_d,$consulta,$con) or die ("N�o foi possivel acessar o banco 3");
                    $achou = mysql_num_rows($query);
                    If ($achou == 0 ) {
                       $inclusao = "INSERT INTO destino(codigo_desti,nome_desti,cep_desti,
                       rua_desti,numero_desti,bairro_desti,cidade_desti,
                       estado_desti,dt_atu_cada,comple_desti,classe_cep)
                       values('$codigo_desti','$nome_desti','$cep_desti','$rua_desti',
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
                    $dt_remessa            =$_SESSION['dt_remessa_m'];
                    $codi_cli              =$_SESSION['codi_cli_m'];
                    $escritorio            =$_SESSION['escritorio_m'];
                    $v_n_remessa           =$_SESSION['v_n_remessa_m'];
                    $tipo_servi            =$_SESSION['tipo_servi_m'];
                    unset($_SESSION['codi_barra_m']);
                    $codi_barra            ='';
                    $comple_desti          ='';
                    unset($_SESSION['n_hawb_m']);
                    $n_hawb                ='';
                    unset($_SESSION['qtdade_m']);
                    $qtdade                ='';
                    //$dt_baixa              ='';
                    unset($_SESSION['classe_cep']);
                    $valor                 ='';

                 }
                 else {
                    $resp_grava="Problemas na Inclus�o";
                 }
             }
           }
           break;
           default:
    }
      //Preenche os campos j� com os valores digitados
     ?>
     <form method="POST" name="cadastro" action="lanca_remessa_com_leitora_testa_ende.php" border="20" align="center">
         <table width="70%" border="1" cellpadding="5" cellspacing="0" bordercolor="#4169E1">
		<tr>
           <td><b>Escrit�rio :</b></td>
           <td>
              <?php
               $adm_m        =$_SESSION['adm_m'];
               if ($adm_m=='N') {
                   $escritorio    =$_SESSION['depto_m'];
                   ?>
                   <select name="escritorio">
                   <?php
                    $sql1 = "SELECT codigo,nome FROM regi_dep WHERE codigo='$escritorio'";
                    $resula = mysql_db_query($banco_d,$sql1,$con) or die ("N�o foi possivel acessar o banco");
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
                    $resula = mysql_db_query($banco_d,$sql1,$con) or die ("N�o foi possivel acessar o banco");
                    while ( $linha = mysql_fetch_array($resula)) {
                        $select = $escritorio == $linha[0] ? "selected" : "";
                        echo "<option value=\"". $linha[0] . "\" $select>" . $linha[1] . "</option>";
                    }
               }
               mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conex�o");
               mysql_select_db($banco_d) or die ("Banco de dados inexistente");

               ?>

              ?>
              </select>
            </td>
		</tr>
		<tr>
          <?php $dt_remessa    =$_SESSION['dt_remessa_m'];?>
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
               mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conex�o");
               mysql_select_db($banco_d) or die ("Banco de dados inexistente");
               ?>
               <select name="codi_cli">
              <?php
                $sql2 = "SELECT cnpj_cpf,nome FROM cli_for";
                $resul = mysql_db_query($banco_d,$sql2,$con) or die ("N�o foi possivel acessar o banco");
                while ( $linha = mysql_fetch_array($resul)) {
                    $select = $codi_cli == $linha[0] ? "selected" : "";
                    echo "<option value=\"". $linha[0] . "\" $select>" . $linha[1] . "</option>";
               }
              ?>
            </select>
            </td>
		</tr>
		<tr>
           <td><b>Servi�o :</b></td>
           <td>
              <?php
               $tipo_servi      =$_SESSION['tipo_servi_m'];
               mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conex�o");
               mysql_select_db($banco_d) or die ("Banco de dados inexistente");

               ?>
               <select name="tipo_servi">
               <?php
                $sql3 = "SELECT codigo_se,descri_se FROM serv_ati";
                $resulo = mysql_db_query($banco_d,$sql3,$con) or die ("N�o foi possivel acessar o banco");
                while ( $linha = mysql_fetch_array($resulo)) {
                    $select = $tipo_servi == $linha[0] ? "selected" : "";
                    echo "<option value=\"". $linha[0] . "\" $select>" . $linha[1] . "</option>";
               }
              ?>
              </select>
             <input name="ativa_ser" type="submit" value="Ativa Servi�os">
            </td>
		</tr>
		<tr>
             <?php $v_n_remessa    =$_SESSION['n_remessa_m'];?>
			<td><b>N�mero da Remessa:</b></td>
			<td><input type="text" name="n_remessa" value ="<?php echo "$v_n_remessa";?>" size="17" maxlength="17" id="n_remessa"><input name="gera" type="submit" value="Gera N�mero Remessa"></td>
		</tr>
     <!--</form>-->
   </table>
  <body leftmargin="10" topmargin="10" marginwidth="10" marginheight="10">
  <!--<form name="cadastro_1" action="lanca_remessa_com_leitora.php" method="post">-->
	<table width="70%" border="1" cellpadding="5" cellspacing="0" bordercolor="#4169E1">
        <tr>
           <td><b>Codigo Barras :</b></td>
           <td><input type="text" name="cod_barra" id="cod_barra" value ="<?php echo "$codi_barra";?>" size="60" maxlength="60" onChange="salva(this)"></td>
        </tr>
         <!-- Coloca foco no primeiro campo codigo de barras do formul�rio -->
          <script language="JavaScript">
            document.getElementById('cod_barra').focus()
          </script>
        <tr>
           <?php $n_hawb    =$_SESSION['n_hawb_m'];?>
           <td><b>N�mero da HAWB :</b></td>
           <td><input type="text" name="n_hawb" id="n_hawb" value ="<?php echo "$n_hawb";?>" size="14" maxlength="14"></td>
		</tr>
		<tr>
           <?php $qtdade    =$_SESSION['qtdade_m'];?>
           <td><b>Qtdade Servi�o :</b></td>
           <td><input name="qtdade" type="text" id="qtdade" value ="<?php echo "$qtdade";?>" size="6" maxlength="6"></td>
        </tr>
        <!--<tr>
			<td><b>Valor :</b></td>
			<td><input name="valor" type="text" size="20" maxlength="20" onKeydown="Formata(this,20,event,2)"></td>
		</tr>-->
		<tr>
			<td><b>Localizador de Destino :</b></td>
			<br />
			<td><input type="text" name="localiza" id="localiza" size="200" maxlength="80" class="input_forms"/><input name="localiza" type="submit" value="Busca Dados Destino"></td>
	    </tr>
        <tr>
            <?php $nome_desti    =$_SESSION['nome_desti_m'];?>
			<td><b>Nome Destino :</b></td>
			<br />
			<td><input type="text" name="nome_desti" id="nome_desti" value ="<?php echo "$nome_desti";?>" size="50" maxlength="50"></td>
	    </tr>
		<tr>
           <?php $codigo_desti    =$_SESSION['codigo_desti_m'];?>
           <td><b>C�digo Destino :</b></td>
           <td><input type="text" name="codigo_desti" id="codigo_desti" value ="<?php echo "$codigo_desti";?>" size="14" maxlength="14"></td>
		</tr>
		<tr>
           <td><b>CEP Destino(Sem Separador) :</b></td>
           <td><input name="cep" type="text" id="cep" value ="<?php echo "$cep";?>" size="10" maxlength="10"><input name="busca" type="submit" value="Busca Endere�o"></td>
        </tr>
        <!--<tr>
		  <td><b>Classe CEP :</b></td>
           <td>-->
			  <?php
              /* $classe_cep    =$_SESSION['classe_cep'];
               mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conex�o");
               mysql_select_db($banco_d) or die ("Banco de dados inexistente");

               echo "<select name=\"classe_cep\">";
               $sql3 = "SELECT codigo,descricao FROM classe_cep";
               $resulo = mysql_db_query($banco_d,$sql3,$con) or die ("N�o foi possivel acessar o banco");
               while ( $linha = mysql_fetch_array($resulo)) {
                    $select = $classe_cep == $linha[0] ? "selected" : "";
                    echo "<option value=\"". $linha[0] . "\" $select>" . $linha[1] ."</option>";
               } */
              ?>
              <!--</select>
           </td>
		</tr>-->
		<tr>
			<td><b>Rua Destino :</b></td>
			<td><input type="text" name="rua_desti" value ="<?php echo "$rua_desti";?>" size="50" maxlength="50" id="rua_desti"></td>
		</tr>
		<tr>
			<td><b>N�mero Destino :</b></td>
			<td><input type="text" name="numero_desti" value ="<?php echo "$numero_desti";?>" size="10" maxlength="10" id="numero_desti"></td>
		</tr>
		<tr>
			<td><b>Complemento :</b></td>
			<td><input type="text" name="comple_desti" value ="<?php echo "$comple_desti";?>"size="30" maxlength="30" id="comple_desti"></td>
		</tr>
		<tr>
			<td><b>Bairro Destino :</b></td>
			<td><input type="text" name="bairro_desti" value ="<?php echo "$bairro_desti";?>" size="40" maxlength="40" id="bairro_desti"></td>
		</tr>
		<tr>
			<td><b>Cidade Destino :</b></td>
			<td><input type="text" name="cidade_desti" value ="<?php echo "$cidade_desti";?>" size="40" maxlength="40" id="cidade_desti"></td>
		</tr>
        <tr>
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

