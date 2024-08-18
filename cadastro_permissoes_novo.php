<?php
  session_start();
  //carrega variaveis com dados para acessar o banco de dados
 
  Include('conexao_free.php');
  mysqli_set_charset($con,'UTF8');
   
  //verifica se o usuário esta habilitado para usar a rotina
 
  $matricula_m  =$_SESSION['matricula_m'];
  $programa='017';
  $_SESSION['programa_m']=$programa;
  
  $confere = "SELECT matricula,programa
  FROM permissoes
  WHERE ((matricula='$matricula_m') and (programa='$programa'))";
  $query = mysqli_query($con,$confere) or die ("Não foi possivel acessar o banco - Rotina Cadastro Destinos");
  $achou = mysqli_num_rows($query);
  If ($achou == 0 ) {
       ?>
          <script language="javascript"> window.location.href=("entrada.php")
            alert('Você não está autorizado a acessar esta rotina.');
          </script>
       <?php
  }
  else {
	    
	$codigo      ='';
    $nome        ='';
    $funcao      =''; 
	
    $resp_grava='';	
  }   
?>

<html>
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
   <link rel="stylesheet" type="text/css" href="pg_cad_pessoas.css" />
   
   <script type="text/javascript">
    function openWin(url,name) {
        popupWin = window.open(url, name,
        'scrollbars=yes,resizable=yes,width=900,height=500');
    }
 </script>
</head>
<body>
    <div id="cad_pessoas">
        <form name="cadastro" id="cadastro" action="cadastro_permissao_novo.php" method="post">
        <div class="tabContainer" id="lista">
    	  <table border="0px">
    		<thead>
    		  <tr>
    			<th class="tabela-coluna0"><span><font size="2" color="white"><b>CPF</b></font></span></th>
    			<th class="tabela-coluna1"><span><font size="2" color="white"><b>NOME</b></font></span></th>
    			<th class="tabela-coluna2"><span><font size="2" color="white"><b>FUNÇÃO</b></font></span></th>
    			<th class="tabela-coluna3"><span><font size="2" color="white"><b>Atualiza</b></font></span></th>
    		  </tr>
    		</thead>
    	  </table>
          <div class="scrollContainer">
            <table border="0">
              <?php
                $lista = "SELECT matricula,nome,funcao FROM pessoa";
                $query = mysqli_query($con,$lista) or die ("Não foi possivel acessar o banco 2");
                $total = mysqli_num_rows($query);

                for($i=0; $i<$total; $i++){
                	$dados = mysqli_fetch_row($query);
                	$codigo     = $dados[0];
                	$nome       = $dados[1];
                	$funcao     = $dados[2];
                    $idLinha = "linha$i";
            	    echo '<tr id="'.$idLinha.'">';
            	    echo '<td class="tabela-coluna0"><span><font face="arial" size="2">'.$codigo.'</font></span></td>';
            	    echo "<td class=\"tabela-coluna1\"><span><font face=\"arial\" size=\"2\">$nome</font></span></td>";
            	    echo "<td class=\"tabela-coluna2\"><span><font face=\"arial\" size=\"2\">$funcao<font face=\"arial\" size=\"1\"></span></td>";
            	    //echo "<td class=\"tabela-coluna3\"><span><a href='cadastro_permissoes_inclui.php?codigo=$codigo&acao=2&ret_n4=cadastro_pessoas.php'><img src=\"img/ok.png\" border=\"none\" alt=\"Permitir\"></a></span></td>";
                    //echo "<td class=\"tabela-coluna4\"><span><a href='cadastro_permissoes_exclui.php?codigo=$codigo&acao=3&ret_n4=cadastro_pessoas.php'><img src=\"img/nao.png\" border=\"none\" alt=\"Tirar Permissão\"></a></span></td>";
                    echo "<td class=\"tabela-coluna4\"><span><a href='atualiza_permissoes_usuario.php?codigo=$codigo&acao=3&ret_n4=cadastro_permissoes.php'><img src=\"img/lupa_b.png\" border=\"none\"></a></span></td>";
                }
              ?>
            </table>
          </div>
          <table width="750" border="1" bgcolor="darkblue">
           <tr>
              <td width="750" height="25" border="1" bgcolor="darkblue"><font color="darkblue">so para encher espaco</font></td>
    	   </tr>
          </table>
        </div>
        </form>
    </div>
</body>
</html>

