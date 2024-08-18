<?php
  ini_set('session.bug_compat_warn', 0);
  ini_set('session.bug_compat_42', 0);
  
  session_start();
  
 //carrega variaveis com dados para acessar o banco de dados

  Include('conexao_free.php');
  mysqli_set_charset($con,'UTF8');

  //Pega o nome do escritorios

  $escritorio = $_SESSION['depto_m'];
  $adm        = $_SESSION['adm_m'];
  
  if ($adm <> 'S') {
      $busca ="SELECT nome FROM regi_dep WHERE codigo='$escritorio'";
      $query = mysqli_query($con,$busca) or die ("Não foi possivel acessar o banco");
      $total = mysqli_num_rows($query);
      for($i=0; $i<$total; $i++){
        $dados = mysqli_fetch_row($query);
        $nome_escri  =$dados[0];
      }
      $_SESSION['nome_escri']=$nome_escri;
  }
  if ($adm == 'S') {
      $_SESSION['nome_escri']='Todas as Bases';
  }
?>

<HTML>
<HEAD>
 <TITLE>mostra_pendencia_escritorio.php</TITLE>
 <script type="text/javascript">
      function openWin(url,name) {
         popupWin = window.open(url, name,
         'scrollbars=yes,resizable=yes,width=900,height=700');
      }
 </script>

 <style>
		body, p, div, td, input, select, textarea {
			font-family: verdana,arial,helvetica;
			font-size:12px;
			color:#000000;
			text-decoration: none;
		}
		input,textarea {
			@if (is.ie) {
				color: #efefef; background-color:#F0F8FF; border: 1px solid #6495ED ;
				/*border-top-width: 1px; border-right-width: 1px; border-bottom-width: 1px; border-left-width: 1px; */
			}
		}
		textarea { overflow:auto }
	</style>

</HEAD>

<BODY>

