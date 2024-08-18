<?php
  session_start();

//carrega variaveis com dados para acessar o banco de dados

  $base_d     =$_SESSION['base_d'];
  $banco_d    =$_SESSION['banco_d'];
  $usuario_d  =$_SESSION['usuario_d'];
  $senha_d    =$_SESSION['senha_d'];

  $matricula_m  =$_SESSION['matricula_m'];
  $programa='33';
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
  <title>Exclui_movimento_custodia.php</title>
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
         <p align="right"><font face="Arial" size="2" color="#FFFFFF"><b>Exclui Movimento de Cliente</b></font></td>
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
     <form method="POST" action="exclui_movimento_custodia.php" border="20">
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
             <input name="mostra" type="submit" value="Mostra">
            </td>
           </tr>
     </form>
  </table>
  <?php
  
       switch (get_post_action('exclui','mostra','seleciona')) {
         case 'mostra':
         
           //Pega dados do cliente para mostrar
             $codi_cli            =$_POST['cliente'];
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
         break;

         case 'seleciona':

                $nu_movi               =$_POST['nu_movi'];
                $_SESSION['nu_movi_c'] =$nu_movi;
             
               // echo "Controle :$nu_movi";
             
                //Localiza a custodia em nome do cliente informado - na tabela CUSTODIA
             
                $con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
                $res = mysql_select_db($banco_d) or die ("Banco de dados inexistente");
             
                $verifi="SELECT controle,codi_cli,codi_custo,codi_desti,vl_movi,v_tarifa,
                date_format(dt_movi,'%d/%m/%Y'),qtdade_movi,estoque_fatura,tipo_movi,
                date_format(dt_inicio,'%d/%m/%Y')
                FROM movi_custodia
                WHERE controle='$nu_movi'";
                $query = mysql_db_query($banco_d,$verifi,$con) or die ("Não foi possivel acessar o banco");
                $total = mysql_num_rows($query);
                for($ic=0; $ic<$total; $ic++){
                   $mostra = mysql_fetch_row($query);
                   $controle       = $mostra[0];
                   $codi_cli       = $mostra[1];
                   $codi_custo     = $mostra[2];
                   $codi_desti     = $mostra[3];
                   $vl_movi        = $mostra[4];
                   $v_tarifa       = $mostra[5];
                   $dt_movi        = $mostra[6];
                   $qtdade_movi    = $mostra[7];
                   $estoque_fatura = $mostra[8];
                   $tipo_movi      = $mostra[9];
                   $dt_inicio      = $mostra[10];
                }
                  
                $_SESSION['valor_movi']    =$vl_movi;
                $_SESSION['qtd_movi']      =$qtdade_movi;
                $_SESSION['dt_inicio']     =$dt_inicio;
                $vl_movi  = number_format($vl_movi , 2, ',', '.');
                $v_tarifa = number_format($v_tarifa, 2, ',', '.');
                $estoque_fatura = number_format($estoque_fatura, 2, ',', '.');
                $nome_cli   =$_SESSION['nomecli'];
                $_SESSION['codi_custo_c']   =$codi_custo;
                $_SESSION['tipo_movi_c']    =$tipo_movi;

         break;

         case 'exclui':
             $controle_a      =$_SESSION['nu_movi_c'];
             $codi_custo      =$_SESSION['codi_custo_c'];
             $tipo_movi       =$_SESSION['tipo_movi_c'];
             $vl_movi         =$_SESSION['valor_movi'];
             $qtdade_movi     =$_SESSION['qtd_movi'];
             $codi_cli        =$_SESSION['codicli'];
             $dt_inicio       =$_SESSION['dt_inicio'];
             
             //echo "Controle :$controle_a";
             
             //Exclui o movimento na tabela MOVI-CUSTODIA
             
             $con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
             $res = mysql_select_db($banco_d) or die ("Banco de dados inexistente");

             $exclusao = "DELETE FROM movi_custodia WHERE controle='$controle_a'";

             if (mysql_db_query($banco_d,$exclusao,$con)) {
             
                $resp_grava="Exclusão bem sucedida.";
                
                //Atualiza o estoque na tabela de custodia
                
                $con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
                $res = mysql_select_db($banco_d) or die ("Banco de dados inexistente");

                $verifi="SELECT controle,qtdade_esto,vl_estoque
                FROM custodia WHERE ((codi_cli='$codi_cli')
                AND (codi_custo='$codi_custo'))";
                $query = mysql_db_query($banco_d,$verifi,$con) or die ("Não foi possivel acessar o banco");
                $total = mysql_num_rows($query);

                for($ic=0; $ic<$total; $ic++){
                   $mostra = mysql_fetch_row($query);
                   $controle_c        = $mostra[0];
                   $qtdade_esto_c     = $mostra[1];
                   $vl_estoque_c      = $mostra[2];
                }

                //////Calcula o estoque para atualizar as tabelas CUSTODIA /////////

                if ($tipo_movi=='S') {
                   $v_estoque       =$vl_estoque_c+$vl_movi;
                   $qtd_esto        =$qtdade_esto_c+$qtdade_movi;
                }
                if ($tipo_movi=='E') {
                   $v_estoque       =$vl_estoque_c-$vl_movi;
                   $qtd_esto        =$qtdade_esto_c-$qtdade_movi;
                }

               /// alterando o formato dos valores para guardar no banco

                if (strlen($v_estoque)>=6) {
                  $v_estoque         = str_replace(".", "", $v_estoque);
                  $v_estoque         = str_replace(",", ".", $v_estoque);
                }
                if (strlen($v_estoque)<6) {
                  $v_estoque         = str_replace(",", ".", $v_estoque);
                }
                
                //Altera formata data de registro da custodia para guardar no banco
                $dt_inicio  = explode("/",$dt_inicio);
                $dt_registro = $dt_inicio[2]."-".$dt_inicio[1]."-".$dt_inicio[0];
                
                $alteracao="UPDATE custodia SET qtdade_esto='$qtd_esto',vl_estoque='$v_estoque',
                dt_movi='$dt_registro'
                WHERE controle='$controle_c'";
                mysql_db_query($banco_d,$alteracao,$con);
                
                $codi_cli        ='';
                $nome_cli        ='';
                $qtdade_movi     ='';
                $vl_movi         ='';
                $tipo_movi       ='';
                $v_tarifa        ='';
                $estoque_fatura  ='';
                $dt_movi         ='';
                $dt_inicio       ='';
                unset($_SESSION['nu_movi_c']);
                unset($_SESSION['codi_custo_c']);
                unset($_SESSION['tipo_movi_c']);
                unset($_SESSION['valor_movi']);
                unset($_SESSION['qtd_movi']);
                unset($_SESSION['codicli']);
                unset($_SESSION['dt_inicio']);
                unset($_SESSION['controle_c']);
             }
             else {
                $resp_grava="Problemas na Exclusão.";
             }
            break;
         default:
     }
  ?>

  <body leftmargin="10" topmargin="10" marginwidth="10" marginheight="10">
  <form name="cadastro" action="exclui_movimento_custodia.php" method="post">
	<table width="60%" border="1" cellpadding="5" cellspacing="0" bordercolor="#4169E1">
        <tr>
			<td><b>Cliente :</b></td>
			<td><?php echo "$codi_cli";?> - <?php echo "$nome_cli";?></td>
		</tr>
        <tr>
            <td><b>Movimento Excluir :</b></td>
            <td>
            <?php
               mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
               mysql_select_db($banco_d) or die ("Banco de dados inexistente");

               $resultado = mysql_query ("SELECT movi_custodia.controle,
               destino.nome_desti,movi_custodia.qtdade_movi,tipo_movi
               FROM movi_custodia,destino
               WHERE ((movi_custodia.codi_desti=destino.codigo_desti)
               AND (movi_custodia.codi_cli='$codi_cli'))");
               
               echo "<select name='nu_movi' class='caixa'>\n";
               while($linha = mysql_fetch_row($resultado))  {
                  printf("<option value='$linha[0]'>$linha[0] - $linha[1] - $linha[2] - $linha[3]</option>\n");
               }
            ?>
            <script language="javascript">
                 Seleciona = function( itemSelecionar){
                  var _nu_movi = document.getElementById("nu_movi");
                  for ( i =0; i < _nu_movi.length; i++){
                    _nu_movi[i].selected = _nu_movi[i].value == itemSelecionar ? true : false;
                  }
                 }
                 Seleciona(<?php echo "$nu_movi";?>);
            </script>
            <input name="seleciona" type="submit" value="Seleciona">
            </td>
        </tr>
		<tr>
           <td><b>Quantidade :</b></td>
             <td><?php echo "$qtdade_movi";?></td>
        </tr>
        <tr>
           <td><b>Valor Movimento :</b></td>
             <td><?php echo "$vl_movi";?></td>
        </tr>
        <tr>
           <td><b>Tipo Movimento :</b></td>
           <td><?php echo "$tipo_movi";?></td>
        </tr>
        <tr>
           <td><b>Tarifa :</b></td>
             <td><?php echo "$v_tarifa";?></td>
        </tr>
        <tr>
           <td><b>Base Faturamento:</b></td>
             <td><?php echo "$estoque_fatura";?></td>
        </tr>
        <tr>
           <td><b>Data Movimento:</b></td>
           <td><?php echo "$dt_movi";?></td>
        </tr>
        <tr>
           <td><b>Data Base:</b></td>
           <td><?php echo "$dt_inicio";?></td>
        </tr>
		<tr>
			<td colspan="2">
				<div align="right">
				<input name="exclui" type="submit" value="Excluir">
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

