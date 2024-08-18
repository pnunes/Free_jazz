<?php
  session_start();
  require_once("pdf.php");
  function gera_relat() {
     $nome_entregador   =$_SESSION['nome_entregador_m'];
     $pdf = new PDF('P');
     $pdf->SetName("Relação de Entregas de :$nome_entregador");
     $pdf->SetCabecalho(" HAWB                   NOME DESTINATÁRIO                    RUA                                                    NUM.       BAIRRO           CIDADE");
     $pdf->Open();
     $pdf->AddPage();
     $pdf->SetFont('Arial', '', 7);
     $entregador =$_SESSION['entregador_m'];
     $con = mysql_connect("localhost", "root", "nunesp") or die ("Erro de conexão");
     $res = mysql_select_db("free_jazz") or die ("Banco de dados inexistente");
     $result = mysql_query("SELECT n_hawb,nome_desti,rua_desti,
     numero_desti,bairro_desti,cidade_desti
     FROM remessa
     WHERE ((entregador='$entregador')
     AND (recebedor='') AND (entregador<>'')
     OR (volta_lista='S'))");
     while ( $row = mysql_fetch_array($result) ) {
        $pdf->Cell(30, 5, $row[0], 0, 0);
        $pdf->Cell(60, 5, $row[1], 0, 0);
        $pdf->Cell(60, 5, $row[2], 0, 0);
        $pdf->Cell(15, 5, $row[3], 0, 0);
        $pdf->Cell(25, 5, $row[4], 0, 0);
        $pdf->Cell(20, 5, $row[5], 0, 1);
        //$pdf->Cell(30, 5, $row[6], 0, 1);
     }
     $pdf->Output();
     }
     gera_relat();
?>
