<?php
  session_start();
?>
<HTML>
<HEAD>
 <TITLE>apaga_imagem_pod.php</TITLE>
</HEAD>
<BODY>
<?php
   $arquivo = $_GET['arquivo'];
   if ($arquivo<>'') {
       unlink("hawbs/".$arquivo)
       ?>
       <SCRIPT LANGUAGE="JavaScript" TYPE="text/javascript"> alert ("Arquivo exclu�do com sucesso")</SCRIPT>
       <SCRIPT language="JavaScript">window.location.href="apaga_imagem_servidor.php";</SCRIPT>
       <?php
   }
   else {
       ?>
       <SCRIPT LANGUAGE="JavaScript" TYPE="text/javascript"> alert ("N�o foi poss�vel excluir o arquivo")</SCRIPT>
       <SCRIPT language="JavaScript">window.location.href="apaga_imagem_servidor.php";</SCRIPT>
       <?php
   }

?>
</BODY>
</HTML>
