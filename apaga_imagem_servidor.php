<?php
  session_start();
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
    <title>apaga_imagem_servidor</title>
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
      <body>
      <div id="geral" align="center">
        <body topmargin="0" leftmargin="0" rightmargin="0" bottommargin="0" marginheight="0" marginwidth="0" bgcolor="#FFFFFF">

         <table border="0" width="100%" bgcolor="#000000" cellspacing="0" cellpadding="0">
          <tr>
            <td width="20%" height="100" background="img/topleft.jpg"></td>
            <td width="658" height="110"> <img border="0" src="img/cabecalho_free_jazz.jpg" width="658" height="110" border="0"></td>
            <td width="15%" height="110">
            <p align="right"><img border="0" src="img/topright.jpg" width="160" height="110" border="0"></td>
         </tr>
        </table>
        <table border="0" width="100%" cellspacing="0" cellpadding="0" background="img/blue.jpg">
         <tr>
           <td width="50%">
             <p align="left"><font face="Arial" size="2" color="#FFFFFF"><b>Sistema de Gerenciamento da Logística de Encomendas</b></font></td>
           <td width="50%">
             <p align="right"><font face="Arial" size="2" color="#FFFFFF"><b>Exclui Imagem Servidor</b></font></td>
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
       <form name="cadastro" method="POST" action="apaga_imagem_servidor.php">
       <table width="400" border="1" cellpadding="5" cellspacing="0" bordercolor="#6495ED" align="center">
         <tr>
           <td><b>Data Inicio :</b></td>
           <td>
               <input type="text" name="data_ini" size="12" maxlength="12" id="data_ini">
               <input TYPE="button" NAME="btndata_ini" VALUE="..." Onclick="javascript:popdate('document.cadastro.data_ini','pop1','150',document.cadastro.data_ini.value)">
               <span id="pop1" style="position:absolute"></span>
           </td>
         </tr>
         <tr>
           <td><b>Data Fim :</b></td>
           <td>
               <input type="text" name="data_fim" size="12" maxlength="12" id="data_fim">
               <input TYPE="button" NAME="btndata_fim" VALUE="..." Onclick="javascript:popdate('document.cadastro.data_fim','pop2','150',document.cadastro.data_fim.value)">
               <span id="pop2" style="position:absolute"></span>
           </td>
         </tr>
         <tr>
             <td colspan="2">
    		   <div align="right">
    				<input name="mostra" type="submit" value="Mostrar">
    		   </div>
    		 </td>
         </tr>
       </table>
       <?php
       switch (get_post_action('mostra')) {

          case 'mostra':
              $data_ini             =$_POST['data_ini'];
              $data_fim             =$_POST['data_fim'];

              $data_ini_v  = explode("/",$data_ini);
              $v_data_ini = $data_ini_v[2]."-".$data_ini_v[1]."-".$data_ini_v[0];
              $v_dt_ini_co = strtotime($v_data_ini);
              $_SESSION['v_dt_ini_m']  =$v_dt_ini_co;
              

              $data_fim_v  = explode("/",$data_fim);
              $v_data_fim = $data_fim_v[2]."-".$data_fim_v[1]."-".$data_fim_v[0];
              $v_dt_fim_co = strtotime($v_data_fim);
              $_SESSION['v_dt_fim_m']  =$v_dt_fim_co;

              $_SESSION['data_ini_m']  =$data_ini;
              $_SESSION['data_fim_m']  =$data_fim;

               ?>
               <table width="400" border="1" cellpadding="0" cellspacing="0" bordercolor="#6495ED">
                   <tr><td colspan="3" align="center"><font size="3" color="blue">RELAÇÃO IMAGEM POD´s</font></td></tr>
                   <tr>
                      <td align="center">NOME DA IMAGEM</td>
                      <td align="center">DT IMAGEM</td>
                      <td align="center">Excluir</td>
                   </tr>

                   <?php
                   $diretorio = 'hawbs';
                   $ponteiro  = opendir($diretorio);
                   while ($nome_itens = readdir($ponteiro)) {
                       $itens[] = $nome_itens;
                   }
                   sort($itens);
                   foreach ($itens as $listar) {
                      if ($listar!="." && $listar!=".."){
                   		 if (is_dir($listar)) {
                			$pastas[]=$listar;
                		 } else{
                			$arquivos[]=$listar;
                		 } // fecha else
                      } // fecha if ($listar!="." && $listar!=".."){
                   } // fecha foreach ($itens as $listar) {

                   $data_ini_co  =$_SESSION['v_dt_ini_m'];
                   $data_fim_co  =$_SESSION['v_dt_fim_m'];
                   $total=0;
                   if ($arquivos != "") {
                      foreach($arquivos as $listar){
                          $data    = date ("d/m/Y", filemtime("hawbs/".$listar));
                          $v_data  = explode("/",$data);
                          $v_data_v = $v_data[2]."-".$v_data[1]."-".$v_data[0];
                          $v_data_co = strtotime($v_data_v);
                          if (($v_data_co>=$data_ini_co) and ($v_data_co<=$data_fim_co)) {
                              print "<tr>
                                 <td><font size='2' face='Verdana, Arial, Helvetica, sans-serif'>$listar</font></td>
                                 <td><font size='2' face='Verdana, Arial, Helvetica, sans-serif'>$data</font></td>
                                 <td align=\"center\"><a href='apaga_imagem_pod.php?arquivo=$listar'><img src='img/btn_excluir.gif' width='16' height='16' border='0'></a> </td>
                                 </tr>";
                              $total=$total+1;
                          }
                      }
                   }
                   echo "<tr><td><strong>TOTAL IMAGENS </strong></td><td><strong>$total</strong></td></tr>";
                   ?>
                   </table>
                   <?php
          break;
          default:
       }
  ?>
</form>
</html>
