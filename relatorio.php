<?php

function relatorio($tabela, $campos, $titulo="", $rotulo="-",$condicao)
{
//carrega as configurações
include("relatorio_cfg.php");
//faz a consulta no banco

$sql = "SELECT " . $campos . " FROM " . $tabela . " WHERE " . $condicao . "";

//faz a consulta e retorna o número de campos
$result =  mysql_query($sql);
$campos = mysql_num_fields($result);
//cria a tabela principal e a tabela da consulta
echo ("<table align=" . $altab . "><tr><font color=" . $corfontetit . " face=" . $fonte . " size=" . $fontetm . 
	"><div align=" . $altit . 
	"><b>" . $titulo . "</b></div></font><td></td></tr><tr><td>");
echo ("<table border=" . $borda . " bordercolor=" . $corborda .
" cellpadding= " . $cellp . " cellspacing=" . $cells . ">");
//verifica se há o parâmetro rótulo e toma a decisão
if ($rotulo!="-")
{
	$rot= explode(",", $rotulo);
	for ($i = 0; $i < $campos; $i++)
{
	echo "<td bgcolor=" . $corcampos . "><div align=" . $alcampos . 
	"><font color=" . $corfonte1 . " face=" . $fonte . " size=" . $fontetm . 
	"><b>" . $rot[$i] . "</b></font></div></td>";
}
}else
{
	for ($i = 0; $i < $campos; $i++)
{   
	echo "<td bgcolor=" . $corcampos . "><div align=" . $alcampos . 
	"><font color=" . $corfonte1 . " face=" . $fonte . " size=" . $fontetm . 
	">" . mysql_field_name($result, $i) . "</font></div></td>";
}
}
//exibe os resultados com as cores alternadas
$cor = 2;
while ($row = mysql_fetch_array($result))
{   switch ($cor)
	{
		case ($cor%2 == 0) :
		$corcampos = $cortab1;
		break;
		case ($cor%2 == 1) :
		$corcampos = $cortab2;
		break;
	}
	echo("<tr bgcolor=" . $corcampos . ">");
	for ($i = 0; $i < $campos; $i++)
	{
		echo("<td><div align=" . $altxt . "><font color=" . $corfonte2 . 
		" face=" . $fonte . " size=" . $fontetm . ">" . stripslashes($row["$i"]) . 
		"</font></div></td>");
	}
	echo("</tr>");
	$cor++;
}
//fecha a tabela
echo("</table></td></tr></table>");
//libera a memória do resultado
mysql_free_result($result);
}
?>
