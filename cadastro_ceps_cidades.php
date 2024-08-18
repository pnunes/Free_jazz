<?php
  session_start();

//carrega variaveis com dados para acessar o banco de dados

  $base_d     =$_SESSION['base_d'];
  $banco_d    =$_SESSION['banco_d'];
  $usuario_d  =$_SESSION['usuario_d'];
  $senha_d    =$_SESSION['senha_d'];

  $matricula_m  =$_SESSION['matricula_m'];
  $programa='050';
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
  <title>Cadastro_ceps_cidades.php</title>
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
         <p align="right"><font face="Arial" size="2" color="#FFFFFF"><b>Ceps Cidades - Inclusão</b></font></td>
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
    switch (get_post_action('grava','mostra')) {
      case 'mostra':
           $cep             =$_POST['cep'];
           $codigo_desti    =$_POST['codigo_desti'];
           $nome_desti      =$_POST['nome_desti'];

           $_SESSION['cep']            =$cep;
           $_SESSION['codigo_desti_m'] =$codigo_desti;
           $_SESSION['nome_desti_m']   =$nome_desti;

           pega_cep($cep);

           $cep             =$_SESSION['cep'];
           $nome_desti      =$_SESSION['nome'];
           $rua_desti       =$_SESSION['rua'];
           $bairro_desti    =$_SESSION['bairro'];
           $cidade_desti    =$_SESSION['cidade'];
           $estado_s        =$_SESSION['estado_sigla'];
           $estado_n        =$_SESSION['estado_nome'];
           $_SESSION['codigo_desti_m'] =$codigo_desti;
      break;

      case 'grava':
        if (isset($_POST['codigo_desti'])) {
        $codigo_desti    =$_POST['codigo_desti'];
        $nome_desti      =$_POST['nome_desti'];
        $rua_desti       =$_POST['rua_desti'];
        $numero_desti    =$_POST['numero_desti'];
        $bairro_desti    =$_POST['bairro_desti'];
        $cidade_desti    =$_POST['cidade_desti'];
        $uf_desti        =$_POST['estado_desti'];
        $cep             =$_POST['cep_desti'];
        $fone_desti      =$_POST['fone_desti'];
        $dt_atu_cada     =$_POST['dt_atu_cada'];

        $con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
        $res = mysql_select_db($banco_d) or die ("Banco de dados inexistente");

        $verifi="SELECT codigo_desti FROM destino WHERE codigo_desti='$codigo_desti'";
        $query = mysql_db_query($banco_d,$verifi,$con) or die ("Não foi possivel acessar o banco");
        $achou = mysql_num_rows($query);

        If ($achou > 0 ) {
        ?>
        <script language="javascript"> window.location.href=("cadastro_auditor.php")
            alert('Já existe destino cadastrado com o codigo informada.');
        </script>
        <?php
        }
        else {
          $inclusao = "INSERT INTO destino(codigo_desti,nome_desti,rua_desti,numero_desti,
          bairro_desti,cidade_desti,estado_desti,cep_desti,fone_desti,dt_atu_cada)
          values('$codigo_desti','$nome_desti','$rua_desti','$numero_desti','$bairro_desti',
          '$cidade_desti','$estado_desti','$cep_desti','$fone_desti','$v_dt_atu_cada')";


             if (mysql_db_query($banco_d,$inclusao,$con)) {
                $resp_grava="Inclusão bem sucedida";
                unset($_SESSION['codigo_desti']);
                $codigo_desti    ='';
                unset($_SESSION['nome_desti']);
                $nome            ='';
                unset($_SESSION['cep_desti']);
                $cep_1           ='';
                unset($_SESSION['rua_desti']);
                $rua             ='';
                $numero          ='';
                unset($_SESSION['bairro_desti']);
                $bairro          ='';
                unset($_SESSION['cidade_desti']);
                $cidade          ='';
                unset($_SESSION['estado_nome']);
                $estado_n        ='';
                unset($_SESSION['estado_sigla']);
                $estado_s        ='';
                $fone_desti      ='';
             }
             else {
               $resp_grava="Problemas na Inclusão";
             }
        }
        mysql_close ($con);
        }
       break;
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
  <body leftmargin="10" topmargin="10" marginwidth="10" marginheight="10">
  <form name="cadastro" id="cadastro" action="cadastro_ceps_cidades.php" method="post" onSubmit="return limpa()">
	<table width="50%" border="1" cellpadding="5" cellspacing="0" bordercolor="#4169E1">
        <tr>
           <td><b>Codigo :</b></td>
           <td><input type="text" name="codigo_desti" class="campo" id="codigo_desti" value ="<?php echo "$codigo_desti";?>" size="14" maxlength="14"></td>
		</tr>
		<tr>
			<td><b>Nome :</b></td>
			<td><input type="text" name="nome_desti" value ="<?php echo "$nome_desti";?>" size="50" maxlength="50" id="nome_desti"></td>
		</tr>
		<tr>
           <td><b>CEP:</b> </td>
           <td><input name="cep_desti" type="text" id="cep_desti" value ="<?php echo "$cep";?>" size="10" maxlength="10"><input name="mostra" type="submit" value="Busca Endereço"</td>
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
           <td><input name="estado_desti" type="text" id="estado_desti" value ="<?php echo "$estado_s";?>" size="2" maxlength="2"> - <?php echo "$estado_n";?></td>
        </tr>
		<tr>
			<td><b>Telefones :</b></td>
			<td><input type="text" name="fone_desti" value ="<?php echo "$fone_desti";?>" size="40" maxlength="40" id="fone_desti"></td>
		</tr>
        <tr>
          <td><b>Data cadastro :</b></td>
          <td>
            <input type="text" name="dt_atu_cada" size="12" maxlength="12" id="dt_atu_cada">
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
