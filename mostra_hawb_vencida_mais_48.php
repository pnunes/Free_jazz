<?php
  session_start();
      $base_d     =$_SESSION['base_d'];
      $banco_d    =$_SESSION['banco_d'];
      $usuario_d  =$_SESSION['usuario_d'];
      $senha_d    =$_SESSION['senha_d'];
      
      $data   =date("d/m/Y");
      
      //Altera formato de data para comparação
      $dt_hoje  = explode("/",$data);
      $v_dt_hoje = $dt_hoje[2]."-".$dt_hoje[1]."-".$dt_hoje[0];
      $v_hoje=mktime(0,0,0,(substr($v_dt_hoje,5,2)),(substr($v_dt_hoje,8,2)),(substr($v_dt_hoje,0,4)));
      $_SESSION['v_hoje_m']    =$v_hoje;
      
      mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
      mysql_select_db($banco_d) or die ("Banco de dados inexistente");
      
      //conta o total de hawb´s em aberto
      //Total base fpolis
      $contagem= mysql_query("SELECT dt_remessa FROM remessa
      WHERE ((dt_envio='0000-00-00')
      AND (escritorio='001')
      AND (dt_remessa>'2012-12-01'))");
      while ($row = mysql_fetch_array($contagem)) {
         $dt_remessa    =$row[0];
         $v_dt_remessa=mktime(0,0,0,(substr($dt_remessa,5,2)),(substr($dt_remessa,8,2)),(substr($dt_remessa,0,4)));
         $segundos = ($v_hoje-$v_dt_remessa);
         $horas = round(($segundos/60/60));
         if ($horas>='48') {
            $total_fln=$total_fln+1;
         }
      }
      
      mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
      mysql_select_db($banco_d) or die ("Banco de dados inexistente");
      //conta o total de hawb´s em aberto
      //Total base fpolis
      $contagem= mysql_query("SELECT dt_remessa FROM remessa
      WHERE ((dt_envio='0000-00-00')
      AND (escritorio='002')
      AND (dt_remessa>'2012-12-01'))");
      while ($row = mysql_fetch_array($contagem)) {
         $dt_remessa    =$row[0];
         $v_dt_remessa=mktime(0,0,0,(substr($dt_remessa,5,2)),(substr($dt_remessa,8,2)),(substr($dt_remessa,0,4)));
         $segundos = ($v_hoje-$v_dt_remessa);
         $horas = round(($segundos/60/60));
         if ($horas>='48') {
            $total_cur=$total_cur+1;
         }
      }
      
      $total_ge=$total_cur+$total_fln;
      
    ?>

    <HTML>
    <HEAD>
     <TITLE>mostra_monitoramento_servicos.php</TITLE>
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

    </HEAD>
    <div id="geral" align="center">
        <body topmargin="0" leftmargin="0" rightmargin="0" bottommargin="0" marginheight="0" marginwidth="0" bgcolor="#FFFFFF">
        <table border="0" width="100%" cellspacing="0" cellpadding="0" background="img/blue.jpg">
         <tr>
           <td width="50%">
             <p align="left"><font face="Arial" size="2" color="#FFFFFF"><b>Sistema de Gerenciamento da Logística de Encomendas</b></font></td>
           <td width="50%">
             <p align="right"><font face="Arial" size="2" color="#FFFFFF"><b>Relação de HAWB´s Abertas a Mais de 48 Horas</b></font></td>
         </tr>
       </table>
    <BODY>
    <table width="40%" border="1" cellpadding="5" cellspacing="0" bordercolor="#6495ED">
       <form name="cadastro" action="mostra_hawb_vencida_mais_48.php" border="20">
       <table width="50%" border="1" cellpadding="5" cellspacing="0" bordercolor="#4169E1">
          <TR><td colspan="4" align="center"><b><font face="arial" size="4">RELAÇÃO DE HAWB´s VENCIDAS</font></b></td></tr>
          <tr>
             <td width="55%" align="center"><b>CLASSIFICAÇÃO</b></td>
             <td width="15%" align="center"><b>BASE CUR.</b></td>
             <td width="15%" align="center"><b>BASE FLN.</b></td>
             <td width="15%" align="center"><b>TOTAL</b></td>
          </tr>
          <tr>
             <td width="55%"><b>HAWB´s PENDENTES : </b></td>
             <td width="15%"><font face="arial" size="3" color="red"><?php echo "$total_cur";?></font></td>
             <td width="15%"><font face="arial" size="3" color="red"><?php echo "$total_fln";?></font></td>
             <td width="15%"><font face="arial" size="3" color="red"><?php echo "$total_ge";?></font></td>
          </tr>
       </table>
       <table width="95%" border="1" cellpadding="5" cellspacing="0" bordercolor="#4169E1">
        <tr><td colspan="14" align="center"><font face="arial" size="3"><b>HAWB´s VENCIDAS</b></font></tr>
        <tr>
         <td width="5%" align="center"><b>HAWB</b></td>
         <td width="7%" align="center"><b>BASE</b></td>
         <td width="7%" align="center"><b>ENTREGADOR</b></td>
         <td width="12%" align="center"><b>CLIENTE</b></td>
         <td width="9%" align="center"><b>SERVIÇO</b></td>
         <td width="15%" align="center"><b>DESTINATARIO</b></td>
         <td width="10%" align="center"><b>CIDADE</b></td>
         <td width="5%" align="center"><b>BIP 1</b></td>
         <td width="5%" align="center"><b>BIP 2</b></td>
         <td width="5%" align="center"><b>BIP 3</b></td>
         <td width="5%" align="center"><b>DT. BAIXA</b></td>
         <td width="5%" align="center"><b>DEV. ENT.</b></td>
         <td width="5%" align="center"><b>BIP 4</b></td>
         <td width="5%" align="center"><b>HORAS</b></td>
        </tr>
        <?php
          $v_hoje   =$_SESSION['v_hoje_m'];
          mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
          mysql_select_db($banco_d) or die ("Banco de dados inexistente");

          $result = mysql_query("SELECT remessa.n_hawb,cli_for.nome,remessa.nome_desti,remessa.cidade_desti,
          serv_ati.descri_se,regi_dep.nome,date_format(remessa.dt_remessa,'%d/%m/%Y'),date_format(remessa.dt_lista,'%d/%m/%Y'),
          date_format(remessa.dt_entrega,'%d/%m/%Y'),date_format(remessa.dt_baixa,'%d/%m/%Y'),
          date_format(remessa.dt_devolucao,'%d/%m/%Y'),date_format(remessa.dt_envio,'%d/%m/%Y'),
          CASE
             WHEN remessa.entregador <>'' THEN (SELECT nome FROM pessoa WHERE matricula=remessa.entregador)
             ELSE 'NA BASE'
          END as nome_entrega,(DATEDIFF(CURDATE(),dt_remessa)*24) as horas
          FROM remessa,cli_for,serv_ati,regi_dep
          WHERE ((remessa.codi_cli=cli_for.cnpj_cpf)
          AND (remessa.co_servico=serv_ati.codigo_se)
          AND (remessa.escritorio=regi_dep.codigo)
          AND (remessa.dt_remessa>'2012-12-01')
          AND (remessa.dt_envio='0000-00-00')
          AND ((DATEDIFF(CURDATE(),dt_remessa)*24)>='48'))
          ORDER BY remessa.dt_remessa");

          while ($dados = mysql_fetch_array($result)) {
    	     $n_hawb          =$dados[0];
    	     $cliente         =$dados[1];
    	     $destino         =$dados[2];
    	     $cidade          =$dados[3];
    	     $servico         =$dados[4];
    	     $base            =$dados[5];
    	     $dt_hawb         =$dados[6];
    	     $dt_lista        =$dados[7];
    	     $dt_entrega      =$dados[8];
    	     $dt_baixa        =$dados[9];
    	     $dt_devolucao    =$dados[10];
    	     $dt_envio        =$dados[11];
             $entregador      =$dados[12];
             $horas           =$dados[13];

             echo "<tr>";
    	     echo "<td width=\"5%\" align=\"left\"><font size=\"1\" face=\"arial\">$n_hawb</font></td>";
    	     echo "<td width=\"7%\"><font size=\"1\" face=\"arial\">$base</font></td>";
    	     if ($entregador=='NA BASE') {
    	        echo "<td width=\"7%\"><font size=\"1\" face=\"arial\" color=\"red\">$entregador</font></td>";
    	     }
             else {
                echo "<td width=\"7%\"><font size=\"1\" face=\"arial\">$entregador</font></td>";
             }
    	     echo "<td width=\"12%\"><font size=\"1\" face=\"arial\">$cliente</font></td>";
    	     echo "<td width=\"9%\"><font size=\"1\" face=\"arial\">$servico</font></td>";
    	     echo "<td width=\"15%\"><font size=\"1\" face=\"arial\">$destino</font></td>";
    	     echo "<td width=\"10%\"><font size=\"1\" face=\"arial\">$cidade</font></td>";
    	     echo "<td width=\"5%\"><font size=\"1\" face=\"arial\">$dt_hawb</font></td>";
    	     if ($dt_lista<>'00/00/0000') {
    	         echo "<td width=\"5%\"><font size=\"2\" face=\"arial\" color=\"red\">$dt_lista</font></td>";
    	     }
    	     else {
                $dt_lista='';
    	        echo "<td width=\"5%\"><font size=\"2\" face=\"arial\" color=\"black\">$dt_lista</font></td>";
    	     }
    	     if ($dt_entrega<>'00/00/0000') {
    	        echo "<td width=\"5%\"><font size=\"2\" face=\"arial\" color=\"green\">$dt_entrega</font></td>";
    	     }
    	     else {
                $dt_entrega='';
    	        echo "<td width=\"5%\"><font size=\"2\" face=\"arial\" color=\"black\">$dt_entrega</font></td>";
    	     }
    	     if ($dt_baixa<>'00/00/0000') {
    	        echo "<td width=\"5%\"><font size=\"2\" face=\"arial\">$dt_baixa</font></td>";
    	     }
    	     else {
                $dt_baixa='';
    	        echo "<td width=\"5%\"><font size=\"2\" face=\"arial\">$dt_baixa</font></td>";
    	     }
    	     if ($dt_devolucao<>'00/00/0000') {
    	        echo "<td width=\"5%\"><font size=\"2\" face=\"arial\">$dt_devolucao</font></td>";
    	     }
    	     else {
    	        $dt_devolucao='';
    	        echo "<td width=\"5%\"><font size=\"2\" face=\"arial\">$dt_devolucao</font></td>";
    	     }
    	     if ($dt_envio<>'00/00/0000') {
    	         echo "<td width=\"5%\"><font size=\"2\" face=\"arial\">$dt_envio</font></td>";
    	     }
    	     else {
    	         $dt_envio='';
    	         echo "<td width=\"5%\"><font size=\"2\" face=\"arial\">$dt_envio</font></td>";
    	     }
    	     echo "<td width=\"5%\"><font size=\"2\" face=\"arial\">$horas</font></td>";
             echo "</tr>";
          }
    ?>
</table>
</form>
</BODY>
</HTML>
