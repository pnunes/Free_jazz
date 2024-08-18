<?php
  session_start();
  /**
 * Show Progress Bar
 * Função para mostrar uma barra de progresso.
 *
 * @param int $width		-> Largura total da barra (em pixels)
 * @param float $percent	-> Porcentagem a ser exibida
 * @param str $type		-> Cor da barra: green / red / blue (Padrão: green)
 * @param str $color		-> Cor do texto da barra (Padrão: #000)
 * @return str			-> Retorna uma string com todo o código da barra formatada
 */

   //carrega variaveis com dados para acessar o banco de dados

  $base_d     =$_SESSION['base_d'];
  $banco_d    =$_SESSION['banco_d'];
  $usuario_d  =$_SESSION['usuario_d'];
  $senha_d    =$_SESSION['senha_d'];

  $matricula_m  =$_SESSION['matricula_m'];
  $programa='122';
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
  include ("campo_calendario.php");
?>
<html>
  <title>arquivo_morto_movimento.php</title>
  <head>
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
         <p align="right"><font face="Arial" size="2" color="#FFFFFF"><b>Exclui movimento morto</b></font></td>
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
   <form method="POST" name="cadastro" action="excluir_movimento_morto.php">
	<table align="center" width="80%" border="1" cellpadding="5" cellspacing="0" bordercolor="#4169E1">
        <tr>
           <td colspan="2">
            <?php
               echo "<center><Font size=\"2\" face=\"ARIAL\">Selecione Cliente...:</font>";
               $resultado = mysql_query ("SELECT cnpj_cpf,nome
               FROM cli_for");
               echo "<select name='cliente' class='caixa' align=\"center\">\n";

               while($linha = mysql_fetch_row($resultado))  {
                  printf("<option value='$linha[0]'>$linha[0] - $linha[1]</option>\n");
               }
            ?>
            </td>
          </tr>
        <tr>
           <td><b>Data inicio :</b></td>
           <td>
             <input type="text" name="data_ini" size="12" maxlength="12" id="data_ini">
             <input TYPE="button" NAME="btndata_ini" VALUE="..." Onclick="javascript:popdate('document.cadastro.data_ini','pop1','150',document.cadastro.data_ini.value)">
             <span id="pop1" style="position:absolute"></span>
           </td>
        </tr>
        <tr>
           <td><b>Data fim :</b></td>
           <td>
             <input type="text" name="data_fim" size="12" maxlength="12" id="data_fim">
             <input TYPE="button" NAME="btndata_fim" VALUE="..." Onclick="javascript:popdate('document.cadastro.data_fim','pop2','150',document.cadastro.data_fim.value)">
             <span id="pop2" style="position:absolute"></span>
           </td>
        </tr>
		<tr>
		    <td colspan="2" align="right">
			   <input name="apaga" type="submit" value="Apagar"">
		    </td>
		</tr>
	</table>
	</form>
	<table align="center" width="80%" border="1" cellpadding="5" cellspacing="0" bordercolor="#4169E1">
    <tr>
    <td align="center">
    <?php
     switch (get_post_action('apaga')) {
         case 'apaga':
              $cliente        =$_POST['cliente'];
              $dt_inicio      =$_POST['data_ini'];
              $dt_fim         =$_POST['data_fim'];
              $conta=0;
              
              //Altera formato de data para comparação
              
              $dt_inicio  = explode("/",$dt_inicio);
              $v_dt_inicio = $dt_inicio[2]."-".$dt_inicio[1]."-".$dt_inicio[0];

              $dt_fim  = explode("/",$dt_fim);
              $v_dt_fim = $dt_fim[2]."-".$dt_fim[1]."-".$dt_fim[0];

              $seleciona = "SELECT n_hawb FROM remessa
              WHERE ((codi_cli ='$cliente')
              AND (dt_remessa>='$v_dt_inicio')
              AND (dt_remessa<='$v_dt_fim'))";

              $query = mysql_db_query($banco_d,$seleciona,$con) or die ("Não foi possivel acessar o banco");
              $total = mysql_num_rows($query);
              for($ic=0; $ic<$total; $ic++){
                    $row = mysql_fetch_row($query);
                    $n_hawb            = $row[0];
                    
                    echo "Pod :$n_hawb";
                    //Apaga movimento da tabela controle_reentrega

                    $deleta_pod ="DELETE FROM controle_reentrega WHERE n_hawb='$n_hawb'";
                    mysql_db_query($banco_d,$deleta_pod,$con);

                    $deleta_reme ="DELETE FROM remessa WHERE n_hawb='$n_hawb'";
                    if (mysql_db_query($banco_d,$deleta_reme,$con)) {
                        $conta++;
                    }
              }
     break;
     default:
 }
  ?>
  </td>
  </tr>
  </table>
  <?php
   if ($conta > 0) {
  ?>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
         <tr>
           <td color="white" align="center" width="900" height="45" colspan="8" ><?php echo "Total Registros apagados :$conta";?></td>
         </tr>
      </table>
  <?php
   }
  ?>
  <table width="100%"  border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td background="img/blue.jpg" align="left" width="100%" height="45px"><center><font face="arial" size="1" color="white">Todos Direitos Reservados a NUNESTEC Tecnologia</font></td>
    </tr>
  </table>

</body>
</html>

