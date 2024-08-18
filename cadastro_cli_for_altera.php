<?php
  session_start();

   //carrega variaveis com dados para acessar o banco de dados
 
  Include('conexao_free.php');
  
  mysqli_set_charset($con,'UTF8');
 
  //verifica se o usuário esta habilitado para usar a rotina
 
  $matricula_m  =$_SESSION['matricula_m'];
  $programa='004';
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
            alert('Você não está autorizado a acessar esta rotina.');
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
	$estado_n        ='';
	$estado_s        ='';
	$ativo           ='';
	$ende_ele        ='';
	$telefone        ='';
    $catego          ='';	
  }
  
  function get_post_action($name)
   {
    $params = func_get_args();
    foreach ($params as $name) {
        if (isset($_POST[$name])) {
            return $name;
        }
    }
   } 
?>
<html>
  <title>Cadastro_cli_for_altera.php</title>
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
         <form method="POST" action="cadastro_cli_for_altera.php" border="20">
            <?php
               echo "<center><Font size=\"2\" face=\"ARIAL\">Cliente/Fornecedor..:</font>";

               $resultado = mysqli_query ($con,"SELECT cnpj_cpf,nome, CASE catego WHEN 'C' THEN 'CLIENTE'  WHEN  'F' THEN 'FORNECEDOR' END as tipo
               FROM cli_for");
               echo "<select name='cli_for' class='caixa' align=\"center\">\n";
               while($linha = mysqli_fetch_row($resultado))  {
                  printf("<option value='$linha[0]'>$linha[0] - $linha[1] --- $linha[2]</option>\n");
               }
            ?>
              <input name="mostra" type="submit" value="Mostra"></center>
            </td>
           </tr>
         </form>
   </table>
  <?php
     $resp_grava='';
     switch (get_post_action('grava','mostra','busca')) {
         case 'mostra':
             $cnpj_cpf          =$_POST['cli_for'];
			 
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
               $estado_s       = $mostra[5];
               $cep            = $mostra[6];
               $telefone       = $mostra[7];
               $ende_ele       = $mostra[8];
               $catego         = $mostra[9];
               $ativo          = $mostra[10];
               
             }

             break;

         case 'busca':
           $cep       =$_POST['cep'];
		   
           //Busca o endereco a partir do cep digitado
		   
           $busca="SELECT logradouros.no_logradouro_cep,logradouros.ds_logradouro_nome,
		   bairros.ds_bairro_nome,cidades.ds_cidade_nome,uf.ds_uf_nome,uf.ds_uf_sigla,logradouros.classe_cep
		   FROM logradouros,bairros,cidades,uf
		   WHERE ((logradouros.cd_bairro=bairros.cd_bairro)
		   AND (bairros.cd_cidade=cidades.cd_cidade)
		   AND (uf.cd_uf=cidades.cd_uf)
		   AND (logradouros.no_logradouro_cep='$cep'))";

		   $resu = mysqli_query($con,$busca) or die ("Não foi possivel acessar o banco - Função Busca Cep");
		   $total_c = mysqli_num_rows($resu);
           
		   if($total_c > 0) {
			   for($ic=0; $ic<$total_c; $ic++){
				   $row = mysqli_fetch_row($resu);
				   
				   $cep            = $row[0];
				   $rua            = $row[1];
				   $bairro         = $row[2];
				   $cidade         = $row[3];
				   $estado_n       = $row[4];
				   $estado_s       = $row[5];
				   $classe_cep     = $row[6];  
			   }
		   }
		   else {
			  $resp_grava="CEP não localizado! Verifique."; 
		   }   
         break;

         case 'grava':
             $cnpj_cpf        =$_POST['cnpj_cpf'];
             $nome            =$_POST['nome'];
             $rua             =$_POST['rua'];
             $numero          =$_POST['numero'];
             $bairro          =$_POST['bairro'];
             $cidade          =$_POST['cidade'];
             $uf              =$_POST['estado'];
             $cep             =$_POST['cep'];
             $telefone        =$_POST['telefone'];
             $email           =$_POST['ende_ele'];
             $categoria       =$_POST['catego'];
             $ativo           =$_POST['ativo'];

             $ativo    =Strtoupper($ativo);
             $categoria=Strtoupper($categoria);
			 
             $alteracao = "UPDATE cli_for SET nome='$nome',rua='$rua',
             numero='$numero',bairro='$bairro',cidade='$cidade',
             uf='$uf',cep='$cep',telefone='$telefone',ende_ele='$email',
             catego='$categoria',ativo='$ativo'
             WHERE cnpj_cpf='$cnpj_cpf'";

             if (mysqli_query($con,$alteracao)) {
                $resp_grava="Alteração bem sucedida";
             }
             else {
                $resp_grava="Problemas na Alteração";
             }
			 
			 //Limpara variaveis
			
			 $cpf_cnpj        ='';    
			 $nome            ='';             
			 $cep             ='';
			 $rua             ='';
			 $numero          ='';
			 $bairro          ='';  
			 $cidade          ='';             
			 $estado        ='';              
			 $estado_s        ='';
			 $ativo           ='';
			 $ende_ele        ='';
			 $telefone        ='';
			 
            break;
         default:
     }
  ?>

  <body leftmargin="10" topmargin="10" marginwidth="10" marginheight="10">
  <form name="cadastro" action="cadastro_cli_for_altera.php" method="post" onSubmit="return validaForm()">
	<table width="50%" border="1" cellpadding="5" cellspacing="0" bordercolor="#4169E1">
        <tr>
           <td><b>CPF ou CNPJ:</b></td>
           <td><input type="text" name="cnpj_cpf" class="campo" id="cnpj_cpf" value ="<?php echo "$cnpj_cpf";?>"></td>
		</tr>
		<tr>
			<td><b>Nome:</b></td>
			<td><input type="text" name="nome" value ="<?php echo "$nome";?>" size="50" maxlength="50" id="nome"></td>
		</tr>
		<tr>
           <td><b>CEP:</b> </td>
           <td><input name="cep" type="text" id="cep" value ="<?php echo "$cep";?>" size="10" maxlength="9"><input name="busca" type="submit" value="Busca Endereço"</td>
        </tr>
		<tr>
			<td><b>Rua:</b></td>
			<td><input type="text" name="rua" value ="<?php echo "$rua";?>" size="40" maxlength="40" id="rua"></td>
		</tr>
		<tr>
			<td><b>Número:</b></td>
			<td><input type="text" name="numero" value ="<?php echo "$numero";?>" size="10" maxlength="10" id="numero"></td>
		</tr>
		<tr>
			<td><b>Bairro:</b></td>
			<td><input type="text" name="bairro" value ="<?php echo "$bairro";?>" size="40" maxlength="40" id="bairro"></td>
		</tr>
		<tr>
			<td><b>Cidade:</b></td>
			<td><input type="text" name="cidade" value ="<?php echo "$cidade";?>" size="40" maxlength="40" id="cidade"></td>
		</tr>
        <tr>
           <td><b>Estado:</b></td>
           <td><input name="estado" type="text" id="estado" value ="<?php echo "$estado";?>" size="2" maxlength="2"> - <?php echo "$estado_n";?></td>
        </tr>
		<tr>
			<td><b>Telefones:</b></td>
			<td><input type="text" name="telefone" value ="<?php echo "$telefone";?>" size="40" maxlength="40" id="telefone"></td>
		</tr>
		<tr>
			<td><b>Email:</b></td>
			<td><input type="text" name="ende_ele" value ="<?php echo "$ende_ele";?>" size="50" maxlength="50" id="ende_ele"></td>
		</tr>
		<tr>
			<td><b>Categoria:</b></td>
			<td><input type="text" name="catego" value ="<?php echo "$catego";?>" size="1" maxlength="1" id="catego"> - "C" - Cliente / "F" - Fornecedor.</td>
		</tr>
		<tr>
			<td><b>Ativo :</b></td>
			<td><input type="text" name="ativo" value ="<?php echo "$ativo";?>" size="1" maxlength="1" id="ativo"> - "S" - Sim / "N" - Não.</td>
		</tr>
		<tr>
            <td><INPUT type=button value="Clientes / Fornecedores Cadastrados"
               onClick="window.open('mostra_cli_for_cadastrados.php','janela_1',
               'scrollbars=yes,resizable=yes,width=800,height=500');">
            </td>
			<td colspan="2">
				<div align="right">
				<input name="grava" type="submit" value="Gravar">
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

