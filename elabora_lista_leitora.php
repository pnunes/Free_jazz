<?php
    if ( session_status() !== PHP_SESSION_ACTIVE ) {
        session_start();
    }

    //carrega variaveis com dados para acessar o banco de dados
 
    Include('conexao_free.php');
    mysqli_set_charset($con,'UTF8');
   
    //verifica se o usuário esta habilitado para usar a rotina
 
    $matricula_m  =$_SESSION['matricula_m'];
    $programa='035';
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
	
	if ($_SESSION['entrada_m']=='S')  {

      $_SESSION['numero_lista_m'] = '';
      $_SESSION['entregador_m']   = '';
	  
	  $_SESSION['entrada_m']='N';
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

    switch (get_post_action('seleciona','imprime','grava','lista')) {

          case 'seleciona':

             //Pega data digitada e o codigo do entregador

             unset($_SESSION['v_dt_lista_m']);
             unset($_SESSION['dt_lista_co_m']);
             $dt_lista_co ='';

             $entregador                 =$_POST['entregador'];
             $_SESSION['entregador_m']   =$entregador;
             $dt_lista                   =$_POST['dt_lista'];
             $_SESSION['dt_lista_m']     =$dt_lista;

             $n_dt_lista  = explode("/",$dt_lista);
             $v_dt_lista = $n_dt_lista[2]."-".sprintf("%02d",$n_dt_lista[1])."-".sprintf("%02d",$n_dt_lista[0]);
             $_SESSION['v_dt_lista_m']     =$v_dt_lista;
             $dt_lista_co= strtotime($v_dt_lista);
             $_SESSION['dt_lista_co_m']   =$dt_lista_co;

             //Pega nome entregador na tabela cli_for

             $resultado = mysqli_query ($con,"SELECT nome FROM cli_for WHERE cnpj_cpf='$entregador'");
             $total = mysqli_num_rows($resultado);

             for($i=0; $i<$total; $i++){
                $dados = mysqli_fetch_row($resultado);
                $nome_entregador      =$dados[0];
             }
             $_SESSION['nome_entregador_m']   =$nome_entregador;
          break;

          case 'lista':
              //Gera número para a lista
              //Pega codigo entregador

              $ultimo = "SELECT * FROM controle_lista ORDER BY numero DESC LIMIT 1";
              $query = mysqli_query($con,$ultimo) or die ("Não foi possivel acessar o banco - controle-lista");
              $total = mysqli_num_rows($query);
              if($total > 0) {
                 for($ic=0; $ic<$total; $ic++){
                     $row = mysqli_fetch_row($query);
                     $numero_lista       = $row[0];
                 }
			  }
			  else {
				     $numero_lista =0;					 
			  }
              $v_numero_lista              =$numero_lista+1;
              $_SESSION['numero_lista_m']  =$v_numero_lista;
              $entregador                  =$_SESSION['entregador_m'];
			  $v_dt_lista                  =$_SESSION['v_dt_lista_m'];
              //Grava o numero da lista na tabela

              $atualiza = "INSERT INTO controle_lista(numero,dt_lista,entregador)
              values('$v_numero_lista','$v_dt_lista','$entregador')";
			  
              mysqli_query($con,$atualiza);
          break;

          case 'grava':
               $n_hawb     =$_POST['n_hawb'];
               if ($n_hawb<>'') {
                   $entregador =$_SESSION['entregador_m'];
                   If ($entregador =='') {
                      ?>
                      <script language="javascript"> window.location.href=("elabora_lista_leitora.php")
                         alert('Você precisa selecionar um entregador e clicar no botão SELECIONAR!');
                      </script>
                      <?php
                   }
                   //Verifica se a hawb foi lançada no sistema
                   $resp_grava='';
                   $verifi="SELECT controle,n_tentativas,n_hawb,cod_barra,entregador,dt_lista,dt_remessa
                   FROM remessa
                   WHERE n_hawb='$n_hawb'";
                   $query = mysqli_query($con,$verifi) or die ("Não foi possivel acessar o banco");
                   $total = mysqli_num_rows($query);
                   If ($total == 0 ) {
                      $n_hawb='';
                      ?>
                        <script language="javascript"> window.location.href=("elabora_lista_leitora.php")
                            alert('HAWB Não lançada no sistema !');
                        </script>
                      <?php
                   }
                   else {
                      for($ic=0; $ic<$total; $ic++){
                         $mostra = mysqli_fetch_row($query);
                         $controle       = $mostra[0];
                         $n_tentativas   = $mostra[1];
                         $n_hawb         = $mostra[2];
                         $codi_barra_g   = $mostra[3];
                         $levador        = $mostra[4];
                         $data_li        = $mostra[5];
                         $dt_remessa     = $mostra[6];
                      }
                      $n_tentativas              =$n_tentativas+1;
                      $_SESSION['tentativas_m']  =$n_tentativas;
                      $_SESSION['controle_m']    =$controle;
                      $_SESSION['n_hawb_m']      =$n_hawb;
                      $_SESSION['cod_barra_g']   =$codi_barra_g;
					  
                      //Verifica se a HAWB já tem entregador definido

                      $v_dt_remessa_co= strtotime($dt_remessa);
                      $dt_lista_co  =$_SESSION['dt_lista_co_m'];
                      If ($data_li=='0000-00-00') {
                           //grava o movimento
                           if ($dt_lista_co >= $v_dt_remessa_co) {
                               $entregador      =$_SESSION['entregador_m'];
                               $v_dt_lista      =$_SESSION['v_dt_lista_m'];
                               $n_tentativas    =$_SESSION['tentativas_m'];
                               $controle        =$_SESSION['controle_m'];
                              // $codi_cli        =$_SESSION['codi_cli_m'];
                             //  $tipo_servi      =$_SESSION['tipo_servi_m'];
                               $v_nu_lista      =$_SESSION['numero_lista_m'];
                               $estatus         ='BIP2';
                               $v_dt_lista      =$_SESSION['v_dt_lista_m'];

                               $alteracao = "UPDATE remessa SET entregador='$entregador',dt_lista='$v_dt_lista',
                               n_tentativas='$n_tentativas',nu_lista='$v_nu_lista',estatus='$estatus',
                               tipo_servi='$tipo_servi'
                               WHERE controle='$controle'";
							   
                               if (mysqli_query($con,$alteracao)) {
                                  //Atualiza a tabela log_operação sistema
                                  $programa     =$_SESSION['programa_m'];
                                  $matricula_m  =$_SESSION['matricula_m'];
                                  $hora         = date ('H:i:s');
                                  $data         = date('Y-m-d');
                                  $n_hawb       =$_SESSION['n_hawb_m'];
                                  $codi_barra_g =$_SESSION['cod_barra_g'];

                                  $inclui="INSERT INTO log_operacao_sistema(matricula,tarefa_executada,data,hora,rotina,n_hawb)
                                  VALUES('$matricula_m','Elabora Lista com leitora','$data','$hora','$programa','$n_hawb')";
								  
                                  mysqli_query($con,$inclui);

                                  //////////////////Atualiza a tabela de histórico HAWB /////////////////////////////////
                                  $atualiza="INSERT INTO controle_reentrega (n_hawb,dt_evento,ocorrencia,cod_barra,ordem)
                                  VALUES('$n_hawb','$v_dt_lista','Em rota de entrega.','$codi_barra_g','2')";
								  
                                  mysqli_query($con,$atualiza);
                                  $resp_grava="Inclusão bem sucedida";
                                  $codi_barra          ='';
                                  $controle            ='';
                                  $entrega             ='';
                                  unset($_SESSION['tentativas_m']);
                                  unset($_SESSION['controle_m']);
                                  unset($_SESSION['n_hawb_m']);
                                  unset($_SESSION['cod_barra_g']);
                               }
                               else {
                                  $resp_grava="Problemas na Inclusão";
                               }

                           }
                           else {
                               $n_hawb='';
                               ?>
                               <script language="javascript"> window.location.href=("elabora_lista_leitora.php")
                                   alert('Data da lista é inferior a data da HAWB !');
                               </script>
                               <?php
                           }
                      }
                   }
               }
          break;
          
          case 'imprime':
               $entregador      =$_SESSION['entregador_m'];
               $v_numero_lista  =$_SESSION['numero_lista_m'];
               
               //Pega nome entregador

               $verifi="SELECT nome FROM cli_for WHERE cnpj_cpf='$entregador'";
               $query = mysqli_query($con,$verifi) or die ("Não foi possivel acessar o banco");
               $total = mysqli_num_rows($query);
               for($ic=0; $ic<$total; $ic++){
                  $mostra = mysqli_fetch_row($query);
                  $nome_entrega        = $mostra[0];
               }
               $_SESSION['nome_entrega_m']=$nome_entrega;
               
               //Conta o número de entregas do entregador para mostrar no relatório

               $contagem=mysqli_query($con,"SELECT COUNT(n_hawb) AS numero FROM remessa
               WHERE nu_lista='$v_numero_lista'");
               $total = mysqli_num_rows($contagem);
               for($i=0; $i<$total; $i++){
                 $dados = mysqli_fetch_row($contagem);
                 $numero      =$dados[0];
               }
               $_SESSION['numero_m']   =$numero;
               require_once("gera_lista.php");
               $resp_grava ='';
          break;

          default:
    }
	
    include ("campo_calendario.php");
?>

<html>
  <title>elabora_lista_leitora.php</title>
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
   <script type="text/javascript">
       function salva(campo){
            cadastro.submit()
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
    <body topmargin="0" leftmargin="0" rightmargin="0" bottommargin="0" marginheight="0" marginwidth="0" bgcolor="#FFFFFF">
     <table border="0" width="100%" bgcolor="#000000" cellspacing="0" cellpadding="0">
      <tr>
        <td width="20%" height="100" background="img/topleft.jpg"></td>
         <td width="658" height="110"> <img border="0" src="img/cabecalho_free_jazz.jpg" width="890" height="115" border="0"></td>
        <td width="15%" height="110">
        <p align="right"><img border="0" src="img/topright.jpg" width="160" height="110" border="0"></td>
     </tr>
    </table>
    <table border="0" width="100%" cellspacing="0" cellpadding="0" background="img/blue.jpg" align="center">
     <tr>
       <td width="50%">
         <p align="left"><font face="Arial" size="2" color="#FFFFFF"><b>Sistema de Gerenciamento da Logística de Encomendas</b></font></td>
       <td width="50%">
         <p align="right"><font face="Arial" size="2" color="#FFFFFF"><b>Elabora Lista de Entrega Com Leitora</b></font></td>
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
   <form method="POST" name="cadastro" action="elabora_lista_leitora.php" border="20">
      <table width="50%" border="1" cellpadding="5" cellspacing="0" bordercolor="#4169E1" align="center">
         <tr>
          <td><b>Data cadastro :</b></td>
          <td>
            <?php $dt_lista   =$_SESSION['dt_lista_m'];?>
            <input type="text" name="dt_lista" value ="<?php echo "$dt_lista";?>" size="12" maxlength="12" id="dt_lista">
            <input TYPE="button" NAME="btndt_lista" VALUE="..." Onclick="javascript:popdate('document.cadastro.dt_lista','pop1','150',document.cadastro.dt_lista.value)">
            <span id="pop1" style="position:absolute"></span>
          </td>
        </tr>
        <tr>
            <td><b>Entregador :</b></td>
            <td>
			 <?php
			      //PEGA VARIAVEIS GLOBAIS SOBRE O USUARIO DO SISTEMA
				  //variavel que indica se o usuario é administrador do sistema.
				  if(isset($_SESSION['adm_m'])) {
                     $adm          =$_SESSION['adm_m'];
				  }
				  else {
					 $adm          =''; 
				  }
				  
				  //variavel que indica o estado em que esta lotado o usuario.
				  if(isset($_SESSION['estado_m'])) {
                      $estado       =$_SESSION['estado_m'];
				  }
				  else {
				      $estado       ='';
				  }	
                  
				  //variavel que contem a matricula do usuario de sistema.
                  if(isset($_SESSION['matricula_m'])) {
                      $matricula_m  =$_SESSION['matricula_m'];
				  }
				  else {
				      $matricula_m  ='';
				  }	  				  
                  
				  //verifica se o usuario é adminsitrador do sistema
                  if ($adm=='S') {
					   if(isset($_SESSION['entregador_m'])) {
                          $entregador   =$_SESSION['entregador_m'];
				       }
					   else {
						  $entregador   ='';  
					   }
                       ?>
                       <select name="entregador">
                       <?php
                       $resultado ="SELECT cnpj_cpf,nome FROM cli_for WHERE ativo='S' and catego='F'";
                       $resul = mysqli_query($con,$resultado) or die ("Não foi possivel acessar o banco");
                       while ( $linha = mysqli_fetch_array($resul)) {
                          $select = $entregador == $linha[0] ? "selected" : "";
                          echo "<option value=\"". $linha[0] . "\" $select>" . $linha[1] . "</option>";
                       }
                   }
                   if ($adm=='E') {
					   
					   //pega o UF do entregador no cadastro de pessoa, quando for pessoal da propria FreeJazz
					   $matricula_m  =$_SESSION['matricula_m'];  
	                   $entrega ="SELECT estado FROM pessoa WHERE matricula ='$matricula_m'";
					   $query_e = mysqli_query($con,$entrega) or die ("Não foi possivel acessar o banco");
                       $total_e = mysqli_num_rows($query_e);
					   if($total_e > 0) {
						  for($ic=0; $ic<$total_e; $ic++){
                             $mostra = mysqli_fetch_row($query_e);
                             $uf_entre       = $mostra[0];
                          }							 
					   }
					   else {
						  $uf_entre  = ''; 
					   }
					   
                       ?>
                       <select name="entregador">
                       <?php
                       $resultado ="SELECT cnpj_cpf,nome FROM cli_for WHERE ((ativo='S') AND (catego='F') AND (uf='$uf_entre'))";
                       $resul = mysqli_query($con,$resultado) or die ("Não foi possivel acessar o banco");
                       while ( $linha = mysqli_fetch_array($resul)) {
                           $select = $entregador == $linha[0] ? "selected" : "";
                        echo "<option value=\"". $linha[0] . "\" $select>" . $linha[1] . "</option>";
                       }
                   }
                   if ($adm=='P') {
						 //pega o cpf do entregador no cadastro de pessoa, quando for pessoal da propria FreeJazz
					     $matricula_m  =$_SESSION['matricula_m']; 			 
	                     $entrega ="SELECT empresa FROM pessoa WHERE matricula ='$matricula_m'";
					     $query_e = mysqli_query($con,$entrega) or die ("Não foi possivel acessar o banco");
                         $total_e = mysqli_num_rows($query_e);
					     if($total_e > 0) {
						    for($ic=0; $ic<$total_e; $ic++){
                               $mostra = mysqli_fetch_row($query_e);
                               $entregador       = $mostra[0];
                            }							 
					     }
					     else {
						    $entregador  = ''; 
					     }
						 ?>
						 <select name="entregador">
						 <?php
						 $resultado ="SELECT cnpj_cpf,nome FROM cli_for WHERE cnpj_cpf ='$entregador' ";
						 $resul = mysqli_query($con,$resultado) or die ("Não foi possivel acessar o banco");
						 while ( $linha = mysqli_fetch_array($resul)) {
							$select = $entregador == $linha[0] ? "selected" : "";
							echo "<option value=\"". $linha[0] . "\" $select>" . $linha[1] . "</option>";
						 }
                   }

                   ?>
                   </select>
                  <input name="seleciona" type="submit" value="Selecionar">
            </td>
        </tr>
        <tr>
           <?php
              if(isset($_SESSION['numero_lista_m'])) {	   
		          $v_nu_lista  =$_SESSION['numero_lista_m'];
			  }
			  else {
				  $v_nu_lista  ='';
			  }
			  
		   ?>
           <td><b>Número Lista:</b></td>
           <td><input type="text" name="n_lista" class="campo" value ="<?php echo "$v_nu_lista";?>" id="n_lista"><input name="lista" type="submit" value="Gera Número Lista"></td>
		</tr>
       </table>
      <?php
	   if(isset($_POST['cod_barra'])) {
          $codi_barra   =$_POST['cod_barra'];
	   }
	   else {
		  $codi_barra  =''; 
	   }
       if ($codi_barra<>'') {
		   // verifica se HAWB ja faz parte de alguma lista de entrega
		   $ver_lista="SELECT dt_lista,nu_lista FROM remessa
           WHERE cod_barra='$codi_barra'";
           $query_li = mysqli_query($con,$ver_lista) or die ("Não foi possivel acessar o banco");
           $total_li = mysqli_num_rows($query_li);
		   for($ici=0; $ici<$total_li; $ici++){
			  $row = mysqli_fetch_row($query_li);
			  $dt_li        = $row[0];
			  $nu_li        = $row[1];
		   }
		   if($dt_li<>'0000-00-00' and $dt_li<>'' and $nu_li<>'' and $nu_li<>0){
			   ?>
              <script language="javascript"> window.location.href=("elabora_lista_leitora.php")
                 alert('HAWB ja consta de lista elaborada. Verifique!');
              </script>
              <?php
           } else {			
			   $entregador = $_SESSION['entregador_m'];
			   If ($entregador =='') {
				  ?>
				  <script language="javascript"> window.location.href=("elabora_lista_leitora.php")
					 alert('Você precisa selecionar um entregador e clicar no botão SELECIONAR!');
				  </script>
				  <?php
			   }
			   $v_nu_lista  =$_SESSION['numero_lista_m'];
			   If ($v_nu_lista =='') {
				  ?>
				  <script language="javascript"> window.location.href=("elabora_lista_leitora.php")
					 alert('Você precisa gerar um número de lista!');
				  </script>
				  <?php
			   }
			   else {
				   $_SESSION['cod_barra_g'] =$codi_barra;
				   $resp_grava='';
				   
				   $verifi="SELECT controle,n_tentativas,n_hawb,entregador,dt_lista,dt_remessa FROM remessa
				   WHERE cod_barra='$codi_barra'";
				   $query = mysqli_query($con,$verifi) or die ("Não foi possivel acessar o banco");
				   $total = mysqli_num_rows($query);

				   //Verifica se a hawb foi lançada no sistema

				   If ($total == 0 ) {
					  $codi_barra='';
					  ?>
					  <script language="javascript"> window.location.href=("elabora_lista_leitora.php")
					   alert('HAWB não lançada no sistema! Verifique.');
					  </script>
					  <?php
				   }
				   else {
					   for($ic=0; $ic<$total; $ic++){
						 $mostra = mysqli_fetch_row($query);
						 $controle       = $mostra[0];
						 $n_tentativas   = $mostra[1];
						 $n_hawb         = $mostra[2];
						 $levador        = $mostra[3];
						 $data_li        = $mostra[4];
						 $dt_remessa     = $mostra[5];
					   }
					   $levador=trim($levador);
					   $data_li=trim($data_li);
					   $n_tentativas              =$n_tentativas+1;
					   $_SESSION['tentativas_m']  =$n_tentativas;
					   $_SESSION['controle_m']    =$controle;
					   $_SESSION['n_hawb_m']      =$n_hawb;
					   $v_dt_remessa_co           = strtotime($dt_remessa);
					   $v_dt_lista                =$_SESSION['v_dt_lista_m'];
					   $dt_lista_co               =$_SESSION['dt_lista_co_m'];

					   If ($data_li=='0000-00-00') {
						   if ($dt_lista_co >= $v_dt_remessa_co) {
							   ///Grava o movimento
							   $entregador     =$_SESSION['entregador_m'];
							   $v_dt_lista     =$_SESSION['v_dt_lista_m'];
							   $n_tentativas   =$_SESSION['tentativas_m'];
							   $controle       =$_SESSION['controle_m'];
							   //$codi_cli       =$_SESSION['codi_cli_m'];
							  // $tipo_servi     =$_SESSION['tipo_servi_m'];
							   $v_nu_lista     =$_SESSION['numero_lista_m'];
							   $estatus        ='BIP2';

							   $alteracao = "UPDATE remessa SET entregador='$entregador',dt_lista='$v_dt_lista',
							   n_tentativas='$n_tentativas',nu_lista='$v_nu_lista',estatus='$estatus'
							   WHERE controle='$controle'";
							   if (mysqli_query($con,$alteracao)) {
								  //Atualiza a tabela log_operação sistema
								  $programa     =$_SESSION['programa_m'];
								  $matricula_m  =$_SESSION['matricula_m'];
								  $hora         = date ('H:i:s');
								  $data         = date('Y-m-d');
								  $n_hawb       =$_SESSION['n_hawb_m'];
								  $codi_barra_g =$_SESSION['cod_barra_g'];
								  $inclui="INSERT INTO log_operacao_sistema(matricula,tarefa_executada,data,hora,rotina,n_hawb)
								  VALUES('$matricula_m','Elabora Lista com leitora','$data','$hora','$programa','$n_hawb')";
								  mysqli_query($con,$inclui);
								  $resp_grava="Inclusão bem sucedida";

								  //////////////////Atualiza a tabela de histórico HAWB /////////////////////////////////
								  $atualiza="INSERT INTO controle_reentrega (n_hawb,dt_evento,ocorrencia,cod_barra,ordem)
								  VALUES('$n_hawb','$v_dt_lista','Em rota de entrega.','$codi_barra_g','2')";
								  mysqli_query($con,$atualiza);
								  $codi_barra          ='';
								  $controle            ='';
								  $entrega             ='';
								  //$c_data_li           ='';
								  //unset($_SESSION['n_data_li_m']);
								  unset($_SESSION['tentativas_m']);
								  unset($_SESSION['controle_m']);
								  unset($_SESSION['n_hawb_m']);
								  unset($_SESSION['cod_barra_g']);
								  $v_numero_lista  =$_SESSION['numero_lista_m'];
							   }
							   else {
								  $resp_grava="Problemas na Inclusão";
							   }
						   }
						   else {
							   $codi_barra  ='';
							   ?>
							   <script language="javascript"> window.location.href=("elabora_lista_leitora.php")
								  alert('Data da lista é inferior a data da HAWB !');
							   </script>
							   <?php
						   }
					   }
					   else {
						 // $resp_grava="HAWB já em lista. Verifique.";
					   }
				   }
			   }
		   }
       }
       //Mostra as remessas do entregador selecionada
	   if(isset($_SESSION['nome_entregador_m'])) {
           $nome_entregador  =$_SESSION['nome_entregador_m'];
	   }
	   else {
		   $nome_entregador  =''; 
	   }
       //$c_data_li  =$_SESSION['n_data_li_m'];
       //echo "<p>Entregador :$c_data_li";
	   ?>
       <table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#4169E1" align="center">
         <tr>
           <td colspan="8" align="center"><font face="arial" size="2"><b>LISTA ENTREGA DE :<?php echo "$nome_entregador";?></b></font></td>
         </tr>
         <tr>
           <td width="2%" align="center"><b>N.</b></td>
           <td width="5%" align="center"><b>N. HAWB</b></td>
           <td width="24%" align="center"><b>NOME</b></td>
           <td width="24%" align="center"><b>RUA</b></td>
           <td width="5%" align="center"><b>NUMERO</b></td>
           <td width="20%" align="center"><b>BAIRRO</b></td>
           <td width="15%" align="center"><b>CIDADE</b></td>
           <td width="4%" align="center"><b>LST</b></td>
         </tr>
        <?php
         if(isset($_SESSION['entregador_m'])) {
            $entregador     =$_SESSION['entregador_m'];
	     }
		 else {
			$entregador     =''; 
		 }
		 if(isset($_SESSION['numero_lista_m'])) {
            $v_nu_lista     = $_SESSION['numero_lista_m'];
		 }
		 else {
			$v_nu_lista     =''; 
		 }
         $resultado = mysqli_query ($con,"SELECT n_hawb,nome_desti,rua_desti,
         numero_desti,bairro_desti,cidade_desti,nu_lista
         FROM remessa
         WHERE ((entregador='$entregador')
         AND (nu_lista='$v_nu_lista')
         AND (entregador<>'') and (nu_lista<>''))");
         $total = mysqli_num_rows($resultado);
         $ni=0;
         for($i=0; $i<$total; $i++){
          $dados = mysqli_fetch_row($resultado);
          $n_hawb            =$dados[0];
          $nome_desti        =$dados[1];
          $rua_desti         =$dados[2];
          $numero_desti      =$dados[3];
          $bairro_desti      =$dados[4];
          $cidade_desti      =$dados[5];
          $n_lista           =$dados[6];
          $ni=$i+1;
          echo "<tr>";
            echo "<td width=\"2%\" align=\"left\"><font size=\"1\" face=\"arial\">$ni</font></td>";
            echo "<td width=\"5%\" align=\"left\"><font size=\"1\" face=\"arial\">$n_hawb</font></td>";
            echo "<td width=\"24%\"><font size=\"1\" face=\"arial\">$nome_desti</font></td>";
            echo "<td width=\"24%\"><font size=\"1\" face=\"arial\">$rua_desti</font></td>";
            echo "<td width=\"5%\"><font size=\"1\" face=\"arial\">$numero_desti</font></td>";
            echo "<td width=\"20%\"><font size=\"1\" face=\"arial\">$bairro_desti</font></td>";
            echo "<td width=\"15%\"><font size=\"1\" face=\"arial\">$cidade_desti</font></td>";
            echo "<td width=\"4%\"><font size=\"1\" face=\"arial\">$n_lista</font></td>";
         echo "</tr>";
       }
    ?>
    <tr>
     <td><INPUT type=button value="Reimprime Lista."
         onClick="window.open('reimprime_lista.php','janela_1',
         'scrollbars=yes,resizable=yes,width=1000,height=600' left='+(window.innerWidth-1000)/2+', top='+(window.innerHeight-600)/2))">
      </td>
      <td colspan="7">
        <div align="right">
         <input name="imprime" type="submit" value="Imprimir">
        </div>
      </td>
    </tr>
    <body leftmargin="10" topmargin="10" marginwidth="10" marginheight="10">
	<table width="50%" border="1" cellpadding="5" cellspacing="0" bordercolor="#4169E1" align="center">
       <tr>
           <?php $codi_barra='';?>
           <td align="center" colspan="3"><b>Codigo Barras:</b>
           <input type="text" name="cod_barra" id="cod_barra" value ="<?php echo "$codi_barra";?>" size="40" maxlength="40" onChange="salva(this)"></td>
       </tr>
       <!-- Coloca foco no primeiro campo codigo de barras do formulário -->
          <script language="JavaScript">
            document.getElementById('cod_barra').focus()
          </script>
       <tr>
           <td><b>Número da HAWB:</b></td>
           <td><input type="text" name="n_hawb" class="campo" id="n_hawb"><input name="grava" type="submit" value="Grava"></td></td>
	   </tr>
   	</table>
  </form>
  </div>
  <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
      <tr>
        <td color="white" width="100%" height="45" colspan="8" align="center"><b><font face="arial" size="5" color="red"><?php echo "$resp_grava";?><b></font></td>
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



