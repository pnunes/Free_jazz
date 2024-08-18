<?php
  session_start();

    //carrega variaveis com dados para acessar o banco de dados
 
	  Include('conexao_free.php');
	  
	  mysqli_set_charset($con,'UTF8');
	 
	  //verifica se o usuário esta habilitado para usar a rotina
	 
	  $matricula_m  =$_SESSION['matricula_m'];
	  $programa='080';
	  $_SESSION['programa_m']=$programa;
	  
	  //verifica se usuario esta habilitado a usar a rotina
	  
	  $confere = "SELECT matricula,programa
	  FROM permissoes
	  WHERE ((matricula='$matricula_m') and (programa='$programa'))";
	  $query = mysqli_query($con,$confere) or die ("Não foi possivel acessar o banco - Rotina Cadastro Pessoas");
	  $achou = mysqli_num_rows($query);
	  If ($achou == 0 ) {
		   ?>
			  <script language="javascript"> window.location.href=("entrada.php")
				alert('Você nã está autorizado a acessar esta rotina.');
			  </script>
		   <?php
	  }
	  else {
		$cnpj_cpf        ='';     
		$nome            ='';
		$cep             ='';
		$rua             ='';
		$numero          ='';
		$bairro          ='';
		$cidade          ='';
		$estado          ='';
		$ativo           ='';
		$ende_ele        ='';
		$telefone        =''; 
        $catego          =''; 		
	  }
	  
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
  <title>exclui_cli_for_cadastrado.php</title>
  <head>
  <body>
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
  <div id="geral" align="center">
    <body topmargin="0" leftmargin="0" rightmargin="0" bottommargin="0" marginheight="0" marginwidth="0" bgcolor="#FFFFFF">

     <table border="0" width="100%" bgcolor="#000000" cellspacing="0" cellpadding="0">
      <tr>
        <td width="20%" height="100" background="img/topleft.jpg"></td>
         <td width="658" height="110"> <img border="0" src="img/cabecalho_free_jazz.jpg" width="890" height="115" border="0"></td>
        <td width="15%" height="110">
        <p align="right"><img border="0" src="img/topright.jpg" width="160" height="110" border="0"></td>
     </tr>
    </table>
    <table border="0" width="100%" cellspacing="0" cellpadding="0" background="img/blue.jpg">
     <tr>
       <td width="50%">
         <p align="left"><font face="Arial" size="2" color="#FFFFFF"><b>Sistema de Gerenciamento da Logística de Encomendas</b></font></td>
       <td width="50%">
         <p align="right"><font face="Arial" size="2" color="#FFFFFF"><b>Clientes e Fornecedores - Alteração</b></font></td>
     </tr>
   </table>
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
  <table width="80%" heigth="300" align="center">
     <tr>
       <td>
         <form method="POST" action="exclui_cli_for_cadastrado.php" border="20">
            <?php
               echo "<center><Font size=\"2\" face=\"ARIAL\">Cliente/Fornecedor..:</font>";

               $resultado = mysqli_query ($con,"SELECT cnpj_cpf,nome
               FROM cli_for");
               echo "<select name='cli_for' class='caixa' align=\"center\">\n";
               while($linha = mysqli_fetch_row($resultado))  {
                  printf("<option value='$linha[0]'>$linha[0] - $linha[1] </option>\n");
               }
            ?>
              <input name="mostra" type="submit" value="Mostra"></center>
            </td>
           </tr>
         </form>
   </table>
  <?php
     switch (get_post_action('exclui','mostra')) {
         case 'mostra':
             $cnpj_cpf            =$_POST['cli_for'];
             
             $resp_grava='';
             
             $verifi="SELECT nome,rua,numero,bairro,cidade,uf,cep,telefone,ende_ele,catego,ativo FROM cli_for WHERE cnpj_cpf='$cnpj_cpf'";
             $query = mysqli_query($con,$verifi) or die ("Não foi possivel acessar o banco");
             $total = mysqli_num_rows($query);

             for($ic=0; $ic<$total; $ic++){
               $mostra = mysqli_fetch_row($query);

               $nome           = $mostra[0];
               $rua            = $mostra[1];
               $numero         = $mostra[2];
               $bairro         = $mostra[3];
               $cidade         = $mostra[4];
               $estado         = $mostra[5];
               $cep            = $mostra[6];
               $telefone       = $mostra[7];
               $ende_ele       = $mostra[8];
               $catego         = $mostra[9];
               $ativo          = $mostra[10];

              $pesquisa = "SELECT codi_cli FROM remessa
              WHERE codi_cli='$cnpj_cpf'";

              $query = mysqli_query($con,$pesquisa) or die ("Não foi possivel acessar o banco");
              $achou = mysqli_num_rows($query);

              If ($achou > 0 ) {
                   ?>
                      <script language="javascript"> window.location.href=("exclui_cli_for_cadastrado.php")
                        alert('Existe movimento em nome deste cliente. Para exclui-lo, exclua primeiro o movimento.');
                      </script>
                   <?php
              }
             }

             break;

         case 'exclui':
             $adm   =$_SESSION['adm_m'];
             if ($adm=='S') {
                
                $excluir = "DELETE FROM cli_for WHERE cnpj_cpf='$cnpj_cpf'";

                if (mysqli_query($con,$excluir)) {    
                   $resp_grava="Exclusão bem sucedida.";   
                }
                else {
                   $resp_grava="Problemas na Exclusão.";
                }
				$cnpj_cpf        ='';     
				$nome            ='';
				$cep             ='';
				$rua             ='';
				$numero          ='';
				$bairro          ='';
				$cidade          ='';
				$estado          ='';
				$ativo           ='';
				$ende_ele        ='';
				$telefone        ='';  
             }
             else  {
                 ?>
                  <script language="javascript"> window.location.href=("entrada.php")
                   alert('Você não está autorizado a fazer exclusões. Fale com o Administrador do sistema.');
                   </script>
                <?php
             }
         break;
         default:
     }
  ?>

  <body leftmargin="10" topmargin="10" marginwidth="10" marginheight="10">
  <form name="cadastro" action="exclui_cli_for_cadastrado.php" method="post" onSubmit="return validaForm()">
	<table width="50%" border="1" cellpadding="5" cellspacing="0" bordercolor="#4169E1">
        <tr>
           <td><b>CPF ou CNPJ:</b></td>
           <td><?php echo "$cnpj_cpf";?></td>
		</tr>
		<tr>
			<td><b>Nome:</b></td>
			<td><?php echo "$nome";?></td>
		</tr>
		<tr>
           <td><b>CEP:</b> </td>
           <td><?php echo "$cep";?></td>
        </tr>
		<tr>
			<td><b>Rua:</b></td>
			<td><?php echo "$rua";?></td>
		</tr>
		<tr>
			<td><b>Número:</b></td>
			<td><?php echo "$numero";?></td>
		</tr>
		<tr>
			<td><b>Bairro:</b></td>
			<td><?php echo "$bairro";?></td>
		</tr>
		<tr>
			<td><b>Cidade:</b></td>
			<td><?php echo "$cidade";?></td>
		</tr>
        <tr>
           <td><b>Estado:</b></td>
           <td><?php echo "$estado";?></td>
        </tr>
		<tr>
			<td><b>Telefones:</b></td>
			<td><?php echo "$telefone";?></td>
		</tr>
		<tr>
			<td><b>Email:</b></td>
			<td><?php echo "$ende_ele";?></td>
		</tr>
		<tr>
			<td><b>Categoria:</b></td>
			<td><?php echo "$catego";?> -("C" - Cliente / "F" - Fornecedor.)</td>
		</tr>
		<tr>
			<td><b>Ativo :</b></td>
			<td><?php echo "$ativo";?> - ("S" - Sim / "N" - Não.)</td>
		</tr>
		<tr>
            <td><INPUT type=button value="Clientes / Fornecedores Cadastrados"
               onClick="window.open('mostra_cli_for_cadastrados.php','janela_1',
               'scrollbars=yes,resizable=yes,width=800,height=500');">
            </td>
			<td colspan="2">
				<div align="right">
				<input name="exclui" type="submit" value="Excluir">
				</div>
			</td>
		</tr>
	</table>
  </div>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td color="white" align="center" width="900" height="45" colspan="8" ><?php echo "$resp_grava";?></td>
      </tr>
  </table>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
       <td color="white" align="left" width="100%" height="40">
     </tr>
  </table>
  <table width="100%"  border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td background="img/blue.jpg" align="left" width="100%" height="45px"><center><font face="arial" size="1" color="white">Todos Direitos Reservados a NUNESTEC Tecnologia</font></td>
    </tr>
  </table>

</body>
</html>

