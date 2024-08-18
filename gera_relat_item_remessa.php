<?php
  session_start();
  require_once("pdf.php");
  function gera_relat_item_remessa() {
     $remessa   =$_SESSION['remessa_m'];
     $v_soma    =$_SESSION['numero_m'];
     $pdf = new PDF('L');
     $pdf->SetSoma("Total itens enviados :$v_soma");
     $pdf->SetName("Itens da Remessa  :$remessa");
     $pdf->SetCabecalho(" HAWB              N. REMESSA          DATA           SERVIÇO                                  RUA                                                               NUM.                   BAIRRO                                   CIDADE");
     $pdf->Open();
     $pdf->AddPage();
     $pdf->SetFont('Arial', '', 7);
     $base_d     =$_SESSION['base_d'];
     $banco_d    =$_SESSION['banco_d'];
     $usuario_d  =$_SESSION['usuario_d'];
     $senha_d    =$_SESSION['senha_d'];
     $con =mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
     $res =mysql_select_db($banco_d) or die ("Banco de dados inexistente");
     $result = mysql_query("SELECT remessa.n_hawb,remessa.n_remessa,date_format(remessa.dt_remessa,'%d/%m/%Y'),
     serv_ati.descri_se,remessa.rua_desti,remessa.numero_desti,remessa.bairro_desti,remessa.cidade_desti
     FROM remessa,serv_ati
     WHERE ((remessa.n_remessa='$remessa')
     AND (remessa.co_servico=serv_ati.codigo_se))");
     while ( $row = mysql_fetch_array($result) ) {
        $pdf->Cell(20, 5, $row[0], 0, 0);
        $pdf->Cell(25, 5, $row[1], 0, 0);
        $pdf->Cell(15, 5, $row[2], 0, 0);
        $pdf->Cell(30, 5, $row[3], 0, 0);
        $pdf->Cell(75, 5, $row[4], 0, 0);
        $pdf->Cell(12, 5, $row[5], 0, 0);
        $pdf->Cell(40, 5, $row[6], 0, 0);
        $pdf->Cell(30, 5, $row[7], 0, 1);
     }
     $pdf->Output();
     }
     gera_relat_item_remessa();
?>
