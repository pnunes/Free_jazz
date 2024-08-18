<?php
  if ( session_status() !== PHP_SESSION_ACTIVE ) {
    session_start();
  }

   //carrega variaveis com dados para acessar o banco de dados
 
  Include('conexao_free.php');
  mysqli_set_charset($con,'UTF8');
   
  //verifica se o usuário esta habilitado para usar a rotina
 
  $matricula_m  =$_SESSION['matricula_m'];
  $programa='034';
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
 
  function get_post_action($name) {
  $params = func_get_args();
    foreach ($params as $name) {
        if (isset($_POST[$name])) {
            return $name;
        }
    }
  }
  if ($_SESSION['entrada_m']=='S')  {
       $codi_barra     = '';
	   $codi_cli       = '';
	   $nome_cli       = '';
	   $escritorio     = '';
	   $nome_escri     = '';
	   $tipo_servi     = '';
	   $nome_servi     = '';
	   $codigo_desti   = '';
	   $nome_desti     = '';
	   $cep_desti      = '';
	   $rua_desti      = '';
	   $numero_desti   = '';
	   $comple_desti   = '';
	   $bairro_desti   = '';
	   $cidade_desti   = '';
	   $estado_desti   = '';
	   $n_remessa      = '';
	   $controle       = '';
	   $dt_remessa     = '';
	   $n_hawb         = '';
	   
	   $resp_grava     = '';
  }
   $foco=0;
