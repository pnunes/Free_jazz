<?php
  session_start();

 //carrega variaveis com dados para acessar o banco de dados

  $base_d     =$_SESSION['base_d'];
  $banco_d    =$_SESSION['banco_d'];
  $usuario_d  =$_SESSION['usuario_d'];
  $senha_d    =$_SESSION['senha_d'];

  $codigo_m  =$_SESSION['codigo_m'];
  $programa='21';
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
  <title>Cadastro_conta_altera.php</title>
  <head>
  <body>
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
     switch (get_post_action('grava','mostra')) {
         case 'mostra':
             $conta_co         =$_POST['conta_co'];
             $_SESSION['conta_co_i']  =$conta_co;
             
             $resp_grava='';
             $con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
             $res = mysql_select_db($banco_d) or die ("Banco de dados inexistente");

             $verifi="SELECT nu_banco,nome_banco,agencia,observacao,saldo
             FROM conta_banco WHERE conta_co='$conta_co'";
             $query = mysql_db_query($banco_d,$verifi,$con) or die ("Não foi possivel acessar o banco");
             $total = mysql_num_rows($query);

             for($ic=0; $ic<$total; $ic++){
               $row = mysql_fetch_row($query);
               $nu_banco             = $row[0];
               $nome_banco           = $row[1];
               $agencia              = $row[2];
               $observacao           = $row[3];
               $valor_saldo          = $row[4];
             }
             
             //Altera formato para mostrar valor
             $valor_saldo   = number_format($valor_saldo, 2, ',', '.');
           
             break;

         case 'grava':
             $nu_banco          =$_POST['nu_banco'];
             $nome_banco        =$_POST['nome_banco'];
             $agencia           =$_POST['agencia'];
             $observacao        =$_POST['observacao'];
             $saldo             =$_POST['saldo'];

             // alterando o formato dos valores para guardar no banco
             
             if (strlen($saldo)>=6) {
               $saldo         = str_replace(".", "", $saldo);
               $saldo         = str_replace(",", ".", $saldo);
             }
             if (strlen($saldo)<6) {
               $saldo         = str_replace(",", ".", $saldo);
             }

             $conta_co       =$_SESSION['conta_co_i'];

             $con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
             $res = mysql_select_db($banco_d) or die ("Banco de dados inexistente");

             $alteracao = "UPDATE conta_banco SET nu_banco='$nu_banco',nome_banco='$nome_banco',
             agencia='$agencia',observacao='$observacao',saldo='$saldo'
             WHERE conta_co='$conta_co'";
             
             if (mysql_db_query($banco_d,$alteracao,$con)) {
                $resp_grava="Alteraçao bem sucedida";
                $nu_banco          ='';
                $nome_banco        ='';
                $agencia           ='';
                $conta_co          ='';
                $valor_saldo       ='';
                $observacao        ='';
                unset($_SESSION['conta_co_i']);
            }
           else {
             $resp_grava="Problemas na Alteração";
           }
           break;
         default:
     }
     ?>

   <body leftmargin="10" topmargin="10" marginwidth="10" marginheight="10">
    <form name="cadastro" action="cadastro_conta_altera.php" method="post">
       <table width="50%" border="1" cellpadding="5" cellspacing="0" bordercolor="#DEB887">
        <tr>
			<td><b>Número conta:</b></td>
            <td>
               <select name="conta_co">
              <?php
                $con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
                $res = mysql_select_db($banco_d) or die ("Banco de dados inexistente");

                $sql2 = "SELECT conta_co,nome_banco FROM conta_banco";
                $resul = mysql_db_query($banco_d,$sql2,$con) or die ("Não foi possivel acessar o banco");
                while ( $linha = mysql_fetch_array($resul)) {
                    $select = $conta_co == $linha[0] ? "selected" : "";
                    echo "<option value=\"". $linha[0] . "\" $select>" . $linha[0] ." - ". $linha[1] ."</option>";
                }
              ?>
              </select>
              <input name="mostra" type="submit" value="Mostra"></center>
            </td>
         </tr>
         <tr>
			<td><b>Número Banco:</b></td>
			<td><input type="text" name="nu_banco" value ="<?php echo "$conta_co";?>" size="15" maxlength="15" id="nu_banco"></td>
		 </tr>
		 <tr>
			<td><b>Nome Banco:</b></td>
			<td><input type="text" name="nome_banco" value ="<?php echo "$nome_banco";?>" size="25" maxlength="25" id="nome_banco"></td>
		 </tr>
		 <tr>
			<td><b>Número Agência:</b></td>
			<td><input type="text" name="agencia" value ="<?php echo "$agencia";?>" size="15" maxlength="15" id="agencia"></td>
		 </tr>
         <tr>
			<td><b>Valor Saldo :</b></td>
			<td><input name="saldo" type="text" value ="<?php echo "$valor_saldo";?>" size="20" maxlength="20" onKeydown="Formata(this,20,event,2)"></td>
		 </tr>
         <tr>
           <td width="30%"><b>Obserevação :</b></td>
           <td><TEXTAREA NAME="observacao" rows="10" cols="100" style="width: 100%"><?php echo "$observacao";?></TEXTAREA></td>
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

