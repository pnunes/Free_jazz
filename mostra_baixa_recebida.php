<?php
  session_start();

 //carrega variaveis com dados para acessar o banco de dados

  $base_d     =$_SESSION['base_d'];
  $banco_d    =$_SESSION['banco_d'];
  $usuario_d  =$_SESSION['usuario_d'];
  $senha_d    =$_SESSION['senha_d'];
  
  $controtra          =$_SESSION['contro'];

?>

<HTML>
<HEAD>
 <TITLE>mostra_baixa_recebida.php</TITLE>

 <?php
 // pega o endere�o do diret�rio
 //$diretorio = getcwd();
 $diretorio='baixas';
 // abre o diret�rio
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

     // checa se o tipo de arquivo encontrado � uma pasta
     if (is_dir($listar)) {
       // caso VERDADEIRO adiciona o item � vari�vel de pastas
       $pastas[]=$listar;
     }
     else{
       // caso FALSO adiciona o item � vari�vel de arquivos
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
 // lista os arquivos se houverem
 if ($arquivos != "") {
    foreach($arquivos as $listar){
      print "<p><img border=\"0\" src=\"img/arquivos.jpg\" border=\"0\">$listar";
      }
 }
?>


</BODY>
</HTML>
