<?php
     if ( session_status() !== PHP_SESSION_ACTIVE ) {
        session_start();
     }
  
     // para evitar estouro de memoria
     ini_set('memory_limit', '256M');
  
     include('conexao_free.php');
	 mysqli_set_charset($con,'UTF8');
	 
     $descri_se  =$_SESSION['descri_se_m'];
     $nome_cli   =$_SESSION['nome_cli_m'];
     $codi_cli   =$_SESSION['cliente_m'];
     $servico    =$_SESSION['servico_m'];
     $dt_inicio  =$_SESSION['dt_inicio_m'];
     $dt_fim     =$_SESSION['dt_fim_m'];
	 
     $v_dt_inicio  = explode("-",$dt_inicio);
     $v_dt_inicio = $v_dt_inicio[2]."/".$v_dt_inicio[1]."/".$v_dt_inicio[0];
     $v_dt_fim  = explode("-",$dt_fim);
     $v_dt_fim = $v_dt_fim[2]."/".$v_dt_fim[1]."/".$v_dt_fim[0];
	 
	 //Cria a estrutura do relatório para impressão.
	$html='<table>';
     $html.='<thead style="font-family: Arial, Tahoma, sans-serif; font-size:12px">';
      $html.='<tr>';
          $html.='<td colspan=9 align=center>Faturamento: Cliente:'.$nome_cli.' - Serviço :'.$descri_se.' - Período :'.$v_dt_inicio.' A '.$v_dt_fim.'</td>';	  
	  $html.='</tr>';
	  $html.='<tr>';	 
	      $html.='<td colspan=9 align=center>------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------</td>';
	  $html.='</tr>';
	  $html.='<tr>';
	   $html.='<td><b>HAWB</b></td>';
	   $html.='<td><b>N. REMESSA</b></td>';
	   $html.='<td><b>DATA</b></td>';
	   $html.='<td><b>DESTINATÁRIO</b></td>';
	   $html.='<td><b>BAIRRO</b></td>';
	   $html.='<td><b>CIDADE</b></td>';
	   $html.='<td><b>QTD</b></td>';
	   $html.='<td><b>UN</b></td>';
	   $html.='<td><b>TOTAL</b></td>';
	  $html.='</tr>';	  
	  $html.='<tr>';	 
	      $html.='<td colspan=9 align=center>------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------</td>';
	  $html.='</tr>';
	 $html.='</thead>';
	 $pega_dados = mysqli_query($con,"SELECT n_hawb,n_remessa,date_format(dt_remessa,'%d/%m/%Y'),nome_desti,
     bairro_desti,cidade_desti,qtdade,classe_cep,co_servico,codi_cli,valor
     FROM remessa
     WHERE ((remessa.co_servico='$servico')
     AND (remessa.codi_cli='$codi_cli')
     AND (remessa.dt_remessa>='$dt_inicio')
     AND (remessa.dt_remessa<='$dt_fim'))
     ORDER BY dt_remessa");
	 $total = mysqli_num_rows($pega_dados);
	 $ni=1;
	 $li=1;
	 $totger =0.00;
	 for($i=0; $i<$total; $i++){
		$dados = mysqli_fetch_row($pega_dados);
		$n_hawb        = $dados[0];
		$n_remessa     = $dados[1];
		$dt_remessa    = $dados[2];
		$nome_desti    = $dados[3];
		$bairro_desti  = $dados[4];
		$cidade_desti  = $dados[5];
		$qtdade        = $dados[6];
		$classe_cep    = $dados[7];
		$codi_servi    = $dados[8];
		$codi_cli      = $dados[9];
		$valor_un      = $dados[10];
		
		$html.='<tr>';
		  $html.='<td style="font-family: Arial, Tahoma, sans-serif; font-size:9px">'.$n_hawb.'</td>';
		  $html.='<td style="font-family: Arial, Tahoma, sans-serif; font-size:9px">'.$n_remessa.'</td>';
		  $html.='<td style="font-family: Arial, Tahoma, sans-serif; font-size:9px">'.$dt_remessa.'</td>';
		  $html.='<td style="font-family: Arial, Tahoma, sans-serif; font-size:9px">'.$nome_desti.'</td>';
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
				  if(isset($valor)) {
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
		  $li++;
        $html.='</tr>';
	 }
	 $html.='<tr>';	 
	      $html.='<td colspan=9 align=center>---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------</td>';
	 $html.='</tr>';
	 $html.='<tr>';
	     $totger  = number_format($totger, 2, ',', '.');
	     $html.='<td colspan=9 align=center>TOTAL DE PODS  : '.$ni.' -  VALOR TOTAL :'.$totger.'</td>';
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
  // Definindo o papel e a orientação
  $dompdf->setPaper('A4', 'Landscape');
  // Renderizando o HTML como PDF
  $dompdf->render();
  // Enviando o PDF para o browser
  $f;$l; if(headers_sent($f,$l)) {echo $f,'',$l,''; die('now detect line');}
  $dompdf->stream('document.pdf',array('Attachment'=>0));	 
?>

