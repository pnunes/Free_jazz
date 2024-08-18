<?php
  session_start();
  $base_nome      =$_SESSION['base_nome'];
  $uso_login      =$_SESSION['uso_login'];
  $senha_log      =$_SESSION['senha_log'];

?>

<html>
  <title>Contato.php</title>
  <head>
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
  <body>
  <div id="geral" align="center">
    <body topmargin="0" leftmargin="0" rightmargin="0" bottommargin="0" marginheight="0" marginwidth="0" bgcolor="#FFFFFF">

    <table border="0" width="100%" bgcolor="#000000" cellspacing="0" cellpadding="0">
      <tr>
       <td width="20%"  height="100"><p align="left"><img border="0" src="img/top_esquerdo.jpg" width="196" height="120"></td>
       <td width="50%" height="100"><p align="center"><img border="0" src="img/LOGO_ACTION_TUNEL_02.gif" width="196" height="120"></td>
       <td width="34%" height="100"><p align="right"><img border="0" src="img/topright.jpg" width="178" height="120"></td>
     </tr>
    </table>
     <table border="0" width="100%" cellspacing="0" cellpadding="0" background="img/blue.jpg">
       <tr>
         <td width="100%">
            <p align="right"><font face="times roman" size="2" color="#FFFFFF">Registro contatos</font></td>
       </tr>
     </table>
     <table width="100%" border="0" cellspacing="0" cellpadding="0">
       <tr>
         <td color="white" align="right" width="900" height="40"><a href="index.php"><img src="img/porta.gif" border="none"></td>
       </tr>
     </table>
  <?php
    include ("campo_calendario.php");
    $resp_grava='';
    if (isset($_POST['nome'])) {
        $nome            =$_POST['nome'];
        $empresa         =$_POST['empresa'];
        $negocio         =$_POST['negocio'];
        $telefone        =$_POST['telefone'];
        $ende_ele        =$_POST['ende_ele'];
        $conteudo        =$_POST['conteudo'];
        $lido            =$_POST['lido'];
        $data            =$_POST['data'];
        
        //alterando o formato das datas para guardar no banco
        $data          = explode("/",$data);
        $data_cada   = $data[2]."-".$data[1]."-".$data[0];
        
        $con = mysql_connect($base_nome, $uso_login, $senha_log) or die ("Erro de conexão");
        $res = mysql_select_db('action') or die ("Banco de dados inexistente");

        $inclusao = "INSERT INTO contato(nome,empresa,negocio,telefone,ende_ele,conteudo,lido,data)
        values('$nome','$empresa','$negocio','$telefone','$ende_ele','$conteudo','$lido','$data_cada')";

        if (mysql_db_query("action",$inclusao,$con)) {
             $resp_grava="Mensagem enviada com sucesso.";
             $nome            ='';
             $empresa         ='';
             $negocio         ='';
             $telefone        ='';
             $ende_ele        ='';
             $conteudo        ='';
             $lido            ='';
            }
           else {
             $resp_grava="Problemas no envio. Faça seu contato por telefone.";
           }
       mysql_close ($con);
    }

  ?>
  <body leftmargin="10" topmargin="10" marginwidth="10" marginheight="10">
  <form name="contato" id="contato" action="contato.php" method="post">
	<table width="50%" border="1" cellpadding="5" cellspacing="0" bordercolor="#4169E1">
        <tr>
           <td><b>Nome completo :</b></td>
           <td><input type="text" name="nome" class="campo" id="nome" size="50" maxlength="50"></td>
		</tr>
		<tr>
			<td><b>Empresa :</b></td>
			<td><input type="text" name="empresa" size="50" maxlength="50" id="empresa"></td>
		</tr>
        <tr>
           <td><b>Negócio da empresa :</b></td>
		   <td>
             <TEXTAREA NAME="negocio" rows="5" cols="70"></TEXTAREA>
           </td>
        </tr>
		<tr>
			<td><b>Telefones :</b></td>
			<td><input type="text" name="telefone" size="50" maxlength="50" id="telefone"></td>
		</tr>
		<tr>
			<td><b>Email :</b></td>
			<td><input type="text" name="ende_ele" size="50" maxlength="50" id="ende_ele"></td>
		</tr>
        <tr>
           <td><b>Mensagem :</b></td>
		   <td>
             <TEXTAREA NAME="conteudo" rows="10" cols="70"></TEXTAREA>
           </td>
        </tr>
        <tr>
          <td><b>Data :</b></td>
          <td>
            <input type="text" name="data" size="10" maxlength="10" id="data">
            <input TYPE="button" NAME="btndata" VALUE="..." Onclick="javascript:popdate('document.contato.data','pop1','150',document.contato.data.value)">
            <span id="pop1" style="position:absolute"></span>
          </td>
        </tr>
		<tr>
			<td colspan="2">
				<div align="right">
				<input name="enviar" type="submit" value="enviar">
				</div>
			</td>
		</tr>
	</table>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td color="white" align="center" width="900" height="30" colspan="8" ><?php echo "$resp_grava";?></td>
      </tr>
    </table>
    <table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="10%"  height="30" align="right"><img border="0" src="img/telefone.jpg" width="50" height="40"></td>
        <td width="20%"  height="30" align="left">  (48) 3025-7444 - (48) 9982-1200 / 9937-0777 - Fpolis - S.C.</td>
      </tr>
    </table>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td color="white" align="center" width="900" height="30" colspan="8" ></td>
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

