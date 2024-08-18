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
   this[database_length++] = new SearchPage("Index.html ", "Transportes Free Jazz", "transportes free jazz nbsp copyright todos os direitos reservadoswww transportesfj com br home empresa serviços onde estamos contato solicite nossos fone cel nextel id liga agenda coleta em rota de entrega realizada curitiba pr são josé sc ", "");
   this[database_length++] = new SearchPage("Empresa.htm ", "Transportes Free Jazz", "transportes free jazz nbsp há mais de dez anos no mercado ltda me está com sua matriz em curitiba pr filial são josé sc conta parceiros todo estado que atua tranportes uma empresa soluções integradas logística serviços personalizados formada por duas divisões na prestação manuseio coleta entregas agregando valor pela segurança agilidade eficiência qual desempenha os processos logísticos além disso oferece mão obra especializada para execução diferenciados exclusivos modulados acordo necessidade seus clientes oferecemos específicas atendimento das necessidades cada negócio alto nível eficácia adequando otimizando mesmos ocorram tempo condições formas desejadas buscando sempre excelência nossas contribuem positivamente resultados dos nossos tanto procuramos superar as expectativas nova entrega novo serviço garantir sucesso do transporte produtos até destino final métodos sofisticados modernos desenvolvimento projetos primando todos detalhes tudo isso ocorra temos equipe profissionais altamente capacitados qualificados atuar todas atividades logísticas home onde estamos contato copyright direitos reservadoswww transportesfj br ", "");
   this[database_length++] = new SearchPage("Servicos.htm ", "Transportes Free Jazz", "transportes free jazz nbsp preocupada em proporcionar aos seus clientes soluções logísticas adequadas às necessidades específicas tranportes ltda me oferece diversos formatos para melhor utilização de sua estrutura bem como otimização serviços tal dispomos motocicletas veículos que devem ser adequados cada tipo serviço além disso acreditamos excelência nossa prestação seja conseqüência direta da maneira tratamos as particularidades operação por isso dos aqui descritos nos comprometemos oferecer qualquer solução logística ventura mais adequada primamos pelo bom desempenho do nosso trabalho pela maximização esforços visando contribuir positiva eficaz com das atividades executadas manuseio documentos ou correspondências vales brindes produtos transporte malotes coleta entrega similares cargas utilizando se utilitários entregas departamentalizadas monitoradas exclusivos expressas urgentes pequeno porte guarda entre outros home empresa onde estamos contato copyright todos os direitos reservadoswww transportesfj br ", "");
   this[database_length++] = new SearchPage("Onde_Estamos.htm ", "Transportes Free Jazz", "transportes free jazz nbsp exibir mapa ampliado home empresa serviços onde estamos contato curitiba prrua conselheiro laurindo sala centrocep são josé scrua joinvile bela vista icep copyright todos os direitos reservadoswww transportesfj com br ", "");
   this[database_length++] = new SearchPage("Contatos.htm ", "Transportes Free Jazz", "transportes free jazz nbsp  assunto do contato   nome   e mail   mensagem   telefone  home empresa serviços onde estamos contato para entrar em preencha nosso formulário ou por nossos telefones abaixo curitiba prfone cel nextel são josé scfone copyright todos os direitos reservadoswww transportesfj com br ", "");
   return this;
}
