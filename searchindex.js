// search index for WYSIWYG Web Builder
var database_length = 0;

function SearchPage(url, title, keywords, description)
{
   this.url = url;
   this.title = title;
   this.keywords = keywords;
   this.description = description;
   return this;
}

function SearchDatabase()
{
   database_length = 0;
   this[database_length++] = new SearchPage("Index.html�", "Transportes Free Jazz", "transportes free jazz nbsp copyright todos os direitos reservadoswww transportesfj com br home empresa servi�os onde estamos contato solicite nossos fone cel nextel id liga agenda coleta em rota de entrega realizada curitiba pr s�o jos� sc ", "");
   this[database_length++] = new SearchPage("Empresa.htm�", "Transportes Free Jazz", "transportes free jazz nbsp h� mais de dez anos no mercado ltda me est� com sua matriz em curitiba pr filial s�o jos� sc conta parceiros todo estado que atua tranportes uma empresa solu��es integradas log�stica servi�os personalizados formada por duas divis�es na presta��o manuseio coleta entregas agregando valor pela seguran�a agilidade efici�ncia qual desempenha os processos log�sticos al�m disso oferece m�o obra especializada para execu��o diferenciados exclusivos modulados acordo necessidade seus clientes oferecemos espec�ficas atendimento das necessidades cada neg�cio alto n�vel efic�cia adequando otimizando mesmos ocorram tempo condi��es formas desejadas buscando sempre excel�ncia nossas contribuem positivamente resultados dos nossos tanto procuramos superar as expectativas nova entrega novo servi�o garantir sucesso do transporte produtos at� destino final m�todos sofisticados modernos desenvolvimento projetos primando todos detalhes tudo isso ocorra temos equipe profissionais altamente capacitados qualificados atuar todas atividades log�sticas home onde estamos contato copyright direitos reservadoswww transportesfj br ", "");
   this[database_length++] = new SearchPage("Servicos.htm�", "Transportes Free Jazz", "transportes free jazz nbsp preocupada em proporcionar aos seus clientes solu��es log�sticas adequadas �s necessidades espec�ficas tranportes ltda me oferece diversos formatos para melhor utiliza��o de sua estrutura bem como otimiza��o servi�os tal dispomos motocicletas ve�culos que devem ser adequados cada tipo servi�o al�m disso acreditamos excel�ncia nossa presta��o seja conseq��ncia direta da maneira tratamos as particularidades opera��o por isso dos aqui descritos nos comprometemos oferecer qualquer solu��o log�stica ventura mais adequada primamos pelo bom desempenho do nosso trabalho pela maximiza��o esfor�os visando contribuir positiva eficaz com das atividades executadas manuseio documentos ou correspond�ncias vales brindes produtos transporte malotes coleta entrega similares cargas utilizando se utilit�rios entregas departamentalizadas monitoradas exclusivos expressas urgentes pequeno porte guarda entre outros home empresa onde estamos contato copyright todos os direitos reservadoswww transportesfj br ", "");
   this[database_length++] = new SearchPage("Onde_Estamos.htm�", "Transportes Free Jazz", "transportes free jazz nbsp exibir mapa ampliado home empresa servi�os onde estamos contato curitiba prrua conselheiro laurindo sala centrocep s�o jos� scrua joinvile bela vista icep copyright todos os direitos reservadoswww transportesfj com br ", "");
   this[database_length++] = new SearchPage("Contatos.htm�", "Transportes Free Jazz", "transportes free jazz nbsp �assunto do contato� �nome� �e mail� �mensagem� �telefone� home empresa servi�os onde estamos contato para entrar em preencha nosso formul�rio ou por nossos telefones abaixo curitiba prfone cel nextel s�o jos� scfone copyright todos os direitos reservadoswww transportesfj com br ", "");
   return this;
}
