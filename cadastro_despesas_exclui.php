<?php
  session_start();

 //carrega variaveis com dados para acessar o banco de dados

  $base_d     =$_SESSION['base_d'];
  $banco_d    =$_SESSION['banco_d'];
  $usuario_d  =$_SESSION['usuario_d'];
  $senha_d    =$_SESSION['senha_d'];

  $codigo_m  =$_SESSION['codigo_m'];
  $programa='19';
  $_SESSION['programa_m']=$programa;
  
  $con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
  $res = mysql_select_db($banco_d) or die ("Banco de dados inexistente");

  $declara = "SELECT matricula,programa
  FROM permissoes
  WHERE ((matricula='$codigo_m') and (programa='$programa'))";

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
  function get_post_action($name) {
    $params = func_get_args();

    foreach ($params as $name) {
        if (isset($_POST[$name])) {
            return $name;
        }
    }
  }
?>
<html>
  <title>Cadastro_despesas_altera.php</title>
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
				color: #efefef; background-color:#FFE4B5; border: 1px solid #DEB887;
				/*border-top-width: 1px; border-right-width: 1px; border-bottom-width: 1px; border-left-width: 1px; */
			}
		}
		textarea { overflow:auto }
	</style>
  </head>
  <div id="geral" align="center">
    <body topmargin="0" leftmargin="0" rightmargin="0" bottommargin="0" marginheight="0" marginwidth="0" bgcolor="#FFFFFF">

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
     switch (get_post_action('exclui','mostra')) {
         case 'mostra':
             $controle                =$_POST['controle'];
             $_SESSION['controle_i']  =$controle;
             
             $resp_grava='';
             $con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
             $res = mysql_select_db($banco_d) or die ("Banco de dados inexistente");

             $verifi="SELECT codigo_despe,valor_gasto,date_format(data_gasto,'%d/%m/%Y'),
             ano,observacao,competencia,beneficiado
             FROM gastos WHERE controle='$controle'";
             $query = mysql_db_query($banco_d,$verifi,$con) or die ("Não foi possivel acessar o banco");
             $total = mysql_num_rows($query);

             for($ic=0; $ic<$total; $ic++){
               $row = mysql_fetch_row($query);
               $codigo_despe         = $row[0];
               $valor_gasto          = $row[1];
               $data_gasto           = $row[2];
               $ano                  = $row[3];
               $observacao           = $row[4];
               $competencia          = $row[5];
               $beneficiado          = $row[6];
             }
             
             //Altera formato para mostrar valor
             $valor_gasto   = number_format($valor_gasto, 2, ',', '.');
           
             break;

         case 'exclui':
             $controle       =$_SESSION['controle_i'];

             $con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
             $res = mysql_select_db($banco_d) or die ("Banco de dados inexistente");

             $alteracao = "DELETE FROM gastos WHERE controle='$controle'";
             
             if (mysql_db_query($banco_d,$alteracao,$con)) {
                $resp_grava="Exclusão bem sucedida";
                $codigo_despe      ='';
                $valor_gasto       ='';
                $data_gasto        ='';
                $competencia       ='';
                $ano               ='';
                $observacao        ='';
                $controle          ='';
                $beneficiado       ='';
                unset($_SESSION['controle_i']);
            }
           else {
             $resp_grava="Problemas na Exclusão";
           }
           break;
         default:
     }
     ?>

   <body leftmargin="10" topmargin="10" marginwidth="10" marginheight="10">
    <form name="cadastro" action="cadastro_despesas_exclui.php" method="post">
       <table width="50%" border="1" cellpadding="5" cellspacing="0" bordercolor="#DEB887">
          <tr>
           <td><b>Selecione a Despesa :</b></td>
           <td>
              <select name="controle">
              <?php
                $con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
                $res = mysql_select_db($banco_d) or die ("Banco de dados inexistente");

                $sql2 = "SELECT gastos.controle,t_item_despesa.descricao,gastos.beneficiado
                FROM gastos,t_item_despesa
                WHERE gastos.codigo_despe=t_item_despesa.codigo";
                $resul = mysql_db_query($banco_d,$sql2,$con) or die ("Não foi possivel acessar o banco");
                while ( $linha = mysql_fetch_array($resul)) {
                    $select = $controle == $linha[0] ? "selected" : "";
                    echo "<option value=\"". $linha[0] . "\" $select>" . $linha[1] . "</option>";
                }
              ?>
              </select>
              <input name="mostra" type="submit" value="Mostra"></center>
           </td>
          </tr>
          <tr>
			<td><b>Tipo Despesa :</b></td>
            <td>
               <select name="codigo_despe">
              <?php
                //$codigo_despe    =$_SESSION['codigo_despe_i'];
                $con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
                $res = mysql_select_db($banco_d) or die ("Banco de dados inexistente");

                $sql2 = "SELECT codigo,descricao FROM t_item_despesa";
                $resul = mysql_db_query($banco_d,$sql2,$con) or die ("Não foi possivel acessar o banco");
                while ( $linha = mysql_fetch_array($resul)) {
                    $select = $codigo_despe == $linha[0] ? "selected" : "";
                    echo "<option value=\"". $linha[0] . "\" $select>" . $linha[1] . "</option>";
                }
              ?>
              </select>
            </td>
		  </tr>
		  <tr>
			<td><b>Nome Beneficiado:</b></td>
			<td><input type="text" name="beneficiado" value ="<?php echo "$beneficiado";?>" size="80" maxlength="80" id="beneficiado"></td>
		  </tr>
		  <tr>
			<td><b>Valor da Despesa :</b></td>
			<td><input name="valor_gasto" type="text" value ="<?php echo "$valor_gasto";?>" size="20" maxlength="20" onKeydown="Formata(this,20,event,2)"></td>
		</tr>
		  <tr>
           <td><b>Mês de Competencia :</b></td>
           <td>
           <select name="competencia">
           <option value="JANEIRO" <?php if ($competencia == "JANEIRO") { echo "selected"; }?>>JANEIRO</option>
           <option value="FEVEREIRO" <?php if ($competencia == "FEVEREIRO") { echo "selected"; }?>>FEVEREIRO</option>
           <option value="MARCO" <?php if ($competencia == "MARCO") { echo "selected"; }?>>MARCO</option>
           <option value="ABRIL" <?php if ($competencia == "ABRIL") { echo "selected"; }?>>ABRIL</option>
           <option value="MAIO" <?php if ($competencia == "MAIO") { echo "selected"; }?>>MAIO</option>
           <option value="JUNHO" <?php if ($competencia == "JUNHO") { echo "selected"; }?>>JUNHO</option>
           <option value="JULHO" <?php if ($competencia == "JULHO") { echo "selected"; }?>>JULHO</option>
           <option value="AGOSTO" <?php if ($competencia == "AGOSTO") { echo "selected"; }?>>AGOSTO</option>
           <option value="SETEMBRO" <?php if ($competencia == "SETEMBRO") { echo "selected"; }?>>SETEMBRO</option>
           <option value="OUTUBRO" <?php if ($competencia == "OUTUBRO") { echo "selected"; }?>>OUTUBRO</option>
           <option value="NOVEMBRO" <?php if ($competencia == "NOVEMBRO") { echo "selected"; }?>>NOVEMBRO</option>
           <option value="DEZEMBRO" <?php if ($competencia == "DEZEMBRO") { echo "selected"; }?>>DEZEMBRO</option>
           </select>
           <input name="mostra" type="submit" value="Mostra"></center>
           </td>
        </tr>
        <tr>
           <td><b>Ano de competência :</b></td>
           <td>
           <SELECT NAME="ano">
               <option value="2011" <?php if ($ano == "2011") { echo "selected"; }?>>2011</option>
               <option value="2012" <?php if ($ano == "2012") { echo "selected"; }?>>2012</option>
               <option value="2013" <?php if ($ano == "2013") { echo "selected"; }?>>2013</option>
               <option value="2014" <?php if ($ano == "2014") { echo "selected"; }?>>2014</option>
               <option value="2015" <?php if ($ano == "2015") { echo "selected"; }?>>2015</option>
               <option value="2016" <?php if ($ano == "2016") { echo "selected"; }?>>2016</option>
               <option value="2017" <?php if ($ano == "2017") { echo "selected"; }?>>2017</option>
               <option value="2018" <?php if ($ano == "2018") { echo "selected"; }?>>2018</option>
               <option value="2019" <?php if ($ano == "2019") { echo "selected"; }?>>2019</option>
               <option value="2020" <?php if ($ano == "2020") { echo "selected"; }?>>2020</option>
           </SELECT>
           </td>
        </tr>
		<tr>
          <td><b>Data da despesa :</b></td>
          <td>
            <input type="text" name="data_gasto" value ="<?php echo "$data_gasto";?>" size="12" maxlength="12" id="data_gasto">
            <input TYPE="button" NAME="btndata_gasto" VALUE="..." Onclick="javascript:popdate('document.cadastro.data_gasto','pop1','150',document.cadastro.data_gasto.value)">
            <span id="pop1" style="position:absolute"></span>
          </td>
        </tr>
        <tr>
           <td width="30%"><b>Observação :</b></td>
           <td><TEXTAREA NAME="observacao" rows="10" cols="100" style="width: 100%"><?php echo "$observacao";?></TEXTAREA></td>
        </tr>
        <tr>
            <td><INPUT type=button value="Despesas do Mês"
               onClick="window.open('mostra_gastos_do_mes.php','janela_1',
               'scrollbars=yes,resizable=yes,width=600,height=400');">
            </td>
			<td>
				<div align="right">
				<input name="exclui" type="submit" value="Excluir">
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
    <table border="0" width="100%" cellspacing="0" cellpadding="0" background="img/marron.jpg">
      <tr>
        <td width="100%" height="25" align="center"></font><font color="white" size="1" face="Arial">©&nbsp; COPYRIGHT NUNESTECH Tecnologia em Sistemas Ltda</font></td>
     </tr>
    </table>
  </div>
</body>
</html>

