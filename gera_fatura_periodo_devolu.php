<?php
  session_start();
  require_once("pdf.php");
  function gera_fatura_periodo_devolu() {
     $dt_inicio  =$_SESSION['dt_inicio_m'];
     $dt_fim     =$_SESSION['dt_fim_m'];
     $v_soma     =$_SESSION['v_soma_m'];
     $v_total    =$_SESSION['v_tota_m'];
     $v_dt_inicio  = explode("-",$dt_inicio);
     $v_dt_inicio = $v_dt_inicio[2]."/".$v_dt_inicio[1]."/".$v_dt_inicio[0];
     $v_dt_fim  = explode("-",$dt_fim);
     $v_dt_fim = $v_dt_fim[2]."/".$v_dt_fim[1]."/".$v_dt_fim[0];
     $pdf = new PDF('L');
     $pdf->SetTotal("Total de HAWB´s :$v_total");
     $pdf->SetSoma("Total Faturamento Cliente :$v_soma");
     $pdf->SetName("Faturamento De $v_dt_inicio a $v_dt_fim");
     $pdf->SetCabecalho(" HAWB                           DATA          NOME DESTINATÁRIO                                                   RUA                                                                         NUM.     BAIRRO                                    CIDADE                        QT   UN     TOT");
     $pdf->Open();
     $pdf->AddPage();
     $pdf->SetFont('Arial', '', 7);
     $base_d     =$_SESSION['base_d'];
     $banco_d    =$_SESSION['banco_d'];
     $usuario_d  =$_SESSION['usuario_d'];
     $senha_d    =$_SESSION['senha_d'];
    // $remessa    =$_SESSION['remessa_m'];
     $con =mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
     $res =mysql_select_db($banco_d) or die ("Banco de dados inexistente");
     $result = mysql_query("SELECT n_hawb,date_format(dt_envio,'%d/%m/%Y'),nome_desti,
     rua_desti,numero_desti,bairro_desti,
     cidade_desti,qtdade,valor,(valor*qtdade) As vl_item
     FROM remessa
     WHERE ((dt_envio>='$dt_inicio')
     AND (dt_envio<='$dt_fim')
     AND (dt_envio<>'0000-00-00'))
     ORDER BY dt_envio");
     while ( $row = mysql_fetch_array($result) ) {
        $pdf->Cell(30, 5, $row[0], 0, 0);
        $pdf->Cell(15, 5, $row[1], 0, 0);
        $pdf->Cell(70, 5, $row[2], 0, 0);
        $pdf->Cell(65, 5, $row[3], 0, 0);
        $pdf->Cell(10, 5, $row[4], 0, 0);
        $pdf->Cell(40, 5, $row[5], 0, 0);
        $pdf->Cell(30, 5, $row[6], 0, 0);
        $pdf->Cell(5, 5, $row[7], 0, 0);
        $pdf->Cell(8, 5, $row[8], 0, 0);
        $pdf->Cell(8, 5, $row[9], 0, 1);
     }
     $pdf->Output();
     }
     gera_fatura_periodo_devolu();
?>
