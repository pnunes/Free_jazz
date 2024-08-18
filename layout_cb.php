<?php
// +----------------------------------------------------------------------+
// | BoletoPhp - Vers„o Beta                                              |
// +----------------------------------------------------------------------+
// | Este arquivo est· disponÌvel sob a LicenÁa GPL disponÌvel pela Web   |
// | em http://pt.wikipedia.org/wiki/GNU_General_Public_License           |
// | VocÍ deve ter recebido uma cÛpia da GNU Public License junto com     |
// | esse pacote; se n„o, escreva para:                                   |
// |                                                                      |
// | Free Software Foundation, Inc.                                       |
// | 59 Temple Place - Suite 330                                          |
// | Boston, MA 02111-1307, USA.                                          |
// +----------------------------------------------------------------------+

// +----------------------------------------------------------------------+
// | Originado do Projeto BBBoletoFree que tiveram colaboraÁıes de Daniel |
// | William Schultz e Leandro Maniezo que por sua vez foi derivado do	  |
// | PHPBoleto de Jo„o Prado Maia e Pablo Martins F. Costa				  |
// | 																	  |
// | Se vc quer colaborar, nos ajude a desenvolver p/ os demais bancos :-)|
// | Acesse o site do Projeto BoletoPhp: www.boletophp.com.br             |
// +----------------------------------------------------------------------+

// +----------------------------------------------------------------------+
// | Equipe CoordenaÁ„o Projeto BoletoPhp: <boletophp@boletophp.com.br>   |
// | Desenvolvimento Boleto Bradesco: Ramon Soares						            |
// +----------------------------------------------------------------------+
?>

