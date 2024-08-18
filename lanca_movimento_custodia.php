<?php
  session_start();

//carrega variaveis com dados para acessar o banco de dados

  $base_d     =$_SESSION['base_d'];
  $banco_d    =$_SESSION['banco_d'];
  $usuario_d  =$_SESSION['usuario_d'];
  $senha_d    =$_SESSION['senha_d'];

  $matricula_m  =$_SESSION['matricula_m'];
  $programa='32';
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

include ("campo_calendario.php");
?>
<html>
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
  <title>Lanca_movimento_custodia.php</title>
  <head>
  <body>
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
         <p align="right"><font face="Arial" size="2" color="#FFFFFF"><b>Lançamento do Movimento de Custodia</b></font></td>
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
  <table width="900" heigth="300" align="center">
     <form method="POST" action="lanca_movimento_custodia.php" border="20">
          <tr>
            <td>
            <?php
               echo "<center><Font size=\"2\" face=\"ARIAL\">Selecione o Cliente...:</font>";
               //$codi_cli     =$_SESSION['codicli'];
               mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
               mysql_select_db($banco_d) or die ("Banco de dados inexistente");

               $resultado = mysql_query ("SELECT cnpj_cpf,nome
               FROM cli_for ORDER BY nome");
               echo "<select name='cliente' class='caixa' align=\"center\">\n";
               while($linha = mysql_fetch_row($resultado))  {
                  printf("<option value='$linha[0]'>$linha[0] - $linha[1] </option>\n");
               }
            ?>
            <script language="javascript">
                 Seleciona = function( itemSelecionar){
                  var _cliente = document.getElementById("cliente");
                  for ( i =0; i < _cliente.length; i++){
                    _cliente[i].selected = _cliente[i].value == itemSelecionar ? true : false;
                  }
                 }
                 Seleciona(<?php echo "$codi_cli";?>);
             </script>
            </td>
           </tr>
           <tr>
            <td>
            <?php
               echo "<center><Font size=\"2\" face=\"ARIAL\">Selecione Empresa Destino...:</font>";
               //$emp_desti     =$_SESSION['emp_desti'];
               mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
               mysql_select_db($banco_d) or die ("Banco de dados inexistente");

               $resultado = mysql_query ("SELECT codigo_desti,nome_desti
               FROM destino ORDER BY nome_desti");
               echo "<select name='emp_desti' class='caixa' align=\"center\">\n";
               while($linha = mysql_fetch_row($resultado))  {
                  printf("<option value='$linha[0]'>$linha[0] - $linha[1] </option>\n");
               }
            ?>
            <script language="javascript">
                 Seleciona = function( itemSelecionar){
                  var _emp_desti = document.getElementById("emp_desti");
                  for ( i =0; i < _emp_desti.length; i++){
                    _emp_desti[i].selected = _emp_desti[i].value == itemSelecionar ? true : false;
                  }
                 }
                 Seleciona(<?php echo "$emp_desti";?>);
             </script>
             <input name="mostra" type="submit" value="Mostra">
            </td>
           </tr>
     </form>
  </table>
  <?php
  
    // $codi_cli        =$_SESSION['codicli'];
   //  $nome_cli        =$_SESSION['nome_cli'];
  
     switch (get_post_action('grava','mostra','calcula')) {
         case 'mostra':
         
           //Pega dados do cliente para mostrar
             $codi_cli            =$_POST['cliente'];
             if ($codi_cli<>$_SESSION['codicli']) {
                 unset($_SESSION['codicli']);
                 unset($_SESSION['nomecli']);
             }
             
             $_SESSION['codicli'] =$_POST['cliente'];
             
             $resp_grava='';
             
             $con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
             $res = mysql_select_db($banco_d) or die ("Banco de dados inexistente");

             $verifi="SELECT cnpj_cpf,nome
             FROM cli_for WHERE cnpj_cpf='$codi_cli'";
             $query = mysql_db_query($banco_d,$verifi,$con) or die ("Não foi possivel acessar o banco");
             $total = mysql_num_rows($query);

             for($ic=0; $ic<$total; $ic++){
               $mostra = mysql_fetch_row($query);
               $codi_cli      = $mostra[0];
               $nome_cli      = $mostra[1];
             }
             $_SESSION['nomecli']=$nome_cli;
             
         //Pega dados da empresa destino para mostrar
             $emp_destino       =$_POST['emp_desti'];
             if ($emp_desti<>$_SESSION['emp_desti']) {
                 unset($_SESSION['emp_desti']);
                 unset($_SESSION['nome_emp_desti']);
             }

             $_SESSION['emp_desti'] =$_POST['emp_desti'];

             $resp_grava='';

             $con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
             $res = mysql_select_db($banco_d) or die ("Banco de dados inexistente");

             $verifi="SELECT codigo_desti,nome_desti
             FROM destino WHERE codigo_desti='$emp_destino'";
             $query = mysql_db_query($banco_d,$verifi,$con) or die ("Não foi possivel acessar o banco");
             $total = mysql_num_rows($query);

             for($ic=0; $ic<$total; $ic++){
               $mostra = mysql_fetch_row($query);
               $emp_destino      = $mostra[0];
               $nome_emp_destino = $mostra[1];
             }
             $_SESSION['nome_emp_desti']=$nome_emp_destino;

         break;

         case 'calcula':
         
             $codigo_custo      =$_POST['codi_custo'];
             $qtdade_movi       =$_POST['qtdade_movi'];
             $tipo_movi         =$_POST['tipo_movi'];
             $regi_dep          =$_POST['regi_dep'];
             if ($qtdade_movi=='') {
                ?>
                  <script language="javascript">
                    alert('Você precisa informar uma quantidade valida para o movimento.');
                  </script>
               <?php
             }
             else {
                //Recupera dados do cliente para constinuar aparecendo no formulário
             
                $codi_cli        =$_SESSION['codicli'];
                $nome_cli        =$_SESSION['nomecli'];
             
                $emp_destino       =$_SESSION['emp_desti'];
                $nome_emp_destino  =$_SESSION['nome_emp_desti'];
             
                //Localiza a custodia em nome do cliente informado - na tabela CUSTODIA
             
                $con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
                $res = mysql_select_db($banco_d) or die ("Banco de dados inexistente");
             
                $verifi="SELECT codi_cli,codi_custo,qtdade_esto,v_tarifa,date_format(dt_movi,'%d/%m/%Y'),
                vl_estoque,date_format(dt_registro,'%d/%m/%Y'),controle
                FROM custodia
                WHERE ((codi_cli='$codi_cli')
                AND (codi_custo='$codigo_custo'))";
                $query = mysql_db_query($banco_d,$verifi,$con) or die ("Não foi possivel acessar o banco");
                $total = mysql_num_rows($query);

                If ($achou = 0 ) {
                   ?>
                     <script language="javascript"> window.location.href=("entrada.php")
                       alert('Não existe no cadastro a custodia para o cliente informado.');
                     </script>
                   <?php
                }
                else {
                  for($ic=0; $ic<$total; $ic++){
                      $mostra = mysql_fetch_row($query);
                      $codi_cli       = $mostra[0];
                      $codigo_custo   = $mostra[1];
                      $qtdade_esto    = $mostra[2];
                      $v_tarifa       = $mostra[3];
                      $dt_movi        = $mostra[4];
                      $vl_estoque     = $mostra[5];
                      $dt_registro    = $mostra[6];
                      $controle_cus   = $mostra[7];
                  }
                  $_SESSION['tarifa']      =$v_tarifa;
                  $_SESSION['controle_c']  =$controle_cus;
                  $_SESSION['v_estoque']   =$vl_estoque;
                  $_SESSION['q_estoque']   =$qtdade_esto;
                  $_SESSION['dt_movi_c']   =$dt_movi;
                  $_SESSION['tipo_movi_c'] =$tipo_movi;
                  
                  $c_valor=($qtdade_movi*$v_tarifa);
                  
                  $v_tarifa = number_format($v_tarifa, 2, ',', '.');
                  $vl_estoque = number_format($vl_estoque, 2, ',', '.');
                  $c_valor = number_format($c_valor, 2, ',', '.');
                }
             }
         break;

         case 'grava':
             $codi_cli        =$_SESSION['codicli'];
             $codi_custo      =$_POST['codi_custo'];
             $g_valor         =$_POST['valor'];
             $v_tarifa        =$_SESSION['tarifa'];
             $qtdade          =$_POST['qtdade_movi'];
             $dt_registro     =$_POST['dt_registro'];
             $controle        =$_SESSION['controle_c'];
             $e_destino       =$_SESSION['emp_desti'];
             $dt_movi         =$_SESSION['dt_movi_c'];
             $tipo_movi       =$_SESSION['tipo_movi_c'];
             $regi_dep        =$_POST['regi_dep'];
             
     /////////////Calcula o novo estoque para atualizar as tabelas CUSTODIA e MOVI_CUSTODIA /////////
             
             if ($tipo_movi=='S') {
                $v_estoque_fatu  =$_SESSION['v_estoque']-$g_valor;
                $n_estoque       =$_SESSION['v_estoque']-$g_valor;
                $qtd_esto        =$_SESSION['q_estoque']-$qtdade;
              }
             if ($tipo_movi=='E') {
                $v_estoque_fatu  =$_SESSION['v_estoque']+$g_valor;
                $n_estoque       =$_SESSION['v_estoque']+$g_valor;
                $qtd_esto        =$_SESSION['q_estoque']+$qtdade;
                $e_destino       ='000000';
              }
              
             // alterando o formato dos valores para guardar no banco
             if (strlen($valor)>=6) {
                 $g_valor         = str_replace(".", "", $g_valor);
                 $g_valor         = str_replace(",", ".", $g_valor);
              }
              if (strlen($valor)<6) {
                 $g_valor         = str_replace(",", ".", $g_valor);
              }
             if (strlen($v_tarifa)>=6) {
                 $v_tarifa         = str_replace(".", "", $v_tarifa);
                 $v_tarifa         = str_replace(",", ".", $v_tarifa);
              }
              if (strlen($v_tarifa)<6) {
                 $v_tarifa         = str_replace(",", ".", $v_tarifa);
              }
             
              if (strlen($v_estoque_fatu)>=6) {
                 $v_estoque_fatu         = str_replace(".", "", $v_estoque_fatu);
                 $v_estoque_fatu         = str_replace(",", ".", $v_estoque_fatu);
              }
              if (strlen($v_estoque_fatu)<6) {
                 $v_estoque_fatu         = str_replace(",", ".", $v_estoque_fatu);
              }
             
             //Altera formata data de registro da custodia para guardar no banco
             $dt_registro  = explode("/",$dt_registro);
             $v_dt_registro = $dt_registro[2]."-".$dt_registro[1]."-".$dt_registro[0];
             
             $dt_movi  = explode("/",$dt_movi);
             $v_dt_movi = $dt_movi[2]."-".$dt_movi[1]."-".$dt_movi[0];
             
             //Insere o movimento na tabela MOVI-CUSTODIA
             $con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
             $res = mysql_select_db($banco_d) or die ("Banco de dados inexistente");

             $inclusao = "INSERT INTO movi_custodia(codi_cli,codi_custo,codi_desti,vl_movi,
             v_tarifa,estoque_fatura,dt_movi,dt_inicio,qtdade_movi,tipo_movi,escritorio)
             VALUES('$codi_cli','$codi_custo','$e_destino','$g_valor',
             '$v_tarifa','$v_estoque_fatu','$v_dt_registro','$v_dt_movi','$qtdade',
             '$tipo_movi','$regi_dep')";

             if (mysql_db_query($banco_d,$inclusao,$con)) {
                $resp_grava="Inclusão bem sucedida.";
                
                //Atualiza a tabela de custodias
                
                $alteracao="UPDATE custodia SET qtdade_esto='$qtd_esto',vl_estoque='$n_estoque',
                dt_movi='$v_dt_registro'
                WHERE controle='$controle'";
                mysql_db_query($banco_d,$alteracao,$con);
                
                $codi_custo      ='';
                $g_valor         ='';
                $qtdade          ='';
                $dt_movi         ='';
                $v_tarifa        ='';
                $regi_dep        ='';
                unset($_SESSION['controle_c']);
                unset($_SESSION['v_estoque']);
                unset($_SESSION['q_estoque']);
             }
             else {
                $resp_grava="Problemas na Inclusão.";
             }
            break;
         default:
     }
  ?>

  <body leftmargin="10" topmargin="10" marginwidth="10" marginheight="10">
  <form name="cadastro" action="lanca_movimento_custodia.php" method="post">
	<table width="70%" border="1" cellpadding="5" cellspacing="0" bordercolor="#4169E1">
        <tr>
			<td><b>Cliente :</b></td>
			<td><?php echo "$codi_cli";?> - <?php echo "$nome_cli";?></td>
		</tr>
		<tr>
			<td><b>Empresa Destino :</b></td>
			<td><?php echo "$emp_destino";?> - <?php echo "$nome_emp_destino";?></td>
		</tr>
        <tr>
		  <td><b>Tipo Custódia :</b></td>
           <td>
			  <?php
               mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
               mysql_select_db($banco_d) or die ("Banco de dados inexistente");

               $resultado = mysql_query ("SELECT codi_custo,descri_custo,qtdade_esto
               FROM custodia
               WHERE codi_cli='$codi_cli'");
               echo "<select name='codi_custo' class='caixa' align=\"left\">\n";
               while($linha = mysql_fetch_row($resultado))  {
                 printf("<option value='$linha[0]'>$linha[0] - $linha[1] - $linha[2] </option>\n");
                 }
              ?>
              <script language="javascript">
                 Seleciona = function( itemSelecionar){
                  var _codi_custo = document.getElementById("codi_custo");
                  for ( i =0; i < _codi_custo.length; i++){
                    _codi_custo[i].selected = _codi_custo[i].value == itemSelecionar ? true : false;
                  }
                 }
                 Seleciona(<?php echo "$codi_custo";?>);
             </script>
           </td>
		</tr>
		<tr>
           <td><b>Estoque :</b></td>
             <td><?php echo "$qtdade_esto";?></td>
        </tr>
		<tr>
           <td><b>Quantidade :</b></td>
             <td><input type="text" name="qtdade_movi" value ="<?php echo "$qtdade_movi";?>" size="8" maxlength="8" id="qtdade_movi"></td>
        </tr>
        <tr>
           <td><b>Tipo Movimento :</b></td>
           <td>
           <SELECT NAME="tipo_movi" SIZE="1">
               <OPTION VALUE="S">Saida</OPTION>
               <OPTION VALUE="E">Entrada</OPTION>
           </SELECT>
           </td>
        </tr>
        <tr>
           <td><b>Tarifa :</b></td>
             <td><?php echo "$v_tarifa";?></td>
        </tr>
        <tr>
           <td><b>Valor Estoque:</b></td>
             <td><?php echo "$vl_estoque";?></td>
        </tr>
        <tr>
           <td><b>Valor Movimento:</b></td>
           <td><input type="text" name="valor" value ="<?php echo "$c_valor";?>" size="8" maxlength="8" id="valor" onchange="Formata(this,20,event,2)">
           <input name="calcula" type="submit" value="Calcula Valor"></td>
        </tr>
        <tr>
           <td><b>Ultimo Movimento :</b></td>
             <td><?php echo "$dt_movi";?></td>
        </tr>
        <tr>
          <td><b>Data Lançamento :</b></td>
          <td>
            <input type="text" name="dt_registro" size="12" maxlength="12" id="dt_registro">
            <input TYPE="button" NAME="btndt_registro" VALUE="..." Onclick="javascript:popdate('document.cadastro.dt_registro','pop1','150',document.cadastro.dt_registro.value)">
            <span id="pop1" style="position:absolute"></span>
          </td>
        </tr>
		<tr>
			<td colspan="2">
				<div align="right">
				<input name="grava" type="submit" value="Gravar">
				</div>
			</td>
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
       <td color="white" align="left" width="100%" height="30">
     </tr>
  </table>
  <table border="0" width="100%" cellspacing="0" cellpadding="0" background="img/blue.jpg">
      <tr>
        <td width="100%" height="25" align="center"></font><font color="white" size="1" face="Arial">©&nbsp; COPYRIGHT NUNESTECH Tecnologia em Sistemas Ltda</font></td>
     </tr>
  </table>

</body>
</html>

