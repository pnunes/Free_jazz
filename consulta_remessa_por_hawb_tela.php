<?php
   if ( session_status() !== PHP_SESSION_ACTIVE ) {
       session_start();
   }

   //carrega variaveis com dados para acessar o banco de dados

   Include('conexao_free.php');
   mysqli_set_charset($con,'UTF8');

  //verifica se o usuário esta habilitado para usar a rotina
  
  $matricula_m  =$_SESSION['matricula_m'];
  $programa='048';
  $_SESSION['programa_m']=$programa;
  
  $confere = "SELECT matricula,programa
  FROM permissoes
  WHERE ((matricula='$matricula_m') and (programa='$programa'))";

  $query = mysqli_query($con,$confere) or die ("Não foi possivel acessar o banco");
  $achou = mysqli_num_rows($query);

  If ($achou == 0 ) {
       ?>
          <script language="javascript"> window.location.href=("entrada.php")
            alert('Você não está autorizado a acessar esta rotina.');
          </script>
       <?php
  }
  else {
	   $codi_barra      ='';
	   $codi_cli        ='';
	   $escritorio      ='';
	   $codigo_desti    ='';
	   $nome_desti      ='';
	   $cep_desti       ='';
	   $rua_desti       ='';
	   $numero_desti    ='';
	   $comple_desti    ='';
	   $bairro_desti    ='';
	   $cidade_desti    ='';
	   $estado_desti    ='';
	   $dt_remessa      ='';
	   $n_remessa       ='';
	   $tipo_servi      ='';
	   $dt_lista        ='';
	   $entregador      ='';
	   $dt_entrega      ='';
	   $hr_entrega      ='';
	   $recebedor       ='';
	   $documento       ='';
	   $parentesco      ='';
	   $observacao      ='';
	   $n_tentativas    ='';
	   $qtdade          ='';
	   $valor           ='';
	   $dt_baixa        ='';
	   $dt_envio        ='';
	   $n_hawb          ='';
	   $volta_lista     ='';
	   $reentrega       ='';
	   $remessa_envio   ='';
	   $cnpj_desti      ='';
	   $nome_cli        ='';
	   $nome_escri      ='';
	   $nome_servi      ='';
	   $nome_entrega    ='';
	   $descricao_pare  ='';
  }

  function get_post_action($name) {
    $params = func_get_args();
    foreach ($params as $name) {
        if (isset($_POST[$name])) {
            return $name;
        }
    }
  }
  $resp_grava ='';
