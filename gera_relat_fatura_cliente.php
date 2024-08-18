<?php
  session_start();
  require_once("pdf.php");
  function gera_relat_fatura_cliente() {
     $nome_cli    =$_SESSION['nome_cli_m'];
     $mes_ano     =$_SESSION['mes_ano_m'];
     $v_soma      =$_SESSION['v_soma_m'];
     $v_total     =$_SESSION['v_total_m'];
     $pdf = new PDF('P');
     $pdf->SetTotal("Total de HAWB´s Entregues :$v_total");
     $pdf->SetSoma("Total Faturamento Cliente :$v_soma");
     $pdf->SetName("Faturamento :$nome_cli - Mes/Ano :$mes_ano");
     $pdf->SetCabecalho("SERVIÇO                    DESCRIÇÃO DO SERVIÇO                                         QTD            VALOR  ");
     $pdf->Open();
     $pdf->AddPage();
     $pdf->SetFont('Arial', '', 7);
     $base_d     =$_SESSION['base_d'];
     $banco_d    =$_SESSION['banco_d'];
     $usuario_d  =$_SESSION['usuario_d'];
     $senha_d    =$_SESSION['senha_d'];
     $cliente    =$_SESSION['cliente_m'];
     $con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
     $res = mysql_select_db($banco_d) or die ("Banco de dados inexistente");
     $result = mysql_query("SELECT faturamento.codigo_se,
     serv_ati.descri_se,faturamento.qtdade,FORMAT(faturamento.vl_fatu,2)
     FROM faturamento,serv_ati
     WHERE ((faturamento.codi_cli='$cliente')
     AND (faturamento.codigo_se=serv_ati.codigo_se)
     AND (faturamento.mes_ano='$mes_ano'))");
     while ( $row = mysql_fetch_array($result) ) {
        $pdf->Cell(28, 5, $row[0], 0, 0);
        $pdf->Cell(70, 5, $row[1], 0, 0);
        $pdf->Cell(15, 5, $row[2], 0, 0);
        $pdf->Cell(18, 5, $row[3], 0, 1);
     }
     $pdf->Output();
     }
     gera_relat_fatura_cliente();
?>
