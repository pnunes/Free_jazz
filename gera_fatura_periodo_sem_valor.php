<?php
  session_start();
  require_once("pdf.php");
  function gera_fatura_periodo_sem_valor() {
     $dt_inicio  =$_SESSION['dt_inicio_m'];
     $dt_fim     =$_SESSION['dt_fim_m'];
     $v_soma     =$_SESSION['v_soma_m'];
     $v_dt_inicio  = explode("-",$dt_inicio);
     $v_dt_inicio = $v_dt_inicio[2]."/".$v_dt_inicio[1]."/".$v_dt_inicio[0];
     $v_dt_fim  = explode("-",$dt_fim);
     $v_dt_fim = $v_dt_fim[2]."/".$v_dt_fim[1]."/".$v_dt_fim[0];
     $pdf = new PDF('L');
     $pdf->SetSoma("Total HAWB´s sem valor :$v_soma");
     $pdf->SetName("HAWB´s sem valor no período De : $v_dt_inicio a $v_dt_fim");
     $pdf->SetCabecalho(" HAWB             ESCRITORIO    SERVIÇO                                   NOME CLIENTE                                     C. CEP      CIDADE                             QTD            VALOR       CEP");
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
     $result = mysql_query("SELECT remessa.n_hawb,regi_dep.nome,serv_ati.descri_se,
     cli_for.nome,remessa.classe_cep,remessa.cidade_desti,remessa.qtdade,remessa.valor,cep_desti
     FROM remessa,regi_dep,serv_ati,cli_for
     WHERE ((remessa.escritorio=regi_dep.codigo)
     AND (remessa.co_servico=serv_ati.codigo_se)
     AND (remessa.codi_cli=cli_for.cnpj_cpf)
     AND (remessa.dt_remessa>='$dt_inicio')
     AND (remessa.dt_remessa<='$dt_fim')
     AND(remessa.valor='0.00'))
     ORDER BY regi_dep.nome,serv_ati.descri_se");
     while ( $row = mysql_fetch_array($result) ) {
        $pdf->Cell(25, 5, $row[0], 0, 0);
        $pdf->Cell(25, 5, $row[1], 0, 0);
        $pdf->Cell(50, 5, $row[2], 0, 0);
        $pdf->Cell(65, 5, $row[3], 0, 0);
        $pdf->Cell(17, 5, $row[4], 0, 0);
        $pdf->Cell(45, 5, $row[5], 0, 0);
        $pdf->Cell(20, 5, $row[6], 0, 0);
        $pdf->Cell(15, 5, $row[7], 0, 0);
        $pdf->Cell(15, 5, $row[8], 0, 1);
        //$pdf->Cell(15, 5, $row[9], 0, 1);
     }
     $pdf->Output();
     }
     gera_fatura_periodo_sem_valor();
?>
