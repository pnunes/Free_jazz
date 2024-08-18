<?php
  session_start();
  require_once("pdf.php");
  function gera_fatura_entregador_devolu() {
     $nome_entrega =$_SESSION['nome_entrega_m'];
     $entregador   =$_SESSION['entregador_m'];
     $dt_inicio    =$_SESSION['dt_inicio_m'];
     $dt_fim       =$_SESSION['dt_fim_m'];
     $v_soma       =$_SESSION['v_soma_m'];
     $v_total      =$_SESSION['v_tota_m'];
     $v_dt_inicio  = explode("-",$dt_inicio);
     $v_dt_inicio = $v_dt_inicio[2]."/".$v_dt_inicio[1]."/".$v_dt_inicio[0];
     $v_dt_fim  = explode("-",$dt_fim);
     $v_dt_fim = $v_dt_fim[2]."/".$v_dt_fim[1]."/".$v_dt_fim[0];
     $pdf = new PDF('L');
     $pdf->SetTotal("Total de HAWB´s Entregues :$v_total");
     $pdf->SetSoma("Total Faturamento Entregador :$v_soma");
     $pdf->SetName("Faturamento Entregador :$nome_entrega - De $v_dt_inicio a $v_dt_fim");
     $pdf->SetCabecalho(" HAWB                          DATA         SERVIÇO                       NOME DESTINATÁRIO                                      RUA                                                                   CIDADE                                   QTD      VL.UN         TOTAL");
     $pdf->Open();
     $pdf->AddPage();
     $pdf->SetFont('Arial', '', 6);
     $base_d     =$_SESSION['base_d'];
     $banco_d    =$_SESSION['banco_d'];
     $usuario_d  =$_SESSION['usuario_d'];
     $senha_d    =$_SESSION['senha_d'];
     $con =mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
     $res =mysql_select_db($banco_d) or die ("Banco de dados inexistente");
     $entregador   =$_SESSION['entregador_m'];
     $dt_inicio    =$_SESSION['dt_inicio_m'];
     $dt_fim       =$_SESSION['dt_fim_m'];
     $result = mysql_query("SELECT remessa.n_hawb,date_format(remessa.dt_envio,'%d/%m/%Y'),serv_ati.descri_se,
     remessa.nome_desti,remessa.rua_desti,remessa.cidade_desti,remessa.qtdade,remessa.co_servico,remessa.entregador,
     remessa.classe_cep
     FROM remessa,serv_ati
     WHERE ((remessa.entregador='$entregador')
     AND (remessa.dt_envio>='$dt_inicio')
     AND (remessa.dt_envio<='$dt_fim')
     AND (remessa.co_servico=serv_ati.codigo_se))");
     while ( $row = mysql_fetch_array($result) ) {
        $pdf->Cell(30, 5, $row[0], 0, 0);
        $pdf->Cell(15, 5, $row[1], 0, 0);
        $pdf->Cell(30, 5, $row[2], 0, 0);
        $pdf->Cell(60, 5, $row[3], 0, 0);
        $pdf->Cell(60, 5, $row[4], 0, 0);
        $pdf->Cell(40, 5, $row[5], 0, 0);
        $pdf->Cell(10, 5, $row[6], 0, 0);
        $qtdade       =$row[6];
        $servico      =$row[7];
        $entregador   =$row[8];
        $classe_cep   =$row[9];
        $localiza="SELECT valor FROM tb_terceiro WHERE repre='$entregador' AND tipo_servi='$servico' AND classe_cep='$classe_cep'";
        $query = mysql_db_query($banco_d,$localiza,$con) or die ("Não foi possivel acessar o banco");
        $total = mysql_num_rows($query);
        for($ic=0; $ic<$total; $ic++){
           $row = mysql_fetch_row($query);
           $valor             = $row[0];
        }
        $pdf->Cell(15, 5, $valor, 0, 0);
        $total   = $qtdade*$valor;
        $total   = number_format($total, 2, ',', '.');
        $pdf->Cell(15, 5, $total, 0, 1);
     }
     $pdf->Output();
  }
  gera_fatura_entregador_devolu();
?>
