<?php
  session_start();
  
  //carrega variaveis com dados para acessar o banco de dados

  $base_d     =$_SESSION['base_d'];
  $banco_d    =$_SESSION['banco_d'];
  $usuario_d  =$_SESSION['usuario_d'];
  $senha_d    =$_SESSION['senha_d'];

  $matricula_m  =$_SESSION['matricula_m'];
  $programa='031';
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
?>

<html>
  <title>altera_custodia_lancada.php</title>
  <head>
  <body>

  <script language='Javascript'>

   <!-- Funcao formata valor -->

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


  <!-- Função calendário-->

  function popdate(obj,div,tam,ddd) {

    if (ddd)     {
        day = ""
        mmonth = ""
        ano = ""
        c = 1
        char = ""
        for (s=0;s<parseInt(ddd.length);s++)
        {
            char = ddd.substr(s,1)
            if (char == "/")
            {
                c++;
                s++;
                char = ddd.substr(s,1);
            }
            if (c==1) day    += char
            if (c==2) mmonth += char
            if (c==3) ano    += char
        }
        ddd = mmonth + "/" + day + "/" + ano
    }

    if(!ddd) {today = new Date()} else {today = new Date(ddd)}
    date_Form = eval (obj)
    if (date_Form.value == "") { date_Form = new Date()} else {date_Form = new Date(date_Form.value)}

    ano = today.getFullYear();
    mmonth = today.getMonth ();
    day = today.toString ().substr (8,2)

    umonth = new Array ("Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro")
    days_Feb = (!(ano % 4) ? 29 : 28)
    days = new Array (31, days_Feb, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31)

    if ((mmonth < 0) || (mmonth > 11))  alert(mmonth)
    if ((mmonth - 1) == -1) {month_prior = 11; year_prior = ano - 1} else {month_prior = mmonth - 1; year_prior = ano}
    if ((mmonth + 1) == 12) {month_next  = 0;  year_next  = ano + 1} else {month_next  = mmonth + 1; year_next  = ano}
    txt  = "<table bgcolor='#efefff' style='border:solid #330099; border-width:2' cellspacing='0' cellpadding='3' border='0' width='"+tam+"' height='"+tam*1.1 +"'>"
    txt += "<tr bgcolor='#FFFFFF'><td colspan='7' align='center'><table border='0' cellpadding='0' width='100%' bgcolor='#FFFFFF'><tr>"
    txt += "<td width=20% align=center><a href=javascript:popdate('"+obj+"','"+div+"','"+tam+"','"+((mmonth+1).toString() +"/01/"+(ano-1).toString())+"') class='Cabecalho_Calendario' title='Ano Anterior'><<</a></td>"
    txt += "<td width=20% align=center><a href=javascript:popdate('"+obj+"','"+div+"','"+tam+"','"+( "01/" + (month_prior+1).toString() + "/" + year_prior.toString())+"') class='Cabecalho_Calendario' title='Mês Anterior'><</a></td>"
    txt += "<td width=20% align=center><a href=javascript:popdate('"+obj+"','"+div+"','"+tam+"','"+( "01/" + (month_next+1).toString()  + "/" + year_next.toString())+"') class='Cabecalho_Calendario' title='Próximo Mês'>></a></td>"
    txt += "<td width=20% align=center><a href=javascript:popdate('"+obj+"','"+div+"','"+tam+"','"+((mmonth+1).toString() +"/01/"+(ano+1).toString())+"') class='Cabecalho_Calendario' title='Próximo Ano'>>></a></td>"
    txt += "<td width=20% align=right><a href=javascript:force_close('"+div+"') class='Cabecalho_Calendario' title='Fechar Calendário'><b>X</b></a></td></tr></table></td></tr>"
    txt += "<tr><td colspan='7' align='right' bgcolor='#ccccff' class='mes'><a href=javascript:pop_year('"+obj+"','"+div+"','"+tam+"','" + (mmonth+1) + "') class='mes'>" + ano.toString() + "</a>"
    txt += " <a href=javascript:pop_month('"+obj+"','"+div+"','"+tam+"','" + ano + "') class='mes'>" + umonth[mmonth] + "</a> <div id='popd' style='position:absolute'></div></td></tr>"
    txt += "<tr bgcolor='#330099'><td width='14%' class='dia' align=center><b>Dom</b></td><td width='14%' class='dia' align=center><b>Seg</b></td><td width='14%' class='dia' align=center><b>Ter</b></td><td width='14%' class='dia' align=center><b>Qua</b></td><td width='14%' class='dia' align=center><b>Qui</b></td><td width='14%' class='dia' align=center><b>Sex<b></td><td width='14%' class='dia' align=center><b>Sab</b></td></tr>"
    today1 = new Date((mmonth+1).toString() +"/01/"+ano.toString());
    diainicio = today1.getDay () + 1;
    week = d = 1
    start = false;

    for (n=1;n<= 42;n++)
    {
        if (week == 1)  txt += "<tr bgcolor='#efefff' align=center>"
        if (week==diainicio) {start = true}
        if (d > days[mmonth]) {start=false}
        if (start)
        {
            dat = new Date((mmonth+1).toString() + "/" + d + "/" + ano.toString())
            day_dat   = dat.toString().substr(0,10)
            day_today  = date_Form.toString().substr(0,10)
            year_dat  = dat.getFullYear ()
            year_today = date_Form.getFullYear ()
            colorcell = ((day_dat == day_today) && (year_dat == year_today) ? " bgcolor='#FFCC00' " : "" )
            txt += "<td"+colorcell+" align=center><a href=javascript:block('"+  d + "/" + (mmonth+1).toString() + "/" + ano.toString() +"','"+ obj +"','" + div +"') class='data'>"+ d.toString() + "</a></td>"
            d ++
        }
        else
        {
            txt += "<td class='data' align=center> </td>"
        }
        week ++
        if (week == 8)
        {
            week = 1; txt += "</tr>"}
        }
        txt += "</table>"
        div2 = eval (div)
        div2.innerHTML = txt
  }

