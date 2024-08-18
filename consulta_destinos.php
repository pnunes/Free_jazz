<?php
  session_start();

   //carrega variaveis com dados para acessar o banco de dados

  $base_d     =$_SESSION['base_d'];
  $banco_d    =$_SESSION['banco_d'];
  $usuario_d  =$_SESSION['usuario_d'];
  $senha_d    =$_SESSION['senha_d'];

  $matricula_m  =$_SESSION['matricula_m'];
  $programa='049';
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
  <title>consulta_destinos.php</title>
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
         <p align="right"><font face="Arial" size="2" color="#FFFFFF"><b>Destinos - Alteração</b></font></td>
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

           break;
         default:
     }
  ?>

  <body leftmargin="10" topmargin="10" marginwidth="10" marginheight="10">
  <form name="cadastro" action="consulta_destinos.php" method="post" onSubmit="return validaForm()">
	<table width="50%" border="1" cellpadding="5" cellspacing="0" bordercolor="#4169E1">
		<tr>
			<td><b>Nome :</b></td>
			<td><input type="text" name="nome_desti" value ="<?php echo "$nome_desti";?>" size="50" maxlength="50" id="nome_desti"class="input_forms"/><input name="localiza" type="submit" value="Busca Dados Destino"></td>
		</tr>
		<tr>
           <td><b>Codigo :</b></td>
           <td><?php echo "$codigo_desti";?></td>
		</tr>
		<tr>
           <td><b>CEP:</b> </td>
           <td><?php echo "$cep";?></td>
        </tr>
		<tr>
			<td><b>Rua :</b></td>
			<td><?php echo "$rua_desti";?></td>
		</tr>
		<tr>
			<td><b>Número :</b></td>
			<td><?php echo "$numero_desti";?></td>
		</tr>
		<tr>
			<td><b>Bairro :</b></td>
			<td><?php echo "$bairro_desti";?></td>
		</tr>
		<tr>
			<td><b>Cidade :</b></td>
			<td><?php echo "$cidade_desti";?></td>
		</tr>
        <tr>
           <td><b>Estado :</b></td>
           <td><?php echo "$estado_desti";?></td>
        </tr>
		<tr>
			<td><b>Telefones :</b></td>
			<td><?php echo "$fone_desti";?></td>
		</tr>
        <tr>
          <td><b>Data cadastro :</b></td>
          <td><?php echo "$v_dt_atu_cada";?></td>
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

