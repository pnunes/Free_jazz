<?php
// +----------------------------------------------------------------------+
// | BoletoPhp - Vers�o Beta                                              |
// +----------------------------------------------------------------------+
// | Este arquivo est� dispon�vel sob a Licen�a GPL dispon�vel pela Web   |
// | em http://pt.wikipedia.org/wiki/GNU_General_Public_License           |
// | Voc� deve ter recebido uma c�pia da GNU Public License junto com     |
// | esse pacote; se n�o, escreva para:                                   |
// |                                                                      |
// | Free Software Foundation, Inc.                                       |
// | 59 Temple Place - Suite 330                                          |
// | Boston, MA 02111-1307, USA.                                          |
// +----------------------------------------------------------------------+

// +----------------------------------------------------------------------+
// | Originado do Projeto BBBoletoFree que tiveram colabora��es de Daniel |
// | William Schultz e Leandro Maniezo que por sua vez foi derivado do	  |
// | PHPBoleto de Jo�o Prado Maia e Pablo Martins F. Costa				  |
// | 																	  |
// | Se vc quer colaborar, nos ajude a desenvolver p/ os demais bancos :-)|
// | Acesse o site do Projeto BoletoPhp: www.boletophp.com.br             |
// +----------------------------------------------------------------------+

// +----------------------------------------------------------------------+
// | Equipe Coordena��o Projeto BoletoPhp: <boletophp@boletophp.com.br>   |
// | Desenvolvimento Boleto Bradesco: Ramon Soares						            |
// +----------------------------------------------------------------------+
?>

<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.0 Transitional//EN'>
<HTML>
<HEAD>
<TITLE><?php echo $dadosboleto["identificacao"]; ?></TITLE>
<META http-equiv=Content-Type content=text/html; charset=windows-1252>
<meta name="Generator" content="Projeto BoletoPHP - www.boletophp.com.br - Licen�a GPL" />
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
<table width=672 height=20 cellspacing=0 cellpadding=0 border=1 bodecolor=#000000>
      <tr>
         <td valign=top width=50 height=13>
            <div align=left>
               <font size=2 face=arial>
                  <b>HAWB:</b>
               </font>
            </div>
         </td>
         <td valign=middle  width=172 height=13>
            <div align=center>
                 <font size=1 face=arial>
                     <b> <?php echo $n_hawb?> </b><!-- colocar aqui o n�mero da HAWB-->
                 </font>
            </div>
         </td>
         <td valign=top width=50 height=13>
            <div align=left>
               <font size=2 face=arial>
                  <b>Cliente:</b>
               </font>
            </div>
         </td>
         <td valign=middle  width=172 height=13>
            <div align=center>
                 <font size=1 face=arial>
                     <b> <?php echo $none_cli?> </b><!-- colocar aqui o n�mero da HAWB-->
                 </font>
            </div>
         </td>
         <td valign=top width=50 height=13>
            <div align=left>
               <font size=2 face=arial>
                  <b>Servi�o:</b>
               </font>
            </div>
         </td>
         <td valign=middle  width=172 height=13 colspan=3>
            <div align=center>
                 <font size=1 face=arial>
                     <?php echo $servico?> <!-- colocar aqui o n�mero da HAWB-->
                 </font>
            </div>
         </td>
      </tr>
</table>
<table cellspacing=0 cellpadding=0 width=672 border=1 bodecolor=#000000 height=100>
  <tr>
     <td valign=middle width=333 colspan=6 height=2>
       <p><font color=#000000 size=1 face=arial><b>Destinat�rio :</b></font><font color=#000000 size=1 face=arial><?php echo $nome?></font>
       <p><font color=#000000 size=1 face=arial><b>Endere�o :</b></font><font color=#000000 size=1 face=arial><?php echo $endereco?> -  <?php echo $numero?></font>
       <p><font color=#000000 size=1 face=arial><b>Complemento :</b></font><font color=#000000 size=1 face=arial><?php echo $comple?></font>
       <p><font color=#000000 size=1 face=arial><b>Bairro :</b></font><font color=#000000 size=1 face=arial><?php echo $bairro?></font>
       <p><font color=#000000 size=1 face=arial><b>Cidade :</b></font><font color=#000000 size=1 face=arial><?php echo $cidade?></font> - <font color=#000000 size=1 face=arial><b>Estado :</b><?php echo $estado?></font>
       <p><font color=#000000 size=1 face=arial><b>CEP :</b></font><font color=#000000 size=1 face=arial><?php echo $cep?></font>
     </td>
  </tr>
</table>
<table cellspacing=0 cellpadding=0 width=672 border=1 bodecolor=#000000 height=100>
            <TBODY>
              <tr>
                <td valign=middle width=333 colspan=6 height=2 align=center>
                   <font color=#000000 face=arial size=2>
                      <b>Recebemos de Transportes Free Jazz Ltda ME:</b>
                   </font>
                </td>
              </tr>
              <tr>
                <td valign=top width=333 colspan=6 height=20>
                   <font color=#000000 face=arial size=1>
                      Nome recebedor:
                   </font>
                </td>
              </tr>
              <tr>
                <td valign=top width=333 colspan=6 height=20>
                   <font color=#000000 face=arial size=1>
                      Documento
                   </font>
                </td>
              </tr>
              <tr>
                <td valign=top height=20>
                   <font color=#000000 face=arial size=1>
                      Data entrega:
                   </font>
                </td>
                <td valign=top height=20>
                   <font color=#000000 face=arial size=1>
                      Hora entrega:
                   </font>
                </td>
              </tr>
              <tr>
                <td valign=top width=333 colspan=6 height=20>
                   <font color=#000000 face=arial size=1>
                      Assinatura:
                   </font>
                </td>
              </tr>
            </TBODY>
          </table>
       </td>
   </tr>
</table>
<br>
<TABLE cellSpacing=0 cellPadding=0 width=666 border=0>
    <TBODY>
        <TR>
           <TD vAlign=bottom align=left height=50>
               <?php fbarcode($cd_barra); ?>
           </TD>
        </tr>
    </tbody>
</table>
<TABLE cellSpacing=0 cellPadding=0 width=666 border=0>
   <TR>
       <TD class=ct width=666>
       </TD>
   </TR>
   <TBODY>
      <TR>
         <TD class=ct width=666>
             <div align=right>
                 <font color=#000000 face=arial size=1>
                    Segunda Via.
                 </font>
             </div>
         </TD>
      </TR>
      <TR>
         <TD class=ct width=666>
             <img height=1 src=img_cb/6.png width=665 border=0>
         </TD>
      </tr>
   </tbody>
</table>
</BODY>
</HTML>