<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.0 Transitional//EN'>
<HTML>
<HEAD>
<TITLE><?php echo $dadosboleto["identificacao"]; ?></TITLE>
<META http-equiv=Content-Type content=text/html; charset=windows-1252>
<meta name="Generator" content="Projeto BoletoPHP - www.boletophp.com.br - Licen√ßa GPL" />
<style type=text/css>
   <!--.cp {  font: bold 10px Arial; color: black}
   <!--.ti {  font: 9px Arial, Helvetica, sans-serif}
   <!--.ld { font: bold 15px Arial; color: #000000}
   <!--.ct { FONT: 9px "Arial Narrow"; COLOR: #000033}
   <!--.cn { FONT: 9px Arial; COLOR: black }
   <!--.bc { font: bold 20px Arial; color: #000000 }
   <!--.ld2 { font: bold 12px Arial; color: #000000 }-->
</style>
</head>

<BODY text=#000000 bgColor=#ffffff topMargin=0 rightMargin=0>
<br>
<table width=668 height=50 cellspacing=0 cellpadding=0 border=1 bodecolor=#000000>
    <tr>
         <td valign=top width=668 height=50 colspan =3>
            <div align=center>
               <img border="0" src="img/logo_hawb.jpg" width="668" height="50" border="0">
            </div>
         </td>
      </tr>
</table>
<table width=672 height=20 cellspacing=0 cellpadding=2 border=1 bodecolor=#000000>
      <tr>
         <td valign=middle width=100 height=13>
            <div align=left>
               <font size=1 face=arial>
                  <b>HAWB  :</b><?php echo $n_hawb?>
               </font>
            </div>
         </td>
         <td valign=middle width=250 height=13>
            <div align=left>
               <font size=1 face=arial>
                  <b>Cliente  :</b><?php echo $nome_cli?>
               </font>
            </div>
         </td>
         <td valign=middle width=250 height=13>
            <div align=left>
               <font size=1 face=arial>
                  <b>Servi√ßo  :</b><?php echo $servico?>
               </font>
            </div>
         </td>
      </tr>
</table>
<table cellspacing=0 cellpadding=0 width=672 border=1 bodecolor=#000000 height=80>
   <tr>
   <td>
   <table width=400 cellspacing=0 cellpadding=0>
     <tr>
        <td valign=middle width=398 colspan=6 style="FONT-SIZE:10px; COLOR:#000000; LINE-HEIGHT:10px; FONT-FAMILY:Arial,Helvetica,sans-serif">
          <p><b>Destinat√°rio :</b><?php echo $nome?>
          <p><b>CNPJ/CPF :</b><?php echo $cnpj_desti?>
          <p><b>Endere√ßo :</b><?php echo $endereco?> -  <?php echo $numero?>
          <p><b>Complemento :</b><?php echo $comple?>
          <p><b>Bairro :</b><?php echo $bairro?> - <b>Cidade :</b><?php echo $cidade?> - <b>Estado :</b><?php echo $estado?> - <b>CEP :</b><?php echo $cep?>
        </td>
     </tr>
   </table>
   </td>
   <td>
      <table width=266 cellspacing=0 cellpadding=0>
         <TBODY>
           <TR>
               <TD valign=bottom align=center>
                 <?php fbarcode($cd_barra); ?>
               </TD>
           </tr>
         </tbody>
      </table>
   </td>
   </tr>
</table>
<table cellspacing=0 cellpadding=0 width=672 border=1 bodecolor=#000000 height=100>
   <tr>
    <td>
    <table cellspacing=0 cellpadding=0 width=333 border=0 bodecolor=#000000 height=100>
      <TBODY>
          <TBODY>
          <tr>
            <td valign=middle colspan=6 align=center>
               <font color=#000000 face=arial size=1>
                  <b>TENTATIVAS DE ENTREGA</b>
               </font>
            </td>
          </tr>
          <tr>
            <td valign=bottom width=333 align=center style="FONT-SIZE:10px; COLOR:#000000; LINE-HEIGHT:15px; FONT-FAMILY:Arial,Helvetica,sans-serif">
               <font color=#000000 face=arial size=1>
                  1  -  ________/________/_________  _________:_________
               </font>
            </td>
          </tr>
          <tr>
            <td valign=bottom width=333 align=center style="FONT-SIZE:10px; COLOR:#000000; LINE-HEIGHT:15px; FONT-FAMILY:Arial,Helvetica,sans-serif">
               <font color=#000000 face=arial size=1>
                  2  -  ________/________/_________  _________:_________
               </font>
            </td>
          </tr>
          <tr>
            <td valign=bottom width=333 align=center style="FONT-SIZE:10px; COLOR:#000000; LINE-HEIGHT:15px; FONT-FAMILY:Arial,Helvetica,sans-serif">
               <font color=#000000 face=arial size=1>
                  3  -  ________/________/_________  _________:_________
               </font>
            </td>
          </tr>
          <tr>
            <td valign=bottom style="FONT-SIZE:10px; COLOR:#000000; LINE-HEIGHT:10px; FONT-FAMILY:Arial,Helvetica,sans-serif">
               <font color=#000000 face=arial size=1><b>ATEN√á√ÉO :</b>Ap√≥s tr√™s tentativas de entrega devolver o objeto.</font>
            </td>
          </tr>
      </TBODY>
      </TBODY>
    </table>
    </td>
    <td>
     <table cellspacing=0 cellpadding=0 width=333 border=0 bodecolor=#000000 height=10>
       <tr>
         <td valign=middle colspan=2 align=center>
           <font color=#000000 face=arial size=1>
              <b>MOTIVOS DA DEVOLU√á√ÉO</b>
           </font>
         </td>
       </tr>
       <td>
       <table cellspacing=0 cellpadding=0 width=163 border=0 bodecolor=#000000 height=80>
       <tr>
       <td>
        <TBODY>
          <tr>
            <td valign=bottom width=151 style="FONT-SIZE:10px; COLOR:#000000; LINE-HEIGHT:10px; FONT-FAMILY:Arial,Helvetica,sans-serif">
               <font color=#000000 face=arial size=1>
                  (___)  -  Mudou-se.
               </font>
            </td>
          </tr>
          <tr>
            <td valign=bottom width=151 style="FONT-SIZE:10px; COLOR:#000000; LINE-HEIGHT:10px; FONT-FAMILY:Arial,Helvetica,sans-serif">
               <font color=#000000 face=arial size=1>
                  (___)  -  Endere√ßo insuficiente.
               </font>
            </td>
          </tr>
          <tr>
            <td valign=bottom width=151 style="FONT-SIZE:10px; COLOR:#000000; LINE-HEIGHT:10px; FONT-FAMILY:Arial,Helvetica,sans-serif">
               <font color=#000000 face=arial size=1>
                  (___)  -  N√∫mero inexistente.
               </font>
            </td>
          </tr>
          <tr>
            <td valign=bottom width=151 style="FONT-SIZE:10px; COLOR:#000000; LINE-HEIGHT:10px; FONT-FAMILY:Arial,Helvetica,sans-serif">
               <font color=#000000 face=arial size=1>
                  (___)  -  Desconhecido.
               </font>
            </td>
          </tr>
        </TBODY>
       </table>
       </td>
       <td>
       <table cellspacing=0 cellpadding=0 width=163 border=0 bodecolor=#000000 height=80>
        <TBODY>
          <tr>
            <td valign=bottom width=163 colspan=6 style="FONT-SIZE:10px; COLOR:#000000; LINE-HEIGHT:10px; FONT-FAMILY:Arial,Helvetica,sans-serif">
               <font color=#000000 face=arial size=1>
                  (___)  -  Recusado.
               </font>
            </td>
          </tr>
          <tr>
            <td valign=bottom width=163 colspan=6 style="FONT-SIZE:10px; COLOR:#000000; LINE-HEIGHT:10px; FONT-FAMILY:Arial,Helvetica,sans-serif">
               <font color=#000000 face=arial size=1>
                  (___)  -  Dificil acesso.
               </font>
            </td>
          </tr>
          <tr>
            <td valign=bottom width=163 style="FONT-SIZE:10px; COLOR:#000000; LINE-HEIGHT:10px; FONT-FAMILY:Arial,Helvetica,sans-serif">
               <font color=#000000 face=arial size=1>
                  (___)  -  Ausente.
               </font>
            </td>
          </tr>
          <tr>
            <td valign=bottom width=163 style="FONT-SIZE:10px; COLOR:#000000; LINE-HEIGHT:10px; FONT-FAMILY:Arial,Helvetica,sans-serif">
               <font color=#000000 face=arial size=1>
                  (___)  - Estabelecimento fechado.
               </font>
            </td>
          </tr>
        </TBODY>
       </table>
     </table>
    </td>
  </tr>
</table>
<table cellspacing=0 cellpadding=0 width=672 border=1 bodecolor=#000000 height=30>
   <TBODY>
      <tr>
        <td valign=top align=left width=430 style="FONT-SIZE:10px; COLOR:#000000; LINE-HEIGHT:10px; FONT-FAMILY:Arial,Helvetica,sans-serif">
           <font color=#000000 face=arial size=1>
              Nome ou carimbo recebedor
           </font>
        </td>
        <td valign=top align=left width=121 style="FONT-SIZE:10px; COLOR:#000000; LINE-HEIGHT:10px; FONT-FAMILY:Arial,Helvetica,sans-serif">
           <font color=#000000 face=arial size=1>
              Identidade ou CPF
           </font>
        </td>
        <td valign=top align=left width=121 style="FONT-SIZE:10px; COLOR:#000000; LINE-HEIGHT:10px; FONT-FAMILY:Arial,Helvetica,sans-serif">
           <font color=#000000 face=arial size=1>
              Data entrega
           </font>
        </td>
      </tr>
    </TBODY>
</table>
<table cellspacing=0 cellpadding=0 width=672 border=1 bodecolor=#000000 height=30>
   <TBODY>
      <tr>
        <td valign=top align=left width=380 style="FONT-SIZE:10px; COLOR:#000000; LINE-HEIGHT:10px; FONT-FAMILY:Arial,Helvetica,sans-serif">
           <font color=#000000 face=arial size=1>
              Assinatura recebedor
           </font>
        </td>
        <td valign=top align=left width=171 style="FONT-SIZE:10px; COLOR:#000000; LINE-HEIGHT:10px; FONT-FAMILY:Arial,Helvetica,sans-serif">
           <font color=#000000 face=arial size=1>
              Fun√ß√£o
           </font>
        </td>
        <td valign=top align=left width=121 style="FONT-SIZE:10px; COLOR:#000000; LINE-HEIGHT:10px; FONT-FAMILY:Arial,Helvetica,sans-serif">
           <font color=#000000 face=arial size=1>
              Hora entrega
           </font>
        </td>
      </tr>
    </TBODY>
</table>
</BODY>
</HTML>
