<?php
  session_start();

   //carrega variaveis com dados para acessar o banco de dados

  $base_d     =$_SESSION['base_d'];
  $banco_d    =$_SESSION['banco_d'];
  $usuario_d  =$_SESSION['usuario_d'];
  $senha_d    =$_SESSION['senha_d'];

  $matricula_m  =$_SESSION['matricula_m'];
  $programa='039';
  $_SESSION['programa_m']=$programa;


  $con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
  $res = mysql_select_db($banco_d) or die ("Banco de dados inexistente");

  $declara = "SELECT matricula,programa
  FROM permissoes
  WHERE ((matricula='$matricula_m') and (programa='$programa'))";

  $query = mysql_db_query($banco_d,$declara,$con) or die ("Não foi possivel acessar o banco");
  $achou = mysql_num_rows($query);

  If ($achou == 0) {
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
  function formatarCPF_CNPJ($campo, $formatado = true){
	    //retira formato
	    $codigoLimpo = ereg_replace("[' '-./ t]",'',$campo);
	    // pega o tamanho da string menos os digitos verificadores
	    $tamanho = (strlen($codigoLimpo) -2);
	    //verifica se o tamanho do código informado é válido
	    if ($tamanho != 9 && $tamanho != 12){
	        return false;
	    }

	    if ($formatado){
	        // seleciona a máscara para cpf ou cnpj
	        $mascara = ($tamanho == 9) ? '###.###.###-##' : '##.###.###/####-##';

	        $indice = -1;
	        for ($i=0; $i < strlen($mascara); $i++) {
	            if ($mascara[$i]=='#') $mascara[$i] = $codigoLimpo[++$indice];
	        }
	        //retorna o campo formatado
	        $retorno = $mascara;

	    }else{
	        //se não quer formatado, retorna o campo limpo
	        $retorno = $codigoLimpo;
	    }
	    return $retorno;
   }
   
   $foco=0;
   include ("campo_calendario.php");
   include ("pega_cep.php");
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
         if(campo.value.length == 24){
            cadastro_1.submit()
         }
         if(campo.value.length == 25){
            cadastro_1.submit()
         }
         if(campo.value.length == 26){
            cadastro_1.submit()
         }
         if(campo.value.length == 27){
            cadastro_1.submit()
         }
         if(campo.value.length == 28){
            cadastro_1.submit()
         }
         if(campo.value.length == 29){
            cadastro_1.submit()
         }
         if(campo.value.length == 30){
            cadastro_1.submit()
         }
       }
       
   <!-- FUNÇÃO PARA DESABILITAR O CRTL+J-->

   function retornoCodbar(evt, valor){
    <!--ENTER = 13 -->
    if (window.event){
       var tecla = window.event.keyCode;
       if(tecla==13){
         <!--alert('Código de barras: '+valor);-->
         window.event.returnValue = false;
       }
    }
    else{
       var tecla = (evt.which) ? evt.which : evt.keyCode;
       if(tecla==13){
          <!--alert('Código de barras: '+valor);-->
         evt.preventDefault();
       }
    }
   }

   function desabilitaCtrlJ(evt){
      //ctrl+j == true+106
      //ctrl+J == true+74
      if (window.event){ //IE
         var ctrl = event.ctrlKey;
         var tecla = window.event.keyCode;
         if((ctrl==true)&&((tecla==106)||(tecla==74))){
            window.event.returnValue = false;
         }
      }
      else{ //Firefox
         var ctrl = evt.ctrlKey;
         var tecla = (evt.which) ? evt.which : evt.keyCode;
         if((ctrl==true)&&((tecla==106)||(tecla==74))){
            evt.preventDefault();
         }
      }
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
   <form method="POST" name="cadastro_1" action="consulta_remessa_por_hawb.php" border="20">
       <table width="70%" border="1" cellpadding="5" cellspacing="0" bordercolor="#4169E1" align="center">

         <?php
              switch (get_post_action('mostra')) {

                 case 'mostra':
                     $n_hawb     =$_POST['n_hawb'];
                     $n_hawb     =intval($n_hawb);
                     
                     if ($n_hawb<>'') {
                     
                        //$_SESSION['codi_barra_m']   =$codi_barra;
                        
                        //Pega o registro na tabela remessa para mostrar

                        $resp_grava='';
                        $con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
                        $res = mysql_select_db($banco_d) or die ("Banco de dados inexistente");

                        $verifi="SELECT controle,codi_cli,escritorio,codigo_desti,nome_desti,cep_desti,
                        rua_desti,numero_desti,comple_desti,bairro_desti,cidade_desti,estado_desti,
                        dt_remessa,n_remessa,controle,tipo_servi,date_format(dt_remessa,'%d/%m/%Y'),
                        cod_barra,entregador,date_format(dt_entrega,'%d/%m/%Y'),hr_entrega,recebedor,
                        documento,parentesco,observacao,n_tentativas,qtdade,valor,date_format(dt_baixa,'%d/%m/%Y')
                        FROM remessa
                        WHERE n_hawb='$n_hawb'";
                        $query = mysql_db_query($banco_d,$verifi,$con) or die ("Não foi possivel acessar o banco PESQUISA");
                        $total = mysql_num_rows($query);

                        //Verifica se o movimento foi lançado

                        If ($total == 0 ) {
                           $n_hawb='';
                           ?>
                           <script language="javascript"> window.location.href=("consulta_remessa_por_hawb.php")
                               alert('HAWB não lançada.');
                           </script>
                           <?php
                        }
                        else {
                           for($ic=0; $ic<$total; $ic++){
                              $mostra = mysql_fetch_row($query);
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
                              $cod_barra      = $mostra[17];
                              $entregador     = $mostra[18];
                              $dt_entrega     = $mostra[19];
                              $hr_entrega     = $mostra[20];
                              $recebedor      = $mostra[21];
                              $documento      = $mostra[22];
                              $parentesco     = $mostra[23];
                              $observacao     = $mostra[24];
                              $n_tentativas   = $mostra[25];
                              $qtdade         = $mostra[26];
                              $valor          = $mostra[27];
                              $dt_baixa       = $mostra[28];
                           }
                           $valor   = number_format($valor, 2, ',', '.');
                           //Pega o nome do cliente.

                           $resultado = mysql_query ("SELECT nome
                           FROM cli_for
                           WHERE cnpj_cpf='$codi_cli'");
                           $total = mysql_num_rows($resultado);

                           for($i=0; $i<$total; $i++){
                              $dados = mysql_fetch_row($resultado);
                              $nome_cli       =$dados[0];
                           }

                           //Pega o nome do escritório.

                           $resultado = mysql_query ("SELECT nome
                           FROM regi_dep
                           WHERE codigo='$escritorio'");
                           $total = mysql_num_rows($resultado);

                           for($i=0; $i<$total; $i++){
                              $dados = mysql_fetch_row($resultado);
                              $nome_escri       =$dados[0];
                           }

                           //Pega o nome do serviço.

                           $resultado = mysql_query ("SELECT descri_se
                           FROM serv_ati
                           WHERE codigo_se='$tipo_servi'");
                           $total = mysql_num_rows($resultado);

                           for($i=0; $i<$total; $i++){
                              $dados = mysql_fetch_row($resultado);
                              $nome_servi       =$dados[0];
                           }
                           
                           //Pega o nome do entregador.

                           $resultado = mysql_query ("SELECT nome
                           FROM pessoa
                           WHERE matricula='$entregador'");
                           $total = mysql_num_rows($resultado);

                           for($i=0; $i<$total; $i++){
                              $dados = mysql_fetch_row($resultado);
                              $nome_entrega       =$dados[0];
                           }

                        }
                      }
                      else {
                         ?>
                           <script language="javascript"> window.location.href=("consulta_remessa_por_hawb.php")
                               alert('Digite um valor válido para HAWB!');
                           </script>
                         <?php
                      }
                      break;
                      default:
              }
           ?>
        <tr>
           <td><b>Número da HAWB:</b></td>
           <td><input type="text" name="n_hawb" class="campo" id="n_hawb" value ="<?php echo "$n_hawb";?>"><input name="mostra" type="submit" value="Mostra"></td></td>
		</tr>
		<?php if ($foco==0) { ?>
          <script language="JavaScript">
            <!-- Coloca foco no primeiro campo codigo de barras do formulário -->
            document.getElementById('n_hawb').focus()
          </script>
        <?php } ?>
        <tr>
           <td><b>Codigo Barras:</b></td>
           <td><?php echo "$cod_barra";?></td>
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
           <td><b>Entregue Por : </b></td>
           <td><?php echo "$entregador";?> - <?php echo "$nome_entrega";?></td>
        </tr>
        <tr>
           <td><b>Data da Entrega : </b></td>
           <td><?php echo "$dt_entrega";?></td>
        </tr>
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
           <td><?php echo "$parentesco";?></td>
        </tr>
        <tr>
           <td><b>Observação : </b></td>
           <td><?php echo "$observacao";?></td>
        </tr>
        <tr>
           <td><b>Tentativas de Entrega : </b></td>
           <td><?php echo "$n_tentativas";?></td>
        </tr>
        <tr>
           <td><b>Quantidade : </b></td>
           <td><?php echo "$qtdade";?></td>
        </tr>
        <tr>
           <td><b>Valor : </b></td>
           <td><?php echo "$valor";?></td>
        </tr>
        <tr>
           <td><b>Data da Baixa : </b></td>
           <td><?php echo "$dt_baixa";?></td>
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
      <td background="img/blue.jpg" align="left" width="100%" height="45px"><center><font face="arial" size="1" color="white">Todos Direitos Reservados a NUNESTEC Tecnologia</font></td>
    </tr>
  </table>

</body>
</html>

