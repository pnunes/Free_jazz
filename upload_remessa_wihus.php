<?php
  session_start();

   //carrega variaveis com dados para acessar o banco de dados

  $base_d     =$_SESSION['base_d'];
  $banco_d    =$_SESSION['banco_d'];
  $usuario_d  =$_SESSION['usuario_d'];
  $senha_d    =$_SESSION['senha_d'];

  $matricula_m  =$_SESSION['matricula_m'];
  $programa='031';
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
?>


<!-- dynamic assets -->
<style type="text/css">
#status
{
	padding:				10px 15px;
	width:					420px;
}
 
#status .progress
{
	background:				white url(progress.gif) no-repeat;
	background-position:	+50% 0;
	margin-right:			0.5em;
}
 
#status .progress-text
{
	font-size:				0.9em;
	font-weight:			bold;
}
 
#images-list
{
	list-style:				none;
	width:					450px;
	margin:					0;
}
 
#images-list li.file
{
	border-bottom:			1px solid #E1E1E1;
	background-image: url(assets/file.png);
	background-repeat: no-repeat;
	background-position: 4px 4px;
}
#images-list li.file.file-uploading
{
	background-image:		url(uploading.gif);
	background-color:		#EFEFEF;
}
#images-list li.file.file-success
{
	background-image:		url(success.png);
}
#images-list li.file.file-failed
{
	background-image:		url(failed.png);
}
 
#images-list li.file .file-name
{
	font-size:				1.2em;
	margin-left:			60px;
	display:				block;
	clear:					left;
	line-height:			40px;
	height:					56px;
	font-weight:			bold;
}
#images-list li.file .file-size
{
	font-size:				0.9em;
	line-height:			18px;
	float:					right;
	margin-top:				2px;
	margin-right:			6px;
}
#images-list li.file .file-info
{
	display:				block;
	margin-left:			44px;
	font-size:				0.9em;
	line-height:			20px;
	clear
}
#images-list li.file .file-remove
{
	clear:					right;
	float:					right;
	line-height:			18px;
	margin-right:			6px;
}

.hide {
	display: none;
}

#loading {
	padding:				30px;
	width:					420px;
	text-align: 			center;
	font-weight: bold;
}

#loading img {
	vertical-align: middle;
}
img {
	border: 0px;
}
a {
	font-size: 11px;
	color: #333333;
}
a:link {
	text-decoration: none;
}
a:visited {
	text-decoration: none;
	color: #333333;
}
a:hover {
	text-decoration: none;
	color: #666666;
}
a:active {
	text-decoration: none;
	color: #333333;
}
body,td,th {
	font-family: Tahoma, Arial, Trebuchet MS;
	font-size: 11px;
}
</style>
	<script type="text/javascript" src="mootools-trunk.js"></script>
	<script type="text/javascript" src="Swiff.Uploader.js"></script>
	<script type="text/javascript" src="Fx.ProgressBar.js"></script>
	<script type="text/javascript" src="FancyUpload2.js"></script>

<script type="text/javascript">
window.addEvent('load', function() {
 
	var swiffy = new FancyUpload2($('status'), $('images-list'), {
		url: $('form_imagens').action,
		fieldName: 'photoupload',
		path: 'Swiff.Uploader.swf',
		onLoad: function() {
			$('loading').destroy();
			$('status').removeClass('hide');
			
			this.options.typeFilter = {'Imagens (*.jpg, *.jpeg, *.gif, *.png,*.txt,*.csv)': '*.jpg; *.jpeg; *.gif; *.png; *.txt; *.csv'};
		},
		limitFiles: 50,
		debug: true,
		target: 'add-image'
	});
 
	/**
	 * Various interactions
	 */
 
	$('add-image').addEvent('click', function() {
		swiffy.browse();
		return false;
	});
 
	$('clear-list').addEvent('click', function() {
		swiffy.removeFile();
		return false;
	});
 
	$('upload-images').addEvent('click', function() {
		swiffy.upload();
		return false;
	});
 
});
</script>
<html>
<title>rotina_upload_baixa.php</title>
  <head>
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
         <p align="left"><font face="Arial" size="2" color="#FFFFFF"><b>Sistema de Gerenciamento da Logística de Encomendas</b></font></td>
       <td width="50%">
         <p align="right"><font face="Arial" size="2" color="#FFFFFF"><b>Envia Baixas para Servidor</b></font></td>
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
<div>
<form action="script_baixa.php" method="post" enctype="multipart/form-data" id="form_imagens">

<div id="loading">
<img src="uploading.gif" alt="" /><br />Carregando...
</div>
	
<div id="status" class="hide">
<p>
<a href="#" id="add-image"><input name="Button" type="button" value="Procurar arquivos" /></a> |
<a href="#" id="clear-list"><input name="Button" type="button" value="Limpar a Lista" /></a> |
<a href="#" id="upload-images"><input type="submit" value="Enviar" /></a></p>
<p>


<div>

<strong class="overall-title">Progresso Total</strong><br />
<img src="bar.gif" class="progress overall-progress" />
</div>

<div>
<strong class="current-title">Arquivo atual</strong><br />
<img src="bar.gif" class="progress current-progress" />
</div>

<div class="current-text"></div>
</div>
 
<div id="images-list"></div>
</form>
</div>
<br /><br />
<a href=upload/download.php?file=teste.txt>Arquivo</a>
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