?>
<html>
  <title>consulta_remessa_por_hawb_tela.php</title>
  <head>
    <script language="JavaScript">
      function salva(campo){
            cadastro.submit()
      }
    </script>
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
    <body onkeydown="desabilitaCtrlJ(event)" topmargin="0" leftmargin="0" rightmargin="0" bottommargin="0" marginheight="0" marginwidth="0" bgcolor="#FFFFFF">
     <table border="0" width="100%" bgcolor="#000000" cellspacing="0" cellpadding="0">
      <tr>
        <td width="20%" height="100" background="img/topleft.jpg"></td>
         <td width="658" height="110"><img border="0" src="img/cabecalho_free_jazz.jpg" width="890" height="115" border="0"></td>
        <td width="15%" height="110">
        <p align="right"><img border="0" src="img/topright.jpg" width="160" height="110" border="0"></td>
     </tr>
    </table>
    <table border="0" width="100%" cellspacing="0" cellpadding="0" background="img/blue.jpg">
     <tr>
       <td width="50%">
         <p align="left"><font face="Arial" size="2" color="#FFFFFF"><b>Sistema de Gerenciamento da Logística de Encomendas</b></font></td>
       <td width="50%">
         <p align="right"><font face="Arial" size="2" color="#FFFFFF"><b>Consulta POD</b></font></td>
     </tr>
   </table>
   <table width="100%" border="0" cellspacing="0" cellpadding="0">
       <tr>
         <td colspan="1" color="white" align="right" width="45%" height="70"><a href="entrada.php"><img src="img/porta.gif" border="none"></td>
       </tr>
   </table>
   <form method="POST" name="cadastro" action="consulta_remessa_por_hawb_tela.php" border="20">
       <table width="80%" border="1" cellpadding="3" cellspacing="0" bordercolor="#4169E1" align="center">

         <?php
              switch (get_post_action('mostra')) {

                 case 'mostra':
                     $n_hawb     =$_POST['n_hawb'];
                     
                     if ($n_hawb<>'') {
                     
                       $_SESSION['n_hawb_m']   =$n_hawb;
                        
                       //Pega o registro na tabela remessa para mostrar

                       $resp_grava='';

                       $verifi="SELECT controle,codi_cli,escritorio,codigo_desti,nome_desti,cep_desti,
                       rua_desti,numero_desti,comple_desti,bairro_desti,cidade_desti,estado_desti,
                       date_format(dt_remessa,'%d/%m/%Y'),n_remessa,co_servico,date_format(dt_lista,'%d/%m/%Y'),
                       entregador,date_format(dt_entrega,'%d/%m/%Y'),hr_entrega,recebedor,
                       documento,parentesco,observacao,n_tentativas,qtdade,valor,
                       date_format(dt_baixa,'%d/%m/%Y'),date_format(dt_envio,'%d/%m/%Y'),n_hawb,
                       volta_lista,reentrega,remessa_envio,cnpj_desti
                       FROM remessa
                       WHERE n_hawb='$n_hawb'";
                       $query = mysqli_query($con,$verifi) or die ("Não foi possivel acessar o banco");
                       $total = mysqli_num_rows($query);

                       //Verifica se a hawb foi lançada

                       If ($total > 0 ) {
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
                               $tipo_servi     = $mostra[14];
                               $dt_lista       = $mostra[15];
                               $entregador     = $mostra[16];
                               $dt_entrega     = $mostra[17];
                               $hr_entrega     = $mostra[18];
                               $recebedor      = $mostra[19];
                               $documento      = $mostra[20];
                               $parentesco     = $mostra[21];
                               $observacao     = $mostra[22];
                               $n_tentativas   = $mostra[23];
                               $qtdade         = $mostra[24];
                               $valor          = $mostra[25];
                               $dt_baixa       = $mostra[26];
                               $dt_envio       = $mostra[27];
                               $n_hawb         = $mostra[28];
                               $volta_lista    = $mostra[29];
                               $reentrega      = $mostra[30];
                               $remessa_envio  = $mostra[31];
                               $cnpj_desti     = $mostra[32];
                            }
                       }
                       else {
                             $verifi="SELECT controle,codi_cli,escritorio,codigo_desti,nome_desti,cep_desti,
                             rua_desti,numero_desti,comple_desti,bairro_desti,cidade_desti,estado_desti,
                             date_format(dt_remessa,'%d/%m/%Y'),n_remessa,co_servico,date_format(dt_lista,'%d/%m/%Y'),
                             entregador,date_format(dt_entrega,'%d/%m/%Y'),hr_entrega,recebedor,
                             documento,parentesco,observacao,n_tentativas,qtdade,valor,
                             date_format(dt_baixa,'%d/%m/%Y'),date_format(dt_envio,'%d/%m/%Y'),n_hawb,
                             volta_lista,reentrega,remessa_envio,cnpj_desti
                             FROM remessa_morto
                             WHERE n_hawb='$n_hawb'";
                             $query = mysqli_query($con,$verifi) or die ("Não foi possivel acessar o banco");
                             $total = mysqli_num_rows($query);
                        
                             If ($total > 0 ) {
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
                                   $tipo_servi     = $mostra[14];
                                   $dt_lista       = $mostra[15];
                                   $entregador     = $mostra[16];
                                   $dt_entrega     = $mostra[17];
                                   $hr_entrega     = $mostra[18];
                                   $recebedor      = $mostra[19];
                                   $documento      = $mostra[20];
                                   $parentesco     = $mostra[21];
                                   $observacao     = $mostra[22];
                                   $n_tentativas   = $mostra[23];
                                   $qtdade         = $mostra[24];
                                   $valor          = $mostra[25];
                                   $dt_baixa       = $mostra[26];
                                   $dt_envio       = $mostra[27];
                                   $n_hawb         = $mostra[28];
                                   $volta_lista    = $mostra[29];
                                   $reentrega      = $mostra[30];
                                   $remessa_envio  = $mostra[31];
                                   $cnpj_desti     = $mostra[32];
                                }
                             }
                             else {
                                  $n_hawb='';
                                  ?>
                                  <script language="javascript"> window.location.href=("consulta_remessa_por_hawb_tela.php")
                                      alert('HAWB não lançada.');
                                  </script>
                                  <?php
                             }
                       }
                        
                       $valor   = number_format($valor, 2, ',', '.');
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

                       //Pega o nome do entregador.

                       $resultado = mysqli_query ($con,"SELECT nome
                       FROM cli_for
                       WHERE cnpj_cpf='$entregador'");
                       $total = mysqli_num_rows($resultado);

                       for($i=0; $i<$total; $i++){
                          $dados = mysqli_fetch_row($resultado);
                          $nome_entrega       =$dados[0];
                       }

                       //Pega o descricao do parentesco.

                       $resultado = mysqli_query ($con,"SELECT descricao
                       FROM parentesco
                       WHERE codigo='$parentesco'");
                       $total = mysqli_num_rows($resultado);

                       for($i=0; $i<$total; $i++){
                          $dados = mysqli_fetch_row($resultado);
                          $descricao_pare       =$dados[0];
                       }
                     }
                 break;
                 default:
              }
			  If(isset($_POST['cod_barra'])) {
				  $codi_barra     =$_POST['cod_barra'];
				  if ($codi_barra<>'') {

					  $_SESSION['codi_barra_m']   =$codi_barra;

					  //Pega o registro na tabela remessa para mostrar

					  $resp_grava='';

					  $verifi="SELECT controle,codi_cli,escritorio,codigo_desti,nome_desti,cep_desti,
					  rua_desti,numero_desti,comple_desti,bairro_desti,cidade_desti,estado_desti,
					  date_format(dt_remessa,'%d/%m/%Y'),n_remessa,co_servico,date_format(dt_lista,'%d/%m/%Y'),
					  cod_barra,entregador,date_format(dt_entrega,'%d/%m/%Y'),hr_entrega,recebedor,
					  documento,parentesco,observacao,n_tentativas,qtdade,valor,
					  date_format(dt_baixa,'%d/%m/%Y'),date_format(dt_envio,'%d/%m/%Y'),n_hawb,
					  volta_lista,reentrega,remessa_envio,cnpj_desti
					  FROM remessa
					  WHERE cod_barra='$codi_barra'";
					  $query = mysqli_query($con,$verifi) or die ("Não foi possivel acessar o banco");
					  $total = mysqli_num_rows($query);

					  //Verifica se o movimento foi lançado

					  If ($total > 0 ) {
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
							   $tipo_servi     = $mostra[14];
							   $dt_lista       = $mostra[15];
							   $cod_barra      = $mostra[16];
							   $entregador     = $mostra[17];
							   $dt_entrega     = $mostra[18];
							   $hr_entrega     = $mostra[19];
							   $recebedor      = $mostra[20];
							   $documento      = $mostra[21];
							   $parentesco     = $mostra[22];
							   $observacao     = $mostra[23];
							   $n_tentativas   = $mostra[24];
							   $qtdade         = $mostra[25];
							   $valor          = $mostra[26];
							   $dt_baixa       = $mostra[27];
							   $dt_envio       = $mostra[28];
							   $n_hawb         = $mostra[29];
							   $volta_lista    = $mostra[30];
							   $reentrega      = $mostra[31];
							   $remessa_envio  = $mostra[32];
							   $cnpj_desti     = $mostra[33];
						  }
					  }
					  else {
						  $verifi="SELECT controle,codi_cli,escritorio,codigo_desti,nome_desti,cep_desti,
						  rua_desti,numero_desti,comple_desti,bairro_desti,cidade_desti,estado_desti,
						  date_format(dt_remessa,'%d/%m/%Y'),n_remessa,co_servico,date_format(dt_lista,'%d/%m/%Y'),
						  cod_barra,entregador,date_format(dt_entrega,'%d/%m/%Y'),hr_entrega,recebedor,
						  documento,parentesco,observacao,n_tentativas,qtdade,valor,
						  date_format(dt_baixa,'%d/%m/%Y'),date_format(dt_envio,'%d/%m/%Y'),n_hawb,
						  volta_lista,reentrega,remessa_envio,cnpj_desti
						  FROM remessa
						  WHERE cod_barra='$codi_barra'";
						  $query = mysqli_query($con,$verifi) or die ("Não foi possivel acessar o banco");
						  $total = mysqli_num_rows($query);
					  
						  If ($total > 0 ) {
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
								 $tipo_servi     = $mostra[14];
								 $dt_lista       = $mostra[15];
								 $cod_barra      = $mostra[16];
								 $entregador     = $mostra[17];
								 $dt_entrega     = $mostra[18];
								 $hr_entrega     = $mostra[19];
								 $recebedor      = $mostra[20];
								 $documento      = $mostra[21];
								 $parentesco     = $mostra[22];
								 $observacao     = $mostra[23];
								 $n_tentativas   = $mostra[24];
								 $qtdade         = $mostra[25];
								 $valor          = $mostra[26];
								 $dt_baixa       = $mostra[27];
								 $dt_envio       = $mostra[28];
								 $n_hawb         = $mostra[29];
								 $volta_lista    = $mostra[30];
								 $reentrega      = $mostra[31];
								 $remessa_envio  = $mostra[32];
								 $cnpj_desti     = $mostra[33];
							  }
						  }
						  else {
							  $codi_barra='';
							  ?>
							  <script language="javascript"> window.location.href=("consulta_remessa_por_hawb_tela.php")
								  alert('HAWB inexistente.');
							  </script>
							  <?php
						  }
					  }

					  $_SESSION['n_hawb_m']   =$n_hawb;

					  $valor   = number_format($valor, 2, ',', '.');
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

					   //Pega o nome do entregador.

					   $resultado = mysqli_query ($con,"SELECT nome
					   FROM pessoa
					   WHERE matricula='$entregador'");
					   $total = mysqli_num_rows($resultado);

					   for($i=0; $i<$total; $i++){
						   $dados = mysqli_fetch_row($resultado);
						   $nome_entrega       =$dados[0];
					   }

					   //Pega o descricao do parentesco.

					   $resultado = mysqli_query ($con,"SELECT descricao
					   FROM parentesco
					   WHERE codigo='$parentesco'");
					   $total = mysqli_num_rows($resultado);

					   for($i=0; $i<$total; $i++){
						   $dados = mysqli_fetch_row($resultado);
						   $descricao_pare       =$dados[0];
					   }
				  }
		      }		  
       ?>
       <tr>
           <td align="center" colspan="2"><b>Codigo Barras:</b>
           <input type="text" name="cod_barra" id="cod_barra" value ="<?php echo "$codi_barra";?>" size="60" maxlength="60" onChange="salva(this)"></td>
           <!--<input name="mostra" type="submit" value="Mostra"></td>-->
       </tr>
         <!-- Coloca foco no primeiro campo codigo de barras do formulário -->
       <script language="JavaScript">
           document.getElementById('cod_barra').focus()
       </script>
        <tr>
           <td><b>Número da HAWB:</b></td>
           <td><input type="text" name="n_hawb" class="campo" id="n_hawb" size="30" maxlength="30" value ="<?php echo "$n_hawb";?>"><input name="mostra" type="submit" value="Mostra"></td></td>
		</tr>
	    <tr><td colspan="2" align="center"><font color="red"><b>RECEBIMENTO DA REMESSA</b></font></td>
        <tr>
           <td><b>Cliente :</b></td>
           <td><?php echo "$codi_cli";?> - <?php echo "$nome_cli";?></td>
		</tr>
		<tr>
           <td><b>Escritório :</b></td>
           <td><?php echo "$escritorio";?> - <?php echo "$nome_escri";?></td>
		</tr>
		<tr>
           <td><b>Serviçoo :</b></td>
           <td><?php echo "$tipo_servi";?> - <?php echo "$nome_servi";?> </td>
		</tr>
		<tr>
           <td><b>Número Remessa:</b></td>
           <td><?php echo "$n_remessa";?></td>
		</tr>
		<tr>
          <td><b>Data Remessa</b> :</b></td>
          <td><?php echo "$dt_remessa";?></td>
        </tr>
        <tr><td colspan="2" align="center"><font color="red"><b>DADOS DO DESTINATÓRIO</b></font></td>
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
           <td><b>CNPJ Destino: </b></td>
           <td><?php echo "$cnpj_desti";?></td>
        </tr>
        <tr><td colspan="2" align="center"><font color="red"><b>ROTA DE ENTREGA</b></font></td></tr>
        <tr>
           <td><b>Saída Para Entrega : </b></td>
           <td><?php echo "$dt_lista";?></td>
        </tr>
        <tr><td colspan="2" align="center"><font color="red"><b>DADOS DA ENTREGA</b></font></td></tr>
        <tr>
           <td><b>Entregador : </b></td>
           <td><?php echo "$entregador";?> - <?php echo "$nome_entrega";?></td>
        </tr>
        <tr>
           <td><b>Data da Entrega : </b></td>
           <td><?php echo "$dt_entrega";?></td>
        </tr>
        <?php
            $v_imagem=0;
            $path ='hawbs/';
            $exte ='.gif';
            if(file_exists("$path$n_hawb$exte")) {
               ?>
               <tr>
                 <td colspan="2" align="center"><font color="red" size="3"><b>MAIS DETALHES DA ENTREGA VER IMAGEM DA HAWB ABAIXO</b></font><td>
               </tr>
               <tr>
                 <td><b>Observação : </b></td>
                 <td><?php echo "$observacao";?></td>
               </tr>
              <tr>
                 <td><b>Tentativas de Entrega : </b></td>
                 <td><?php echo "$n_tentativas";?></td>
              </tr>
                 <tr><td colspan="2" align="center"><font color="red"><b>CONCLUSÃO DO SERVIÇO</b></font></td>
              <tr>
                 <td><b>Data da Baixa após entrega : </b></td>
                 <td><?php echo "$dt_baixa";?></td>
              </tr>
              <tr>
                 <td><b>Retorno HAWB  ao Cliente: </b></td>
                 <td><?php echo "$dt_envio";?></td>
              </tr>
              <?php
               echo "<td colspan=\"2\" align=\"center\"><img border=\"0\" src=\"$path$n_hawb$exte\" width=\"800\" height=\"350\"><td>";
               $v_imagem=1;
            }
            else {
              $path ='hawbs/';
              $exte ='.jpg';
              ?>
              <tr>
                 <td><b>Hora da Entrega : </b></td>
                 <td><?php echo "$hr_entrega";?></td>
              </tr>
              <tr>
                 <td><b>Recebido Por : </b></td>
                 <td><?php echo "$recebedor";?></td>
              </tr>
              <tr>
                 <td><b>Identidade Recebedor : </b></td>
                 <td><?php echo "$documento";?></td>
              </tr>
              <tr>
                 <td><b>Parentesco : </b></td>
                 <td><?php echo "$parentesco";?> - <?php echo "$descricao_pare";?></td>
              </tr>
              <tr>
                 <td><b>Tentativas de Entrega : </b></td>
                 <td><?php echo "$n_tentativas";?></td>
              </tr>
              <tr><td colspan="2" align="center"><font color="red"><b>CONCLUSÃO DO SERVIÇO</b></font></td>
              <tr>
                 <td><b>Data da Baixa após entrega : </b></td>
                 <td><?php echo "$dt_baixa";?></td>
              </tr>
              <tr>
                 <td><b>Retorno HAWB  ao Cliente: </b></td>
                 <td><?php echo "$dt_envio";?></td>
              </tr>
              <tr>
                 <td><b>Remessa Envio Origem: </b></td>
                 <td><?php echo "$remessa_envio";?></td>
              </tr>
              <tr>
              <?php
              if(file_exists("$path$n_hawb$exte")) {
                  echo "<td colspan=\"2\" align=\"center\"><img border=\"0\" src=\"$path$n_hawb$exte\" width=\"800\" height=\"350\"><td>";
                  $v_imagem=1;
              }
              if ($v_imagem==0) {
                     echo "<td colspan=\"2\" align=\"center\"><font color=\"red\" size=\"4\"><b>HAWB NÃO DIGITALIZADA</b></font><td>";
              }
            }
         ?>
        </tr>
	</table>
  </form>
  </div>
  <?php
     //Mostra historico da hawb consultada
	   if(isset($_SESSION['n_hawb_m'])) {
           $n_hawb   =$_SESSION['n_hawb_m'];
	   }
	   else {
		   $n_hawb   ='';
	   } 
	   ?>
       <table width="80%" border="1" cellpadding="5" cellspacing="0" bordercolor="#4169E1" align="center">
         <tr>
           <td colspan="8" align="center"><font face="arial" size="3"><b>HISTÓRICO DA HAWB</b></font></td>
         </tr>
         <tr>
           <td width="10%" align="center"><b>DATA</b></td>
           <td width="90%" align="center"><b>OCORRÊNCIA</b></td>
         </tr>
        <?php
        
         $resultado = mysqli_query ($con,"SELECT date_format(dt_evento,'%d/%m/%Y'),ocorrencia FROM controle_reentrega
         WHERE ((n_hawb='$n_hawb') and (n_hawb<>''))
         ORDER BY ordem");
         $total = mysqli_num_rows($resultado);
         if ($total>0) {
            $ni=0;
            for($i=0; $i<$total; $i++){
               $dados = mysqli_fetch_row($resultado);
               $dt_evento         =$dados[0];
               $ocorrencia        =$dados[1];
               $ni=$i+1;
               echo "<tr>";
                 echo "<td width=\"10%\" align=\"left\"><font size=\"2\" face=\"arial\">$dt_evento</font></td>";
                 echo "<td width=\"90%\" align=\"left\"><font size=\"2\" face=\"arial\">$ocorrencia</font></td>";
               echo "</tr>";
			}
         }

  ?>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <td color="white" align="center" width="900" height="45" colspan="4" ><?php echo "$resp_grava";?></td>
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

