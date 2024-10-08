<HTML>
<HEAD>
 <TITLE>Documento PHP</TITLE>
</HEAD>
<BODY>
<?

  require_once("pdf.php");
  function PDFClientes() {
    $pdf = new PDF('L'); // relat�rio em orienta��o "paisagem"

    $pdf->SetName("Listagem de Clientes");
    $pdf->Open();
    $pdf->AddPage();
    $pdf->SetFont('Arial', '', 10);
    $result = BDQuery("SELECT c.codigo,c.nome,l.tipo,l.nome,
                    c.numero,b.nome,c.telefone,DATE_FORMAT(c.nasc,'%d/%m/%Y'),c.cpf,c.rg,cep.cepid,cep.cidade
                    FROM clientes as c, logradouros as l, bairros as b, cep
                    WHERE (c.logradouro= l.codigo AND c.bairro = b.bid AND c.cep = cep.cepid)ORDER BY c.nome");
    while ( $row = BDRowArray($result) ) {
          $pdf->Cell(10, 5, $row[0], 0, 0);
          $pdf->Cell(80, 5, $row[1], 0, 0);
          $pdf->Cell(75, 5, $row[2]." ".$row[3].", ".$row[4], 0, 0);
          $pdf->Cell(40, 5, $row[5], 0, 0);
          $pdf->Cell(25, 5, $row[6], 0, 0);
          $pdf->Cell(20, 5, $row[7], 0, 0);
          $pdf->Cell(30, 5, $row[8], 0, 1);
    }
    $pdf->Output();
}
PDFClientes();

?>
</BODY>
</HTML>
