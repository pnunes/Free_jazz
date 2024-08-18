<?php

  session_start();

 //carrega variaveis com dados para acessar o banco de dados

  Include('conexao_free.php');

  function get_post_action($name) {
    $params = func_get_args();
    foreach ($params as $name) {
        if (isset($_POST[$name])) {
            return $name;
        }
    }
  }
 
  //verifica se o usuário esta habilitado para usar a rotina 
 
  $matricula_m  =$_SESSION['matricula_m'];
  $programa='079';
  $_SESSION['programa_m']=$programa;

  $confere = "SELECT matricula,programa
  FROM permissoes
  WHERE ((matricula='$matricula_m') and (programa='$programa'))";
  
  $query = mysqli_query($con,$confere) or die ("Não foi possivel acessar o banco - Rotina Cadastro Pessoas");
  $achou = mysqli_num_rows($query);
  If ($achou == 0 ) {
       ?>
          <script language="javascript"> window.location.href=("entrada.php")
            alert('Você não está autorizado a usar esta rotina. Fale com o Administrador do Sistema.');
          </script>
       <?php
  }
  else {
		$matricula       ='';
		$nome            ='';
		$ramal           ='';
		$funcao          ='';
		$ende_ele        ='';
		$usuario         ='';
		$senha           ='';
		$depto           ='';
		$telefone        ='';
		$adm             ='';
		$ativo           ='';
		$data_cada       ='';
		$empresa         ='';
		$estado          ='';
		$c_servico       ='';
        $resp_grava      ='';		
   }
?>

