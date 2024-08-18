<?php
  if ( session_status() !== PHP_SESSION_ACTIVE ) {
    session_start();
  }

   //carrega variaveis com dados para acessar o banco de dados
 
  Include('conexao_free.php');
  mysqli_set_charset($con,'UTF8');
   
  //verifica se o usuário esta habilitado para usar a rotina
 
  $matricula_m  =$_SESSION['matricula_m'];
  $programa='032';
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
  
   include ("campo_calendario.php");
   
   ////////////////////////////////////LIMPA AS VARIAVEIS FIXAS AOENTRAR NA ROTINA /////////////////////////////
   
   if ($_SESSION['entrada_m']=='S')  {

      $_SESSION['hawb_lancada_m'] = 'N';
      
      $_SESSION['n_remessa_m']    ='';
	  $_SESSION['escritorio_m']   ='';
	  $_SESSION['codi_cli_m']     ='';
	  $_SESSION['codi_servi_m']   =''; 
	  $_SESSION['dt_remessa_m']   ='';	  

	  $_SESSION['entrada_m']='N';
	  
      $n_remessa        ='';
      $escritorio       ='';
      $codi_cli         ='';
      $codi_servi       =''; 
      $dt_remessa       = date('d/m/Y');
	  $codi_barra       ='';
	  $n_hawb           ='';
	  $nome_desti       ='';
	  $codigo_desti     ='';
	  $cnpj_desti       ='';
	  $cep              ='';
	  $classe_cep       ='';
	  $rua_desti        ='';
	  $numero_desti     ='';
	  $comple_desti     ='';
	  $bairro_desti     ='';
	  $cidade_desti     ='';
	  $estado_desti     ='';
	  $qtdade           ='';
	  $valor            ='';
	  
	  $resp_grava       ='';
   }
   
   if ($_SESSION['hawb_lancada_m']=='S')  {
	   
	   $_SESSION['hawb_lancada_m'] ='N';
	   
	   $codi_barra       ='';
	   $n_hawb           ='';
	   $nome_desti       ='';
	   $codigo_desti     ='';
	   $cnpj_desti       ='';
	   $cep              ='';
	   $classe_cep       ='';
	   $rua_desti        ='';
	   $numero_desti     ='';
	   $comple_desti     ='';
	   $bairro_desti     ='';
	   $cidade_desti     ='';
	   $estado_desti     ='';
	   $qtdade           ='';
	   $valor            ='';
	  
	   $resp_grava       ='';   
   }
 ?>
 
 <html>
  <title>lanca_remessa_com_leitora.php</title>
  <head>
  <script type="text/javascript" src="jquery-autocomplete/lib/jquery.js"></script>
  <script type="text/javascript" src="jquery-autocomplete/lib/jquery.bgiframe.min.js"></script>
  <script type="text/javascript" src="jquery-autocomplete/lib/jquery.ajaxQueue.js"></script>
  <script type="text/javascript" src="jquery-autocomplete/lib/thickbox-compressed.js"></script>
  <script type="text/javascript" src="jquery-autocomplete/jquery.autocomplete.js"></script>
  <!--css -->
  <link rel="stylesheet" type="text/css" href="jquery-autocomplete/jquery.autocomplete.css"/>
  <link rel="stylesheet" type="text/css" href="jquery-autocomplete/lib/thickbox.css"/>
  <script type="text/javascript">

    <!-- FUNÇÃO QUE ATIVA CODIGO DE BARRAS-->
    
    function salva(campo){
       cadastro.submit()
    }

  <!-- FUNÇÃO PROCURA DESTINO POR NOME-->
  $(document).ready(function(){
		$("#nome_desti").autocomplete("completar.php", {
			width:350,
			selectFirst: false
		});
	});
	
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
        else {
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
        if (window.event) { //IE
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
   
  <!--Cabeçalho da página -->
   
  <body onkeydown="desabilitaCtrlJ(event)" topmargin="0" leftmargin="0" rightmargin="0" bottommargin="0" marginheight="0" marginwidth="0" bgcolor="#FFFFFF">
    <form method="POST" name="cadastro" action="lanca_remessa_com_leitora.php" border="20" align="center">
    <div id="geral" align="center">
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
		    <td width="50%"><p align="left"><font face="Arial" size="2" color="#FFFFFF"><b>Sistema de Gerenciamento da Logística de Encomendas</b></font></td>
		    <td width="50%"><p align="right"><font face="Arial" size="2" color="#FFFFFF"><b>Lança Remessa Com Leitora</b></font></td> 
		  </tr>
	   </table>
	   <table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
			 <td colspan="1" align="left" width="45%"><INPUT type=button size="3" value="Ajuda"onClick="window.open('mostra_ajuda.php','janela_1',  
				   'scrollbars=yes,resizable=yes,width=400,height=700');" style="width:100;height:30;color=red;font: bold 16px Arial;">
			 </td>
			 <td colspan="1" color="white" align="right" width="45%" height="70"><a href="entrada.php"><img src="img/porta.gif" border="none"></td>
		  </tr>
	   </table>
	 
	   <!-- controla as opções feitas na pagina-->
	   
	   <table width="80%" heigth="300">
	   
	   <?php
  
				///////Carrega os campos com os dados lidos do codigo de barras///////
	  
				if(isset($_POST['cod_barra'])){			 
				 $escritorio      =$_POST['escritorio'];			
				 $codi_barra     =$_POST['cod_barra'];
			
			    if ($codi_barra <> '') {
					
					//Verifica se existe POD com o mesmo numero

					$localiza = "SELECT cod_barra
					FROM remessa
					WHERE cod_barra='$codi_barra'";

					$query = mysqli_query($con,$localiza) or die ("Não foi possivel acessar o banco 1");
					$achou = mysqli_num_rows($query);

					If ($achou > 0 ) {
					   $_SESSION['hawb_lancada_m'] = 'S';
					   ?>
					   <script language="javascript"> window.location.href=("lanca_remessa_com_leitora.php")
						  alert('HAWB já foi lançada. Verifique.');
					   </script>
					   <?php
					}
					else {
				 
					   //Pega o codigo do destinatário e o numero da hawb a partir do codigo de barras

					   if(strlen($codi_barra) == 26){
						  $codigo_desti          =Substr($codi_barra,0,8);
						  $codigo_desti          =intval($codigo_desti);
						  $n_hawb                =Substr($codi_barra,17,10);
						  $n_hawb                =intval($n_hawb);
					   
					   $_SESSION['n_hawb_m']  =$n_hawb;
					   
					   //Pega os dados do destino a parir do código extraido do codigo de barras
					   
					   $resp_grava='';

					   $verifi="SELECT codigo_desti,nome_desti,cep_desti,rua_desti,numero_desti,
					   comple_desti,bairro_desti,cidade_desti,estado_desti,classe_cep,documento
					   FROM destino WHERE codigo_desti='$codigo_desti'";
					   $query = mysqli_query($con,$verifi) or die ("Não foi possivel acessar o banco - destino -1");
					   $total = mysqli_num_rows($query);
                       if($total > 0) {
						   for($ic=0; $ic<$total; $ic++){
							  $mostra = mysqli_fetch_row($query);
							  $codigo_desti   = $mostra[0];
							  $nome_desti     = $mostra[1];
							  $cep            = $mostra[2];
							  $rua_desti      = $mostra[3];
							  $numero_desti   = $mostra[4];
							  $comple_desti   = $mostra[5];
							  $bairro_desti   = $mostra[6];
							  $cidade_desti   = $mostra[7];
							  $estado_desti   = $mostra[8];
							  $classe_cep     = $mostra[9];
							  $cnpj_desti     = $mostra[10];
						 }
					   }else {
						  $nome_desti     = '';
						  $cep            = '';
						  $rua_desti      = '';
						  $numero_desti   = '';
						  $comple_desti   = '';
						  $bairro_desti   = '';
						  $cidade_desti   = '';
						  $estado_desti   = '';
						  $classe_cep     = '';
						  $cnpj_desti     = '';  
					   }
					}
				 }
				 $qtdade          =$_POST['qtdade'];
				 $valor           =$_POST['valor'];
			   }
			}

            ////////Opçoes de seleção para compor os dados a serem gravados
			
		    switch (get_post_action('grava','busca_cep','localiza','gera','ativa_cli','ativa_ser')) {
			  case 'ativa_cli':
			  
				   $escritorio      =$_POST['escritorio'];
				   $n_remessa       =$_POST['n_remessa'];
				   $dt_remessa      =$_POST['dt_remessa'];
				   $codi_cli        =$_POST['codi_cli'];
				   
				   $_SESSION['codi_cli_m'] = $codi_cli;
				   
				   if(isset($_POST['codi_servi'])) {
				     $codi_servi		=$_POST['codi_servi'];
                   }
                   else {
                     $codi_servi     ='';
                   }
                   
				   $codi_barra      =$_POST['cod_barra'];
				   $n_hawb          =$_POST['n_hawb'];
				   $qtdade          =$_POST['qtdade'];
				   $valor           =$_POST['valor'];
				   $codigo_desti    =$_POST['codigo_desti'];
				   $nome_desti      =$_POST['nome_desti'];
				   $cep             =$_POST['cep'];
				   $rua_desti       =$_POST['rua_desti'];
				   $numero_desti    =$_POST['numero_desti'];
				   $comple_desti    =$_POST['comple_desti'];
				   $bairro_desti    =$_POST['bairro_desti'];
				   $cidade_desti    =$_POST['cidade_desti'];
				   $estado_desti    =$_POST['estado_desti'];
				   $classe_cep      =$_POST['classe_cep'];
				   $cnpj_desti      =$_POST['cnpj_desti'];
				   
				   $resp_grava       ='';
			  break;
			  
              case 'ativa_ser':
			       $escritorio      =$_POST['escritorio'];
				   $n_remessa       =$_POST['n_remessa'];
				   $dt_remessa      =$_POST['dt_remessa'];
				   $codi_cli        =$_POST['codi_cli'];
				   $codi_servi		=$_POST['codi_servi'];
                   $_SESSION['codi_servi_m'] = $codi_servi; 
				   $codi_barra      =$_POST['cod_barra'];
				   $n_hawb          =$_POST['n_hawb'];
				   $qtdade          =$_POST['qtdade'];
				   $valor           =$_POST['valor'];
				   $codigo_desti    =$_POST['codigo_desti'];
				   $nome_desti      =$_POST['nome_desti'];
				   $cep             =$_POST['cep'];
				   $rua_desti       =$_POST['rua_desti'];
				   $numero_desti    =$_POST['numero_desti'];
				   $comple_desti    =$_POST['comple_desti'];
				   $bairro_desti    =$_POST['bairro_desti'];
				   $cidade_desti    =$_POST['cidade_desti'];
				   $estado_desti    =$_POST['estado_desti'];
				   $classe_cep      =$_POST['classe_cep'];
				   $cnpj_desti      =$_POST['cnpj_desti'];
				   
				   $resp_grava       ='';
			  break;
			  
			  case 'gera':
				  // gera o numero da remessa	  
				  $ultimo = "SELECT * FROM nu_reme_manu ORDER BY numero DESC LIMIT 1";

				  $query = mysqli_query($con,$ultimo) or die ("Não foi possivel acessar o banco - numero remessa");
				  $total = mysqli_num_rows($query);
				  
				  if($total > 0){
				    for($ic=0; $ic<$total; $ic++){
					    $row = mysqli_fetch_row($query);
					    $n_reme           = $row[0];
				    }
				  }
				  else {
					 $n_reme =0; 
				  }  
				  $n_remessa  = sprintf("%07d",$n_reme+1);
				
				 //Retira os traços da string
				 $n_remessa    =str_replace('-','',$n_remessa);   
				 $_SESSION['n_remessa_m'] = $n_remessa;
				  
				 $escritorio      =$_POST['escritorio'];
				 $dt_remessa      =$_POST['dt_remessa'];
				 $codi_cli        =$_POST['codi_cli'];
				 $codi_servi      =$_POST['codi_servi'];
				 $codi_barra      =$_POST['cod_barra'];
				 $n_hawb          =$_POST['n_hawb'];
				 $qtdade          =$_POST['qtdade'];
				 $valor           =$_POST['valor'];
				 $codigo_desti    =$_POST['codigo_desti'];
				 $nome_desti      =$_POST['nome_desti'];
				 $cep             =$_POST['cep'];
				 $rua_desti       =$_POST['rua_desti'];
				 $numero_desti    =$_POST['numero_desti'];
				 $comple_desti    =$_POST['comple_desti'];
				 $bairro_desti    =$_POST['bairro_desti'];
				 $cidade_desti    =$_POST['cidade_desti'];
				 $estado_desti    =$_POST['estado_desti'];
				 $cnpj_desti      =$_POST['cnpj_desti'];
				 $classe_cep      =$_POST['classe_cep'];
				 
				 //Altera formato da data para salvar no arqivo
				 $a_dt_remessa  = explode("/",$dt_remessa);
				 $b_dt_remessa = $a_dt_remessa[2]."-".$a_dt_remessa[1]."-".$a_dt_remessa[0]; 
				 $verifi="SELECT numero FROM nu_reme_manu WHERE numero='$n_remessa'";
				 $query = mysqli_query($con,$verifi) or die ("Não foi possivel acessar o banco_2");
				 $achou = mysqli_num_rows($query);

				 If ($achou == 0 ) {
					 $atualiza = "INSERT INTO nu_reme_manu(numero,dt_remessa)
					 values('$n_remessa','$b_dt_remessa')";

					 mysqli_query($con,$atualiza);
				 }
			
				 $resp_grava       ='';	  
			  break;
			  
			  case 'localiza':
				   $escritorio      =$_POST['escritorio'];
				   $dt_remessa      =$_POST['dt_remessa'];
				   $codi_cli        =$_POST['codi_cli'];
				   $codi_servi      =$_POST['codi_servi'];
				   $codi_barra      =$_POST['cod_barra'];
				   $qtdade          =$_POST['qtdade'];
				   $valor           =$_POST['valor'];
				   $codigo_desti    =$_POST['codigo_desti'];
				   $nome_desti      =$_POST['nome_desti'];
				   $cep             =$_POST['cep'];
				   $rua_desti       =$_POST['rua_desti'];
				   $numero_desti    =$_POST['numero_desti'];
				   $comple_desti    =$_POST['comple_desti'];
				   $bairro_desti    =$_POST['bairro_desti'];
				   $cidade_desti    =$_POST['cidade_desti'];
				   $estado_desti    =$_POST['estado_desti'];
				   $cnpj_desti      =$_POST['cnpj_desti'];
				   
				   
				   //Busca o destino na tabela

				   $locali="SELECT codigo_desti,nome_desti,cep_desti,rua_desti,numero_desti,
				   comple_desti,bairro_desti,cidade_desti,estado_desti,classe_cep,documento
				   FROM destino WHERE trim(nome_desti)='$nome_desti'";
				   $query = mysqli_query($con,$locali) or die ("Não foi possivel acessar o banco - lozaliza destino");
				   $total = mysqli_num_rows($query);

				   for($ic=0; $ic<$total; $ic++){
					   $mostra = mysqli_fetch_row($query);
					   $codigo_desti   = $mostra[0];
					   $nome_desti     = $mostra[1];
					   $cep            = $mostra[2];
					   $rua_desti      = $mostra[3];
					   $numero_desti   = $mostra[4];
					   $comple_desti   = $mostra[5];
					   $bairro_desti   = $mostra[6];
					   $cidade_desti   = $mostra[7];
					   $estado_desti   = $mostra[8];
					   $classe_cep     = $mostra[9];
					   $cnpj_desti     = $mostra[10];
				   }
				   $resp_grava       ='';
			  break;
			  
			  case 'busca_cep':
				   $escritorio      =$_POST['escritorio'];
				   $dt_remessa      =$_POST['dt_remessa'];
				   $codi_cli        =$_POST['codi_cli'];
				   $codi_servi      =$_POST['codi_servi'];
				   $codi_barra      =$_POST['cod_barra'];
				   $qtdade          =$_POST['qtdade'];
				   $valor           =$_POST['valor'];
				   $codigo_desti    =$_POST['codigo_desti'];
				   $nome_desti      =$_POST['nome_desti'];
				   $cep             =$_POST['cep'];
				   $rua_desti       =$_POST['rua_desti'];
				   $numero_desti    =$_POST['numero_desti'];
				   $comple_desti    =$_POST['comple_desti'];
				   $bairro_desti    =$_POST['bairro_desti'];
				   $cidade_desti    =$_POST['cidade_desti'];
				   $estado_desti    =$_POST['estado_desti'];
				   $cnpj_desti      =$_POST['cnpj_desti'];
				   $classe_cep      =$_POST['calsse_cep'];
				   
				   
				   //Busca o endereco a partir do cep digitado
			   
				   $busca="SELECT logradouros.ds_logradouro_nome,
				   bairros.ds_bairro_nome,cidades.ds_cidade_nome,uf.ds_uf_sigla,logradouros.classe_cep
				   FROM logradouros,bairros,cidades,uf
				   WHERE ((logradouros.cd_bairro=bairros.cd_bairro)
				   AND (bairros.cd_cidade=cidades.cd_cidade)
				   AND (uf.cd_uf=cidades.cd_uf)
				   AND (logradouros.no_logradouro_cep='$cep'))";

				   $resu = mysqli_query($con,$busca) or die ("Não foi possivel acessar o banco - Função Busca Cep");
				   $total_c = mysqli_num_rows($resu);
				   
				   if($total_c > 0) {
					   for($ic=0; $ic<$total_c; $ic++){
						   $mostra = mysqli_fetch_row($resu);
						   
						   $rua_desti      = $mostra[0];
						   $bairro_desti   = $mostra[1];
						   $cidade_desti   = $mostra[2];
						   $estado_desti   = $mostra[3];
						   $classe_cep     = $mostra[4];
					   }
				   }
				   else {
					  $resp_grava="CEP não localizado! Verifique."; 
				   } 				   
			  break;
			  
			  case 'grava':

				   $escritorio      =$_POST['escritorio'];
				   $dt_remessa      =$_POST['dt_remessa'];
				   $codi_cli        =$_POST['codi_cli'];
				   $codi_servi      =$_POST['codi_servi'];
				   $n_remessa       =$_POST['n_remessa'];
				   $codi_barra      =$_POST['cod_barra'];
				   $n_hawb          =$_POST['n_hawb'];
				   $qtdade          =$_POST['qtdade'];
				   $valor           =$_POST['valor'];
				   $codigo_desti    =$_POST['codigo_desti'];
				   $nome_desti      =$_POST['nome_desti'];
				   $cep             =$_POST['cep'];
				   $rua_desti       =$_POST['rua_desti'];
				   $numero_desti    =$_POST['numero_desti'];
				   $comple_desti    =$_POST['comple_desti'];
				   $bairro_desti    =$_POST['bairro_desti'];
				   $cidade_desti    =$_POST['cidade_desti'];
				   $estado_desti    =$_POST['estado_desti'];
				   $cnpj_desti      =$_POST['cnpj_desti'];
				   $classe_cep		=$_POST['classe_cep'];
				   $estatus         ='BIP1';
				   
				   
				   //Salva os dados básico - escritorio, n_remessa, dt_remessa e codi_cli - numa sessão para poder repetir 
				   //na entrada de dados para o mesmo cliente até que mude os dados básicos
				   
				   $_SESSION['escritorio_m']  = $escritorio;
                   $_SESSION['n_remessa_m']   = $n_remessa;
                   $_SESSION['codi_cli_m']    = $codi_cli;
				   $_SESSION['codi_servi_m']  = $codi_servi;
				   $_SESSION['dt_remessa_m']  = $dt_remessa;
				   
				   //////////////////////////////////////////////////////////////////////////////////////////////
				   
				   // Controla classe de cep em branco

				   If ($classe_cep == '' ) {
					  ?>
					  <script language="javascript"> window.location.href=("lanca_remessa_com_leitora.php")
						alert('A classe de CEP destedestino está em branco, Defina a Classe de CEP, se não haverá problema no Faturamento.');
					  </script>
					  <?php
				   }
				   else {
					  if ($classe_cep <> '04') {
						   //Atribui valor 1 a quantidade caso não tenha sido digitado outro valor
						   if(isset($qtdade)) {
							  if ($qtdade=='') {
							     $qtdade='1';
							  }
						   }
						   else {
							   $qtdade='1'; 
						   }

						   //Pega valor do serviço na tabela de preço

						   if (($codi_cli<>'') and ($codi_servi<>'') and ($classe_cep<>'') and ($valor=='')) {
							    $pegava="SELECT valor FROM tabela_preco
							    WHERE ((codi_cli='$codi_cli') AND (tipo_servi='$codi_servi') AND (classe_cep='$classe_cep'))";
							    $query_2 = mysqli_query($con,$pegava) or die ("Não foi possivel acessar o banco 2");
							    $total = mysqli_num_rows($query_2);

							    for($ic=0; $ic<$total; $ic++){
							       $row = mysqli_fetch_row($query_2);
							       $valor        = $row[0];
							    }
							    if($valor = '') {
							       $valor ='0.00';
							    }
						    }

						    // alterando o formato dos valores para guardar na tabela
						    if ($valor<>'') {
							   if (strlen($valor)>=6) {
							     $valor         = str_replace(".", "", $valor);
							     $valor         = str_replace(",", ".", $valor);
							   }
							   if (strlen($valor)<6) {
							     $valor         = str_replace(",", ".", $valor);
							   }
						    }
						    else {
							  $valor ='0.00';
						    }
						  
						    //mudando formato da data para gravar na tabela

						    $dt_remessa  = explode("/",$dt_remessa);
						    $v_dt_remessa = $dt_remessa[2]."-".$dt_remessa[1]."-".$dt_remessa[0];

						    //verifica se ficaram campos importantes sem preencher

						    if ($rua_desti=='' or $bairro_desti=='' or $cidade_desti=='' or $estado_desti=='' or $n_remessa=='' or $n_hawb=='') {
							    ?>
							    <script language="javascript"> window.location.href=("lanca_remessa_com_leitora.php")
								    alert('Existem campos importantes que não foram preenchidos! Verifique.');
							    </script>
							    <?php
						    }
						    else {
																
							   $inclusao = "INSERT INTO remessa(codi_cli,n_remessa,escritorio,cod_barra,tipo_servi,codigo_desti,
							   nome_desti,cep_desti,rua_desti,numero_desti,bairro_desti,cidade_desti,estado_desti,dt_remessa,
							   qtdade,comple_desti,n_hawb,classe_cep,valor,co_servico,estatus,cnpj_desti)
							   VALUES('$codi_cli','$n_remessa','$escritorio','$codi_barra','$codi_servi','$codigo_desti','$nome_desti',
							   '$cep','$rua_desti','$numero_desti','$bairro_desti','$cidade_desti','$estado_desti','$v_dt_remessa','$qtdade',
							   '$comple_desti','$n_hawb','$classe_cep','$valor','$codi_servi','$estatus','$cnpj_desti')";

							   if (mysqli_query($con,$inclusao) or die ("Não foi possivel usar a tabela remessa: ".mysqli_errno($con)." - ".mysqli_error($con))) {

								    //Atualiza a tabela de destinos

								    $consulta="SELECT codigo_desti FROM destino WHERE codigo_desti='$codigo_desti'";
								    $query = mysqli_query($con,$consulta) or die ("Não foi possivel acessar o banco 3");
								    $achou = mysqli_num_rows($query);
									
									
								    if ($achou == 0 ) {
									   $inclusao = "INSERT INTO destino(codigo_desti,nome_desti,cep_desti,
									   rua_desti,numero_desti,bairro_desti,cidade_desti,
									   estado_desti,dt_atu_cada,comple_desti,classe_cep,documento)
									   VALUES('$codigo_desti','$nome_desti','$cep','$rua_desti',
									   '$numero_desti','$bairro_desti','$cidade_desti',
									   '$estado_desti','$v_dt_remessa','$comple_desti','$classe_cep','$cnpj_desti')";
									   mysqli_query($con,$inclusao);
								    }
								    else {
									   $alteracao = "UPDATE destino SET nome_desti='$nome_desti',cep_desti='$cep',
									   rua_desti='$rua_desti',numero_desti='$numero_desti',bairro_desti='$bairro_desti',
									   cidade_desti='$cidade_desti',estado_desti='$estado_desti',dt_atu_cada='$v_dt_remessa',
									   comple_desti='$comple_desti',classe_cep='$classe_cep',documento='$cnpj_desti'
									   WHERE codigo_desti='$codigo_desti'";
									   mysqli_query($con,$alteracao);
								    }

								    //////////////////Atualiza a tabela de controle de açõs no sistema ////////////////////
								    $programa     =$_SESSION['programa_m'];
								    $matricula_m  =$_SESSION['matricula_m'];
								    $data         = date('Y/m/d');
								    $hora         = date ('H:i:s');
							   
								    $incluir="INSERT INTO log_operacao_sistema (matricula,tarefa_executada,
								    n_hawb,data,hora,rotina,servico,codi_cli,remessa)
								    VALUES('$matricula_m','Inclusão de HAWB no Sistema','$n_hawb','$data','$hora',
								    '$programa','$codi_servi','$codi_cli','$n_remessa')";
								    mysqli_query($con,$incluir);

								    //////////////////Atualiza a tabela de histórico HAWB /////////////////////////////////
								    $atualiza="INSERT INTO controle_reentrega (n_hawb,dt_evento,ocorrencia,cod_barra,ordem)
								    VALUES('$n_hawb','$v_dt_remessa','Recebido na Transportadora.','$codi_barra','1')";
								    mysqli_query($con,$atualiza);

								    $resp_grava="Inclusão bem sucedida";
							   }
							   else {
								    $resp_grava="Problemas na Inclusão";
							   }
							 
							   $n_remessa        =$_SESSION['n_remessa_m'];
							   $escritorio       =$_SESSION['escritorio_m'];
							   $codi_cli         =$_SESSION['codi_cli_m'];
							   $codi_servi       =$_SESSION['codi_servi_m']; 
							   $dt_remessa       =$_SESSION['dt_remessa_m'];
							   $codi_barra       ='';
							   $n_hawb           ='';
							   $nome_desti       ='';
							   $codigo_desti     ='';
							   $cnpj_desti       ='';
							   $cep              ='';
							   $classe_cep       ='';
							   $rua_desti        ='';
							   $numero_desti     ='';
							   $comple_desti     ='';
							   $bairro_desti     ='';
							   $cidade_desti     ='';
							   $estado_desti     ='';
							   $qtdade           ='';
							   $valor            ='';
							   
							}  
				      }
				      else {
						   $n_remessa        =$_SESSION['n_remessa_m'];
						   $escritorio       =$_SESSION['escritorio_m'];
						   $codi_cli         =$_SESSION['codi_cli_m'];
						   $codi_servi       =$_SESSION['codi_servi_m']; 
						   $dt_remessa       =$_SESSION['dt_remessa_m'];
						   $codi_barra       ='';
						   $n_hawb           ='';
						   $nome_desti       ='';
						   $codigo_desti     ='';
						   $cnpj_desti       ='';
						   $cep              ='';
						   $classe_cep       ='';
						   $rua_desti        ='';
						   $numero_desti     ='';
						   $comple_desti     ='';
						   $bairro_desti     ='';
						   $cidade_desti     ='';
						   $estado_desti     ='';
						   $qtdade           ='';
						   $valor            ='';
					       ?>
					       <script language="javascript"> window.location.href=("lanca_remessa_com_leitora.php")
						    alert('HAWB NÂO GRAVADA, pois está fora de contrato! Verifique.');
					       </script>
					     <?php
				      }
				   }
			     
			   break;
		    default:  
		 }
     ?>
	 
	 <!-- Construção do formulário com todos os campos que serão preeenchidos -->
	 
         <table width="70%" border="1" cellpadding="5" cellspacing="0" bordercolor="#4169E1">
		    <tr>
               <td><b>Escritário :</b></td>
               <td>
                 <?php
                 $adm_m        =$_SESSION['adm_m'];
                 if (($adm_m=='E') or ($adm_m=='P')) {
					 if(isset($_SESSION['escritorio_m'])) {
                        $escritorio    =$_SESSION['depto_m'];
					 }
					 else {
						$escritorio    =''; 
					 }
                     ?>
                     <select name="escritorio" id="escritorio">
                     <?php
                        $sql1 = "SELECT codigo,nome FROM regi_dep WHERE codigo='$escritorio'";
                        $resula = mysqli_query($con,$sql1) or die ("Não foi possivel acessar o banco - regi_dep-1");
                        while ( $linha = mysqli_fetch_array($resula)) {
                           $select = $escritorio == $linha[0] ? "selected" : "";
                           echo "<option value=\"". $linha[0] . "\" $select>" . $linha[1] . "</option>";
                        }
                 }
                 if ($adm_m=='S') {
					 
					 if(isset($_SESSION['escritorio_m'])) {
                        $escritorio    =$_SESSION['depto_m'];
					 }
					 else {
						$escritorio    =''; 
					 } 
                     ?>
                     <select name="escritorio" id="escritorio">
                     <?php
                     $sql1 = "SELECT codigo,nome FROM regi_dep";
                     $resula = mysqli_query($con,$sql1) or die ("Não foi possivel acessar o banco - regi-dep");
                     while ( $linha = mysqli_fetch_array($resula)) {
                        $select = $escritorio == $linha[0] ? "selected" : "";
                        echo "<option value=\"". $linha[0] . "\" $select>" . $linha[1] . "</option>";
                     }
                 }
                 ?>
                 </select>
               </td>
		    </tr>
		    <tr>
               <?php
			   
			   if(isset($_SESSION['dt_remessa_m'])) {
				   
				   if($_SESSION['dt_remessa_m'] <> '') {		   
				      $dt_remessa = $_SESSION['dt_remessa_m'];
				   }
				   else {
					  $dt_remessa       = date('d/m/Y');  
				   }
			   }
			   else {
				   $dt_remessa       = date('d/m/Y'); 
			   }
			   
		       if ($adm_m=='N') {
               ?>
                 <td><b>Data Remessa</b> :</b></td>
                 <td><b><?php echo "$dt_remessa";?></b></b></td>
               <?php
               }
               else {		   
                 ?>
                 <td><b>Data Remessa</b> :</b></td>
                 <td>
                    <input type="text" name="dt_remessa" value ="<?php echo "$dt_remessa";?>" size="12" maxlength="12" id="dt_remessa">
                    <input TYPE="button" NAME="btndt_remessa" VALUE="..." Onclick="javascript:popdate('document.cadastro.dt_remessa','pop1','150',document.cadastro.dt_remessa.value)">
                    <span id="pop1" style="position:absolute"></span>
                 </td>
                 <?php
               }
              ?>
            </tr>
			<tr>
              <td><b>Cliente :</b></td>
              <td>
			    <?php
				   if(isset($_SESSION['codi_cli_m'])) {
                        $codi_cli    =$_SESSION['codi_cli_m'];
					 }
					 else {
						$codi_cli    =''; 
					 } 
				?>
                <select name="codi_cli" id="codi_cli">
                  <?php
                  $sql2 = "SELECT cnpj_cpf,nome FROM cli_for WHERE ativo='S' AND catego='C'";
                  $resul = mysqli_query($con,$sql2) or die ("Não foi possivel acessar o banco - cli_for");
                  while ( $linha = mysqli_fetch_array($resul)) {
                     $select = $codi_cli == $linha[0] ? "selected" : "";
                     echo "<option value=\"". $linha[0] . "\" $select>" . $linha[1] . "</option>";
                  }
                 ?>
                </select>
                <input name="ativa_cli" type="submit" value="Ativa Cliente">
              </td>
		    </tr>
			<tr>
              <td><b>Serviço :</b></td>
			  <?php
				   if(isset($_SESSION['codi_servi_m'])) {
                        $codi_servi    =$_SESSION['codi_servi_m'];
					 }
					 else {
						$codi_servi    =''; 
					 } 
				?>
              <td>			     
                 <select name="codi_servi" id="codi_servi">
                   <?php
                   $sql3 = "SELECT DISTINCT tabela_preco.tipo_servi, serv_ati.descri_se
                   FROM tabela_preco,serv_ati
                   WHERE ((tabela_preco.tipo_servi=serv_ati.codigo_se)
                   AND (tabela_preco.ativo='S')
                   AND  (tabela_preco.codi_cli='$codi_cli'))";
                   $resulo = mysqli_query($con,$sql3) or die ("Não foi possivel usar a tabela remessa: ".mysqli_errno($con)." - ".mysqli_error($con));
                   while ( $linha = mysqli_fetch_array($resulo)) {
                       $select = $codi_servi == $linha[0] ? "selected" : "";
                       echo "<option value=\"". $linha[0] . "\" $select>" . $linha[1] . "</option>";
                   }
                   ?>
                 </select>
				 <input name="ativa_ser" type="submit" value="Ativa Serviço">
              </td>
		    </tr>
			<tr>
			  <?php
			      if(isset($_SESSION['n_remessa_m'])) {
					  $n_remessa = $_SESSION['n_remessa_m']; 
				  }
				  else {
					  $n_remessa = ''; 
				  }
			  ?>
			  <td><b>Número da Remessa:</b></td>
			  <td><input type="text" name="n_remessa" value ="<?php echo "$n_remessa";?>" size="17" maxlength="17" id="n_remessa"><input name="gera" type="submit" value="Gera Número Remessa"></td>
		    </tr>
         </table>
		 <table width="70%" border="1" cellpadding="5" cellspacing="0" bordercolor="#4169E1">
		    <tr>
              <td><b>Codigo Barras :</b></td>
              <td><input type="text" name="cod_barra" id="cod_barra" value ="<?php echo "$codi_barra";?>" size="60" maxlength="60" onChange="salva(this)"></td>
            </tr>
            <!-- Coloca foco no primeiro campo codigo de barras do formulário -->
             <script language="JavaScript">
                document.getElementById('cod_barra').focus()
             </script>
            <tr>
              <td><b>Número da HAWB :</b></td>
              <td><input type="text" name="n_hawb" id="n_hawb" value ="<?php echo "$n_hawb";?>" size="30" maxlength="30"></td>
		    </tr>
		    <tr>
              <td><b>Qtdade Serviço :</b></td>
              <td><input name="qtdade" type="text" id="qtdade" value ="<?php echo "$qtdade";?>" size="6" maxlength="6"></td>  
            </tr>
            <tr>
		      <td><b>Valor :</b></td>
		      <td><input name="valor" type="text" size="20" value ="<?php echo "$valor";?>" maxlength="20" onKeydown="Formata(this,20,event,2)"></td>
		    </tr>
            <tr>
			  <td><b>Nome Destino :</b></td>
			  <br />
			  <td><input type="text" name="nome_desti" id="nome_desti" value ="<?php echo "$nome_desti";?>" size="50" maxlength="50" class="input_forms"/><input name="localiza" type="submit" value="Busca Dados Destino"></td>
	        </tr>
		    <tr>
              <td><b>Código Destino :</b></td>
              <td><input type="text" name="codigo_desti" id="codigo_desti" value ="<?php echo "$codigo_desti";?>" size="14" maxlength="14"></td>
		    </tr>
		    <tr>
              <td><b>CNPJ Destino :</b></td>
              <td><input type="text" name="cnpj_desti" id="cnpj_desti" value ="<?php echo "$cnpj_desti";?>" size="16" maxlength="16"></td>
		    </tr>
		    <tr>
              <td><b>CEP Destino(Sem Separador) :</b></td>
              <td><input name="cep" type="text" id="cep" value ="<?php echo "$cep";?>" size="10" maxlength="10"><input name="busca_cep" type="submit" value="Busca Endereço"></td>
            </tr>
            <tr>
              <td><b>Classe CEP :</b></td>
              <td>
                <select name="classe_cep" id="classe_cep">
                <?php
                $sql2 = "SELECT codigo,descricao FROM classe_cep";
                $resul = mysqli_query($con,$sql2) or die ("Não foi possivel acessar o banco - escritorio");
                while ( $linha = mysqli_fetch_array($resul)) {
                    $select = $classe_cep == $linha[0] ? "selected" : "";
                    echo "<option value=\"". $linha[0] . "\" $select>" . $linha[1] . "</option>";
                }
                ?>
                </select>
              </td>
		    </tr>
		    <tr>
			  <td><b>Rua Destino :</b></td>
			  <td><input type="text" name="rua_desti" value ="<?php echo "$rua_desti";?>" size="50" maxlength="50" id="rua_desti"></td>
		    </tr>
		    <tr>         
			  <td><b>Número Destino :</b></td>
			  <td><input type="text" name="numero_desti" value ="<?php echo "$numero_desti";?>" size="10" maxlength="10" id="numero_desti"></td>
		    </tr>
		    <tr>
			  <td><b>Complemento :</b></td>
			  <td><input type="text" name="comple_desti" value ="<?php echo "$comple_desti";?>"size="30" maxlength="30" id="comple_desti"></td>
		    </tr>
		    <tr>
			  <td><b>Bairro Destino :</b></td>
			  <td><input type="text" name="bairro_desti" value ="<?php echo "$bairro_desti";?>" size="40" maxlength="40" id="bairro_desti"></td>
		    </tr>
		    <tr>
			  <td><b>Cidade Destino :</b></td>
			  <td><input type="text" name="cidade_desti" value ="<?php echo "$cidade_desti";?>" size="40" maxlength="40" id="cidade_desti"></td>
		    </tr>
            <tr>
              <td><b>Estado Destino : </b></td>
              <td><input name="estado_desti" type="text" id="estado_desti" value ="<?php echo "$estado_desti";?>" size="3" maxlength="3"></td>
            </tr>
		    <tr>
              <td><INPUT type=button value="Consulta HAWB" onClick="window.open('consulta_remessa_por_hawb_tela.php','janela_1',
               'scrollbars=yes,resizable=yes,width=800,height=400');">
              </td>
		      <td colspan="2">
		        <div align="right">
			      <input name="grava" type="submit" value="Gravar">
			    </div>
		      </td>
		    </tr>
	     </table>
     </form>
    </div>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
         <td colspan="2" align="left" width="45%"><INPUT type=button size="3" value="Classe CEP"
               onClick="window.open('mostra_classe_cep.php','janela_1',
               'scrollbars=yes,resizable=yes,width=800,height=700');" style="width:100;height:30;color=red;font: bold 16px Arial;">
         </td>
      </tr>
    </table>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
         <td color="white" align="center" width="100%" height="45" colspan="8" ><?php echo "$resp_grava";?></td>
      </tr>
    </table>
    <table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td background="img/blue.jpg" align="left" width="100%" height="45px"><center><font face="arial" size="1" color="white">Todos Direitos Reservados a NUNESTEC Tecnologia</font></td>
      </tr>
    </table>

  </body>
</html>

