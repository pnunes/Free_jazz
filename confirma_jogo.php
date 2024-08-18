<?php
  session_start();

 //carrega variaveis com dados para acessar o banco de dados

  $base_d     =$_SESSION['base_d'];
  $banco_d    =$_SESSION['banco_d'];
  $usuario_d  =$_SESSION['usuario_d'];
  $senha_d    =$_SESSION['senha_d'];

  include ("campo_calendario.php");
  function get_post_action($name) {
    $params = func_get_args();
    foreach ($params as $name) {
        if (isset($_POST[$name])) {
            return $name;
        }
    }
  }
?>
<script>
    function zera_variaveis(){
       <?php
          unset($_SESSION['data_jogo_i']);
          unset($_SESSION['data_jogo_v']);
          unset($_SESSION['usuario']);
          unset($_SESSION['senha']);
       ?>
    }
</script>
<html>
<head>
<meta http-equiv="Content-Language" content="en-us">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta name="GENERATOR" content="Microsoft FrontPage 4.0">
<meta name="ProgId" content="FrontPage.Editor.Document">
<title>Pagina_entrada</title>
</head>

<body topmargin="0" leftmargin="0" onunload="zera_variaveis()">
   <?php
    switch (get_post_action('confirma','acessa')) {
         case 'acessa':
             $usuario  =$_POST['usuario'];
             $senha    =$_POST['senha'];
             
             // Verifica se o usuário é válido
             
             $con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
             $res = mysql_select_db($banco_d) or die ("Banco de dados inexistente");

             $declara = "SELECT codigo,nome
             FROM cad_membro
             WHERE ((usuario='$usuario') and (senha='$senha') and (ativo='S'))";

             $query = mysql_db_query($banco_d,$declara,$con) or die ("Não foi possivel acessar o banco");
             $achou = mysql_num_rows($query);
             
             If ($achou >0) {
                $_SESSION['abre_m']  =1;
                for($ic=0; $ic<$achou; $ic++){
                   $row = mysql_fetch_row($query);
                   $codigo_membro      = $row[0];
                   $nome_membro        = $row[1];
                }
                $_SESSION['codigo_membro_i'] =$codigo_membro;
              }
              else {
                  ?>
                  <script language="javascript"> window.location.href=("main.htm")
                     alert('Você não está autorizado a acessar esta rotina.');
                  </script>
                  <?php
                $_SESSION['abre_m']  =0;
              }
         break;
         case 'confirma':
              $data_jogo      =$_POST['data_jogo'];
              $membro         =$_SESSION['codigo_membro_i'];
              
              $_SESSION['data_jogo_v']   =$data_jogo;
              //mudando formato da data para gravar na tabela

              $data_jogo  = explode("/",$data_jogo);
              $v_data_jogo = $data_jogo[2]."-".$data_jogo[1]."-".$data_jogo[0];
              
              $_SESSION['data_jogo_i']  =$v_data_jogo;
              
              $con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
              $res = mysql_select_db($banco_d) or die ("Banco de dados inexistente");
              
              $verifi="SELECT codigo_membro FROM jogos
              WHERE ((codigo_membro='$membro')
              AND (data_jogo='$v_data_jogo'))";
              
              $query = mysql_db_query($banco_d,$verifi,$con) or die ("Não foi possivel acessar o banco");
              $achou_1 = mysql_num_rows($query);

              If ($achou_1 > 0 ) {
                 $apaga=1;
                 ?>
                 <script language="Javascript">
                     function AlexCT(opcao) {
                        if (opcao=="sim") {
                           window.location.href=("cancela_jogo.php");
                        }
                        if (opcao=="nao") {
                           window.location.href=("main.php");
                        }
                      }
                 </script>
                 <?php
              }
              else {
                  $apaga=0;
                  $inclusao = "INSERT INTO jogos (codigo_membro,data_jogo)
                  values('$membro','$v_data_jogo')";

                  if (mysql_db_query($banco_d,$inclusao,$con)) {
                     $resp_grava="Confirmação bem sucedida";
                     $data_jogo      ='';
                     $membro         ='';
                    }
                   else {
                     $resp_grava="Problemas na Confirmação";
                   }
              }
         break;
         default:
    }
    ?>
    </body>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
         <td colspan="1" align="left" width="45%"><INPUT type=button size="3" value="Ajuda"
               onClick="window.open('mostra_ajuda.php','janela_1',
               'scrollbars=yes,resizable=yes,width=400,height=700');" style="width:100;height:30;color=red;font: bold 16px Arial;">
         </td>
         <td colspan="1" color="white" align="right" width="45%" height="70"><a href="main.php"><img src="img/porta.gif" border="none"></td>
       </tr>
    </table>
	<table width="70%" border="1" cellpadding="5" cellspacing="0" bordercolor="#DEB887">
       <form name="cadastro" id="cadastro" action="confirma_jogo.php" method="post">
        <?php
          If ($_SESSION['abre_m']==0) {
            ?>
            <table style="HEIGHT:100%;WIDTH:100%;" border="0" width="96" cellspacing="0" cellpadding="0">
             <tr>
              <td width="20%" height="30">
                 <P><center><font face="arial" size="2" color="#00000"><b>Login:</b><input type="text" style="background-color: #cccccc" name="usuario" size="20" maxlength="20"></font></center></P>
                 <script language="JavaScript">
                   document.getElementById('usuario').focus()
                 </script>
                 <P><center><font face="arial" size="2" color="#00000"><b>Senha:</b><input type="password" style="background-color: #cccccc" name="senha" size="10" maxlength="10"></font></center></P>
                 <p><center><input name="acessa" type="submit" value="Acessar"></center>
              </td>
             </tr>
            </table>
        <?php
          }
	      IF ($_SESSION['abre_m']==1) {
	      ?>    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td color="white" align="center" width="100%" height="50">
                  </tr>
                </table>
                <table width="50%" border="1" cellpadding="5" cellspacing="0" bordercolor="#DEB887" align="center">
                   <tr>
                     <td><b>Data do Jogo :</b></td>
                     <td>
                       <input type="text" name="data_jogo" size="12" maxlength="12" id="data_jogo">
                       <input TYPE="button" NAME="btndata_jogo" VALUE="..." Onclick="javascript:popdate('document.cadastro.data_jogo','pop1','150',document.cadastro.data_jogo.value)">
                       <span id="pop1" style="position:absolute"></span>
                     </td>
                   </tr>
                   <tr>
                     <td><INPUT type=button value="Grupo confirmado"
                       onClick="window.open('mostra_confirmacao_jogo.php','janela_1',
                       'scrollbars=yes,resizable=yes,width=600,height=400');">
                     </td>
			         <td colspan="2">
				        <div align="right">
				          <input name="confirma" type="submit" value="Confirmar">
				        </div>
			         </td>
		           </tr>
		           <?php If ($apaga==1) {?>
                     <tr>
                       <?php
                          $data_jogo  =$_SESSION['data_jogo_v'];
                          $mensa="Você já confirmou sua participação no jogo do dia :$data_jogo ! Quer cancelar ?";
                       ?>
                       <td colspan="8" align="center"><?php echo "$mensa";?></td>
                     </tr>
		             <tr>
                       <td align="left"><a href="javascript:AlexCT('sim');" style="text-decoration:none"><font face="arial" size="3" color="red">Cancelar</font></a></td>
                       <td align="right"><a href="javascript:AlexCT('nao');" style="text-decoration:none"><font face="arial" size="3" color="red">Não Cancelar</font></a></td>
                     </tr>
                   <?php }?>
                 </table>
	      <?php
	      }
       ?>
    </table>
  </form>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
     <tr>
       <td color="white" align="center" width="100%" height="250">
     </tr>
  </table>
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
  <table border="0" width="100%" cellspacing="0" cellpadding="0" background="img/marron.jpg">
    <tr>
      <td width="100%" height="25" align="center"></font><font color="white" size="1" face="Arial">©&nbsp; COPYRIGHT NUNESTECH Tecnologia em Sistemas Ltda</font></td>
    </tr>
  </table>
</body>
</html>
