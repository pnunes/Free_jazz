<?php
  session_start();
  //carrega variaveis com dados para acessar o banco de dados
 
  Include('conexao_free.php');
  mysqli_set_charset($con,'UTF8');
   
  function get_post_action($name) {
    $params = func_get_args();
    foreach ($params as $name) {
        if (isset($_POST[$name])) {
            return $name;
        }
    }
  }
?>
<html>
  <title>atualiza_permissÃµes_usuario.php</title>
  <head>
     <meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
     <link rel="stylesheet" type="text/css" href="estilo_perfil_usuario.css" />
  </head>
  <body>
    <div id="cad_pessoas">
      <br><br>
      <form method="POST" action="atualiza_permissoes_usuario.php">
      <table id="perfil" width="950" border="1" cellpadding="5" cellspacing="0" bordercolor="#6495ED">
          <?php
              switch (get_post_action('atualiza')) {
                    case 'atualiza':
                    
                         $cpf  = $_SESSION['cpf_m'];
                         
                         foreach($_POST['progra'] as $programa){

                             //Pega o nome do programa para gravar no arquivo

                             $verifi="SELECT nome_programa FROM cad_rotinas
                             WHERE programa='$programa'";
                             $query = mysqli_query($con,$verifi) or die ("NÃ£o foi possivel acessar o banco");
                             $total = mysqli_num_rows($query);

                             for($ic=0; $ic<$total; $ic++){
                               $row = mysqli_fetch_row($query);
                               $nome_programa       = $row[0];
                             }

                             //Verifica se a permissÃ£o jÃ¡ esta gravada no arquivo

                            $declara = "SELECT cpf FROM permissoes
                            WHERE ((cpf='$cpf') AND (programa='$programa'))";
                            $query = mysqli_query($con,$declara) or die ("NÃ£o foi possivel acessar o banco");
                            $achou = mysqli_num_rows($query);
                            
                            If ($achou == 0 ) {
                               // Isere o registro no arquivo permissoes
                               mysqli_query("INSERT INTO permissoes (cpf,programa,nome_programa)
                                           VALUES ('$cpf','$programa','$nome_programa')");
                            }
                            else {
                               // apaga o registro o marcado
                               mysqli_query("DELETE FROM permissoes WHERE cpf='$cpf' AND programa='$programa'");
                            }
                           $num++;
                         }
                         unset($_SESSION['cpf_m']);
                    break;
                    default:
              }
          ?>
          <?php
            if ($_GET['codigo']) {
               $cpf = $_GET['codigo'];
               $_SESSION['cpf_m'] =$cpf;
               //echo "<p>CPF : $cpf";
            }

            //Pega o nome da pessoa

            $verifi="SELECT nome FROM pessoa WHERE cpf='$cpf'";
            $query = mysqli_query($con,$verifi) or die ("NÃ£o foi possivel acessar o banco");
            $total = mysqli_num_rows($query);

            for($ic=0; $ic<$total; $ic++){
               $row = mysqli_fetch_row($query);
               $nome        = $row[0];
            }
          ?>
          <tr>
             <td colspan="7" align="center" bgcolor="darkblue"><font face="arial" size="3" color="white">Perfil do usuario :</font><font color="#FFFF00" face="arial" size="3"><b><?php echo "$nome"; ?></b></font></td>
          </tr>
          <tr>
             <td align="center" bgcolor="darkblue"><font face="arial" size="2" color="white">Rotina Sistema</font></td>
             <td align="center" bgcolor="darkblue"><font face="arial" size="2" color="white">Status</font></td>
             <td align="center" bgcolor="darkblue"><font face="arial" size="2" color="white">Rotina Sistema</font></td>
             <td align="center" bgcolor="darkblue"><font face="arial" size="2" color="white">Status</font></td>
          </tr>
          <?php
            $sql = mysqli_query($con,"SELECT programa,nome_programa
            FROM cad_rotinas
            ORDER BY nome_programa");

            if (mysqli_num_rows($sql)==0) {
                echo "Não há permissões cadastradas para o usuário informado!";
            }
            else{
              $conta=0;
              echo "<div>";
              echo "<tr>";
              while ($x  = mysqli_fetch_array($sql)) {
                 $programa      = $x['programa'];
                 $nome_programa = $x['nome_programa'];
                 $loca_permi = mysqli_query($con,"SELECT programa FROM permissoes WHERE cpf='$cpf' AND programa ='$programa'");
                 if (mysqli_num_rows($loca_permi)> 0) {
                    if($conta > 1) {
                       echo "<tr>";
                       $conta=0;
                    }
                    echo "<td>";
                    echo $programa."<font face=\"arial\" size=\"1\"><input type =\"checkbox\" name = \"progra[]\" id=\"progra\" value=\"$programa\">$nome_programa";
                    echo "</td>";
                    echo "<td><font face=\"arial\" size=\"1\"><b>SIM</b></font></td>";
                 }
                 else {
                    if($conta > 1) {
                      echo "<tr>";
                      $conta=0;
                    }
                    echo "<td>";
                    echo $programa."<font face=\"arial\" size=\"1\"><input type =\"checkbox\" name = \"progra[]\" id=\"progra\" value=\"$programa\">$nome_programa";
                    echo "</td>";
                    echo "<td><font face=\"arial\" size=\"1\" color=\"red\"><b>NÃO</b></font></td>";
                 }
                 $conta++;
                 if ($conta > 1) {
                    echo "</tr>";
                 }
                 echo "</div>";
              }
            }
            ?>
            <tr>
			  <td colspan="6" align="center" bgcolor="darkblue">
				<input name="atualiza" type="submit" value="Atualizar">
			  </td>
		    </tr>
	  </table>
    </form>
 </div>
</body>
</html>