?>
<html>
  <title>lanca_remessa_com_leitora.php</title>
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
   
   <script>
       function salva(campo){
            cadastro.submit()
       }
  </script>
  </head>
  <div id="geral" align="center">
    <body onkeydown="desabilitaCtrlJ(event)" topmargin="0" leftmargin="0" rightmargin="0" bottommargin="0" marginheight="0" marginwidth="0" bgcolor="#FFFFFF">
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
         <p align="right"><font face="Arial" size="2" color="#FFFFFF"><b>Exclui Remessa Com Leitora</b></font></td>
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
   <form method="POST" name="cadastro" action="exclui_remessa_com_leitora.php" border="20">
       <table width="70%" border="1" cellpadding="5" cellspacing="0" bordercolor="#4169E1" align="center">

           <?php
		      if(isset($_POST['codi_barra'])) {
				  
				  $codi_barra     =$_POST['codi_barra'];

				  if ($codi_barra<>'') {
				  
					 $_SESSION['codi_barra_m']   =$codi_barra;
					 
					 //Pega o registro na tabela remessa para mostrar antes de excluir
			
					 $resp_grava='';
					 

					 $verifi="SELECT controle,codi_cli,escritorio,codigo_desti,nome_desti,cep_desti,
					 rua_desti,numero_desti,comple_desti,bairro_desti,cidade_desti,estado_desti,
					 dt_remessa,n_remessa,controle,tipo_servi,date_format(dt_remessa,'%d/%m/%Y'),n_hawb
					 FROM remessa
					 WHERE cod_barra='$codi_barra'";
					 $query = mysqli_query($con,$verifi) or die ("Não foi possivel acessar o banco");
					 $total = mysqli_num_rows($query);

					 //Verifica se a HAWB foi lançada
					 
					 If ($total == 0 ) {
						 $codi_barra='';
						 ?>
						 <script language="javascript"> window.location.href=("exclui_remessa_com_leitora.php")
						   alert('HAWB não foi lançaada.');
						 </script>
						 <?php
					 }
					 else {
					   for($ic=0; $ic<$total; $ic++){
						 $mostra = mysqli_fetch_row($query);
						 $controle       = $mostra[0];
						 $codi_cli       = $mostra[1];
						 $escritorio     = $mostra[2];
						 $codigo_desti   = $mostra[3];
						 $nome_desti     = $mostra[4];
						 $cep_desti      = $mostra[5];
						 $rua_desti      = $mostra[6];
						 $numero_desti   = $mostra[7];
						 $comple_desti   = $mostra[8];
						 $bairro_desti   = $mostra[9];
						 $cidade_desti   = $mostra[10];
						 $estado_desti   = $mostra[11];
						 $dt_remessa     = $mostra[12];
						 $n_remessa      = $mostra[13];
						 $controle       = $mostra[14];
						 $tipo_servi     = $mostra[15];
						 $dt_remessa     = $mostra[16];
						 $n_hawb         = $mostra[17];
						 
					   }
					   $_SESSION['controle_m']   =$controle;
					   $_SESSION['n_hawb_m']     =$n_hawb;
					   
					   //Pega o nome do cliente.

					   $resultado = mysqli_query ($con,"SELECT nome
					   FROM cli_for
					   WHERE cnpj_cpf='$codi_cli'");
					   $total = mysqli_num_rows($resultado);

					   for($i=0; $i<$total; $i++){
						 $dados = mysqli_fetch_row($resultado);
						 $nome_cli       =$dados[0];
					   }
					   
					   //Pega o nome do escritório.

					   $resultado = mysqli_query ($con,"SELECT nome
					   FROM regi_dep
					   WHERE codigo='$escritorio'");
					   $total = mysqli_num_rows($resultado);

					   for($i=0; $i<$total; $i++){
						 $dados = mysqli_fetch_row($resultado);
						 $nome_escri       =$dados[0];
					   }

					   //Pega o nome do serviço.

					   $resultado = mysqli_query ($con,"SELECT descri_se
					   FROM serv_ati
					   WHERE codigo_se='$tipo_servi'");
					   $total = mysqli_num_rows($resultado);

					   for($i=0; $i<$total; $i++){
						$dados = mysqli_fetch_row($resultado);
						$nome_servi       =$dados[0];
					   }

					 }
				  }
              }
              switch (get_post_action('exclui','mostra')) {
                 case 'mostra':
                      $n_hawb     =$_POST['n_hawb'];

                      if ($n_hawb <>'') {
						  
                         $_SESSION['n_hawb_m']   =$n_hawb ;
                         
                         //Pega o registro na tabela remessa para mostrar antes de excluir

                         $resp_grava='';
                        
                         $verifi="SELECT controle,codi_cli,escritorio,codigo_desti,nome_desti,cep_desti,
                         rua_desti,numero_desti,comple_desti,bairro_desti,cidade_desti,estado_desti,
                         dt_remessa,n_remessa,controle,tipo_servi,date_format(dt_remessa,'%d/%m/%Y'),n_hawb
                         FROM remessa
                         WHERE n_hawb='$n_hawb'";
                         $query = mysqli_query($con,$verifi) or die ("Não foi possivel acessar o banco");
                         $total = mysql_num_rows($query);

                         //Verifica se o movimento foi lançado

                         If ($total == 0 ) {
                            $n_hawb='';
                            ?>
                            <script language="javascript"> window.location.href=("exclui_remessa_com_leitora.php")
                               alert('HAWB não foi lançada.');
                            </script>
                            <?php
                         }
                         else {
                           for($ic=0; $ic<$total; $ic++){
                             $mostra = mysqli_fetch_row($query);
                             $controle       = $mostra[0];
                             $codi_cli       = $mostra[1];
                             $escritorio     = $mostra[2];
                             $codigo_desti   = $mostra[3];
                             $nome_desti     = $mostra[4];
                             $cep_desti      = $mostra[5];
                             $rua_desti      = $mostra[6];
                             $numero_desti   = $mostra[7];
                             $comple_desti   = $mostra[8];
                             $bairro_desti   = $mostra[9];
                             $cidade_desti   = $mostra[10];
                             $estado_desti   = $mostra[11];
                             $dt_remessa     = $mostra[12];
                             $n_remessa      = $mostra[13];
                             $controle       = $mostra[14];
                             $tipo_servi     = $mostra[15];
                             $dt_remessa     = $mostra[16];
                             $n_hawb         = $mostra[17];
                           }
                           $_SESSION['controle_m']   =$controle;
                           $_SESSION['n_hawb_m']     =$n_hawb;
                           
                           //Pega o nome do cliente.

                           $resultado = mysqli_query ($con,"SELECT nome
                           FROM cli_for
                           WHERE cnpj_cpf='$codi_cli'");
                           $total = mysqli_num_rows($resultado);

                           for($i=0; $i<$total; $i++){
                             $dados = mysqli_fetch_row($resultado);
                             $nome_cli       =$dados[0];
                           }
                          
                           //Pega o nome do escritório.

                           $resultado = mysqli_query ($con,"SELECT nome
                           FROM regi_dep
                           WHERE codigo='$escritorio'");
                           $total = mysqli_num_rows($resultado);

                           for($i=0; $i<$total; $i++){
                             $dados = mysqli_fetch_row($resultado);
                             $nome_escri       =$dados[0];
                           }

                           //Pega o nome do serviço.

                           $resultado = mysqli_query ($con,"SELECT descri_se
                           FROM serv_ati
                           WHERE codigo_se='$tipo_servi'");
                           $total = mysqli_num_rows($resultado);

                           for($i=0; $i<$total; $i++){
                            $dados = mysqli_fetch_row($resultado);
                            $nome_servi       =$dados[0];
                           }

                         }
                      }

                     break;
                     
                 case 'exclui':

                     $controle   =$_SESSION['controle_m'];
                     $adm        =$_SESSION['adm_m'];
					 
                     If ($adm=='S') {
                       
                        $exclusao = "DELETE FROM remessa WHERE controle='$controle'";

                        if (mysqli_query($con,$exclusao)) {
                        
                           //Atualiza a tabela log_operação sistema
						   
                           $programa     =$_SESSION['programa_m'];
                           $matricula_m  =$_SESSION['matricula_m'];
                           $hora         = date ('H:i:s');
                           $data         = date('Y-m-d');
                           $n_hawb       =$_SESSION['n_hawb_m'];

                           $inclui="INSERT INTO log_operacao_sistema(matricula,tarefa_executada,data,hora,rotina,n_hawb)
                           VALUES('$matricula_m','Exclusão de hawb do sistema','$data','$hora',
                           '$programa','$n_hawb')";
                           mysqli_query($con,$inclui);

                           $n_hawb       =$_SESSION['n_hawb_m'];
						   
                           $deleta ="DELETE FROM controle_reentrega WHERE n_hawb='$n_hawb'";
                           mysqli_query($con,$deleta);
                           
                           $resp_grava="Exclusão bem sucedida";
                           $codi_barra     = '';
                           $codi_cli       = '';
                           $nome_cli       = '';
                           $escritorio     = '';
                           $nome_escri     = '';
                           $tipo_servi     = '';
                           $nome_servi     = '';
                           $codigo_desti   = '';
                           $nome_desti     = '';
                           $cep_desti      = '';
                           $rua_desti      = '';
                           $numero_desti   = '';
                           $comple_desti   = '';
                           $bairro_desti   = '';
                           $cidade_desti   = '';
                           $estado_desti   = '';
                           $n_remessa      = '';
                           $controle       = '';
                           $dt_remessa     = '';
                           $n_hawb         = '';
                           unset($_SESSION['controle_m']);
                        }
                        else {
                          $resp_grava="Problemas na Exclusão";
                        }
                     }
                     else {
                           ?>
                           <script language="javascript"> window.location.href=("exclui_remessa_com_leitora.php")
                               alert('Você não está autorizado a fazer exclusões no Sistema! Fale com o Adminstrador.');
                           </script>
                           <?php
                           $codi_barra     = '';
                           $codi_cli       = '';
                           $nome_cli       = '';
                           $escritorio     = '';
                           $nome_escri     = '';
                           $tipo_servi     = '';
                           $nome_servi     = '';
                           $codigo_desti   = '';
                           $nome_desti     = '';
                           $cep_desti      = '';
                           $rua_desti      = '';
                           $numero_desti   = '';
                           $comple_desti   = '';
                           $bairro_desti   = '';
                           $cidade_desti   = '';
                           $estado_desti   = '';
                           $n_remessa      = '';
                           $controle       = '';
                           $dt_remessa     = '';
                           $n_hawb         = '';
                           unset($_SESSION['controle_m']);
                     }
                     break;
                     default:
              }
           ?>
        <tr>
           <td><b>Codigo Barras:</b></td>
           <td><input type="text" name="codi_barra" id="codi_barra" value ="<?php echo "$codi_barra";?>" size="60" maxlength="60" onChange="salva(this)"><font color="red"></font></td>
           <!--<input name="mostra" type="submit" value="Mostra"></td>-->
         </tr>
         <?php if ($foco==0) { ?>
          <script language="JavaScript">
            <!-- Coloca foco no primeiro campo codigo de barras do formulário -->
            document.getElementById('codi_barra').focus()
          </script>
         <?php } ?>
        <tr>
           <td><b>Número da HAWB:</b></td>
           <td><input type="text" name="n_hawb" class="campo" size="30" maxlength="30" id="n_hawb" value ="<?php echo "$n_hawb";?>"><input name="mostra" type="submit" value="Mostra">(Use este campo para excluir pelo número da HWAB.)</td></td>
		</tr>
        <tr>
           <td><b>Cliente :</b></td>
           <td><?php echo "$codi_cli";?> - <?php echo "$nome_cli";?></td>
		</tr>
		<tr>
           <td><b>Escritório :</b></td>
           <td><?php echo "$escritorio";?> - <?php echo "$nome_escri";?></td>
		</tr>
		<tr>
           <td><b>Serviço :</b></td>
           <td><?php echo "$tipo_servi";?>   -   <?php echo "$nome_servi";?> </td>
		</tr>
		<tr>
           <td><b>Número Remessa:</b></td>
           <td><?php echo "$n_remessa";?></td>
		</tr>
		<tr>
          <td><b>Data Remessa</b> :</b></td>
          <td><?php echo "$dt_remessa";?></td>
        </tr>

        <tr>
           <td><b>Código Destino:</b></td>
           <td><?php echo "$codigo_desti";?></td>
		</tr>
		<tr>
			<td><b>Nome Destino:</b></td>
			<td><?php echo "$nome_desti";?></td>
		</tr>
		<tr>
           <td><b>CEP Destino:</b></td>
           <td><?php echo "$cep_desti";?></td>
        </tr>
		<tr>
			<td><b>Rua Destino:</b></td>
			<td><?php echo "$rua_desti";?></td>
		</tr>
		<tr>
			<td><b>Número Destino:</b></td>
			<td><?php echo "$numero_desti";?></td>
		</tr>
		<tr>
			<td><b>Complemento:</b></td>
			<td><?php echo "$comple_desti";?></td>
		</tr>
		<tr>
			<td><b>Bairro Destino:</b></td>
			<td><?php echo "$bairro_desti";?></td>
		</tr>
		<tr>
			<td><b>Cidade Destino:</b></td>
			<td><?php echo "$cidade_desti";?></td>
		</tr>
        <tr>
           <td><b>Estado Destino: </b></td>
           <td><?php echo "$estado_desti";?></td>
        </tr>
		<tr>
          <td><INPUT type=button value="Consulta HAWB"
               onClick="window.open('consulta_remessa_por_hawb_tela.php','janela_1',
               'scrollbars=yes,resizable=yes,width=800,height=400');">
          </td>
		  <td colspan="2">
		     <div align="right">
			   <input name="exclui" type="submit" value="Excluir">
			 </div>
		  </td>
		</tr>
	</table>
  </form>
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
      <td background="img/blue.jpg" align="left" width="100%" height="45px" align="center"><font face="arial" size="1" color="white">Todos Direitos Reservados a NUNESTEC Tecnologia</font></td>
    </tr>
  </table>

</body>
</html>

