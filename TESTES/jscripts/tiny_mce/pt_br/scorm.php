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
 * Strings for component 'scorm', language 'pt_br', branch 'MOODLE_20_STABLE'
 *
 * @package   scorm
 * @copyright 1999 onwards Martin Dougiamas  {@link http://moodle.com}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['activation'] = 'Ativação';
$string['activityloading'] = 'Você será redirecionado à atividade em';
$string['activitypleasewait'] = 'Carregando...';
$string['advanced'] = 'Parâmetros';
$string['areacontent'] = 'Arquivos de conteúdo';
$string['areapackage'] = 'Pacote de arquivos';
$string['asset'] = 'Recurso';
$string['assetlaunched'] = 'Recurso - Visto';
$string['attempt'] = 'tentativa';
$string['attempt1'] = '1 tentativa';
$string['attempts'] = 'Tentativas';
$string['attemptsx'] = '{$a} tentativas';
$string['attr_error'] = 'Valor errado para o atributo ({$a->attr}) na etiqueta (tag){$a->tag}.';
$string['autocontinue'] = 'Continuação Automática';
$string['autocontinuedesc'] = 'Esta opção define como padrão a continuação automática';
$string['autocontinue_help'] = '<p>Se Continuação Automática estiver assinalada como SIM, quando um SCO chamar o método "close communication", automaticamente o próximo SCO disponível será iniciado.</p>

<p>Se estiver assinalado NÃO, os usuários terão de usar o botão "Continue" para seguir adiante.</p>';
$string['averageattempt'] = 'Média de tentativas';
$string['badmanifest'] = 'Erros no manifesto: consulte o relatório de erros';
$string['badpackage'] = 'O pacote apresenta problemas. Controle e tente novamente';
$string['browse'] = 'Visitar';
$string['browsed'] = 'Visto';
$string['browsemode'] = 'Prévia';
$string['browserepository'] = 'Navegar no repositório';
$string['chooseapacket'] = 'Escolher ou atualizar um pacote';
$string['completed'] = 'Completado';
$string['confirmloosetracks'] = 'Atenção: provavelmente este pacote foi modificado. Se a estrutura for mudada, os registros das interações dos usuários podem ser perdidos durante a atualização';
$string['contents'] = 'Conteúdo';
$string['coursepacket'] = 'Pacote do curso';
$string['coursestruct'] = 'Estrutura do curso';
$string['currentwindow'] = 'Janela atual';
$string['datadir'] = 'Erro no sistema de arquivos: não é possível criar um diretório para os dados do curso';
$string['deleteallattempts'] = 'Remova todas as tentativas SCORM';
$string['details'] = 'Detalhes do registro';
$string['directories'] = 'Mostrar os links do diretório';
$string['display'] = 'Mostrar';
$string['displaydesc'] = 'Esta opção define se visualizar ou não o pacote em uma atividade';
$string['domxml'] = 'biblioteca DOMXML externa';
$string['duedate'] = 'Data duplicada';
$string['element'] = 'Elemento';
$string['enter'] = 'Entrar';
$string['entercourse'] = 'Entrar no curso';
$string['errorlogs'] = 'Relatório de erros';
$string['everyday'] = 'Todos os dias';
$string['everytime'] = 'Quando for usado';
$string['exceededmaxattempts'] = 'Você atingiu a número máximo de tentativas.';
$string['exit'] = 'Sair do curso SCORM';
$string['exitactivity'] = 'Sair da atividade';
$string['expired'] = 'Desculpe, este atividade fechada em {$a} e não está mais disponível';
$string['external'] = 'Atualizar o tempo nos pacotes externos';
$string['failed'] = 'Falhou';
$string['finishscormlinkname'] = 'clique aqui para voltar à página do curso';
$string['firstaccess'] = 'Primeiro acesso';
$string['firstattempt'] = 'Primeira tentativa';
$string['forcenewattempt'] = 'Forçar nova tentativa';
$string['found'] = 'Manifesto encontrado';
$string['frameheight'] = 'Configura a altura predefinida do frame utilizado';
$string['framewidth'] = 'Configura a largura predefinida do frame utilizado';
$string['fullscreen'] = 'Preencher toda a tela';
$string['general'] = 'Dados Gerais';
$string['gradeaverage'] = 'Média das notas';
$string['gradehighest'] = 'Nota mais alta';
$string['grademethod'] = 'Método de avaliação';
$string['grademethoddesc'] = 'Esta opção define a modalidade padrão de avaliação';
$string['grademethod_help'] = '<p>Os resultados de uma atividade SCORM/AICC mostrada nas Páginas de Avaliação podem ser calculados em vários modos:</p>
    <ul>
	<li><b>Estado dos SCOes</b><br />Este modo apresenta o número de SCOes completados na atividade. O valor máximo é o número de SCOes.</li>
	<li><b>Nota mais alta</b><br />A página de Avaliação irá mostrar o maior resultado obtido pelos usuários em todos os SCOes completados.</li>
	<li><b>Média das Notas</b><br />Caso você escolha este modo, o será calculada a média de todos os resultados.</li>
	<li><b>Soma de notas</b><br />Com este modo todos os resultados serão somados.</li>
</ul>';
$string['gradescoes'] = 'Objetos de aprendizagem';
$string['gradesum'] = 'Soma de notas';
$string['height'] = 'Altura';
$string['hidden'] = 'Escondido';
$string['hidebrowse'] = 'Esconder botão Prévia';
$string['hidebrowsedesc'] = 'Esta opção define se habilitar ou não a prévia';
$string['hidebrowse_help'] = '<p>Se essa opção estiver marcado como Sim, o botão de Prévia na página de visualização do pacote SCORM/AICC será escondido.</p>

<p>O aluno pode escolher prever a atividade (modo de navegação), ou tentar respondê-la, no modo normal.</p>

<p>Quando um Objeto de Aprendizado for completado no modo de prévia (navegação), ele fica marcado com o <img src="<?php echo $CFG->wwwroot.\'/mod/scorm/pix/browsed.gif\' ?>" alt="<?php print_string(\'browsed\',\'scorm\') ?>" title="<?php print_string(\'browsed\',\'scorm\') ?>" /> ícone de navegação.</p>';
$string['hideexit'] = 'Esconder o botão Sair';
$string['hidenav'] = 'Esconder botões de navegação';
$string['hidenavdesc'] = 'Esta opção define se mostrar ou ocultar os botões de navegação';
$string['hidereview'] = 'Esconder o botão Revisão';
$string['hidetoc'] = 'Esconder estrutura do curso na janela de execução';
$string['hidetocdesc'] = 'Esta opção define se mostrar ou ocultar a estrutura de navegação do curso';
$string['highestattempt'] = 'Tentativa mais alta';
$string['identifier'] = 'Identificador da questão';
$string['incomplete'] = 'Incompleto';
$string['info'] = 'Info';
$string['interactions'] = 'Interações';
$string['last'] = 'Último acesso em';
$string['lastaccess'] = 'Último acesso';
$string['lastattempt'] = 'Última tentativa';
$string['lastattemptlock'] = 'Bloqueio após tentativa final';
$string['location'] = 'Mostrar a barra de endereço';
$string['max'] = 'Pontuação máxima';
$string['maximumattempts'] = 'Número de tentativas';
$string['maximumattemptsdesc'] = 'Esta opção define o padrão para número máximo de tentativas';
$string['maximumattempts_help'] = '<p>Isso define o número de tentativas permitidas ao usuário.<br />Isso funciona apenas com pacotes SCORM1.2 e AICC. SCORM2004 tem sua pŕopria definição do número máximo de tentativas</p>';
$string['maximumgradedesc'] = 'Esta opção define o padrão para o cálculo da pontuação máxima';
$string['menubar'] = 'Mostrar a barra de menu';
$string['min'] = 'Pontuação mínima';
$string['missing_attribute'] = 'Falta o atributo {$a->attr} na etiqueta {$a->tag}';
$string['missingparam'] = 'Um requisito está faltando ou está errado';
$string['missing_tag'] = 'Falta etiqueta {$a->tag}';
$string['mode'] = 'Modalidade';
$string['modulename'] = 'SCORM/AICC';
$string['modulenameplural'] = 'SCORMs/AICCs';
$string['navigation'] = 'Navegação';
$string['newattempt'] = 'Começar uma nova tentativa';
$string['next'] = 'Próxima';
$string['noactivity'] = 'Nenhum registro';
$string['noattemptsallowed'] = 'Número de tentativas permitidas';
$string['noattemptsmade'] = 'Número de tentativas feitas';
$string['no_attributes'] = 'Etiqueta {$a->tag} deve ter atributos';
$string['no_children'] = 'Etiqueta {$a->tag} deve ter filhos';
$string['nolimit'] = 'Tentativas ilimitadas';
$string['nomanifest'] = 'O manifesto não foi encontrado';
$string['noprerequisites'] = 'Infelizmente você ainda não alcançou o nível de requisitos necessário para acessar este recurso de aprendizagem';
$string['noreports'] = 'Nenhum relatório disponível';
$string['normal'] = 'Normal';
$string['noscriptnoscorm'] = 'O seu navegador não é compatível com javascript ou o javascript não está habilitado. O funcionamento deste recurso pode ser afetado.';
$string['notattempted'] = 'Nenhuma tentativa';
$string['not_corr_type'] = 'Erro de associação de tipos na etiqueta {$a->tag}';
$string['notopenyet'] = 'Desculpe, esta atividade não está disponível até {$a}';
$string['objectives'] = 'Objetivos';
$string['onchanges'] = 'Sempre que mudar';
$string['optallstudents'] = 'todos usuários';
$string['optattemptsonly'] = 'somente usuários com tentativas';
$string['options'] = 'Opções';
$string['optnoattemptsonly'] = 'somente usuários sem tentativas';
$string['organization'] = 'Organização';
$string['organizations'] = 'Organizações';
$string['othersettings'] = 'Parâmetros adicionais';
$string['othertracks'] = 'Outros registros';
$string['package'] = 'Arquivo do pacote';
$string['packagedir'] = 'Erro no sistema de arquivos: não é possível criar um diretório para o pacote';
$string['packagefile'] = 'Nenhum arquivo de pacote definido';
$string['package_help'] = '<p>O pacote é um arquivo  particular  com  Extensão <b>zip</b> (ou pif) que contém
   arquivos válidos de definição do curso AICC ou SCORM.</p>

<p>Um pacote  <b>SCORM</b> deve conter no diretório principal do zip um arquivo com o nome  <b>imsmanifest.xml</b>
   que define a estrutura do curso SCORM, a localização dos recursos e outras informações.</p>

<p>Um pacote  <b>AICC</b> é definida por diversos arquivos (de 4 a 7) com extensões definidas.
   Este é o significado das extensões:</p>
   <ul>
	<li>CRS - Course Description file (obrigatório)</li>
	<li>AU  - Assignable Unit file (obrigatório)</li>
	<li>DES - Descriptor file (obrigatório)</li>
	<li>CST - Course Structure file (obrigatório)</li>
	<li>ORE - Objective Relationship file (opcional)</li>
	<li>PRE - Prerequisites file (opcional)</li>
	<li>CMP - Completition Requirements file (opcional)</li>
   </ul>';
$string['packageurl'] = 'URL';
$string['pagesize'] = 'Tamanho da página';
$string['passed'] = 'Completado';
$string['php5'] = 'PHP 5 (library DOMXML nativa)';
$string['pluginname'] = 'Pacote SCORM';
$string['popup'] = 'Nova janela';
$string['popupmenu'] = 'Em uma caixa de listagem';
$string['popupopen'] = 'Abrir pacote em nova janela';
$string['position_error'] = 'A etiqueta {$a->tag} não pode ser filha de {$a->parent}';
$string['preferencespage'] = 'Preferências apenas para esta página';
$string['preferencesuser'] = 'Preferências para este relatório';
$string['prev'] = 'Anterior';
$string['raw'] = 'Pontuação';
$string['regular'] = 'Manifesto correto';
$string['report'] = 'Relatório';
$string['resizable'] = 'permitir o redimensionamento da janela';
$string['result'] = 'Resultado';
$string['results'] = 'Resultados';
$string['review'] = 'Rever';
$string['reviewmode'] = 'Modalidade de revisão';
$string['scoes'] = 'Objetos de Aprendizagem';
$string['score'] = 'Resultado';
$string['scormclose'] = 'Até';
$string['scormcourse'] = 'Curso SCORM';
$string['scorm:deleteresponses'] = 'Excluir tentativas SCORM';
$string['scormloggingoff'] = 'API Logging desabilitado';
$string['scormloggingon'] = 'API Logging habilitado';
$string['scormresponsedeleted'] = 'Excluir tentativas do usuário';
$string['scorm:savetrack'] = 'Salvar caminhos';
$string['scorm:skipview'] = 'Pular introdução';
$string['scormtype'] = 'Tipo';
$string['scorm:viewreport'] = 'Ver relatórios';
$string['scorm:viewscores'] = 'Ver pontuação';
$string['scrollbars'] = 'Permitir o rolamento da janela';
$string['selectall'] = 'Selecionar todos';
$string['selectnone'] = 'Desmarcar todos';
$string['show'] = 'Exibir';
$string['sided'] = 'Ao lado esquerdo';
$string['skipview'] = 'O estudante salta a página de menu';
$string['skipviewdesc'] = 'Esta opção define o padrão relativo a quando saltar a estrutura de conteúdos de uma página';
$string['skipview_help'] = '<p>Se você adicionar pacotes com apenas um Objeto de Aprendizado, você pode permitir que o Moodle salte a página de estrutura de conteúdo quando os usuários clicarem numa atividade do SCORM, na página do curso.</p>

<p>Você pode escolher:</p>

   <ul>
       <li><strong>Nunca</strong> saltar a página de estrutura do conteúdo</li> 
       <li><strong>Primeiro acesso</strong> saltar a página de estrutura do conteúdo apenas na primeira vez</li> 
       <li><strong>Sempre</strong> saltar a página de estrutura do conteúdo</li> 
   </ul>';
$string['slashargs'] = 'Atenção: slash arguments está desabilitado neste site e isto pode afetar o funcionamento dos objetos';
$string['stagesize'] = 'Tamanho da Tela/Frame';
$string['stagesize_help'] = '<p>Essas duas opções definema altura e a largura da janela/frame dos Objetos de Aprendizado.</p>';
$string['started'] = 'Iniciado em';
$string['status'] = 'Estado';
$string['statusbar'] = 'Mostrar a barra de estado';
$string['student_response'] = 'Resposta';
$string['suspended'] = 'Suspenso';
$string['syntax'] = 'Erro de sintaxe';
$string['tag_error'] = 'Etiqueta desconhecida ({$a->tag}) com o seguinte conteúdo: {$a->value}';
$string['time'] = 'Duração';
$string['timerestrict'] = 'Restringir resposta para este período de tempo';
$string['title'] = 'Título';
$string['toolbar'] = 'Mostrar a barra de instrumentos';
$string['too_many_attributes'] = 'Etiqueta {$a->tag} tem atributos demais';
$string['too_many_children'] = 'Etiqueta {$a->tag} tem filhos demais';
$string['totaltime'] = 'Tempo';
$string['trackingloose'] = 'Atenção: os dados relativos ao tracking deste pacote serão cancelados!';
$string['type'] = 'Tipo';
$string['typelocal'] = 'Pacote enviado';
$string['typelocalsync'] = 'Pacote baixado';
$string['unziperror'] = 'Um erro acontece durante o unzip do pacote';
$string['updatefreq'] = 'Frequência de auto-atualização';
$string['updatefreqdesc'] = 'Esta opção define o padrão de frequência de auto;atualização';
$string['validateascorm'] = 'Convalidar pacote';
$string['validation'] = 'Resultado da convalidação';
$string['validationtype'] = 'Esta preferência define a biblioteca DOMXML usada para validar o manifesto SCORM. Se você não tem certeza sobre o que fazer, mantenha a escolha atual.';
$string['value'] = 'Valor';
$string['versionwarning'] = 'A versão do manifesto é anterior à 1.3, atenção à etiqueta {$a->tag}';
$string['viewallreports'] = 'Ver relatório de {$a} tentativas';
$string['viewalluserreports'] = 'Ver relatórios de {$a} usuários';
$string['whatgrade'] = 'Tentativas avaliadas';
$string['whatgradedesc'] = 'Esta opção define o padrão de avaliação das tentativas';
$string['whatgrade_help'] = '<p>Quando você permitir tentativas múltipaas para os usuários, você pode escolher como usar os resultados dessas tentativas no relatório de notas.</p>';
$string['width'] = 'Largura';
$string['window'] = 'Frame/Janela';
