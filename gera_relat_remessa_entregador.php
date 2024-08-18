<?php
  session_start();
  require_once("pdf.php");
  function gera_relat_remessa_entregador() {
     $nome_entrega  =$_SESSION['nome_entrega_m'];
     $dt_inicio_v   =$_SESSION['dt_inicio_v'];
     $dt_fim_v      =$_SESSION['dt_fim_v'];
     $dt_inicio     =$_SESSION['dt_inicio_m'];
     $dt_fim        =$_SESSION['dt_fim_m'];
     $v_soma        =$_SESSION['numero_m'];
     $entregador    =$_SESSION['entregador_m'];
     $pdf = new PDF('L');
     $pdf->SetSoma("Total itens enviados :$v_soma");
     $pdf->SetName("Remessas Do entregador :$nome_entrega - Período:$dt_inicio_v a $dt_fim_v");
     $pdf->SetCabecalho(" HAWB       N. REMESSA          SERVIÇO                                   DATA         NOME DESTINATÁRIO                                                   RUA                                                                    BAIRRO                          CIDADE");
     $pdf->Open();
     $pdf->AddPage();
     $pdf->SetFont('Arial', '', 6);
     $base_d        =$_SESSION['base_d'];
     $banco_d       =$_SESSION['banco_d'];
     $usuario_d     =$_SESSION['usuario_d'];
     $senha_d       =$_SESSION['senha_d'];
     $con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
     $res = mysql_select_db($banco_d) or die ("Banco de dados inexistente");
     $result = mysql_query("SELECT remessa.n_hawb,remessa.n_remessa,serv_ati.descri_se,
     date_format(remessa.dt_remessa,'%d/%m/%Y'),remessa.nome_desti,remessa.rua_desti,
     remessa.bairro_desti,remessa.cidade_desti
     FROM remessa,serv_ati
     WHERE ((remessa.entregador='$entregador')
     AND (remessa.dt_remessa>='$dt_inicio')
     AND (remessa.dt_remessa<='$dt_fim')
     AND (remessa.co_servico=serv_ati.codigo_se))
     ORDER BY remessa.dt_remessa");
     while ( $row = mysql_fetch_array($result) ) {
        $pdf->Cell(15, 5, $row[0], 0, 0);
        $pdf->Cell(25, 5, $row[1], 0, 0);
        $pdf->Cell(40, 5, $row[2], 0, 0);
        $pdf->Cell(15, 5, $row[3], 0, 0);
        $pdf->Cell(70, 5, $row[4], 0, 0);
        $pdf->Cell(60, 5, $row[5], 0, 0);
        $pdf->Cell(30, 5, $row[6], 0, 0);
        $pdf->Cell(30, 5, $row[7], 0, 1);
     }
     $pdf->Output();
     }
     gera_relat_remessa_entregador();
?>
