<?php
	if ( session_status() !== PHP_SESSION_ACTIVE ) {
		session_start();
	}

	//carrega variaveis com dados para acessar o banco de dados
	 
	Include('conexao_free.php');
	mysqli_set_charset($con,'UTF8');


    $n_remessa    =$_POST['n_remessa'];

    if ($n_remessa<>'') {

        //Pega os registros na tabela remessa para mostrar

        $result = mysqli_query($con,"SELECT controle,codi_cli,escritorio,codigo_desti,nome_desti,cep_desti,
        rua_desti,numero_desti,comple_desti,bairro_desti,cidade_desti,estado_desti,
        date_format(dt_remessa,'%d/%m/%Y'),co_servico,cod_barra,n_hawb,cnpj_desti,entregador,parentesco
        FROM remessa
        WHERE n_remessa='$n_remessa'");
        include ("funcao_cb.php");
        while ( $row = mysqli_fetch_array($result) ) {
           $controle       = $row[0];
           $codi_cli       = $row[1];
           $escritorio     = $row[2];
           $codigo_desti   = $row[3];
           $nome_desti     = $row[4];
           $cep_desti      = $row[5];
           $rua_desti      = $row[6];
           $numero_desti   = $row[7];
           $comple_desti   = $row[8];
           $bairro_desti   = $row[9];
           $cidade_desti   = $row[10];
           $estado_desti   = $row[11];
           $dt_remessa     = $row[12];
           $co_servico     = $row[13];
           $cod_barra      = $row[14];
           $n_hawb         = $row[15];
           $cnpj_desti     = $row[16];
		   $entregador     = $row[17];
		   $parentesco     = $row[18];

           $resultado = mysqli_query ($con,"SELECT nome FROM cli_for
           WHERE cnpj_cpf='$codi_cli'");
           $total = mysqli_num_rows($resultado);
           for($i=0; $i<$total; $i++){
              $dados = mysqli_fetch_row($resultado);
              $nome_cli       =$dados[0];
           }

           //Pega o nome do escritório.

           $resultado = mysqli_query ($con,"SELECT nome
           FROM regi_dep
           WHERE codigo='$escritorio'");
           $total = mysqli_num_rows($resultado);

           for($i=0; $i<$total; $i++){
              $dados = mysqli_fetch_row($resultado);
              $nome_escri       =$dados[0];
           }

           //Pega o nome do serviço.

           $resultado = mysqli_query ($con,"SELECT descri_se
           FROM serv_ati
           WHERE codigo_se='$co_servico'");
           $total = mysqli_num_rows($resultado);

           for($i=0; $i<$total; $i++){
              $dados = mysqli_fetch_row($resultado);
              $nome_servi       =$dados[0];
           }

           //Pega o nome do entregador.

           $resultado = mysqli_query ($con,"SELECT nome
           FROM pessoa
           WHERE matricula='$entregador'");
           $total = mysqli_num_rows($resultado);

           for($i=0; $i<$total; $i++){
              $dados = mysqli_fetch_row($resultado);
              $nome_entrega       =$dados[0];
           }

           //Pega o descricao do parentesco.

           $resultado = mysqli_query ($con,"SELECT descricao
           FROM parentesco
           WHERE codigo='$parentesco'");
           $total = mysqli_num_rows($resultado);

           for($i=0; $i<$total; $i++){
              $dados = mysqli_fetch_row($resultado);
              $descricao_pare       =$dados[0];
           }

           //FORMATO DA HAWB
           ?>
           <br>
            <table width=668 height=50 cellspacing=0 cellpadding=0 border=1 bodecolor=#000000 align="center">
                <tr>
                     <td valign=top width=668 height=50 colspan =3>
                        <div align=center>
                           <img border="0" src="img/logo_hawb.jpg" width="668" height="50" border="0">
                        </div>
                     </td>
                  </tr>
            </table>
            <table width=672 height=20 cellspacing=0 cellpadding=2 border=1 bodecolor=#000000 align="center">
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
                              <b>Serviço  :</b><?php echo $nome_servi?>
                           </font>
                        </div>
                     </td>
                  </tr>
            </table>
            <table cellspacing=0 cellpadding=0 width=672 border=1 bodecolor=#000000 height=80 align="center">
               <tr>
               <td>
               <table width=400 cellspacing=0 cellpadding=0>
                 <tr>
                    <td valign=middle width=398 colspan=6 style="FONT-SIZE:10px; COLOR:#000000; LINE-HEIGHT:10px; FONT-FAMILY:Arial,Helvetica,sans-serif">
                      <p><b>Destinatário :</b><font size=1 face=arial><?php echo $nome_desti?></font>
                      <p><b>CNPJ/CPF :</b><font size=1 face=arial><?php echo $cnpj_desti?></font>
                      <p><b>Endereço :</b><font size=1 face=arial><?php echo $rua_desti?> -  <?php echo $numero_desti?></font>
                      <p><b>Complemento :</b><font size=1 face=arial><?php echo $comple_desti?></font>
                      <p><b>Bairro :</b><font size=1 face=arial><?php echo $bairro_desti?> - <b>Cidade :</b><?php echo $cidade_desti?> - <b>Estado :</b><?php echo $estado_desti?> - <b>CEP :</b><?php echo $cep_desti?></font>
                    </td>
                 </tr>
               </table>
               </td>
               <td>
                  <table width=266 cellspacing=0 cellpadding=0>
                     <TBODY>
                       <TR>
                           <TD valign=bottom align=center>
                             <?php fbarcode($cod_barra); ?>
                           </TD>
                       </tr>
                     </tbody>
                  </table>
               </td>
               </tr>
            </table>
            <table cellspacing=0 cellpadding=0 width=672 border=1 bodecolor=#000000 height=100 align="center">
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
                           <font color=#000000 face=arial size=1><b>ATENÇÃO :</b>Após três tentativas de entrega devolver o objeto.</font>
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
                          <b>MOTIVOS DA DEVOLUÇÃO</b>
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
                              (___)  -  Endereço insuficiente.
                           </font>
                        </td>
                      </tr>
                      <tr>
                        <td valign=bottom width=151 style="FONT-SIZE:10px; COLOR:#000000; LINE-HEIGHT:10px; FONT-FAMILY:Arial,Helvetica,sans-serif">
                           <font color=#000000 face=arial size=1>
                              (___)  -  Número inexistente.
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
            <table cellspacing=0 cellpadding=0 width=672 border=1 bodecolor=#000000 height=30 align="center">
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
            <table cellspacing=0 cellpadding=0 width=672 border=1 bodecolor=#000000 height=30 align="center">
               <TBODY>
                  <tr>
                    <td valign=top align=left width=380 style="FONT-SIZE:10px; COLOR:#000000; LINE-HEIGHT:10px; FONT-FAMILY:Arial,Helvetica,sans-serif">
                       <font color=#000000 face=arial size=1>
                          Assinatura recebedor
                       </font>
                    </td>
                    <td valign=top align=left width=171 style="FONT-SIZE:10px; COLOR:#000000; LINE-HEIGHT:10px; FONT-FAMILY:Arial,Helvetica,sans-serif">
                       <font color=#000000 face=arial size=1>
                          Função
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
            <br><br>
           <?php
        }
     }
     else {
       ?>
          <script language="javascript"> window.location.href=("imprime_hawb_por_remessa.php")
            alert('Não há movimento para o número de remessa informado.');
          </script>
       <?php
     }
?>
