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
  
  
  $programa='036';
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
   
   $mes_ano   =Substr(date("d-m-Y"),3,7);
   $v_mes_ano  =str_replace('-','',$mes_ano);
   $v_mes_ano  =rtrim($v_mes_ano);

?>
<html>
  <title>Remessa_manual_exclui.php</title>
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
         <p align="right"><font face="Arial" size="2" color="#FFFFFF"><b>Remessa Manual - Alteração</b></font></td>
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
     <tr>
       <td>
         <form method="POST" action="remessa_manual_exclui.php" border="20">
            <?php
               //echo "Depto :$depto_m";
               //echo "Mesano :$v_mes_ano";
               echo "<center><Font size=\"2\" face=\"ARIAL\">Remessa..:</font>";

               mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
               mysql_select_db($banco_d) or die ("Banco de dados inexistente");

               $resultado = mysql_query ("SELECT controle,n_remessa,nome_desti,dt_remessa,codi_cli
               FROM remessa
               WHERE ((substr(n_remessa,9)='$v_mes_ano')
               AND (escritorio='$depto_m')
               AND (recebedor=''))");
               echo "<select name='controle' class='caixa' align=\"center\">\n";
               while($linha = mysql_fetch_row($resultado))  {
                  printf("<option value='$linha[0]'>$linha[0] - $linha[1] - $linha[2] - $linha[3] - $linha[4] </option>\n");
               }
            ?>
              <input name="mostra" type="submit" value="Mostra"></center>
            </td>
           </tr>
         </form>
   </table>
  <?php
    $resp_grava='';
    
    switch (get_post_action('exclui','mostra')) {
      case 'mostra':
            $controle                =$_POST['controle'];
            $_SESSION['n_controle']  =$_POST['controle'];
            
            
            $resp_grava='';
            $con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
            $res = mysql_select_db($banco_d) or die ("Banco de dados inexistente");

            $coleta="SELECT codi_cli,escritorio,tipo_servi,cod_barra,codigo_desti,
            nome_desti,cep_desti,rua_desti,numero_desti,bairro_desti,cidade_desti,
            estado_desti,date_format(dt_remessa,'%d/%m/%Y'),n_remessa,comple_desti
            FROM remessa
            WHERE controle ='$controle'";
            
            $query = mysql_db_query($banco_d,$coleta,$con) or die ("Não foi possivel acessar o banco");
            $total = mysql_num_rows($query);

            for($ic=0; $ic<$total; $ic++){
               $row = mysql_fetch_row($query);
               $cli_for            = $row[0];
               $escritorio         = $row[1];
               $tipo_servi         = $row[2];
               $cod_barra          = $row[3];
               $codigo_desti       = $row[4];
               $nome_desti         = $row[5];
               $cep_1              = $row[6];
               $rua                = $row[7];
               $numero             = $row[8];
               $bairro             = $row[9];
               $cidade             = $row[10];
               $estado_s           = $row[11];
               $dt_remessa         = $row[12];
               $n_remessa          = $row[13];
               $comple_desti       = $row[14];
            }
      break;

      case 'exclui':

        $controle    =$_SESSION['n_controle'];
        
        $con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
        $res = mysql_select_db($banco_d) or die ("Banco de dados inexistente");

        $alteracao = "DELETE FROM remessa WHERE controle='$controle'";

        if (mysql_db_query($banco_d,$alteracao,$con)) {
        
           $resp_grava="Exclusão bem sucedida";
           
           $cli_for            = '';
           $escritorio         = '';
           $tipo_servi         = '';
           $cod_barra          = '';
           $codigo_desti       = '';
           $nome_desti         = '';
           $cep_1              = '';
           $rua                = '';
           $numero             = '';
           $bairro             = '';
           $cidade             = '';
           $estado_s           = '';
           $dt_remessa         = '';
           $comple_desti       = '';
        }
        else {
           $resp_grava="Problemas na Exclusão";
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
</script>

  <body leftmargin="10" topmargin="10" marginwidth="10" marginheight="10">
  <form name="cadastro" id="cadastro" action="remessa_manual_exclui.php" method="post" onSubmit="return limpa()">
	<table width="50%" border="1" cellpadding="5" cellspacing="0" bordercolor="#4169E1">
        <tr>
           <td><b>Responsável Remessa:</b></td>
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
			<td><?php echo "$n_remessa";?></td>
		</tr>
		<tr>
          <td><b>Data Remessa</b> :</b></td>
          <td><?php echo "$dt_remessa";?></td>
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
           <td><b>Código Destino:</b></td>
           <td><?php echo "$codigo_desti";?></td>
		</tr>
		<tr>
			<td><b>Nome Destino:</b></td>
			<td><?php echo "$nome_desti";?></td>
		</tr>
		<tr>
           <td><b>CEP Destino:</b></td>
           <td><?php echo "$cep_1";?></td>
        </tr>
		<tr>
			<td><b>Rua Destino:</b></td>
			<td><?php echo "$rua";?></td>
		</tr>
		<tr>
			<td><b>Número Destino:</b></td>
			<td><?php echo "$numero";?></td>
		</tr>
		<tr>
			<td><b>Complemento:</b></td>
			<td><?php echo "$comple_desti";?></td>
		</tr>
		<tr>
			<td><b>Bairro Destino:</b></td>
			<td><?php echo "$bairro";?></td>
		</tr>
		<tr>
			<td><b>Cidade Destino:</b></td>
			<td><?php echo "$cidade";?></td>
		</tr>
        <tr>
           <td><b>Estado Destino: </b></td>
           <td><?php echo "$estado_s";?></td>
        </tr>
        <tr>
           <td><b>Codigo de Barra: </b></td>
           <td><?php echo "$cod_barra";?></td>
        </tr>
		<tr>
            <td><INPUT type=button value="Ver Remessa"
               onClick="window.open('mostra_cli_for_cadastrados.php','janela_1',
               'scrollbars=yes,resizable=yes,width=800,height=500');">
            </td>
			<td colspan="2">
				<div align="right">
				<input name="exclui" type="submit" value="Excluir">
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
