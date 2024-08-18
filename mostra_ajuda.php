<?php
  session_start();

 //carrega variaveis com dados para acessar o banco de dados

  $base_d     =$_SESSION['base_d'];
  $banco_d    =$_SESSION['banco_d'];
  $usuario_d  =$_SESSION['usuario_d'];
  $senha_d    =$_SESSION['senha_d'];
  
  $programa_m =$_SESSION['programa_m'];
?>

<HTML>
<HEAD>
 <TITLE>mostra_ajuda.php</TITLE>

 <!-- TinyMCE -->
    <script type="text/javascript" src="tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
    <script type="text/javascript">
	tinyMCE.init({
		// General options
		mode : "textareas",


		// Example content CSS (should be your site CSS)
		content_css : "css/content.css",

		// Drop lists for link/image/media/template dialogs
		template_external_list_url : "lists/template_list.js",
		external_link_list_url : "lists/link_list.js",
		external_image_list_url : "lists/image_list.js",
		media_external_list_url : "lists/media_list.js",

		// Style formats
		style_formats : [
			{title : 'Bold text', inline : 'b'},
			{title : 'Red text', inline : 'span', styles : {color : '#ff0000'}},
			{title : 'Red header', block : 'h1', styles : {color : '#ff0000'}},
			{title : 'Example 1', inline : 'span', classes : 'example1'},
			{title : 'Example 2', inline : 'span', classes : 'example2'},
			{title : 'Table styles'},
			{title : 'Table row 1', selector : 'tr', classes : 'tablerow1'}
		],

		// Replace values for the template plugin
		template_replace_values : {
			username : "Some User",
			staffid : "991234"
		}
	   });
      </script>
      <!-- /TinyMCE -->


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

</HEAD>

<BODY>

<FORM>
<INPUT type=button value="Fechar janela" onClick="window.close();">
</FORM>
<table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#6495ED">

<?php
      mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
      mysql_select_db($banco_d) or die ("Banco de dados inexistente");

      $resultado = mysql_query ("SELECT ajuda,nome_programa
      FROM cad_rotinas
      WHERE programa='$programa_m'");
      $total = mysql_num_rows($resultado);

      for($i=0; $i<$total; $i++){
         $dados = mysql_fetch_row($resultado);
	     $ajuda          =$dados[0];
	     $nome_programa  =$dados[1];
       }
?>
<tr>
  <td><TEXTAREA NAME="conteudo" rows="40" cols="58" readonly style="justified"><?php echo "$ajuda";?></TEXTAREA></td>
</tr>
</table>
</div>
</BODY>
</HTML>
