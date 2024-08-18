<?php
  session_start();

 //carrega variaveis com dados para acessar o banco de dados

  $base_d     =$_SESSION['base_d'];
  $banco_d    =$_SESSION['banco_d'];
  $usuario_d  =$_SESSION['usuario_d'];
  $senha_d    =$_SESSION['senha_d'];

  function get_post_action($name)
{
    $params = func_get_args();

    foreach ($params as $name) {
        if (isset($_POST[$name])) {
            return $name;
        }
    }
}
  $codigo_m  =$_SESSION['codigo_m'];
  $programa='12';

  $con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
  $res = mysql_select_db($banco_d) or die ("Banco de dados inexistente");

  $declara = "SELECT matricula,programa
  FROM permissoes
  WHERE ((matricula='$codigo_m') and (programa='$programa'))";

  $query = mysql_db_query($banco_d,$declara,$con) or die ("Não foi possivel acessar o banco");
  $achou = mysql_num_rows($query);

  If ($achou == 0) {
       ?>
          <script language="javascript"> window.location.href=("entrada.php")
            alert('Você não está autorizado a acessar esta rotina.');
          </script>
       <?php
  }
  include ("campo_calendario.php");
?>
<html>
  <title>Noticia_site_altera.php</title>
  <head>
  <!-- TinyMCE -->
    <script type="text/javascript" src="tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
    <script type="text/javascript">
	tinyMCE.init({
		// General options
		mode : "textareas",
		theme : "advanced",
		plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave",

		// Theme options
		theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
		theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
		theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,restoredraft",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,

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
				color: #efefef; background-color:#FFE4B5; border: 1px solid #DEB887 ;
				/*border-top-width: 1px; border-right-width: 1px; border-bottom-width: 1px; border-left-width: 1px; */
			}
		}
		textarea { overflow:auto }
	</style>
  </head>
  <body>
  <div id="geral" align="center">
    <body topmargin="0" leftmargin="0" rightmargin="0" bottommargin="0" marginheight="0" marginwidth="0" bgcolor="#FFFFFF">
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
         <form method="POST" action="noticia_site_altera.php" border="20">
            <?php

               include ("campo_calendario.php");
            
               echo "<center><Font size=\"2\" face=\"ARIAL\">Selecione a Notícia..:</font>";

               mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
               mysql_select_db($banco_d) or die ("Banco de dados inexistente");

               $resultado = mysql_query ("SELECT codigo,titulo
               FROM t_noticias
               ORDER BY titulo");
               echo "<select name='noticia' class='caixa' align=\"center\">\n";
               while($linha = mysql_fetch_row($resultado))  {
                  printf("<option value='$linha[0]'>$linha[0] - $linha[1] </option>\n");
               }
            ?>
              <input name="mostra" type="submit" value="Mostra"></center>
            </td>
           </tr>
         </form>
   </table>
  <?php
     switch (get_post_action('grava','mostra')) {
         case 'mostra':
             $codigo                 =$_POST['noticia'];
             $_SESSION['codigo_p']   =$_POST['noticia'];
             $resp_grava='';
             $con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
             $res = mysql_select_db($banco_d) or die ("Banco de dados inexistente");

             $verifi="SELECT codigo,titulo,assunto,date_format(data_publicacao,'%d/%m/%Y'),publicar
             FROM t_noticias WHERE codigo='$codigo'";
             $query = mysql_db_query($banco_d,$verifi,$con) or die ("Não foi possivel acessar o banco");
             $total = mysql_num_rows($query);

             for($ic=0; $ic<$total; $ic++){
               $row = mysql_fetch_row($query);
               $codigo         = $row[0];
               $titulo         = $row[1];
               $assunto        = $row[2];
               $dt_publi       = $row[3];
               $publicar       = $row[4];
             }
             break;

         case 'grava':
             $codigo          =$_SESSION['codigo_p'];
             $assunto         =$_POST['assunto'];
             $titulo          =$_POST['titulo'];
             $dt_publicacao   =$_POST['data_publi'];
             $publicar        =$_POST['publica'];

             //mudando formato da data para gravar na tabela

             $dt_publicacao  = explode("/",$dt_publicacao);
             $v_dt_publicacao = $dt_publicacao[2]."-".$dt_publicacao[1]."-".$dt_publicacao[0];

             $con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
             $res = mysql_select_db($banco_d) or die ("Banco de dados inexistente");

             $alteracao = "UPDATE t_noticias SET titulo='$titulo',assunto='$assunto',data_publicacao='$v_dt_publicacao'
             WHERE codigo='$codigo'";
             
             if (mysql_db_query($banco_d,$alteracao,$con)) {
                $resp_grava="Alteraçao bem sucedida";
                $codigo                ='';
                $titulo                ='';
                $assunto               ='';
                $v_dt_publicacao       ='';
                $publicar              ='';
                unset($_SESSION['codigo_p']);
             }
             else {
               $resp_grava="Problemas na Alteração";
             }
             break;
             default:
     }
  ?>

  <body leftmargin="10" topmargin="10" marginwidth="10" marginheight="10">
  <form name="cadastro" action="noticia_site_altera.php" method="post">
 <table width="95%" border="1" cellpadding="5" cellspacing="0" bordercolor="#DEB887">
		<tr>
			<td width="15%"><b>Número Notícia :</b></td>
			<td><?php echo "$codigo"; ?></td>
		</tr>
		<tr>
			<td width="15%"><b>Titulo da Notícia :</b></td>
			<td><input type="text" id="titulo" name="titulo" value ="<?php echo "$titulo";?>" size="70" maxlength="70"></td>
		</tr>
		<tr>
           <td width="15%"><b>Conteúdo da Notícia :</b></td>
           <td><TEXTAREA NAME="assunto" rows="35" cols="70" style="width: 100%"><?php echo "$assunto";?></TEXTAREA></td>
        </tr>
        <tr>
          <td width="15%"><b>Data da Publicação :</b></td>
          <td>
            <input type="text" name="data_publi" value ="<?php echo "$dt_publi";?>" size="12" maxlength="12" id="data_publi">
            <input TYPE="button" NAME="btndata_publi" VALUE="..." Onclick="javascript:popdate('document.cadastro.data_publi','pop1','150',document.cadastro.data_publi.value)">
            <span id="pop1" style="position:absolute"></span>
          </td>
        </tr>
        <tr>
			<td width="15%"><b>Publicar (S/N):</b></td>
			<td><input type="text" id="publica" name="publica" value ="<?php echo "$publicar";?>" size="1" maxlength="1"></td>
		</tr>
		<tr>
			<td colspan="2">
				<div align="right">
				<input name="grava" type="submit" value="Gravar">
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
       <td color="white" align="left" width="100%" height="10">
     </tr>
    </table>
    <table border="0" width="100%" cellspacing="0" cellpadding="0" background="img/marron.jpg">
      <tr>
        <td width="100%" height="25" align="center"></font><font color="white" size="1" face="Arial">©&nbsp; COPYRIGHT NUNESTECH Tecnologia em Sistemas Ltda</font></td>
     </tr>
    </table>
  </div>
</body>
</html>

