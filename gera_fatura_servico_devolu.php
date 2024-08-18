<?php
  session_start();
  require_once("pdf.php");
  function gera_fatura_servico_devolu() {
     $descri_se  =$_SESSION['descri_se_m'];
     $cliente    =$_SESSION['nome_cli_m'];
     $codi_cli   =$_SESSION['cliente_m'];
     $servico    =$_SESSION['servico_m'];
     $dt_inicio  =$_SESSION['dt_inicio_m'];
     $dt_fim     =$_SESSION['dt_fim_m'];
     $v_soma     =$_SESSION['v_soma_m'];
     $qtdade     =$_SESSION['v_qtdade_m'];
     $v_dt_inicio  = explode("-",$dt_inicio);
     $v_dt_inicio = $v_dt_inicio[2]."/".$v_dt_inicio[1]."/".$v_dt_inicio[0];
     $v_dt_fim  = explode("-",$dt_fim);
     $v_dt_fim = $v_dt_fim[2]."/".$v_dt_fim[1]."/".$v_dt_fim[0];
     $pdf = new PDF('L');
     $pdf->SetTotal("Total de Serviços :$qtdade");
     $pdf->SetSoma("Total Faturamento Cliente :$v_soma");
     $pdf->SetName("Faturamento: Cliente:$cliente - Serviço :$descri_se - Período : $v_dt_inicio a $v_dt_fim");
     $pdf->SetCabecalho(" HAWB       N. REMESSA          DATA                 NOME DESTINATÁRIO                                                        BAIRRO                         CIDADE                     QTD                                VL.UN                      TOTAL");
     $pdf->Open();
     $pdf->AddPage();
     $pdf->SetFont('Arial', '', 7);
     $base_d     =$_SESSION['base_d'];
     $banco_d    =$_SESSION['banco_d'];
     $usuario_d  =$_SESSION['usuario_d'];
     $senha_d    =$_SESSION['senha_d'];
     $con =mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
     $res =mysql_select_db($banco_d) or die ("Banco de dados inexistente");
     $result = mysql_query("SELECT n_hawb,n_remessa,
     date_format(dt_remessa,'%d/%m/%Y'),nome_desti,
     bairro_desti,cidade_desti,qtdade,valor,
     (valor*qtdade) As vl_item
     FROM remessa
     WHERE ((remessa.co_servico='$servico')
     AND (remessa.dt_envio>='$dt_inicio')
     AND (remessa.dt_envio<='$dt_fim')
     AND (codi_cli='$codi_cli')
     AND (remessa.dt_envio<>'0000-00-00'))
     ORDER BY remessa.dt_envio");
     while ( $row = mysql_fetch_array($result) ) {
        $pdf->Cell(15, 5, $row[0], 0, 0);
        $pdf->Cell(25, 5, $row[1], 0, 0);
        $pdf->Cell(20, 5, $row[2], 0, 0);
        $pdf->Cell(75, 5, $row[3], 0, 0);
        $pdf->Cell(30, 5, $row[4], 0, 0);
        $pdf->Cell(30, 5, $row[5], 0, 0);
        $pdf->Cell(30, 5, $row[6], 0, 0);
        $pdf->Cell(25, 5, $row[7], 0, 0);
        $pdf->Cell(15, 5, $row[8], 0, 0);
        $pdf->Cell(15, 5, $row[9], 0, 1);
     }
     $pdf->Output();
     }
     gera_fatura_servico_devolu();
?>
