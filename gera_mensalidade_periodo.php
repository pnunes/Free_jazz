<?php
  session_start();
  require_once("pdf.php");
  function gera_mensalidade_periodo() {
     $ano        =$_SESSION['ano_i'];
     $pdf = new PDF('L');
     $pdf->SetName("Posição Memsalidades do Ano: $ano");
     $pdf->SetCabecalho("NOME MEMBRO                           JANEIRO       FEVEREIRO       MARÇO             ABRIL                MAIO         JUNHO         JULHO        AGOSTO      SETEMBRO     OUTUBRO     NOVEMBRO      DEZEMBRO");
     $pdf->Open();
     $pdf->AddPage();
     $pdf->SetFont('Arial', '', 7);
     $base_d     =$_SESSION['base_d'];
     $banco_d    =$_SESSION['banco_d'];
     $usuario_d  =$_SESSION['usuario_d'];
     $senha_d    =$_SESSION['senha_d'];
     $conta      =0;
     $con =mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
     $res =mysql_select_db($banco_d) or die ("Banco de dados inexistente");
     $result = mysql_query("SELECT mensalidade.codigo_membro,cad_membro.nome,mensalidade.competencia,mensalidade.vl_pago
     FROM cad_membro,mensalidade
     WHERE ((mensalidade.ano='$ano')
     AND (mensalidade.codigo_membro=cad_membro.codigo))
     ORDER BY cad_membro.nome,mensalidade.data_pg");
     while ($row = mysql_fetch_array($result)) {
        if ($conta==0) {
            $pdf->Cell(10, 5, '______________________________________________________________________________________________________________________________________________________________________________________________________', 0, 1);
            $codigo_me=$row[0];
            $conta=1;
            $pdf->Cell(45, 5, $row[1], 0, 0);
        }
        $membro  =$row[0];
        $mes     =trim($row[2]);
        if ($membro == $codigo_me) {
            if ($mes =='JANEIRO') {
               $pdf->Cell(20, 5, $row[3], 0, 0);
            }
            if ($mes =='FEVEREIRO') {
               $pdf->Cell(20, 5, $row[3], 0, 0);
            }
            if ($mes =='MARÇO') {
               $pdf->Cell(20, 5, $row[3], 0, 0);
            }
            if ($mes =='ABRIL') {
               $pdf->Cell(20, 5, $row[3], 0, 0);
            }
            if ($mes =='MAIO') {
               $pdf->Cell(20, 5, $row[3], 0, 0);
            }
            if ($mes =='JUNHO') {
               $pdf->Cell(20, 5, $row[3], 0, 0);
            }
            if ($mes =='JULHO') {
               $pdf->Cell(20, 5, $row[3], 0, 0);
            }
            if ($mes =='AGOSTO') {
               $pdf->Cell(20, 5, $row[3], 0, 0);
            }
            if ($mes =='SETEMBRO') {
               $pdf->Cell(20, 5, $row[3], 0, 0);
            }
            if ($mes =='OUTUBRO')  {
               $pdf->Cell(20, 5, $row[3], 0, 0);
            }
            if ($mes =='NOVEMBRO') {
               $pdf->Cell(20, 5, $row[3], 0, 0);
            }
            if ($mes =='DEZEMBRO') {
               $pdf->Cell(20, 5, $row[3], 0, 0);
            }
        }
        else {
           $pdf->Cell(10, 5, ' ', 0, 1);
           $pdf->Cell(10, 5, '______________________________________________________________________________________________________________________________________________________________________________________________________', 0, 1);
           $codigo_me=$row[0];
           $conta=1;
           $pdf->Cell(45, 5, $row[1], 0, 0);
           
           if ($mes =='JANEIRO') {
               $pdf->Cell(20, 5, $row[3], 0, 0);
            }
            if ($mes =='FEVEREIRO') {
               $pdf->Cell(20, 5, $row[3], 0, 0);
            }
            if ($mes =='MARÇO') {
               $pdf->Cell(20, 5, $row[3], 0, 0);
            }
            if ($mes =='ABRIL') {
               $pdf->Cell(20, 5, $row[3], 0, 0);
            }
            if ($mes =='MAIO') {
               $pdf->Cell(20, 5, $row[3], 0, 0);
            }
            if ($mes =='JUNHO') {
               $pdf->Cell(20, 5, $row[3], 0, 0);
            }
            if ($mes =='JULHO') {
               $pdf->Cell(20, 5, $row[3], 0, 0);
            }
            if ($mes =='AGOSTO') {
               $pdf->Cell(20, 5, $row[3], 0, 0);
            }
            if ($mes =='SETEMBRO') {
               $pdf->Cell(20, 5, $row[3], 0, 0);
            }
            if ($mes =='OUTUBRO')  {
               $pdf->Cell(20, 5, $row[3], 0, 0);
            }
            if ($mes =='NOVEMBRO') {
               $pdf->Cell(20, 5, $row[3], 0, 0);
            }
            if ($mes =='DEZEMBRO') {
               $pdf->Cell(20, 5, $row[3], 0, 0);
            }
        }
     }
     $pdf->Output();
     }
     gera_mensalidade_periodo();
?>
