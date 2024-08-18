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
 * Strings for component 'workshop', language 'pt_br', branch 'MOODLE_20_STABLE'
 *
 * @package   workshop
 * @copyright 1999 onwards Martin Dougiamas  {@link http://moodle.com}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['accesscontrol'] = 'Controle de acesso';
$string['aggregategrades'] = 'Notas re-calculadas';
$string['aggregation'] = 'Agregação de notas';
$string['allocate'] = 'Alocar envios';
$string['allocatedetails'] = 'esperado: {$a->expected}<br />enviado: {$a->submitted}<br /> alocado para: {$a->allocate}';
$string['allocation'] = 'Alocação de envio';
$string['allocationdone'] = 'Alocação concluída';
$string['allocationerror'] = 'Erro de alocação';
$string['allsubmissions'] = 'Todos os envios';
$string['alreadygraded'] = 'Já foi avaliada';
$string['areainstructauthors'] = 'Instruções para envio';
$string['areainstructreviewers'] = 'Instruções para avaliação';
$string['areasubmissionattachment'] = 'Anexos do envio';
$string['areasubmissioncontent'] = 'Textos enviados';
$string['assess'] = 'Avaliar';
$string['assessedexample'] = 'Exemplo enviado avaliado';
$string['assessedsubmission'] = 'Envio avaliado';
$string['assessingexample'] = 'Avaliação de exemplo enviado';
$string['assessingsubmission'] = 'Avaliação de envio';
$string['assessmentbyknown'] = 'Avaliado por {$a}';
$string['assessmentbyunknown'] = 'Avaliação';
$string['assessmentbyyourself'] = 'Avaliação por você mesmo';
$string['assessmentdeleted'] = 'Avaliação desalocada';
$string['assessmentend'] = 'Prazo da avaliação';
$string['assessmentenddatetime'] = 'Prazo da avaliação: {$a->daydatetime} ({$a->distanceday})';
$string['assessmentform'] = 'Formulário de avaliação';
$string['assessmentofsubmission'] = '<a href="{$a->assessmenturl}">Avaliação</a> de <a href="{$a->submissionurl}">{$a->submissiontitle}</a>';
$string['assessmentsettings'] = 'Configurações da avaliação';
$string['assessmentstart'] = 'Aberto a partir de';
$string['assessmentweight'] = 'Peso da avaliação';
$string['backtoeditform'] = 'Voltar para formulário de edição';
$string['byfullname'] = 'por <a href="{$a->url}">{$a->name}</a>';
$string['calculategradinggrades'] = 'Calcular notas de avaliação';
$string['calculategradinggradesdetails'] = 'esperado: {$a->expected}<br />calculado: {$a->calculated}';
$string['calculatesubmissiongrades'] = 'Calcular notas de envios';
$string['calculatesubmissiongradesdetails'] = 'esperado: {$a->expected}<br />calculado: {$a->calculated}';
$string['chooseuser'] = 'Escolher usuário...';
$string['clearaggregatedgrades'] = 'Limpar todas as notas agregadas';
$string['clearassessments'] = 'Limpar avaliações';
$string['createsubmission'] = 'Enviar';
$string['daysago'] = '{$a} dias atrás';
$string['daysleft'] = '{$a} dias passados';
$string['daystoday'] = 'hoje';
$string['daystomorrow'] = 'amanhã';
$string['daysyesterday'] = 'ontem';
$string['editassessmentform'] = 'Editar formuário de avaliação';
$string['editassessmentformstrategy'] = 'Editar formuário de avaliação ({$a})';
$string['editingassessmentform'] = 'Ediçao de formuário de avaliação';
$string['editingsubmission'] = 'Ediçao de tarefa enviada';
$string['editsubmission'] = 'Editar tarefa enviada';
$string['example'] = 'Exemplos de tarefa enviada';
$string['exampleadd'] = 'Adicionar exemplo de tarefa enviada';
$string['exampleassess'] = 'Avaliar exemplo de tarefa enviada';
$string['exampleassessments'] = 'Exemplos de tarefas enviadas para avaliar';
$string['exampleassesstask'] = 'Avaliar exemplos';
$string['examplecomparing'] = 'Comparação de avaliações de exemplos de tarefas enviadas';
$string['exampledelete'] = 'Excluir example';
$string['exampleedit'] = 'Editar exemplos';
$string['exampleediting'] = 'Edição de exemplos';
$string['exampleneedassessed'] = 'Você tem que avaliar todos os exemplos tarefas enviadas primeiro';
$string['exampleneedsubmission'] = 'Você tem que enviar seu trabalho e avaliar todos os exemplos de tarefas enviadas primeiro';
$string['examplesbeforeassessment'] = 'Exemplos estão disponíveis depois de seu próprio envio e devem ser avaliados antes ';
$string['examplesbeforesubmission'] = 'Exemplo devem ser avaliados antes de seu próprio envio';
$string['examplesmode'] = 'Modo de avaliação de exemplos';
$string['examplesubmissions'] = 'Exemplos de tarefas enviadas';
$string['examplesvoluntary'] = 'Avaliação de exemplo de tarefa enviada é voluntária';
$string['feedbackauthor'] = 'Retorno para o autor';
$string['feedbackreviewer'] = 'Retorno para o crítico';
$string['formataggregatedgrade'] = '{$a->grade}';
$string['formataggregatedgradeover'] = '<del>{$a->grade}</del><br /><ins>{$a->over}</ins>';
$string['formatpeergrade'] = '<span class="grade">{$a->grade}</span> <span class="gradinggrade">({$a->gradinggrade})</span>';
$string['formatpeergradeover'] = '<span class="grade">{$a->grade}</span> <span class="gradinggrade">(<del>{$a->gradinggrade}</del> / <ins>{$a->gradinggradeover}</ins>)</span>';
$string['formatpeergradeoverweighted'] = '<span class="grade">{$a->grade}</span> <span class="gradinggrade">(<del>{$a->gradinggrade}</del> / <ins>{$a->gradinggradeover}</ins>)</span> @ <span class="weight">{$a->weight}</span>';
$string['formatpeergradeweighted'] = '<span class="grade">{$a->grade}</span> <span class="gradinggrade">({$a->gradinggrade})</span> @ <span class="weight">{$a->weight}</span>';
$string['givengrades'] = 'Notas dadas';
$string['gradecalculated'] = 'Nota calculada para envio';
$string['gradedecimals'] = 'Casas decimais nas notas';
$string['gradegivento'] = '&gt;';
$string['gradeinfo'] = 'Nota: {$a->received} de {$a->max}';
$string['gradeitemassessment'] = '{$a->workshopname} (avaliação)';
$string['gradeitemsubmission'] = '{$a->workshopname} (envio)';
$string['gradeover'] = 'Sobrescrever nota para envio';
$string['gradereceivedfrom'] = '&lt;';
$string['gradesreport'] = 'Relatório de notas do workshop';
$string['gradinggrade'] = 'Grade de Notas';
$string['gradinggradecalculated'] = 'Nota calculada para avaliação';
$string['gradinggrade_help'] = 'Esta configuração espeifica a nota máxima que pode ser obtida para uma avaliação de envio.';
$string['gradinggradeof'] = 'Nota para avaliação (de{$a})';
$string['gradinggradeover'] = 'Sobrescrever nota para avaliação';
$string['gradingsettings'] = 'Configurações de nota';
$string['iamsure'] = 'Sim, eu tenha certeza';
$string['info'] = 'Informação';
$string['instructauthors'] = 'Instruções para envio';
$string['instructreviewers'] = 'Instruções para avaliação';
$string['introduction'] = 'Introdução';
$string['latesubmissions'] = 'Envios atrasados';
$string['latesubmissionsallowed'] = 'Envios atrasados são permitidos';
$string['latesubmissions_desc'] = 'Aceitar envios após o prazo estipulado';
$string['maxbytes'] = 'Tamanho máximo do arquivo';
$string['modulename'] = 'Laboratório de Avaliação';
$string['modulenameplural'] = 'Laboratórios de Avaliação';
$string['mysubmission'] = 'Meu envio';
$string['nattachments'] = 'Número máximo de anexos enviados';
$string['noexamples'] = 'Nenhum exemplo ainda neste workshop';
$string['noexamplesformready'] = 'Você deve definir o formulário de avaliação antes de prover os envios de exemplo';
$string['nogradeyet'] = 'Nenhuma nota ainda';
$string['nosubmissionfound'] = 'Nenhum envio encontrado para este usuário';
$string['nosubmissions'] = 'Nenhum envio neste workshop';
$string['notassessed'] = 'Nada avaliado ainda';
$string['nothingtoreview'] = 'Nada para o crítico';
$string['notoverridden'] = 'Não sobrescrito';
$string['noworkshops'] = 'Não existem workshops neste curso';
$string['noyoursubmission'] = 'Você não enviou seu trabalho ainda';
$string['nullgrade'] = '-';
$string['participant'] = 'Participante';
$string['participantrevierof'] = 'Participante é crítico de';
$string['participantreviewedby'] = 'Participante é criticado por';
$string['phaseassessment'] = 'Fase de avaliação';
$string['phaseclosed'] = 'Encerrado';
$string['phasesetup'] = 'Configurar fase';
$string['phasesubmission'] = 'Fase de envio';
$string['pluginadministration'] = 'Adminstração do workshop';
$string['pluginname'] = 'Laboratório de Avaliação';
$string['previewassessmentform'] = 'Preview';
$string['publishedsubmissions'] = 'Documentos enviados publicados';
$string['publishsubmission'] = 'Publicar documentos enviados';
$string['reassess'] = 'Reavaliar';
$string['receivedgrades'] = 'Notas recebidas';
$string['recentassessments'] = 'Avaliações do workshop:';
$string['recentsubmissions'] = 'Tarefas enviadas do workshop:';
$string['saveandclose'] = 'Salvar e sair';
$string['saveandcontinue'] = 'Salvar e continuar edição';
$string['saveandpreview'] = 'Salvar e pré-visualizar';
$string['selfassessmentdisabled'] = 'Auto-avaliação desativada';
$string['someuserswosubmission'] = 'Existe pelo menos um autor que ainda não enviou seu trabalho';
$string['sortasc'] = 'Ordenação crescente';
$string['sortdesc'] = 'Ordenação decrescente';
$string['submission'] = 'Tarefa enviada';
$string['submissionattachment'] = 'Anexo';
$string['submissionby'] = 'Tarefa enviada por {$a}';
$string['submissioncontent'] = 'Conteúdo enviado';
$string['submissionend'] = 'Prazo dos envios';
$string['submissionenddatetime'] = 'Prazo dos envios: {$a->daydatetime} ({$a->distanceday})';
$string['submissiongrade'] = 'Nota para envio';
$string['submissiongrade_help'] = 'Esta configuração especifica a nota máxima que pode ser obtida pelos trabalhos enviados.';
$string['submissiongradeof'] = 'Notar para envio (de{$a})';
$string['submissionsettings'] = 'Configurações de envio';
$string['submissionstart'] = 'Início dos envios';
$string['submissiontitle'] = 'Título';
$string['switchingphase'] = 'Mudança de fase';
$string['switchphase'] = 'Mudar fase';
$string['taskassesspeersdetails'] = 'total: {$a->total}<br/>pendente: {$a->todo}';
$string['taskassessself'] = 'Avaliar você mesmo';
$string['taskinstructauthors'] = 'Prover instruções para envio';
$string['taskinstructreviewers'] = 'Prover instruções para avaliação';
$string['taskintro'] = 'Atribua a introdução do workshop';
$string['tasksubmit'] = 'Enviar seu trabalho';
$string['toolbox'] = 'Barra de ferramentas do workshop';
$string['undersetup'] = 'O workshop está sendo configurado. Por favor espere até que ele mude pra a próxima fase.';
$string['useexamples'] = 'Usar exemplos';
$string['usepeerassessment_desc'] = 'Alunos podem avaliar o trabalho dos outros';
$string['userdatecreated'] = 'enviado em <span>{$a}</span>';
$string['userdatemodified'] = 'modificado em <span>{$a}</span>';
$string['userplan'] = 'Planejador do workshop';
$string['useselfassessment'] = 'Usar auto-avaliação';
$string['useselfassessment_desc'] = 'Alunos podem avaliar seus próprios trabalhos';
$string['weightinfo'] = 'Peso: {$a}';
$string['withoutsubmission'] = 'Crítico sem envio próprio';
$string['workshop:allocate'] = 'Alicar envios para crítico';
$string['workshop:editdimensions'] = 'Editar formuários de avaliação';
$string['workshopfeatures'] = 'Recursos do workshop';
$string['workshop:manageexamples'] = 'Gerenciar envios de exemplo';
$string['workshopname'] = 'Nome do workshop';
$string['workshop:overridegrades'] = 'Sobrescrever as notas calculadas';
$string['workshop:publishsubmissions'] = 'Publicar envios';
$string['workshop:submit'] = 'Enviar';
$string['workshop:switchphase'] = 'Mudar faser';
$string['workshop:view'] = 'Visualizar workshop';
$string['workshop:viewallassessments'] = 'Visualizar todas avaliações';
$string['workshop:viewallsubmissions'] = 'Visualizar todos envios';
$string['workshop:viewauthornames'] = 'Visualizar todos nomes de autores';
$string['workshop:viewpublishedsubmissions'] = 'Visualizar todos os envios publicados';
$string['workshop:viewreviewernames'] = 'Visualizar todos nomes de críticos';
$string['yoursubmission'] = 'Seu envio';
