<?php
  session_start();

 //carrega variaveis com dados para acessar o banco de dados

  $base_d     =$_SESSION['base_d'];
  $banco_d    =$_SESSION['banco_d'];
  $usuario_d  =$_SESSION['usuario_d'];
  $senha_d    =$_SESSION['senha_d'];

  $codigo_m  =$_SESSION['codigo_m'];
  $programa='20';
  $_SESSION['programa_m']=$programa;
  
  $con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
  $res = mysql_select_db($banco_d) or die ("Banco de dados inexistente");

  $declara = "SELECT matricula,programa
  FROM permissoes
  WHERE ((matricula='$codigo_m') and (programa='$programa'))";

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
  function get_post_action($name) {
    $params = func_get_args();
    foreach ($params as $name) {
        if (isset($_POST[$name])) {
            return $name;
        }
    }
  }
?>
<html>
  <title>Cadastro_conta.php</title>
  <head>
  </head>
  <body>
  <div id="geral" align="center">
    <body topmargin="0" leftmargin="0" rightmargin="0" bottommargin="0" marginheight="0" marginwidth="0" bgcolor="#FFFFFF">
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
    switch (get_post_action('grava')) {
        case 'grava':
            $nu_banco          =$_POST['nu_banco'];
            $nome_banco        =$_POST['nome_banco'];
            $agencia           =$_POST['agencia'];
            $conta_co          =$_POST['conta_co'];
            $valor_saldo       =$_POST['saldo'];
            $observacao        =$_POST['observacao'];

            //$competencia         =Strtoupper($competencia);

            // alterando o formato dos valores para guardar no banco
            if (strlen($valor_saldo)>=6) {
               $valor_saldo         = str_replace(".", "", $valor_saldo);
               $valor_saldo         = str_replace(",", ".", $valor_saldo);
            }
            if (strlen($valor_saldo)<6) {
               $valor_saldo         = str_replace(",", ".", $valor_saldo);
            }

            $con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
            $res = mysql_select_db($banco_d) or die ("Banco de dados inexistente");
            
            $inclusao = "INSERT INTO conta_banco (nu_banco,nome_banco,agencia,conta_co,observacao,saldo)
            values('$nu_banco','$nome_banco','$agencia','$conta_co','$observacao','$valor_saldo')";
            
            if (mysql_db_query($banco_d,$inclusao,$con)) {
                 $resp_grava="Inclusão bem sucedida";
                 $nu_banco          ='';
                 $nome_banco        ='';
                 $agencia           ='';
                 $conta_co          ='';
                 $valor_saldo       ='';
                 $observacao        ='';
            }
            else {
               $resp_grava="Problemas na Inclusão";
            }
            mysql_close ($con);
        break;
     default:
    }
  ?>
  <script LANGUAGE="Javascript">
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
  
   <style>
		body, p, div, td, input, select, textarea {
			font-family: verdana,arial,helvetica;
			font-size:12px;
			color:#000000;
			text-decoration: none;
		}
		input,textarea {
			@if (is.ie) {
				color: #efefef; background-color:#FFE4B5; border: 1px solid #DEB887;
				/*border-top-width: 1px; border-right-width: 1px; border-bottom-width: 1px; border-left-width: 1px; */
			}
		}
		textarea { overflow:auto }
  </style>
  </head>
  <body leftmargin="10" topmargin="10" marginwidth="10" marginheight="10">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
         <td color="white" align="left" width="100%" height="35">
      </tr>
    </table>
  <form name="cadastro" id="cadastro" action="cadastro_conta.php" method="post">
	<table width="70%" border="1" cellpadding="5" cellspacing="0" bordercolor="#DEB887">
        <tr>
			<td><b>Número Banco:</b></td>
			<td><input type="text" name="nu_banco" size="15" maxlength="15" id="nu_banco"></td>
		</tr>
		<tr>
			<td><b>Nome Banco:</b></td>
			<td><input type="text" name="nome_banco" size="25" maxlength="25" id="nome_banco"></td>
		</tr>
		<tr>
			<td><b>Número Agência:</b></td>
			<td><input type="text" name="agencia" size="15" maxlength="15" id="agencia"></td>
		</tr>
		<tr>
			<td><b>Número Conta:</b></td>
			<td><input type="text" name="conta_co" size="15" maxlength="15" id="conta_co"></td>
		</tr>
        <tr>
			<td><b>Valor Saldo :</b></td>
			<td><input name="saldo" type="text" size="20" maxlength="20" onKeydown="Formata(this,20,event,2)"></td>
		</tr>
        <tr>
           <td width="30%"><b>Obserevação :</b></td>
           <td><TEXTAREA NAME="observacao" rows="10" cols="100" style="width: 100%"></TEXTAREA></td>
        </tr>
        <tr>
			<td colspan="2">
				<div align="right">
				<input name="grava" type="submit" value="Gravar">
				</div>
			</td>
		</tr>
	</table>
	 </form>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td color="white" align="center" width="900" height="45" colspan="8" ><?php echo "$resp_grava";?></td>
      </tr>
    </table>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
         <td color="white" align="left" width="100%" height="30">
      </tr>
    </table>
    <table border="0" width="100%" cellspacing="0" cellpadding="0" background="img/marron.jpg">
      <tr>
        <td width="100%" height="25" align="center"></font><font color="white" size="1" face="Arial">©&nbsp; COPYRIGHT NUNESTECH Tecnologia em Sistemas Ltda</font></td>
     </tr>
   </table>
 </div>
</body>
</html>

