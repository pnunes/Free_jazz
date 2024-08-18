<?php
  if ( session_status() !== PHP_SESSION_ACTIVE ) {
    session_start();
  }
  //Recebendo as variáveis da página de entrada -index.php
  $usuario     =$_POST['usuario'];
  $senha       =$_POST['senha'];
  
?>
<HTML>
<HEAD>
 <TITLE>confere_acesso.php</TITLE>
</HEAD>
<BODY>
<body topmargin="0" leftmargin="0" rightmargin="0" bottommargin="0" marginheight="0" marginwidth="0" bgcolor="#FFFFFF">
<table border="0" width="100%" bgcolor="#000000" cellspacing="0" cellpadding="0">
  <tr>
    <td width="20%" height="100" background="img/topleft.jpg"></td>
    <td width="658" height="110"> <img border="0" src="img/cabecalho_free_jazz.jpg" width="658" height="110" border="0"></td>
    <td width="15%" height="110">
      <p align="right"><img border="0" src="img/topright.jpg" width="160" height="110" border="0"></td>
  </tr>
</table>
<table border="0" width="100%" cellspacing="0" cellpadding="0" background="img/green.jpg">
  <tr>
    <td width="100%">
      <p align="right"><font face="Arial" size="2" color="#FFFFFF"><b>Sistema de Gerenciamento de Auditoria Interna</b></font></td>
  </tr>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
       <td color="white" align="left" width="900" height="390">
     </tr>
  </table>
<?php  Include('conexao_free.php');
  // Verifica se o usuário é válido
  
  $declara = "SELECT matricula,nome,ende_ele,usuario,senha,telefone,ativo,adm,data_cada,depto,empresa
  FROM pessoa
  WHERE ((usuario='$usuario') and (senha='$senha') and (ativo='S'))";

  $query_d = mysqli_query($con,$declara) or die ("Não foi possivel usar a tabela pessoa: ".mysqli_errno($con)." - ".mysqli_error($con));
  $total   = mysqli_num_rows($query_d);
  
  echo "<p>Total :".$total;
  
  if($total > 0) {
	   for($ic=0; $ic<$total; $ic++){
		   $row = mysqli_fetch_row($query_d);
		   $matricula_m        = $row[0];
		   $nome_m             = $row[1];
		   $ende_ele_m         = $row[2];
		   $usuario_m          = $row[3];
		   $senha_m            = $row[4];
		   $telefone_m         = $row[5];
		   $ativo_m            = $row[6];
		   $administra_m       = $row[7];
		   $data_cada_m        = $row[8];
		   $depto_m            = $row[9];
		   $empresa_m          = $row[10];
	   }
	 
	   // criando variaveis globais

	   $_SESSION['matricula_m']   = $matricula_m;
	   $_SESSION['nome_m']        = $nome_m;
	   $_SESSION['ende_ele_m']    = $ende_ele_m;
	   $_SESSION['usuario_m']     = $usuario_m;
	   $_SESSION['senha_m']       = $senha_m;
	   $_SESSION['telefone_m']    = $telefone_m;
	   $_SESSION['ativo_m']       = $ativo_m;
	   $_SESSION['adm_m']         = $administra_m;
	   $_SESSION['data_cada_m']   = $data_cada_m;
	   $_SESSION['depto_m']       = $depto_m;
	   $_SESSION['empresa_m']     = $empresa_m;
	   
	   ?>
         <script language="javascript"> window.location.href=("entrada.php")</script>
       <?php
  }
  else {
	  ?>
	  <script language="javascript"> window.location.href=("index.php")
		alert('Usuario não cadastrado! Fale com o administrador do sistema.');
	  </script>
	  <?php 
  }
?>
<table border="0" width="100%" cellspacing="0" cellpadding="0" background="img/green.jpg">
  <tr>
    <td width="100%" height="25" align="center"></font><font color="#000000" size="1" face="Arial">©&nbsp; COPYRIGHT NUNESTECH Tecnologia em Sistemas Ltda</font></td>
  </tr>
</table>
</BODY>
</HTML>
