<?php  session_start();    Include('conexao_free.php');  mysqli_set_charset($con,'UTF8');  ?><HTML><HEAD> <TITLE>mostra_classe_cep_cadastradas.php</TITLE> <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" /> <style>		body, p, div, td, input, select, textarea {			font-family: verdana,arial,helvetica;			font-size:12px;			color:#000000;			text-decoration: none;		}		input,textarea {			@if (is.ie) {				color: #efefef; background-color:#F0F8FF; border: 1px solid #6495ED ;				/*border-top-width: 1px; border-right-width: 1px; border-bottom-width: 1px; border-left-width: 1px; */			}		}		textarea { overflow:auto }	</style></HEAD><BODY><FORM><INPUT type=button value="Fechar janela" onClick="window.close();"></FORM><table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#4169E1"> <tr>    <td colspan="4" align="center"><font face="arial" size="2"><b>CLASSE CEP CADASTRADAS</b></font></td> </tr> <tr>     <td width="10%" align="center"><b>CODIGO</b></td>     <td width="70%" align="center"><b>DESCRIÇÂO</b></td>     <td width="10%" align="center"><b>CEP INICIO</b></td>     <td width="10%" align="center"><b>CEP FINL</b></td> </tr><?php      $resultado = mysqli_query ($con,"SELECT codigo,descricao,cep_inicio,cep_fim                   FROM classe_cep ORDER BY codigo");      $total = mysqli_num_rows($resultado);      for($i=0; $i<$total; $i++){         $dados = mysqli_fetch_row($resultado);	     $codigo          =$dados[0];	     $descricao       =$dados[1];	     $cep_inicio      =$dados[2];	     $cep_fim         =$dados[3];	     echo "<tr>";	     echo "<td width=\"10%\" align=\"left\"><font size=\"2\" face=\"arial\">$codigo</font></td>";	     echo "<td width=\"70%\"><font size=\"2\" face=\"arial\">$descricao</font></td>";	     echo "<td width=\"10%\"><font size=\"2\" face=\"arial\">$cep_inicio</font></td>";	     echo "<td width=\"10%\"><font size=\"2\" face=\"arial\">$cep_fim</font></td>";         echo "</tr>";       }?></table></div></BODY></HTML>