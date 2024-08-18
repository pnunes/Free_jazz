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
  function show_prog_bar($width, $percent, $type = 'green', $color = '#000') {
	$font =			    'Tahoma';
	$font_size =		'8px';
	$font_weight =		'bold';	// bold, normal
	$imgs_folder =		'images/';

	// == Don't edit below ==
	$percent = min($percent, $width);
	$width  -= 2;
	$result = (($percent*$width) / $width);
	$return = '';
	$return .= '<div name="progress">';
	$return .= '<div style="background: url(\''.$imgs_folder.'/progress.gif\') no-repeat; height: 11px; width: 1px; display: block; float: left"><!-- --></div>';
	$return .= '<div style="background: url(\''.$imgs_folder.'/bg.gif\'); height: 11px; width: '.$width.'px; display: block; float: left">';

	$return .= '<span style="background: url(\''.$imgs_folder.'/on_'.strtolower($type).'.gif\'); display: block; float: left; width: '.$result.'px; height: 11px; margin: 1px 0; font-size: '.$font_size.'; font-family: \''.$font.'\'; line-height: 11px; font-weight: '.$font_weight.'; text-align: right; color: '.$color.'; letter-spacing: 1px;">&nbsp;'.$percent.'</span>';

	$return .= '</div>';
	$return .= '<div style="background: url(\''.$imgs_folder.'/progress.gif\') no-repeat; height: 11px; width: 1px; display: block; float: left"><!-- --></div>';
	$return .= '</div>';
	return $return;
  }


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
         <p align="right"><font face="Arial" size="2" color="#FFFFFF"><b>Envia Movimento para Arquivo Inativo</b></font></td>
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
   <form method="POST" name="cadastro" action="arquivo_morto_movimento.php">
	<table align="center" width="80%" border="1" cellpadding="5" cellspacing="0" bordercolor="#4169E1">
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
			   <input name="envia" type="submit" value="Enviar"">
		    </td>
		</tr>
	</table>
	</form>
	<table align="center" width="80%" border="1" cellpadding="5" cellspacing="0" bordercolor="#4169E1">
    <tr>
    <td align="center">
    <?php
     switch (get_post_action('envia')) {
         case 'envia':
              $dt_inicio      =$_POST['data_ini'];
              $dt_fim         =$_POST['data_fim'];
              $processo='N';
              $conta=0;
              //Altera formato de data para comparação
              $dt_inicio  = explode("/",$dt_inicio);
              $v_dt_inicio = $dt_inicio[2]."-".$dt_inicio[1]."-".$dt_inicio[0];

              $dt_fim  = explode("/",$dt_fim);
              $v_dt_fim = $dt_fim[2]."-".$dt_fim[1]."-".$dt_fim[0];

              $con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
              $res = mysql_select_db($banco_d) or die ("Banco de dados inexistente");

              $coleta = "SELECT
                        n_remessa,
                        codi_cli,
                        escritorio,
                        tipo_servi,
                        cod_barra,
                        n_tentativas,
                        codigo_desti,
                        nome_desti,
                        cep_desti,
                        rua_desti,
                        numero_desti,
                        comple_desti,
                        bairro_desti,
                        cidade_desti,
                        estado_desti,
                        dt_remessa,
                        dt_baixa,
                        dt_entrega,
                        hr_entrega,
                        documento,
                        parentesco,
                        recebedor,
                        dt_faturamento,
                        dt_lista,
                        entregador,
                        ocorrencia,
                        valor,
                        qtdade,
                        n_hawb,
                        dt_devolucao,
                        observacao,
                        volta_lista,
                        dt_envio,
                        remessa_envio,
                        nu_lista,
                        classe_cep,
                        reentrega,
                        hora,
                        co_servico,
                        classe_cep_regiao,
                        estatus,
                        exportado,
                        imagem_exportada
                        FROM remessa
                        WHERE ((dt_remessa>='$v_dt_inicio')
                        AND (dt_remessa<='$v_dt_fim')
                        AND (dt_envio<>'0000-00-00'))";

                        $query = mysql_db_query($banco_d,$coleta,$con) or die ("Não foi possivel acessar o banco");
                        $total = mysql_num_rows($query);
                        for($ic=0; $ic<$total; $ic++){
                            $row = mysql_fetch_row($query);
                            $n_remessa          = $row[0];
                            $codi_cli           = $row[1];
                            $escritorio         = $row[2];
                            $tipo_servi         = $row[3];
                            $cod_barra          = $row[4];
                            $n_tentativas       = $row[5];
                            $codigo_desti       = $row[6];
                            $nome_desti         = $row[7];
                            $cep_desti          = $row[8];
                            $rua_desti          = $row[9];
                            $numero_desti       = $row[10];
                            $comple_desti       = $row[11];
                            $bairro_desti       = $row[12];
                            $cidade_desti       = $row[13];
                            $estado_desti       = $row[14];
                            $dt_remessa         = $row[15];
                            $dt_baixa           = $row[16];
                            $dt_entrega         = $row[17];
                            $hr_entrega         = $row[18];
                            $documento          = $row[19];
                            $parentesco         = $row[20];
                            $recebedor          = $row[21];
                            $dt_faturamento     = $row[22];
                            $dt_lista           = $row[23];
                            $entregador         = $row[24];
                            $ocorrencia         = $row[25];
                            $valor              = $row[26];
                            $qtdade             = $row[27];
                            $n_hawb             = $row[28];
                            $dt_devolucao       = $row[29];
                            $observacao         = $row[30];
                            $volta_lista        = $row[31];
                            $dt_envio           = $row[32];
                            $remessa_envio      = $row[33];
                            $nu_lista           = $row[34];
                            $classe_cep         = $row[35];
                            $reentrega          = $row[36];
                            $hora               = $row[37];
                            $co_servico         = $row[38];
                            $classe_cep_regiao  = $row[39];
                            $estatus            = $row[40];
                            $exportado          = $row[41];
                            $imagem_exportada   = $row[42];

                            $verifica ="SELECT n_hawb FROM remessa_morto WHERE n_hawb='$n_hawb'";
                            $query_v = mysql_db_query($banco_d,$verifica,$con) or die ("Não foi possivel acessar o banco");
                            $total_v = mysql_num_rows($query_v);
                            if ($total_v==0) {
                                $inclui = "INSERT INTO remessa_morto (
                                     n_remessa,
                                     codi_cli,
                                     escritorio,
                                     tipo_servi,
                                     cod_barra,
                                     n_tentativas,
                                     codigo_desti,
                                     nome_desti,
                                     cep_desti,
                                     rua_desti,
                                     numero_desti,
                                     comple_desti,
                                     bairro_desti,
                                     cidade_desti,
                                     estado_desti,
                                     dt_remessa,
                                     dt_baixa,
                                     dt_entrega,
                                     hr_entrega,
                                     documento,
                                     parentesco,
                                     recebedor,
                                     dt_faturamento,
                                     dt_lista,
                                     entregador,
                                     ocorrencia,
                                     valor,
                                     qtdade,
                                     n_hawb,
                                     dt_devolucao,
                                     observacao,
                                     volta_lista,
                                     dt_envio,
                                     remessa_envio,
                                     nu_lista,
                                     classe_cep,
                                     reentrega,
                                     hora,
                                     co_servico,
                                     classe_cep_regiao,
                                     estatus,
                                     exportado,
                                     imagem_exportada)
                                     VALUES (
                                     '$n_remessa',
                                     '$codi_cli',
                                     '$escritorio',
                                     '$tipo_servi',
                                     '$cod_barra',
                                     '$n_tentativas',
                                     '$codigo_desti',
                                     '$nome_desti',
                                     '$cep_desti',
                                     '$rua_desti',
                                     '$numero_desti',
                                     '$comple_desti',
                                     '$bairro_desti',
                                     '$cidade_desti',
                                     '$estado_desti',
                                     '$dt_remessa',
                                     '$dt_baixa',
                                     '$dt_entrega',
                                     '$hr_entrega',
                                     '$documento',
                                     '$parentesco',
                                     '$recebedor',
                                     '$dt_faturamento',
                                     '$dt_lista',
                                     '$entregador',
                                     '$ocorrencia',
                                     '$valor',
                                     '$qtdade',
                                     '$n_hawb',
                                     '$dt_devolucao',
                                     '$observacao',
                                     '$volta_lista',
                                     '$dt_envio',
                                     '$remessa_envio',
                                     '$nu_lista',
                                     '$classe_cep',
                                     '$reentrega',
                                     '$hora',
                                     '$co_servico',
                                     '$classe_cep_regiao',
                                     '$estatus',
                                     '$exportado',
                                     '$imagem_exportada')";
                                     mysql_db_query($banco_d,$inclui,$con);
                                     
                                     //$deleta = "DELETE FROM remessa WHERE n_hawb='$n_hawb'";
                                     //mysql_db_query($banco_d,$deleta,$con);
                                     
                                     $historico = "SELECT n_hawb,dt_evento,ocorrencia,cod_barra,ordem,cod_ocorre
                                     FROM controle_reentrega WHERE n_hawb='$n_hawb'";
                                     $query_1 = mysql_db_query($banco_d,$historico,$con) or die ("Não foi possivel acessar o banco");
                                     $total_1 = mysql_num_rows($query_1);
                                     for($ic=0; $ic<$total_1; $ic++){
                                         $row = mysql_fetch_row($query_1);
                                         $n_hawb_a          = $row[0];
                                         $dt_evento         = $row[1];
                                         $ocorrencia        = $row[2];
                                         $cod_barra         = $row[3];
                                         $ordem             = $row[4];
                                         $cod_ocorre        = $row[5];
                                         
                                         $procura ="SELECT n_hawb FROM historico_pod_morto WHERE n_hawb='$n_hawb'";
                                         $query_h = mysql_db_query($banco_d,$procura,$con) or die ("Não foi possivel acessar o banco");
                                         $total_h = mysql_num_rows($query_h);
                                         if ($total_h==0) {
                                            $inclui_his ="INSERT INTO historico_pod_morto (n_hawb,dt_evento,ocorrencia,cod_barra,ordem,cod_ocorre)
                                            VALUES ('$n_hawb_a','$dt_evento','$ocorrencia','$cod_barra','$ordem','$cod_ocorre')";
                                            mysql_db_query($banco_d,$inclui_his,$con);
                                         
                                            //$deleta_his = "DELETE FROM controle_reentrega WHERE n_hawb='$n_hawb'";
                                            //mysql_db_query($banco_d,$deleta_his,$con);
                                         }
                                     }
                                $conta++;
                                ?>
                                   <?=show_prog_bar($total, $conta);?><br />
                                <?php
                            }
                        }
                        $processo='S';
         break;
         default:
     }
  ?>
  </td>
  </tr>
  </table>
  <table width="100%"  border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td background="img/blue.jpg" align="left" width="100%" height="45px"><center><font face="arial" size="1" color="white">Todos Direitos Reservados a NUNESTEC Tecnologia</font></td>
    </tr>
  </table>

</body>
</html>

