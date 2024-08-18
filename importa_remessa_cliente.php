<?php
  session_start();

//carrega variaveis com dados para acessar o banco de dados

  $base_d     =$_SESSION['base_d'];
  $banco_d    =$_SESSION['banco_d'];
  $usuario_d  =$_SESSION['usuario_d'];
  $senha_d    =$_SESSION['senha_d'];

  $nome_m       =$_SESSION['nome_m'];
  $matricula_m  =$_SESSION['matricula_m'];
  $programa='029';
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

  function get_post_action($name)
   {
    $params = func_get_args();

    foreach ($params as $name) {
        if (isset($_POST[$name])) {
            return $name;
        }
    }
   }
   include("campo_calendario.php");
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
      case 'importa':
         $arquivo       =$_POST['arquivo'];
         $data_recebe   =$_POST['data_ini'];
         
         //Altera formato de data para comparação
         $data_recebe   = explode("/",$data_recebe);
         $v_data_recebe = $data_recebe[2]."-".$data_recebe[1]."-".$data_recebe[0];
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

         //$tabela = "remessa"; //tabela do banco
         //$arquivo = 'arquivo';// aquivo a ser importado txt ou
         //$arquivo = 'teste.csv';// aquivo a ser importado csv do execel

         $arq = fopen('reme_wihus/'.$arquivo,'r');// le o arquivo txt
         $grava=0;
         $mensa=0;
         $dt_importa   =date('Y-m-d');
         $h_hora = date("H:i", time());

         $inclui=0;
         $ll=0;
         while(!feof($arq)){
            for($i=0; $i<1; $i++){
	          if ($conteudo = fgets($arq)){//se extrair uma linha e não for false
		        $ll++; // $ll recebe mais 1 ==== em quanto o existir linha sera somada aqui
		        $linha = explode(';', $conteudo);// divide por coluna onde tiver ponto e virgula
	          }
              $n_hawb  =$linha[1];
              
              //Verifica se o POD ja foi importado - se já existe no banco
              $verifi="SELECT n_hawb FROM remessa WHERE n_hawb='$n_hawb'";
              $query = mysql_db_query($banco_d,$verifi,$con) or die ("Não foi possivel acessar o banco");
              $achou = mysql_num_rows($query);
              If ($achou == 0 ) {
                  $servico  =$linha[4];

                  if ($servico<>'0007') {
                     //Pega codigo do serviço na tabela free_jazz
                     $coleta ="SELECT codigo_se FROM serv_ati WHERE codigo_wihus='$servico'";
                     $query = mysql_db_query($banco_d,$coleta,$con) or die ("Não foi possivel acessar o banco 2");
                     $total = mysql_num_rows($query);
                     for($ic=0; $ic<$total; $ic++){
                        $row = mysql_fetch_row($query);
                        $codigo_se     = $row[0];
                     }
                  }
                  else {
                     $codigo_se='0004';
                  }
                  //localiza a classe de cep
                  $cep_desti   =$linha[9];
                  $cep_desti_c =Substr($cep_desti,0,5);
                  $pega_cep = mysql_query("SELECT codigo,cep_inicio,cep_fim,escritorio FROM classe_cep");
                  while ($row = mysql_fetch_array($pega_cep)) {
                     $codigo_cla     = $row[0];
                     $cep_ini        = $row[1];
                     $cep_fi         = $row[2];
                     $escritorio     = $row[3];
                     if (((int)$cep_desti_c>=(int)$cep_ini) and ((int)$cep_desti_c<=(int)$cep_fi)) {
                         $classe_cep = $codigo_cla;
                         $base       = $escritorio;
                         break;
                     }
                     else {
                         $classe_cep='';
                     }
                  }
                  $estado  =$linha[12];
                  if ($classe_cep=='') {
                     if ($estado='SC') {
                        $base    ='001';
                     }
                     if ($estado<>'SC')  {
                        $base    ='002';
                     }
                     $classe_cep = '03';
                  }
                  If ($linha[1]<>'') {
                      //Grava o registro do POD na tabela remessa
                      $sql = "INSERT INTO remessa (cod_barra,n_hawb,n_remessa,dt_remessa,co_servico,codigo_desti,
                      nome_desti,rua_desti,comple_desti,cep_desti,bairro_desti,cidade_desti,estado_desti,escritorio,
                      codi_cli,classe_cep,qtdade)
                      VALUES ('$linha[0]','$linha[1]','$linha[2]','$v_data_recebe','$codigo_se','$linha[5]',
                      '$linha[6]','$linha[7]','$linha[8]','$linha[9]','$linha[10]','$linha[11]','$linha[12]',
                      '$base','$linha[14]','$classe_cep','1')";
                      $result = mysql_query($sql) or die(mysql_error());
                      $grava++;
                      $mensa= 1;

        	          //////////////////Atualiza a tabela de controle de ações no sistema ////////////////////
                      $servico      =$_SESSION['servi_m'];
                      $matricula_m  =$_SESSION['matricula_m'];
                      $data         = date('Y/m/d');
                      $hora         = date ('H:i');
                      $programa     =$_SESSION['programa_m'];
                      $incluir="INSERT INTO log_operacao_sistema (matricula,tarefa_executada,
                      n_hawb,data,hora,rotina,servico,codi_cli,remessa)
                      VALUES('$matricula_m','Iportação da HAWB para o Sistema','$linha[1]','$data','$hora',
                      '$programa','$servico','$linha[14]','$linha[2]')";
                      mysql_db_query($banco_d,$incluir,$con);

                      //////////////////Atualiza a tabela de histórico HAWB /////////////////////////////////
                      $atualiza="INSERT INTO controle_reentrega (n_hawb,dt_evento,ocorrencia,cod_barra,ordem)
                      VALUES('$linha[1]','$v_data_recebe','Recebido na Transportadora.','$linha[0]','1')";
                      mysql_db_query($banco_d,$atualiza,$con);

        	          //Atualiza o arquivo de dados de destinatários
                      $codigo_desti =$linha[5];
        	          $con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
                      $res = mysql_select_db($banco_d) or die ("Banco de dados inexistente");

                      $consulta="SELECT codigo_desti FROM destino WHERE codigo_desti='$codigo_desti'";
                      $query = mysql_db_query($banco_d,$consulta,$con) or die ("Não foi possivel acessar o banco 3");
                      $achou = mysql_num_rows($query);
                      If ($achou == 0 ) {
                           $inclusao = "INSERT INTO destino(codigo_desti,nome_desti,cep_desti,
                           rua_desti,comple_desti,bairro_desti,cidade_desti,
                           estado_desti,dt_atu_cada)
                           values('$linha[5]','$linha[6]','$linha[9]','$linha[7]',
                           '$linha[8]','$linha[10]','$linha[11]',
                           '$linha[12]','$v_dt_remessa')";
                           mysql_db_query($banco_d,$inclusao,$con);
                      }
                  }
                  $linha = array();// linpa o array de $linha e volta para o for
              }
            }
         }
         if ($mensa== 1) {
            $resp_grava="Foram lidos ".$ll." Registros e Gravados".$grava;
         }
      break;
      default:
  }
  ?>
  <body leftmargin="10" topmargin="10" marginwidth="10" marginheight="10">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
         <td color="white" align="left" width="100%" height="35">
      </tr>
    </table>
  <form name="cadastro" id="cadastro" action="importa_remessa_cliente.php" method="post">
	<table width="50%" border="1" cellpadding="5" cellspacing="0" bordercolor="#6495ED">
		<tr>
			<td><b>Nome do arquivo TXT :</b></td>
			<td><input type="text" name="arquivo" size="50" maxlength="50" id="arquivo"></td>
		</tr>
		<tr>
            <td><b>Data Importação :</b></td>
            <td>
              <input type="text" name="data_ini" size="12" maxlength="12" id="data_ini">
              <input TYPE="button" NAME="btndata_ini" VALUE="..." Onclick="javascript:popdate('document.cadastro.data_ini','pop1','150',document.cadastro.data_ini.value)">
              <span id="pop1" style="position:absolute"></span>
            </td>
          </tr>
        <tr>
            <td><INPUT type=button value="Ver Remessas Recebidas"
               onClick="window.open('mostra_remessa_recebida.php','janela_1',
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
