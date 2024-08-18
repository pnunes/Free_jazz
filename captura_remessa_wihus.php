<?php
    session_start();
    $base_d     =$_SESSION['base_d'];
    $banco_d    =$_SESSION['banco_d'];
    $usuario_d  =$_SESSION['usuario_d'];
    $senha_d    =$_SESSION['senha_d'];
    
    //acesso banco - wihus - Internet
    //$_SESSION['base_w']   ='www.wihus.com.br';
    $_SESSION['base_w']    ='mysql01.wihus.com.br';
    $_SESSION['banco_w']   ='wihus';
    $_SESSION['usuario_w'] ='wihus';
    $_SESSION['senha_w']   ='ps251857';
    
    //Conexão local
    //$_SESSION['base_w']   ='localhost';
    //$_SESSION['banco_w']  ='wihus';
    //$_SESSION['usuario_w']='root';
    //$_SESSION['senha_w']  ='nunesp';
    
    
    function get_post_action($name) {
       $params = func_get_args();

       foreach ($params as $name) {
          if (isset($_POST[$name])) {
            return $name;
          }
       }
    }
    
    //Pega variaveis banco wihus
    $banco_w   =$_SESSION['banco_w'];
    $base_w    =$_SESSION['base_w'];
    $usuario_w =$_SESSION['usuario_w'];
    $senha_w   =$_SESSION['senha_w'];
    
    switch (get_post_action('importa','mostra')) {
         case 'importa':
             /* if ($_POST['hawb']<>'') {
                  foreach($_POST['hawb'] as $hawb){
                  
                      //Abre conexao com banco Wihus
                      $con = mysql_connect($base_w, $usuario_w, $senha_w) or die ("Erro de conexão");
                      $res = mysql_select_db($banco_w) or die ("Banco de dados inexistente 1");
                  
                      $pega_dados = "SELECT n_hawb,n_remessa,dt_remessa,co_servico,codigo_desti,
                      nome_desti,rua_desti,numero_desti,comple_desti,cep_desti,bairro_desti,cidade_desti,
                      estado_desti,cod_barra
                      FROM remessa WHERE n_hawb='$hawb'";
                      $query = mysql_db_query($banco_w,$pega_dados,$con) or die ("Não foi possivel acessar o banco");
                      $total = mysql_num_rows($query);
                      
                      for($ic=0; $ic<$total; $ic++){
                          $row = mysql_fetch_row($query);
                          $n_hawb         = $row[0];
                          $remessa        = $row[1];
                          $dt_remessa     = $row[2];
                          $servico        = $row[3];
                          $codigo_desti   = $row[4];
                          $nome_desti     = $row[5];
                          $rua_desti      = $row[6];
                          $numero_desti   = $row[7];
                          $comple_desti   = $row[8];
                          $cep_desti      = $row[9];
                          $bairro_desti   = $row[10];
                          $cidade_desti   = $row[11];
                          $estado_desti   = $row[12];
                          $cod_barra      = $row[13];
                      }

                      $contar =0;
                      if (($estado_desti=='SC') AND ($cidade_desti<>'BLUMENAU'))  {
                         $escritorio='001';
                      }
                      if ($estado_desti=='PR') {
                         $escritorio='002';
                      }
                      if (($estado_desti=='SC') AND ($cidade_desti=='BLUMENAU'))  {
                         $escritorio='003';
                      }
                      //Abre conexão banco free_jazz
                      $con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
                      $res = mysql_select_db($banco_d) or die ("Banco de dados inexistente 2");

                      //Verifica se o POD ja foi importado
                      $confere = "SELECT n_hawb FROM remessa WHERE n_hawb='$n_hawb'";
                      $query = mysql_db_query($banco_d,$confere,$con) or die ("Não foi possivel acessar o banco 1");
                      $achou = mysql_num_rows($query);
                      If ($achou == 0 ) {
                          //Pega codigo do serviço na tabela free_jazz
                          $coleta ="SELECT codigo_se FROM serv_ati WHERE codigo_wihus='$servico'";
                          $query = mysql_db_query($banco_d,$coleta,$con) or die ("Não foi possivel acessar o banco 2");
                          $total = mysql_num_rows($query);
                          for($ic=0; $ic<$total; $ic++){
                             $row = mysql_fetch_row($query);
                             $codigo_se     = $row[0];
                          }
                          $cep_desti_c =Substr($cep_desti,0,5);
                          $pega_cep = mysql_query("SELECT codigo,cep_inicio,cep_fim FROM classe_cep");
                          while ($row = mysql_fetch_array($pega_cep)) {
                              $codigo_cla     = $row[0];
                              $cep_ini        = $row[1];
                              $cep_fi         = $row[2];
                              if (((int)$cep_desti_c>=(int)$cep_ini) and ((int)$cep_desti_c<=(int)$cep_fi)) {
                                 $classe_cep = $codigo_cla;
                                 break;
                              }
                          }

                          $codi_cli = $_SESSION['codigo_cli'];
                          $inclusao = "INSERT INTO remessa(n_hawb,n_remessa,dt_remessa,co_servico,codigo_desti,nome_desti,
                          rua_desti,numero_desti,comple_desti,cep_desti,bairro_desti,cidade_desti,
                          estado_desti,classe_cep,codi_cli,cod_barra,escritorio)
                          VALUES ('$n_hawb','$remessa','$dt_remessa','$codigo_se','$codigo_desti','$nome_desti','$rua_desti','$numero_desti',
                          '$comple_desti','$cep_desti','$bairro_desti','$cidade_desti','$estado_desti','$classe_cep','$codi_cli','$cod_barra',
                          '$escritorio')";

                          mysql_db_query($banco_d,$inclusao,$con);

                          $hora   = date ('H:i');
                          $data   = date('Y-m-d');

                          //////////////////Atualiza a tabela de histórico HAWB - base free Jazz /////////////////////////////////
                          $atualiza="INSERT INTO controle_reentrega (n_hawb,dt_evento,ocorrencia,cod_barra,ordem)
                          VALUES('$n_hawb','$data','Recebido na Transportadora.','$cod_barra','1')";
                          mysql_db_query($banco_d,$atualiza,$con);

                          $contar++;
                          $classe_cep='';
                      }
                      $_SESSION['contar']= $contar;
                      
                      //Abre conexao com banco Wihus
                      $con = mysql_connect($base_w, $usuario_w, $senha_w) or die ("Erro de conexão");
                      $res = mysql_select_db($banco_w) or die ("Banco de dados inexistente 3");

                      $atualiza="UPDATE remessa SET exportado='S' WHERE n_hawb='$n_hawb'";
                      mysql_db_query($banco_w,$atualiza,$con);

                      $hora   = date ('H:i');
                      $data   = date('Y-m-d');
                      $codi_barra_g  =$_SESSION['codigo_barra'];

                      //////////////////Atualiza a tabela de histórico HAWB - Base Wihus - codigo 97 /////////////////////////////////
                      $atualiza="INSERT INTO controle_reentrega (n_hawb,dt_evento,ocorrencia,cod_barra,cod_ocorre,ordem,hora)
                      VALUES('$n_hawb','$data','Em rota de entrega.','$codi_barra_g','97','2','$hora')";
                      mysql_db_query($banco_w,$atualiza,$con);

                      //////////////////Atualiza a tabela de histórico HAWB - Base Wihus - codigo 79 /////////////////////////////////
                     /* $atualiza="INSERT INTO controle_reentrega (n_hawb,dt_evento,ocorrencia,cod_barra,cod_ocorre,ordem,hora)
                      VALUES('$n_hawb','$data','Recebido na base entrega destino.','$codi_barra_g','79','2','$hora')";
                      mysql_db_query($banco_w,$atualiza,$con); */
                //  }
             // }
                  
         break;

         case 'mostra':
                 // $cliente                ='06327259000193';
                 // $_SESSION['codigo_cli'] ='06327259000193';
                 // $codigo_free         ='84102640991';
                  $dt_inicio           =$_POST['data_ini'];
                  $dt_fim              =$_POST['data_fim'];
              
              //Altera formato de data para comparação
              $dt_inicio  = explode("/",$dt_inicio);
              $v_dt_inicio = $dt_inicio[2]."-".$dt_inicio[1]."-".$dt_inicio[0];

              $dt_fim  = explode("/",$dt_fim);
              $v_dt_fim = $dt_fim[2]."-".$dt_fim[1]."-".$dt_fim[0];
         break;
         default:
    }

  //carrega variaveis com dados para acessar o banco de dados
  
  $matricula_m  =$_SESSION['matricula_m'];
  $programa='121';
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


  include("campo_calendario.php");
