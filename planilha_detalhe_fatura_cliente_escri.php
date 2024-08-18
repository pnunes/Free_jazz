<?php
    if ( session_status() !== PHP_SESSION_ACTIVE ) {       session_start();    }    // abra conexao com o banco
    Include('conexao_free.php');    // função le valor submite
    function get_post_action($name) {
       $params = func_get_args();
       foreach ($params as $name) {
          if (isset($_POST[$name])) {
            return $name;
          }
       }
    }
	if(!isset($resp_grava)) {
	   $resp_grava = '';
	}
    switch (get_post_action('gera')) {
         case 'gera':
             $cliente                =$_POST['cliente'];
             $dt_inicio              =$_POST['data_ini'];
             $dt_fim                 =$_POST['data_fim'];
            // $escritorio             =$_POST['escritorio'];
             //Altera formato de data para comparara-lo
             $dt_inicio  = explode("/",$dt_inicio);
             $v_dt_inicio = $dt_inicio[2]."-".$dt_inicio[1]."-".$dt_inicio[0];			 
             $dt_fim  = explode("/",$dt_fim);
             $v_dt_fim = $dt_fim[2]."-".$dt_fim[1]."-".$dt_fim[0];
             //- Definimos o nome do arquivo que será exportado -------------
             $arquivo = 'detalhe_fatura_cliente_escritorio.xls';      
             // Criamos uma tabela HTML com o formato da planilha
             $html = '';
             $html .= '<table border="1">';
             $html .= '<tr>';
             $html .= '<td colspan="3"><b>Faturamento Por Cliente por Escritório</b></td></tr>';			 
             // -- Cabeçalho do arquivo -------------------------------------
             $html .= '<tr><td align="center"><b>HAWB</b></td>';
             $html .= '<td align="center"><b>DT_HAWB</b></td>';
             $html .= '<td align="center"><b>NOME DESTINO</b></td>';
             $html .= '<td align="center"><b>SERVIÇO</b></td>';
             $html .= '<td align="center"><b>NUMERO</b></td>';
             $html .= '<td align="center"><b>BAIRRO</b></td>';
             $html .= '<td align="center"><b>CIDADE</b></td>';
             $html .= '<td align="center"><b>QDTDADE</b></td>';
             $html .= '<td align="center"><b>VL. UNIT.</b></td>';
             $html .= '<td align="center"><b>TOTAL</b></td></tr>';
             //--------------------------------------------------------------
            $sql = mysqli_query($con,"SELECT n_hawb,date_format(remessa.dt_remessa,'%d/%m/%Y'),nome_desti,
            numero_desti,bairro_desti,cidade_desti,qtdade,valor,co_servico,classe_cep
            FROM remessa
            WHERE ((codi_cli='$cliente')
            AND (dt_remessa>='$v_dt_inicio')
            AND (dt_remessa<='$v_dt_fim'))");			$aux = mysqli_num_rows($sql);			//$row=mysqli_fetch_array($sql);
            while($row = mysqli_fetch_array($sql)) {
                $n_hawb         = $row[0];
                $dt_remessa     = $row[1];
                $nome_desti     = $row[2];
                $numero_desti   = $row[3];
                $bairro_desti   = $row[4];
                $cidade_desti   = $row[5];
                $qtdade         = $row[6];
                $valor          = $row[7];
                $co_servico     = $row[8];
                $classe_cep     = $row[9];
                //Localiza o valor do serviço
                if ($classe_cep<>'04' AND $classe_cep<>'03') {
                   $localiza="SELECT valor FROM tabela_preco WHERE codi_cli='$cliente' AND tipo_servi='$co_servico' AND classe_cep='$classe_cep'";
                   $query = mysqli_query($con,$localiza) or die ("Não foi possivel acessar o banco (pega valor)");
                   $total = mysqli_num_rows($query);
				   if($total > 0){
                      for($ic=0; $ic<$total; $ic++){
                         $row = mysqli_fetch_row($query);
                         $v_valor             = $row[0];
                      }
                      $v_total =$v_valor*$qtdade;
				      $v_total = number_format($v_total, 2, ',', '.');
				   }else {
					  $v_valor = 0.00; 
					  $v_total =$v_valor*$qtdade;
				      $v_total = number_format($v_total, 2, ',', '.');
				   }
                }
                else {
                   $v_total = $qtdade*$valor;
				   $v_total = number_format($v_total, 2, ',', '.');
                }                $v_valor = number_format($v_valor, 2, ',', '.');
				$valor   = number_format($valor, 2, ',', '.');
                //Localiza o nome do serviço
                $verifi="SELECT descri_se FROM serv_ati WHERE codigo_se='$co_servico'";
                $query = mysqli_query($con,$verifi) or die ("Não foi possivel acessar o banco");
                $total = mysqli_num_rows($query);				
                for($ic=0; $ic<$total; $ic++){
                   $row = mysqli_fetch_row($query);
                   $descri_se        = $row[0];
                }
                $html .= "<tr>";
                $html .= "<td align='center'>$n_hawb</td>";
                $html .= "<td>$dt_remessa</td>";
                $html .= "<td>$nome_desti</td>";
                $html .= "<td>$descri_se</td>";
                $html .= "<td>$numero_desti</td>";
                $html .= "<td>$bairro_desti</td>";
                $html .= "<td>$cidade_desti</td>";
                $html .= "<td>$qtdade</td>";
                if ($classe_cep<>'04' AND $classe_cep<>'03') {
                   $html .= "<td>$v_valor</td>";
                }
                else {
                   $html .= "<td>$valor</td>";
                }
                $html .= "<td>$v_total</td>";
                $html .= "</tr>";
            }
            $html .= '</table>';
            // Configuraçães do header para forçar o download
            header ("Cache-Control: no-cache, must-revalidate");
            header ("Pragma: no-cache");
            header ("Content-type: application/x-msexcel");
            header ("Content-Disposition: attachment; filename=\"{$arquivo}\"" );
            header ("Content-Description: PHP Generated Data" );
            // Envia o conteúdo do arquivo
            echo $html;
            exit;
         break;
         default:
    }
    //carrega variaveis com dados para acessar o banco de dados
    $matricula_m  =$_SESSION['matricula_m'];
    $programa='096';
    $_SESSION['programa_m']=$programa;
    $declara = "SELECT matricula,programa FROM permissoes
    WHERE ((matricula='$matricula_m') and (programa='$programa'))";
    $query = mysqli_query($con,$declara) or die ("Não foi possivel acessar o banco");
    $achou = mysqli_num_rows($query);
    If ($achou == 0 ) {
       ?>
       <script language="javascript"> window.location.href=("entrada.php")
            alert('Você não está autorizado a acessar esta rotina.');
       </script>
       <?php
    }
    include("campo_calendario.php");
?>
<HTML>
<HEAD>
   <TITLE>planilha_detalhe_fatura_cliente_escri.php</TITLE>
</HEAD>
<BODY>
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
  <div id="geral" align="center">    <form name="cadastro" method="POST" action="planilha_detalhe_fatura_cliente_escri.php" border="20">
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
			  <p align="left"><font face="Arial" size="2" color="#FFFFFF"><b>Sistema de Gerenciamento da Logística de Encomendas</b></font>			</td>
			<td width="50%">
			  <p align="right"><font face="Arial" size="2" color="#FFFFFF"><b>Relatório de Itens de Remessas</b></font>			</td>
		  </tr>
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
	   <table width="70%" border="1" cellpadding="5" cellspacing="0" bordercolor="#6495ED">
		  <tr>
		   <td colspan="2">
			<?php
			   echo "<center><Font size=\"2\" face=\"ARIAL\">Selecione Cliente...:</font>";
			   $resultado = mysqli_query ($con,"SELECT cnpj_cpf,nome FROM cli_for WHERE ativo='S'");
			   echo "<select name='cliente' class='caixa' align=\"center\">\n";
				  while($linha = mysqli_fetch_row($resultado))  {
					  printf("<option value='$linha[0]'>$linha[0] - $linha[1]</option>\n");
				  }
			?>
			</td>
		  </tr>
		 <!-- <tr>
			<td colspan="2">
			   <?php
			  // echo "<center><Font size=\"2\" face=\"ARIAL\">Selecione Escritorio...:</font>";
			  // $resultado = mysqli_query ($con,"SELECT codigo,nome FROM regi_dep");
			  // echo "<select name='escritorio' class='caixa' align=\"center\">\n";
			  //	while($linha = mysqli_fetch_row($resultado))  {
			  //	  printf("<option value='$linha[0]'>$linha[0] - $linha[1]</option>\n");
			  //	}
			   ?>
			</td>
		  </tr>-->
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
			<td colspan="2">
				<div align="right">
				<input name="gera" type="submit" value="Gerar">
				</div>
			</td>
		  </tr>
	  </table>
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
			<td width="100%" height="25" align="center"></font><font color="white" size="1" face="Arial">COPYRIGHT NUNESTECH Tecnologia em Sistemas Ltda</font></td>
		 </tr>
	  </table>    </form>  </div>
</BODY>
</HTML>
