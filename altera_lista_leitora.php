<?php
  session_start();

   //carrega variaveis com dados para acessar o banco de dados

  $base_d     =$_SESSION['base_d'];
  $banco_d    =$_SESSION['banco_d'];
  $usuario_d  =$_SESSION['usuario_d'];
  $senha_d    =$_SESSION['senha_d'];

  $matricula_m  =$_SESSION['matricula_m'];
  $programa='029';
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
     <form method="POST" name="cadastro_2" action="elabora_lista_leitora.php" border="20" align="center">
         <tr>
            <td>
			 <?php
              echo "<center><Font size=\"2\" face=\"ARIAL\">Entregador..:</font>";
			 
              mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
              mysql_select_db($banco_d) or die ("Banco de dados inexistente");

              $resultado = mysql_query ("SELECT matricula,nome
              FROM pessoa");
              echo "<select name='entregador' class='caixa' align=\"center\">\n";
              while($linha = mysql_fetch_row($resultado))  {
                 printf("<option value='$linha[0]'>$linha[0] - $linha[1] </option>\n");
                 }
              ?>
              <script language="javascript">
                 var _entregador = function( itemSelecionar){
                  entregador = document.getElementById("entregador");
                  for ( i =0; i < _entregador.length; i++){
                    _entregador[i].selected = _entregador[i].value == itemSelecionar ? true : false;
                  }
                 }
                 Seleciona(<?php echo "$entregador";?>);
             </script>
             <input name="seleciona" type="submit" value="Selecione"></td>
            </td>
        </tr>
     </form>
   </table>
   <table width="80%" heigth="300">
     <form method="POST" name="cadastro_1" action="elabora_lista_leitora.php" border="20" align="center">
         <tr>
           <td align="center" colspan="3"><b>Codigo Barras:</b>
           <input type="text" name="codi_barra" id="codi_barra" value ="<?php echo "$codi_barra";?>" size="60" maxlength="60" onkeyup="salva(this)" onkeydown="return retornoCodbar(event, this.value)"></td>
           <!--<input name="mostra" type="submit" value="Mostra"></td>-->
         </tr>
         <?php if ($foco==0) { ?>
          <script language="JavaScript">
            <!-- Coloca foco no primeiro campo codigo de barras do formulário -->
            document.getElementById('codi_barra').focus()
          </script>
         <?php } ?>
     </form>
   </table>
  <?php
     include ("campo_calendario.php");

            $codi_barra     =$_POST['codi_barra'];

        if ($codi_barra<>'') {
        
             $resp_grava='';
             $con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
             $res = mysql_select_db($banco_d) or die ("Banco de dados inexistente");

             $verifi="SELECT controle,nome_desti,cep_desti,rua_desti,numero_desti,
             comple_desti,bairro_desti,cidade_desti,estado_desti,entregador
             FROM remessa WHERE cod_barra='$codi_barra'";
             $query = mysql_db_query($banco_d,$verifi,$con) or die ("Não foi possivel acessar o banco");
             $total = mysql_num_rows($query);

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
               $entregador_atu = $mostra[9];
               $dt_lista       = date('d/m/Y');

               $_SESSION['controle']  =$controle;
             }
             
             //Pega nome entregador na tabela pessoas

             mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
             mysql_select_db($banco_d) or die ("Banco de dados inexistente");

             $resultado = mysql_query ("SELECT nome
             FROM pessoa
             WHERE matricula='$entregador_atu'");
             $total = mysql_num_rows($resultado);

             for($i=0; $i<$total; $i++){
                $dados = mysql_fetch_row($resultado);
                $nome_entregador_atu      =$dados[0];
             }
             $_SESSION['nome_entregador_atu_m']   =$nome_entregador_atu;
        }
        
     switch (get_post_action('grava','seleciona')) {
         case 'seleciona':
             $entregador_n                 =$_POST['entregador'];
             $_SESSION['entregador_m']   =$entregador_n;
             
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

         case 'grava':
             $controle        =$_SESSION['controle'];
             $entregador      =$_SESSION['entregador_m'];
             $dt_lista        =$_SESSION['dt_lista'];

             $dt_lista  = explode("/",$dt_lista);
             $v_dt_lista = $dt_lista[2]."-".$dt_lista[1]."-".$dt_lista[0];

             $con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
             $res = mysql_select_db($banco_d) or die ("Banco de dados inexistente");

             $alteracao = "UPDATE remessa SET entregador='$entregador',dt_lista='$v_dt_lista'
             WHERE controle='$controle'";

             if (mysql_db_query($banco_d,$alteracao,$con)) {
                $resp_grava="Alteração bem sucedida";

                $codi_barra          ='';
                $nome_desti          ='';
                $cep_desti           ='';
                $rua_desti           ='';
                $numero_desti        ='';
                $comple_desti        ='';
                $bairro_desti        ='';
                $cidade_desti        ='';
                $estado_desti        ='';
                $entregador_atu      ='';
                $nome_entregador_atu ='';
             }
             else {
                $resp_grava="Problemas na Alteração";
             }
            break;
         default:
     }
  ?>

  <body leftmargin="10" topmargin="10" marginwidth="10" marginheight="10">
  <form name="cadastro" action="elabora_lista_leitora.php" method="post">
	<table width="70%" border="1" cellpadding="5" cellspacing="0" bordercolor="#4169E1">
        <tr>
			<td><b>Entregador Atual :</b></td>
			<td><?php echo "$entregador_atu";?> - <?php echo "$nome_entregador_atu";?></td>
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
          <td>
            <input type="text" name="dt_lista" value ="<?php echo "$dt_lista";?>" size="12" maxlength="12" id="dt_lista">
            <input TYPE="button" NAME="btndt_lista" VALUE="..." Onclick="javascript:popdate('document.cadastro.dt_lista','pop1','150',document.cadastro.dt_lista.value)">
            <span id="pop1" style="position:absolute"></span>
          </td>
        </tr>
		<tr>
		  <td colspan="2">
		     <div align="right">
			   <input name="grava" type="submit" value="Gravar">
			 </div>
		  </td>
		</tr>
	</table>
	<?php
      $nome_entregador  =$_SESSION['nome_entregador_m'];
	?>
    <table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#4169E1">
      <tr>
        <td colspan="6" align="center"><font face="arial" size="2"><b>LISTA ENTREGA DE :<?php echo "$nome_entregador";?></b></font></td>
      </tr>
      <tr>
         <td width="5%" align="center"><b>CODIGO</b></td>
         <td width="25%" align="center"><b>NOME</b></td>
         <td width="25%" align="center"><b>RUA</b></td>
         <td width="5%" align="center"><b>NUMERO</b></td>
         <td width="20%" align="center"><b>BAIRRO</b></td>
         <td width="20%" align="center"><b>CIDADE</b></td>
         </tr>
      <?php
       $entregador   =$_SESSION['entregador_m'];
       
       mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
       mysql_select_db($banco_d) or die ("Banco de dados inexistente");

       $resultado = mysql_query ("SELECT codigo_desti,nome_desti,rua_desti,
       numero_desti,bairro_desti,cidade_desti
       FROM remessa
       WHERE ((entregador='$entregador')
       AND (recebedor='')
       AND (volta_lista='S'))");
       $total = mysql_num_rows($resultado);

       for($i=0; $i<$total; $i++){
          $dados = mysql_fetch_row($resultado);
          $codigo_desti      =$dados[0];
          $nome_desti        =$dados[1];
          $rua_desti         =$dados[2];
          $numero_desti      =$dados[3];
          $bairro_desti      =$dados[4];
          $cidade_desti      =$dados[5];
          
          echo "<tr>";
            echo "<td width=\"5%\" align=\"left\"><font size=\"1\" face=\"arial\">$codigo_desti</font></td>";
            echo "<td width=\"25%\"><font size=\"1\" face=\"arial\">$nome_desti</font></td>";
            echo "<td width=\"25%\"><font size=\"1\" face=\"arial\">$rua_desti</font></td>";
            echo "<td width=\"5%\"><font size=\"1\" face=\"arial\">$numero_desti</font></td>";
            echo "<td width=\"20%\"><font size=\"1\" face=\"arial\">$bairro_desti</font></td>";
            echo "<td width=\"20%\"><font size=\"1\" face=\"arial\">$cidade_desti</font></td>";
         echo "</tr>";
       }
     ?>
     <tr>
       <td colspan="6">
          <div align="right">
		     <input name="imprime" type="submit" value="Imprimir">
          </div>
       </td>
     </tr>
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

