<?php
  session_start();

 //carrega variaveis com dados para acessar o banco de dados

  $base_d     =$_SESSION['base_d'];
  $banco_d    =$_SESSION['banco_d'];
  $usuario_d  =$_SESSION['usuario_d'];
  $senha_d    =$_SESSION['senha_d'];
  
  $matricula_m  =$_SESSION['matricula_m'];
  $programa='091';
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
  
  switch (get_post_action('limpa')) {
       case 'limpa':
              $directory  ='baixa_dibra';
              $empty=TRUE;
              
              if(substr($directory,-1) == '') {
                 $directory = substr($directory,0,-1);
              }
              if(!file_exists($directory) || !is_dir($directory)) {
                 return FALSE;
              }
              elseif(!is_readable($directory)) {
                 return FALSE;
              }
              else {
                $handle = opendir($directory);
                while (FALSE !== ($item = readdir($handle))) {
                    if($item != '.' && $item != '..') {
                        $path = $directory.'/'.$item;
                        if(is_dir($path)) {
                            removing($path);
                        }
                        else {
                            unlink($path);
                        }
                    }
                }
                closedir($handle);
                if($empty == FALSE) {
                   if(!rmdir($directory)) {
                        return FALSE;
                   }
                }

              }
       break;
       default:
  }

 ?>

<HTML>
<HEAD>
 <TITLE>limpa_pasta_baixa.php</TITLE>
 <html>
  <title>Altera_lista.php</title>
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
         <p align="right"><font face="Arial" size="2" color="#FFFFFF"><b>Limpa pasta de arquivos TXT de baixa</b></font></td>
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
   <form method="POST" action="limpa_pasta_baixa.php" border="20">
      <table width="60%" border="1" cellpadding="5" cellspacing="0" bordercolor="#6495ED">
         <tr>
             <?php
             // pega o endereço do diretório
             
             $diretorio='baixa_dibra';
             // abre o diretório
             $ponteiro  = opendir($diretorio);// monta os vetores com os itens encontrados na pasta
             while ($nome_itens = readdir($ponteiro)) {
               $itens[] = $nome_itens;
             }
             // ordena o vetor de itens
             sort($itens);
            // percorre o vetor para fazer a separacao entre arquivos e pastas
             foreach ($itens as $listar) {
            // retira "./" e "../" para que retorne apenas pastas e arquivos
               if ($listar!="." && $listar!=".."){

                 // checa se o tipo de arquivo encontrado é uma pasta
                 if (is_dir($listar)) {
                   // caso VERDADEIRO adiciona o item à variável de pastas
                   $pastas[]=$listar;
                 }
                 else{
                   // caso FALSO adiciona o item à variável de arquivos
                   $arquivos[]=$listar;
                 }
               }
             }
             // lista as pastas se houverem
            // if ($pastas != "" ) {
            //    foreach($pastas as $listar){
            //    print "<p><img border=\"0\" src=\"img/pastas.jpg\" border=\"0\">..$listar";
            //    }
            // }
            echo "<td>";
               // lista os arquivos se houverem
               if ($arquivos != "") {
                  foreach($arquivos as $listar){
                     print "<p><img border=\"0\" src=\"img/arquivos.jpg\" border=\"0\">$listar";
                  }
               }
               else {
                 $resp_grava="A pasta esta vazia.";
               }
            echo "</td>";
            ?>
          </tr>
          <tr>
             <td colspan="2">
                <div align="right">
	                 <input name="limpa" type="submit" value="Limpar">
                </div>
             </td>
          </tr>
       </table>
       <table width="60%" border="0" cellspacing="0" cellpadding="0" align="center">
          <tr>
             <td color="white" width="900" height="45" colspan="8" align="center"><font face="arial" size="3" color="red"><b><?php echo "$resp_grava";?></b></font></td>
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
