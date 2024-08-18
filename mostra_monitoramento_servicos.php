<?php
  session_start();

      $r_dt_inicio   =$_SESSION['dt_inicio_m'];
      $r_dt_fim      =$_SESSION['dt_fim_m'];
      
      $dt_inicio     =$_SESSION['dt_inicio_v'];
      $dt_fim        =$_SESSION['dt_fim_v'];

      $base_d     =$_SESSION['base_d'];
      $banco_d    =$_SESSION['banco_d'];
      $usuario_d  =$_SESSION['usuario_d'];
      $senha_d    =$_SESSION['senha_d'];
      
      mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
      mysql_select_db($banco_d) or die ("Banco de dados inexistente");
      
      //conta o total de hawb´s do período em monitoramento
      //Total base Curitiba
      $contagem=mysql_query("SELECT COUNT(n_remessa) AS tot_hawb FROM remessa
      WHERE ((dt_remessa>='$r_dt_inicio')
      AND (dt_remessa<='$r_dt_fim')
      AND (escritorio='002'))");
      $total = mysql_num_rows($contagem);
      for($i=0; $i<$total; $i++){
         $dados = mysql_fetch_row($contagem);
         $total_cur      =$dados[0];
      }
      
      //Total base Fpolis
      $contagem_1=mysql_query("SELECT COUNT(n_remessa) AS tot_hawb FROM remessa
      WHERE ((dt_remessa>='$r_dt_inicio')
      AND (dt_remessa<='$r_dt_fim')
      AND (escritorio='001'))");
      $total = mysql_num_rows($contagem_1);
      for($i=0; $i<$total; $i++){
         $dados = mysql_fetch_row($contagem_1);
         $total_fln      =$dados[0];
      }

      //Total base blumenau
      $contagem_2=mysql_query("SELECT COUNT(n_remessa) AS tot_hawb FROM remessa
      WHERE ((dt_remessa>='$r_dt_inicio')
      AND (dt_remessa<='$r_dt_fim')
      AND (escritorio='003'))");
      $total = mysql_num_rows($contagem_2);
      for($i=0; $i<$total; $i++){
         $dados = mysql_fetch_row($contagem_2);
         $total_blu      =$dados[0];
      }

      //Total base joinville
      $contagem_3=mysql_query("SELECT COUNT(n_remessa) AS tot_hawb FROM remessa
      WHERE ((dt_remessa>='$r_dt_inicio')
      AND (dt_remessa<='$r_dt_fim')
      AND (escritorio='004'))");
      $total = mysql_num_rows($contagem_3);
      for($i=0; $i<$total; $i++){
         $dados = mysql_fetch_row($contagem_3);
         $total_joi      =$dados[0];
      }
      $total_ge=$total_cur+$total_fln+$total_blu+$total_joi;
      
      //Conta POD´s com imagem mandadas para o servidor ou não
      //Total base Curitiba
      $contagem_30=mysql_query("SELECT n_hawb FROM remessa
      WHERE ((dt_remessa>='$r_dt_inicio')
      AND (dt_remessa<='$r_dt_fim')
      AND (escritorio='002'))");
      $total = mysql_num_rows($contagem_30);
      for($i=0; $i<$total; $i++){
         $dados = mysql_fetch_row($contagem_30);
         $n_hawb       =$dados[0];
         $path ='hawbs/';
         $exte ='.gif';
         if(file_exists("$path$n_hawb$exte")) {
              $total_imag_cur=$total_imag_cur+1;
         }
         else {
              $total_imag_cur_nao=$total_imag_cur_nao+1;
         }
      }
      
      //Total base Florianópolis
      $contagem_31=mysql_query("SELECT n_hawb FROM remessa
      WHERE ((dt_remessa>='$r_dt_inicio')
      AND (dt_remessa<='$r_dt_fim')
      AND (escritorio='001'))");
      $total = mysql_num_rows($contagem_31);
      for($i=0; $i<$total; $i++){
         $dados = mysql_fetch_row($contagem_31);
         $n_hawb       =$dados[0];
         $path ='hawbs/';
         $exte ='.gif';
         if(file_exists("$path$n_hawb$exte")) {
              $total_imag_fln=$total_imag_fln+1;
         }
         else {
              $total_imag_fln_nao=$total_imag_fln_nao+1;
         }
      }
      
      //Total base blumenau
      $contagem_32=mysql_query("SELECT n_hawb FROM remessa
      WHERE ((dt_remessa>='$r_dt_inicio')
      AND (dt_remessa<='$r_dt_fim')
      AND (escritorio='003'))");
      $total = mysql_num_rows($contagem_32);
      for($i=0; $i<$total; $i++){
         $dados = mysql_fetch_row($contagem_32);
         $n_hawb       =$dados[0];
         $path ='hawbs/';
         $exte ='.gif';
         if(file_exists("$path$n_hawb$exte")) {
              $total_imag_blu=$total_imag_blu+1;
         }
         else {
              $total_imag_blu_nao=$total_imag_blu_nao+1;
         }
      }

      //Total base joinville
      $contagem_33=mysql_query("SELECT n_hawb FROM remessa
      WHERE ((dt_remessa>='$r_dt_inicio')
      AND (dt_remessa<='$r_dt_fim')
      AND (escritorio='004'))");
      $total = mysql_num_rows($contagem_33);
      for($i=0; $i<$total; $i++){
         $dados = mysql_fetch_row($contagem_33);
         $n_hawb       =$dados[0];
         $path ='hawbs/';
         $exte ='.gif';
         if(file_exists("$path$n_hawb$exte")) {
              $total_imag_joi=$total_imag_joi+1;
         }
         else {
              $total_imag_joi_nao=$total_imag_joi_nao+1;
         }
      }
      $total_imag_ge     =$total_imag_cur+$total_imag_fln+$total_imag_blu+$total_imag_joi;
      $total_imag_nao_ge =$total_imag_cur_nao+$total_imag_fln_nao+$total_imag_blu_nao+$total_imag_joi_nao;
      
      //conta o total de hawb´s em lista de entrega
      //Base curitiba
      $contagem_4=mysql_query("SELECT COUNT(n_remessa) AS tot_lista FROM remessa
      WHERE ((dt_remessa>='$r_dt_inicio')
      AND (dt_remessa<='$r_dt_fim')
      AND (dt_lista<>'0000-00-00')
      AND (escritorio='002'))");
      $total = mysql_num_rows($contagem_4);
      for($i=0; $i<$total; $i++){
         $dados = mysql_fetch_row($contagem_4);
         $total_lista_cur      =$dados[0];
      }

      //Base Fpolis
      $contagem_5=mysql_query("SELECT COUNT(n_remessa) AS tot_lista FROM remessa
      WHERE ((dt_remessa>='$r_dt_inicio')
      AND (dt_remessa<='$r_dt_fim')
      AND (dt_lista<>'0000-00-00')
      AND (escritorio='001'))");
      $total = mysql_num_rows($contagem_5);
      for($i=0; $i<$total; $i++){
         $dados = mysql_fetch_row($contagem_5);
         $total_lista_fln      =$dados[0];
      }

      //Base Blumenau
      $contagem_5=mysql_query("SELECT COUNT(n_remessa) AS tot_lista FROM remessa
      WHERE ((dt_remessa>='$r_dt_inicio')
      AND (dt_remessa<='$r_dt_fim')
      AND (dt_lista<>'0000-00-00')
      AND (escritorio='003'))");
      $total = mysql_num_rows($contagem_5);
      for($i=0; $i<$total; $i++){
         $dados = mysql_fetch_row($contagem_5);
         $total_lista_blu      =$dados[0];
      }
      
      //Base Joinville
      $contagem_6=mysql_query("SELECT COUNT(n_remessa) AS tot_lista FROM remessa
      WHERE ((dt_remessa>='$r_dt_inicio')
      AND (dt_remessa<='$r_dt_fim')
      AND (dt_lista<>'0000-00-00')
      AND (escritorio='004'))");
      $total = mysql_num_rows($contagem_6);
      for($i=0; $i<$total; $i++){
         $dados = mysql_fetch_row($contagem_6);
         $total_lista_joi      =$dados[0];
      }
      $total_lista_ge=$total_lista_cur+$total_lista_fln+$total_lista_blu+$total_lista_joi;
      
      //conta o total de hawb´s entregue
      //Base Curitiba
      $contagem_7=mysql_query("SELECT COUNT(n_remessa) AS tot_entrega FROM remessa
      WHERE ((dt_remessa>='$r_dt_inicio')
      AND (dt_remessa<='$r_dt_fim')
      AND (dt_entrega<>'0000-00-00')
      AND (escritorio='002'))");
      $total = mysql_num_rows($contagem_7);
      for($i=0; $i<$total; $i++){
         $dados = mysql_fetch_row($contagem_7);
         $total_entregue_cur      =$dados[0];
      }

      //Base Fpolis
      $contagem_8=mysql_query("SELECT COUNT(n_remessa) AS tot_entrega FROM remessa
      WHERE ((dt_remessa>='$r_dt_inicio')
      AND (dt_remessa<='$r_dt_fim')
      AND (dt_entrega<>'0000-00-00')
      AND (escritorio='001'))");
      $total = mysql_num_rows($contagem_8);
      for($i=0; $i<$total; $i++){
         $dados = mysql_fetch_row($contagem_8);
         $total_entregue_fln      =$dados[0];
      }

      //Base blumenau
      $contagem_9=mysql_query("SELECT COUNT(n_remessa) AS tot_entrega FROM remessa
      WHERE ((dt_remessa>='$r_dt_inicio')
      AND (dt_remessa<='$r_dt_fim')
      AND (dt_entrega<>'0000-00-00')
      AND (escritorio='003'))");
      $total = mysql_num_rows($contagem_9);
      for($i=0; $i<$total; $i++){
         $dados = mysql_fetch_row($contagem_9);
         $total_entregue_blu      =$dados[0];
      }
      
      //Base joinville
      $contagem_10=mysql_query("SELECT COUNT(n_remessa) AS tot_entrega FROM remessa
      WHERE ((dt_remessa>='$r_dt_inicio')
      AND (dt_remessa<='$r_dt_fim')
      AND (dt_entrega<>'0000-00-00')
      AND (escritorio='004'))");
      $total = mysql_num_rows($contagem_10);
      for($i=0; $i<$total; $i++){
         $dados = mysql_fetch_row($contagem_10);
         $total_entregue_joi      =$dados[0];
      }
      $total_entregue_ge=$total_entregue_cur+$total_entregue_fln+$total_entregue_blu+$total_entregue_joi;

      //conta o total de hawb´s baixada no sistema
      //Base Curitiba
      $contagem_11=mysql_query("SELECT COUNT(n_remessa) AS tot_baixa FROM remessa
      WHERE ((dt_remessa>='$r_dt_inicio')
      AND (dt_remessa<='$r_dt_fim')
      AND (dt_baixa<>'0000-00-00')
      AND (escritorio='002'))");
      $total = mysql_num_rows($contagem_11);
      for($i=0; $i<$total; $i++){
         $dados = mysql_fetch_row($contagem_11);
         $total_baixa_cur      =$dados[0];
      }

      //Base Fpolis
      $contagem_12=mysql_query("SELECT COUNT(n_remessa) AS tot_baixa FROM remessa
      WHERE ((dt_remessa>='$r_dt_inicio')
      AND (dt_remessa<='$r_dt_fim')
      AND (dt_baixa<>'0000-00-00')
      AND (escritorio='001'))");
      $total = mysql_num_rows($contagem_12);
      for($i=0; $i<$total; $i++){
         $dados = mysql_fetch_row($contagem_12);
         $total_baixa_fln      =$dados[0];
      }

      //Base blumenau
      $contagem_13=mysql_query("SELECT COUNT(n_remessa) AS tot_baixa FROM remessa
      WHERE ((dt_remessa>='$r_dt_inicio')
      AND (dt_remessa<='$r_dt_fim')
      AND (dt_baixa<>'0000-00-00')
      AND (escritorio='003'))");
      $total = mysql_num_rows($contagem_13);
      for($i=0; $i<$total; $i++){
         $dados = mysql_fetch_row($contagem_13);
         $total_baixa_blu      =$dados[0];
      }

      //Base joinville
      $contagem_14=mysql_query("SELECT COUNT(n_remessa) AS tot_baixa FROM remessa
      WHERE ((dt_remessa>='$r_dt_inicio')
      AND (dt_remessa<='$r_dt_fim')
      AND (dt_baixa<>'0000-00-00')
      AND (escritorio='004'))");
      $total = mysql_num_rows($contagem_14);
      for($i=0; $i<$total; $i++){
         $dados = mysql_fetch_row($contagem_14);
         $total_baixa_joi      =$dados[0];
      }
      $total_baixa_ge=$total_baixa_cur+$total_baixa_fln+$total_baixa_blu+$total_baixa_joi;

      //conta o total de hawb´s devolvida a origem
      //Base Curitiba
      $contagem_15=mysql_query("SELECT COUNT(n_remessa) AS tot_oreigem FROM remessa
      WHERE ((dt_remessa>='$r_dt_inicio')
      AND (dt_remessa<='$r_dt_fim')
      AND (dt_envio<>'0000-00-00')
      AND (escritorio='002'))");
      $total = mysql_num_rows($contagem_15);
      for($i=0; $i<$total; $i++){
         $dados = mysql_fetch_row($contagem_15);
         $total_origem_cur      =$dados[0];
      }
      //Base Fplois
      $contagem_16=mysql_query("SELECT COUNT(n_remessa) AS tot_oreigem FROM remessa
      WHERE ((dt_remessa>='$r_dt_inicio')
      AND (dt_remessa<='$r_dt_fim')
      AND (dt_envio<>'0000-00-00')
      AND (escritorio='001'))");
      $total = mysql_num_rows($contagem_16);
      for($i=0; $i<$total; $i++){
         $dados = mysql_fetch_row($contagem_16);
         $total_origem_fln      =$dados[0];
      }
      
      //Base blumenau
      $contagem_17=mysql_query("SELECT COUNT(n_remessa) AS tot_oreigem FROM remessa
      WHERE ((dt_remessa>='$r_dt_inicio')
      AND (dt_remessa<='$r_dt_fim')
      AND (dt_envio<>'0000-00-00')
      AND (escritorio='003'))");
      $total = mysql_num_rows($contagem_17);
      for($i=0; $i<$total; $i++){
         $dados = mysql_fetch_row($contagem_17);
         $total_origem_blu      =$dados[0];
      }
      
      //Base joinville
      $contagem_18=mysql_query("SELECT COUNT(n_remessa) AS tot_oreigem FROM remessa
      WHERE ((dt_remessa>='$r_dt_inicio')
      AND (dt_remessa<='$r_dt_fim')
      AND (dt_envio<>'0000-00-00')
      AND (escritorio='004'))");
      $total = mysql_num_rows($contagem_18);
      for($i=0; $i<$total; $i++){
         $dados = mysql_fetch_row($contagem_18);
         $total_origem_joi      =$dados[0];
      }
      $total_origem_ge=$total_origem_cur+$total_origem_fln+$total_origem_blu+$total_origem_joi;
      
      //conta o total de hawb´s com processo imcompleto
      //Base Curitiba
      $contagem_19=mysql_query("SELECT COUNT(n_remessa) AS tot_oreigem FROM remessa
      WHERE ((dt_remessa>='$r_dt_inicio')
      AND (dt_remessa<='$r_dt_fim')
      AND (dt_envio='0000-00-00')
      AND (escritorio='002'))");
      $total = mysql_num_rows($contagem_19);
      for($i=0; $i<$total; $i++){
         $dados = mysql_fetch_row($contagem_19);
         $total_incom_cur      =$dados[0];
      }
      //Base Fplois
      $contagem_20=mysql_query("SELECT COUNT(n_remessa) AS tot_oreigem FROM remessa
      WHERE ((dt_remessa>='$r_dt_inicio')
      AND (dt_remessa<='$r_dt_fim')
      AND (dt_envio='0000-00-00')
      AND (escritorio='001'))");
      $total = mysql_num_rows($contagem_20);
      for($i=0; $i<$total; $i++){
         $dados = mysql_fetch_row($contagem_20);
         $total_incom_fln      =$dados[0];
      }
      
      //Base blumenau
      $contagem_20=mysql_query("SELECT COUNT(n_remessa) AS tot_oreigem FROM remessa
      WHERE ((dt_remessa>='$r_dt_inicio')
      AND (dt_remessa<='$r_dt_fim')
      AND (dt_envio='0000-00-00')
      AND (escritorio='003'))");
      $total = mysql_num_rows($contagem_20);
      for($i=0; $i<$total; $i++){
         $dados = mysql_fetch_row($contagem_20);
         $total_incom_blu      =$dados[0];
      }
      
      //Base joinville
      $contagem_21=mysql_query("SELECT COUNT(n_remessa) AS tot_oreigem FROM remessa
      WHERE ((dt_remessa>='$r_dt_inicio')
      AND (dt_remessa<='$r_dt_fim')
      AND (dt_envio='0000-00-00')
      AND (escritorio='004'))");
      $total = mysql_num_rows($contagem_21);
      for($i=0; $i<$total; $i++){
         $dados = mysql_fetch_row($contagem_21);
         $total_incom_joi      =$dados[0];
      }
      $total_incom_ge=$total_incom_cur+$total_incom_fln+$total_incom_blu+$total_incom_joi;
      
    ?>

    <HTML>
    <HEAD>
     <TITLE>mostra_monitoramento_servicos.php</TITLE>
     <meta HTTP-EQUIV="refresh" CONTENT="500">
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
             <p align="right"><font face="Arial" size="2" color="#FFFFFF"><b>Monitoramento dos serviços</b></font></td>
         </tr>
       </table>
         <table width="100%" border="0" cellspacing="0" cellpadding="0">
           <tr>
             <td colspan="1" align="left" width="45%"><INPUT type=button size="3" value="Ajuda"
                   onClick="window.open('mostra_ajuda.php','janela_1',
                   'scrollbars=yes,resizable=yes,width=400,height=700');" style="width:100;height:30;color=red;font: bold 16px Arial;">
             </td>
             <td colspan="1" color="white" align="right" width="45%" height="70"><a href="monitoramento_servicos.php"><img src="img/porta.gif" border="none"></td>
           </tr>
       </table>
    <BODY>
    <table width="40%" border="1" cellpadding="5" cellspacing="0" bordercolor="#6495ED">
       <form name="cadastro" action="mostra_monitoramento_servicos.php" border="20">
       <table width="70%" border="1" cellpadding="5" cellspacing="0" bordercolor="#4169E1">
          <TR><td colspan="6" align="center"><b><font face="arial" size="4">SITUAÇÃO DOS SERVIÇOS NO PERIODO INFORMADO</font></b></td></tr>
          <tr>
             <td width="50%" align="center"><b>CLASSIFICAÇÃO</b></td>
             <td width="10%" align="center"><b>BASE CUR.</b></td>
             <td width="10%" align="center"><b>BASE FLN.</b></td>
             <td width="10%" align="center"><b>BASE BLU.</b></td>
             <td width="10%" align="center"><b>BASE JOI.</b></td>
             <td width="10%" align="center"><b>TOTAL</b></td>
          </tr>
          <tr>
             <td width="50%"><b>HAWB´s Recebidas (BIP 1 OK): </b></td>
             <td width="10%"><font face="arial" size="3" color="red"><?php echo "$total_cur";?></font></td>
             <td width="10%"><font face="arial" size="3" color="red"><?php echo "$total_fln";?></font></td>
             <td width="10%"><font face="arial" size="3" color="red"><?php echo "$total_blu";?></font></td>
             <td width="10%"><font face="arial" size="3" color="red"><?php echo "$total_joi";?></font></td>
             <td width="10%"><font face="arial" size="3" color="red"><?php echo "$total_ge";?></font></td>
          </tr>
          <tr>
             <td width="50%"><b>HAWB´s Em Lista Entrega (BIP 2 OK) : </b></td>
             <td width="10%"><font face="arial" size="3" color="red"><?php echo "$total_lista_cur ";?></font></td>
             <td width="10%"><font face="arial" size="3" color="red"><?php echo "$total_lista_fln ";?></font></td>
             <td width="10%"><font face="arial" size="3" color="red"><?php echo "$total_lista_blu ";?></font></td>
             <td width="10%"><font face="arial" size="3" color="red"><?php echo "$total_lista_joi ";?></font></td>
             <td width="10%"><font face="arial" size="3" color="red"><?php echo "$total_lista_ge";?></font></td>
          </tr>
          <tr>
             <td width="50%"><b>HAWB´s Entregues (BIP 3 OK): </b></td>
             <td width="10%"><font face="arial" size="3" color="red"><?php echo "$total_entregue_cur";?></font></td>
             <td width="10%"><font face="arial" size="3" color="red"><?php echo "$total_entregue_fln";?></font></td>
             <td width="10%"><font face="arial" size="3" color="red"><?php echo "$total_entregue_blu";?></font></td>
             <td width="10%"><font face="arial" size="3" color="red"><?php echo "$total_entregue_joi";?></font></td>
             <td width="10%"><font face="arial" size="3" color="red"><?php echo "$total_entregue_ge";?></font></td>
          </tr>
          <tr>
             <td width="50%"><b>HAWB´s Baixadas : </b></td>
             <td width="10%"><font face="arial" size="3" color="red"><?php echo "$total_baixa_cur";?></font></td>
             <td width="10%"><font face="arial" size="3" color="red"><?php echo "$total_baixa_fln";?></font></td>
             <td width="10%"><font face="arial" size="3" color="red"><?php echo "$total_baixa_blu";?></font></td>
             <td width="10%"><font face="arial" size="3" color="red"><?php echo "$total_baixa_joi";?></font></td>
             <td width="10%"><font face="arial" size="3" color="red"><?php echo "$total_baixa_ge";?></font></td>
          </tr>
          <tr>
             <td width="50%"><b>HAWB´s Devolvida Origem (BIP 4 OK): </b></td>
             <td width="10%"><font face="arial" size="3" color="red"><?php echo "$total_origem_cur";?></font></td>
             <td width="10%"><font face="arial" size="3" color="red"><?php echo "$total_origem_fln";?></font></td>
             <td width="10%"><font face="arial" size="3" color="red"><?php echo "$total_origem_blu";?></font></td>
             <td width="10%"><font face="arial" size="3" color="red"><?php echo "$total_origem_joi";?></font></td>
             <td width="10%"><font face="arial" size="3" color="red"><?php echo "$total_origem_ge";?></font></td>
          </tr>
          <tr>
             <td width="50%"><b>HAWB´s com processo incompleto : </b></td>
             <td width="10%"><font face="arial" size="3" color="red"><?php echo "$total_incom_cur";?></font></td>
             <td width="10%"><font face="arial" size="3" color="red"><?php echo "$total_incom_fln";?></font></td>
             <td width="10%"><font face="arial" size="3" color="red"><?php echo "$total_incom_blu";?></font></td>
             <td width="10%"><font face="arial" size="3" color="red"><?php echo "$total_incom_joi";?></font></td>
             <td width="10%"><font face="arial" size="3" color="red"><?php echo "$total_incom_ge";?></font></td>
          </tr>
          <tr>
             <td width="50%"><b>HAWB´s com imagem : </b></td>
             <td width="10%"><font face="arial" size="3" color="red"><?php echo "$total_imag_cur";?></font></td>
             <td width="10%"><font face="arial" size="3" color="red"><?php echo "$total_imag_fln";?></font></td>
             <td width="10%"><font face="arial" size="3" color="red"><?php echo "$total_imag_blu";?></font></td>
             <td width="10%"><font face="arial" size="3" color="red"><?php echo "$total_imag_joi";?></font></td>
             <td width="10%"><font face="arial" size="3" color="red"><?php echo "$total_imag_ge";?></font></td>
          </tr>
          <tr>
             <td width="50%"><b>HAWB´s sem imagem : </b></td>
             <td width="10%"><font face="arial" size="3" color="red"><?php echo "$total_imag_cur_nao";?></font></td>
             <td width="10%"><font face="arial" size="3" color="red"><?php echo "$total_imag_fln_nao";?></font></td>
             <td width="10%"><font face="arial" size="3" color="red"><?php echo "$total_imag_blu_nao";?></font></td>
             <td width="10%"><font face="arial" size="3" color="red"><?php echo "$total_imag_joi_nao";?></font></td>
             <td width="10%"><font face="arial" size="3" color="red"><?php echo "$total_imag_nao_ge";?></font></td>
          </tr>
       </table>
       <table width="95%" border="1" cellpadding="5" cellspacing="0" bordercolor="#4169E1">
        <tr><td colspan="14" align="center"><font face="arial" size="3"><b>HAWB´s COM ETAPA IMCOMPLETA - PERÍODO :</b><font face="arial" size="2" color="red"><?php echo "$dt_inicio";?></font> A  <font face="arial" size="2" color="red"><?php echo "$dt_fim";?></font></tr>
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
         <td width="5%" align="center"><b>IMAGEM</b></td>
         <td width="5%" align="center"><b>DEV.ENT.</b></td>
         <td width="5%" align="center"><b>BIP 4</b></td>
        </tr>
        <?php
          mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
          mysql_select_db($banco_d) or die ("Banco de dados inexistente");

          $resultado = mysql_query ("SELECT remessa.n_hawb,cli_for.nome,remessa.nome_desti,remessa.cidade_desti,
          serv_ati.descri_se,regi_dep.nome,
          date_format(remessa.dt_remessa,'%d/%m/%Y'),date_format(remessa.dt_lista,'%d/%m/%Y'),
          date_format(remessa.dt_entrega,'%d/%m/%Y'),date_format(remessa.dt_baixa,'%d/%m/%Y'),
          date_format(remessa.dt_devolucao,'%d/%m/%Y'),date_format(remessa.dt_envio,'%d/%m/%Y'),
          CASE
             WHEN remessa.entregador <>'' THEN (SELECT nome FROM cli_for WHERE cnpj_cpf=remessa.entregador)
             ELSE 'NA BASE'
          END as nome_entrega
          FROM remessa,cli_for,serv_ati,regi_dep
          WHERE ((remessa.dt_remessa>='$r_dt_inicio')
          AND (remessa.dt_remessa<='$r_dt_fim')
          AND (remessa.codi_cli=cli_for.cnpj_cpf)
          AND (remessa.co_servico=serv_ati.codigo_se)
          AND (remessa.escritorio=regi_dep.codigo))
          ORDER BY remessa.entregador,remessa.dt_remessa DESC");
          $total = mysql_num_rows($resultado);

          for($i=0; $i<$total; $i++){
             $dados = mysql_fetch_row($resultado);
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
    	     echo "<td width=\"20%\"><font size=\"1\" face=\"arial\">$destino</font></td>";
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
    	     $path ='hawbs/';
             $exte ='.gif';
             if(file_exists("$path$n_hawb$exte")) {
                $imagem='SIM';
                echo "<td width=\"5%\"><font size=\"2\" face=\"arial\">$imagem</font></td>";
             }
             else {
                $imagem='NÃO';
                echo "<td width=\"5%\"><font size=\"2\" face=\"arial\" color=\"red\">$imagem</font></td>";
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
             echo "</tr>";
          }
    ?>
</table>
</form>
</BODY>
</HTML>
