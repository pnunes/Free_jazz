<?php
  session_start();

//carrega variaveis com dados para acessar o banco de dados

  $base_d     =$_SESSION['base_d'];
  $banco_d    =$_SESSION['banco_d'];
  $usuario_d  =$_SESSION['usuario_d'];
  $senha_d    =$_SESSION['senha_d'];

  $nome_m       =$_SESSION['nome_m'];
  $matricula_m  =$_SESSION['matricula_m'];
  $programa='045';
  $_SESSION['programa_m']=$programa;

  /////////////ABRE CONEXÃO COM O BANCO DE DADOS //////////////////////////////
  
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

<title>faturamento.php</title>
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
         <p align="right"><font face="Arial" size="2" color="#FFFFFF"><b>Gera Faturamento</b></font></td>
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
  
   switch (get_post_action('processa')) {
      case 'processa':

             // Seleciona movimento noperiodo informado
             $codi_cli    =$_POST['cliente'];
             $dt_inicio   =$_POST['dt_inicio'];
             $dt_fim      =$_POST['dt_fim'];
             $mes_ano     =$_POST['mes_ano'];
             $dt_gerado   =date('Y-m-d');
             
             //Verifica se já foi processado o faturamento para o mês escritorio e cliente informados

             $confere="SELECT * FROM faturamento
             WHERE ((codi_cli='$codi_cli') AND (mes_ano='$mes_ano'))";
             $query_4 = mysql_db_query($banco_d,$confere,$con) or die ("Não foi possivel acessar o banco 2");
             $total = mysql_num_rows($query_4);
             If ($total > 0) {
                 ?>
                 <script language="javascript"> window.location.href=("faturamento.php")
                    alert('O fatruramento para o escritório e mês informados já foi processado! Verifique.');
                 </script>
                 <?php
             }
             
             //Altera formato de data para comparação
             $dt_inicio  = explode("/",$dt_inicio);
             $v_dt_inicio = $dt_inicio[2]."-".$dt_inicio[1]."-".$dt_inicio[0];
             
             $dt_fim  = explode("/",$dt_fim);
             $v_dt_fim = $dt_fim[2]."-".$dt_fim[1]."-".$dt_fim[0];
             
             $coleta="SELECT codi_cli,co_servico,qtdade,valor,classe_cep
             FROM remessa
             WHERE ((codi_cli='$codi_cli')
             AND (dt_remessa>='$v_dt_inicio')
             AND (dt_remessa<='$v_dt_fim'))
             ORDER BY codi_cli,co_servico";
             
             $query_1 = mysql_db_query($banco_d,$coleta,$con) or die ("Não foi possivel acessar o banco 1");
             $achou = mysql_num_rows($query_1);
             
             If ($achou == 0) {
                 ?>
                 <script language="javascript"> window.location.href=("faturamento.php")
                    alert('Não há movimento lançado no período informado! Verifique.');
                 </script>
                 <?php
             }
             else {
                 $ser=0;
                 $con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
                 $res = mysql_select_db($banco_d) or die ("Banco de dados inexistente");
                 while($linha=mysql_fetch_array($query_1)) {
                      if ($ser==0) {
                         $cliente      = $linha['codi_cli'];
                         $servi        = $linha['co_servico'];
                         $classe_cep   = $linha['classe_cep'];
                         $ser=1;
                      }
                      if ($linha['codi_cli']<>'' and $linha['co_servico']<>'' and $linha['classe_cep']<>'')  {
                          if (($linha['codi_cli']==$cliente) and ($linha['co_servico']==$servi)) {
                              $localiza="SELECT valor FROM tabela_preco WHERE codi_cli='$cliente' AND tipo_servi='$servi' AND classe_cep='$classe_cep'";
                              $query = mysql_db_query($banco_d,$localiza,$con) or die ("Não foi possivel acessar o banco (pega valor)");
                              $total = mysql_num_rows($query);
                              for($ic=0; $ic<$total; $ic++){
                                 $row = mysql_fetch_row($query);
                                 $t_valor             = $row[0];
                              }
                              if ($classe_cep<>'04' AND $classe_cep<>'03') {
                                 $t_qtd = $t_qtd+$linha['qtdade'];
                                 $valor = $valor+($t_valor*$linha['qtdade']);
                              }
                              else {
                                 $t_qtd   = $t_qtd+$linha['qtdade'];
                                 $valor = $valor+($linha['valor']*$linha['qtdade']);
                              }
                          }
                          else {
                              $grava="INSERT INTO faturamento (mes_ano,codi_cli,codigo_se,qtdade,vl_fatu,dt_gerado)
                              VALUES('$mes_ano','$cliente','$servi','$t_qtd','$valor','$dt_gerado')";
                              mysql_db_query($banco_d,$grava,$con);
                              $t_qtd   =0;
                              $valor   =0;
                              //faz o primeiro calculo para a nova combinação cliente e serviço
                              $localiza="SELECT valor FROM tabela_preco WHERE codi_cli='$cliente' AND tipo_servi='$servi' AND classe_cep='$classe_cep'";
                              $query = mysql_db_query($banco_d,$localiza,$con) or die ("Não foi possivel acessar o banco (pega valor)");
                              $total = mysql_num_rows($query);
                              for($ic=0; $ic<$total; $ic++){
                                 $row = mysql_fetch_row($query);
                                 $valor             = $row[0];
                              }
                              if ($classe_cep<>'04' AND $classe_cep<>'03') {
                                 $t_qtd   = $t_qtd+$linha['qtdade'];
                                 $valor = $valor+($valor*$linha['qtdade']);
                              }
                              else {
                                 $t_qtd   = $t_qtd+$linha['qtdade'];
                                 $valor = $valor+($linha['valor']*$linha['qtdade']);
                              }
                              //prepara para o novo escritorio,cliente ou serviço

                              $cliente      = $linha['codi_cli'];
                              $servi        = $linha['co_servico'];
                              $classe_cep   = $linha['classe_cep'];
                          }
                      }
                 }
                 
                 //Grava o último registro ao findar as linhas do array
                 
                 $grava="INSERT INTO faturamento (mes_ano,codi_cli,codigo_se,qtdade,vl_fatu,dt_gerado)
                 VALUES('$mes_ano','$cliente','$servi','$t_qtd','$valor','$dt_gerado')";
                 mysql_db_query($banco_d,$grava,$con);
                 $t_qtd   =0;
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
  <form name="cadastro" id="cadastro" action="faturamento.php" method="post">
	<table width="30%" border="1" cellpadding="5" cellspacing="0" bordercolor="#6495ED">
      <tr>
           <td><b>Cliente :</b></td>
           <td>
              <?php

               mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
               mysql_select_db($banco_d) or die ("Banco de dados inexistente");

               ?>
              <select name="cliente">
              <?php
              $sql = "SELECT cnpj_cpf,nome FROM cli_for WHERE ativo='S' AND catego='C' ORDER BY nome";
              $resultado = mysql_db_query($banco_d,$sql,$con) or die ("Não foi possivel acessar o banco");
              while ( $linha = mysql_fetch_array($resultado)) {
                    $select = $codi_cli == $linha[0] ? "selected" : "";
                    echo "<option value=\"". $linha[0] . "\" $select>" . $linha[1] . "</option>";
              }
              ?>
            </td>
		</tr>
      <tr>
          <td><b>Data Iníco :</b></td>
          <td>
            <input type="text" name="dt_inicio" size="12" maxlength="12" id="dt_inicio">
            <input TYPE="button" NAME="btndt_inicio" VALUE="..." Onclick="javascript:popdate('document.cadastro.dt_inicio','pop1','150',document.cadastro.dt_inicio.value)">
            <span id="pop1" style="position:absolute"></span>
          </td>
        </tr>
      <tr>
          <td><b>Data Limite :</b></td>
          <td>
            <input type="text" name="dt_fim" size="12" maxlength="12" id="dt_fim">
            <input TYPE="button" NAME="btndt_fim" VALUE="..." Onclick="javascript:popdate('document.cadastro.dt_fim','pop2','150',document.cadastro.dt_fim.value)">
            <span id="pop2" style="position:absolute"></span>
          </td>
        </tr>
        <tr>
			<td><b>Mês Ano :</b></td>
			<td><input name="mes_ano" type="text" value ="<?php echo "$mes_ano";?>" size="20" maxlength="20" id="mes_ano">(Exemplo :082011)</td>
		</tr>
        <tr>
			<td>
				<div align="right">
				<input name="processa" type="submit" value="Processar">
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
