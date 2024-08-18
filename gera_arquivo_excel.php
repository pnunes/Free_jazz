<?php
  if ( session_status() !== PHP_SESSION_ACTIVE ) {    session_start();  }    // Ativa conexao com o banco
  Include('conexao_free.php');  mysqli_set_charset($con,'UTF8');

  //consulta sql
  $SQL = "SELECT  `brideLastName`, `brideFirstName`, `brideEmail`, `address`, `city`, `state` FROM `users`" ;
  $executa = mysqli_query($con,$SQL);
  // definimos o tipo de arquivo
  header("Content-type: application/msexcel");
  // Como serÃ¡ gravado o arquivo
  header("Content-Disposition: attachment; filename=users.xls");
  // montando a tabela
  echo "<table>";
     echo "<tr>";
        echo "<td></td>";
		echo "<td>LastName</td>";
		echo "<td>FirstName</td>";
		echo "<td>E-mail</td>";
		echo "<td>Address</td>";
		echo "<td>city</td>";
		echo "<td>state</td>";
	 echo "</tr>";
  $i=1;
  while ($rs = mysql_fetch_array($executa)){
    echo "<tr>";
      echo "<td>".$i."</td>";
      echo "<td>" . $rs["brideLastName"] . "</td>";
      echo "<td>" . $rs["brideFirstName"] . "</td>";
      echo "<td>" . $rs["brideEmail"] . "</td>";
      echo "<td>" . $rs["address"] . "</td>";
      echo "<td>" . $rs["city"] . "</td>";
      echo "<td>" . $rs["state"] . "</td>";
    echo "</tr>";
    $i++;
  }
  echo "</table>";
?>

<HTML>
<HEAD>
 <TITLE>gera_arquivo_excel.php</TITLE>

 <style>
   body, p, div, td, input, select, textarea {
     font-family: verdana,arial,helvetica;
     font-size:12px;
     color:#000000;
     text-decoration: none;
   }
   input,textarea {
      @if (is.ie) {
        color: #000000; background-color:#F0FFF0; border: 1px solid #009933;
        /*border-top-width: 1px; border-right-width: 1px; border-bottom-width: 1px; border-left-width: 1px; */
      }
   }
   textarea { overflow:auto }
   </style>

</HEAD>

<BODY>

<FORM>
<INPUT type=button value="Fechar janela" onClick="window.close();">
</FORM>
<table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#009933">
 <tr>
    <td colspan="3" align="center"><font face="arial" size="2"><b>DEPARTAMENTOS CADASTRADOS</b></font></td>
 </tr>
 <tr>
     <td width="10%" align="center"><b>CODIGO</b></td>
     <td width="75%" align="center"><b>NOME</b></td>
     <td width="15%" align="center"><b>SIGLA</b></td>
 </tr>
<?php
      mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
      mysql_select_db($banco_d) or die ("Banco de dados inexistente");

      $resultado = mysql_query ("SELECT codigo,nome,sigla
                   FROM regi_dep");
      $total = mysql_num_rows($resultado);

      for($i=0; $i<$total; $i++){
         $dados = mysql_fetch_row($resultado);
	     $codigo         =$dados[0];
	     $nome           =$dados[1];
	     $sigla          =$dados[2];
	     echo "<tr>";
	     echo "<td width=\"10%\" align=\"left\"><font size=\"2\" face=\"arial\">$codigo</font></td>";
	     echo "<td width=\"75%\"><font size=\"2\" face=\"arial\">$nome</font></td>";
	     echo "<td width=\"15%\"><font size=\"2\" face=\"arial\">$sigla</font></td>";
         echo "</tr>";
       }
?>
</table>
</div>
</BODY>
</HTML>
