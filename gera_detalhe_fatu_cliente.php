<?php
     if ( session_status() !== PHP_SESSION_ACTIVE ) {
       session_start();
     }
	 // para evitar estouro de memoria
     ini_set('memory_limit', '256M');
	
     //carrega variaveis com dados para acessar o banco de dados
 
     Include('conexao_free.php');
     mysqli_set_charset($con,'UTF8');
	
	 //pega as variaveis globais mandadas pela rotina - rela_fatura_cliente
	 $dt_inicio  =$_SESSION['dt_inicio_m'];
     $dt_fim     =$_SESSION['dt_fim_m'];
	 
	 //altera formato da data para mostrar no cabeçalho do relatorio
	 $dt_inicio_r  = explode("-",$dt_inicio);
	 $v_dt_inicio = $dt_inicio_r[2]."/".$dt_inicio_r[1]."/".$dt_inicio_r[0];

	 $dt_fim_r  = explode("-",$dt_fim);
	 $v_dt_fim = $dt_fim_r[2]."/".$dt_fim_r[1]."/".$dt_fim_r[0];
	 
	 //pega dados do cliente das variaveis globais
	 $nome_cli   =$_SESSION['nome_cli_m'];
     $cliente    =$_SESSION['cliente_m'];
     
	 //estrutura html do relatorio
	 
	 //Cria a estrutura do relatório para impressão.
	$html='<table>';
     $html.='<thead style="font-family: Arial, Tahoma, sans-serif; font-size:12px">';
      $html.='<tr>';	 
	      $html.='<td colspan=8 align=center>FATURAMENTO CLIENTE  : '.$nome_cli.' PERÍODO : '.$v_dt_inicio.'  A  '.$v_dt_fim.'</td>';
	  $html.='</tr>';
	 //$html.='</thead>';
	  $html.='<tr>';	 
	      $html.='<td colspan=8 align=center>------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------</td>';
	  $html.='</tr>';
	  $html.='<tr>';
	   $html.='<td><b>HAWB</b></td>';
	   $html.='<td><b>DATA</b></td>';
	   $html.='<td><b>DESTINATÁRIO</b></td>';
	   $html.='<td><b>SERVIÇO</b></td>';
	   $html.='<td><b>BAIRRO</b></td>';
	   $html.='<td><b>CIDADE</b></td>';
	   $html.='<td><b>QTD</b></td>';
	   $html.='<td><b>UN</b></td>';
	   $html.='<td><b>TOTAL</b></td>';
	  $html.='</tr>';	  
	  $html.='<tr>';	 
	      $html.='<td colspan=8 align=center>------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------</td>';
	  $html.='</tr>';
	 $html.='</thead>';
	 
	 //pega os dados no banco
	 $pega_fatu_cli = mysqli_query($con,"SELECT remessa.n_hawb,date_format(remessa.dt_remessa,'%d/%m/%Y'),
     remessa.nome_desti,serv_ati.descri_se,remessa.bairro_desti,remessa.cidade_desti,remessa.qtdade,
     remessa.classe_cep,remessa.co_servico,remessa.codi_cli,remessa.valor
     FROM remessa,serv_ati
     WHERE ((trim(remessa.codi_cli)='$cliente')
     AND (remessa.co_servico=serv_ati.codigo_se)
     AND (remessa.dt_remessa>='$dt_inicio')
     AND (remessa.dt_remessa<='$dt_fim'))
     ORDER BY remessa.dt_remessa");
	 $total = mysqli_num_rows($pega_fatu_cli);
	 $ni=0;
	// $li=1;
	 $totger =0.00;
	 for($i=0; $i<$total; $i++){
		$dados = mysqli_fetch_row($pega_fatu_cli);
		$n_hawb        = $dados[0];
		$dt_remessa    = $dados[1];
		$nome_desti    = $dados[2];
		$servico       = $dados[3];
		$bairro_desti  = $dados[4];
		$cidade_desti  = $dados[5];
		$qtdade        = $dados[6];
		$classe_cep    = $dados[7];
		$codi_servi    = $dados[8];
		$codi_cli      = $dados[9];
		$valor_un      = $dados[10];
		$html.='<tr>';
		  $html.='<td style="font-family: Arial, Tahoma, sans-serif; font-size:9px">'.$n_hawb.'</td>';
		  $html.='<td style="font-family: Arial, Tahoma, sans-serif; font-size:9px">'.$dt_remessa.'</td>';
		  $html.='<td style="font-family: Arial, Tahoma, sans-serif; font-size:9px">'.$nome_desti.'</td>';
		  $html.='<td style="font-family: Arial, Tahoma, sans-serif; font-size:9px">'.$servico.'</td>';
		  $html.='<td style="font-family: Arial, Tahoma, sans-serif; font-size:9px">'.$bairro_desti.'</td>';
		  $html.='<td style="font-family: Arial, Tahoma, sans-serif; font-size:9px">'.$cidade_desti.'</td>';
		  $html.='<td style="font-family: Arial, Tahoma, sans-serif; font-size:9px">'.$qtdade.'</td>';
		  if($classe_cep<>'04' AND $classe_cep<>'03') {
			  $localiza="SELECT valor FROM tabela_preco WHERE codi_cli='$codi_cli' AND classe_cep='$classe_cep' AND tipo_servi='$codi_servi'";
              $query_1 = mysqli_query($con,$localiza) or die ("Não foi possivel acessar o banco (pega valor)");
              $total_1 = mysqli_num_rows($query_1);
			  if($total_1 > 0) {
                 for($ic=0; $ic < $total_1; $ic++){
                    $row = mysqli_fetch_row($query_1);
                    $valor             = $row[0];
                 }
				 $valor_v   = number_format($valor, 2, ',', '.');
			     $html.='<td style="font-family: Arial, Tahoma, sans-serif; font-size:9px">'.$valor_v.'</td>';
		         $total_v   = $qtdade*$valor;
			     $totger = $totger+$total_v;
                 $total_v   = number_format($total_v, 2, ',', '.');
                 $html.='<td style="font-family: Arial, Tahoma, sans-serif; font-size:9px">'.$total_v.'</td>';
              }
              else {
                 $valor = 0.00;
				 $html.='<td style="font-family: Arial, Tahoma, sans-serif; font-size:9px">'.$valor.'</td>';
				 $total_v = 0.00;
				 $html.='<td style="font-family: Arial, Tahoma, sans-serif; font-size:9px">'.$total_v.'</td>';
              }				  
	      } 
		  else {
			  $valor_f   = number_format($valor_un, 2, ',', '.');
		      $html.='<td style="font-family: Arial, Tahoma, sans-serif; font-size:9px">'.$valor_f.'</td>';
		      $total_i   = $qtdade*$valor_un;
			  $totger = $totger+$total_i;
              $total_i  = number_format($total_i, 2, ',', '.');
              $html.='<td style="font-family: Arial, Tahoma, sans-serif; font-size:9px">'.$total_i.'</td>';  
		  }
		  $ni++;
		 // $li++;
        $html.='</tr>';
	 }
	 $html.='<tr>';	 
	      $html.='<td colspan=8 align=center>---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------</td>';
	 $html.='</tr>';
	 $html.='<tr>';
	     $totger  = number_format($totger, 2, ',', '.');
	     $html.='<td colspan=8 align=center>TOTAL DE PODS  : '.$ni.' -  VALOR TOTAL :'.$totger.'</td>';
	 $html.='</tr>';
  $html.='</table>';
   
  require_once 'dompdf/autoload.inc.php';
  // referenciando o namespace do dompdf
  use Dompdf\Dompdf;
  // instanciando o dompdf
  $dompdf = new Dompdf();
  //lendo o arquivo HTML correspondente
  /*$html = file_get_contents('exemplo.html');*/
  //inserindo o HTML que queremos converter
  $dompdf->loadHtml($html);
  // Definindo o papel e a orientação do mesmo
  $dompdf->setPaper('A4', 'Landscape');
  // Renderizando o HTML como PDF
  $dompdf->render();
  // Enviando o PDF para o browser
  $dompdf->stream('document.pdf',array('Attachment'=>0));
	 
?>