?>

<HTML>
<TITLE>captura_remessa_wihus.php</TITLE>
<HEAD>
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
<BODY>
  <div id="geral" align="center">
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
         <p align="right"><font face="Arial" size="2" color="#FFFFFF"><b>Captura Remessa Wihus</b></font></td>
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
   <table width="40%" border="1" cellpadding="5" cellspacing="0" bordercolor="#6495ED">
        <form name="cadastro" id="cadastro" method="POST" action="captura_remessa_wihus.php" border="20">
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
			<td align="center">
				<input name="importa" type="submit" value="Importar">
			</td>
			<td align="center">
				<input name="mostra" type="submit" value="Mostrar">
			</td>
		</tr>
  </table>
  <table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#4169E1">
     <tr>
       <td colspan="8" align="center"><font face="arial" size="3" color="red"><b>LISTA POD´s IMPORTADOS</b></font></td>
     </tr>
     <tr>
       <td width="8%" align="center"><b>HAWB</b></td>
       <td width="7%" align="center"><b>REMESSA</b></td>
       <td width="7%" align="center"><b>DT. REMESSA</b></td>
       <td width="13%" align="center"><b>SERVIÇO</b></td>
       <td width="25%" align="center"><b>NOME DESTINATARIO</b></td>
       <td width="25%" align="center"><b>ENDEREÇO</b></td>
       <td width="15%" align="center"><b>CIDADE</b></td>
       <td width="5%" align="center"><b>UF</b></td>
     </tr>
      <?php
      //Abre conexao com banco Wihus
      $con = mysql_connect($base_w, $usuario_w, $senha_w) or die ("Erro de conexão");
      $res = mysql_select_db($banco_w) or die ("Banco de dados inexistente 1");

      $contar =0;

      $resultado = mysql_query("SELECT remessa.n_hawb,remessa.n_remessa,
      remessa.dt_remessa,serv_ati.descri_se,remessa.nome_desti,
      remessa.rua_desti,remessa.cidade_desti,remessa.estado_desti
      FROM remessa,serv_ati
      WHERE ((remessa.estado_desti='PR')
      OR (remessa.estado_desti='SC')
      AND (remessa.dt_remessa>='$v_dt_inicio')
      AND (remessa.dt_remessa<='$v_dt_fim')
      AND (remessa.exportado<>'S')
      AND (remessa.co_servico=serv_ati.codigo_se))
      ORDER BY remessa.dt_remessa,remessa.n_remessa");
      $numeh=0;
      echo "<tr><td bgcolor=\"blue\"><a href=\"javascript:void(null)\" onClick=\"CheckAll();\"><font face=\"arial\" color=\"white\"><b> Marcar Todas</b></font></a><br></td></tr>";
      while ($x = mysql_fetch_array($resultado)) {
          $n_hawb       = $x['n_hawb'];
          $n_remessa    = $x['n_remessa'];
          $dt_remessa   = $x['dt_remessa'];
          //Altera formato de data para mostrar
          $dt_remessa  = explode("-",$dt_remessa);
          $v_dt_remessa = $dt_remessa[2]."/".$dt_remessa[1]."/".$dt_remessa[0];
          $servico      = $x['descri_se'];
          $nome_desti   = $x['nome_desti'];
          $rua_desti    = $x['rua_desti'];
          $cidade_desti = $x['cidade_desti'];
          $estado_desti = $x['estado_desti'];
          echo "<div>";
          echo "<font face=\"arial\" size=\"1\">";
          echo "<tr><td width=\"5%\">";
          echo $n_hawb."<input type =\"checkbox\" name = \"hawb[]\" id=\"hawb\" value=\"$n_hawb\" OnClick=\"MarcaBases(true);\"></td>";
          echo "<td width=\"7%\">$n_remessa</td>";
          echo "<td width=\"7%\">$v_dt_remessa</td>";
          echo "<td width=\"11%\">$servico</td>";
          echo "<td width=\"25%\">$nome_desti</td>";
          echo "<td width=\"25%\">$rua_desti</td>";
          echo "<td width=\"15%\">$cidade_desti</td>";
          echo "<td width=\"5%\">$estado_desti</td>";
          echo "</tr>";
          echo "</div>";
          $numeh++;
      }
      $_SESSION['numeh'] =$numeh;
      ?>
  </table>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <?php $v_numeh =$_SESSION['numeh'];?>
        <td color="white" align="center" width="900" height="45" colspan="8"><font color="black" size="3" face="arial">Total de POD´s Para Importação :<?php echo "$v_numeh";?></font></td>
      </tr>
      <tr>
        <?php $v_contar = $_SESSION['contar'];?>
        <td color="white" align="center" width="900" height="45" colspan="8"><font color="black" size="3" face="arial">Total de POD´s Importados :<?php echo "$v_contar";?></font></td>
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
</BODY>
</HTML>
