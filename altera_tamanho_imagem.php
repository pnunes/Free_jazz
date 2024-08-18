<?php
  session_start();

 //carrega variaveis com dados para acessar o banco de dados

  ini_set("memory_limit","24M");

  $base_d     =$_SESSION['base_d'];
  $banco_d    =$_SESSION['banco_d'];
  $usuario_d  =$_SESSION['usuario_d'];
  $senha_d    =$_SESSION['senha_d'];

  $matricula_m  =$_SESSION['matricula_m'];
  $programa='A5';
  $_SESSION['programa_m']=$programa;
   
  function get_post_action($name) {
    $params = func_get_args();
    foreach ($params as $name) {
        if (isset($_POST[$name])) {
            return $name;
        }
    }
  }

  function dimensaoImagem($input_image) {

      // Pega o tamanho original da imagem e armazena em um Array:
      $size = getimagesize( $input_image );

      // Configura a nova largura da imagem:
      $thumb_width = "600";

      // Calcula a altura da nova imagem para manter a proporção na tela:
      $thumb_height = ( int )(( $thumb_width/$size[0] )*$size[1] );

      // Cria a imagem com as cores reais originais na memória.
      $thumbnail = ImageCreateTrueColor( $thumb_width, $thumb_height );

      // Criará uma nova imagem do arquivo.
      $src_img = ImageCreateFromJPEG( $input_image );

      // Criará a imagem redimensionada:
      ImageCopyResampled( $thumbnail, $src_img, 0, 0, 0, 0, $thumb_width, $thumb_height, $size[0], $size[1] );

      // Informe aqui o novo nome da imagem e a localização:
      ImageJPEG( $thumbnail, $input_image );

      // Limpa da memoria a imagem criada temporáriamente:
      ImageDestroy( $thumbnail );
  }
