<?php
   session_start();

   //carrega variaveis com dados para acessar o banco de dados

   $base_d     =$_SESSION['base_d'];
   $banco_d    =$_SESSION['banco_d'];
   $usuario_d  =$_SESSION['usuario_d'];
   $senha_d    =$_SESSION['senha_d'];

   $matricula_m  =$_SESSION['matricula_m'];
   $programa='76';
   $_SESSION['programa_m']=$programa;

   // Abre conex�o com o banco de dados

   $con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conex�o");
   $res = mysql_select_db($banco_d) or die ("Banco de dados inexistente");

   $declara = "SELECT matricula,programa
   FROM permissoes
   WHERE ((matricula='$matricula_m') and (programa='$programa'))";

   $query = mysql_db_query($banco_d,$declara,$con) or die ("N�o foi possivel acessar o banco");
   $achou = mysql_num_rows($query);

   If ($achou == 0 ) {
       ?>
          <script language="javascript"> window.location.href=("entrada.php")
            alert('Voc� n�o est� autorizado a acessar esta rotina.');
          </script>
       <?php
   }

   
   // gerando um arquivo sql. Como?
   // a fun��o fopen, abre um arquivo, que no meu caso, ser� chamado como: nomedobanco.sql
   // note que eu estou concatenando dinamicamente o nome do banco com a extens�o .sql.
   $back = fopen("backups/free_jazz.sql","w");
   
   // aqui, listo todas as tabelas daquele banco selecionado acima
   $res = mysql_list_tables($banco_d) or die(mysql_error());
   
   // resgato cada uma das tabelas, num loop
   while ($row = mysql_fetch_row($res))  {
      $table = $row[0];
      // usando a fun��o SHOW CREATE TABLE do mysql, exibo as fun��es de cria��o da tabela,
      // exportando tamb�m isso, para nosso arquivo de backup
      $res2 = mysql_query("SHOW CREATE TABLE $table");
      // instru��es que ser�o gravadas no arquivo de backup
      
      while ($lin = mysql_fetch_row($res2)){
          fwrite($back,"\n#\n# Cria��o da Tabela : $table\n#\n\n");
          fwrite($back,"$lin[1] ;\n\n#\n# Dados a serem inclu�dos na tabela\n#\n\n");
      
         // seleciono todos os dados de cada tabela pega no while acima
          // e depois gravo no arquivo .sql, usando comandos de insert
          $res3 = mysql_query("SELECT * FROM $table");
          while($r=mysql_fetch_row($res3)) {
              $sql="INSERT INTO $table VALUES (";
              for($j=0; $j<mysql_num_fields($res3);$j++)  {
                 if(!isset($r[$j]))
                   $sql .= " '',";
                 elseif($r[$j] != "")
                   $sql .= " '".addslashes($r[$j])."',";
                 else
                 $sql .= " '',";
                 }
                 $sql = ereg_replace(",$", "", $sql);
                 $sql .= ");\n";
                 fwrite($back,$sql);
          }
      }
   }
   // fechar o arquivo que foi gravado
   fclose($back);
   // gerando o arquivo para download, com o nome do banco e extens�o sql.
   $arquivo = $banco_d.".sql";
   Header("Content-type: application/sql");
   Header("Content-Disposition: attachment; filename=$arquivo");
   // l� e exibe o conte�do do arquivo gerado
   readfile($arquivo);
?>
