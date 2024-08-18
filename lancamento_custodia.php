<?php
  session_start();

//carrega variaveis com dados para acessar o banco de dados

  $base_d     =$_SESSION['base_d'];
  $banco_d    =$_SESSION['banco_d'];
  $usuario_d  =$_SESSION['usuario_d'];
  $senha_d    =$_SESSION['senha_d'];

  $matricula_m  =$_SESSION['matricula_m'];
  $programa='30';
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
  <title>Lancamento_custodia.php</title>
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
         <p align="right"><font face="Arial" size="2" color="#FFFFFF"><b>Cadastro de Custódia Por Cliente</b></font></td>
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
     <tr>
       <td>
         <form method="POST" action="lancamento_custodia.php" border="20">
            <?php
               echo "<center><Font size=\"2\" face=\"ARIAL\">Selecione o Cliente...:</font>";
               $codi_cli     =$_SESSION['codicli'];
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
             <input name="mostra" type="submit" value="Mostra">
            </td>
           </tr>
         </form>
  </table>
  <?php
  
     $cnpj_cpf        =$_SESSION['codicli'];
     $nome            =$_SESSION['nome_cli'];
  
     switch (get_post_action('grava','mostra','calcula')) {
         case 'mostra':

             $codi_cli            =$_POST['cliente'];
             if ($codi_cli<>$_SESSION['codicli']) {
                 unset($_SESSION['codicli']);
                 unset($_SESSION['nome_cli']);
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
               $cnpj_cpf     = $mostra[0];
               $nome         = $mostra[1];
             }
             $_SESSION['nome_cli']=$nome;
             
             break;

         case 'calcula':
             $codi_cli        =$_SESSION['codicli'];
             $codi_custo      =$_POST['codi_custo'];
             
             //REcupera dados do cliente para constinuar aparecendo no formulário
             
             $cnpj_cpf        =$_SESSION['codicli'];
             $nome            =$_SESSION['nome_cli'];
             
             //Pega valor do unitário do serviço para calcular o total
             
             $verifi="SELECT codigo_se,descri_se,valor
             FROM serv_ati WHERE codigo_se='$codi_custo'";
             
             $query = mysql_db_query($banco_d,$verifi,$con) or die ("Não foi possivel acessar o banco");
             $total = mysql_num_rows($query);

             for($ic=0; $ic<$total; $ic++){
               $mostra = mysql_fetch_row($query);
               $codi_custo     = $mostra[0];
               $descri_custo   = $mostra[1];
               $valor_custo    = $mostra[2];
             }
             
             $verifi="SELECT codi_cli,codi_custo FROM custodia WHERE ((codi_cli='$codi_cli')
             AND (codi_custo='$codi_custo'))";
             $query = mysql_db_query($banco_d,$verifi,$con) or die ("Não foi possivel acessar o banco");
             $achou = mysql_num_rows($query);

             If ($achou > 0 ) {
             ?>
             <script language="javascript"> window.location.href=("entrada.php")
                alert('Já existe no cadastro o tipo de custódia e cliente informados.');
             </script>
             <?php
             }
             else {
                $cnpj_cpf                   =$_SESSION['codicli'];
                $nome                       =$_SESSION['nome_cli'];
                $_SESSION['descri_custo']   =$descri_custo;
                $_SESSION['tarifa']         =$valor_custo;
                $qtdade                     =$_POST['qtdade'];
                $c_valor                    =($qtdade*$valor_custo);
                $valor = number_format($valor, 2, ',', '.');
             }
            break;

         case 'grava':
             $codi_cli        =$_SESSION['codicli'];
             $codi_custo      =$_POST['codi_custo'];
             $descri_custo    =$_SESSION['descri_custo'];
             $g_valor         =$_POST['valor'];
             $valor_custo     =$_POST['v_tarifa'];
             $qtdade          =$_POST['qtdade'];
             $dt_registro     =$_POST['dt_registro'];
             
             // alterando o formato dos valores para guardar no banco
             if (strlen($valor)>=6) {
                 $g_valor         = str_replace(".", "", $g_valor);
                 $g_valor         = str_replace(",", ".", $g_valor);
              }
              if (strlen($valor)<6) {
                 $g_valor         = str_replace(",", ".", $g_valor);
              }
             if (strlen($valor_custo)>=6) {
                 $valor_custo         = str_replace(".", "", $valor_custo);
                 $valor_custo         = str_replace(",", ".", $valor_custo);
              }
              if (strlen($valor_custo)<6) {
                 $valor_custo         = str_replace(",", ".", $valor_custo);
              }
             
             //Altera formata data de registro da custodia para guardar no banco
             $dt_registro  = explode("/",$dt_registro);
             $v_dt_registro = $dt_registro[2]."-".$dt_registro[1]."-".$dt_registro[0];
             
             $con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
             $res = mysql_select_db($banco_d) or die ("Banco de dados inexistente");



             $inclusao = "INSERT INTO custodia(codi_cli,codi_custo,descri_custo,v_tarifa,qtdade_esto,vl_estoque,dt_registro,dt_movi)
             values('$codi_cli','$codi_custo','$descri_custo','$valor_custo','$qtdade','$g_valor','$v_dt_registro',$v_dt_registro')";

             if (mysql_db_query($banco_d,$inclusao,$con)) {
                $resp_grava="Inclusão bem sucedida.";
                
                $codi_cli        ='';
                $codi_custo      ='';
                $descri_custo    ='';
                $valor           ='';
                $valor_custo     ='';
                $qtdade          ='';
                $dt_registro     ='';
             }
             else {
                $resp_grava="Problemas na Inclusão.";
             }
            break;
         default:
     }
  ?>

  <body leftmargin="10" topmargin="10" marginwidth="10" marginheight="10">
  <form name="cadastro" action="lancamento_custodia.php" method="post">
	<table width="80%" border="1" cellpadding="5" cellspacing="0" bordercolor="#4169E1">
        <tr>
			<td><b>Codigo Cliente :</b></td>
			<td><?php echo "$cnpj_cpf";?></td>
		</tr>
		<tr>
			<td><b>Nome Cliente :</b></td>
			<td><?php echo "$nome";?></td>
		</tr>
        <tr>
		  <td><b>Tipo Custódia :</b></td>
           <td>
			  <?php
               mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
               mysql_select_db($banco_d) or die ("Banco de dados inexistente");

               $resultado = mysql_query ("SELECT codigo_se,descri_se,valor
               FROM serv_ati
               ORDER BY descri_se");
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
           <td><b>Quantidade :</b></td>
             <td><input type="text" name="qtdade" value ="<?php echo "$qtdade";?>" size="8" maxlength="8" id="qtdade"></td>
        </tr>
        <tr>
           <td><b>Tarifa :</b></td>
             <td><input type="text" name="v_tarifa" value ="<?php echo "$valor_custo";?>" size="8" maxlength="8" id="v_tarifa" onchange="Formata(this,20,event,2)"></td>
        </tr>
        <tr>
           <td><b>Valor :</b></td>
             <td><input type="text" name="valor" value ="<?php echo "$c_valor";?>" size="8" maxlength="8" id="valor" onchange="Formata(this,20,event,2)">
             <input name="calcula" type="submit" value="Calcula Valor"></td>
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

