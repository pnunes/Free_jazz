<?php
  session_start();

 //carrega variaveis com dados para acessar o banco de dados

  $base_d     =$_SESSION['base_d'];
  $banco_d    =$_SESSION['banco_d'];
  $usuario_d  =$_SESSION['usuario_d'];
  $senha_d    =$_SESSION['senha_d'];

?>

<HTML>
<HEAD>
 <TITLE>Documento PHP</TITLE>
</HEAD>
<BODY>
  <?php
      $data_jogo      =$_SESSION['data_jogo_i'];
      $membro         =$_SESSION['codigo_membro_i'];
      
      $con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
      $res = mysql_select_db($banco_d) or die ("Banco de dados inexistente");
      
      $apaga="DELETE FROM jogos
      WHERE ((codigo_membro='$membro')
      AND (data_jogo='$data_jogo'))";

      if (mysql_db_query($banco_d,$apaga,$con)) {
          $resp_grava="Cancelamento bem sucedido.";
          $data_jogo      ='';
          $membro         ='';
          $_SESSION['abre_m']  = 1;
          ?>
          <script> window.location.href=("main.php");</script>
          <?php
      }
      else {
          $resp_grava="Problemas no Cancelamento.";
          $_SESSION['abre_m']  = 1;
          ?>
          <script> window.location.href=("main.php");</script>
          <?php
      }
   ?>
   <table width="100%" border="0" cellspacing="0" cellpadding="0">
     <tr>
       <td color="white" align="center" width="100%" height="400">
     </tr>
  </table>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td color="white" align="center" width="900" height="45" colspan="8" ><?php echo "$resp_grava";?></td>
    </tr>
  </table>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td color="white" align="left" width="100%" height="30">
    </tr>
  </table>
  <table border="0" width="100%" cellspacing="0" cellpadding="0" background="img/marron.jpg">
    <tr>
      <td width="100%" height="25" align="center"></font><font color="white" size="1" face="Arial">©&nbsp; COPYRIGHT NUNESTECH Tecnologia em Sistemas Ltda</font></td>
    </tr>
  </table>
</BODY>
</HTML>
