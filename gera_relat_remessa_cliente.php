<?php
  session_start();
  require_once("pdf.php");
  function gera_relat_item_remessa() {
     $nome_cli      =$_SESSION['nome_cli_m'];
     $cliente       =$_SESSION['cliente_m'];
     $v_soma        =$_SESSION['numero_m'];
     $dt_inicio_v   =$_SESSION['dt_inicio_v'];
     $dt_fim_v      =$_SESSION['dt_fim_v'];
     $dt_inicio     =$_SESSION['dt_inicio_m'];
     $dt_fim        =$_SESSION['dt_fim_m'];
     $pdf = new PDF('L');
     $pdf->SetSoma("Total itens do Cliente :$v_soma");
     $pdf->SetName("Remessas Do Cliente  :$nome_cli  - De $dt_inicio_v a $dt_fim_v");
     $pdf->SetCabecalho(" HAWB   N. REMESSA    DATA        NOME DESTINATÁRIO                                       RUA                                                          NUM.     BAIRRO                          CIDADE");
     $pdf->Open();
     $pdf->AddPage();
     $pdf->SetFont('Arial', '', 7);
     $base_d     =$_SESSION['base_d'];
     $banco_d    =$_SESSION['banco_d'];
     $usuario_d  =$_SESSION['usuario_d'];
     $senha_d    =$_SESSION['senha_d'];
     $con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
     $res = mysql_select_db($banco_d) or die ("Banco de dados inexistente");
     $result = mysql_query("SELECT n_hawb,n_remessa,date_format(dt_remessa,'%d/%m/%Y'),
     nome_desti,rua_desti,numero_desti,bairro_desti,cidade_desti
     FROM remessa
     WHERE ((codi_cli='$cliente') AND
     (dt_remessa>='$dt_inicio') AND
     (dt_remessa<='$dt_fim'))");
     while ( $row = mysql_fetch_array($result) ) {
        $pdf->Cell(15, 5, $row[0], 0, 0);
        $pdf->Cell(25, 5, $row[1], 0, 0);
        $pdf->Cell(18, 5, $row[2], 0, 0);
        $pdf->Cell(75, 5, $row[3], 0, 0);
        $pdf->Cell(65, 5, $row[4], 0, 0);
        $pdf->Cell(12, 5, $row[5], 0, 0);
        $pdf->Cell(40, 5, $row[6], 0, 0);
        $pdf->Cell(30, 5, $row[7], 0, 1);
     }
     $pdf->Output();
     }
     gera_relat_item_remessa();
?>
