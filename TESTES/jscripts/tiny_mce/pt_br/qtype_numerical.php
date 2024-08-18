<?php

// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Strings for component 'qtype_numerical', language 'pt_br', branch 'MOODLE_20_STABLE'
 *
 * @package   qtype_numerical
 * @copyright 1999 onwards Martin Dougiamas  {@link http://moodle.com}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['addingnumerical'] = 'Adicionando uma pergunta numérica';
$string['addmoreanswerblanks'] = 'Vazio em {no} Outras Respostas';
$string['addmoreunitblanks'] = 'Vazio em {no} Outras Unidades';
$string['answermustbenumberorstar'] = 'A resposta deve ser um número ou \'*\'.';
$string['answerno'] = 'Resposta {$a}';
$string['decfractionofquestiongrade'] = 'como fração decimal (0-1) da avaliação da pergunta';
$string['decfractionofresponsegrade'] = 'como fração decimal (0-1) da avaliação da resposta';
$string['editableunittext'] = 'Texto elemento de entrada';
$string['editingnumerical'] = 'Editando uma pergunta Numérica';
$string['errornomultiplier'] = 'Você tem que definir um multiplicador para esta unidade.';
$string['errorrepeatedunit'] = 'Duas unidades não podem ter o mesmo nome.';
$string['instructions'] = 'Instruções';
$string['leftexample'] = 'ESQUERDA, como em $1.00';
$string['manynumerical'] = 'Somente a RESPOSTA NUMÉRICA será avaliada utilizando unidades opcionais';
$string['nonvalidcharactersinnumber'] = 'Caracteres INVÁLIDOS em números';
$string['notenoughanswers'] = 'Você tem que definir pelo menos uma resposta.';
$string['numerical'] = 'Numérico';
$string['numerical_help'] = 'Na perspectiva do aluno, uma questão numérica parece exatamente uma pergunta de resposta curta. A diferença é que as respostas numéricas têm permissão de ter uma margem de erro. Isso permite um intervalo fixo de respostas a ser avaliada como uma resposta. Por exemplo, se a resposta é 10, com uma margem de erro 2, então qualquer número entre 8 e 12 serão aceitos como corretos.
';
$string['numericalinstructions'] = 'Instruções';
$string['numericalinstructions_help'] = 'Instruções específicas relacionadas com a pergunta

* Exemplos de formatos de números 
* Unidades complexas';
$string['numericalmultiplier'] = 'Multiplicador';
$string['numericalmultiplier_help'] = 'O multiplicador é o fator pelo qual a resposta numérica correta será multiplicado. 

A primeira unidade (Unidade 1) tem um padrão multiplicador de 1, assim, se a resposta numérica correta é 5500 e você definir W como unidade na Unidade 1, que tem como 1 como multiplicador padrão, a resposta correta é 5500 W. 

Se você adicionar a unidade de kW com um multiplicador de 0,001, isto irá resultar em uma resposta correta 5,5 kW. Isto significa que tanto as respostas 5500W, como 5.5kW serão consideradas corretas. 

Note-se que a margem de erro também é aceita, logo um erro permitido de 100W passa a ser um erro de 0.1kW.';
$string['numericalsummary'] = 'Permite uma resposta numérica, possivelmente com unidades, que é avaliada pela comparação com vários modelos de respostas, possivelmente com tolerâncias.';
$string['oneunitshown'] = 'Somente a RESPOSTA NUMÉRICA será avaliada Unidade 1 será mostrada';
$string['onlynumerical'] = 'Somente a RESPOSTA NUMÉRICA será avaliada. Unidades não serão permitidas.';
$string['rightexample'] = 'DIREITA, como em 1.00cm';
$string['selectunit'] = 'Seleciocionar uma unidade';
$string['selectunits'] = 'Selecionar unidades';
$string['studentunitanswer'] = 'Mostratr UNIDADE DE RESPOSTA como';
$string['unitappliedpenalty'] = 'Estas marcas incluem uma penalidade de {$a} para unidades erradas';
$string['unitchoice'] = 'Múltipla escolha (elementos rádio)';
$string['unitdisplay'] = '<STRONG> Unidade 1 exibida </ STRONG>';
$string['unitedit'] = 'Editar unidade';
$string['unitgraded'] = 'Serão avaliadas RESPOSTA NUMÉRICA e RESPOSTA DE UNIDADE';
$string['unitgraded1'] = '	
<STRONG>UNIDADE AVALIADA</STRONG>';
$string['unithdr'] = 'Unidade {$a}';
$string['unitmandatory'] = 'Obrigatório';
$string['unitmandatory_help'] = '* A resposta vai ser avaliada de acordo com a unidade escrita.
* A penalidade de unidade será aplicada se o campo unidade estiver vazio';
$string['unitnotselected'] = 'Nenhuma unidade selecionada';
$string['unitnotused'] = '<STRONG>UNIDADE NÃO UTILIZADA</STRONG>';
$string['unitnotvalid'] = 'A unidade não é válida com este valor numérico';
$string['unitoptional'] = 'Unidade opcional';
$string['unitoptional_help'] = '* Se o campo unidade não estiver vazio, a resposta vai ser avaliada de acordo com essa unidade.
* Se a unidade for mal escrita ou desconhecida, a resposta será considerada como não válida.';
$string['unitpenalty'] = 'Penalidade de unidade';
$string['unitpenalty_help'] = 'A penalidade é aplicada se:

* Um nome indefinido de unidade é indicado no elemento de resposta \'Unidade\'
* O nome da unidade é indicado no elemento de resposta \'Número\'';
$string['unitposition'] = 'Posição da unidade';
$string['unitshandling'] = 'Unidades gerenciadas';
$string['unitsused'] = '	
<STRONG>UNIDADE UTILIZADA</STRONG>';
$string['unitunknown'] = 'Unidade indefinida';
$string['unituses_help'] = 'A(s) unidade (s) é(são) a(s) utilização(ões) como nas verões anteriores à do Moodle 2.0 

* O estudante pode responder utilizando unidades pré-definidas pelo professor 
* nesse caso, a constante será aplicada ao valor do estudante;
* caso o aluno não adicionar nenhuma unidade, sua resposta numérica é utilizada como apresentada.
';
$string['validnumberformats'] = 'Formatos válidos de números';
$string['validnumberformats_help'] = '* números regulares 13500.67 : 13 500.67 : 13500,67: 13 500,67 

* se você utilizar vírgula (,) como separador de milhares, SEMPRE utilize ponto (.) como separador de decimais, como em 13,500.67 : 13,500. 

* para formato de expoente para 1.350067 * 10<sup>4</sup>, use 1.350067 E4 : 1.350067 E04';
