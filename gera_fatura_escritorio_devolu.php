<?php
  session_start();
  require_once("pdf.php");
  function gera_fatura_escritorio_devolu() {
     $nome_escri =$_SESSION['nome_escri_m'];
     $escritorio =$_SESSION['escritorio_m'];
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
     $pdf->SetSoma("Total Faturamento Escritorio :$v_soma");
     $pdf->SetName("Faturamento Serviço :$nome_escri - De $v_dt_inicio a $v_dt_fim");
     $pdf->SetCabecalho(" HAWB                           DATA          SERVIÇO                      NOME DESTINATÁRIO                                     RUA                                                              NUM.         BAIRRO                        CIDADE                     QT    UN    TOT");
     $pdf->Open();
     $pdf->AddPage();
     $pdf->SetFont('Arial', '', 6);
     $base_d     =$_SESSION['base_d'];
     $banco_d    =$_SESSION['banco_d'];
     $usuario_d  =$_SESSION['usuario_d'];
     $senha_d    =$_SESSION['senha_d'];
     $con =mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
     $res =mysql_select_db($banco_d) or die ("Banco de dados inexistente");
     $result = mysql_query("SELECT remessa.n_hawb,date_format(remessa.dt_envio,'%d/%m/%Y'),
     serv_ati.descri_se,remessa.nome_desti,remessa.rua_desti,remessa.numero_desti,remessa.bairro_desti,
     remessa.cidade_desti,remessa.qtdade,remessa.valor,(remessa.valor*remessa.qtdade) As vl_item
     FROM remessa,serv_ati
     WHERE ((remessa.escritorio='$escritorio')
     AND (remessa.co_servico=serv_ati.codigo_se)
     AND (remessa.dt_envio>='$dt_inicio')
     AND (remessa.dt_envio<='$dt_fim'))");
     while ( $row = mysql_fetch_array($result) ) {
        $pdf->Cell(30, 5, $row[0], 0, 0);
        $pdf->Cell(15, 5, $row[1], 0, 0);
        $pdf->Cell(30, 5, $row[2], 0, 0);
        $pdf->Cell(60, 5, $row[3], 0, 0);
        $pdf->Cell(55, 5, $row[4], 0, 0);
        $pdf->Cell(12, 5, $row[5], 0, 0);
        $pdf->Cell(30, 5, $row[6], 0, 0);
        $pdf->Cell(30, 5, $row[7], 0, 0);
        $pdf->Cell(5, 5, $row[8], 0, 0);
        $pdf->Cell(8, 5, $row[9], 0, 0);
        $pdf->Cell(8, 5, $row[10], 0, 1);
     }
     $pdf->Output();
     }
     gera_fatura_escritorio_devolu();
?>
