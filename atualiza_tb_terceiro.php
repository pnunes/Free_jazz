<?php
  session_start();
  $base_d     =$_SESSION['base_d'];
  $banco_d    =$_SESSION['banco_d'];
  $usuario_d  =$_SESSION['usuario_d'];
  $senha_d    =$_SESSION['senha_d'];

  function get_post_action($name) {
       $params = func_get_args();

       foreach ($params as $name) {
          if (isset($_POST[$name])) {
            return $name;
          }
       }
  }
    
  If ($_SESSION['programa_m']=='000') {
       $_POST['entregador'] ='';
  }
  switch (get_post_action('mostra')) {

         case 'mostra':
              $entregador             =$_POST['entregador'];
              $_SESSION['entrega_m']  =$entregador;
              
              $con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
              $res = mysql_select_db($banco_d) or die ("Banco de dados inexistente");

              //Pega o nome do entregador

              $con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
              $res = mysql_select_db($banco_d) or die ("Banco de dados inexistente");

              $pega = "SELECT nome FROM cli_for WHERE cnpj_cpf='$entregador'";
              $query = mysql_db_query($banco_d,$pega,$con) or die ("Não foi possivel acessar o banco 1");
              $total = mysql_num_rows($query);
              for($ic=0; $ic<$total; $ic++){
                  $row = mysql_fetch_row($query);
                  $nome_entrega          = $row[0];
              }
              $_SESSION['nome_entrega_m'] =$nome_entrega;
           break;
         default:
  }

  //carrega variaveis com dados para acessar o banco de dados

  $matricula_m  =$_SESSION['matricula_m'];
  $programa='120';
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
?>
<html>
<head>
<script type="text/javascript" src="bibliotecaajax_tabela_preco.js"></script>
<link rel="stylesheet" type="text/css" href="estilodatagrid.css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
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
         <p align="right"><font face="Arial" size="2" color="#FFFFFF"><b>Elabora Lista de Entrega Com Leitora</b></font></td>
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
  <form name="formulario" method="POST" action="atualiza_tb_terceiro.php" border="20">
  <div align="center">
  <div id="avisos">
  <table id="minhaTabela" cellpadding="1" cellspacing="1">
		<tr>
            <?php $nome_entrega  =$_SESSION['nome_entrega_m'];?>
			<td colspan="5" id="titulo"><strong>TABELA PREÇO DE :<?php echo "$nome_entrega";?></strong></td>
		</tr>
		<tr id="cabecalho">
			<td id="controle"><strong>CON</strong></td>
			<td id="servico"><strong>SERVIÇO</strong></td>
			<td id="classe_cep"><strong>CLASSE CEP</strong></td>
			<td id="valor"><strong>R$ VALOR</strong></td>
			<td id="editar"><strong>&nbsp;</strong></td>
			<td id="excluir"><strong>&nbsp;</strong></td>
		</tr>
  <?php
    $entregador  =$_SESSION['entrega_m'];
    $con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
    $res = mysql_select_db($banco_d) or die ("Banco de dados inexistente");
    $lista = "SELECT tb_terceiro.controle,serv_ati.descri_se,
    tb_terceiro.nome_classe,tb_terceiro.valor
    FROM tb_terceiro,cli_for,serv_ati
    WHERE ((tb_terceiro.repre=cli_for.cnpj_cpf)
    AND (tb_terceiro.tipo_servi=serv_ati.codigo_se)
    AND (tb_terceiro.repre='$entregador'))
    ORDER BY cli_for.nome,serv_ati.descri_se,tb_terceiro.nome_classe";
    $query = mysql_db_query($banco_d,$lista,$con) or die ("Não foi possivel acessar o banco 2");
    $total = mysql_num_rows($query);

    for($i=0; $i<$total; $i++){
    	$dados = mysql_fetch_row($query);
    	$controle   = $dados[0];
    	$servico    = $dados[1];
    	$classe_cep = $dados[2];
    	$valor      = $dados[3];
    	$idLinha = "linha$i";
    	echo '<tr id="'.$idLinha.'">';
    	echo '<td class="linhas" align="center">'.$controle.'</td>';
    	echo "<td class=\"linhas\">$servico</td>";
    	echo "<td class=\"linhas\">$classe_cep</td>";
    	echo "<td class=\"linhas\">$valor</td>";
    	echo "<td class=\"linhas\"><a href=\"#\" onclick=\"EditarLinha('$idLinha', '$controle');\"><img src=\"images/editar.gif\" alt=\"Editar\" title=\"Editar\"></a></td>";
    	echo "<td class=\"linhas\"><a href=\"#\" onclick=\"ExcluirLinha('$idLinha', '$controle');\"><img src=\"images/excluir.gif\" alt=\"Excluir\" title=\"Excluir\"></a></td>";
    }
  ?>
</table>

  <table width="70%" border="1" cellpadding="5" cellspacing="0" bordercolor="#6495ED">
     <tr>
       <td>Selecione o Entregador :</td>
       <td>
		  <?php
              mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
              mysql_select_db($banco_d) or die ("Banco de dados inexistente");
              ?>
              <select name="entregador">
              <?php
               $resultado ="SELECT cnpj_cpf,nome FROM cli_for WHERE catego='F'";
               $resul = mysql_db_query($banco_d,$resultado,$con) or die ("Não foi possivel acessar o banco");
               while ( $linha = mysql_fetch_array($resul)) {
                  $select = $entregador == $linha[0] ? "selected" : "";
                  echo "<option value=\"". $linha[0] . "\" $select>" . $linha[0] . "-" . $linha[1] . "</option>";
               }
              ?>
              </select>
              <input name="mostra" type="submit" value="Selecione o entregador."></td>
          <?php
          ?>
        </td>
      </tr>
      <tr>
		 <td colspan="2">
			 <div align="right">
				<input name="gera" type="submit" value="Gerar">
			 </div>
		 </td>
	  </tr>
  </table>
</form>
</div>
</body>
</html>
