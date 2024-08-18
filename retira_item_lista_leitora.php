<?php
  session_start();

   //carrega variaveis com dados para acessar o banco de dados

  $base_d     =$_SESSION['base_d'];
  $banco_d    =$_SESSION['banco_d'];
  $usuario_d  =$_SESSION['usuario_d'];
  $senha_d    =$_SESSION['senha_d'];

  $matricula_m  =$_SESSION['matricula_m'];
  $programa='036';
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
          <script language="javascript"> window.location.href=("entrada.php")
            alert('Você não está autorizado a acessar esta rotina.');
          </script>
       <?php
  }
  $data       = date('Y-m-d');
  $_SESSION['data_m']   =$v_data;

  function get_post_action($name) {
    $params = func_get_args();
    foreach ($params as $name) {
        if (isset($_POST[$name])) {
            return $name;
        }
    }
  }

  switch (get_post_action('retira','seleciona','imprime','mostra')) {
         case 'seleciona':
             unset ($_SESSION['entregador_m']);
             $entregador                 =$_POST['entregador'];
             $_SESSION['entregador_m']   =$entregador;

             //Pega nome entregador na tabela pessoas

             mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
             mysql_select_db($banco_d) or die ("Banco de dados inexistente");

             $resultado = mysql_query ("SELECT nome
             FROM pessoa
             WHERE matricula='$entregador'");
             $total = mysql_num_rows($resultado);

             for($i=0; $i<$total; $i++){
                $dados = mysql_fetch_row($resultado);
                $nome_entregador      =$dados[0];
             }
             $_SESSION['nome_entregador_m']   =$nome_entregador;
         break;

         case 'mostra':
              $n_hawb     =$_POST['n_hawb'];
              if ($n_hawb<>'') {
                 $entregador   =$_SESSION['entregador_m'];
                 $resp_grava='';

                 $con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
                 $res = mysql_select_db($banco_d) or die ("Banco de dados inexistente");

                 $verifi="SELECT controle,nome_desti,cep_desti,rua_desti,numero_desti,
                 comple_desti,bairro_desti,cidade_desti,estado_desti,date_format(dt_lista,'%d/%m/%Y'),n_hawb
                 FROM remessa
                 WHERE ((entregador='$entregador')
                 AND (n_hawb='$n_hawb'))";
                 $query = mysql_db_query($banco_d,$verifi,$con) or die ("Não foi possivel acessar o banco");
                 $total = mysql_num_rows($query);

                 //Verifica se omovimento foi lançado

                 If ($total == 0) {
                    $codi_barra='';
                    ?>
                     <script language="javascript"> window.location.href=("retira_item_lista_leitora.php")
                       alert('HAWB não faz parte da lista do entregador informado ou ainda não foi entregue! Verifique.');
                     </script>
                    <?php
                 }
                 else {
                    for($ic=0; $ic<$total; $ic++){
                       $mostra = mysql_fetch_row($query);
                       $controle       = $mostra[0];
                       $nome_desti     = $mostra[1];
                       $cep_desti      = $mostra[2];
                       $rua_desti      = $mostra[3];
                       $numero_desti   = $mostra[4];
                       $comple_desti   = $mostra[5];
                       $bairro_desti   = $mostra[6];
                       $cidade_desti   = $mostra[7];
                       $estado_desti   = $mostra[8];
                       $dt_lista       = $mostra[9];
                       $n_hawb         = $mostra[10];

                       $_SESSION['controle_m']  =$controle;
                       $_SESSION['n_hawb_m']    =$n_hawb;
                    }
                 }
              }
              else {
                 ?>
                 <script language="javascript"> window.location.href=("retira_item_lista_leitora.php")
                     alert('Digite um número de HAWB válido.');
                 </script>
                 <?php
              }

         break;
         
         case 'retira':
             $controle        =$_SESSION['controle_m'];
             $entregador      ='';
             $dt_lista        ='0000-00-00';

             $con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
             $res = mysql_select_db($banco_d) or die ("Banco de dados inexistente");

             $alteracao = "UPDATE remessa SET entregador='$entregador',dt_lista='$dt_lista'
             WHERE controle='$controle'";

             if (mysql_db_query($banco_d,$alteracao,$con)) {
             
                //Atualiza a tabela log_operação sistema

                $programa     =$_SESSION['programa_m'];
                $matricula_m  =$_SESSION['matricula_m'];
                $hora         = date('G:H:s');
                $data         = date('Y-m-d');
                $n_hawb       =$_SESSION['n_hawb_m'];

                $v_data  =$_SESSION['data_m'];

                $con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
                $res = mysql_select_db($banco_d) or die ("Banco de dados inexistente");

                $inclui="INSERT INTO log_operação_sistema(matricula,tarefa_executada,data,hora,rotina,n_hawb)
                   values('$matricula_m','Retira hawb da lista','$data','$hora',
                   '$programa','$n_hawb')";
                mysql_db_query($banco_d,$inclui,$con);
             
             //////////////////Atualiza a tabela de histórico HAWB /////////////////////////////////
                $atualiza="INSERT INTO controle_reentrega (n_hawb,dt_evento,ocorrencia)
                VALUES('$n_hawb','$v_data','Retirada a HAWB da lista de entrega.')";
                mysql_db_query($banco_d,$atualiza,$con);

                $resp_grava="Foi Retirado da lista com sucesso";

                $codi_barra          ='';
                $nome_desti          ='';
                $cep_desti           ='';
                $rua_desti           ='';
                $numero_desti        ='';
                $comple_desti        ='';
                $bairro_desti        ='';
                $cidade_desti        ='';
                $estado_desti        ='';
                $dt_lista            ='';
             }
             else {
                $resp_grava="Problemas ao retirar da Lista.";
             }
            break;

         case 'imprime':
               $entregador   =$_SESSION['entregador_m'];
               //Conta o número de entregas do entregador para mostrar no relatório
               mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
               mysql_select_db($banco_d) or die ("Banco de dados inexistente");
               $contagem=mysql_query("SELECT COUNT(n_hawb) AS numero FROM remessa
               WHERE ((entregador='$entregador')
               AND (entregador<>'')
               AND (recebedor=''))");
               $total = mysql_num_rows($contagem);
               for($i=0; $i<$total; $i++){
                 $dados = mysql_fetch_row($contagem);
                 $numero      =$dados[0];
               }
               $_SESSION['numero_m']   =$numero;
               require_once("gera_lista.php");
               gera_lista();
         break;
         default:
  }


?>
<html>
  <title>retira_item_lista_leitora.php</title>
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
            cadastro_1.submit()
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
         <p align="right"><font face="Arial" size="2" color="#FFFFFF"><b>Elabora Lista de Entrega Com Leitora</b></font></td>
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
   <table width="80%" heigth="300">
     <form method="POST" name="cadastro" action="retira_item_lista_leitora.php" border="20" align="center">
         <tr>
            <td>
			 <?php
              echo "<center><Font size=\"2\" face=\"ARIAL\">Entregador..:</font>";
              $entregador   =$_SESSION['entregador_m'];
              mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
              mysql_select_db($banco_d) or die ("Banco de dados inexistente");
              ?>
               <select name="entregador">
              <?php
                $resultado ="SELECT matricula,nome FROM pessoa";
                $resul = mysql_db_query($banco_d,$resultado,$con) or die ("Não foi possivel acessar o banco");
                while ( $linha = mysql_fetch_array($resul)) {
                    $select = $entregador == $linha[0] ? "selected" : "";
                    echo "<option value=\"". $linha[0] . "\" $select>" . $linha[1] . "</option>";
               }
              ?>
            </select>
             <input name="seleciona" type="submit" value="Selecionar"></td>
            </td>
        </tr>
     </table>
    </form>
     <?php
        $codi_barra     =$_POST['codi_barra'];
        if ($codi_barra<>'') {
             $entregador   =$_SESSION['entregador_m'];
             $resp_grava='';

             $con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
             $res = mysql_select_db($banco_d) or die ("Banco de dados inexistente");

             $verifi="SELECT controle,nome_desti,cep_desti,rua_desti,numero_desti,
             comple_desti,bairro_desti,cidade_desti,estado_desti,date_format(dt_lista,'%d/%m/%Y')
             FROM remessa
             WHERE ((entregador='$entregador')
             AND (cod_barra='$codi_barra'))";
             $query = mysql_db_query($banco_d,$verifi,$con) or die ("Não foi possivel acessar o banco");
             $total = mysql_num_rows($query);

             //Verifica se omovimento foi lançado

             If ($total == 0) {
                $codi_barra='';
                ?>
                 <script language="javascript">
                   alert('HAWB não faz parte da lista do entregador informado ou ainda não foi entregue! Verifique.');
                 </script>
                <?php
             }
             else {
                for($ic=0; $ic<$total; $ic++){
                   $mostra = mysql_fetch_row($query);
                   $controle       = $mostra[0];
                   $nome_desti     = $mostra[1];
                   $cep_desti      = $mostra[2];
                   $rua_desti      = $mostra[3];
                   $numero_desti   = $mostra[4];
                   $comple_desti   = $mostra[5];
                   $bairro_desti   = $mostra[6];
                   $cidade_desti   = $mostra[7];
                   $estado_desti   = $mostra[8];
                   $dt_lista       = $mostra[9];

                   $_SESSION['controle_m']  =$controle;
                }
             }
        }
  ?>

  <body leftmargin="10" topmargin="10" marginwidth="10" marginheight="10">
  <form method="POST" name="cadastro_1" action="retira_item_lista_leitora.php" border="20" align="center">
	<table width="70%" border="1" cellpadding="5" cellspacing="0" bordercolor="#4169E1">
         <tr>
           <td align="center" colspan="3"><b>Codigo Barras:</b>
           <input type="text" name="codi_barra" id="codi_barra" value ="<?php echo "$codi_barra";?>" size="60" maxlength="60" onChange="salva(this)"><font color="red">(Use campo Númeroda HWAB,caso não tenha ocódigo de Barras.)</font></td>
         </tr>
          <script language="JavaScript">
            <!-- Coloca foco no primeiro campo codigo de barras do formulário -->
            document.getElementById('codi_barra').focus()
          </script>
         <tr>
           <td><b>Número da HAWB:</b></td>
           <td><input type="text" name="n_hawb" class="campo" id="n_hawb" value ="<?php echo "$n_hawb";?>"><input name="mostra" type="submit" value="Mostra"></td></td>
         </tr>
	     <tr>
			<td><b>Nome :</b></td>
			<td><?php echo "$nome_desti";?></td>
		</tr>
		<tr>
           <td><b>CEP:</b> </td>
           <td><?php echo "$cep_desti";?></td>
        </tr>
		<tr>
			<td><b>Rua:</b></td>
			<td><?php echo "$rua_desti";?></td>
		</tr>
		<tr>
			<td><b>Número:</b></td>
			<td><?php echo "$numero_desti";?></td>
		</tr>
		<tr>
			<td><b>Complemento :</b></td>
			<td><?php echo "$comple_desti";?></td>
		</tr>
		<tr>
			<td><b>Bairro:</b></td>
			<td><?php echo "$bairro_desti";?></td>
		</tr>
		<tr>
			<td><b>Cidade:</b></td>
			<td><?php echo "$cidade_desti";?></td>
		</tr>
        <tr>
           <td><b>Estado:</b></td>
           <td><?php echo "$estado_desti";?></td>
        </tr>
        <tr>
          <td><b>Data da Lista :</b></td>
          <td><?php echo "$dt_lista";?></td>
        </tr>
		<tr>
		  <td colspan="2">
		     <div align="right">
			   <input name="retira" type="submit" value="Retirar">
			 </div>
		  </td>
		</tr>
	</table>
	<?php
      $nome_entregador  =$_SESSION['nome_entregador_m'];
	?>
    <table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#4169E1">
      <tr>
        <td colspan="7" align="center"><font face="arial" size="2"><b>LISTA ENTREGA DE :<?php echo "$nome_entregador";?></b></font></td>
      </tr>
      <tr>
         <td width="2%" align="center"><b>N.</b></td>
         <td width="5%" align="center"><b>N. HAWB</b></td>
         <td width="24%" align="center"><b>NOME</b></td>
         <td width="24%" align="center"><b>RUA</b></td>
         <td width="5%" align="center"><b>NUMERO</b></td>
         <td width="20%" align="center"><b>BAIRRO</b></td>
         <td width="15%" align="center"><b>CIDADE</b></td>
         </tr>
      <?php
       $entregador   =$_SESSION['entregador_m'];
       
       mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
       mysql_select_db($banco_d) or die ("Banco de dados inexistente");

       $resultado = mysql_query ("SELECT n_hawb,nome_desti,rua_desti,
       numero_desti,bairro_desti,cidade_desti
       FROM remessa
       WHERE ((entregador='$entregador')
       AND (entregador<>'')
       AND (recebedor='')
       OR (volta_lista='S'))");
       $total = mysql_num_rows($resultado);
       $ni=0;
       for($i=0; $i<$total; $i++){
          $dados = mysql_fetch_row($resultado);
          $n_hawb            =$dados[0];
          $nome_desti        =$dados[1];
          $rua_desti         =$dados[2];
          $numero_desti      =$dados[3];
          $bairro_desti      =$dados[4];
          $cidade_desti      =$dados[5];
          $ni=$i+1;
          
          echo "<tr>";
            echo "<td width=\"2%\" align=\"left\"><font size=\"1\" face=\"arial\">$ni</font></td>";
            echo "<td width=\"5%\" align=\"left\"><font size=\"1\" face=\"arial\">$n_hawb</font></td>";
            echo "<td width=\"24%\"><font size=\"1\" face=\"arial\">$nome_desti</font></td>";
            echo "<td width=\"24%\"><font size=\"1\" face=\"arial\">$rua_desti</font></td>";
            echo "<td width=\"5%\"><font size=\"1\" face=\"arial\">$numero_desti</font></td>";
            echo "<td width=\"20%\"><font size=\"1\" face=\"arial\">$bairro_desti</font></td>";
            echo "<td width=\"15%\"><font size=\"1\" face=\"arial\">$cidade_desti</font></td>";
         echo "</tr>";
       }
     ?>
     <tr>
       <td colspan="7">
          <div align="right">
		     <input name="imprime" type="submit" value="Imprimir">
          </div>
       </td>
     </tr>
  </form>
  </div>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td color="white" align="center" width="900" height="45" colspan="4" ><?php echo "$resp_grava";?></td>
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

