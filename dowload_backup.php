<HTML>
<HEAD>
 <TITLE>Documento PHP</TITLE>
</HEAD>
<BODY>
<form action="dowload_backup.php" method="GET">
Receber o arquivo <input type="text" name="arquivo">
<input type="submit" value="Receber arquivo">
<?php
   $arquivo = $_GET["arquivo"];
   $dir     = 'backups/';
   define('DIR_DOWNLOAD','backups/');
   $arquivo = $dir.$arquivo;
   if(isset($arquivo) && file_exists($arquivo)){ // faz o teste se a variavel n�o esta vazia e se o arquivo realmente existe
      switch(strtolower(substr(strrchr(basename($arquivo),"."),1))){ // verifica a extens�o do arquivo para pegar o tipo
         case "pdf": $tipo="application/pdf"; break;
         case "exe": $tipo="application/octet-stream"; break;
         case "zip": $tipo="application/zip"; break;
         case "doc": $tipo="application/msword"; break;
         case "xls": $tipo="application/vnd.ms-excel"; break;
         case "ppt": $tipo="application/vnd.ms-powerpoint"; break;
         case "gif": $tipo="image/gif"; break;
         case "png": $tipo="image/png"; break;
         case "jpg": $tipo="image/jpg"; break;
         case "mp3": $tipo="audio/mpeg"; break;
         case "sql": $tipo="application/wordpad"; break;
         case "htm": // deixar vazio por seuran�a
         case "html": // deixar vazio por seuran�a
      }
      header("Content-Type: ".$tipo); // informa o tipo do arquivo ao navegador
      header("Content-Length: ".filesize($arquivo)); // informa o tamanho do arquivo ao navegador
      header("Content-Disposition: attachment; filename=".basename($arquivo)); // informa ao navegador que � tipo anexo e faz abrir a janela de download, tambem informa o nome do arquivo
      readfile($arquivo); // l� o arquivo
   }
   else {
      ?>
      <script language="javascript"> window.location.href=("dowload_backup.php")
          alert('Arquivo n�o localizado! Verifique.');
      </script>
      <?php
    }
?>

</form>
</BODY>
</HTML>
