<?php
  session_start();

//carrega variaveis com dados para acessar o banco de dados

  $base_d     =$_SESSION['base_d'];
  $banco_d    =$_SESSION['banco_d'];
  $usuario_d  =$_SESSION['usuario_d'];
  $senha_d    =$_SESSION['senha_d'];

  $matricula_m  =$_SESSION['matricula_m'];
  $programa='040';
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
  include ("pega_cep.php");
  
  function get_post_action($name)
   {
    $params = func_get_args();

    foreach ($params as $name) {
        if (isset($_POST[$name])) {
            return $name;
        }
    }
   }
?>
<html>
  <title>servico_especial_inclui.php</title>
  <head>
  </head>
  <body>
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
         <p align="right"><font face="Arial" size="2" color="#FFFFFF"><b>Serviço Especial - Lançamento</b></font></td>
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
  <?php
    $resp_grava='';
    
    //Pega o número da última remessa gerada emitida
    switch (get_post_action('grava','busca','nova')) {
      case 'nova':
      
           unset($_SESSION['cli_for ']);
           unset($_SESSION['escritorio']);
           unset($_SESSION['v_n_remessa']);
           unset($_SESSION['codigo_desti']);
           unset($_SESSION['dt_remessa']);
           unset($_SESSION['tipo_servi']);
           
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

      break;

      case 'busca':
           $cep             =$_POST['cep'];
           $cli_for         =$_POST['cli_for'];
           $escritorio      =$_POST['escritorio'];
           $nome_desti      =$_POST['nome_desti'];
           $v_n_remessa     =$_POST['n_remessa'];
           $codigo_desti    =$_POST['codigo_desti'];
           $dt_remessa      =$_POST['dt_remessa'];
           $tipo_servi      =$_POST['tipo_servi'];
           $qtdade          =$_POST['qtdade'];
           $valor           =$_POST['valor'];

           $_SESSION['cep']           =$cep;
           $_SESSION['cli_for ']      =$cli_for;
           $_SESSION['nome_desti']    =$nome_desti;
           $_SESSION['escritorio']    =$escritorio;
           $_SESSION['v_n_remessa']   =$v_n_remessa;
           $_SESSION['codigo_desti']  =$codigo_desti;
           $_SESSION['dt_remessa']    =$dt_remessa;
           $_SESSION['tipo_servi']    =$tipo_servi;
           $_SESSION['qtdade_c']      =$qtdade;
           $_SESSION['valor_c']       =$valor;
           
           pega_cep($cep);
           
           $cli_for         =$_SESSION['cli_for '];
           $escritorio      =$_SESSION['escritorio'];
           $v_n_remessa     =$_SESSION['v_n_remessa'];
           $nome_desti      =$_SESSION['nome_desti'];
           $codigo_desti    =$_SESSION['codigo_desti'];
           $tipo_servi      =$_SESSION['tipo_servi'];
           $dt_remessa      =$_SESSION['dt_remessa'];
           $cep_1           =$_SESSION['cep'];
           $rua             =$_SESSION['rua'];
           $bairro          =$_SESSION['bairro'];
           $cidade          =$_SESSION['cidade'];
           $estado_s        =$_SESSION['estado_sigla'];
           $estado_n        =$_SESSION['estado_nome'];
           $qtdade          =$_SESSION['qtdade_c'];
           $valor           =$_SESSION['valor_c'];

      break;

      case 'grava':
        if (isset($_POST['cli_for'])) {
        $codi_cli        =$_POST['cli_for'];
        $n_remessa       =$_POST['n_remessa'];
        $escritorio      =$_POST['escritorio'];
        $tipo_servi      =$_POST['tipo_servi'];
        $cod_barra       =$_POST['cod_barra'];
        $codigo_desti    =$_POST['destino'];
        $cep_desti       =$_POST['cep'];
        $rua_desti       =$_POST['rua_desti'];
        $numero_desti    =$_POST['numero_desti'];
        $comple_desti    =$_POST['comple_desti'];
        $bairro_desti    =$_POST['bairro_desti'];
        $cidade_desti    =$_POST['cidade_desti'];
        $estado_desti    =$_POST['estado_desti'];
        $dt_remessa      =$_POST['dt_remessa'];
        $qtdade          =$_POST['qtdade'];
        $comple_desti    =$_POST['comple_desti'];
        $valor           =$_POST['valor'];
        $observacao      =$_POST['observacao'];
        
        If ($qtdade=='') {
            $qtdade=1;
        }
        
        $resultado = mysql_query ("SELECT nome_desti
        FROM destino
        WHERE codigo_desti='$codigo_desti'");
        $total = mysql_num_rows($resultado);

        for($i=0; $i<$total; $i++){
            $dados = mysql_fetch_row($resultado);
            $nome_desti      =$dados[0];
        }
        
        //Altera formato de valor para gravar no banco
        if (strlen($valor)>=6) {
            $g_valor         = str_replace(".", "", $g_valor);
            $g_valor         = str_replace(",", ".", $g_valor);
        }
        if (strlen($valor)<6) {
            $g_valor         = str_replace(",", ".", $g_valor);
        }
        
        
        //mudando formato da data para gravar na tabela

        $dt_remessa  = explode("/",$dt_remessa);
        $v_dt_remessa = $dt_remessa[2]."-".$dt_remessa[1]."-".$dt_remessa[0];

        $c_remessa            =Substr($n_remessa,0,6);

        $con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
        $res = mysql_select_db($banco_d) or die ("Banco de dados inexistente");

        $inclusao = "INSERT INTO remessa(codi_cli,n_remessa,escritorio,tipo_servi,cod_barra,codigo_desti,
        nome_desti,cep_desti,rua_desti,numero_desti,bairro_desti,cidade_desti,
        estado_desti,dt_remessa,qtdade,comple_desti,valor,observacao)
        values('$codi_cli','$n_remessa','$escritorio','$tipo_servi','$cod_barra','$codigo_desti',
        '$nome_desti','$cep_desti','$rua_desti','$numero_desti','$bairro_desti','$cidade_desti',
        '$estado_desti','$v_dt_remessa','$qtdade','$comple_desti','$g_valor','$observacao')";

        if (mysql_db_query($banco_d,$inclusao,$con)) {
        
           $resp_grava="Inclusão bem sucedida";
           
           //Atualiza a tabela de controle de numero de remessas
           
           $n_remes=   $_SESSION['n_reme'];
           
           $con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
           $res = mysql_select_db($banco_d) or die ("Banco de dados inexistente");

           $verifi="SELECT numero FROM nu_reme_manu WHERE numero='$n_remes'";
           $query = mysql_db_query($banco_d,$verifi,$con) or die ("Não foi possivel acessar o banco");
           $achou = mysql_num_rows($query);

           If ($achou == 0 ) {
              $atualiza = "INSERT INTO nu_reme_manu(numero,dt_remessa)
              values('$n_remes','$v_dt_remessa')";

              mysql_db_query($banco_d,$atualiza,$con);
           }

           unset($_SESSION['codigo_desti']);
           $codigo_desti          ='';
           unset($_SESSION['nome_desti']);
           $nome_desti            ='';
           unset($_SESSION['cep_desti']);
           $cep_1           ='';
           unset($_SESSION['rua_desti']);
           $rua_desti             ='';
           $numero_desti          ='';
           $colple_desti          ='';
           unset($_SESSION['bairro_desti']);
           $bairro_desti          ='';
           unset($_SESSION['cidade_desti']);
           $cidade_desti          ='';
           unset($_SESSION['estado_nome']);
           $estado_n        ='';
           unset($_SESSION['estado_sigla']);
           $estado_s        ='';
           $dt_remessa      =$_SESSION['dt_remessa'];
           $cli_for         =$_SESSION['cli_for '];
           $escritorio      =$_SESSION['escritorio'];
           $v_n_remessa     =$_SESSION['v_n_remessa'];
           unset($_SESSION['qtdade_c']);
           $valor               ='';
           $qtdade              ='';
           $observacao          ='';
           $cod_barra           ='';
        }
        else {
           $resp_grava="Problemas na Inclusão";
        }
          mysql_close ($con);
        }
       break;
       default:
    }
  ?>
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
  <script LANGUAGE="Javascript">

     function aplica_mascara_cpfcnpj(campo,tammax,teclapres) {
        var tecla = teclapres.keyCode;

        if ((tecla < 48 || tecla > 57) && (tecla < 96 || tecla > 105) && tecla != 46 && tecla != 8) {
                return false;
        }

        var vr = campo.value;
        vr = vr.replace( /\//g, "" );
        vr = vr.replace( /-/g, "" );
        vr = vr.replace( /\./g, "" );
        var tam = vr.length;

        if ( tam <= 2 ) {
                campo.value = vr;
        }
        if ( (tam > 2) && (tam <= 5) ) {
                campo.value = vr.substr( 0, tam - 2 ) + '-' + vr.substr( tam - 2, tam );
        }
        if ( (tam >= 6) && (tam <= 8) ) {
                campo.value = vr.substr( 0, tam - 5 ) + '.' + vr.substr( tam - 5, 3 ) + '-' + vr.substr( tam - 2, tam );
        }
        if ( (tam >= 9) && (tam <= 11) ) {
                campo.value = vr.substr( 0, tam - 8 ) + '.' + vr.substr( tam - 8, 3 ) + '.' + vr.substr( tam - 5, 3 ) + '-' + vr.substr( tam - 2, tam );
        }
        if ( (tam == 12) ) {
                campo.value = vr.substr( tam - 12, 3 ) + '.' + vr.substr( tam - 9, 3 ) + '/' + vr.substr( tam - 6, 4 ) + '-' + vr.substr( tam - 2, tam );
        }
        if ( (tam > 12) && (tam <= 14) ) {
                campo.value = vr.substr( 0, tam - 12 ) + '.' + vr.substr( tam - 12, 3 ) + '.' + vr.substr( tam - 9, 3 ) + '/' + vr.substr( tam - 6, 4 ) + '-' + vr.substr( tam - 2, tam );
        }
     }

     function verifica_cpf_cnpj(cpf_cnpj) {
        if (cpf_cnpj.length == 11) {
                return(verifica_cpf(cpf_cnpj));
        } else if (cpf_cnpj.length == 14) {
                return(verifica_cnpj(cpf_cnpj));
        } else {
                return false;
        }
        return true;
     }


     function verifica_cpf(sequencia) {
        if ( Procura_Str(1,sequencia,'00000000000,11111111111,22222222222,33333333333,44444444444,55555555555,66666666666,77777777777,88888888888,99999999999,00000000191,19100000000') > 0 ) {
                return false;
        }
        seq = sequencia;
        soma = 0;
        multiplicador = 2;
        for (f = seq.length - 3;f >= 0;f--) {
                soma += seq.substring(f,f + 1) * multiplicador;
                multiplicador++;
        }
        resto = soma % 11;
        if (resto == 1 || resto == 0) {
                digito = 0;
        } else {
                digito = 11 - resto;
        }
        if (digito != seq.substring(seq.length - 2,seq.length - 1)) {
                return false;
        }
        soma = 0;
        multiplicador = 2;
        for (f = seq.length - 2;f >= 0;f--) {
                soma += seq.substring(f,f + 1) * multiplicador;
                multiplicador++;
        }
        resto = soma % 11;
        if (resto == 1 || resto == 0) {
                digito = 0;
        } else {
                digito = 11 - resto;
        }
        if (digito != seq.substring(seq.length - 1,seq.length)) {
                return false;
        }
        return true;
     }

     function verifica_cnpj(sequencia) {
        seq = sequencia;
        soma = 0;
        multiplicador = 2;
        for (f = seq.length - 3;f >= 0;f-- ) {
                soma += seq.substring(f,f + 1) * multiplicador;
                if ( multiplicador < 9 ) {
                        multiplicador++;
                } else {
                        multiplicador = 2;
                }
        }
        resto = soma % 11;
        if (resto == 1 || resto == 0) {
                digito = 0;
        } else {
                digito = 11 - resto;
        }
        if (digito != seq.substring(seq.length - 2,seq.length - 1)) {
                return false;
        }

        soma = 0;
        multiplicador = 2;
        for (f = seq.length - 2;f >= 0;f--) {
                soma += seq.substring(f,f + 1) * multiplicador;
                if (multiplicador < 9) {
                        multiplicador++;
                } else {
                        multiplicador = 2;
                }
        }
        resto = soma % 11;
        if (resto == 1 || resto == 0) {
                digito = 0;
        } else {
                digito = 11 - resto;
        }
        if (digito != seq.substring(seq.length - 1,seq.length)) {
                return false;
        }
        return true;
     }


     function Procura_Str(param0,param1,param2) {
        for (a = param0 - 1;a < param1.length;a++) {
                for (b = 1;b < param1.length;b++) {
                        if (param2 == param1.substring(b - 1,b + param2.length - 1)) {
                                return a;
                        }
                }
        }
        return 0;
     }


     function retira_mascara(cpf_cnpj) {

         return cpf_cnpj.replace(/\./g,'').replace(/-/g,'').replace(/\//g,'')
     }
     
     <!--desabilita a tecla CTRL + J - devido a leitora de codigo debarras -->
     
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

</script>

  <body onkeydown="desabilitaCtrlJ(event)" leftmargin="10" topmargin="10" marginwidth="10" marginheight="10">
  <form name="cadastro" id="cadastro" action="servico_especial_inclui.php" method="post" onSubmit="return limpa()">
	<table width="50%" border="1" cellpadding="5" cellspacing="0" bordercolor="#4169E1">
        <tr>
           <td><b>Cliente :</b></td>
           <td>
              <?php

               mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
               mysql_select_db($banco_d) or die ("Banco de dados inexistente");

               $resultado = mysql_query ("SELECT cnpj_cpf,nome
               FROM cli_for");
               echo "<select name='cli_for' class='caixa'>\n";
               while($linha = mysql_fetch_row($resultado))  {
                  printf("<option value='$linha[0]'>$linha[0] - $linha[1] </option>\n");
               }
              ?>
              <script language="javascript">
                 Seleciona = function( itemSelecionar){
                  var _cli_for = document.getElementById("cli_for");
                  for ( i =0; i < _cli_for.length; i++){
                    _cli_for[i].selected = _cli_for[i].value == itemSelecionar ? true : false;
                  }
                 }
                 Seleciona(<?php echo "$cli_for";?>);
             </script>
            </td>
		</tr>
		<tr>
           <td><b>Escritório :</b></td>
           <td>
              <?php

               mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
               mysql_select_db($banco_d) or die ("Banco de dados inexistente");

               $resultado = mysql_query ("SELECT codigo,nome
               FROM regi_dep");
               echo "<select name='escritorio' class='caixa'>\n";
               while($linha = mysql_fetch_row($resultado))  {
                  printf("<option value='$linha[0]'>$linha[0] - $linha[1] </option>\n");
               }
              ?>
              <script language="javascript">
                 Seleciona = function( itemSelecionar){
                  var _escritorio = document.getElementById("escritorio");
                  for ( i =0; i < _escritorio.length; i++){
                    _escritorio[i].selected = _escritorio[i].value == itemSelecionar ? true : false;
                  }
                 }
                 Seleciona(<?php echo "$escritorio";?>);
             </script>
            </td>
		</tr>
		<tr>
			<td><b>Número da Remessa:</b></td>
			<td><input type="text" name="n_remessa" value ="<?php echo "$v_n_remessa";?>" size="17" maxlength="17" id="n_remessa"><input name="nova" type="submit" value="Nova Remessa"></td></td>
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
           <td><b>Serviço :</b></td>
           <td>
              <?php

               mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
               mysql_select_db($banco_d) or die ("Banco de dados inexistente");

               $resultado = mysql_query ("SELECT codigo_se,descri_se
               FROM serv_ati");
               echo "<select name='tipo_servi' class='caixa'>\n";
               while($linha = mysql_fetch_row($resultado))  {
                  printf("<option value='$linha[0]'>$linha[0] - $linha[1] </option>\n");
               }
              ?>
              <script language="javascript">
                 Seleciona = function( itemSelecionar){
                  var _tipo_servi = document.getElementById("tipo_servi");
                  for ( i =0; i < _tipo_servi.length; i++){
                    _tipo_servi[i].selected = _tipo_servi[i].value == itemSelecionar ? true : false;
                  }
                 }
                 Seleciona(<?php echo "$tipo_servi";?>);
             </script>
            </td>
		</tr>
		<tr>
           <td><b>Quantidade :</b></td>
           <td><input type="text" name="qtdade" class="campo" id="qtdade" value ="<?php echo "$qtdade";?>" size="4" maxlength="4"></td>
		</tr>
		<tr>
           <td><b>Valor :</b></td>
           <td><input type="text" name="valor" class="campo" id="valor" value ="<?php echo "$valor";?>" size="8" maxlength="8" onKeydown="Formata(this,20,event,2)"></td>
		</tr>
        <tr>
           <td><b>Destino :</b></td>
           <td>
              <?php

               mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
               mysql_select_db($banco_d) or die ("Banco de dados inexistente");

               $resultado = mysql_query ("SELECT codigo_desti,nome_desti
               FROM destino
               ORDER BY nome_desti");
               echo "<select name='destino' class='caixa'>\n";
               while($linha = mysql_fetch_row($resultado))  {
                  printf("<option value='$linha[0]'>$linha[0] - $linha[1] </option>\n");
               }
              ?>
              <script language="javascript">
                 Seleciona = function( itemSelecionar){
                  var _destino = document.getElementById("destino");
                  for ( i =0; i < _destino.length; i++){
                    _destino[i].selected = _destino[i].value == itemSelecionar ? true : false;
                  }
                 }
                 Seleciona(<?php echo "$destino";?>);
             </script>
            </td>
		</tr>
		<tr>
           <td><b>CEP Destino:</b></td>
           <td><input name="cep" type="text" id="cep" value ="<?php echo "$cep_1";?>" size="9" maxlength="9"><input name="busca" type="submit" value="Busca Endereço"></td>
        </tr>
		<tr>
			<td><b>Rua Destino:</b></td>
			<td><input type="text" name="rua_desti" value ="<?php echo "$rua";?>" size="50" maxlength="50" id="rua_desti"></td>
		</tr>
		<tr>
			<td><b>Número Destino:</b></td>
			<td><input type="text" name="numero_desti" size="10" maxlength="10" id="numero_desti"></td>
		</tr>
		<tr>
			<td><b>Complemento:</b></td>
			<td><input type="text" name="comple_desti" value ="<?php echo "$comple_desti";?>"size="30" maxlength="30" id="comple_desti"></td>
		</tr>
		<tr>
			<td><b>Bairro Destino:</b></td>
			<td><input type="text" name="bairro_desti" value ="<?php echo "$bairro";?>" size="40" maxlength="40" id="bairro_desti"></td>
		</tr>
		<tr>
			<td><b>Cidade Destino:</b></td>
			<td><input type="text" name="cidade_desti" value ="<?php echo "$cidade";?>" size="40" maxlength="40" id="cidade_desti"></td>
		</tr>
        <tr>
           <td><b>Estado Destino: </b></td>
           <td><input name="estado_desti" type="text" id="estado_desti" value ="<?php echo "$estado_s";?>" size="2" maxlength="2"> - <?php echo "$estado_n";?></td>
        </tr>
        <tr>
			<td><b>Observação :</b></td>
			<td><input type="text" name="observacao" value ="<?php echo "$observacao";?>" size="100" maxlength="100" id="observacao"></td>
		</tr>
        <tr>
           <td><b>Codigo de Barra: </b></td>
           <td><input name="cod_barra" type="text" id="cod_barra" value ="<?php echo "$cod_barra";?>" size="44" maxlength="44" onkeydown="return retornoCodbar(event, this.value)"></td>
        </tr>
		<tr>
            <td>
				<div align="center">
				<input name="nova" type="submit" value="Nova Remessa">
				</div>
			</td>
			<td>
				<div align="right">
				<input name="grava" type="submit" value="Gravar">
				</div>
			</td>
		</tr>
	</table>
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
 </div>
</body>
</html>
