<?php
  //Chamando a classe TCFPDF
  require_once('tcpdf/tcpdf.php');
  
  // criando um novo documento com TCFPDF
  $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
  
  // definindo a fonte
  // $pdf->SetFont('arial', '', 12);

  // adicionando uma pagina
  $pdf->AddPage();
  
  // saida do arquivo HTML
  $pdf->writeHTML('imagem_hawb.php', true, 0, true, 0);

  //fecha e imprime o documento

  $pdf->Output();

  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
 
?>

