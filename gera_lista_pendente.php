<?php
  session_start();
  require_once("pdf.php");
  function gera_lista_pendente() {
     $entregador        =$_SESSION['entregador_m'];
     $nome_entregador   =$_SESSION['nome_entregador_m'];
     $v_soma            =$_SESSION['numero_m'];
     $dt_inicio         =$_SESSION['dt_inicio_m'];
     $dt_fim            =$_SESSION['dt_fim_m'];
     $v_dt_inicio  = explode("-",$dt_inicio);
     $v_dt_inicio = $v_dt_inicio[2]."/".$v_dt_inicio[1]."/".$v_dt_inicio[0];
     $v_dt_fim  = explode("-",$dt_fim);
     $v_dt_fim = $v_dt_fim[2]."/".$v_dt_fim[1]."/".$v_dt_fim[0];
     $pdf = new PDF('L');
     $pdf->SetSoma("Total HAWB´s Pendentes Entregador :$v_soma");
     $pdf->SetName("RHAWB´s Pendentes de :$nome_entregador - Período :$v_dt_inicio a $v_dt_fim");
     $pdf->SetCabecalho(" HAWB                     SERVIÇO                DATA          NOME DESTINATÁRIO                                            RUA                                                                   NUM.     BAIRRO                        CIDADE                  ENTREGADOR");
     $pdf->Open();
     $pdf->AddPage();
     $pdf->SetFont('Arial', '', 6);
     $numero_lista =(int)$numero_lista;
     $base_d     =$_SESSION['base_d'];
     $banco_d    =$_SESSION['banco_d'];
     $usuario_d  =$_SESSION['usuario_d'];
     $senha_d    =$_SESSION['senha_d'];
     $con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
     $res = mysql_select_db($banco_d) or die ("Banco de dados inexistente");
     $result = mysql_query("SELECT remessa.n_hawb,serv_ati.descri_se,
     date_format(remessa.dt_remessa,'%d/%m/%Y'),remessa.nome_desti,remessa.rua_desti,
     remessa.numero_desti,remessa.bairro_desti,remessa.cidade_desti,cli_for.nome
     FROM remessa,serv_ati,cli_for
     WHERE ((remessa.entregador='$entregador')
     AND (remessa.co_servico=serv_ati.codigo_se)
     AND (remessa.entregador=cli_for.cnpj_cpf)
     AND (remessa.dt_lista<>'0000-00-00')
     AND (remessa.dt_baixa='0000-00-00')
     AND (remessa.dt_remessa>='$dt_inicio')
     AND (remessa.dt_remessa<='$dt_fim'))");
     while ( $row = mysql_fetch_array($result) ) {
        $pdf->Cell(25, 5, $row[0], 0, 0);
        $pdf->Cell(25, 5, $row[1], 0, 0);
        $pdf->Cell(15, 5, $row[2], 0, 0);
        $pdf->Cell(65, 5, $row[3], 0, 0);
        $pdf->Cell(60, 5, $row[4], 0, 0);
        $pdf->Cell(10, 5, $row[5], 0, 0);
        $pdf->Cell(30, 5, $row[6], 0, 0);
        $pdf->Cell(30, 5, $row[7], 0, 0);
        $pdf->Cell(5, 5, $row[8], 0, 1);
     }
     $pdf->Output();
     }
     gera_lista_pendente();
?>
