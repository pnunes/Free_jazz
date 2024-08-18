<?php
  session_start();
  require_once("pdf.php");
  function gera_lista_dia() {
     $v_soma       =$_SESSION['numero_m'];
     $entrega      =$_SESSION['entregador_m'];
     $hora         =$_SESSION['hora_m'];
     $v_dt_lista   =$_SESSION['v_dt_lista_m'];
     $nome_entrega =$_SESSION['nome_entrega_m'];
     $dt_lista     =$SESSION['dt_lista_m'];
     $pdf = new PDF('L');
     $pdf->SetSoma("Total Entregas Entregador :$v_soma");
     $pdf->SetName("Relação de Entregas da Lista de : $nome_entrega  -  Data:$dt_lista  -  Hora :$hora");
     $pdf->SetCabecalho(" HAWB                          SERVIÇO                              NOME DESTINATÁRIO                                                 RUA                                                                    NUM.           BAIRRO                              CIDADE");
     $pdf->Open();
     $pdf->AddPage();
     $pdf->SetFont('Arial', '', 7);
     $base_d     =$_SESSION['base_d'];
     $banco_d    =$_SESSION['banco_d'];
     $usuario_d  =$_SESSION['usuario_d'];
     $senha_d    =$_SESSION['senha_d'];
     $con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
     $res = mysql_select_db($banco_d) or die ("Banco de dados inexistente");
     $result = mysql_query("SELECT remessa.n_hawb,serv_ati.descri_se,remessa.nome_desti,
     remessa.rua_desti,remessa.numero_desti,remessa.bairro_desti,remessa.cidade_desti
     FROM remessa,serv_ati
     WHERE ((remessa.hora='$hora')
     AND (dt_lista='$v_dt_lista')
     AND (entregador=' $entrega')
     AND (remessa.co_servico=serv_ati.codigo_se))");
     while ( $row = mysql_fetch_array($result)) {
        $pdf->Cell(30, 5, $row[0], 0, 0);
        $pdf->Cell(35, 5, $row[1], 0, 0);
        $pdf->Cell(70, 5, $row[2], 0, 0);
        $pdf->Cell(60, 5, $row[3], 0, 0);
        $pdf->Cell(15, 5, $row[4], 0, 0);
        $pdf->Cell(35, 5, $row[5], 0, 0);
        $pdf->Cell(20, 5, $row[6], 0, 1);
     }
     $pdf->Output();
     }
     gera_lista_dia();
?>
