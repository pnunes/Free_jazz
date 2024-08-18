<?php
  session_start();

 //carrega variaveis com dados para acessar o banco de dados

  $base_d     =$_SESSION['base_d'];
  $banco_d    =$_SESSION['banco_d'];
  $usuario_d  =$_SESSION['usuario_d'];
  $senha_d    =$_SESSION['senha_d'];
  
  $matricula_m  =$_SESSION['matricula_m'];
  $programa='103';
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
  
  include("campo_calendario.php");
  $_SESSION['ver_m'] =0;
?>

<HTML>
<HEAD>
 <TITLE>mostra_inconsistencias_movimento.php</TITLE>

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
         <p align="right"><font face="Arial" size="2" color="#FFFFFF"><b>Mostra Inconsistências nos Dados Lançados</b></font></td>
     </tr>
   </table>
   <table width="100%" border="0" cellspacing="0" cellpadding="0">
       <tr>
         <td colspan="1" color="white" align="right" width="45%" height="70"><a href="entrada.php"><img src="img/porta.gif" border="none"></td>
       </tr>
   </table>

   <form method="POST" name="cadastro" action="mostra_inconsistencias_movimento.php" border="20" align="center">
   <?php
     switch (get_post_action('mostra')) {

         case 'mostra':
             $escri                    =$_POST['escri'];
             $_SESSION['escri_m']      =$escri;
             $dt_inicio                =$_POST['data_ini'];
             $dt_fim                   =$_POST['data_fim'];
             $_SESSION['ver_m'] =1;
             //mudando formato da data para gravar na tabela

             $data_ini  = explode("/",$dt_inicio);
             $v_data_ini = $data_ini[2]."-".$data_ini[1]."-".$data_ini[0];

             $data_fim  = explode("/",$dt_fim);
             $v_data_fim = $data_fim [2]."-".$data_fim [1]."-".$data_fim [0];

             //Pega dados do escritorio
             mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
             mysql_select_db($banco_d) or die ("Banco de dados inexistente");
             $resultado = mysql_query ("SELECT nome,estado FROM regi_dep
             WHERE codigo='$escri'");
             $total = mysql_num_rows($resultado);

             for($i=0; $i<$total; $i++){
                $dados = mysql_fetch_row($resultado);
                $nome_escritorio       =$dados[0];
                $estado                =$dados[1];
             }
             $_SESSION['nome_escritorio_v']   =$nome_escritorio;
             $_SESSION['estado_v']            =$estado;
         break;
         default:
     }

     ?>
   
     <table width="50%" border="1" cellpadding="5" cellspacing="0" bordercolor="#4169E1">
      <tr>
        <td><b>Escritorio :</b></td>
        <td>
          <?php
           $escri   =$_SESSION['escri_m'];
           mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
           mysql_select_db($banco_d) or die ("Banco de dados inexistente");
           ?>
           <select name="escri">
           <?php
            $sql2 = "SELECT codigo,nome FROM regi_dep";
            $resul = mysql_db_query($banco_d,$sql2,$con) or die ("Não foi possivel acessar o banco");
            while ( $linha = mysql_fetch_array($resul)) {
                $select = $escri == $linha[0] ? "selected" : "";
                echo "<option value=\"". $linha[0] . "\" $select>" . $linha[1] . "</option>";
           }
           ?>
           </select>
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
       <td colspan="2">
         <div align="right">
    	    <input name="mostra" type="submit" value="Mostrar">
    	 </div>
       </td>
      </tr>
   </table>
   <table width="90%" border="1" cellpadding="5" cellspacing="0" bordercolor="#4169E1">
     <tr>
       <?php $nome_escritorio  =$_SESSION['nome_escritorio_v'];?>
       <td colspan="4" align="center"><font face="arial" size="2"><b>INCONSISTÊNCIAS NOS DADOS LANÇADOS -  :<?php echo "$nome_escritorio" ?> - Período : <?php echo "$dt_inicio A $dt_fim" ?></b></font></td>
     </tr>
     <tr>
       <td width="10%" align="center"><b>N. HAWB</b></td>
       <td width="5%" align="center"><b>BASE</b></td>
       <td width="10%" align="center"><b>CID.DESTI</b></td>
       <td width="75%" align="center"><b>DESCRIÇÃO DA INCONSISTÊNCIA</b></td>
     </tr>
     <?php
      $escri  =$_SESSION['escri_m'];
      mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
      mysql_select_db($banco_d) or die ("Banco de dados inexistente");

      $resultado = mysql_query ("SELECT n_hawb,n_remessa,co_servico,codi_cli,dt_remessa,estado_desti,
      dt_lista,dt_baixa,entregador,dt_envio,escritorio,cidade_desti
      FROM remessa
      WHERE ((escritorio='$escri')
      AND (dt_remessa>='$v_data_ini')
      AND (dt_remessa<='$v_data_fim'))
      ORDER BY n_hawb");
      $total = mysql_num_rows($resultado);
      $contar=0;

      for($i=0; $i<$total; $i++){
         $dados = mysql_fetch_row($resultado);
	     $n_hawb          =$dados[0];
	     $n_remessa       =$dados[1];
	     $co_servico      =$dados[2];
	     $codi_cli        =$dados[3];
	     $dt_remessa      =$dados[4];
	     $estado_desti    =$dados[5];
         $dt_lista        =$dados[6];
         $dt_baixa        =$dados[7];
         $entregador      =$dados[8];
         $dt_envio        =$dados[9];
         $escritorio      =$dados[10];
         $cidade_desti    =$dados[11];
         
         if($estado_desti<>'SP') {
             if ($co_servico<>'') {
                 $con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
                 $res = mysql_select_db($banco_d,$con) or die ("Banco de dados inexistente");

                 $verifica = "SELECT codigo_se FROM serv_ati
                 WHERE codigo_se='$co_servico'";
                 $query_v = mysql_db_query($banco_d,$verifica,$con) or die ("Não foi possivel acessar o banco");
                 $achou = mysql_num_rows($query_v);

                 If ($achou == 0 ) {
                    $observa0='Codigo serviço não cadastrado';
                 }
             }
             else  {
                 $observa1='Falta codigo do serviço';
             }
             $estado    =$_SESSION['estado_v'];
             if($estado_desti<>$estado) {
                $observa2='HAWB lançada em base incorreta';
             }
       	     if ($n_remessa=='') {
    	        $observa3='Falta número da remessa';
    	     }
    	     if ($codi_cli=='') {
    	        $observa4='Falta codigo do cliente';
    	     }
    	     if ($dt_remessa=='0000-00-00') {
    	        $observa5='Data da remessa inconsistente';
    	     }
    	     if (($entregador<>'') and ($dt_lista=='0000-00-00')) {
    	         $observa6='Problema com data da Lista.';
    	     }
    	     if (($dt_envio<>'0000-00-00') and ($dt_baixa=='0000-00-00')) {
    	         $observa7='Problema com data da Baixa.';
    	     }
    	     if ($observa0<>'' or $observa1<>'' or  $observa2<>'' or $observa3<>'' or $observa4<>'' or $observa5<>'') {
    	         $observacao=$observa0." - ".$observa1." - ".$observa2." - ".$observa3." - ".$observa4." - ".$observa5." - ".$observa6." - ".$observa7;
    	         echo "<tr>";
    	         echo "<td width=\"10%\"><font size=\"2\" face=\"arial\">$n_hawb</font></td>";
    	         echo "<td width=\"5%\"><font size=\"2\" face=\"arial\">$escritorio</font></td>";
    	         echo "<td width=\"10%\"><font size=\"2\" face=\"arial\">$cidade_desti</font></td>";
    	         echo "<td width=\"75%\"><font size=\"2\" face=\"arial\">$observacao</font></td>";
                 echo "</tr>";
                 $contar=$contar+1;
                 $ver=1;

             }
             $observa0='';
             $observa1='';
             $observa2='';
             $observa3='';
             $observa4='';
             $observa5='';
             $observa6='';
             $observa7='';
         }
      }
      $ver  =$_SESSION['ver_m'];
      if ($contar>0)  {
         echo "<tr>";
               echo "<td colspan=\"4\" align=\"left\"><b><font size=\"2\" face=\"arial\">Total de HAWB´s inconsistentes :$contar</font></b></td>";
         echo "</tr>";
      }
      if (($contar==0) and ($ver==1))  {
         echo "<tr>";
               echo "<td colspan=\"4\" align=\"center\"><b><font size=\"4\" face=\"arial\" color=\"red\">MOVIMENTO SEM INCONSISTÊNCIAS.</font></b></td>";
         echo "</tr>";
      }
     ?>
</table>
</form>
</div>
</BODY>
</HTML>
