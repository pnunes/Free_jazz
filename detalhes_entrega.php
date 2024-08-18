<?php
  session_start();

 //carrega variaveis com dados para acessar o banco de dados

  $base_d     =$_SESSION['base_d'];
  $banco_d    =$_SESSION['banco_d'];
  $usuario_d  =$_SESSION['usuario_d'];
  $senha_d    =$_SESSION['senha_d'];
  
  //Recupera o número da HAWBda memória
  
  
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

<HTML>
<HEAD>
 <TITLE>detalhes_entrega.php</TITLE>

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
  <?php
  switch (get_post_action('grava')) {
         case 'grava':
             $ocorrencia       =$_POST['ocorrencia'];
             $dt_evento        =$_POST['dt_evento'];
             $n_hawb           =$_SESSION['n_hawb_m'];
             $code_barra       =$_SESSION['cod_barra_m'];
             
             //mudando formato da data para gravar na tabela
             if (($dt_evento<>'')and ($dt_evento<>'0000-00-00')and ($n_hawb<>'')) {
                 $dt_evento  = explode("/",$dt_evento);
                 $v_dt_evento = $dt_evento[2]."-".$dt_evento[1]."-".$dt_evento[0];

                 $con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
                 $res = mysql_select_db($banco_d) or die ("Banco de dados inexistente");

                 $incluir = "INSERT INTO controle_reentrega (n_hawb,ocorrencia,dt_evento,cod_barra)
                 VALUES ('$n_hawb','$ocorrencia','$v_dt_evento','$code_barra')";

                 if (mysql_db_query($banco_d,$incluir,$con)) {
                    $resp_grava="Inclusão bem sucedida";
                    $ocorrencia         = '';
                    $dt_evento          = '';
                 }
                 else {
                    $resp_grava="Problemas na Inclusão";
                 }
             }
             else {
             ?>
                 <script language="javascript"> window.location.href=("detalhes_entrega.php")
                        alert('Você precisa definir uma data e número da HAWB.');
                 </script>
                 <?php
             }
         break;
         default:
     }
 ?>
<form name="cadastro" action="detalhes_entrega.php" method="post">
<INPUT type=button value="Fechar janela" onClick="window.close();">
	<table width="70%" border="1" cellpadding="5" cellspacing="0" bordercolor="#4169E1">
       <tr>
			<td><b>Número da HAWB :</b></td>
			<td><?php echo "$n_hawb";?></td>
	   </tr>
	   <tr>
			<td><b>Descrição da Ocorrência :</b></td>
            <td><input type="text" name="ocorrencia" size="100" maxlength="100" id="ocorrencia"></td>
		</tr>
		<!-- Coloca foco no primeiro campo codigo de barras do formulário -->
       <script language="JavaScript">
              document.getElementById('ocorrencia').focus();
       </script>
        <tr>
          <td><b>Data da entrega :</b></td>
          <td>
            <input type="text" name="dt_evento" size="12" maxlength="12" id="dt_evento">
            <input TYPE="button" NAME="btndt_evento" VALUE="..." Onclick="javascript:popdate('document.cadastro.dt_evento','pop1','150',document.cadastro.dt_evento.value)">
            <span id="pop1" style="position:absolute"></span>
          </td>
        </tr>
        <tr>
			<td colspan="2">
				<div align="right">
				<input name="grava" type="submit" value="Gravar">
				</div>
			</td>
		</tr>
	</table>
  </form>
</FORM>
</div>
</BODY>
</HTML>
