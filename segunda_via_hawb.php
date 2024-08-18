<?php
  if ( session_status() !== PHP_SESSION_ACTIVE ) {
    session_start();
  }

  Include('conexao_free.php');
  mysqli_set_charset($con,'UTF8');
  
  $matricula_m  =$_SESSION['matricula_m'];
  $programa='077';
  $_SESSION['programa_m']=$programa;

  $declara = "SELECT matricula,programa
  FROM permissoes
  WHERE ((matricula='$matricula_m') and (programa='$programa'))";

  $query = mysqli_query($con,$declara) or die ("Não foi possivel acessar o banco");
  $achou = mysqli_num_rows($query);

  If ($achou == 0 ) {
       ?>
          <script language="javascript"> window.location.href=("entrada.php")
            alert('Você não está autorizado a acessar esta rotina.');
          </script>
       <?php
  }
  else {
	   $codigo_desti   ='';
	   $nome_desti     ='';
	   $rua_desti      ='';
	   $numero_desti   ='';
	   $comple_desti   ='';
	   $bairro_desti   ='';
	   $cidade_desti   ='';
	   $estado_desti   ='';
	   $cep_desti      ='';
	   $cod_barra      ='';
	   $n_hawb         ='';
	   $cnpj_desti     ='';
       $codi_cli       ='';
       $nome_cli       ='';
       $escritorio     ='';
       $dt_remessa     ='';
       $nome_servi     ='';
       $co_servico     ='';
       $nome_escri     ='';
       $entregador     ='';
	   $parentesco     ='';
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
  <title>segunda_via_hawb.php</title>
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
         <p align="right"><font face="Arial" size="2" color="#FFFFFF"><b>Gera e imprime a Segunda de HAWB</b></font></td>
     </tr>
   </table>
   <table width="100%" border="0" cellspacing="0" cellpadding="0">
       <tr>
         <td colspan="1" color="white" align="right" width="45%" height="70"><a href="entrada.php"><img src="img/porta.gif" border="none"></td>
       </tr>
   </table>
   <form method="POST" name="cadastro" action="segunda_via_hawb.php" border="20">
       <table width="80%" border="1" cellpadding="3" cellspacing="0" bordercolor="#4169E1" align="center">

         <?php
              switch (get_post_action('mostra')) {

                 case 'mostra':
                     $n_hawb     =$_POST['n_hawb'];
                     //$n_hawb     =intval($n_hawb);
                     
                     if ($n_hawb<>'') {
                     
                        //$_SESSION['codi_barra_m']   =$codi_barra;
                        
                        $_SESSION['n_hawb_m']   =$n_hawb;
                        
                        //Pega o registro na tabela remessa para mostrar

                        $resp_grava='';

                        $verifi="SELECT controle,codi_cli,escritorio,codigo_desti,nome_desti,cep_desti,
                        rua_desti,numero_desti,comple_desti,bairro_desti,cidade_desti,estado_desti,
                        date_format(dt_remessa,'%d/%m/%Y'),co_servico,cod_barra,n_hawb,cnpj_desti
                        FROM remessa
                        WHERE n_hawb='$n_hawb'";
                        $query = mysqli_query($con,$verifi) or die ("Não foi possivel acessar o banco");
                        $total = mysqli_num_rows($query);

                        //Verifica se o movimento foi lançado

                        If ($total == 0 ) {
                           $n_hawb='';
                           ?>
                           <script language="javascript"> window.location.href=("consulta_remessa_por_hawb_tela.php")
                               alert('HAWB não lançada.');
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
                               $co_servico     = $mostra[13];
                               $cod_barra      = $mostra[14];
                               $n_hawb         = $mostra[15];
                               $cnpj_desti     = $mostra[16];
                           }

                           ///CARREGA VARIAVEIS NA MEMÓRIA PARA IMPRIMIR HAWB

                           $_SESSION['nome_desti_h']       =$nome_desti;
                           $_SESSION['rua_desti_h']        =$rua_desti;
                           $_SESSION['numero_desti_h']     =$numero_desti;
                           $_SESSION['comple_desti_h']     =$comple_desti;
                           $_SESSION['bairro_desti_h']     =$bairro_desti;
                           $_SESSION['cidade_desti_h']     =$cidade_desti;
                           $_SESSION['estado_desti_h']     =$estado_desti;
                           $_SESSION['cep_desti_h']        =$cep_desti;
                           $_SESSION['cod_barra_h']        =$cod_barra;
                           $_SESSION['n_hawb_h']           =$n_hawb;
                           $_SESSION['cnpj_desti_h']       =$cnpj_desti;
                           
                           $resultado = mysqli_query ($con,"SELECT nome FROM cli_for
                           WHERE cnpj_cpf='$codi_cli'");
                           $total = mysqli_num_rows($resultado);
                           for($i=0; $i<$total; $i++){
                              $dados = mysqli_fetch_row($resultado);
                              $nome_cli       =$dados[0];
                           }
                           $_SESSION['nome_cli_h']    =$nome_cli;
                           
                           //Pega o nome do escritório.

                           $resultado = mysqli_query ($con,"SELECT nome
                           FROM regi_dep
                           WHERE codigo='$escritorio'");
                           $total = mysqli_num_rows($resultado);

                           for($i=0; $i<$total; $i++){
                              $dados = mysqli_fetch_row($resultado);
                              $nome_escri       =$dados[0];
                           }
                           
                           $_SESSION['escritorio_h']  =$nome_escri;
                           
                           //Pega o nome do serviço.

                           $resultado = mysqli_query ($con,"SELECT descri_se
                           FROM serv_ati
                           WHERE codigo_se='$co_servico'");
                           $total = mysqli_num_rows($resultado);

                           for($i=0; $i<$total; $i++){
                              $dados = mysqli_fetch_row($resultado);
                              $nome_servi       =$dados[0];
                           }
                           
                           $_SESSION['servico_h']  =$nome_servi;
                           
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
                 break;
                 default:
          }
           ?>
        <tr>
           <td><b>Número da HAWB:</b></td>
           <td><input type="text" name="n_hawb" class="campo" id="n_hawb" size="30" maxlength="30" value ="<?php echo "$n_hawb";?>"><input name="mostra" type="submit" value="Mostra"></td></td>
		</tr>
        <tr>
           <td><b>Número Codigo Barra :</b></td>
           <td><?php echo "$cod_barra";?> </td>
		</tr>
        <tr>
           <td><b>Cliente :</b></td>
           <td><?php echo "$codi_cli";?> - <?php echo "$nome_cli";?></td>
		</tr>
		<tr>
           <td><b>Escritúrio :</b></td>
           <td><?php echo "$escritorio";?> - <?php echo "$nome_escri";?></td>
		</tr>
		<tr>
           <td><b>Serviço :</b></td>
           <td><?php echo "$co_servico";?> - <?php echo "$nome_servi";?> </td>
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
           <td><b>CNPJ Destino: </b></td>
           <td><?php echo "$cnpj_desti";?></td>
        </tr>
        <tr>
           <td><INPUT type=button value="Imprime Segunda Via"
               onClick="window.open('gera_segunda_via_hawb.php','janela_1',
               'scrollbars=yes,resizable=yes,width=800,height=600');">
            </td>
        </tr>
	</table>
  </form>
  </div>
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

