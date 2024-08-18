<?php
  session_start();

   //carrega variaveis com dados para acessar o banco de dados

  $_SESSION['base_d']      ='localhost';
  
  //na internet
  $_SESSION['banco_d']     ='pnunes_vbueno_freejazz01';
  $_SESSION['usuario_d']   ='pnunes';
  $_SESSION['senha_d']     ='25185725';

  //$_SESSION['contar_m']=0;

  //no meu micro

  //$_SESSION['banco_d']     ='free_jazz';
  //$_SESSION['usuario_d']   ='root';
  //$_SESSION['senha_d']     ='nunesp';

  //Carrega as variáveis com os dados do banco aberto

  $base_d     =$_SESSION['base_d'];
  $banco_d    =$_SESSION['banco_d'];
  $usuario_d  =$_SESSION['usuario_d'];
  $senha_d    =$_SESSION['senha_d'];

  /*$matricula_m  =$_SESSION['matricula_m'];
  $programa='38';
  $_SESSION['programa_m']=$programa;


  $con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
  $res = mysql_select_db($banco_d) or die ("Banco de dados inexistente");

  $declara = "SELECT matricula,programa
  FROM permissoes
  WHERE ((matricula='$matricula_m') and (programa='$programa'))";

  $query = mysql_db_query($banco_d,$declara,$con) or die ("Não foi possivel acessar o banco");
  $achou = mysql_num_rows($query);

  If ($achou == 0 ) {
       ?>
       <!--   <script language="javascript"> window.location.href=("entrada.php")
            alert('Você não está autorizado a acessar esta rotina.');
          </script> -->
       <?php
 /* }
  else  {
    $foco =0;
  }*/
  
  $con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
  $res = mysql_select_db($banco_d) or die ("Banco de dados inexistente");
  
  function get_post_action($name) {
    $params = func_get_args();
    foreach ($params as $name) {
        if (isset($_POST[$name])) {
            return $name;
        }
    }
  }
  include ("campo_calendario.php");
