<?php
  session_start();

   //carrega variaveis com dados para acessar o banco de dados

  $base_d     =$_SESSION['base_d'];
  $banco_d    =$_SESSION['banco_d'];
  $usuario_d  =$_SESSION['usuario_d'];
  $senha_d    =$_SESSION['senha_d'];

  $matricula_m  =$_SESSION['matricula_m'];
  $programa='051';
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
   include ("pega_cep.php");
   include ("campo_calendario.php");
?>
<html>
  <title>Cadastro_ceps_cidades_altera.php</title>
  <head>
  <script type="text/javascript" src="jquery-autocomplete/lib/jquery.js"></script>
  <script type="text/javascript" src="jquery-autocomplete/lib/jquery.bgiframe.min.js"></script>
  <script type="text/javascript" src="jquery-autocomplete/lib/jquery.ajaxQueue.js"></script>
  <script type="text/javascript" src="jquery-autocomplete/lib/thickbox-compressed.js"></script>
  <script type="text/javascript" src="jquery-autocomplete/jquery.autocomplete.js"></script>
  <!--css -->
  <link rel="stylesheet" type="text/css" href="jquery-autocomplete/jquery.autocomplete.css"/>
  <link rel="stylesheet" type="text/css" href="jquery-autocomplete/lib/thickbox.css"/>
  <body>
  <script type="text/javascript">
    $(document).ready(function(){
		$("#nome_desti").autocomplete("completar.php", {
			width:350,
			selectFirst: false
		});
	});
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
         <p align="right"><font face="Arial" size="2" color="#FFFFFF"><b>Ceps Cidades - Alteração</b></font></td>
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
     switch (get_post_action('grava','localiza','busca')) {
         case 'localiza':
             $nome_desti                  =$_POST['nome_desti'];
             $v_nome_desti                =trim($nome_desti);
             $resp_grava='';
             $con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
             $res = mysql_select_db($banco_d) or die ("Banco de dados inexistente");

             $locali="SELECT codigo_desti,nome_desti,cep_desti,rua_desti,numero_desti,
             comple_desti,bairro_desti,cidade_desti,estado_desti,fone_desti,date_format(dt_atu_cada,'%d/%m/%Y')
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
               $fone_desti     = $mostra[9];
               $dt_atu_cada    = $mostra[10];
             }
               
               //Guarda chave de pesquisa na session
               $_SESSION['nome_desti_m']     =$nome_desti;
               $_SESSION['codigo_desti_m']   =$codigo_desti;
               $_SESSION['cidade_desti_m']   =$cidade_desti;
               $_SESSION['estado_desti_m']   =$estado_desti;
             break;

         case 'busca':
           $cep                          =$_POST['cep_desti'];
           $_SESSION['cep_desti_m']      =$cep;

           pega_cep($cep);

           $codigo_desti    =$_SESSION['codigo_desti_m'];
           $nome_desti      =$_SESSION['nome_desti_m'];
           $cidade_desti    =$_SESSION['cidade_desti_m'];
           $estado_desti    =$_SESSION['estado_desti_m'];
           $cep             =$_SESSION['cep'];
           $rua_desti       =$_SESSION['rua'];
           $bairro_desti    =$_SESSION['bairro'];
           $cidade_desti    =$_SESSION['cidade'];
           $estado_desti    =$_SESSION['estado_sigla'];
           $estado_n        =$_SESSION['estado_nome'];
           
           //Altera o formato doCNPJ CPF
         break;

         case 'grava':
             $codigo_desti    =$_SESSION['codigo_desti_m'];
             $nome_desti      =$_POST['nome_desti'];
             $rua_desti       =$_POST['rua_desti'];
             $numero_desti    =$_POST['numero_desti'];
             $bairro_desti    =$_POST['bairro_desti'];
             $cidade_desti    =$_POST['cidade_desti'];
             $estado_desti    =$_POST['estado_desti'];
             $cep             =$_POST['cep_desti'];
             $fone_desti      =$_POST['fone_desti'];
             $dt_atu_cada     =$_POST['dt_atu_cada'];

             //mudando formato da data para gravar na tabela
             $dt_atu_cada  = explode("/",$dt_atu_cada);
             $v_dt_atu_cada = $dt_atu_cada[2]."-".$dt_atu_cada[1]."-".$dt_atu_cada[0];

             $con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
             $res = mysql_select_db($banco_d) or die ("Banco de dados inexistente");

             $alteracao = "UPDATE destino SET nome_desti='$nome_desti',
             rua_desti='$rua_desti',numero_desti='$numero_desti',comple_desti='$comple_desti',
             bairro_desti='$bairro_desti',cidade_desti='$cidade_desti',
             estado_desti='$estado_desti',cep_desti='$cep',fone_desti='$fone_desti',
             dt_atu_cada='$v_dt_atu_cada'
             WHERE codigo_desti='$codigo_desti'";

             if (mysql_db_query($banco_d,$alteracao,$con)) {
                $resp_grava="Alteração bem sucedida";
                unset($_SESSION['codigo_desti']);
                $codigo_desti          ='';
                unset($_SESSION['nome_desti']);
                $nome_desti            ='';
                $cep                   ='';
                unset($_SESSION['rua']);
                $rua_desti             ='';
                unset($_SESSION['numero']);
                $numero_desti          ='';
                unset($_SESSION['bairro']);
                $bairro_desti          ='';
                unset($_SESSION['cidade']);
                $cidade_desti          ='';
                unset($_SESSION['estado_nome']);
                $estado_n              ='';
                unset($_SESSION['estado_sigla']);
                $estado_desti          ='';
                $fone_desti            ='';
                $v_dt_atu_cada         ='';
             }
             else {
                $resp_grava="Problemas na Alteração";
                ?>
                  <script language="JavaScript">document.cadastro.reset();</script>
                <?php
             }
            break;
         default:
     }
  ?>

  <body leftmargin="10" topmargin="10" marginwidth="10" marginheight="10">
  <form name="cadastro" action="cadastro_ceps_cidades_altera.php" method="post" onSubmit="return validaForm()">
	<table width="50%" border="1" cellpadding="5" cellspacing="0" bordercolor="#4169E1">
		<tr>
			<td><b>Nome :</b></td>
			<td><input type="text" name="nome_desti" value ="<?php echo "$nome_desti";?>" size="50" maxlength="50" id="nome_desti"class="input_forms"/><input name="localiza" type="submit" value="Busca Dados Destino"></td>
		</tr>
		<tr>
           <td><b>Codigo :</b></td>
           <td><input type="text" name="codigo_desti" class="campo" id="codigo_desti" value ="<?php echo "$codigo_desti";?>" size="14" maxlength="14"></td>
		</tr>
		<tr>
           <td><b>CEP:</b> </td>
           <td><input name="cep_desti" type="text" id="cep_desti" value ="<?php echo "$cep";?>" size="10" maxlength="10"><input name="busca" type="submit" value="Busca Endereço"</td>
        </tr>
		<tr>
			<td><b>Rua :</b></td>
			<td><input type="text" name="rua_desti" value ="<?php echo "$rua_desti";?>" size="40" maxlength="40" id="rua_desti"></td>
		</tr>
		<tr>
			<td><b>Número :</b></td>
			<td><input type="text" name="numero_desti" value ="<?php echo "$numero_desti";?>" size="10" maxlength="10" id="numero_desti"></td>
		</tr>
		<tr>
			<td><b>Bairro :</b></td>
			<td><input type="text" name="bairro_desti" value ="<?php echo "$bairro_desti";?>" size="40" maxlength="40" id="bairro_desti"></td>
		</tr>
		<tr>
			<td><b>Cidade :</b></td>
			<td><input type="text" name="cidade_desti" value ="<?php echo "$cidade_desti";?>" size="40" maxlength="40" id="cidade_desti"></td>
		</tr>
        <tr>
           <td><b>Estado :</b></td>
           <td><input name="estado_desti" type="text" id="estado_desti" value ="<?php echo "$estado_desti";?>" size="2" maxlength="2"> - <?php echo "$estado_n";?></td>
        </tr>
		<tr>
			<td><b>Telefones :</b></td>
			<td><input type="text" name="fone_desti" value ="<?php echo "$fone_desti";?>" size="40" maxlength="40" id="fone_desti"></td>
		</tr>
        <tr>
          <td><b>Data cadastro :</b></td>
          <td>
            <input type="text" name="dt_atu_cada" value ="<?php echo "$v_dt_atu_cada";?>"size="12" maxlength="12" id="dt_atu_cada">
            <input TYPE="button" NAME="btndt_atu_cada" VALUE="..." Onclick="javascript:popdate('document.cadastro.dt_atu_cada','pop1','150',document.cadastro.dt_atu_cada.value)">
            <span id="pop1" style="position:absolute"></span>
          </td>
        </tr>
		<tr>
            <td><INPUT type=button value="Destinos Cadastrados"
               onClick="window.open('mostra_destinos_cadastrados.php','janela_1',
               'scrollbars=yes,resizable=yes,width=800,height=500');">
            </td>
			<td colspan="2">
				<div align="right">
				<input name="grava" type="submit" value="Gravar">
				</div>
			</td>
		</tr>
	</table>
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

