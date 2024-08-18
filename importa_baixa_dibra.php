<?php
  session_start();

//carrega variaveis com dados para acessar o banco de dados

  $base_d     =$_SESSION['base_d'];
  $banco_d    =$_SESSION['banco_d'];
  $usuario_d  =$_SESSION['usuario_d'];
  $senha_d    =$_SESSION['senha_d'];

  $nome_m       =$_SESSION['nome_m'];
  $matricula_m  =$_SESSION['matricula_m'];
  $programa='030';
  $_SESSION['programa_m']=$programa;

  //Abre conexãocom o banco de dados
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
  function get_post_action($name)
   {
    $params = func_get_args();

    foreach ($params as $name) {
        if (isset($_POST[$name])) {
            return $name;
        }
    }
   }
  include ("campo_calendario.php");
?>

<title>importa_baixa_dibra.php</title>
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
         <p align="right"><font face="Arial" size="2" color="#FFFFFF"><b>Importação das Baixas</b></font></td>
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
      case 'importa':
         $arquivo          =$_POST['arquivo'];
         $data_importa     =$_POST['data_importa'];
         /*
         esta funciomando para txt e csv, pode funcionar para outros arquivos, mais so testei estes
         voce devera alterar os dados de conecção do bando de dados
         altera a nome da tabela que voce esta usando, e o nome do arquivo
         o arquivo deve estar na mesma pasta deste arquivo php
         */

         //========================================

         //$tabela = "remessa"; //tabela do banco
         //$arquivo = 'arquivo';// aquivo a ser importado txt ou
         //$arquivo = 'teste.csv';// aquivo a ser importado csv do execel

         $arq = fopen('baixa_dibra/'.$arquivo,'r');// le o arquivo.
         $grava=0;
         $mensa=0;

         //Altera formato da data para gravar na tabela

         $data_importa   = explode("/",$data_importa);
         $v_data_importa = $data_importa[2]."-".$data_importa[1]."-".$data_importa[0];

         $n_localiza  =0;
         $localiza    =0;
         $ll=0;
         while(!feof($arq)){
           for($i=0; $i<1; $i++){
	           if ($conteudo = fgets($arq)){//se extrair uma linha e não for false
		           $ll++; // $ll recebe mais 1 ==== em quanto o existir linha sera somada aqui
		           $linha = explode(',', $conteudo);// divide por coluna onde tiver virgula
               }
               $n_hawb  =trim($linha[1]);
               
               //Verifica se o POD passou pelos demais passos
               $verifi="SELECT dt_lista FROM remessa WHERE n_hawb='$n_hawb'";
               $query = mysql_db_query($banco_d,$verifi,$con) or die ("Não foi possivel acessar o banco");
               $total = mysql_num_rows($query);
               for($ic=0; $ic<$total; $ic++){
                  $row = mysql_fetch_row($query);
                  $dt_lista        = $row[0];
               }
               If ($dt_lista<>'0000-00-00') {
                   // inicia a importação dos dados atualizando as baixas

                   if (($linha[0]<>'') and ($linha[1]<>''))  {
                      $n_hawb  =trim($linha[1]);
                      $altera="UPDATE remessa SET dt_entrega='$v_data_importa',dt_baixa='$v_data_importa',
                      ocorrencia='69'
                      WHERE n_hawb='$n_hawb'";
                      mysql_db_query($banco_d,$altera,$con);
                      $localiza = $localiza+1;

                     //////////////////Atualiza a tabela de histórico HAWB /////////////////////////////////
                        $atualiza="INSERT INTO controle_reentrega (n_hawb,dt_evento,ocorrencia,ordem)
                        VALUES('$n_hawb','$v_data_importa','HAWB entregue e digitalizada.','4')";
                        mysql_db_query($banco_d,$atualiza,$con);
                   }
                   else {
                      $n_localiza = $n_localiza+1;
                   }
               }
	       }
           $linha = array();// linpa o array de $linha e volta para o for
         }
          $resp_grava="Toral Registros importados : ".$localiza." Total Registros incompletos descartados :".$n_localiza;
      break;
    }
  ?>
  <body leftmargin="10" topmargin="10" marginwidth="10" marginheight="10">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
         <td color="white" align="left" width="100%" height="35">
      </tr>
    </table>
  <form name="cadastro" id="cadastro" action="importa_baixa_dibra.php" method="post">
	<table width="50%" border="1" cellpadding="5" cellspacing="0" bordercolor="#6495ED">
		<tr>
			<td><b>Nome do arquivo TXT :</b></td>
			<td><input type="text" name="arquivo" size="30" maxlength="30" id="arquivo"></td>
		</tr>
		<tr>
          <td><b>Data Importação :</b></td>
          <td>
            <input type="text" name="data_importa" size="12" maxlength="12" id="data_importa">
            <input TYPE="button" NAME="btndata_importa" VALUE="..." Onclick="javascript:popdate('document.cadastro.data_importa','pop1','150',document.cadastro.data_importa.value)">
            <span id="pop1" style="position:absolute"></span>
          </td>
        </tr>
        <tr>
            <td><INPUT type=button value="Ver Baixas"
               onClick="window.open('mostra_baixa_dibra.php','janela_1',
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
        <td align="center" color="white" width="900" height="45" colspan="7" ><?php echo "$resp_grava";?></td>
      </tr>
    </table>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
         <td color="white" align="left" width="100%" height="30">
      </tr>
    </table>
    <table border="0" width="100%" cellspacing="0" cellpadding="0" background="img/blue.jpg">
      <tr>
        <td width="100%" height="25" align="center"></font><font color="white" size="1" face="Arial">©&nbsp; COPYRIGHT NUNESTECH Tecnologia em Sistemas Ltda</font></td>
     </tr>
   </table>

</BODY>
</HTML>
