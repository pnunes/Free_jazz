<?php  session_start();    Include('conexao_free.php');  mysqli_set_charset($con,'UTF8');  ?><HTML><HEAD> <TITLE>mostra_precos_cadastrados.php</TITLE> <style>		body, p, div, td, input, select, textarea {			font-family: verdana,arial,helvetica;			font-size:12px;			color:#000000;			text-decoration: none;		}		input,textarea {			@if (is.ie) {				color: #efefef; background-color:#F0F8FF; border: 1px solid #6495ED ;				/*border-top-width: 1px; border-right-width: 1px; border-bottom-width: 1px; border-left-width: 1px; */			}		}		textarea { overflow:auto }	</style></HEAD><BODY><FORM><INPUT type=button value="Fechar janela" onClick="window.close();"></FORM><table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#4169E1"> <tr>    <td colspan="5" align="center"><font face="arial" size="2"><b>PREÇOS CADASTRADOS</b></font></td> </tr> <tr>     <td width="10%" align="center"><b>SERVICO</b></td>     <td width="25%" align="center"><b>TERCEIRIZADO</b></td>     <td width="35%" align="center"><b>NOME SERVIÇO</b></td>     <td width="20%" align="center"><b>CLASSE</b></td>     <td width="10%" align="center"><b>VALOR</b></td> </tr><?php            $resultado = mysqli_query ($con,"SELECT tb_terceiro.tipo_servi,cli_for.nome,                   serv_ati.descri_se,tb_terceiro.valor,tb_terceiro.nome_classe                   FROM tb_terceiro,cli_for,serv_ati                   WHERE ((tb_terceiro.repre=cli_for.cnpj_cpf)                   AND (tb_terceiro.tipo_servi=serv_ati.codigo_se))                   ORDER BY cli_for.nome,tb_terceiro.nome_classe");      $total = mysqli_num_rows($resultado);      for($i=0; $i<$total; $i++){         $dados = mysqli_fetch_row($resultado);         $servico      =$dados[0];	     $repre        =$dados[1];	     $nome_ser     =$dados[2];	     $valor        =$dados[3];	     $nome_classe  =$dados[4];	     	     $valor          = number_format($valor, 2, ',', '.');	     echo "<tr>";	     echo "<td width=\"10%\" align=\"left\"><font size=\"2\" face=\"arial\">$servico</font></td>";	     echo "<td width=\"25%\" align=\"left\"><font size=\"2\" face=\"arial\">$repre</font></td>";	     echo "<td width=\"35%\"><font size=\"2\" face=\"arial\">$nome_ser</font></td>";	     echo "<td width=\"20%\"><font size=\"2\" face=\"arial\">$nome_classe</font></td>";	     echo "<td width=\"10%\"><font size=\"2\" face=\"arial\">$valor</font></td>";         echo "</tr>";       }?></table></div></BODY></HTML>