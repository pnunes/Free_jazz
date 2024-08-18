<?php
 session_start();

  $base_d     =$_SESSION['base_d'];
  $banco_d    =$_SESSION['banco_d'];
  $usuario_d  =$_SESSION['usuario_d'];
  $senha_d    =$_SESSION['senha_d'];

  $cliente    = $_POST['cliente'];
  $mes_ano    = $_POST['mes_ano'];
  $dt_venci   = $_POST['dt_venci'];
  
  //Pega os dados do cliente

  $con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
  $res = mysql_select_db($banco_d) or die ("Banco de dados inexistente");

  $pega = "SELECT cnpj_cpf,nome,rua,numero,bairro,cidade,cep,uf FROM cli_for WHERE cnpj_cpf='$cliente'";
  $query = mysql_db_query($banco_d,$pega,$con) or die ("Não foi possivel acessar o banco");
  $total = mysql_num_rows($query);
  for($ic=0; $ic<$total; $ic++){
     $row = mysql_fetch_row($query);
     $cnpj        = $row[0];
     $nome        = $row[1];
     $rua         = $row[2];
     $numero      = $row[3];
     $bairro      = $row[4];
     $cidade      = $row[5];
     $cep         = $row[6];
     $estado      = $row[7];
  }

$rg = $cnpj;
$endereco = $rua." - ".$numero." - ".$bairro;

$con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
$res = mysql_select_db($banco_d) or die ("Banco de dados inexistente");

$soma = "SELECT sum(vl_fatu) AS tot_fatu
FROM faturamento
WHERE ((codi_cli='$cliente')AND (mes_ano='$mes_ano'))";
$vtotal = mysql_db_query($banco_d,$soma,$con) or die ("Não foi possivel acessar o banco 2");
$total = mysql_num_rows($vtotal);

for($ic=0; $ic<$total; $ic++){
   $row = mysql_fetch_row($vtotal);
   $v_soma          = $row[0];
}
// +----------------------------------------------------------------------+
// | BoletoPhp - Versão Beta                                              |
// +----------------------------------------------------------------------+
// | Este arquivo está disponível sob a Licença GPL disponível pela Web   |
// | em http://pt.wikipedia.org/wiki/GNU_General_Public_License           |
// | Você deve ter recebido uma cópia da GNU Public License junto com     |
// | esse pacote; se não, escreva para:                                   |
// |                                                                      |
// | Free Software Foundation, Inc.                                       |
// | 59 Temple Place - Suite 330                                          |
// | Boston, MA 02111-1307, USA.                                          |
// +----------------------------------------------------------------------+

// +----------------------------------------------------------------------+
// | Originado do Projeto BBBoletoFree que tiveram colaborações de Daniel |
// | William Schultz e Leandro Maniezo que por sua vez foi derivado do	  |
// | PHPBoleto de João Prado Maia e Pablo Martins F. Costa			       	  |
// | 																	                                    |
// | Se vc quer colaborar, nos ajude a desenvolver p/ os demais bancos :-)|
// | Acesse o site do Projeto BoletoPhp: www.boletophp.com.br             |
// +----------------------------------------------------------------------+

// +----------------------------------------------------------------------+
// | Equipe Coordenação Projeto BoletoPhp: <boletophp@boletophp.com.br>   |
// | Desenvolvimento Boleto Bradesco: Ramon Soares						            |
// +----------------------------------------------------------------------+


// ------------------------- DADOS DINÂMICOS DO SEU CLIENTE PARA A GERAÇÃO DO BOLETO (FIXO OU VIA GET) -------------------- //
// Os valores abaixo podem ser colocados manualmente ou ajustados p/ formulário c/ POST, GET ou de BD (MySql,Postgre,etc)	//

// DADOS DO BOLETO PARA O SEU CLIENTE
$dias_de_prazo_para_pagamento = 5;
$taxa_boleto = 2.95;
$data_venc = $dt_venci;  // Prazo de X dias OU informe data: "13/04/2006";
//$data_venc = date("d/m/Y", time() + ($dias_de_prazo_para_pagamento * 86400));  // Prazo de X dias OU informe data: "13/04/2006";
$valor_cobrado = $v_soma; // Valor - REGRA: Sem pontos na milhar e tanto faz com "." ou "," ou com 1 ou 2 ou sem casa decimal
$valor_cobrado = str_replace(",", ".",$valor_cobrado);
$valor_boleto=number_format($valor_cobrado+$taxa_boleto, 2, ',', '');

