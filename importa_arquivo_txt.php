<?php
  session_start();

//carrega variaveis com dados para acessar o banco de dados

  $base_d     =$_SESSION['base_d'];
  $banco_d    =$_SESSION['banco_d'];
  $usuario_d  =$_SESSION['usuario_d'];
  $senha_d    =$_SESSION['senha_d'];

  $matricula_m  =$_SESSION['matricula_m'];
  $programa='03';
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

<title>Cadastro_cli_for.php</title>
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
         <p align="right"><font face="Arial" size="2" color="#FFFFFF"><b>Importação de Remessa</b></font></td>
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
  <?php
  
   switch (get_post_action('importa')) {
      case 'mostra':
         /*
         esta funciomando para txt e csv, pode funcionar para outros arquivos, mais so testei estes
         voce devera alterar os dados de conecção do bando de dados
         altera a nome da tabela que voce esta usando, e o nome do arquivo
         o arquivo deve estar na mesma pasta deste arquivo php
         */

         $conexao = mysql_connect($base_d,$usuario_d,$senha_d);
         if($conexao) {
           mysql_select_db($banco_d, $conexao) or die("O banco solicitado não pode ser utilizado :  . mysql_error()");
         }
         else{echo "não foi possivel estabelecer uma conecção";}

         //========================================

         $tabela = "remessa"; //tabela do banco
         $arquivo = '00000001082011.txt';// aquivo a ser importado txt ou
         //$arquivo = 'teste.csv';// aquivo a ser importado csv do execel

         $arq = fopen($arquivo,'r');// le o arquivo txt

         while(!feof($arq)){
           for($i=0; $i<1; $i++){
	         if ($conteudo = fgets($arq)){//se extrair uma linha e não for false
		        $ll++; // $ll recebe mais 1 ==== em quanto o existir linha sera somada aqui
		        $linha = explode(';', $conteudo);// divide por coluna onde tiver ponto e virgula
	         }

	         $sql = "INSERT INTO $tabela (TESTE1, TESTE2, TESTE3) VALUES ('$linha[0]', '$linha[1]', '$linha[2]')";
	         $result = mysql_query($sql) or die(mysql_error());
	         $linha = array();// linpa o array de $linha e volta para o for
           }
         }
      echo "quantidade de linhas importadas = ".$ll;
      break;
    }
  ?>
  <body leftmargin="10" topmargin="10" marginwidth="10" marginheight="10">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
         <td color="white" align="left" width="100%" height="35">
      </tr>
    </table>
  <form name="cadastro" id="cadastro" action="cadastro_funcao.php" method="post">
	<table width="50%" border="1" cellpadding="5" cellspacing="0" bordercolor="#6495ED">
		<tr>
			<td><b>Nome do arquivo TXT :</b></td>
			<td><input type="text" name="arquivo" size="30" maxlength="30" id="arquivo"></td>
		</tr>
        <tr>
            <td><INPUT type=button value="Funções Cadastradas"
               onClick="window.open('mostra_funcoes_cadastradas.php','janela_1',
               'scrollbars=yes,resizable=yes,width=600,height=400');">
            </td>
			<td>
				<div align="right">
				<input name="importa" type="submit" value="Importar">
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
    <table border="0" width="100%" cellspacing="0" cellpadding="0" background="img/blue.jpg">
      <tr>
        <td width="100%" height="25" align="center"></font><font color="#000000" size="1" face="Arial">©&nbsp; COPYRIGHT NUNESTECH Tecnologia em Sistemas Ltda</font></td>
     </tr>
   </table>

</BODY>
</HTML>
