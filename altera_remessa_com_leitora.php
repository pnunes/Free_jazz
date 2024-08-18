<?php
  if ( session_status() !== PHP_SESSION_ACTIVE ) {
    session_start();
  }

  //carrega variaveis com dados para acessar o banco de dados
 
  Include('conexao_free.php');
  mysqli_set_charset($con,'UTF8');
   
  //verifica se o usuário esta habilitado para usar a rotina
 
  $matricula_m  =$_SESSION['matricula_m'];
  $programa='033';
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
	
	 if ($_SESSION['entrada_m']='S') {
		 
		$_SESSION['entrada_m']='N';
		 
	    $codigo_desti   ='';
		$nome_desti     ='';
		$cep            ='';
		$rua_desti      ='';
		$numero_desti   ='';
		$comple_desti   ='';
		$bairro_desti   ='';
		$cidade_desti   ='';
		$estado_desti   ='';
		$dt_remessa     ='';
		$codi_cli       ='';
		$escritorio     ='';
		$n_remessa      ='';
		$co_servico     ='';
		$codi_barra     ='';
		$n_hawb         ='';
		$qtdade         ='';
		$controle       ='';
		$classe_cep     ='';
		$valor          ='';
		$cnpj_desti     ='';
		$recebedor      ='';
		$documento      ='';	
	    $dt_entrega     ='';
	    $dt_baixa       ='';
	    $dt_lista       ='';
	    $dt_envio       ='';
	  
	    $resp_grava     ='';
	 }
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
   include ("pega_cep.php");
   if(!isset($_SESSION['dt_remessa'])) {
       $_SESSION['dt_remessa']  = date('d/m/Y');
   }
    