?>
<html>
  <title>converte_imagem.php</title>
  <head>
  <script language="JavaScript" type="text/JavaScript">
      ok=false;
      function CheckAll() {
          if(!ok){
        	  for (var i=0;i<document.cadastro.elements.length;i++) {
        		var x = document.cadastro.elements[i];
        		if (x.name == 'hawb[]') {
        				x.checked = true;
        				ok=true;
        			}
        		}
          }
    	  else{
    	      for (var i=0;i<document.cadastro.elements.length;i++) {
    		      var x = document.cadastro.elements[i];
    		      if (x.name == 'hawb[]') {
    			     x.checked = false;
    				 ok=false;
    			  }
    		  }
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
        <td width="658" height="110"> <img border="0" src="img/cabecalho_free_jazz.jpg" width="658" height="110" border="0"></td>
        <td width="15%" height="110">
        <p align="right"><img border="0" src="img/topright.jpg" width="160" height="110" border="0"></td>
     </tr>
    </table>
    <table border="0" width="100%" cellspacing="0" cellpadding="0" background="img/blue.jpg">
     <tr>
       <td width="50%">
         <p align="left"><font face="Arial" size="2" color="#FFFFFF"><b>Sistema de Gerenciamento da Logística de Encomendas</b></font></td>
       <td width="50%">
         <p align="right"><font face="Arial" size="2" color="#FFFFFF"><b>Converte Imagem de GIF para JPG</b></font></td>
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
  <?php
    switch (get_post_action('converte')) {
        case 'converte':
        
             $con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
             $res = mysql_select_db($banco_d) or die ("Banco de dados inexistente");
             $num=0;
             if ($_POST['hawb']<>'') {
             
                 foreach($_POST['hawb'] as $hawb){
                    $n_hawb =$hawb;
                    $imagem =$hawb.".jpg";

                    $path ='hawbs/';
                    $exte ='.jpg';
                    if(file_exists("$path$hawb$exte")) {

                       //Convertendo a imagem de GIF para JPG
                       
                       $caminhoImagem = 'hawbs/'.$imagem;
                       $explode = explode('.', $caminhoImagem);
                       $extensao = end($explode);
                       $imput_imagem = $explode[0] . '.jpg';
                       //converterImagem($caminhoImagem, $novaImagem, $extensao, true);
                       dimensaoImagem($caminhoImagem, $imput_imagem);
                       $num=$num+1;
                    }
                 }
                 $resp_grava ='Foram convertidas :'. $num . " " . 'imagens.';
             }
             else {
                 ?>
                   <script language="javascript"> window.location.href=("converte_imagem.php")
                   alert('Você precisa selecionar clicando no box !');
                   </script>
                <?php
             }
        break;
        default:
    }
  ?>
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
  </head>
  <body leftmargin="10" topmargin="10" marginwidth="10" marginheight="10">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
         <td color="white" align="left" width="100%" height="10">
      </tr>
    </table>
  <form name="cadastro" id="cadastro" action="altera_tamanho_imagem.php" method="post">
     <p>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
         <td color="white" align="left" width="100%" height="15">
      </tr>
    </table>
	<table width="90%" border="1" cellpadding="5" cellspacing="0" bordercolor="#6495ED" align="center">
      <tr>
         <td colspan="6" align="center"><font face="arial" size="2"><b>Selecione as imagens que deseja converter.</b></font></td>
      </tr>
      <tr>
         <td align="center"><b>N.POD</b></td>
         <td align="center"><b>ENTREGADOR</b></td>
         <td align="center"><b>DESTINATARIO</b></td>
         <td align="center"><b>TAM.</b></td>
         <td align="center"><b>DT. ENVIO</b></td>
         <td align="center"><b>REMESSA</b></td>
      </tr>
      <?php
        $con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
        $res = mysql_select_db($banco_d) or die ("Banco de dados inexistente");
        
        $sql = mysql_query("SELECT remessa.n_hawb,cli_for.nome,remessa.nome_desti,remessa.n_remessa
        FROM remessa,cli_for
        WHERE ((remessa.codi_cli='06327259000193')
        AND (remessa.entregador=cli_for.cnpj_cpf))
        ORDER BY remessa.n_remessa");
        if (mysql_num_rows($sql)==0) {
            echo "Não há Imagens para serem Convertidas !";
        }
        else {
            $numeh=0;
            $path ='hawbs/';
            $exte ='.jpg';
            echo "<tr><td bgcolor=\"blue\"><a href=\"javascript:void(null)\" onClick=\"CheckAll();\"><font face=\"arial\" color=\"white\"><b> Marcar Todas</b></font></a><br></td></tr>";
            while ($x  = mysql_fetch_array($sql)) {
                  $n_hawb       = $x['n_hawb'];
                  $nome_repre   = $x['nome'];
                  $nome_desti   = $x['nome_desti'];
                  $n_remessa    = $x['n_remessa'];
                  if(file_exists("$path$n_hawb$exte")) {
                      $data    = date ("d/m/Y", filemtime("$path$n_hawb$exte"));
                      $tamanho = filesize("$path$n_hawb$exte");
                      $tamanho =(int) ($tamanho/1000);
                      if ($tamanho>50) {
                         echo "<div>";
                         echo "<font face=\"arial\" size=\"1\">";
                         echo "<tr><td>";
                         echo $n_hawb."<input type =\"checkbox\" name = \"hawb[]\" id=\"hawb\" value=\"$n_hawb\" OnClick=\"MarcaBases(true);\"></td>";
                         echo "<td>$nome_repre</td>";
                         echo "<td>$nome_desti</td>";
                         echo "<td>$tamanho KB</td>";
                         echo "<td>$data</td>";
                         echo "<td>$n_remessa</td>";
                         echo "</tr>";
                         echo "</div>";
                         $numeh++;
                     }
                  }
            }
        }
      ?>
	  <tr>
	    <td colspan="5">
			<div align="left">
               <b> Total de Imagens para conversão..:</b><font size="3" color="red"><?php echo "$numeh";?></font>
	        </div>
	    </td>
	    <td>
			<div align="right">
			   <input name="converte" type="submit" value="Converter">
	        </div>
	    </td>
	  </tr>
	</table>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td color="white" align="center" width="900" height="45" colspan="8" ><?php echo "$resp_grava";?></td>
      </tr>
    </table>
    </form>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
         <td color="white" align="left" width="100%" height="30">
      </tr>
    </table>
    <table border="0" width="100%" cellspacing="0" cellpadding="0" background="img/blue.jpg">
      <tr>
        <td width="100%" height="25" align="center"></font><font color="white" size="1" face="Arial">©&nbsp; COPYRIGHT NUNESTECH Tecnologia em Sistemas Ltda</font></td>
     </tr>
</table>
 </div>
</body>
</html>