$dadosboleto["nosso_numero"] = "75896452";  // Nosso numero sem o DV - REGRA: Máximo de 11 caracteres!
$dadosboleto["numero_documento"] = $dadosboleto["nosso_numero"];	// Num do pedido ou do documento = Nosso numero
$dadosboleto["data_vencimento"] = $data_venc; // Data de Vencimento do Boleto - REGRA: Formato DD/MM/AAAA
$dadosboleto["data_documento"] = date("d/m/Y"); // Data de emissão do Boleto
$dadosboleto["data_processamento"] = date("d/m/Y"); // Data de processamento do boleto (opcional)
$dadosboleto["valor_boleto"] = $valor_boleto; 	// Valor do Boleto - REGRA: Com vírgula e sempre com duas casas depois da virgula

// DADOS DO SEU CLIENTE
$dadosboleto["sacado"] = "$nome CNPJ: $rg";
$dadosboleto["endereco1"] = "$endereco";
$dadosboleto["endereco2"] = "$cidade - $estado - CEP: $cep";

// INFORMACOES PARA O CLIENTE
$dadosboleto["demonstrativo1"] = "Pagamento de Serviços Prestados por Transportes Free Jazz Ltda ME.";
$dadosboleto["demonstrativo2"] = "Taxa Bloqueto - R$ ".$taxa_boleto;
$dadosboleto["demonstrativo3"] = "Site Free Jazz - http://www.freejazz.net.br";
$dadosboleto["instrucoes1"] = "- Sr. Caixa, cobrar multa de 2% após o vencimento";
$dadosboleto["instrucoes2"] = "- Receber até 10 dias após o vencimento";
$dadosboleto["instrucoes3"] = "- Em caso de dúvidas entre em contato conosco: freejazz@freejazz.net.br";
//$dadosboleto["instrucoes4"] = "&nbsp; Emitido pelo sistema Projeto BoletoPhp - www.boletophp.com.br";

// DADOS OPCIONAIS DE ACORDO COM O BANCO OU CLIENTE
$dadosboleto["quantidade"] = "001";
$dadosboleto["valor_unitario"] = $valor_boleto;
$dadosboleto["aceite"] = "";		
$dadosboleto["uso_banco"] = ""; 	
$dadosboleto["especie"] = "R$";
$dadosboleto["especie_doc"] = "DS";


// ---------------------- DADOS FIXOS DE CONFIGURAÇÃO DO SEU BOLETO --------------- //


// DADOS DA SUA CONTA - Bradesco
$dadosboleto["agencia"] = "1172"; // Num da agencia, sem digito
$dadosboleto["agencia_dv"] = "0"; // Digito do Num da agencia
$dadosboleto["conta"] = "0403005"; 	// Num da conta, sem digito
$dadosboleto["conta_dv"] = "2"; 	// Digito do Num da conta

// DADOS PERSONALIZADOS - Bradesco
$dadosboleto["conta_cedente"] = "0403005"; // ContaCedente do Cliente, sem digito (Somente Números)
$dadosboleto["conta_cedente_dv"] = "2"; // Digito da ContaCedente do Cliente
$dadosboleto["carteira"] = "06";  // Código da Carteira

// SEUS DADOS
//$dadosboleto["identificacao"] = "BoletoPhp - Código Aberto de Sistema de Boletos";
$dadosboleto["cpf_cnpj"] = "03.103.519/0001-93";
$dadosboleto["endereco"] = "Rua Conselheiro Laurindo, 809 - Conj. 704";
$dadosboleto["cidade_uf"] = "Centro - Curitiba - PR";
$dadosboleto["cedente"] = "Transportes Free Jazz Ltda. ME.";

// NÃO ALTERAR!
include("funcoes_bradesco.php");
include("layout_bradesco.php");
?>