<FORM>
<INPUT type=button value="Fechar janela" onClick="window.close();">
</FORM>
   <table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#4169E1">
      <tr>
        <?php $nome_escri =$_SESSION['nome_escri'];?>
        <td colspan="14" align="center"><font face="arial" size="2"><b>PENDENCIA ESCRITORIO :<?php echo "$nome_escri";?></b></font></td>
      </tr>
      <tr>
         <td align="center"><b>HAWB</b></td>
         <td align="center"><b>DT ENTRADA</b></td>
         <td align="center"><b>DT LISTA</b></td>
         <td align="center"><b>DT BAIXA</b></td>
         <td align="center"><b>HORAS</b></td>
         <td align="center"><b>NOME</b></td>
         <td align="center"><b>SERVIÇO</b></td>
         <td align="center"><b>BAIRRO</b></td>
         <td align="center"><b>CIDADE</b></td>
         <td align="center"><b>DT ENTREG.</b></td>
         <td align="center"><b>DT DEVO.</b></td>
         <td align="center"><b>REG.</b></td>
         <td align="center"><b>IMAGEM</b></td>
      </tr>
        <?php

         $data               =date("Y/m/d");
         $dt_hoje_co         = strtotime($data);
         $_SESSION['v_hoje'] = $dt_hoje_co;
         $adm                =$_SESSION['adm_m'];
         $matricula          =$_SESSION['matricula_m'];
         If ($adm == 'N') {
             $resultado = "SELECT n_hawb,nome_desti,co_servico,bairro_desti,cidade_desti,entregador,
             dt_remessa,escritorio,dt_envio,dt_lista,dt_baixa,controle
             FROM remessa
             WHERE entregador='$matricula' AND nu_lista=0 AND dt_remessa>='2021-04-16'
             ORDER BY dt_remessa";
         }
         If ($adm == 'P') {
             $resultado = "SELECT n_hawb,nome_desti,co_servico,bairro_desti,cidade_desti,entregador,
             dt_remessa,escritorio,dt_envio,dt_lista,dt_baixa,controle
             FROM remessa
             WHERE escritorio='$escritorio' AND nu_lista=0 AND dt_remessa>='2021-04-16'
             ORDER BY dt_remessa";
         }
         If ($adm == 'S') {
             $resultado = "SELECT n_hawb,nome_desti,co_servico,bairro_desti,cidade_desti,entregador,
             dt_remessa,escritorio,dt_envio,dt_lista,dt_baixa,controle,dt_entrega
             FROM remessa
             WHERE nu_lista=0 AND dt_remessa>='2021-04-16'
             ORDER BY escritorio,dt_remessa";
         }
         
         $vtotal = mysqli_query($con,$resultado);
         $ni=0;
         while ($row = mysqli_fetch_array($vtotal)) {
            $n_hawb            =$row[0];
            $nome_desti        =$row[1];
            $servico           =$row[2];
            $bairro_desti      =$row[3];
            $cidade_desti      =$row[4];
            $entregador        =$row[5];
            $dt_remessa        =$row[6];
            $escritorio        =$row[7];
            $dt_envio          =$row[8];
            $dt_lista          =$row[9];
            $dt_baixa          =$row[10];
            $controle          =$row[11];
			$dt_entrega        =$row[12];
			/*echo "<p>Data Re :".$dt_remessa;
			echo "<p>Data En :".$dt_envio;
			echo "<p>Data Bx :".$dt_baixa;
			echo "<p>Data Li :".$dt_lista;*/
            
            //Muda formato da data para mostrar
            $dt_remessa_v  = explode("-",$dt_remessa);
            $v_dt_remessa_v = $dt_remessa_v[2]."/".$dt_remessa_v[1]."/".$dt_remessa_v[0];
            
            $dt_envio_v  = explode("-",$dt_envio);
            $v_dt_envio = $dt_envio_v[2]."/".$dt_envio_v[1]."/".$dt_envio_v[0];
            
            $dt_lista_v  = explode("-",$dt_lista);
            $v_dt_lista = $dt_lista_v[2]."/".$dt_lista_v[1]."/".$dt_lista_v[0];
            
            $dt_baixa_v  = explode("-",$dt_baixa);
            $v_dt_baixa = $dt_baixa_v[2]."/".$dt_baixa_v[1]."/".$dt_baixa_v[0];
			
			$dt_entrega_v  = explode("-",$dt_entrega);
            $v_dt_entrega = $dt_entrega_v[2]."/".$dt_entrega_v[1]."/".$dt_entrega_v[0];
            
            //Pega o prazo para o escritorio
            $busca_1 ="SELECT prazo_pod,nome FROM regi_dep WHERE codigo='$escritorio'";
            $query_1 = mysqli_query($con,$busca_1) or die ("Não foi possivel acessar o banco");
            $total_1 = mysqli_num_rows($query_1);
            for($i=0; $i<$total_1; $i++){
               $dados = mysqli_fetch_row($query_1);
               $prazo       =$dados[0];
            }
            
            //Pega o nome do serviço
            $busca_se ="SELECT descri_se FROM serv_ati WHERE codigo_se='$servico'";
            $query_se = mysqli_query($con,$busca_se) or die ("Não foi possivel acessar o banco");
            $total_se = mysqli_num_rows($query_se);
            for($i=0; $i<$total_se; $i++){
               $dados = mysqli_fetch_row($query_se);
               $descri_se       =$dados[0];
            }
            //Pega o nome do entregador
            $pega_nome ="SELECT nome FROM cli_for WHERE cnpj_cpf='$entregador'";
            $query = mysqli_query($con,$pega_nome) or die ("Não foi possivel acessar o banco");
            $total = mysqli_num_rows($query);
            for($i=0; $i<$total; $i++){
               $dados = mysqli_fetch_row($query);
               $nome_entregador    =$dados[0];
            }
            if(!isset($nome_entregador)) {
			   $nome_entregador ='';
			}
            $dt_remessa_co  = strtotime($dt_remessa);
            $dt_hoje_co     = $_SESSION['v_hoje'];
            $segundos       = ($dt_hoje_co-$dt_remessa_co);
            $horas          = round(($segundos/60/60));
			
            /*echo "<p>Data Re :".$v_dt_remessa_v;*/
			//echo "<p>Data Envio :".$dt_envio;
			/*echo "<p>Data Bx :".$v_dt_baixa;
			echo "<p>Data Li :".$v_dt_lista;*/
			
            If (($horas >= $prazo) and ($dt_envio=='0000-00-00')) {
                $path ='hawbs/';
                $exte ='.jpg';
                $exte_1='.gif';
				$exte_2='.tif';
                if((file_exists("$path$n_hawb$exte")) or (file_exists("$path$n_hawb$exte_1")) or (file_exists("$path$n_hawb$exte_2"))){
                    $imagem='SIM';
                } 
                else {
					$imagem='NÃO';
			    }
                $idLinha = "linha$i";
	            echo '<tr id="'.$idLinha.'">';
	            echo '<td class="linhas" align="center">'.$n_hawb.'</td>';
	            echo "<td class=\"linhas\">$v_dt_remessa_v</td>";
	            echo "<td class=\"linhas\">$v_dt_lista</td>";
	            echo "<td class=\"linhas\">$v_dt_baixa</td>";
	            echo "<td class=\"linhas\">$horas</td>";
	            echo "<td class=\"linhas\">$nome_desti</td>";
                echo "<td class=\"linhas\">$descri_se</td>";
                echo "<td class=\"linhas\">$bairro_desti</td>";
                echo "<td class=\"linhas\">$cidade_desti</td>";
				echo "<td class=\"linhas\">$v_dt_entrega</td>";
               // echo "<td class=\"linhas\">$nome_entregador</td>";
                echo "<td class=\"linhas\">$v_dt_envio</td>";
                echo "<td class=\"linhas\">$controle</td>";
                echo "<td class=\"linhas\">$imagem</td>";
	            echo "<td class=\"linhas\"><a href=\"javascript:openWin('consulta_remessa_por_hawb_tela_1.php?hawb=$n_hawb','janela_4');\"><img src=\"img/lupa.gif\" alt=\"Mostra\" title=\"Mostra\"></a></td>";
                $ni=$ni+1;
                $imagem='';
                $nome_entregador='';
                $prazo ='';
            }
         }
         echo "<tr>";
            echo "<td colspan=\"13\" align=\"center\"><font size=\"2\" face=\"arial\" color=\"red\" >TOTAL DE PODs PENDENTES ..........$ni</font></td>";
         echo "</tr>";
?>
</table>
</div>
</BODY>
</HTML>
