<?php
  session_start();

 //carrega variaveis com dados para acessar o banco de dados

  $base_d     =$_SESSION['base_d'];
  $banco_d    =$_SESSION['banco_d'];
  $usuario_d  =$_SESSION['usuario_d'];
  $senha_d    =$_SESSION['senha_d'];

?>

<HTML>
<HEAD>
 <TITLE>mostra_classes_cep.php</TITLE>

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
<table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#4169E1">
 <tr>
    <td colspan="4" align="center" bgcolor="#444fff"><font face="arial" size="2"><b>RELA��O DE CLASSES DE CEP E VALOR</b></font></td>
 </tr>
 <tr>
     <td width="100%" align="center" td colspan="4" bgcolor="#444fff"><b>REGI�O PARAN�</b></td>
 </tr>
 <tr>
     <td width="40%" align="center" bgcolor="#444fff"><b>NOME CIDADE</b></td>
     <td width="20%" align="center" bgcolor="#444fff"><b>CLASSE CEP</b></td>
     <td width="40%" align="center" bgcolor="#444fff"><b>FAIXA DE CEP</b></td>
     <td width="40%" align="center" bgcolor="#444fff"><b>VALOR R$</b></td>
 </tr>
 <tr>
     <td width="40%" align="left">CURITIBA</td>
     <td width="20%" align="center">CAPITAL</td>
     <td width="30%" align="center">80000 - 82999</td>
     <td width="10%" align="center">80000 - 82999</td>
 </tr>
 <tr>
     <td width="40%" align="left">S�O JOS� DOS PINHAIS</td>
     <td width="20%" align="center">GRANDE CIDADE</td>
     <td width="40%" align="center">83000 - 83149</td>
 </tr>
 <tr>
     <td width="40%" align="left">PINHAIS</td>
     <td width="20%" align="center">GRANDE CIDADE</td>
     <td width="40%" align="center">83320 - 83349</td>
 </tr>
 <tr>
     <td width="40%" align="left">ARAUCARIA</td>
     <td width="20%" align="center">GRANDE CIDADE</td>
     <td width="40%" align="center">83700 - 83724</td>
 </tr>
 <tr>
     <td width="40%" align="left">ALMIRANTE TAMANDAR�</td>
     <td width="20%" align="center">INTERIOR</td>
     <td width="40%" align="center">83500 - 83529</td>
 </tr>
 <tr>
     <td width="40%" align="left">APUCARANA</td>
     <td width="20%" align="center">INTERIOR</td>
     <td width="40%" align="center">86800 - 86815</td>
 </tr>
 <tr>
     <td width="40%" align="left">ARAPONGAS</td>
     <td width="20%" align="center">INTERIOR</td>
     <td width="40%" align="center">86700 - 86714</td>
 </tr>
 <tr>
     <td width="40%" align="left">CAMB�</td>
     <td width="20%" align="center">INTERIOR</td>
     <td width="40%" align="center">86180 - 86195</td>
 </tr>
 <tr>
     <td width="40%" align="left">CAMPO LARGO</td>
     <td width="20%" align="center">INTERIOR</td>
     <td width="40%" align="center">83600 - 83640</td>
 </tr>
 <tr>
     <td width="40%" align="left">CACAVEL</td>
     <td width="20%" align="center">INTERIOR</td>
     <td width="40%" align="center">85800- 85820</td>
 </tr>
 <tr>
     <td width="40%" align="left">COLOMBO</td>
     <td width="20%" align="center">INTERIOR</td>
     <td width="40%" align="center">83400 - 83415</td>
 </tr>
 <tr>
     <td width="40%" align="left">CMPINA GRANDE DO SUL</td>
     <td width="20%" align="center">INTERIOR</td>
     <td width="40%" align="center">83430 - 83430</td>
 </tr>
 <tr>
     <td width="40%" align="left">FAZENDA RIO GRANDE</td>
     <td width="20%" align="center">INTERIOR</td>
     <td width="40%" align="center">83820 - 83835</td>
 </tr>
 <tr>
     <td width="40%" align="left">FOZ DO IGUA��</td>
     <td width="20%" align="center">INTERIOR</td>
     <td width="40%" align="center">85850 - 85871</td>
 </tr>
 <tr>
     <td width="40%" align="left">GUARAPUAVA</td>
     <td width="20%" align="center">INTERIOR</td>
     <td width="40%" align="center">85000 - 85099</td>
 </tr>
 <tr>
     <td width="40%" align="left">JANDAIA DO SUL</td>
     <td width="20%" align="center">INTERIOR</td>
     <td width="40%" align="center">86900 - 86900</td>
 </tr>
 <tr>
     <td width="40%" align="left">LONDRINA</td>
     <td width="20%" align="center">INTERIOR</td>
     <td width="40%" align="center">86000 - 86099</td>
 </tr>
 <tr>
     <td width="40%" align="left">MANDAGUARI</td>
     <td width="20%" align="center">INTERIOR</td>
     <td width="40%" align="center">86975 - 86975</td>
 </tr>
 <tr>
     <td width="40%" align="left">MARIALVA</td>
     <td width="20%" align="center">INTERIOR</td>
     <td width="40%" align="center">86990 - 86990</td>
 </tr>
 <tr>
     <td width="40%" align="left">MARINGA</td>
     <td width="20%" align="center">INTERIOR</td>
     <td width="40%" align="center">87000 - 87109</td>
 </tr>
 <tr>
     <td width="40%" align="left">PARANAGUA</td>
     <td width="20%" align="center">INTERIOR</td>
     <td width="40%" align="center">83200 - 83249</td>
 </tr>
 <tr>
     <td width="40%" align="left">PIRAGUARA</td>
     <td width="20%" align="center">INTERIOR</td>
     <td width="40%" align="center">84000 - 83318</td>
 </tr>
 <tr>
     <td width="40%" align="left">PONTA GROSSA</td>
     <td width="20%" align="center">INTERIOR</td>
     <td width="40%" align="center">86000 - 84099</td>
 </tr>
 <tr>
     <td width="40%" align="left">QUATRO BARRAS</td>
     <td width="20%" align="center">INTERIOR</td>
     <td width="40%" align="center">83420 - 83420</td>
 </tr>
 <tr>
     <td width="40%" align="left">ROLANDIA</td>
     <td width="20%" align="center">INTERIOR</td>
     <td width="40%" align="center">86600 - 86600</td>
 </tr>
 <tr>
     <td width="100%" align="center" td colspan="3" bgcolor="#444fff"><b>REGI�O SANTA CATARINA</b></td>
 </tr>
 <tr>
     <td width="40%" align="center" bgcolor="#444fff"><b>NOME CIDADE</b></td>
     <td width="20%" align="center" bgcolor="#444fff"><b>CLASSE CEP</b></td>
     <td width="40%" align="center" bgcolor="#444fff"><b>FAIXA DE CEP</b></td>
 </tr>
 <tr>
     <td width="40%" align="left">FLORIAN�POLIS</td>
     <td width="20%" align="center">CAPITAL</td>
     <td width="40%" align="center">88000 - 88099</td>
 </tr>
 <tr>
     <td width="40%" align="left">S�O JOS�</td>
     <td width="20%" align="center">GRANDE CIDADE</td>
     <td width="40%" align="center">88100 - 88123</td>
 </tr>
 <tr>
     <td width="40%" align="left">PALHO�A</td>
     <td width="20%" align="center">GRANDE CIDADE</td>
     <td width="40%" align="center">88130 - 88139</td>
 </tr>
 <tr>
     <td width="40%" align="left">BIGUA��</td>
     <td width="20%" align="center">GRANDE CIDADE</td>
     <td width="40%" align="center">88160 - 88160</td>
 </tr>
 <tr>
     <td width="40%" align="left">CHAPEC�</td>
     <td width="20%" align="center">INTERIOR</td>
     <td width="40%" align="center">89800 - 89816</td>
 </tr>
 <tr>
     <td width="40%" align="left">CRICI�MA</td>
     <td width="20%" align="center">INTERIOR</td>
     <td width="40%" align="center">88800 - 88819</td>
 </tr>
 <tr>
     <td width="40%" align="left">GUARAMIRIM</td>
     <td width="20%" align="center">INTERIOR</td>
     <td width="40%" align="center">89270 - 89270</td>
 </tr>
 <tr>
     <td width="40%" align="left">JARAGU� DO SUL</td>
     <td width="20%" align="center">INTERIOR</td>
     <td width="40%" align="center">89250 - 89269</td>
 </tr>
 <tr>
     <td width="40%" align="left">JOINVILLE</td>
     <td width="20%" align="center">INTERIOR</td>
     <td width="40%" align="center">89200 - 89239</td>
 </tr>
 <tr>
     <td width="40%" align="left">LAGES</td>
     <td width="20%" align="center">INTERIOR</td>
     <td width="40%" align="center">88500 - 88529</td>
 </tr>
 <tr>
     <td width="40%" align="left">SANTO AMARO DA IMPERATRIZ</td>
     <td width="20%" align="center">INTERIOR</td>
     <td width="40%" align="center">88140 - 88140</td>
 </tr>
 <tr>
     <td width="40%" align="left">S�O FRANCISCO DO SUL</td>
     <td width="20%" align="center">INTERIOR</td>
     <td width="40%" align="center">89240 - 89240</td>
 </tr>
 <tr>
     <td width="40%" align="left">TIJUCAS</td>
     <td width="20%" align="center">INTERIOR</td>
     <td width="40%" align="center">88200 - 88200</td>
 </tr>
 <tr>
     <td width="40%" align="left">TUBAR�O</td>
     <td width="20%" align="center">INTERIOR</td>
     <td width="40%" align="center">88700 - 88709</td>
 </tr>
 <tr>
     <td width="40%" align="left">ARAQUARI</td>
     <td width="20%" align="center">INTERIOR</td>
     <td width="40%" align="center">89245 - 89245</td>
 </tr>
 <tr>
     <td width="40%" align="left">BRUSQUE</td>
     <td width="20%" align="center">INTERIOR</td>
     <td width="40%" align="center">88350 - 88359</td>
 </tr>
 <tr>
     <td width="40%" align="left">CAMBORI�</td>
     <td width="20%" align="center">INTERIOR</td>
     <td width="40%" align="center">88340 - 88340</td>
 </tr>
 <tr>
     <td width="40%" align="left">INDAIAL</td>
     <td width="20%" align="center">INTERIOR</td>
     <td width="40%" align="center">89130 - 89130</td>
 </tr>
 <tr>
     <td width="40%" align="left">GASPAR</td>
     <td width="20%" align="center">INTERIOR</td>
     <td width="40%" align="center">89110 - 89110</td>
 </tr>
 <tr>
     <td width="40%" align="left">POMERODE</td>
     <td width="20%" align="center">INTERIOR</td>
     <td width="40%" align="center">89107 - 89107</td>
 </tr>
 <tr>
     <td width="40%" align="left">BALNE�RIO CAMBORI�</td>
     <td width="20%" align="center">INTERIOR</td>
     <td width="40%" align="center">88330 - 88339</td>
 </tr>
 <tr>
     <td width="40%" align="left">ITAJA�</td>
     <td width="20%" align="center">INTERIOR</td>
     <td width="40%" align="center">88300 - 88319</td>
 </tr>
 <tr>
     <td width="40%" align="left">NAVEGANTES</td>
     <td width="20%" align="center">INTERIOR</td>
     <td width="40%" align="center">88375 - 88375</td>
 </tr>
 <tr>
     <td width="40%" align="left">BLUMENAU</td>
     <td width="20%" align="center">INTERIOR</td>
     <td width="40%" align="center">89000 - 89099</td>
 </tr>
</table>
</div>
</BODY>
</HTML>
