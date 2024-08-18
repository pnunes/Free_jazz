<?php
  session_start();

   //carrega variaveis com dados para acessar o banco de dados

  $base_d     =$_SESSION['base_d'];
  $banco_d    =$_SESSION['banco_d'];
  $usuario_d  =$_SESSION['usuario_d'];
  $senha_d    =$_SESSION['senha_d'];

  $matricula_m  =$_SESSION['matricula_m'];
  $programa='004';
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
  <title>baixa_remessa.php</title>
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
    <body topmargin="0" leftmargin="0" rightmargin="0" bottommargin="0" marginheight="0" marginwidth="0" bgcolor="#FFFFFF">
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
         <p align="right"><font face="Arial" size="2" color="#FFFFFF"><b>Baixa Remessa Entregue</b></font></td>
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
     <form method="POST" name="cadastro_1" action="baixa_remessa.php" border="20" align="center">
         <tr>
           <td align="center" colspan="3"><b>Codigo Barras:</b>
           <input type="text" name="codi_barra" id="codi_barra" value ="<?php echo "$codi_barra";?>" size="60" maxlength="60" onkeyup="salva(this)" onkeydown="return retornoCodbar(event, this.value)">
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

         $codi_barra      =$_POST['codi_barra'];
       
         if ($codi_barra<>'') {
             $resp_grava='';
             $con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
             $res = mysql_select_db($banco_d) or die ("Banco de dados inexistente");

             $verifi="SELECT controle,nome_desti,cep_desti,rua_desti,numero_desti,comple_desti,bairro_desti,
             cidade_desti,estado_desti,recebedor,documento,parentesco,date_format(dt_entrega,'%d/%m/%Y'),
             hr_entrega,n_tentativas,volta_lista
             FROM remessa
             WHERE ((cod_barra='$codi_barra')
             AND(entregador<>''))";
             $query = mysql_db_query($banco_d,$verifi,$con) or die ("Não foi possivel acessar o banco");
             $total = mysql_num_rows($query);

             //Verifica se o movimento tem entregador definido

             If ($total == 0) {
                $codi_barra='';
                ?>
                 <script language="javascript">
                   alert('HAWB não entregador definido, portanto não podeter sido entregue.');
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
                   $recebedor      = $mostra[9];
                   $documento      = $mostra[10];
                   $parentesco     = $mostra[11];
                   $dt_entrega     = $mostra[12];
                   $hr_entrega     = $mostra[13];
                   $n_tentativa    = $mostra[14];
                   $codi_barra     = $mostra[15];
                   $volta_lista    = $mostra[16];

                   $_SESSION['controle']  =$controle;
                   $n_tentativa           =$n_tentativa+1;
                   $_SESSION['tentativa'] =$n_tentativa;
                }
             }
         }

       switch (get_post_action('grava')) {

         case 'grava':
             $controle        =$_SESSION['controle'];

             $recebedor      =$_POST['recebedor'];
             $documento      =$_POST['documento'];
             $parentesco     =$_POST['parentesco'];
             $dt_entrega     =$_POST['dt_entrega'];
             $hr_entrega     =$_POST['hr_entrega'];
             $n_tentativa    =$_SESSION['tentativa'];
             $ocorrencia     =$_POST['ocorrencia'];
             //$volta_lista    =$_POST['volta_lista'];

             $dt_entrega  = explode("/",$dt_entrega);
             $v_dt_entrega = $dt_entrega[2]."-".$dt_entrega[1]."-".$dt_entrega[0];

             $con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
             $res = mysql_select_db($banco_d) or die ("Banco de dados inexistente");

             $ver = "SELECT volta_lista FROM ocorrencia WHERE codigo='$ocorrencia'";
             $query = mysql_db_query($banco_d,$ver,$con) or die ("Não foi possivel acessar o banco");
             $total = mysql_num_rows($query);

             for($ic=0; $ic<$total; $ic++){
               $mostra = mysql_fetch_row($query);
               $volta_lista       = $mostra[0];
             }
             
             //Verifica se foram feitas 3 tentativas de entrega, marca a remessa para devolução a origem - Marca com Ddedevolver
             if ($n_tentativa >= 3) {
                if ($recebedor=='') {
                   $volta_lista='D';
                }
             }
             //Se foi tentata a entrega e não foi conseguido,abaixo de três tentativas, volta para lista de entrega
             if ($n_tentativa < 3) {
                if ($recebedor=='') {
                   $volta_lista='S';
                }
             }
             //Se foi tentata de entrega logrou exito, considera servico concluido - Marca com F de faturar
             if ($recebedor<>'') {
                $volta_lista='F';
             }
             
             $alteracao = "UPDATE remessa SET recebedor='$recebedor',documento='$documento',
             parentesco='$parentesco',dt_entrega='$v_dt_entrega',hr_entrega='$hr_entrega',
             n_tentativas='$n_tentativa',ocorrencia='$ocorrencia',volta_lista='$volta_lista'
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
                $recebedor           ='';
                $documento           ='';
                $dt_entrega          ='';
                $hr_entrega          ='';
                $n_tentativas        ='';
                $volta_lista         ='';
             }
             else {
                $resp_grava="Problemas na Alteração";
             }
            break;
            default:
        }
    ?>

  <body leftmargin="10" topmargin="10" marginwidth="10" marginheight="10">
  <form name="cadastro" action="baixa_remessa.php" method="post">
	<table width="70%" border="1" cellpadding="5" cellspacing="0" bordercolor="#4169E1">
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
			<td><b>Nome Recebedor :</b></td>
			<td><input type="text" name="recebedor" value ="<?php echo "$recebedor";?>" size="40" maxlength="40" id="recebedor"></td>
		</tr>
		<tr>
			<td><b>Documento :</b></td>
			<td><input type="text" name="documento" value ="<?php echo "$documento";?>" size="30" maxlength="30" id="documento"></td>
		</tr>
		<tr>
			<td><b>Parentesco:</b></td>
			<td><input type="text" name="parentesco" value ="<?php echo "$parentesco";?>" size="40" maxlength="40" id="parentesco"></td>
		</tr>
		<tr>
			<td><b>entregador:</b></td>
            <td>
			 <?php
              mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
              mysql_select_db($banco_d) or die ("Banco de dados inexistente");

              $resultado = mysql_query ("SELECT matricula,nome
              FROM pessoa");
              echo "<select name='entregador' class='caixa' align=\"left\">\n";
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
            </td>
        </tr>
        <tr>
			<td><b>Ocorrência :</b></td>
            <td>
			 <?php
              mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
              mysql_select_db($banco_d) or die ("Banco de dados inexistente");

              $resultado = mysql_query ("SELECT codigo,descricao
              FROM ocorrencia");
              echo "<select name='ocorrencia' class='caixa' align=\"left\">\n";
              while($linha = mysql_fetch_row($resultado))  {
                 printf("<option value='$linha[0]'>$linha[0] - $linha[1] </option>\n");
                 }
              ?>
              <script language="javascript">
                 var _ocorrencia = function( itemSelecionar){
                  ocorrencia = document.getElementById("ocorrencia");
                  for ( i =0; i < _ocorrencia.length; i++){
                    _ocorrencia[i].selected = _ocorrencia[i].value == itemSelecionar ? true : false;
                  }
                 }
                 Seleciona(<?php echo "$ocorrencia";?>);
             </script>
            </td>
        </tr>
        <tr>
          <td><b>Data entrega :</b></td>
          <td>
            <input type="text" name="dt_entrega" size="12" maxlength="12" id="dt_entrega">
            <input TYPE="button" NAME="btndt_entrega" VALUE="..." Onclick="javascript:popdate('document.cadastro.dt_entrega','pop1','150',document.cadastro.dt_entrega.value)">
            <span id="pop1" style="position:absolute"></span>
          </td>
        </tr>
        <tr>
          <td><b>hora entrega :</b></td>
          <td>
            <input type="text" name="hr_entrega" size="12" maxlength="12" id="hr_entrega">
          </td>
        </tr>
        <tr>
			<td><b>Tentativas de Entrega:</b></td>
			<td><input type="text" name="n_tentativas" value ="<?php echo "$n_tentativas";?>" size="1" maxlength="1" id="n_tentativas"></td>
		</tr>
		<tr>
          <td><b>Volta para Lista ? :</b></td>
          <td>
            <input type="text" name="volta_lista" value ="<?php echo "$volta_lista";?>" size="1" maxlength="1" id="volta_lista">
          </td>
        </tr>
        <?php if ($foco==1) { ?>
          <script language="JavaScript">
            <!-- Coloca foco no primeiro campo recebedor do formulário -->
            document.getElementById('recebedor').focus()
          </script>
         <?php } ?>
		<tr>
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

