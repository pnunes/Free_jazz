<?php
  session_start();
  require_once("pdf.php");
  function gera_hawb_vencida() {
     $hoje        =$_SESSION['dt_hoje_m'];
     $v_hoje      =$_SESSION['v_hoje_m'];
     $depto_m     =$_SESSION['depto_m'];
     $adm_m       =$_SESSION['adm_m'];
     $v_soma      =$_SESSION['v_soma_m'];
     $data_ini    =$_SESSION['dt_inicio_v'];
     $data_fim    =$_SESSION['dt_fim_v'];
     $v_data_ini  =$_SESSION['data_ini_m'];
     $v_data_fim  =$_SESSION['data_fim_m'];
     $escritorio  =$_SESSION['escritorio_m'];
     $nome_escrito=$_SESSION['nome_escrito_m'];
     $pdf = new PDF('L');
     $pdf->SetSoma("Total HAWB´s vencidas :$v_soma");
     $pdf->SetName("HAWB´s vencidas em relação a Data :$hoje - no Período de $data_ini a $data_fim Base :$nome_escrito");
     $pdf->SetCabecalho(" HAWB                     DATA         NOME DESTINATÁRIO                                                   RUA                                                                                NUM.    BAIRRO                                     CIDADE                         HORAS");
     $pdf->Open();
     $pdf->AddPage();
     $pdf->SetFont('Arial', '', 7);
     $base_d     =$_SESSION['base_d'];
     $banco_d    =$_SESSION['banco_d'];
     $usuario_d  =$_SESSION['usuario_d'];
     $senha_d    =$_SESSION['senha_d'];
     $con =mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
     $res =mysql_select_db($banco_d) or die ("Banco de dados inexistente");
     $result = mysql_query("SELECT n_hawb,dt_remessa,nome_desti,
     rua_desti,numero_desti,bairro_desti,cidade_desti,nu_lista,dt_remessa
     FROM remessa
     WHERE ((dt_envio='0000-00-00')
     and (dt_remessa>='$v_data_ini')
     and (dt_remessa<='$v_data_fim')
     AND (escritorio='$escritorio'))
     ORDER BY dt_remessa");
     while ( $row = mysql_fetch_array($result) ) {
        $dt_remessa  =$row[1];
        $v_dt_remessa=mktime(0,0,0,(substr($dt_remessa,5,2)),(substr($dt_remessa,8,2)),(substr($dt_remessa,0,4)));
        $segundos = ($v_hoje-$v_dt_remessa);
        $horas = round(($segundos/60/60));
        if ($horas>='48') {
           $pdf->Cell(25, 5, $row[0], 0, 0);
           $i_dt_remessa  =$row[1];
           $i_dt_remessa  = explode("-",$i_dt_remessa);
           $v_i_dt_remessa = $i_dt_remessa[2]."/".$i_dt_remessa[1]."/".$i_dt_remessa[0];
           $pdf->Cell(15, 5, $v_i_dt_remessa, 0, 0);
           $pdf->Cell(70, 5, $row[2], 0, 0);
           $pdf->Cell(70, 5, $row[3], 0, 0);
           $pdf->Cell(10, 5, $row[4], 0, 0);
           $pdf->Cell(40, 5, $row[5], 0, 0);
           $pdf->Cell(30, 5, $row[6], 0, 0);
           $pdf->Cell(10, 5, $horas, 0, 1);
        }
     }
     $pdf->Output();
     }
     gera_hawb_vencida();
?>
