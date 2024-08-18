<?php
  session_start();

 //carrega variaveis com dados para acessar o banco de dados

  $base_d     =$_SESSION['base_d'];
  $banco_d    =$_SESSION['banco_d'];
  $usuario_d  =$_SESSION['usuario_d'];
  $senha_d    =$_SESSION['senha_d'];

  function get_post_action($name) {
    $params = func_get_args();
    foreach ($params as $name) {
        if (isset($_POST[$name])) {
            return $name;
        }
    }
  }
  $matricula_m  =$_SESSION['matricula_m'];

  $data   =date("d/m/Y");

  //Altera formato de data para comparação
  $dt_hoje  = explode("/",$data);
  $v_dt_hoje = $dt_hoje[2]."-".$dt_hoje[1]."-".$dt_hoje[0];
  $v_hoje=mktime(0,0,0,(substr($v_dt_hoje,5,2)),(substr($v_dt_hoje,8,2)),(substr($v_dt_hoje,0,4)));
  $_SESSION['v_hoje_m']    =$v_hoje;

?>

<HTML>
<HEAD>
 <TITLE>mostra_recados_por_destino.php</TITLE>

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
<table width="100%" heigth="300" align="center">
     <tr>
       <td>
         <form method="POST" action="mostra_recados_por_destino.php" border="20">
            <?php
               echo "<center><Font size=\"2\" face=\"ARIAL\">Recado de..:</font>";

               mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
               mysql_select_db($banco_d) or die ("Banco de dados inexistente");

               $resultado = mysql_query ("SELECT controle_recados.controle_reca,
               pessoa.nome
               FROM recado,pessoa,controle_recados
               WHERE ((recado.remetente=pessoa.matricula)
               AND (controle_recados.controle_reca=recado.controle)
               AND (controle_recados.lido='N')
               AND (controle_recados.matricula='$matricula_m'))");
               echo "<select name='controle' class='caixa' align=\"center\">\n";
               while($linha = mysql_fetch_row($resultado))  {
                  printf("<option value='$linha[0]'>$linha[0] - $linha[1] - $linha[2]</option>\n");
               }
            ?>
              <input name="mostra" type="submit" value="Mostrar"></center>
            </td>
           </tr>
         </form>
   </table>
   <table width="100%" border="0" cellspacing="0" cellpadding="0">
     <tr>
       <td color="white" align="center" width="900" height="10"></td>
     </tr>
</table>
<INPUT type=button value="Fechar janela" onClick="window.close();"></td>
<table width="100%" align="center" border="1" cellpadding="5" cellspacing="0" bordercolor="#4169E1">
     <tr>
        <td align="center" width="100%"><b><font size="3" face="arial">R  E  C  A D O / L  E  M  B  R  E  T  E</font></b></td>
     </tr>
     <?php
     switch (get_post_action('grava','mostra')) {
         case 'mostra':
              $controle= $_POST['controle'];
              $_SESSION['contro']=$controle;
              
              mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
              mysql_select_db($banco_d) or die ("Banco de dados inexistente");

              $resultado = mysql_query ("SELECT controle_recados.controle_reca,recado.recado,recado.remetente,
              date_format(recado.postagem,'%d/%m/%Y'),controle_recados.lido,pessoa.nome
              FROM recado,pessoa,controle_recados
              WHERE ((recado.remetente=pessoa.matricula)
              AND  (controle_recados.controle_reca=recado.controle)
              AND (controle_recados.controle_reca='$controle')
              AND (controle_recados.lido='N')
              AND (controle_recados.matricula='$matricula_m'))");
                  
              $total = mysql_num_rows($resultado);
              if ($total > 0 ) {
                  for($i=0; $i<$total; $i++){
                     $dados = mysql_fetch_row($resultado);
	                 $controle     =$dados[0];
	                 $recado       =$dados[1];
	                 $rementente   =$dados[2];
	                 $postagem     =$dados[3];
	                 $v_lido       =$dados[4];
	                 $nome_reme    =$dados[5];
	              }
	          }

         break;
         
         case 'grava':
              $controle       =$_SESSION['contro'];
              $vv_lido        =$_POST['lido'];

              $vv_lido=Strtoupper($vv_lido);

              $matricula_m  =$_SESSION['matricula_m'];

              $con =mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
              $res =mysql_select_db($banco_d) or die ("Banco de dados inexistente");

              $alteracao = "UPDATE controle_recados SET lido='$vv_lido'
              WHERE ((controle_reca='$controle') AND (matricula='$matricula_m'))";

              if (mysql_db_query($banco_d,$alteracao,$con)) {
                $resp_grava="Liberação bem sucedida.";
             }
             else {
                $resp_grava="Problemas na Liberação.";
             }
         break;
         default:
     }
     ?>
   </table>
   <body leftmargin="10" topmargin="10" marginwidth="10" marginheight="10">
   <form name="cadastro" action="mostra_recados_por_destino.php" method="post">
   <table width="100%"  align="center" border="1" cellpadding="5" cellspacing="0" bordercolor="#4169E1">
		<tr>
			<td><b>Numero do Recado :</b></td>
			<td><?php echo "$controle"; ?></td>
		</tr>
		<tr>
          <td><b>Enviado Por :</b></td>
            <td>
               <?php echo "$rementente"; ?> - <?php echo "$nome_reme"; ?>
            </td>
        </tr>
        <tr>
           <td><b>Recado :</b></td>
		   <td>
             <TEXTAREA NAME="recado" rows="15" cols="80" readonly><?php echo "$recado";?></TEXTAREA>
           </td>
        </tr>
        <td><b>Postagem :</b></td>
          <td>
            <?php echo "$postagem"; ?>
          </td>
        </tr>
        <tr>
			<td><b>Recado Lido(S/N) :</b></td>
            <td><input type="text" name="lido" value ="<?php echo "$v_lido";?>" size="1" maxlength="1"></td>
		</tr>
		<tr>
			<td colspan="2">
				<div align="right">
				<input name="grava" type="submit" value="Liberar">
				</div>
			</td>
		</tr>
	 </table>
  </form>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td color="white" align="center" width="900" height="25" colspan="8" ><?php echo "$resp_grava";?></td>
      </tr>
  </table>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
         <td color="white" align="left" width="100%" height="15"></td>
      </tr>
  </table>
</BODY>
</HTML>
