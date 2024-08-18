<?php
  session_start();
  require_once("pdf.php");
  function gera_hawb_periodo() {
     $dt_inicio  =$_SESSION['dt_inicio_m'];
     $dt_fim     =$_SESSION['dt_fim_m'];
     $v_soma     =$_SESSION['v_soma_m'];
     $v_dt_inicio  = explode("-",$dt_inicio);
     $v_dt_inicio = $v_dt_inicio[2]."/".$v_dt_inicio[1]."/".$v_dt_inicio[0];
     $v_dt_fim  = explode("-",$dt_fim);
     $v_dt_fim = $v_dt_fim[2]."/".$v_dt_fim[1]."/".$v_dt_fim[0];
     $pdf = new PDF('L');
     $pdf->SetSoma("Total HAWB´s no Período :$v_soma");
     $pdf->SetName("HAWB´s lançadas De $v_dt_inicio a $v_dt_fim");
     $pdf->SetCabecalho(" HAWB   N. REMESSA     DATA       NOME DESTINATÁRIO                                 RUA                                                           NUM.   BAIRRO                      CIDADE             C. CEP");
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
     $result = mysql_query("SELECT n_hawb,n_remessa,date_format(dt_remessa,'%d/%m/%Y'),nome_desti,
     rua_desti,numero_desti,bairro_desti,cidade_desti,classe_cep
     FROM remessa
     WHERE ((dt_remessa>='$dt_inicio')
     AND (dt_remessa<='$dt_fim'))");
     while ( $row = mysql_fetch_array($result) ) {
        $pdf->Cell(15, 5, $row[0], 0, 0);
        $pdf->Cell(25, 5, $row[1], 0, 0);
        $pdf->Cell(18, 5, $row[2], 0, 0);
        $pdf->Cell(70, 5, $row[3], 0, 0);
        $pdf->Cell(65, 5, $row[4], 0, 0);
        $pdf->Cell(12, 5, $row[5], 0, 0);
        $pdf->Cell(35, 5, $row[6], 0, 0);
        $pdf->Cell(30, 5, $row[7], 0, 0);
        $pdf->Cell(15, 5, $row[8], 0, 1);
     }
     $pdf->Output();
     }
     gera_hawb_periodo();
?>
