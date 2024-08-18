<?php
if ( session_status() !== PHP_SESSION_ACTIVE ) {
    session_start();
}

$nome_desti       = $_SESSION['nome_desti_h'];
$rua_desti        = $_SESSION['rua_desti_h'];
$numero_desti     = $_SESSION['numero_desti_h'];
$comple_desti     = $_SESSION['comple_desti_h'];
$bairro_desti     = $_SESSION['bairro_desti_h'];  
$cidade_desti     = $_SESSION['cidade_desti_h'];
$estado_desti     = $_SESSION['estado_desti_h'];
$cep_desti        = $_SESSION['cep_desti_h'];
$cnpj_desti       = $_SESSION['cnpj_desti_h'];
$cod_barra        = $_SESSION['cod_barra_h'];
$servico          = $_SESSION['servico_h'];
$n_hawb           = $_SESSION['n_hawb_h'];
$escritorio       = $_SESSION['escritorio_h'];
$nome_cli         = $_SESSION['nome_cli_h'];
$estado_regi      = $_SESSION['estado_regi_h'];

if(isset($_SESSION['nome_entrega_h'])) {
   $nome_entrega     = $_SESSION['nome_entrega_h'];
}

   $html='<table style="border: 1px solid #000;width:950px;">
      <tr>
	     <td style="display: inline-block;font-size:24px; font-weight: bold; font-family:Arial,Helvetica, sans-serif; width:100px; height:40px; text-align:center; border: 1px solid #000;line-height: 50px">HAWB</td>
		 <td style="display: inline-block;font-size:24px; font-weight: bold; font-family:Arial,Helvetica, sans-serif; width:150px; height:40px; text-align:center; border: 1px solid #000;line-height: 50px">'.$n_hawb.'</td>
	     <td style="display: inline-block;font-size:24px;font-weight: bold;font-family:Arial,Helvetica, sans-serif;width:150px;height:40px;text-align:center;border: 1px solid #000;line-height: 50px">'.date('d/m/y').'</td>
		 <td style="display: inline-block;font-size:20px;font-weight: bold;font-family:Arial, Helvetica,sans-serif;width:70px;height:40px;text-align:center;border: 1px solid #000;line-height: 50px">'.$estado_regi.'</td>
		 <td style="display: inline-block;font-size:14px;font-weight: bold;font-family:Arial, Helvetica, sans-serif;width:315px;height:40px;text-align:center;border: 1px solid #000;line-height: 50px">Transportes Free Jazz Ltda.</td>
      </tr>';
   $html.='</table>';
   $html.='<table style="border: 1px solid #000;width:950px;">
      <tr>
	     <td style="font-size:12px; font-weight: bold; font-family:Arial,Helvetica, sans-serif; width:300px; height:40px; text-align:center; border: 1px solid #000;line-height: 50px">'.$nome_desti.'</td>
		 <td style="font-size:12px; font-weight: bold; font-family:Arial,Helvetica, sans-serif; width:390px; height:40px; text-align:center; border: 1px solid #000;line-height: 50px">'
		    .$rua_desti.",".$numero_desti." - ".$comple_desti.
		 '</td>
	     <td style="font-size:12px;font-weight: bold;font-family:Arial,Helvetica, sans-serif;width:95px;height:40px;text-align:center;border: 1px solid #000;line-height: 50px">'.$cep_desti.'</td>
      </tr>';
   $html.='</table>';
	  /*<tr>
	     <td style='width:550px;height:40px;'>
			 <div style='display: inline-block;font-size:11px;font-weight: bold;font-family:Arial,Helvetica, sans-serif;width:272px;height:40px;text-align:center;border: 1px solid #000;'>
				 <div style='font-size:8px;font-weight: bold;font-family:Arial, Helvetica, sans-serif;margin-top:0px;text-align:left;'>Destinatário</div>
				 <?php echo $nome_desti;?>
			 </div>	 
			 <div style='display: inline-block;font-size:11px;font-weight: bold;font-family:Arial, Helvetica, sans-serif;width:370px;height:40px;text-align:center;border: 1px solid #000;'>
				 <div style='font-size:8px;font-weight: bold;font-family:Arial, Helvetica, sans-serif;margin-top:0px;text-align:left;'>Endereço</div>
				 <?php echo $rua_desti.",".$numero_desti." - ".$comple_desti;?>
			 </div>
			 <div style='display: inline-block;font-size:11px;font-weight: bold;font-family:Arial, Helvetica, sans-serif;width:70px;height:40px;text-align:center;border: 1px solid #000;'>
				 <div style='font-size:8px;font-weight: bold;font-family:Arial, Helvetica, sans-serif;margin-top:0px;text-align:left;'>CEP</div>
				 <?php echo $cep_desti;?>
			 </div>
		 </td>
	  </tr>
	  <tr>
		 <td style='width:550px;height:40px;'>
		     <div style='display: inline-block;font-size:11px;font-weight: bold;font-family:Arial, Helvetica, sans-serif;width:300px;height:40px;text-align:center;border: 1px solid #000;'>
				 <div style='font-size:8px;font-weight: bold;font-family:Arial, Helvetica, sans-serif;margin-top:0px;text-align:left;'>Bairro</div>
				 <?php echo $bairro_desti;?>
			 </div>
			 <div style='display: inline-block;font-size:11px;font-weight: bold;font-family:Arial, Helvetica, sans-serif;width:350px;height:40px;text-align:center;border: 1px solid #000;'>
				 <div style='font-size:8px;font-weight: bold;font-family:Arial, Helvetica, sans-serif;margin-top:0px;text-align:left;'>Cidade</div>
				 <?php echo $cidade_desti;?>
			 </div>
			 <div style='display: inline-block;font-size:14px;font-weight: bold;font-family:Arial, Helvetica, sans-serif;width:62px;height:40px;text-align:center;border: 1px solid #000;'>
				 <div style='font-size:8px;font-weight: bold;font-family:Arial, Helvetica, sans-serif;margin-top:0px;text-align:left;'>Estado</div>
				 <?php echo $estado_desti;?>
			 </div>
		  </td>
      </tr>*/
   
   
   //chama a classe TCFPDF
   require('tcpdf/tcpdf.php');
   $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
   //$pdf->setSourceFile("some_file_path");
   //$tmpl = $pdf->ImportPage(1);
   $pdf->AddPage('L', 'A4');
   $pdf->writeHTML($html,0);
   $pdf->Output();
?>   
<!--</BODY>
</HTML>-->