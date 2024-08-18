<?php
  session_start(); //carrega variaveis com dados para acessar o banco de dados   Include('conexao_free.php'); 
  //verifica se o usuário esta habilitado para usar a rotina
 
  $matricula_m  =$_SESSION['matricula_m'];
  $programa='001';
  $_SESSION['programa_m']=$programa;
    $confere = "SELECT matricula,programa  FROM permissoes  WHERE ((matricula='$matricula_m') and (programa='$programa'))";  $query = mysqli_query($con,$confere) or die ("Não foi possivel acessar o banco - Rotina Cadastro Pessoas");
  $achou = mysqli_num_rows($query);  If ($achou == 0 ) {
       ?>
          <script language="javascript"> window.location.href=("entrada.php")
            alert('Você não está autorizado a acessar esta rotina.');
          </script>
       <?php
  }
?><html>
  <title>Cadastro_pessoas.php</title>
  <head>
  <script LANGUAGE="Javascript">
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
</script>
  </head>
  <body>
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
         <p align="left"><font face="Arial" size="2" color="#FFFFFF"><b>Sistema de Gerenciamento da Logástica de Encomendas</b></font></td>
       <td width="50%">
         <p align="right"><font face="Arial" size="2" color="#FFFFFF"><b>Cadastro de Pessoas - Inclusão</b></font></td>
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
  <?php
    include ("campo_calendario.php");
    $resp_grava='';
    if (isset($_POST['matricula'])) {
        $matricula       =$_POST['matricula'];
        $nome            =$_POST['nome'];
        $ramal           =$_POST['ramal'];
        $funcao          =$_POST['funcao'];
        $ende_ele        =$_POST['ende_ele'];
        $usuario         =$_POST['usuario'];
        $senha           =$_POST['senha'];
        $depto           =$_POST['depto'];
        $telefone        =$_POST['telefone'];
        $adm             =$_POST['adm'];
        $ativo           ='S';
        $data_cada       =$_POST['data_cada'];
        $empresa         =$_POST['empresa'];
        $estado          =$_POST['estado'];
        $c_servico       =$_POST['c_servico'];		
        //Acrecentando zero a esquerda da matricula        $matricula = sprintf("%05d", $matricula);
        $adm      =Strtoupper($adm);		        // alterando o formato dos valores para guardar no banco        if (strlen($c_servico)>=6) {
           $c_servico         = str_replace(".", "", $c_servico);
           $c_servico         = str_replace(",", ".", $c_servico);
        }
        if (strlen($c_servico)<6) {
           $c_servico         = str_replace(",", ".", $c_servico);
        }		        //mudando formato da data para gravar na tabela        $data_cada  = explode("/",$data_cada);
        $v_data_cada = $data_cada[2]."-".$data_cada[1]."-".$data_cada[0];        $verifi="SELECT matricula FROM pessoa WHERE matricula='$matricula'";		
        $query = mysqli_query($con,$verifi) or die ("Não foi possivel acessar o banco");
        $achou = mysqli_num_rows($query);		        If ($achou > 0 ) {
          ?>
          <script language="javascript"> window.location.href=("entrada.php")
            alert('Já existe pessoa cadastrada com a matricula informada.');
          </script>
          <?php
        }
        else {
          $inclusao = "INSERT INTO pessoa(matricula,nome,ramal,funcao,
          ende_ele,usuario,senha,depto,telefone,adm,ativo,data_cada,empresa,estado,c_servico)
          values('$matricula','$nome','$ramal','$funcao',
          '$ende_ele','$usuario','$senha','$depto','$telefone','$adm','$ativo',
          '$v_data_cada','$empresa','$estado','$c_servico')";		            if (mysqli_query($con,$inclusao)) {             $resp_grava="Inclusão bem sucedida";
             $matricula       ='';
             $nome            ='';
             $ramal           ='';
             $ende_ele        ='';
             $usuario         ='';
             $senha           ='';
             $telefone        ='';
             $adm             ='';
             $ativo           ='';
             $data_cada       ='';
             $estado          ='';
             $c_servico       ='';
            }
           else {
             $resp_grava="Problemas na Inclusão";
           }
        }
    }
  ?>
  <style>		body, p, div, td, input, select, textarea {
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
		textarea { overflow:auto }	</style>
  </head>
  <body leftmargin="10" topmargin="10" marginwidth="10" marginheight="10">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
         <td color="white" align="left" width="100%" height="35">
      </tr>
    </table>
  <form name="cadastro" id="cadastro" action="cadastro_pessoas.php" method="post">
	<table width="50%" border="1" cellpadding="5" cellspacing="0" bordercolor="#6495ED">
		<tr>
			<td><b>Matricula :</b></td>			<td><input type="text" name="matricula" size="15" maxlength="15" id="matricula"></td>		</tr>		<tr>			<td><b>Nome :</b></td>			<td><input type="text" name="nome" size="50" maxlength="50" id="nome"></td>		</tr>		<tr>			<td><b>Empresa :</b></td>			<td>			  <?php              $pega_empresa = mysqli_query($con,"SELECT cnpj_cpf,nome              FROM cli_for              ORDER BY nome");              echo "<select name='empresa' class='caixa' align=\"left\">\n";              while($linha = mysqli_fetch_row($pega_empresa))  {                 printf("<option value='$linha[0]'>$linha[0] - $linha[1] </option>\n");              }              ?>
			  </select>           </td>		</tr>		<tr>			<td><b>Escritorio :</b></td>			<td>			<?php                            $pega_depto = mysqli_query ($con,"SELECT codigo,nome              FROM regi_dep ORDER BY nome");              echo "<select name='depto' class='caixa' align=\"left\">\n";              while($linha = mysqli_fetch_row($pega_depto))  {                 printf("<option value='$linha[0]'>$linha[0] - $linha[1] </option>\n");                 }           ?>           </td>		</tr>		<tr>			<td><b>Ramal :</b></td>			<td><input type="text" name="ramal" size="15" maxlength="15" id="ramal"></td>		</tr>		<tr>			<td><b>Telefones :</b></td>			<td><input type="text" name="telefone" size="30" maxlength="30" id="telefone"></td>		</tr>		<tr>           <td><b>Estado :</b></td>           <td>           <SELECT NAME="estado" SIZE="1">               <OPTION VALUE="SC">Santa Catarina</OPTION>               <OPTION VALUE="PR">Paraná</OPTION>               <OPTION VALUE="RS">Rio Grande do Sul</OPTION>               <OPTION VALUE="RJ">Rio de Janeiro</OPTION>               <OPTION VALUE="SP">São Paulo</OPTION>               <OPTION VALUE="MG">Minas Gerais</OPTION>           </SELECT>           </td>        </tr>		<tr>			<td><b>Email :</b></td>			<td><input name="ende_ele" type="text" size="40" maxlength="40" id="ende_elel"></td>		</tr>		<tr>			<td><b>Função :</b></td>			<td>			<?php              $pega_funcao = mysqli_query ($con,"SELECT codigo,descricao              FROM t_funcao");              echo "<select name='funcao' class='caixa' align=\"left\">\n";              while($linha = mysqli_fetch_row($pega_funcao))  {                 printf("<option value='$linha[0]'>$linha[0] - $linha[1] </option>\n");                 }           ?>           </td>		</tr>		<tr>			<td><b>Login do usuário :</b></td>			<td><input name="usuario" type="text" size="20" maxlength="20" id="usuario">(Máximo de 20 caracteres)</td>		</tr>		<tr>			<td><b>Senha do usuário :</b></td>			<td><input name="senha" type="password" size="10" maxlength="10" id="senha">(Máximo de 10 caracteres)</td>		</tr>		<tr>			<td><b>Ativo :</b></td>			<td><input name="ativo" type="text" size="1" maxlength="1" id="ativo">(S/N)</td>		</tr>		<tr>			<td><b>Administrador Sistema :</b></td>			<td><input name="adm" type="text" size="1" maxlength="1" id="adm">(S->Tudo P->Indivual E->Escritorio)</td>		</tr>		<tr>			<td><b>Custo Pareceiro :</b></td>			<td><input name="c_servico" type="text" size="20" maxlength="20" onKeydown="Formata(this,20,event,2)"></td>		</tr>		<tr>          <td><b>Data cadastro :</b></td>          <td>            <input type="text" name="data_cada" size="12" maxlength="12" id="data_cada">            <input TYPE="button" NAME="btndata_cada" VALUE="..." Onclick="javascript:popdate('document.cadastro.data_cada','pop1','150',document.cadastro.data_cada.value)">            <span id="pop1" style="position:absolute"></span>          </td>        </tr>		<tr>            <td><INPUT type=button value="Pessoas Cadastradas"               onClick="window.open('mostra_pessoas_cadastradas.php','janela_1',               'scrollbars=yes,resizable=yes,width=600,height=400');">            </td>			<td colspan="2">				<div align="right">				<input name="enviar" type="submit" value="enviar">				</div>			</td>		</tr>	</table>	<table width="100%" border="0" cellspacing="0" cellpadding="0">      <tr>        <td color="white" align="center" width="900" height="45" colspan="8" ><?php echo "$resp_grava";?></td>      </tr>    </table>    </form>    <table width="100%" border="0" cellspacing="0" cellpadding="0">      <tr>         <td color="white" align="left" width="100%" height="30">      </tr>    </table>    <table border="0" width="100%" cellspacing="0" cellpadding="0" background="img/blue.jpg">      <tr>        <td width="100%" height="25" align="center"></font><font color="white" size="1" face="Arial">COPYRIGHT NUNESTECH Tecnologia em Sistemas Ltda</font></td>     </tr></table> </div></body></html>