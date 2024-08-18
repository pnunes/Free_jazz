<?php
  session_start();

 //carrega variaveis com dados para acessar o banco de dados

  $base_d     =$_SESSION['base_d'];
  $banco_d    =$_SESSION['banco_d'];
  $usuario_d  =$_SESSION['usuario_d'];
  $senha_d    =$_SESSION['senha_d'];

  $codigo_m  =$_SESSION['codigo_m'];
  $programa='17';
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
  <title>Cadastro_despesas.php</title>
  <head>
  </head>
  <body>
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
    switch (get_post_action('grava')) {
        case 'grava':
            $codigo_despe      =$_POST['codigo_despe'];
            $beneficiado       =$_POST['beneficiado'];
            $valor_gasto       =$_POST['valor_gasto'];
            $competencia       =$_POST['competencia'];
            $ano               =$_POST['ano'];
            $data_gasto        =$_POST['data_gasto'];
            $observacao        =$_POST['observacao'];


            //altera formato da data para gravar no banco

            $data_gasto  = explode("/",$data_gasto);
            $v_data_gasto = $data_gasto[2]."-".$data_gasto[1]."-".$data_gasto[0];
            
            //Tranforma a string em maiusculas
            
            //$competencia         =Strtoupper($competencia);

            // alterando o formato dos valores para guardar no banco
            if (strlen($valor_gasto)>=6) {
               $valor_gasto         = str_replace(".", "", $valor_gasto);
               $valor_gasto         = str_replace(",", ".", $valor_gasto);
            }
            if (strlen($valor_gasto)<6) {
               $valor_gasto         = str_replace(",", ".", $valor_gasto);
            }

            //echo "Codigo :$codigo_despe";
            //echo "Data :$v_data_gasto";
            //echo "Valor :$valor_gasto";
            //echo "Compete :$competencia";
            //echo "Ano :$ano";

            $con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
            $res = mysql_select_db($banco_d) or die ("Banco de dados inexistente");
            
            $inclusao = "INSERT INTO gastos (codigo_despe,data_gasto,valor_gasto,observacao,beneficiado,competencia,ano)
            values('$codigo_despe','$v_data_gasto','$valor_gasto','$observacao','$beneficiado','$competencia','$ano')";
            
            if (mysql_db_query($banco_d,$inclusao,$con)) {
                 $resp_grava="Inclusão bem sucedida";
                 $codigo_despe      ='';
                 $beneficiado       ='';
                 $valor_gasto       ='';
                 $competencia       ='';
                 $ano               ='';
                 $data_gasto        ='';
                 $observacao        ='';
            }
            else {
               $resp_grava="Problemas na Inclusão";
            }
            mysql_close ($con);
        break;
     default:
    }
  ?>
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
  <body leftmargin="10" topmargin="10" marginwidth="10" marginheight="10">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
         <td color="white" align="left" width="100%" height="35">
      </tr>
    </table>
  <form name="cadastro" id="cadastro" action="cadastro_despesas.php" method="post">
	<table width="70%" border="1" cellpadding="5" cellspacing="0" bordercolor="#DEB887">
        <tr>
			<td><b>Despesa :</b></td>
            <td>
               <select name="codigo_despe">
              <?php
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
			<td><input type="text" name="beneficiado" size="80" maxlength="80" id="beneficiado"></td>
		</tr>
        <tr>
			<td><b>Valor Despesa :</b></td>
			<td><input name="valor_gasto" type="text" size="20" maxlength="20" onKeydown="Formata(this,20,event,2)"></td>
		</tr>
        <tr>
           <td><b>Mês de competência :</b></td>
           <td>
           <SELECT NAME="competencia" SIZE="1">
               <OPTION VALUE="JANEIRO">JANEIRO</OPTION>
               <OPTION VALUE="FEVEREIRO">FEVEREIRO</OPTION>
               <OPTION VALUE="MARÇO">MARCO</OPTION>
               <OPTION VALUE="ABRIL">ABRIL</OPTION>
               <OPTION VALUE="MAIO">MAIO</OPTION>
               <OPTION VALUE="JUNHO">JUNHO</OPTION>
               <OPTION VALUE="JULHO">JULHO</OPTION>
               <OPTION VALUE="AGOSTO">AGOSTO</OPTION>
               <OPTION VALUE="SETEMBRO">SETEMBRO</OPTION>
               <OPTION VALUE="OUTUBRO">OUTUBRO</OPTION>
               <OPTION VALUE="NOVEMBRO">NOVEMBRO</OPTION>
               <OPTION VALUE="DEZEMBRO">DEZEMBRO</OPTION>
           </SELECT>
           </td>
        </tr>
        <tr>
           <td><b>Ano de competência :</b></td>
           <td>
           <SELECT NAME="ano" SIZE="1">
               <OPTION VALUE="2011">2011</OPTION>
               <OPTION VALUE="2012">2012</OPTION>
               <OPTION VALUE="2013">2013</OPTION>
               <OPTION VALUE="2014">2014</OPTION>
               <OPTION VALUE="2015">2015</OPTION>
               <OPTION VALUE="2016">2016</OPTION>
               <OPTION VALUE="2017">2017</OPTION>
               <OPTION VALUE="2018">2018</OPTION>
               <OPTION VALUE="2019">2019</OPTION>
               <OPTION VALUE="2020">2020</OPTION>
           </SELECT>
           </td>
        </tr>
		<tr>
          <td><b>Data da despesa :</b></td>
          <td>
            <input type="text" name="data_gasto" size="12" maxlength="12" id="data_gasto">
            <input TYPE="button" NAME="btndata_gasto" VALUE="..." Onclick="javascript:popdate('document.cadastro.data_gasto','pop1','150',document.cadastro.data_gasto.value)">
            <span id="pop1" style="position:absolute"></span>
          </td>
        </tr>
        <tr>
           <td width="30%"><b>Obserevação :</b></td>
           <td><TEXTAREA NAME="observacao" rows="10" cols="100" style="width: 100%"></TEXTAREA></td>
        </tr>
        <tr>
            <td><INPUT type=button value="Despesas do Mês"
               onClick="window.open('mostra_gastos_do_mes.php','janela_1',
               'scrollbars=yes,resizable=yes,width=600,height=400');">
            </td>
			<td>
				<div align="right">
				<input name="grava" type="submit" value="Gravar">
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

