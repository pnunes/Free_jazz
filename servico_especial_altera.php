<?php
  session_start();

//carrega variaveis com dados para acessar o banco de dados

  $base_d     =$_SESSION['base_d'];
  $banco_d    =$_SESSION['banco_d'];
  $usuario_d  =$_SESSION['usuario_d'];
  $senha_d    =$_SESSION['senha_d'];

  $empresa_m    =$_SESSION['empresa_m'];
  $matricula_m  =$_SESSION['matricula_m'];
  $depto_m      =$_SESSION['depto_m'];
  
  
  $programa='041';
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
  
  //função que pega e trata a opção feita no sistema
  
  function get_post_action($name)
   {
    $params = func_get_args();

    foreach ($params as $name) {
        if (isset($_POST[$name])) {
            return $name;
        }
    }
   }
   
   // Controle de decisões da rotina
   
    $resp_grava='';

    switch (get_post_action('grava','busca','mostra','envia')) {

      case 'envia':
           $v_mes_ano   =$_POST['mes_ano'];
           $_SESSION['mes_ano_m']   =$v_mes_ano;
      break;

      case 'mostra':
            $controle               =$_POST['controle'];
            $_SESSION['contro']     =$_POST['controle'];


            $resp_grava='';
            $con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
            $res = mysql_select_db($banco_d) or die ("Banco de dados inexistente");

            $coleta="SELECT controle,codi_cli,escritorio,tipo_servi,cod_barra,codigo_desti,
            nome_desti,cep_desti,rua_desti,numero_desti,bairro_desti,cidade_desti,
            estado_desti,date_format(dt_remessa,'%d/%m/%Y'),qtdade,n_remessa,comple_desti,
            valor,observacao
            FROM remessa WHERE controle ='$controle'";

            $query = mysql_db_query($banco_d,$coleta,$con) or die ("Não foi possivel acessar o banco");
            $total = mysql_num_rows($query);

            for($ic=0; $ic<$total; $ic++){
               $row = mysql_fetch_row($query);
               $controle           = $row[0];
               $cli_for            = $row[1];
               $escritorio         = $row[2];
               $tipo_servi         = $row[3];
               $cod_barra          = $row[4];
               $codigo_desti       = $row[5];
               $nome_desti         = $row[6];
               $cep_1              = $row[7];
               $rua                = $row[8];
               $numero             = $row[9];
               $bairro             = $row[10];
               $cidade             = $row[11];
               $estado_s           = $row[12];
               $dt_remessa         = $row[13];
               $qtdade             = $row[14];
               $v_n_remessa        = $row[15];
               $comple_desti       = $row[16];
               $valor              = $row[17];
               $observacao         = $row[18];
            }
            $_SESSION['v_remessa']   =$v_n_remessa;
      break;
      case 'busca':
           $cep             =$_POST['cep'];
           $cli_for         =$_POST['cli_for'];
           $escritorio      =$_POST['escritorio'];
           $nome_desti      =$_POST['nome_desti'];
           $codigo_desti    =$_POST['codigo_desti'];
           $dt_remessa      =$_POST['dt_remessa'];
           $tipo_servi      =$_POST['tipo_servi'];
           $qtdade          =$_POST['qtdade'];
           $cod_barra       =$_POST['cod_barra'];
           $valor           =$_POST['valor'];
           $observacao      =$_POST['observacao'];

           $_SESSION['cep']           =$cep;
           $_SESSION['cli_for ']      =$cli_for;
           $_SESSION['nome_desti']    =$nome_desti;
           $_SESSION['escritorio']    =$escritorio;
           $_SESSION['codigo_desti']  =$codigo_desti;
           $_SESSION['dt_remessa']    =$dt_remessa;
           $_SESSION['tipo_servi']    =$tipo_servi;
           $_SESSION['qtdade_c']      =$qtdade;
           $_SESSION['cd_barra']      =$cod_barra;
           $_SESSION['valor_c']       =$valor;
           $_SESSION['observacao_c']  =$observacao;

           pega_cep($cep);

           $cli_for         =$_SESSION['cli_for '];
           $escritorio      =$_SESSION['escritorio'];
           $v_n_remessa     =$_SESSION['v_remessa'];
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
           $cod_barra       =$_SESSION['cd_barra'];
           $valor           =$_SESSION['valor_c'];
           $observacao      =$_SESSION['observacao_c'];
      break;

      case 'grava':
        if (isset($_POST['cli_for'])) {
        $codi_cli        =$_POST['cli_for'];
        $escritorio      =$_POST['escritorio'];
        $tipo_servi      =$_POST['tipo_servi'];
        $cod_barra       =$_POST['cod_barra'];
        $codigo_desti    =$_POST['codigo_desti'];
        $nome_desti      =$_POST['nome_desti'];
        $cep_desti       =$_POST['cep'];
        $rua_desti       =$_POST['rua_desti'];
        $numero_desti    =$_POST['numero_desti'];
        $bairro_desti    =$_POST['bairro_desti'];
        $cidade_desti    =$_POST['cidade_desti'];
        $estado_desti    =$_POST['estado_desti'];
        $dt_remessa      =$_POST['dt_remessa'];
        $qtdade          =$_POST['qtdade'];
        $comple_desti    =$_POST['comple_desti'];
        $valor           =$_POST['valor'];
        $observacao      =$_POST['observacao'];

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

        $controle_c =$_SESSION['contro'];

        $con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
        $res = mysql_select_db($banco_d) or die ("Banco de dados inexistente");

        $alteracao = "UPDATE remessa SET codi_cli='$codi_cli',escritorio='$escritorio',
        tipo_servi='$tipo_servi',cod_barra='$cod_barra',codigo_desti='$codigo_desti',
        nome_desti='$nome_desti',cep_desti='$cep_desti',rua_desti='$rua_desti',
        numero_desti='$numero_desti',bairro_desti='$bairro_desti',cidade_desti='$cidade_desti',
        estado_desti='$estado_desti',dt_remessa='$v_dt_remessa',
        qtdade='$qtdade',comple_desti='$comple_desti',valor='$g_valor',observacao='$observacao'
        WHERE controle='$controle_c'";

        if (mysql_db_query($banco_d,$alteracao,$con)) {

           $resp_grava="Inclusão bem sucedida";

           unset($_SESSION['cli_for']);
           unset($_SESSION['codigo_desti']);
           $codigo_desti          ='';
           unset($_SESSION['nome_desti']);
           $nome_desti            ='';
           unset($_SESSION['cep']);
           $cep_1           ='';
           unset($_SESSION['escritorio']);
           $rua_desti             ='';
           $numero_desti          ='';
           unset($_SESSION['v_remessa']);
           $bairro_desti          ='';
           unset($_SESSION['dt_remessa']);
           $v_dt_remessa          ='';
           $cidade_desti          ='';
           unset($_SESSION['tipo_servi']);
           $estado_n        ='';
           unset($_SESSION['estado_sigla']);
           $estado_s        ='';
           unset($_SESSION['rua']);
           unset($_SESSION['bairro']);
           unset($_SESSION['cidade']);
           unset($_SESSION['estado_sigla']);
           unset($_SESSION['estado_nome']);
           unset($_SESSION['contro']);
           unset($_SESSION['qtdade_c']);
           $qtdade        ='';
           unset($_SESSION['valor_c']);
           $g_valor        ='';
           $valor          ='';
           unset($_SESSION['observacao_c']);
           $observacao        ='';
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

?>
<html>
  <title>servico_especial_altera.php</title>
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
         <p align="right"><font face="Arial" size="2" color="#FFFFFF"><b>Serviço Especial - Alteração</b></font></td>
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
   <table width="80%" heigth="300" align="center">
         <form name="cadastro" id="cadastro" action="servico_especial_altera.php" method="post">
           <tr>
              <td align="center"><b>Informe o mês:</b>(Exemplo: 082011)
              <input type="text" name="mes_ano" id="mes_ano" value ="<?php echo "$qtdade";?>" size="15" maxlength="15">
              <input name="envia" type="submit" value="Enviar"></center></td>
           </tr>
         </form>
         <form name="cadastro" id="cadastro" action="servico_especial_altera.php" method="post">
           <tr>
            <td>
              <?php
               $v_mes_ano   =$_SESSION['mes_ano_m'];
               
               echo "<center><Font size=\"2\" face=\"ARIAL\">Remessa..:</font>";

               mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
               mysql_select_db($banco_d) or die ("Banco de dados inexistente");

               $resultado = mysql_query ("SELECT controle,n_remessa,nome_desti,
               date_format(dt_remessa,'%d/%m/%Y'),codi_cli
               FROM remessa
               WHERE ((substr(n_remessa,9)='$v_mes_ano')
               AND (escritorio='$depto_m')
               AND (recebedor=''))");
               echo "<select name='controle' class='caixa' align=\"center\">\n";
               while($linha = mysql_fetch_row($resultado))  {
                  printf("<option value='$linha[0]'>$linha[0] - $linha[1] - $linha[2] - $linha[3] - $linha[4]</option>\n");
               }
              ?>
              <input name="mostra" type="submit" value="Mostra"></center>
            </td>
           </tr>
         </form>
   </table>
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
</script>

  <body leftmargin="10" topmargin="10" marginwidth="10" marginheight="10">
  <form name="cadastro" id="cadastro" action="servico_especial_altera.php" method="post" onSubmit="return limpa()">
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
           <td><b>Região/Escritório:</b></td>
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
			<td><?php echo "$v_n_remessa";?></td>
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
               FROM serv_ati
               ORDER BY descri_se");
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
           <td><input type="text" name="valor" class="campo" id="valor" value ="<?php echo "$valor";?>" size="8" maxlength="8" onchange="Formata(this,20,event,2)"></td>
		</tr>
        <tr>
           <td><b>Código Destino:</b></td>
           <td><input type="text" name="codigo_desti" class="campo" id="codigo_desti" value ="<?php echo "$codigo_desti";?>"></td>
		</tr>
		<tr>
			<td><b>Nome Destino:</b></td>
			<td><input type="text" name="nome_desti" value ="<?php echo "$nome_desti";?>" size="50" maxlength="50" id="nome_desti"></td>
		</tr>
		<tr>
           <td><b>CEP Destino:</b></td>
           <td><input name="cep" type="text" id="cep" value ="<?php echo "$cep_1";?>" size="9" maxlength="9"><input name="busca" type="submit" value="Busca Endereço"</td>
        </tr>
		<tr>
			<td><b>Rua Destino:</b></td>
			<td><input type="text" name="rua_desti" value ="<?php echo "$rua";?>" size="50" maxlength="50" id="rua_desti"></td>
		</tr>
		<tr>
			<td><b>Número Destino:</b></td>
			<td><input type="text" name="numero_desti" value ="<?php echo "$numero";?>"size="10" maxlength="10" id="numero_desti"></td>
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
           <td><input name="cod_barra" type="text" id="cod_barra" value ="<?php echo "$cod_barra";?>" size="50" maxlength="50"></td>
        </tr>
		<tr>
            <td><INPUT type=button value="Ver Remessa"
               onClick="window.open('mostra_cli_for_cadastrados.php','janela_1',
               'scrollbars=yes,resizable=yes,width=800,height=500');">
            </td>
			<td colspan="2">
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