<!-- função para exibir a janela com os meses-->

function pop_month(obj, div, tam, ano) {
  txt  = "<table bgcolor='#CCCCFF' border='0' width=80>"
  for (n = 0; n < 12; n++) { txt += "<tr><td align=center><a href=javascript:popdate('"+obj+"','"+div+"','"+tam+"','"+("01/" + (n+1).toString() + "/" + ano.toString())+"')>" + umonth[n] +"</a></td></tr>" }
  txt += "</table>"
  popd.innerHTML = txt
}

<!-- função para exibir a janela com os anos -->

function pop_year(obj, div, tam, umonth) {
  txt  = "<table bgcolor='#CCCCFF' border='0' width=160>"
  l = 1
  for (n=1991; n<2012; n++)
  {  if (l == 1) txt += "<tr>"
     txt += "<td align=center><a href=javascript:popdate('"+obj+"','"+div+"','"+tam+"','"+(umonth.toString () +"/01/" + n) +"')>" + n + "</a></td>"
     l++
     if (l == 4)
        {txt += "</tr>"; l = 1 }
  }
  txt += "</tr></table>"
  popd.innerHTML = txt
}

<!--função para fechar o calendário -->

function force_close(div)
    { div2 = eval (div); div2.innerHTML = ''}

<!-- função para fechar o calendário e setar a data no campo de data associado-->

function block(data, obj, div) {
    force_close (div)
    obj2 = eval(obj)
    obj2.value = data
}

