<?php
  session_start();

 //carrega variaveis com dados para acessar o banco de dados

  $base_d     =$_SESSION['base_d'];
  $banco_d    =$_SESSION['banco_d'];
  $usuario_d  =$_SESSION['usuario_d'];
  $senha_d    =$_SESSION['senha_d'];

  $matricula_m  =$_SESSION['matricula_m'];
  $programa='A5';
  $_SESSION['programa_m']=$programa;
   
  /*$con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
  $res = mysql_select_db($banco_d) or die ("Banco de dados inexistente");

  $declara = "SELECT matricula,programa
  FROM permissoes
  WHERE ((matricula='$matricula_m') and (programa='$programa'))";

  $query = mysql_db_query($banco_d,$declara,$con) or die ("Não foi possivel acessar o banco");
  $achou = mysql_num_rows($query);*/


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
  <title>envia_imagem_selecionando.php</title>
  <head>
  <script language="JavaScript" type="text/JavaScript">
      ok=false;
      function CheckAll() {
          if(!ok){
        	  for (var i=0;i<document.cadastro.elements.length;i++) {
        		var x = document.cadastro.elements[i];
        		if (x.name == 'hawb[]') {
        				x.checked = true;
        				ok=true;
        			}
        		}
          }
    	  else{
    	      for (var i=0;i<document.cadastro.elements.length;i++) {
    		      var x = document.cadastro.elements[i];
    		      if (x.name == 'hawb[]') {
    			     x.checked = false;
    				 ok=false;
    			  }
    		  }
    	  }
      }
  </script>
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
         <p align="right"><font face="Arial" size="2" color="#FFFFFF"><b>Envia imagem POD´s Selecionados para Wihus</b></font></td>
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
  <?php
    switch (get_post_action('envia','mostra')) {
        case 'mostra':
             $data_envio  =$_POST['data_envio'];
             $dt_inicio   =$_POST['data_ini'];
             $dt_fim      =$_POST['data_fim'];
             
             $_SESSION['dt_inicio_d']  =$dt_inicio;
             $_SESSION['dt_fim_d']     =$dt_fim;
             
             //Altera formato de data para comparação
             $dt_inicio_r   = explode("/",$dt_inicio);
             $dia_i=$dt_inicio_r[0];
             $dia_i=sprintf("%02d", $dia_i);
             $mes_i=$dt_inicio_r[1];
             $mes_i=sprintf("%02d", $mes_i);
             $v_dt_inicio = $dt_inicio_r[2]."-".$mes_i."-".$dia_i;

             $dt_fim_r    = explode("/",$dt_fim);
             $dia_f=$dt_fim_r[0];
             $dia_f=sprintf("%02d", $dia_f);
             $mes_f=$dt_fim_r[1];
             $mes_f=sprintf("%02d", $mes_f);
             $v_dt_fim  = $dt_fim_r[2]."-".$mes_f."-".$dia_f;

             $_SESSION['dt_inicio_m']  =$v_dt_inicio;
             $_SESSION['dt_fim_m']     =$v_dt_fim;
             $_SESSION['entrada_m'] ='N';
        break;
    
        case 'envia':
             $data_envio  = explode("/",$data_envio);
             $mes =$data_envio[1];
             $mes =sprintf("%02d", $mes);
             $v_data_envio = $data_envio[2].$mes.$data_envio[0];
             $v_data_grava = $data_envio[2]."-".$data_envio[1]."-".$data_envio[0];
             
             //PEGA O NUMERO DO LOTE NO ARQUIVO E ADICIONA MAIS 1
             /*$con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
             $res = mysql_select_db($banco_d) or die ("Banco de dados inexistente");
             $ultimo = "SELECT nu_lote FROM lote_imagem ORDER BY nu_lote DESC LIMIT 1";

             $query = mysql_db_query($banco_d,$ultimo,$con) or die ("Não foi possivel acessar o banco");
             $total = mysql_num_rows($query);
             for($ic=0; $ic<$total; $ic++){
                $row = mysql_fetch_row($query);
                $lote     = $row[0];
             }*/

             //$transpo    ='0795636';
             //$filial     ='G10';
             //$lote       =$lote+1;
             //Acrecentando zero a esquerda do numero
             //$lote = sprintf("%06d", $lote);

             //ATIUALIZA A TABELA CONTROLE DE LOTE
             //$atualiza = "INSERT INTO lote_imagem(nu_lote,data_lote)
             //values('$lote','$data_grava')";

             //mysql_db_query($banco_d,$atualiza,$con);
             
             $con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
             $res = mysql_select_db($banco_d) or die ("Banco de dados inexistente");
             $num=0;
             if ($_POST['hawb']<>'') {
             
                 foreach($_POST['hawb'] as $hawb){

                    //echo "Nu HAWB :$hawb";
                   // echo "Arquivo grande :$imagem";
                    //echo "Arquivo local :$arq_hawb";
                    /* Conectar com o servidor FTP */
                   // $conecta = ftp_connect('www.wihus.com.br');
                    $conecta = ftp_connect('ftp.wihus.com.br');
                    if(!$conecta) die('Erro ao conectar com o servidor');

                    /* Autenticar no servidor */
                    //$login = ftp_login($conecta, 'dinheiro', '#251857@');
                    $login = ftp_login($conecta, 'wihus', 'wilna2010');

                    if(!$login) die('Erro ao autenticar');

                     /* Liga modo passivo */
                    ftp_pasv($conecta, true);
                    ftp_site($conecta, 'CHMOD 0777 /public_html/hawbs/');
                    //ftp_site($conecta, 'CHMOD 0777 /FreteReal/IMAGENS/');
                    $path ='hawbs/';
                    $exte ='.gif';
                    if(file_exists("$path$hawb$exte")) {
                         $imagem=$hawb.".gif";
                        //$envia = ftp_put($conecta, "/FreteReal/IMAGENS/$imagem", "/home/storage/3/65/d3/wihus/public_html/hawbs/$arq_hawb", FTP_BINARY);
                        //$envia = ftp_put($conecta, "/FreteReal/IMAGENS/$imagem", "/public_html/hawbs/$arq_hawb", FTP_BINARY);
                        $envia = ftp_put($conecta, "/public_html/hawbs/$imagem", "hawbs/$imagem", FTP_BINARY);
                        if(!$envia){
                           die('Erro ao enviar arquivo!');
                        }
                        else{
                           //Atualiza o registro da HAWB na tabela remessa
                           $con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
                           $res = mysql_select_db($banco_d) or die ("Banco de dados inexistente");

                           $localiza = "SELECT n_hawb,dt_envio FROM remessa
                           WHERE n_hawb='$hawb'";
                           $query = mysql_db_query($banco_d,$localiza,$con) or die ("Não foi possivel acessar o banco");
                           $total = mysql_num_rows($query);
                           for($ic=0; $ic<$total; $ic++){
                              $row = mysql_fetch_row($query);
                              $n_hawb        = $row[0];
                              $dt_envio      = $row[1];
                           }
                           if ($dt_envio=='0000-00-00') {
                              $query = mysql_db_query($banco_d,$localiza,$con) or die ("Não foi possivel acessar o banco");
                              $achou = mysql_num_rows($query);
                              If ($achou > 0 ) {
                                 $altera ="UPDATE remessa SET dt_envio='$v_data_envio',imagem_exportada='S'
                                 WHERE n_hawb='$hawb'";
                                 mysql_db_query($banco_d,$altera,$con);
                                 $num++;
                              }
                           }
                           else {
                              $query = mysql_db_query($banco_d,$localiza,$con) or die ("Não foi possivel acessar o banco");
                              $achou = mysql_num_rows($query);
                              If ($achou > 0 ) {
                                 $altera ="UPDATE remessa SET imagem_exportada='S'
                                 WHERE n_hawb='$hawb'";
                                 mysql_db_query($banco_d,$altera,$con);
                                 $num++;
                              }
                           }
                        }
                    }
                    else{
                        $path ='hawbs/';
                        $exte ='.jpg';
                        if(file_exists("$path$hawb$exte")) {
                            $imagem=$hawb.".jpg";
                            //$envia = ftp_put($conecta, "/FreteReal/IMAGENS/$imagem", "/home/storage/3/65/d3/wihus/public_html/hawbs/$arq_hawb", FTP_BINARY);
                            //$envia = ftp_put($conecta, "/FreteReal/IMAGENS/$imagem", "/public_html/hawbs/$arq_hawb", FTP_BINARY);
                            $envia = ftp_put($conecta, "/public_html/hawbs/$imagem", "hawbs/$imagem", FTP_BINARY);
                            if(!$envia){
                               die('Erro ao enviar arquivo!');
                            }
                            else{
                               //Atualiza o registro da HAWB na tabela remessa
                               $con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
                               $res = mysql_select_db($banco_d) or die ("Banco de dados inexistente");

                               $localiza = "SELECT n_hawb,dt_envio FROM remessa
                               WHERE n_hawb='$hawb'";
                               $query = mysql_db_query($banco_d,$localiza,$con) or die ("Não foi possivel acessar o banco");
                               $total = mysql_num_rows($query);
                               for($ic=0; $ic<$total; $ic++){
                                  $row = mysql_fetch_row($query);
                                  $n_hawb        = $row[0];
                                  $dt_envio      = $row[1];
                               }
                               if ($dt_envio=='0000-00-00') {
                                  $query = mysql_db_query($banco_d,$localiza,$con) or die ("Não foi possivel acessar o banco");
                                  $achou = mysql_num_rows($query);
                                  If ($achou > 0 ) {
                                     $altera ="UPDATE remessa SET dt_envio='$v_data_envio',imagem_exportada='S'
                                     WHERE n_hawb='$hawb'";
                                     mysql_db_query($banco_d,$altera,$con);
                                     $num++;
                                  }
                               }
                               else {
                                  $query = mysql_db_query($banco_d,$localiza,$con) or die ("Não foi possivel acessar o banco");
                                  $achou = mysql_num_rows($query);
                                  If ($achou > 0 ) {
                                     $altera ="UPDATE remessa SET imagem_exportada='S'
                                     WHERE n_hawb='$hawb'";
                                     mysql_db_query($banco_d,$altera,$con);
                                     $num++;
                                  }
                               }
                            }
                        }
                    }
                 }
                 $resp_grava ='Foram transferidas :'. $num . 'imagens.';
             }
             else {
                 ?>
                   <script language="javascript"> window.location.href=("envia_imagem_selecionando.php")
                   alert('Você precisa selecionar clicando no box !');
                   </script>
                <?php
             }
        break;
        default:
    }
  ?>
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
  <body leftmargin="10" topmargin="10" marginwidth="10" marginheight="10">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
         <td color="white" align="left" width="100%" height="10">
      </tr>
  </table>
  <form name="cadastro" id="cadastro" action="envia_imagem_selecionando.php" method="post">
  <table width="50%" border="1" cellspacing="0" cellpadding="0" align="center">
     <tr>
      <td><b>Data inicio :</b></td>
       <td>
         <?php $_SESSION['dt_inicio_d']  =$dt_inicio;?>
         <input type="text" name="data_ini" value ="<?php echo "$dt_inicio";?>" size="12" maxlength="12" id="data_ini">
         <input TYPE="button" NAME="btndata_ini" VALUE="..." Onclick="javascript:popdate('document.cadastro.data_ini','pop1','150',document.cadastro.data_ini.value)">
         <span id="pop1" style="position:absolute"></span>
       </td>
      </tr>
      <tr>
       <td><b>Data fim :</b></td>
       <td>
         <?php $_SESSION['dt_fim_d']  =$dt_fim;?>
         <input type="text" name="data_fim" value ="<?php echo "$dt_fim";?>" size="12" maxlength="12" id="data_fim">
         <input TYPE="button" NAME="btndata_fim" VALUE="..." Onclick="javascript:popdate('document.cadastro.data_fim','pop2','150',document.cadastro.data_fim.value)">
         <span id="pop2" style="position:absolute"></span>
       </td>
      </tr>
      <tr>
         <td><b>Data Envio :</b></td>
         <td colspan="3" align="left">
             <input type="text" name="data_envio" size="12" maxlength="12" id="data_envio">
             <input TYPE="button" NAME="btndata_envio" VALUE="..." Onclick="javascript:popdate('document.cadastro.data_envio','pop3','150',document.cadastro.data_envio.value)">
             <span id="pop3" style="position:absolute"></span>
         </td>
      </tr>
     <p>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
         <td color="white" align="left" width="100%" height="15">
      </tr>
    </table>
    <table width="80%" border="1" cellspacing="0" cellpadding="0" align="center">
      <tr>
         <td colspan="6" align="center"><font face="arial" size="2"><b>Selecione as imagens que deseja enviar.</b></font></td>
      </tr>
      <tr>
         <td align="center"><b>N.POD</b></td>
         <td align="center"><b>REPRESENTANTE</b></td>
         <td align="center"><b>DESTINATARIO</b></td>
         <td align="center"><b>TAM.</b></td>
         <td align="center"><b>DT. REMESSA</b></td>
         <td align="center"><b>N. REMESSA</b></td>
         <td align="center"><b>ENVIO IMG.</b></td>
      </tr>
      <?php
        $v_dt_inicio   =$_SESSION['dt_inicio_m'];
        $v_dt_fim      =$_SESSION['dt_fim_m'];

        $con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
        $res = mysql_select_db($banco_d) or die ("Banco de dados inexistente");
        
        $sql = mysql_query("SELECT remessa.n_hawb,cli_for.nome,remessa.nome_desti,remessa.dt_envio,
        remessa.dt_remessa,remessa.n_remessa
        FROM remessa,cli_for
        WHERE ((remessa.dt_remessa>='$v_dt_inicio')
        AND (remessa.dt_remessa<='$v_dt_fim')
        AND (remessa.codi_cli='06327259000193')
        AND (remessa.codi_cli=cli_for.cnpj_cpf)
        AND (remessa.imagem_exportada<>'S'))
        ORDER BY remessa.dt_remessa,remessa.n_remessa");
        if ($_SESSION['entrada_m'] =='N') {
            if (mysql_num_rows($sql)==0) {
                echo "Não há Imagens disponíveis para o período informado !";
            }
            else {
                $numeh=0;
                $path ='hawbs/';
                $exte ='.gif';
                $exte_1='.jpg';
                echo "<tr><td bgcolor=\"blue\"><a href=\"javascript:void(null)\" onClick=\"CheckAll();\"><font face=\"arial\" color=\"white\"><b> Marcar Todas</b></font></a><br></td></tr>";
                while ($x  = mysql_fetch_array($sql)) {
                      $n_hawb       = $x['n_hawb'];
                      $nome_repre   = $x['nome'];
                      $nome_desti   = $x['nome_desti'];
                      $dt_remessa   = $x['dt_remessa'];
                      $n_remessa    = $x['n_remessa'];
                      $dt_envio     = $x['dt_envio'];
                      //Altera formato de data para mostrar
                      $dt_remessa_r   = explode("-",$dt_remessa);
                      $v_dt_remessa   = $dt_remessa_r[2]."/".$dt_remessa_r[1]."/".$dt_remessa_r[0];
                      $dt_envio_r   = explode("-",$dt_envio);
                      $v_dt_envio   = $dt_envio_r[2]."/".$dt_envio_r[1]."/".$dt_envio_r[0];
                      //echo "<p>Arquivo :$path$n_hawb$exte";
                      if(file_exists("$path$n_hawb$exte")) {
                          $tamanho = filesize("$path$n_hawb$exte");
                          $tamanho =(int) ($tamanho/1000);
                          echo "<div>";
                          echo "<font face=\"arial\" size=\"1\">";
                          echo "<tr><td>";
                          echo $n_hawb."<input type =\"checkbox\" name = \"hawb[]\" id=\"hawb\" value=\"$n_hawb\" OnClick=\"MarcaBases(true);\"></td>";
                          echo "<td align=\"center\">$nome_repre</td>";
                          echo "<td align=\"left\">$nome_desti</td>";
                          echo "<td align=\"center\">$tamanho KB</td>";
                          echo "<td align=\"center\">$v_dt_remessa</td>";
                          echo "<td align=\"center\">$n_remessa</td>";
                          echo "<td align=\"center\">$v_dt_envio</td>";
                          echo "</tr>";
                          echo "</div>";
                          $numeh++;
                      }
                      else {
                         if(file_exists("$path$n_hawb$exte_1")) {
                            $tamanho = filesize("$path$n_hawb$exte_1");
                            $tamanho =(int) ($tamanho/1000);
                            echo "<div>";
                            echo "<font face=\"arial\" size=\"1\">";
                            echo "<tr><td>";
                            echo $n_hawb."<input type =\"checkbox\" name = \"hawb[]\" id=\"hawb\" value=\"$n_hawb\" OnClick=\"MarcaBases(true);\"></td>";
                            echo "<td align=\"center\">$nome_repre</td>";
                            echo "<td align=\"left\">$nome_desti</td>";
                            echo "<td align=\"center\">$tamanho KB</td>";
                            echo "<td align=\"center\">$v_dt_remessa</td>";
                            echo "<td align=\"center\">$n_remessa</td>";
                            echo "<td align=\"center\">$v_dt_envio</td>";
                            echo "</tr>";
                            echo "</div>";
                            $numeh++;
                         }
                      }
                }
            }
        }
      ?>
	  <tr>
	    <td colspan="4">
			<div align="left">
               <b> Total de POD´s prontos para envio..:</b><font size="3" color="red"><?php echo "$numeh";?></font>
	        </div>
	    </td>
	    <td>
			<div align="left">
			   <input name="mostra" type="submit" value="Mostrar">
	        </div>
	    </td>
	    <td>
			<div align="right">
			   <input name="envia" type="submit" value="Enviar">
	        </div>
	    </td>
	  </tr>
	</table>
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
 </div>
</body>
</html>

