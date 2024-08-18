<?php
  session_start();
  require_once("pdf.php");
  function gera_relat_remessa_escritorio() {
     $nome_escri    =$_SESSION['nome_escri_m'];
     $escritorio    =$_SESSION['escritorio_m'];
     $dt_inicio     =$_SESSION['dt_inicio_m'];
     $dt_fim        =$_SESSION['dt_fim_m'];
     $dt_inicio_v   =$_SESSION['dt_inicio_v'];
     $dt_fim_v      =$_SESSION['dt_fim_v'];
     $v_soma        =$_SESSION['numero_m'];
     $pdf = new PDF('L');
     $pdf->SetSoma("Total itens enviados :$v_soma");
     $pdf->SetName("Remessas Escritório :$nome_escri - De $dt_inicio_v a $dt_fim_v");
     $pdf->SetCabecalho(" HAWB   N. REMESSA    DATA        NOME DESTINATÁRIO                                       RUA                                                        NUM.     BAIRRO                          CIDADE");
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
     $result = mysql_query("SELECT n_hawb,n_remessa,date_format(dt_remessa,'%d/%m/%Y'),
     nome_desti,rua_desti,numero_desti,bairro_desti,cidade_desti
     FROM remessa
     WHERE ((escritorio='$escritorio')
     AND (dt_remessa>='$dt_inicio')
     AND (dt_remessa<='$dt_fim'))");
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
     gera_relat_remessa_escritorio();
?>