?>
<html>
  <title>baixa_c.php</title>
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
   <script language="JavaScript">
      
       <!-- FUNÇÃO QUE VERIFICA SE CAMPOS FORAM PREENCHIDOS-->

        function validar(baixa) {
           var recebedor = cadastro.recebedor.value;
           var documento = cadastro.documento.value;
              if (recebedor == "") {
                 alert('O campo recebedor não foi preenchido! Verifique.');
                 cadastro.recebedor.focus();
                 return false;
              }
              if (documento == "") {
                 alert('O campo documento não foi preenchido! Verifique.');
                 cadastro.documento.focus();
                 return false;
              }
        }

   
       <!-- LE CAMPO DO CODIGO DE BARRA E SUMETE-->
   
       function salva(campo){
            cadastro.submit();
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
    <body  topmargin="0" leftmargin="0" rightmargin="0" bottommargin="0" marginheight="0" marginwidth="0" bgcolor="#FFFFFF">
    <table border="0" width="90%" cellspacing="0" cellpadding="0" background="img/blue.jpg">
     <tr>
       <td width="90%">
         <p align="center"><font face="Arial" size="4" color="#FFFFFF"><b>Sistema de Gerenciamento - Free Jazz - Baixa Remota de HAWB</b></font></td>
     </tr>
   </table>
   <?php
   switch (get_post_action('baixa','mostra')) {
         case 'baixa':
             $controle        =$_SESSION['controle_m'];
             $recebedor       =$_POST['recebedor'];
             $documento       =$_POST['documento'];
             $parentesco      ='01';
             $dt_entrega      =$_POST['dt_entrega'];
             $reentrega       ='N';
             
             $con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
             $res = mysql_select_db($banco_d) or die ("Banco de dados inexistente");

             $n_dt_entrega  = explode("/",$dt_entrega);
             $v_dt_entrega = $n_dt_entrega[2]."-".$n_dt_entrega[1]."-".$n_dt_entrega[0];

             $dt_lista    =$_SESSION['dt_lista_m'];
             
             $c_dt_lista    =StrToTime($dt_lista);
             $c_dt_entrega  =StrToTime($v_dt_entrega);
             
             if (($recebedor<>'') and ($documento<>'') and ($dt_entrega<>'') and ($dt_entrega<>'0000-00-00')){
                 if (($c_dt_lista <= $c_dt_entrega) and ($v_dt_entrega<>'0000-00-00')) {
                    $con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
                    $res = mysql_select_db($banco_d) or die ("Banco de dados inexistente");

                    $alteracao = "UPDATE remessa SET recebedor='$recebedor',documento='$documento',
                    parentesco='$parentesco',dt_entrega='$v_dt_entrega',reentrega='$reentrega',
                    ocorrencia='Serviço realizado com sucesso.',dt_baixa='$v_dt_entrega',reentrega='$reentrega'
                    WHERE controle='$controle'";

                    if (mysql_db_query($banco_d,$alteracao,$con)) {

                        //Atualiza a tabela de log de operaçoes no sistema
                        $n_hawb       =$_SESSION['n_hawb_m'];
                        $matricula_m  =$_SESSION['matricula_m'];
                        $data         = date('Y-m-d');
                        $hora         = date ('H:i:s');
                        $programa     =$_SESSION['programa_m'];

                        $con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
                        $res = mysql_select_db($banco_d) or die ("Banco de dados inexistente");

                    //////////////////Atualiza a tabela de ações no sistema /////////////////////////////////

                        $inclui="INSERT INTO log_operacao_sistema(matricula,tarefa_executada,data,hora,rotina,n_hawb)
                        VALUES('$matricula_m','Baixa HAWB pelo celular','$data','$hora','$programa','$n_hawb')";
                        mysql_db_query($banco_d,$inclui,$con);

                        $code_barra   =$_SESSION['cod_barra_m'];
                    //////////////////Atualiza a tabela de histórico HAWB /////////////////////////////////
                        $atualiza="INSERT INTO controle_reentrega (n_hawb,dt_evento,ocorrencia,cod_barra)
                        VALUES('$n_hawb','$v_dt_entrega','Serviço realizado com sucesso.','$code_barra')";
                        mysql_db_query($banco_d,$atualiza,$con);

                        $resp_grava="Baixa bem sucedida";

                        $codi_barra          ='';
                        $nome_desti          ='';
                        $volta_lista         ='';
                        $ocorrencia          ='';
                        $nome_desti          ='';
                        $n_hawb              ='';
                        $s_baixa             ='';
                        unset($_SESSION['controle_m']);
                        unset($_SESSION['cod_barra_m']);
                        $recebedor                 ='';
                        $documento                 ='';
                        $foco=0;

                        ?>
                        <!-- Coloca foco no primeiro campo codigo de barras do formulário -->
                        <script language="JavaScript">
                           document.getElementById('cod_barra').focus();
                        </script>
                        <?php
                    }
                    else {
                       $resp_grava="Problemas na Baixa";
                    }
                 }
                 else {
                    ?>
                    <script language="javascript"> window.location.href=("baixa_c.php")
                        alert('HAWB Sem (BIP 2) ou data da entrega (BIP 3)é menor que a da lista (BIP 2)! Verifique.');
                    </script>
                    <?php
                 }
             }
             else {
                ?>
                <script language="javascript"> window.location.href=("baixa_c.php")
                   alert('Os campos,data entrega, data baixa, nome e documento do recebedor devem ser preenchidos! Verifique');
                </script>
                <?php
             }
         break;

         case 'mostra':
              $n_hawb   =$_POST['n_hawb'];
              if (empty($n_hawb)) {
                  ?>
                  <script language="JavaScript">
                     document.getElementById('n_hawb').focus();
                  </script>
                  <?php
              }
              else {
                  $_SESSION['n_hawb_m']      =$n_hawb;
                  $resp_grava='';
                  
                  $con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
                  $res = mysql_select_db($banco_d) or die ("Banco de dados inexistente");

                  $verifi="SELECT controle,nome_desti,rua_desti,numero_desti,recebedor,dt_lista,cod_barra,documento
                  FROM remessa
                  WHERE n_hawb='$n_hawb'";
                  $query = mysql_db_query($banco_d,$verifi,$con) or die ("Não foi possivel acessar o banco");
                  $total = mysql_num_rows($query);

                  if ($total>0) {

                      for($ic=0; $ic<$total; $ic++){
                          $mostra = mysql_fetch_row($query);
                          $controle       = $mostra[0];
                          $nome_desti     = $mostra[1];
                          $rua_desti      = $mostra[2];
                          $numero_desti   = $mostra[3];
                          $recebedor      = $mostra[4];
                          $dt_lista       = $mostra[5];
                          $cod_barra      = $mostra[6];
                          $documento      = $mostra[7];
                          
                          $_SESSION['cod_barra_m']   =$cod_barra;
                          $_SESSION['dt_lista_m']    =$dt_lista;
                          $_SESSION['controle_m']    =$controle;

                          ?>
                          <!-- Coloca foco no primeiro campo codigo de barras do formulário -->
                          <script language="JavaScript">
                              document.getElementById('recebedor').focus();
                          </script>
                          <?php
                      }

                      //Verifica se omovimento foi entregue

                      If ($recebedor<>'') {
                         $n_hawb='';
                         ?>
                         <script language="javascript"> window.location.href=("baixa.php")
                            alert('HAWB já foi entregue! Verifique.');
                         </script>
                         <?php
                      }
                  }
                  else {
                      $n_hawb='';
                      ?>
                      <script language="javascript"> window.location.href=("baixa.php")
                         alert('HAWB não cadastrada no sistema! Verifique.');
                      </script>
                      <?php
                  }
              }
              
         break;
         default:
   }

  ?>
  <form name="cadastro" action="baixa.php" method="post">
   <div font size="0.2">
	<table width="90%" border="1" cellpadding="3" cellspacing="0" bordercolor="#4169E1">
       <tr>
           <td><font size="3" face="arial"><b>Número HAWB :</b></font></td>
           <td><font size="3" face="arial"><input type="text" name="n_hawb" value ="<?php echo "$n_hawb";?>" size="30" maxlength="30" id="n_hawb"><input name="mostra" type="submit" value="Busca Dados"></font></td>
       </tr>
        <!-- Coloca foco no primeiro campo codigo de barras do formulário -->
           <script language="JavaScript">
              document.getElementById('n_hawb').focus();
          </script>
	   <tr>
			<td><font size="3" face="arial"><b>Destino :</b></font></td>
			<td><font size="3" face="arial"><?php echo "$nome_desti";?></td>
	   </tr>
	   <tr>
			<td><font size="3" face="arial"><b>Endereço :</b></font></td>
			<td><font size="3" face="arial"><?php echo "$rua_desti - $numero_desti";?></font></td>
	   </tr>
       <tr>
           <td><font size="3" face="arial"><b>Nome Recebedor :</b></font></td>
           <td><font size="3" face="arial"><input type="text" name="recebedor" value ="<?php echo "$recebedor";?>" size="40" maxlength="40" id="recebedor"></font></td>
       </tr>
       <tr>
           <td><font size="3" face="arial"><b>Documento Recebedor :</b></font></td>
           <td><font size="3" face="arial"><input type="text" name="documento" value ="<?php echo "$documento";?>" size="30" maxlength="30" id="documento"></font></td>
       </tr>
       <tr>
          <td><font size="3" face="arial"><b>Data da entrega :</b></font></td>
          <td>
            <input type="text" name="dt_entrega" value ="<?php echo "$dt_entrega";?>" size="12" maxlength="12" id="dt_entrega">
            <input TYPE="button" NAME="btndt_entrega" VALUE="..." Onclick="javascript:popdate('document.cadastro.dt_entrega','pop1','150',document.cadastro.dt_entrega.value)">
            <span id="pop1" style="position:absolute"></span>
          </td>
       </tr>
       <tr>
          <td>
             <div align="left">
                 <a href="Javascript:parent.parent.window.close();"><img src="img/sair.jpg" border="none"></a>
             </div>
          </td>
		  <td>
             <div align="right">
			   <font size="3" face="arial"><input name="baixa" type="submit" value="Baixar"></font>
	         </div>
		  </td>
		</tr>
	</table>
  </form>
  <table width="90%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td color="white" align="center" width="90%" height="15" colspan="8" ><?php echo "$resp_grava";?></td>
      </tr>
  </table>
  <table width="90%"  border="0" cellspacing="0" cellpadding="0" align="center">
    <tr>
      <td background="img/blue.jpg" width="90%" height="25px" colspan="2"><center><font face="arial" size="1" color="white">Todos Direitos Reservados a NUNESTEC Tecnologia</font></td>
    </tr>
  </table>
 </div>
</body>
</html>