</script>
<!-- o css abaixo define a aparência do calendário. -->
   <style>
    .dia {font-family: helvetica, arial; font-size: 8pt; color: #FFFFFF}
    .data {font-family: helvetica, arial; font-size: 8pt; text-decoration:none; color:#191970}
    .mes {font-family: helvetica, arial; font-size: 8pt}
    .Cabecalho_Calendario {font-family: helvetica, arial; font-size: 10pt; color: #000000; text-decoration:none; font-weight:bold}
   </style>
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
         <p align="right"><font face="Arial" size="2" color="#FFFFFF"><b>Altera Cadastro Custódia Por Cliente</b></font></td>
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
  <table width="990" heigth="300" align="center">
     <tr>
       <td>
         <form name="cadastro" method="POST" action="altera_custodia_lancada.php" border="20">
            <?php
               echo "<center><Font size=\"2\" face=\"ARIAL\">Selecione o Cliente...:</font>";

               mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
               mysql_select_db($banco_d) or die ("Banco de dados inexistente");

               $resultado = mysql_query ("SELECT cnpj_cpf,nome
               FROM cli_for");
               echo "<select name='cliente' class='caixa' align=\"center\">\n";

               while($linha = mysql_fetch_row($resultado))  {
                  printf("<option value='$linha[0]'>$linha[0] - $linha[1]</option>\n");
               }
               echo "<input name=\"mostra\" type=\"submit\" value=\"Mostra\">";
               echo "</td>";
               echo "</tr>";
        ?>
     <tr>
  </table>

  <?php
     switch (get_post_action('grava','mostra')) {
         case 'mostra':
             $codi_cli             =$_POST['cliente'];
             $_SESSION['codi_cli'] =$_POST['cliente'];
             $resp_grava='';
             mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
             mysql_select_db($banco_d) or die ("Banco de dados inexistente");
             $query = mysql_query ("SELECT cnpj_cpf,nome
             FROM cli_for
             WHERE cnpj_cpf='$codi_cli'");
             $total = mysql_num_rows($query);
             for($ic=0; $ic<$total; $ic++){
                $mostra = mysql_fetch_row($query);
                $codi_cli       = $mostra[0];
                $nome           = $mostra[1];
             }
             ?>
             <?php
             $sql = mysql_query ("SELECT controle,codi_custo,v_tarifa,
             qtdade_esto,vl_estoque,dt_registro
             FROM custodia
             WHERE codi_cli='$codi_cli'");
             $total = mysql_num_rows($sql);

             if (mysql_num_rows($sql)==0) {
                $resp_grava="Não há custódia registrada para o cliente informado.";
              }
             else{
             
             //abre form - tabela e cabeçalho da tabela.

              echo "<body leftmargin=\"10\" topmargin=\"10\" marginwidth=\"10\" marginheight=\"10\">";

              echo "<table width=\"990\" border=\"1\" cellpadding=\"5\" cellspacing=\"0\" bordercolor=\"#4169E1\">";
                 echo "<tr>";
                   echo "<td><b>Codigo Cliente :</b>$codi_cli</td>";
                   echo "<td><b>Nome Cliente :</b>$nome</td>";
                 echo "</tr>";
              echo "</table>";
              echo "<table width=\"990\" border=\"1\" cellpadding=\"5\" cellspacing=\"0\" bordercolor=\"#4169E1\">";
                echo "<th>C</th>";
                echo "<th>TIPO CUSTODIA</th>";
                echo "<th>TARIFA</th>";
                echo "<th>QTDADE</th>";
                echo "<th>R$ ESTOQUE</th>";
                echo "<th>REGISTRO</th>";
              $co=0;
              while ($x  = mysql_fetch_array($sql)) {
                $controle         = $x['controle'];
                $codi_custo       = $x['codi_custo'];
                $v_tarifa         = $x['v_tarifa'];
                $qtdade_esto      = $x['qtdade_esto'];
                $vl_estoque       = $x['vl_estoque'];
                $dt_registro      = $x['dt_registro'];

                //Formata valortes para mostrar na tela
                
                $v_tarifa   = number_format($v_tarifa, 2, ',', '.');
                $vl_estoque = number_format($vl_estoque, 2, ',', '.');

		        echo "<tr>";
                    echo "<td width=\"3%\">$controle</b><input type=\"hidden\" name=v_item['$co'][controle] value=\"$controle\" size=\"2\" maxlength=\"2\"></font></td>";
                    echo "<td width=\"15%\">";
                      mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
                      mysql_select_db($banco_d) or die ("Banco de dados inexistente");

                      $resultado = mysql_query ("SELECT codigo_se,descri_se,valor
                      FROM serv_ati");
                      echo "<select name=v_item['$co'][codi_custo] id=codi_custo$co class='caixa' align=\"left\">\n";
                      $opcao="sele$co";
                      while($linha = mysql_fetch_row($resultado))  {
                         printf("<option value='$linha[0]'>$linha[0] - $linha[1] -  $linha[2]</option>\n");
                      }
                      ?>
                      <script language="javascript">
                        Seleciona = function(itemSelecionar){
                          var _codi_custo<?php echo "$co";?> = document.getElementById("codi_custo<?php echo "$co";?>");
                          for ( i =0; i < _codi_custo<?php echo "$co";?>.length; i++){
                            _codi_custo<?php echo "$co";?>[i].selected = _codi_custo<?php echo "$co";?>[i].value == itemSelecionar ? true : false;
                          }
                        }
                        Seleciona(<?php echo "$codi_custo";?>);
                     </script>
                     <?php
                    echo "</td>";
                   // echo "<td width=\"5%\"><input type=\"text\" name=v_item['$co'][v_tarifa] value=\"$v_tarifa\" size=\"8\" maxlength=\"8\">";
                    echo "<td width=\"5%\" align=\"right\">$v_tarifa</td>";
                    echo "<td width=\"5%\"><input type=\"text\" name=v_item['$co'][qtdade_esto] value=\"$qtdade_esto\" size=\"8\" maxlength=\"8\">";
                   // echo "<td width=\"5%\"><input type=\"text\" name=v_item['$co'][vl_estoque] value=\"$vl_estoque\" size=\"8\" maxlength=\"8\">";
                    echo "<td width=\"5%\" align=\"right\">$vl_estoque</td>";
                    echo "<td width=\"8%\">";
                     $dt_registro = explode("-",$dt_registro);
                     $dt_resgi = $dt_registro[2]."/".$dt_registro[1]."/".$dt_registro[0];
                     echo "<input TYPE=\"text\" name=v_item['$co'][dt_registro] size=\"12\" maxlength=\"12\" value =\"$dt_resgi\" id=\"datare$co\">";
                     echo "<input TYPE=\"button\" NAME=\"btndatare$co\" VALUE=\"...\" Onclick=\"javascript:popdate('document.cadastro.datare$co','pop$co','150',document.cadastro.datare$co.value)\">";
                     echo "<span id=\"pop$co\" style=\"position:absolute\"></span>";
                    echo "</td>";
                echo "</tr>";
                $co=$co+1;
              }
              echo "<tr>";
               echo "<td colspan=\"7\">";
                  echo "<div align=\"right\">";
                    echo "<input name=\"grava\" type=\"submit\" value=\"Gravar\">";
                  echo "</div>";
               echo "</td>";
              echo "</tr>";
              echo "</table>";
              }
              break;

         case 'grava':
             $con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
             $res = mysql_select_db($banco_d) or die ("Banco de dados inexistente");
             $num=0;
             foreach($_POST['v_item'] as $dados){
                 $controle        = $dados[controle];
                 $codi_custo      = $dados[codi_custo];
                 //$v_tarifa        = $dados[v_tarifa];
                 $g_qtdade_esto   = $dados[qtdade_esto];
                // $g_vl_estoque    = $dados[vl_estoque];
                 $dt_registro     = $dados[dt_registro];

                 //PEGA O VALOR UNITÁRIO DO SERVIÇO PARA CALCULAR O TOTAL DO ESTOQUE
                 
                 mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
                 mysql_select_db($banco_d) or die ("Banco de dados inexistente");
                 $query = mysql_query ("SELECT valor
                 FROM serv_ati
                 WHERE codigo_se='$codi_custo'");
                
                 $total = mysql_num_rows($query);
                
                 for($ic=0; $ic<$total; $ic++){
                    $mostra = mysql_fetch_row($query);
                    $valor          = $mostra[0];
                 }
                 
                 //Refaz o calculo do valor do estoque
                 
                 $g_vl_estoque=($g_qtdade_esto*$valor);
                 
                 $dt_registro     = explode("/",$dt_registro);
                 $v_dt_registro    = $dt_registro[2]."-".$dt_registro[1]."-".$dt_registro[0];


                 // alterando o formato dos valores para guardar no banco
                 if (strlen($g_vl_estoque)>=6) {
                    $g_vl_estoque       = str_replace(".", "", $g_vl_estoque);
                    $g_vl_estoque       = str_replace(",", ".", $g_vl_estoque);
                 }
                 if (strlen($g_vl_estoque)<6) {
                    $g_vl_estoque         = str_replace(",", ".", $g_vl_estoque);
                 }

                 
                 mysql_query("UPDATE custodia SET qtdade_esto='$g_qtdade_esto',codi_custo='$codi_custo',
                 vl_estoque='$g_vl_estoque',dt_registro='$v_dt_registro',
                 v_tarifa='$valor',dt_movi='$v_dt_registro'
                 WHERE controle='$controle'");
                 $num++;
             }
            break;
         default:
     }
  ?>
  </form>
  </div>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td color="white" align="center" width="900" height="45" colspan="8" ><?php echo "$resp_grava";?></td>
      </tr>
    </table>
    </form>
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