?>
<html>
  <title>altera_remessa_com_leitora.php</title>
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

      <!-------------------------------FUNÇÃO PARA FORMATAR VALOR ---------------------------->

     /* function Limpar(valor, validos) {
        var result = "";
        var aux;
        for (var i=0; i < valor.length; i++) {
          aux = validos.indexOf(valor.substring(i, i+1));
          if (aux>=0) {
            result += aux;
          }
        }
        return result;
     }*/

     function Formata(campo,tammax,teclapres,decimal) {
        var tecla = teclapres.keyCode;
        vr = Limpar(campo.value,"0123456789");
        tam = vr.length;
        dec=decimal

        if (tam < tammax && tecla != 8){ tam = vr.length + 1 ; }

          if (tecla == 8 )
          { tam = tam - 1 ; }

          if ( tecla == 8 || tecla >= 48 && tecla <= 57 || tecla >= 96 && tecla <= 105 )
          {

          if ( tam <= dec )
          { campo.value = vr ; }

          if ( (tam > dec) && (tam <= 5) ){
          campo.value = vr.substr( 0, tam - 2 ) + "," + vr.substr( tam - dec, tam ) ; }
          if ( (tam >= 6) && (tam <= 8) ){
          campo.value = vr.substr( 0, tam - 5 ) + "." + vr.substr( tam - 5, 3 ) + "," + vr.substr( tam - dec, tam ) ;
          }
          if ( (tam >= 9) && (tam <= 11) ){
          campo.value = vr.substr( 0, tam - 8 ) + "." + vr.substr( tam - 8, 3 ) + "." + vr.substr( tam - 5, 3 ) + "," + vr.substr( tam - dec, tam ) ; }
          if ( (tam >= 12) && (tam <= 14) ){
          campo.value = vr.substr( 0, tam - 11 ) + "." + vr.substr( tam - 11, 3 ) + "." + vr.substr( tam - 8, 3 ) + "." + vr.substr( tam - 5, 3 ) + "," + vr.substr( tam - dec, tam ) ; }
          if ( (tam >= 15) && (tam <= 17) ){
          campo.value = vr.substr( 0, tam - 14 ) + "." + vr.substr( tam - 14, 3 ) + "." + vr.substr( tam - 11, 3 ) + "." + vr.substr( tam - 8, 3 ) + "." + vr.substr( tam - 5, 3 ) + "," + vr.substr( tam - 2, tam ) ;}
          }

     }


    <!-- FUNÇÃO QUE VERIFICA SE CAMPOS FORAM PREENCHIDOS-->

      /*  function validar() {
          var n_hawb = cadastro.n_hawb.value;
          var n_remessa = cadastro.n_remessa.value;
          var rua_desti = cadastro.rua_desti.value;
          var numero_desti = cadastro.numero_desti.value;
          var bairro_desti = cadastro.numero_desti.value;
          var cidade_desti = cadastro.numero_desti.value;
          if (n_hawb == "") {
             alert('O campo da HAWB não foi preenchido! Verifique.');
             cadastro.n_hawb.focus();
             return false;
          }
          if (n_remessa == "") {
             alert('O campo NÚMERO DA REMESSA não foi preenchido! Verifique.');
             cadastro.n_remessa.focus();
             return false;
          }
          if (rua_desti == "") {
             alert('O campo RUA DO DESTINATÁRIO não foi preenchido! Verifique.');
             cadastro.rua_desti.focus();
             return false;
          }
          if (numero_desti == "") {
             alert('O campo NÚMERO DO DESTINATÁRIO não foi preenchido! Verifique.');
             cadastro.numero_desti.focus();
             return false;
          }
          if (bairro_desti == "") {
             alert('O campo BAIRRO DO DESTINATÁRIO não foi preenchido! Verifique.');
             cadastro.bairro_desti.focus();
             return false;
          }
          if (cidade_desti == "") {
             alert('O campo CIDADE DO DESTINATÁRIO não foi preenchido! Verifique.');
             cadastro.cidade_desti.focus();
             return false;
          }
        }*/

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
         <p align="right"><font face="Arial" size="2" color="#FFFFFF"><b>altera Remessa Com Leitora</b></font></td>
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
   <table width="80%" heigth="300">
    <?php
        
    switch (get_post_action('grava','busca_cep','localiza','pega')) {
      case 'pega':
	  
            $codigo_desti   ='';
			$nome_desti     ='';
			$cep            ='';
			$rua_desti      ='';
			$numero_desti   ='';
			$comple_desti   ='';
			$bairro_desti   ='';
			$cidade_desti   ='';
			$estado_desti   ='';
			$dt_remessa     ='';
			$codi_cli       ='';
			$escritorio     ='';
			$n_remessa      ='';
			$co_servico     ='';
			$codi_barra     ='';
			$n_hawb         ='';
			$qtdade         ='';
			$controle       ='';
			$classe_cep     ='';
			$valor          ='';
			$cnpj_desti     ='';
			$recebedor      ='';
			$documento      ='';	
			$dt_entrega     ='';
			$dt_baixa       ='';
			$dt_lista       ='';
	        $dt_envio       ='';
	  
			
			
            $n_hawb   =$_POST['n_hawb'];

            if ($n_hawb <>'') {
              
              //localiza o registro

              $localiza = "SELECT controle,date_format(dt_remessa,'%d/%m/%Y'),codi_cli,n_remessa,
              escritorio,co_servico,codigo_desti,nome_desti,cep_desti,rua_desti,numero_desti,comple_desti,
              bairro_desti,cidade_desti,estado_desti,qtdade,classe_cep,valor,date_format(dt_entrega,'%d/%m/%Y'),
              date_format(dt_baixa,'%d/%m/%Y'),date_format(dt_lista,'%d/%m/%Y'),date_format(dt_envio,'%d/%m/%Y'),
              recebedor,documento,cnpj_desti
              FROM remessa
              WHERE n_hawb='$n_hawb'";

              $query = mysqli_query($con,$localiza) or die ("Não foi possivel acessar o banco 1");
              $total = mysqli_num_rows($query);

              If ($total > 0 ) {
                for($ic=0; $ic<$total; $ic++){
                   $mostra = mysqli_fetch_row($query);
                   
				   $controle     = $mostra[0];
                   $dt_remessa   = $mostra[1];
                   $codi_cli     = $mostra[2];
                   $n_remessa    = $mostra[3];
                   $escritorio   = $mostra[4];
                   $co_servico   = $mostra[5];
                   $codigo_desti = $mostra[6];
                   $nome_desti   = $mostra[7];
                   $cep          = $mostra[8];
                   $rua_desti    = $mostra[9];
                   $numero_desti = $mostra[10];
                   $comple_desti = $mostra[11];
                   $bairro_desti = $mostra[12];
                   $cidade_desti = $mostra[13];
                   $estado_desti = $mostra[14];
                   $qtdade       = $mostra[15];            
                   $classe_cep   = $mostra[16];
                   $valor        = $mostra[17];
                   $dt_entrega   = $mostra[18];
                   $dt_baixa     = $mostra[19];
                   $dt_lista     = $mostra[20];
                   $dt_envio     = $mostra[21];
                   $recebedor    = $mostra[22];
                   $documento    = $mostra[23];
                   $cnpj_desti   = $mostra[24];
				   
                   
                   $valor   = number_format($valor, 2, ',', '.');
				   
				   $_SESSION['controle_m'] = $controle;
                }
				
              }
              else {
                 $n_hawb='';
                 ?>
                  <script language="javascript"> window.location.href=("altera_remessa_com_leitora.php")
                    alert('HAWB Não Localizada! Verifique.');
                  </script>
                 <?php
              }
            }
      break;
      
      case 'localiza':
	  
	       //echo "<p>Passando pelo modulo Localiza.";
	   
           /*$codi_barra                  =$_POST['cod_barra'];
           $co_servico                  =$_POST['co_servico'];
           $n_hawb                      =$_POST['n_hawb'];
           $nome_desti                  =$_POST['nome_desti'];
           $codigo_desti                =$_POST['codigo_desti'];
           $qtdade                      =$_POST['qtdade'];*/
		   
           $_SESSION['nome_desti']      =$_POST['nome_desti'];

           $locali="SELECT codigo_desti,nome_desti,cep_desti,rua_desti,numero_desti,
           comple_desti,bairro_desti,cidade_desti,estado_desti,classe_cep,documento
           FROM destino WHERE trim(nome_desti)='".$_SESSION['nome_desti']."'";
           $query = mysqli_query($con,$locali) or die ("Não foi possivel acessar o banco");
           $total = mysqli_num_rows($query);

           for($ic=0; $ic<$total; $ic++){
               $mostra = mysqli_fetch_row($query);
		       $_SESSION['codigo_desti']   = $mostra[0];
               $_SESSION['nome_desti']     = $mostra[1];
               $_SESSION['cep']            = $mostra[2];
               $_SESSION['rua_desti']      = $mostra[3];
               $_SESSION['numero_desti']   = $mostra[4];
               $_SESSION['comple_desti']   = $mostra[5];
               $_SESSION['bairro_desti']   = $mostra[6];
               $_SESSION['cidade_desti']   = $mostra[7];
               $_SESSION['estado_desti']   = $mostra[8];
               $_SESSION['classe_cep']     = $mostra[9];
               $_SESSION['cnpj_desti']     = $mostra[10];
           }
      break;
      
      case 'busca_cep':
	  
	       //carrega as variaveis com os dados da tela para não perdel-os

	       $codi_cli        =$_POST['codi_cli'];
           $n_remessa       =$_POST['n_remessa'];
           $escritorio      =$_POST['escritorio'];
           $co_servico      =$_POST['co_servico'];
           $codi_barra      =$_POST['cod_barra'];
           $codigo_desti    =$_POST['codigo_desti'];
		   $cep             =$_POST['cep'];
           $rua_desti       =$_POST['rua_desti'];
           $numero_desti    =$_POST['numero_desti'];
           $comple_desti    =$_POST['comple_desti'];
           $bairro_desti    =$_POST['bairro_desti'];
           $cidade_desti    =$_POST['cidade_desti'];
           $estado_desti    =$_POST['estado_desti'];
           $qtdade          =$_POST['qtdade'];
           $nome_desti      =$_POST['nome_desti'];
	       $dt_remessa      =$_POST['dt_remessa'];
		   $cnpj_desti      =$_POST['cnpj_desti'];
           $n_hawb          =$_POST['n_hawb'];
           $classe_cep      =$_POST['classe_cep'];
           $valor           =$_POST['valor'];
           $dt_entrega      =$_POST['dt_entrega'];
           $dt_baixa        =$_POST['dt_baixa'];
           $dt_lista        =$_POST['dt_lista'];
           $dt_envio        =$_POST['dt_envio'];
           $recebedor       =$_POST['recebedor'];
           $documento       =$_POST['documento'];
           
		   
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
	       
           $codi_cli        =$_POST['codi_cli'];
           $n_remessa       =$_POST['n_remessa'];
           $escritorio      =$_POST['escritorio'];
           $co_servico      =$_POST['co_servico'];
           $codi_barra      =$_POST['cod_barra'];
           $codigo_desti    =$_POST['codigo_desti'];
           $qtdade          =$_POST['qtdade'];
           $nome_desti      =$_POST['nome_desti'];
           $cep             =$_POST['cep'];
           $rua_desti       =$_POST['rua_desti'];
           $numero_desti    =$_POST['numero_desti'];
           $comple_desti    =$_POST['comple_desti'];
           $bairro_desti    =$_POST['bairro_desti'];
           $cidade_desti    =$_POST['cidade_desti'];
           $estado_desti    =$_POST['estado_desti'];
           $dt_remessa      =$_POST['dt_remessa'];
		   $cnpj_desti      =$_POST['cnpj_desti'];
           $n_hawb          =$_POST['n_hawb'];
           $classe_cep      =$_POST['classe_cep'];
           $valor           =$_POST['valor'];
           $dt_entrega      =$_POST['dt_entrega'];
           $dt_baixa        =$_POST['dt_baixa'];
           $dt_lista        =$_POST['dt_lista'];
           $dt_envio        =$_POST['dt_envio'];
           $recebedor       =$_POST['recebedor'];
           $documento       =$_POST['documento'];
		   
		   
           if ($qtdade =='') {
               $qtdade =1;
           }
           // alterando o formato dos valores para guardar no banco
		    
            if ($valor <>'') {
                if (strlen($valor )>=6) {
                   $valor          = str_replace(".", "", $valor );
                   $valor          = str_replace(",", ".", $valor );
                }
                if (strlen($valor )<6) {
                   $valor          = str_replace(",", ".", $valor );
                }
            }
            else {
               
                //Pega valor do serviço na tabela de preços

                $pegava="SELECT valor FROM tabela_preco
                WHERE ((codi_cli='$codi_cli') AND (tipo_servi='$co_servico') AND (classe_cep='$classe_cep'))";
                $query_2 = mysqli_query($con,$pegava) or die ("Não foi possivel acessar a Tabela de Preco");
                $total = mysqli_num_rows($query_2);

                for($ic=0; $ic<$total; $ic++){
                   $row = mysqli_fetch_row($query_2);
                   $valor    = $row[0];
                }
				
				if ($valor <>'') {
                   if (strlen($valor )>=6) {
                      $valor          = str_replace(".", "", $valor );
                      $valor          = str_replace(",", ".", $valor );
                   }
                   if (strlen($valor )<6) {
                      $valor         = str_replace(",", ".", $valor );
                   }
                }
				else {
					$valor = '0.00';
			    }
            }
           
           //mudando formato da data para gravar na tabela
		   
           if($dt_remessa <>'') {
               $t_dt_remessa  = explode("/",$dt_remessa);
               $v_dt_remessa = $t_dt_remessa[2]."-".$t_dt_remessa[1]."-".$t_dt_remessa[0];
		   }
		   else {
			   $v_dt_remessa = '';
		   }
		   if($dt_entrega <>'') {
               $t_dt_entrega  = explode("/",$dt_entrega);
               $v_dt_entrega = $t_dt_entrega[2]."-".$t_dt_entrega[1]."-".$t_dt_entrega[0];
           }
		   else {
			  $v_dt_entrega =''; 
		   }
		   if($dt_baixa <>'') {
               $t_dt_baixa  = explode("/",$dt_baixa);
               $v_dt_baixa = $t_dt_baixa[2]."-".$t_dt_baixa[1]."-".$t_dt_baixa[0];
           }
		   else {
			   $v_dt_baixa =''; 
		   }
		   if($dt_lista <>'') {
               $t_dt_lista  = explode("/",$dt_lista);
               $v_dt_lista = $t_dt_lista[2]."-".$t_dt_lista[1]."-".$t_dt_lista[0];
           }
		   else {
			   $v_dt_lista = ''; 
		   }
		   if($dt_envio <>'') {
               $t_dt_envio  = explode("/",$dt_envio);
               $v_dt_envio = $t_dt_envio[2]."-".$t_dt_envio[1]."-".$t_dt_envio[0];
           }
		   else {
			   $v_dt_envio = '';
		   }
		   
		   $controle  = $_SESSION['controle_m'];
		   
           if ($controle<>'') {
              
              //Verifica se o a HAWB já foi lançaada

              $localiza = "SELECT controle FROM remessa
              WHERE controle='$controle'";

              $query = mysqli_query($con,$localiza) or die ("Não foi possivel usar a tabela remeaasa: ".mysqli_errno($con)." - ".mysqli_error($con));
              $achou = mysqli_num_rows($query);

              If ($achou > 0 ) {
             
                 $alteracao = "UPDATE remessa SET codi_cli='$codi_cli',n_remessa='$n_remessa',
                 escritorio='$escritorio',co_servico='$co_servico',codigo_desti='$codigo_desti',
                 nome_desti='$nome_desti',cep_desti='$cep',rua_desti='$rua_desti',numero_desti='$numero_desti',
				 bairro_desti='$bairro_desti',cidade_desti='$cidade_desti',estado_desti='$estado_desti',dt_remessa='$v_dt_remessa',
                 qtdade='$qtdade',comple_desti='$comple_desti',classe_cep='$classe_cep',
                 valor='$valor',dt_entrega='$v_dt_entrega',dt_baixa='$v_dt_baixa',dt_lista='$v_dt_lista',dt_envio='$v_dt_envio',
				 recebedor='$recebedor',documento='$documento',cnpj_desti='$cnpj_desti'
                 WHERE controle='$controle'";

                 if (mysqli_query($con,$alteracao) or die ("Não foi possivel usar a tabela Remessa: ".mysqli_errno($con)." - ".mysqli_error($con))) {
                 
                    /////////Atualiza a tabela de controle de ações no sistema /////////////////////////////
                    $matricula_m  =$_SESSION['matricula_m'];
                    $data         = date('Y/m/d');
                    $hora         = date ('H:i:s');
                    $programa     =$_SESSION['programa_m'];
                    
                    $incluir="INSERT INTO log_operacao_sistema (matricula,tarefa_executada,n_hawb,data,hora,rotina)
                    VALUES('$matricula_m','Alteração HAWB lançada','$n_hawb','$data','$hora','$programa')";
                    mysqli_query($con,$incluir) or die ("Não foi possivel usar a tabela Log_operacao: ".mysqli_errno($con)." - ".mysqli_error($con));
                 
                    //////////////////Atualiza a tabela de histórico HAWB /////////////////////////////////
                    $atualiza="INSERT INTO controle_reentrega (n_hawb,dt_evento,ocorrencia,cod_barra)
                    VALUES('$n_hawb','$v_dt_remessa','Alteração HAWB lançada Sistema.','$codi_barra')";
                    mysqli_query($con,$atualiza) or die ("Não foi possivel usar a tabela Controle_reentrega: ".mysqli_errno($con)." - ".mysqli_error($con));

					$resp_grava="Alterações bem sucedidas!";
					
					$codigo_desti   ='';
					$nome_desti     ='';
					$cep            ='';
					$rua_desti      ='';
					$numero_desti   ='';
					$comple_desti   ='';
					$bairro_desti   ='';
					$cidade_desti   ='';
					$estado_desti   ='';
					$dt_remessa     ='';
					$codi_cli       ='';
					$escritorio     ='';
					$n_remessa      ='';
					$co_servico     ='';
					$codi_barra     ='';
					$n_hawb         ='';
					$qtdade         ='';
					$controle       ='';
					$classe_cep     ='';
					$valor          ='';
					$cnpj_desti     ='';
					$recebedor      ='';
					$documento      ='';	
					$dt_entrega     ='';
					$dt_baixa       ='';
					$dt_lista       ='';
					$dt_envio       ='';
					$_SESSION['controle_m'] = '';
					
                 }
                 else {
                    $resp_grava="Problemas na Alteração";
                 }
             }
             else {
                ?>
                 <script language="javascript"> window.location.href=("altera_remessa_com_leitora.php")
                   alert('Registro não localizada! Verifique');
                 </script>
                <?php
             }
           }
		   
           break;
           default:
    }
	if(isset($_POST['cod_barra'])) {
		
        $codi_barra  =$_POST['cod_barra'];
		
		if ($codi_barra <>'') {
            
			 //Pega o registro na tabela remessa para mostrar

			 $resp_grava='';

			 $localiza = "SELECT controle,n_hawb,date_format(dt_remessa,'%d/%m/%Y'),codi_cli,n_remessa,
				  escritorio,co_servico,codigo_desti,nome_desti,cep_desti,rua_desti,numero_desti,comple_desti,
				  bairro_desti,cidade_desti,estado_desti,qtdade,classe_cep,valor,date_format(dt_entrega,'%d/%m/%Y'),
				  date_format(dt_baixa,'%d/%m/%Y'),date_format(dt_lista,'%d/%m/%Y'),
                  date_format(dt_envio,'%d/%m/%Y'),recebedor,documento,cnpj_desti
				  FROM remessa
				  WHERE cod_barra='$codi_barra'";

			 $query = mysqli_query($con,$localiza) or die ("Não foi possivel acessar o banco 1");
			 $total = mysqli_num_rows($query);

			 If ($total > 0 ) {
				for($ic=0; $ic<$total; $ic++){
				   $mostra = mysqli_fetch_row($query);
				   
				   $controle     = $mostra[0];
				   
				   $_SESSION['controle_m'] = $controle;
				   
				   
				   $n_hawb       = $mostra[1];
                   $dt_remessa   = $mostra[2];
                   $codi_cli     = $mostra[3];
                   $n_remessa    = $mostra[4];
                   $escritorio   = $mostra[5];
                   $co_servico   = $mostra[6];
                   $codigo_desti = $mostra[7];
                   $nome_desti   = $mostra[8];
                   $cep          = $mostra[9];
                   $rua_desti    = $mostra[10];
                   $numero_desti = $mostra[11];
                   $comple_desti = $mostra[12];
                   $bairro_desti = $mostra[13];
                   $cidade_desti = $mostra[14];
                   $estado_desti = $mostra[15];
                   $qtdade       = $mostra[16];            
                   $classe_cep   = $mostra[17];
                   $valor        = $mostra[18];
                   $dt_entrega   = $mostra[19];
                   $dt_baixa     = $mostra[20];
                   $dt_lista     = $mostra[21];
                   $dt_envio     = $mostra[22];
                   $recebedor    = $mostra[23];
                   $documento    = $mostra[24];
                   $cnpj_desti   = $mostra[25];
				}

			 }
		}
	}
	
    ?>
    <form method="POST" name="cadastro" action="altera_remessa_com_leitora.php" border="20" align="center">
    <body leftmargin="10" topmargin="10" marginwidth="10" marginheight="10">
	<table width="70%" border="1" cellpadding="5" cellspacing="0" bordercolor="#4169E1">
        <tr>
           <td><b>Codigo Barras :</b></td>
           <td><input type="text" name="cod_barra" id="cod_barra" size="60" maxlength="60" onChange="salva(this)"></td>
        </tr>
        <!-- Coloca foco no primeiro campo codigo de barras do formulário -->
        <script language="JavaScript">
            document.getElementById('cod_barra').focus()
        </script>
        <tr>
           <td><b>Número da HAWB :</b></td>
           <td><input type="text" name="n_hawb" id="n_hawb" value ="<?php echo "$n_hawb";?>" size="30" maxlength="30"><input name="pega" type="submit" value="Mostra dados"></td>
 	    </tr>
        <tr>
			<td><b>Número da Remessa:</b></td>
			<td><input type="text" name="n_remessa" value ="<?php echo "$n_remessa";?>" size="17" maxlength="17" id="n_remessa"></td>
		</tr>
		<tr>
           <td><b>Escritório :</b></td>
           <td>
              <?php
               $adm_m        =$_SESSION['adm_m'];
               if ($adm_m=='N') {
				   if(isset($_SESSION['depto_m'])){
                      $escritorio  = $_SESSION['depto_m'];
				   }
				   else {
					  $escritorio  =''; 
				   }
               }
               /*if ($adm_m=='S') {
				   if(isset($_SESSION['escritorio_m'])){
                      $escritorio    =$_SESSION['escritorio'];
				   }
				   else {
					  $escritorio    =''; 
				   }
               }*/
               
               ?>
              <select name="escritorio">
              <?php
			    
                $sql1 = "SELECT codigo,nome FROM regi_dep";
                $resula = mysqli_query($con,$sql1) or die ("Não foi possivel acessar o banco");
                while ( $linha = mysqli_fetch_array($resula)) {
                    $select = $escritorio == $linha[0] ? "selected" : "";
                    echo "<option value=\"". $linha[0] . "\" $select>" . $linha[1] . "</option>";
              }
              ?>
            </select>
            </td>
		</tr>
		<tr>
          <td><b>Data Remessa</b> :</b></td>
          <td>
            <input type="text" name="dt_remessa" value ="<?php echo "$dt_remessa";?>" size="12" maxlength="12" id="dt_remessa">
            <input TYPE="button" NAME="btndt_remessa" VALUE="..." Onclick="javascript:popdate('document.cadastro.dt_remessa','pop1','150',document.cadastro.dt_remessa.value)">
            <span id="pop1" style="position:absolute"></span>
          </td>
        </tr>
        <tr>
           <td><b>Cliente :</b></td>
           <td>
              
               <select name="codi_cli">
               <?php
                $sql2 = "SELECT cnpj_cpf,nome FROM cli_for WHERE ativo='S' AND catego='C'";
                $resul = mysqli_query($con,$sql2) or die ("Não foi possivel acessar o banco");
                while ( $linha = mysqli_fetch_array($resul)) {
                    $select = $codi_cli == $linha[0] ? "selected" : "";
                    echo "<option value=\"". $linha[0] . "\" $select>" . $linha[1] . "</option>";
               }
              ?>
            </select>
            </td>
		</tr>
		<tr>
           <td><b>Serviço :</b></td>
           <td>
               <select name="co_servico">
               <?php
                $sql3 = "SELECT codigo_se,descri_se FROM serv_ati";
                $resulo = mysqli_query($con,$sql3) or die ("Não foi possivel acessar o banco");
                while ( $linha = mysqli_fetch_array($resulo)) {
                    $select = $co_servico == $linha[0] ? "selected" : "";
                    echo "<option value=\"". $linha[0] . "\" $select>" . $linha[1] . "</option>";
               }
              ?>
              </select>
            </td>
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
           <td><b>CEP Destino :</b></td>
           <td><input name="cep" type="text" id="cep" value ="<?php echo "$cep";?>" size="9" maxlength="9"><input name="busca_cep" type="submit" value="Busca Endereço"></td>
        </tr>
        <tr>
		  <td><b>Classe CEP :</b></td>
           <td>
			  <?php
               echo "<select name=\"classe_cep\">";
               $sql3 = "SELECT codigo,descricao FROM classe_cep";
               $resulo = mysqli_query($con,$sql3) or die ("Não foi possivel acessar o banco");
               while ( $linha = mysqli_fetch_array($resulo)) {
                    $select = $classe_cep == $linha[0] ? "selected" : "";
                    echo "<option value=\"". $linha[0] . "\" $select>" . $linha[1] ."</option>";
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
           <td><b>Qtdade Serviço :</b></td>
           <td><input name="qtdade" type="text" id="qtdade" value ="<?php echo "$qtdade";?>" size="6" maxlength="6"></td>
        </tr>
        <tr>
           <td><b>Valor Serviço :</b></td>
           <td><input name="valor" type="text" id="valor" value ="<?php echo "$valor";?>" size="8" maxlength="8" onKeydown="Formata(this,20,event,2)"></td>
        </tr>
        <tr>
          <td><b>Data Entrega</b> :</b></td>
          <td>
            <input type="text" name="dt_entrega" value ="<?php echo "$dt_entrega";?>" size="12" maxlength="12" id="dt_entrega">
            <input TYPE="button" NAME="btndt_entrega" VALUE="..." Onclick="javascript:popdate('document.cadastro.dt_entrega','pop2','150',document.cadastro.dt_entrega.value)">
            <span id="pop2" style="position:absolute"></span>
          </td>
        </tr>
        <tr>
          <td><b>Data Baixa</b> :</b></td>
          <td>
            <input type="text" name="dt_baixa" value ="<?php echo "$dt_baixa";?>" size="12" maxlength="12" id="dt_baixa">
            <input TYPE="button" NAME="btndt_baixa" VALUE="..." Onclick="javascript:popdate('document.cadastro.dt_baixa','pop3','150',document.cadastro.dt_baixa.value)">
            <span id="pop3" style="position:absolute"></span>
          </td>
        </tr>
        <tr>
          <td><b>Data Lista</b> :</b></td>
          <td>
            <input type="text" name="dt_lista" value ="<?php echo "$dt_lista";?>" size="12" maxlength="12" id="dt_lista">
            <input TYPE="button" NAME="btndt_lista" VALUE="..." Onclick="javascript:popdate('document.cadastro.dt_lista','pop4','150',document.cadastro.dt_lista.value)">
            <span id="pop4" style="position:absolute"></span>
          </td>
        </tr>
        <tr>
          <td><b>Data Envio Origem</b> :</b></td>
          <td>
            <input type="text" name="dt_envio" value ="<?php echo "$dt_envio";?>" size="12" maxlength="12" id="dt_envio">
            <input TYPE="button" NAME="btndt_envio" VALUE="..." Onclick="javascript:popdate('document.cadastro.dt_envio','pop5','150',document.cadastro.dt_envio.value)">
            <span id="pop5" style="position:absolute"></span>
          </td>
        </tr>
        <tr>
           <td><b>Nome Recebedor : </b></td>
           <td><input name="recebedor" type="text" id="recebedor" value ="<?php echo "$recebedor";?>" size="40" maxlength="40"></td>
        </tr>
        <tr>
           <td><b>Documento : </b></td>
           <td><input name="documento" type="text" id="documento" value ="<?php echo "$documento";?>" size="30" maxlength="30"></td>
        </tr>
		<tr>
          <td><INPUT type=button value="Consulta HAWB"
               onClick="window.open('consulta_remessa_por_hawb_tela.php','janela_1',
               'scrollbars=yes,resizable=yes,width=800,height=400');">
          </td>
		  <td colspan="2">
		     <div align="right">
			   <input name="grava" type="submit" onclick="return validar()" value="Alterar">
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
      <td color="white" align="center" width="900" height="45" colspan="8" ><?php echo "$resp_grava";?></td>
     </tr>
  </table>
  <table width="100%"  border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td background="img/blue.jpg" align="left" width="100%" height="45px"><center><font face="arial" size="1" color="white">Todos Direitos Reservados a NUNESTEC Tecnologia</font></td>
    </tr>
  </table>

</body>
</html>