<html>
  <title>exclui_pessoa_cadastrada.php</title>
  <head>
  <body>
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
	<script language='Javascript'>


    function confirma_exclusao() {
       var confirma =confirm('Tem Certeza que quer excluir ?');
       if (confirma) {
          var nome ="exclui";
          document.location = "exclui_pessoa_cadastrada.php"; //executa a exclusão
       }
       else {
          document.location = "entrada.php"; //sair
       }
    }

   <!-- Funcao formata valor -->

   function Limpar(valor, validos) {
        var result = "";
        var aux;
        for (var i=0; i < valor.length; i++) {
          aux = validos.indexOf(valor.substring(i, i+1));
          if (aux>=0) {
            result += aux;
          }
        }
        return result;
     }

     function Formata(campo,tammax,teclapres,decimal) {
        var tecla = teclapres.keyCode;
        vr = Limpar(campo.value,"0123456789");
        tam = vr.length;
        dec=decimal
        if (tam < tammax && tecla != 8){ tam = vr.length + 1 ; }
          if (tecla == 8 )
             { tam = tam - 1 ; }
          if ( tecla == 8 || tecla >= 48 && tecla <= 57 || tecla >= 96 && tecla <= 105 ) {
             if ( tam <= dec )
                { campo.value = vr ; }
                if ( (tam > dec) && (tam <= 5) ){
                   campo.value = vr.substr( 0, tam - 2 ) + "," + vr.substr( tam - dec, tam ) ;
                }
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
            <p align="right"><font face="Arial" size="2" color="#FFFFFF"><b>Cadastro de Pessoas - Exclusão</b></font></td>
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
     <table width="80%" heigth="300" align="center">
       <tr>
         <td>
         <form method="POST" action="exclui_pessoa_cadastrada.php" border="20">
            <?php
               echo "<center><Font size=\"2\" face=\"ARIAL\">Selecione pessoa..:</font>";
               
               $seleciona = mysqli_query ($con,"SELECT matricula,nome
               FROM pessoa ORDER BY nome");
               echo "<select name='pessoa' class='caixa' align=\"center\">\n";
               while($linha = mysqli_fetch_row($seleciona))  {
                  printf("<option value='$linha[0]'>$linha[0] - $linha[1] </option>\n");
               }
            ?>
              <input name="mostra" type="submit" value="Mostra"></center>
         </td>
         </form>
       </tr>
   </table>
   <?php
     switch (get_post_action('exclui','mostra')) {
         case 'mostra':
             $matri              =$_POST['pessoa'];
             $_SESSION['matri']  =$matri;
             $resp_grava='';
             
             $pega_dados="SELECT matricula,nome,ramal,funcao,ende_ele,
             usuario,senha,depto,telefone,adm,ativo,date_format(data_cada,'%d/%m/%Y'),
             empresa,estado,c_servico
             FROM pessoa WHERE matricula='$matri'";
             $query = mysqli_query($con,$pega_dados) or die ("Não foi possivel acessar o banco");
             $total = mysqli_num_rows($query);
             for($ic=0; $ic<$total; $ic++){
               $row = mysqli_fetch_row($query);
               $matricula        = $row[0];
               $nome             = $row[1];
               $ramal            = $row[2];
               $funcao           = $row[3];
               $ende_ele         = $row[4];
               $usuario          = $row[5];
               $senha            = $row[6];
               $depto            = $row[7];
               $telefone         = $row[8];
               $adm              = $row[9];
               $ativo            = $row[10];
               $data_cada        = $row[11];
               $empresa          = $row[12];
               $estado           = $row[13];
               $c_servico        = $row[14];
             }
			 
             if ($c_servico<>''){
                $c_servico   = number_format($c_servico, 2, ',', '.');
			 }
			 
             //Verifica se esta pessoa está com movimento registrado
			 
             $pesquisa = "SELECT entregador FROM remessa
             WHERE entregador='$matricula'";
             $query = mysqli_query($con,$pesquisa) or die ("Não foi possivel acessar o banco");
             $achou = mysqli_num_rows($query);
             If ($achou > 0 ) {
                 ?>
                 <script language="javascript"> window.location.href=("exclui_pessoa_cadastrada.php")
                     alert('Existe movimento em nome desta pessoa. Para exclui-la, exclua primeiro o respectivo movimento .');
                 </script>
                 <?php
                }
         break;
         
         case 'exclui':
            
            $adm   =$_SESSION['adm_m'];
            if ($adm=='S') {
                $matricula       =$_SESSION['matri'];
				
                $excluir = "DELETE FROM pessoa WHERE matricula='$matricula'";
				
                if (mysqli_query($con,$excluir)) {
					
                   $resp_grava="Exclusão bem sucedida.";
				   
                   $matricula       ='';
                   $nome            ='';
                   $ramal           ='';
                   $funcao          ='';
                   $ende_ele        ='';
                   $usuario         ='';
                   $senha           ='';
                   $depto           ='';
                   $telefone        ='';
                   $adm             ='';
                   $ativo           ='';
                   $data_cada       ='';
                   $empresa         ='';
                   $estado          ='';
                   $c_servico       ='';
				   
                  // echo "<meta HTTP-EQUIV='refresh' CONTENT='0'>";
                }
                else {
                   $resp_grava="Problemas na Exclusão.";
                }
            }
            
         break;
         default:
     }
  ?>



  <body leftmargin="10" topmargin="10" marginwidth="10" marginheight="10">
  <form name="cadastro" action="exclui_pessoa_cadastrada.php" method="post">
  <table width="80%" border="1" cellpadding="5" cellspacing="0" bordercolor="#6495ED">
		<tr>
			<td><b>Matricula :</b></td>
			<td><?php echo "$matricula"; ?></td>
		</tr>
		<tr>
			<td><b>Nome :</b></td>
			<td><input type="text" id="nome" name="nome" value ="<?php echo "$nome";?>" size="40" maxlength="40"></td>
		</tr>
		<tr>
			<td><b>Empresa :</b></td>
            <td>
			<?php
              ?>
              <select name="empresa">
              <?php
              $sql = "SELECT cnpj_cpf,nome FROM cli_for ORDER BY nome";
              $resultado = mysqli_query($con,$sql) or die ("Não foi possivel acessar o banco");
              while ( $linha = mysqli_fetch_array($resultado)) {
                 $select = $empresa == $linha[0] ? "selected" : "";
                 echo "<option value=\"". $linha[0] . "\" $select>" . $linha[1] . "</option>";
              }
            ?>
            </select>
           </td>
		</tr>
		<tr>
			<td><b>Escrtório :</b></td>
            <td>
			<?php
              ?>
              <select name="depto">
              <?php
                   $query = "SELECT codigo,nome FROM regi_dep";
                   $result = mysqli_query($con,$query) or die ("Não foi possivel acessar o banco");
                    while ( $linha = mysqli_fetch_array($result)) {
                         $select = $depto == $linha[0] ? "selected" : "";
                         echo "<option value=\"". $linha[0] . "\" $select>" . $linha[1] . "</option>";
                    }
              ?>
            </select>
          </td>
        </tr>
        <tr>
          <td><b>Ramal :</b></td>
          <td><input type="text" name="ramal" value ="<?php echo "$ramal";?>" size="15" maxlength="15" id="ramal"></td>
		</tr>
		<tr>
			<td><b>Telefones :</b></td>
			<td><input type="text" name="telefone" value ="<?php echo "$telefone";?>" size="30" maxlength="30" id="telefone"></td>
		</tr>
		<tr>
           <td><b>Estado :</b></td>
           <td>
           <select name="estado">
           <option value="SC" <?php if ($estado == "SC") { echo "selected"; }?>>Santa Catarina</option>
           <option value="PR" <?php if ($estado == "PR") { echo "selected"; }?>>Parana</option>
           <option value="RS" <?php if ($estado == "RS") { echo "selected"; }?>>Rio Grande do Sul</option>
           <option value="RJ" <?php if ($estado == "RJ") { echo "selected"; }?>>Rio de Janeiro</option>
           <option value="SP" <?php if ($estado == "SP") { echo "selected"; }?>>São Paulo</option>
           <option value="MG" <?php if ($estado == "MG") { echo "selected"; }?>>Minas Gerais</option>
           </select>
           </p>
           </td>
        </tr>
		<tr>
			<td><b>Email :</b></td>
			<td><input name="ende_ele" type="text" value ="<?php echo "$ende_ele";?>" size="40" maxlength="40" id="ende_elel"></td>
		</tr>
		<tr>
			<td><b>Função :</b></td>
			<td>
			 <?php
              ?>
              <select name="funcao">
              <?php
                   $queri= "SELECT codigo,descricao FROM t_funcao";
                   $result = mysqli_query($con,$queri) or die ("Não foi possivel acessar o banco");
                    while ( $linha = mysqli_fetch_array($result)) {
                         $select = $funcao == $linha[0] ? "selected" : "";
                         echo "<option value=\"". $linha[0] . "\" $select>" . $linha[1] . "</option>";
                    }
              ?>
              </select>
           </td>
		</tr>
		<tr>
			<td><b>Login do usuário :</b></td>
			<td><input name="usuario" type="text" value ="<?php echo "$usuario";?>" size="20" maxlength="20" id="usuario">(Máximo de 20 caracteres)</td>
		</tr>
		<tr>
			<td><b>Senha do usuário :</b></td>
			<td><input name="senha" type="password" value ="<?php echo "$senha";?>" size="10" maxlength="10" id="senha">(Máximo de 10 caracteres)</td>
		</tr>
		<tr>
			<td><b>Ativo :</b></td>
			<td><input name="ativo" type="text" value ="<?php echo "$ativo";?>" size="1" maxlength="1" id="ativo">(S/N)</td>
		</tr>
		<tr>
			<td><b>Administrador Sistema :</b></td>
			<td><input name="adm" type="text" value ="<?php echo "$adm";?>" size="1" maxlength="1" id="adm">(S/N)</td>
		</tr>
		<tr>
			<td><b>Custo Parceiro :</b></td>
			<td><input name="c_servico" type="text" value ="<?php echo "$c_servico";?>" size="20" maxlength="20" onKeydown="Formata(this,20,event,2)"></td>
		</tr>
		<tr>
          <td><b>Data cadastro :</b></td>
          <td>
            <input type="text" name="data_cada" value ="<?php echo "$data_cada";?>" size="12" maxlength="12" id="data_cada">
            <input TYPE="button" NAME="btndata_cada" VALUE="..." Onclick="javascript:popdate('document.cadastro.data_cada','pop1','150',document.cadastro.data_cada.value)">
            <span id="pop1" style="position:absolute"></span>
          </td>
        </tr>
		<tr>
            <td><INPUT type=button value="Pessoas Cadastradas"
               onClick="window.open('mostra_pessoas_cadastradas.php','janela_1',
               'scrollbars=yes,resizable=yes,width=600,height=400');">
            </td>
			<td colspan="2">
				<div align="right">
				<input name="exclui" type="submit" OnClick="confirma_exclusao();" value="Excluir">
				</div>
			</td>
		</tr>
	</table>
   </form>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td color="white" align="center" width="900" height="45" colspan="8" ><?php echo "$resp_grava";?></td>
      </tr>
  </table>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
       <td color="white" align="left" width="100%" height="30">
    </tr>
  </table>
  <table border="0" width="100%" cellspacing="0" cellpadding="0" background="img/blue.jpg">
      <tr>
        <td width="100%" height="25" align="center"></font><font color="white" size="1" face="Arial">�&nbsp; COPYRIGHT NUNESTECH Tecnologia em Sistemas Ltda</font></td>
     </tr>
  </table>
</div>
</body>
</html>



