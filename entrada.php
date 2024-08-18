<?php
  session_start();
  $ano       =Substr(date("d/m/Y"),6,4);
  $mes_ano   =Substr(date("Y-m-d"),0,7);

  $_SESSION['hora_m']    =date('H:i:s');
  $_SESSION['dt_lista_m']=date('d/m/Y');
  
  $_SESSION['ano']=$ano;
  $_SESSION['mes_ano']=$mes_ano;

  $programa='000';
  $_SESSION['programa_m']=$programa;
  
  $depto_m   =$_SESSION['depto_m'];
  $adm_m     =$_SESSION['adm_m'];

  unset($_SESSION['v_data_ini_m']);
  unset($_SESSION['v_data_fim_m']);

  ////////////////////Criando variável que é utilizada na rotina LANAÇA REMESSA COM LEITORA/////////////
  $_SESSION['lupe_m']    ='N';
  $_SESSION['entrada_m'] ='S';
  ////////////////////////////////////////////////////////////////////////////////////////////////////
  
  Include_once('conexao_free.php');

?>
<HTML>
<HEAD>
 <TITLE>Entrada.php</TITLE>
</HEAD>
<BODY>
<body topmargin="0" leftmargin="0" rightmargin="0" bottommargin="0" marginheight="0" marginwidth="0" bgcolor="#FFFFFF">

<table border="0" width="100%" bgcolor="#000000" cellspacing="0" cellpadding="0">
  <tr>
    <td width="20%" height="100" background="img/topleft.jpg"></td>
     <td width="658" height="110"> <img border="0" src="img/cabecalho_free_jazz.jpg" width="890" height="130" border="0"></td>
    <td width="15%" height="110">
      <p align="right"><img border="0" src="img/topright.jpg" width="275" height="130" border="0"></td>
  </tr>
</table>
<table border="0" width="100%" cellspacing="0" cellpadding="0" background="img/blue.jpg">
  <tr>
    <td width="100%">
      <p align="right"><font face="Arial" size="2" color="#FFFFFF"><b>Sistema de Gerenciamento da Logística de Encomendas</b></font></td>
  </tr>
</table>
  <table width="100%" border="0" cellspacing="0" cellpadding="0" height="50">
     <tr>
       <td color="white" align="left" width="900" height="100">
     </tr>
     <script type="text/javascript">
      function vertical() {

          var navItems = document.getElementById("nav").getElementsByTagName("li");

          for (var i=0; i< navItems.length; i++) {
             if(navItems[i].className == "submenu") {
                navItems[i].onmouseover=function() {this.getElementsByTagName('ul')[0].style.display="block";this.style.backgroundColor = "#FFFFFF";}
                navItems[i].onmouseout=function() {this.getElementsByTagName('ul')[0].style.display="none";this.style.backgroundColor = "#FFFFFF";}
             }
          }

      }

      function horizontal() {

          var navItems = document.getElementById("barra").getElementsByTagName("li");

          for (var i=0; i< navItems.length; i++) {
             if((navItems[i].className == "menuvertical") || (navItems[i].className == "submenu")) {
                if(navItems[i].getElementsByTagName('ul')[0] != null) {
                   navItems[i].onmouseover=function() {this.getElementsByTagName('ul')[0].style.display="block";this.style.backgroundColor = "#FFFFFF";}
                   navItems[i].onmouseout=function() {this.getElementsByTagName('ul')[0].style.display="none";this.style.backgroundColor = "#FFFFFF";}
                }
             }
          }

      }
   </script>

   <style type="text/css">

     body { fontsize(2)}

       ul.menubar
     {
       margin: 0px;
       padding: 0px;
       background-color: #FFFFFF; /* IE6 Bug */
       font-size: 100%;
     }

       ul.menubar .menuvertical
     {
       margin: 0px;
       padding: 0px;
       list-style: none;
       background-color: #FFFFFF;
       border: 1px solid #FFFFFF;
       float:left;
     }

       ul.menubar ul.menu
     {
       display: none;
       position: absolute;
       background-color: #FFFFFF; /* IE6 Bug */
       margin: 0px;
     }

       ul.menubar a
     {
       padding: 5px;
       display:block;
       text-decoration: none;
       background-color: #FFFFFF; /* IE6 Bug */
       color: #000000;
       padding: 5px;
     }


       ul.menu,
       ul.menu ul
     {
       margin: 0;
       padding: 0;
       border-bottom: 1px solid #FFFFFF;
       width: 150px; /* Width of Menu Items */
       background-color: #FFFFFF; /* IE6 Bug */
     }

       ul.menu li
     {
       position: relative;
       list-style: none;
       border: 0px;
       background-color: #FFFFFF; /* IE6 Bug */
     }

       ul.menu li hr
     {
       width: 178px;
       padding: 0px;
       margin: 0px;
       background-color: #FFFFFF; /* IE6 Bug */
     }

       ul.menu li a
     {
       display: block;
       text-decoration: none;
       border: 1px solid #FFFFFF;
       border-bottom: 0px;
       color: #000000;
       padding: 5px 10px 5px 5px;
       background-color: #FFFFFF; /* IE6 Bug */
     }

     /* Fix IE. Hide from IE Mac \*/
     * html ul.menu li { float: left; height: 1%; }
     * html ul.menu li a { height: 1%; }
     /* End */

       ul.menu ul
     {
       position: absolute;
       display: none;
       left: 145px; /* Set 1px less than menu width */
       top: 0px;
       background-color: #FFFFFF; /* IE6 Bug */
     }

       ul.menu li.submenu ul { display: none; } /* Hide sub-menus initially */

       ul.menu li.submenu { background: #FFFFFF; }

       ul.menu li a:hover { color: #000000}

     </style>
       </head>
        <body onload="horizontal();">
         <ul id="barra" class="menubar">
            <li class="menuvertical"><a href="#"><img src="img/cadastros.jpg" border="none"></a>
               <ul id="nav" class="menu">
                  <li class="submenu"><a href="#"><img src="img/pessoas.jpg" border="none"></a>
                     <ul>
       <!--ROT -001 ok-->  <li><a href="cadastro_pessoas.php"><img src="img/inclusao.jpg" border="none"></a></li>
       <!--ROT -002 ok-->  <li><a href="cadastro_pessoas_altera.php"><img src="img/alteracao.jpg" border="none"></a></li>
       <!--ROT -079 ok-->  <li><a href="exclui_pessoa_cadastrada.php"><img src="img/exclusao.jpg" border="none"></a></li>
                     </ul>
                  </li>
                  <li class="submenu"><a href="#"><img src="img/cli_for.jpg" border="none"></a>
                     <ul>
       <!--ROT -003 ok-->  <li><a href="cadastro_cli_for.php"><img src="img/inclusao.jpg" border="none"></a></li>
       <!--ROT -004 ok-->  <li><a href="cadastro_cli_for_altera.php"><img src="img/alteracao.jpg" border="none"></a></li>
       <!--ROT -080 ok-->  <li><a href="exclui_cli_for_cadastrado.php"><img src="img/exclusao.jpg" border="none"></a></li>
                     </ul>
                  </li>
                  <li class="submenu"><a href="#"><img src="img/destinos.jpg" border="none"></a>
                     <ul>
       <!--ROT -005 ok-->  <li><a href="cadastro_destinos.php"><img src="img/inclusao.jpg" border="none"></a></li>
       <!--ROT -006 ok-->  <li><a href="cadastro_destinos_altera.php"><img src="img/alteracao.jpg" border="none"></a></li>
       <!--ROT -081 ok-->  <li><a href="cadastro_destinos_exclui.php"><img src="img/exclusao.jpg" border="none"></a></li>
                     </ul>
                  </li>
                  <li class="submenu"><a href="#"><img src="img/funcao.jpg" border="none"></a>
                     <ul>
       <!--ROT -007 ok-->  <li><a href="cadastro_funcao.php"><img src="img/inclusao.jpg" border="none"></a></li>
       <!--ROT -008 ok-->  <li><a href="cadastro_funcao_altera.php"><img src="img/alteracao.jpg" border="none"></a></li>
                     </ul>
                  </li>
                  <li class="submenu"><a href="#"><img src="img/escritorios.jpg" border="none"></a>
                     <ul>
       <!--ROT -009 ok-->  <li><a href="cadastro_escritorios.php"><img src="img/inclusao.jpg" border="none"></a></li>
       <!--ROT -010 ok-->  <li><a href="cadastro_escritorios_altera.php"><img src="img/alteracao.jpg" border="none"></a></li>
	   <!--ROT -120 ok-->  <li><a href="cadastro_escritorios_exclui.php"><img src="img/exclusao.jpg" border="none"></a></li>
                     </ul>
                  </li>
                  <li class="submenu"><a href="#"><img src="img/servicos.jpg" border="none"></a>
                     <ul>
       <!--ROT -011 ok-->  <li><a href="cadastro_servicos.php"><img src="img/inclusao.jpg" border="none"></a></li>
       <!--ROT -012 ok-->  <li><a href="cadastro_servicos_altera.php"><img src="img/alteracao.jpg" border="none"></a></li>
	   <!--ROT -121 ok-->  <li><a href="cadastro_servicos_exclui.php"><img src="img/exclusao.jpg" border="none"></a></li>
                     </ul>
                  </li>
                  <li class="submenu"><a href="#"><img src="img/ocorrencia.jpg" border="none"></a>
                     <ul>
       <!--ROT -015 ok-->  <li><a href="cadastro_ocorrencia.php"><img src="img/inclusao.jpg" border="none"></a></li>
       <!--ROT -016 ok-->  <li><a href="cadastro_ocorrencia_altera.php"><img src="img/alteracao.jpg" border="none"></a></li>
       <!--ROT -082 ok-->  <li><a href="cadastro_ocorrencia_exclui.php"><img src="img/exclusao.jpg" border="none"></a></li>
                     </ul>
                  </li>
                  <li class="submenu"><a href="#"><img src="img/permissoes.jpg" border="none"></a>
                     <ul>
       <!--ROT -017 ok-->  <li><a href="cadastro_permissoes.php"><img src="img/inclusao.jpg" border="none"></a></li>
       <!--ROT -018 ok-->  <li><a href="cadastro_permissoes_altera.php"><img src="img/alteracao.jpg" border="none"></a></li>
                     </ul>
                  <li class="submenu"><a href="#"><img src="img/parentesco.jpg" border="none"></a>
                     <ul>
       <!--ROT -019 ok-->  <li><a href="cadastro_parentesco.php"><img src="img/inclusao.jpg" border="none"></a></li>
       <!--ROT -020 ok-->  <li><a href="cadastro_parentesco_altera.php"><img src="img/alteracao.jpg" border="none"></a></li>
	   <!--ROT -122 ok-->  <li><a href="cadastro_parentesco_exclui.php"><img src="img/exclusao.jpg" border="none"></a></li>
                     </ul>
                  <li class="submenu"><a href="#"><img src="img/classe_cep.jpg" border="none"></a>
                     <ul>
       <!--ROT -021 ok-->  <li><a href="cadastro_classe_cep.php"><img src="img/inclusao.jpg" border="none"></a></li>
       <!--ROT -022 ok-->  <li><a href="cadastro_classe_cep_altera.php"><img src="img/alteracao.jpg" border="none"></a></li>
	   <!--ROT -123 ok-->  <li><a href="cadastro_classe_cep_exclui.php"><img src="img/exclusao.jpg" border="none"></a></li>
                     </ul>
                  <li class="submenu"><a href="#"><img src="img/classe_cep_regiao.jpg" border="none"></a>
                     <ul>
      <!--ROT -083 ok-->   <li><a href="cadastro_classe_cep_regiao.php"><img src="img/inclusao.jpg" border="none"></a></li>
      <!--ROT -084 ok-->   <li><a href="cadastro_classe_cep_regiao_altera.php"><img src="img/alteracao.jpg" border="none"></a></li>
      <!--ROT -085 ok-->   <li><a href="cadastro_classe_cep_regiao_exclui.php"><img src="img/exclusao.jpg" border="none"></a></li>
                     </ul>
                  <li class="submenu"><a href="#"><img src="img/tabela_preco_cliente.jpg" border="none"></a>
                     <ul>
     <!--ROT -023 ok-->    <li><a href="cadastro_tabela_preco.php"><img src="img/inclusao.jpg" border="none"></a></li>
     <!--ROT -024 ok-->    <li><a href="cadastro_tabela_preco_altera.php"><img src="img/alteracao.jpg" border="none"></a></li>
     <!--ROT -121 ok-->    <li><a href="atualiza_tabela_preco_cliente.php"><img src="img/atualiza_preco_cliente.jpg" border="none"></a></li>
                     </ul>
                  <li class="submenu"><a href="#"><img src="img/tabela_terceirizado.jpg" border="none"></a>
                     <ul>
     <!--ROT -086 ok-->    <li><a href="cadastro_tabela_preco_contratado.php"><img src="img/inclusao.jpg" border="none"></a></li>
     <!--ROT -087 ok-->    <li><a href="cadastro_tabela_preco_contratado_altera.php"><img src="img/alteracao.jpg" border="none"></a></li>
     <!--ROT -120 ok-->    <li><a href="atualiza_tabela_preco_terceirizado.php"><img src="img/atualiza_preco_terceiro.jpg" border="none"></a></li>
                     </ul>
                  </li>
                  <li class="submenu"><a href="#"><img src="img/recados.jpg" border="none"></a>
                     <ul>
     <!--ROT -025 ok-->    <li><a href="cadastro_recado.php"><img src="img/inclusao.jpg" border="none"></a></li>
     <!--ROT -026 ok-->    <li><a href="cadastro_recado_altera.php"><img src="img/alteracao.jpg" border="none"></a></li>
     <!--ROT -027 ok-->    <li><a href="cadastro_recado_exclui.php"><img src="img/exclusao.jpg" border="none"></a></li>
                     </ul>
               </ul>
            </li>
            <li class="menuvertical"><a href="#"><img src="img/operacao.jpg" border="none"></a>
               <ul id="nav" class="menu">
                   <li class="submenu"><a href="#"><img src="img/importa.jpg" border="none"></a>
                      <ul>
    <!--ROT -028 ok-->     <li><a href="rotina_upload_remessas.php"><img src="img/envia_hawb_servidor.jpg" border="none"></a></li>
    <!--ROT -029 ok-->     <li><a href="rotina_upload_baixa_dibra.php"><img src="img/envia_baixa_cliente_servidor.jpg" border="none"></a></li>
    <!--ROT -030 ok-->     <li><a href="importa_baixa_dibra.php"><img src="img/importa_baixa_cliente.jpg" border="none"></a></li>
    <!--ROT -091 ok-->     <li><a href="limpa_pasta_baixa.php"><img src="img/limpa_pasta_baixa.jpg" border="none"></a></li>
                      </ul>
                   <li class="submenu"><a href="#"><img src="img/importa_baixa.jpg" border="none"></a>
                      <ul>
    <!--ROT -031 ok-->     <li><a href="rotina_upload_baixa.php"><img src="img/remessa_servidor.jpg" border="none"></a></li>
    <!--ROT -088 ok-->     <li><a href="importa_baixa.php"><img src="img/importa_baixa_terceiro.jpg" border="none"></a></li>
                      </ul>
                  <li class="submenu"><a href="#"><img src="img/exporta_dados.jpg" border="none"></a>
                      <ul>
   <!--ROT -089 ok-->      <li><a href="baixa_hawb_sem_imagem.php"><img src="img/hawb_sem_imagem.jpg" border="none"></a></li>
                      </ul>
                 <li class="submenu"><a href="#"><img src="img/conexao_wihus.jpg" border="none"></a>
                      <ul>
                          <li><a href="upload_remessa_wihus.php"><img src="img/remessa_servidor.jpg" border="none"></a></li>
                          <li><a href="importa_remessa_cliente.php"><img src="img/importa_remessa_wihus.jpg" border="none"></a></li>
                          <li><a href="envia_imagem_selecionando.php"><img src="img/envia_imagem_wihus.jpg" border="none"></a></li>
                          <li><a href="remessa_retorno_wihus.php"><img src="img/remessa_retorno_wihus.jpg" border="none"></a></li>
                          <li><a href="captura_remessa_wihus.php"><img src="img/pega_remessa_wihus.jpg" border="none"></a></li>
                          <li><a href="altera_tamanho_imagem.php"><img src="img/altera_tamanho_imagem.jpg" border="none"></a></li>
                      </ul>
               </ul>
            </li>
            <li class="menuvertical"><a href="#"><img src="img/financeiro.jpg" border="none"></a>
               <ul id="nav" class="menu">
                   <li class="submenu"><a href="#"><img src="img/faturamento.jpg" border="none"></a>
                      <ul>
    <!--ROT -045 ok-->     <li><a href="faturamento.php"><img src="img/faturamento_cliente.jpg" border="none"></a></li>
    <!--ROT -090 ok-->     <li><a href="faturamento_cliente_escritorio.php"><img src="img/fatura_escritorio_cliente.jpg" border="none"></a></li>
    <!--ROT -046 ok-->     <li><a href="cancela_faturamento.php"><img src="img/cancela.jpg" border="none"></a></li>
                      </ul>
                   <li class="submenu"><a href="#"><img src="img/bloqueto.jpg" border="none"></a>
                      <ul>
    <!--ROT -047 ok-->     <li><a href="gera_boleto_bradesco.php"><img src="img/boleto_simular.jpg" border="none"></a></li>
                       <li><a href="#"><img src="img/boleto_gerar_imprimir.jpg" border="none"></a></li>
                     </ul>
               </ul>
            </li>
            <li class="menuvertical"><a href="#"><img src="img/consultas.jpg" border="none"></a>
               <ul id="nav" class="menu">
    <!--ROT -048 ok-->  <li class="submenu"><a href="consulta_remessa_por_hawb_tela.php"><img src="img/c_hawb.jpg" border="none"></a>
    <!--ROT -049 ok-->  <li class="submenu"><a href="consulta_destinos.php"><img src="img/destinos.jpg" border="none"></a>
    <!--ROT -050 ok-->  <li class="submenu"><a href="rela_hawb_vencida.php"><img src="img/hawb_vencida.jpg" border="none"></a>
    <!--ROT -103 ok-->  <li class="submenu"><a href="rela_hawb_pendente_entregador.php"><img src="img/hawb_pendente_entregador.jpg" border="none"></a>
    <!--ROT -092 ok-->   <li class="submenu"><a href="rela_hawb_pendente_escritorio.php"><img src="img/hawb_pendente_escritorio.jpg" border="none"></a>
    <!--ROT -077 ok-->   <li class="submenu"><a href="segunda_via_hawb.php"><img src="img/segunda_via_hawb.jpg" border="none"></a>
    <!--ROT -093 ok-->  <li class="submenu"><a href="imprime_hawb_por_remessa.php"><img src="img/imprime_hawb_remessa.jpg" border="none"></a>
    <!--ROT -094 ok-->  <li class="submenu"><a href="monitoramento_servicos.php"><img src="img/monitora_servico.jpg" border="none"></a>
               </ul>
            </li>
            <li class="menuvertical"><a href="#"><img src="img/relatorios.jpg" border="none"></a>
               <ul id="nav" class="menu">
                   <li class="submenu"><a href="#"><img src="img/r_remessa.jpg" border="none"></a>
                      <ul>
    <!--ROT -051 ok-->     <li><a href="rela_item_remessa.php"><img src="img/r_item_remessa.jpg" border="none"></a></li>
    <!--ROT -095 ok-->     <li><a href="rela_item_remessa_cliente.php"><img src="img/item_remessa_cliente.jpg" border="none"></a></li>
    <!--ROT -052 ok-->     <li><a href="rela_hawb_periodo.php"><img src="img/r_por_periodo.jpg" border="none"></a></li>
    <!--ROT -053 ok-->     <li><a href="rela_remessa_entregador.php"><img src="img/r_por_entregador.jpg" border="none"></a></li>
    <!--ROT -054 ok-->     <li><a href="rela_remessa_escritorio.php"><img src="img/r_por_escritorio.jpg" border="none"></a></li>
    <!--ROT -055 ok-->     <li><a href="rela_remessa_cliente.php"><img src="img/r_por_cliente.jpg" border="none"></a></li>
    <!--ROT -056 ok-->     <li><a href="reimprime_lista.php"><img src="img/reimprimir_listas.jpg" border="none"></a></li>
                      </ul>
                   <li class="submenu"><a href="#"><img src="img/faturamento.jpg" border="none"></a>
                      <ul id="nav" class="menu">
                         <li class="submenu"><a href="#"><img src="img/fatu_no_recebe.jpg" border="none"></a>
                          <ul>
       <!--ROT -057 ok-->      <li><a href="rela_fatura_cliente.php"><img src="img/r_por_cliente.jpg" border="none"></a></li>
       <!--ROT -058 ok-->      <li><a href="rela_detalhe_fatura_cliente.php"><img src="img/r_por_cliente_detalhado.jpg" border="none"></a></li>
                           <li class="submenu"><a href="#"><img src="img/fatura_cliente_escritorio_detalhe.jpg" border="none"></a>
                             <ul>
             <!--ROT -059 ok-->     <li><a href="rela_detalhe_fatura_cliente_escri.php"><img src="img/relatorio_papel.jpg" border="none"></a></li>
             <!--ROT -096 ok-->     <li><a href="planilha_detalhe_fatura_cliente_escri.php"><img src="img/planilha_excel.jpg" border="none"></a></li>
                             </ul>
                           <li class="submenu"><a href="#"><img src="img/r_por_periodo.jpg" border="none"></a>
                             <ul>
             <!--ROT -060 ok-->     <li><a href="rela_fatura_periodo.php"><img src="img/r_por_periodo_bruto.jpg" border="none"></a></li>
             <!--ROT -097 ok-->     <li><a href="rela_fatura_liquido_periodo.php"><img src="img/r_por_periodo_liquido.jpg" border="none"></a></li>
                             </ul>
        <!--ROT -061 ok-->     <li><a href="rela_fatura_servico.php"><img src="img/r_por_servico.jpg" border="none"></a></li>
        <!--ROT -098 ok-->     <li><a href="rela_fatura_servico_cliente_base.php"><img src="img/r_por_servico_cliente_base.jpg" border="none"></a></li>
        <!--ROT -062 ok-->     <li><a href="rela_fatura_escritorio.php"><img src="img/r_por_escritorio.jpg" border="none"></a></li>
                          <!-- <li><a href="rela_detalhe_fatura_cliente_escri.php"><img src="img/r_por_cliente_escri.jpg" border="none"></a></li> -->
        <!--ROT -063 ok-->     <li><a href="rela_fatura_entregador.php"><img src="img/r_por_entregador.jpg" border="none"></a></li>
        <!--ROT -064 ok-->     <li><a href="rela_fatura_periodo_sem_valor.php"><img src="img/hawb_sem_valor_rela.jpg" border="none"></a></li>
                          </ul>
                       <li class="submenu"><a href="#"><img src="img/fatu_na_entrega.jpg" border="none"></a>
                          <ul>
       <!--ROT -110 ok-->      <li><a href="rela_detalhe_fatura_cliente_devolu.php"><img src="img/r_por_cliente_detalhado.jpg" border="none"></a></li>
                               <li class="submenu"><a href="#"><img src="img/fatura_cliente_escritorio_detalhe.jpg" border="none"></a>
                             <ul>
             <!--ROT -111 ok-->     <li><a href="rela_detalhe_fatura_cliente_escri_devolu.php"><img src="img/relatorio_papel.jpg" border="none"></a></li>
             <!--ROT -112 ok-->     <li><a href="planilha_detalhe_fatura_cliente_escri_devolu.php"><img src="img/planilha_excel.jpg" border="none"></a></li>
                             </ul>
                           <li class="submenu"><a href="#"><img src="img/r_por_periodo.jpg" border="none"></a></li>
                             <ul>
             <!--ROT -113 ok-->     <li><a href="rela_fatura_periodo_devolu.php"><img src="img/r_por_periodo_bruto.jpg" border="none"></a></li>
             <!--ROT -114 ok-->     <li><a href="rela_fatura_liquido_periodo_devolu.php"><img src="img/r_por_periodo_liquido.jpg" border="none"></a></li>
                             </ul>
        <!--ROT -118 ok-->     <li><a href="rela_fatura_servico_devolu.php"><img src="img/r_por_servico.jpg" border="none"></a></li>
        <!--ROT -115 ok-->     <li><a href="rela_fatura_servico_cliente_base_devolu.php"><img src="img/r_por_servico_cliente_base.jpg" border="none"></a></li>
        <!--ROT -116 ok-->     <li><a href="rela_fatura_escritorio_devolu.php"><img src="img/r_por_escritorio.jpg" border="none"></a></li>
                               <li><a href="rela_detalhe_fatura_cliente_escri.php"><img src="img/r_por_cliente_escri.jpg" border="none"></a></li> 
        <!--ROT -117 ok-->     <li><a href="rela_fatura_entregador_devolu.php"><img src="img/r_por_entregador.jpg" border="none"></a></li>

                          </ul>
                       </ul>
                  </ul>
            </li>
             <li class="menuvertical"><a href="#"><img src="img/manutencao.jpg" border="none"></a>
               <ul id="nav" class="menu">
                  <li class="submenu"><a href="#"><img src="img/ajuda.jpg" border="none"></a>
                      <ul>
                       <li><a href="cadastro_ajuda_altera.php"><img src="img/alteracao.jpg" border="none"></a></li>
                      </ul>
                  <li class="submenu"><a href="apaga_imagem_servidor.php"><img src="img/apaga_imagem_servidor.jpg" border="none"></a>
                  <li class="submenu"><a href="#"><img src="img/rotinas_sistema.jpg" border="none"></a>
                      <ul>
                       <li><a href="cadastro_rotina_sistema.php"><img src="img/inclusao.jpg" border="none"></a></li>
                       <li><a href="cadastro_rotina_sistema_altera.php"><img src="img/alteracao.jpg" border="none"></a></li>
                       <li><a href="cadastro_rotina_sistema_exclui.php"><img src="img/exclusao.jpg" border="none"></a></li>
                      </ul>
                  <li class="submenu"><a href="#"><img src="img/backup.jpg" border="none"></a>
                      <ul>
                       <li><a href="rotina_backup.php"><img src="img/backup_dados.jpg" border="none"></a></li>
                       <li><a href="dowload_backup.php"><img src="img/baixar_backup.jpg" border="none"></a></li>
                      </ul> 
                  <li class="submenu"><a href="#"><img src="img/contato.jpg" border="none"></a>
                      <ul>
                       <li><a href="verifica_contato.php"><img src="img/ver_contato.jpg" border="none"></a></li>
                       <li><a href="contatos_exclui.php"><img src="img/exclusao.jpg" border="none"></a></li>
                      </ul> 
                  <li class="submenu"><a href="#"><img src="img/classe_cep_destino.jpg" border="none"></a>
                      <ul>
      <!--ROT -068 ok-->   <li><a href="cadastro_classe_cep_logradouro.php"><img src="img/classe_cep_logradouro.jpg" border="none"></a></li>
      <!--ROT -069 ok-->   <li><a href="cadastro_classe_cep_destino.php"><img src="img/classe_cep_destino.jpg" border="none"></a></li>
      <!--ROT -099 ok-->   <li><a href="cadastro_classe_cep_regiao_destino.php"><img src="img/classe_cep_regiao_destino.jpg" border="none"></a></li>
      <!--ROT -100 ok-->   <li><a href="cadastro_classe_cep_remessa.php"><img src="img/classe_cep_remessa.jpg" border="none"></a></li>
                           <li><a href="gera_relat_destinos_sem_cep.php"><img src="img/destinos_sem_cep.jpg" border="none"></a></li>
      <!--ROT -070 ok-->   <li><a href="atualiza_valor_hawb_periodo.php"><img src="img/hawb_sem_valor_atu.jpg" border="none"></a></li>
                      </ul>
                  <li class="submenu"><a href="#"><img src="img/controle_operacoes.jpg" border="none"></a>
                      <ul>
       <!--ROT -071 ok-->  <li><a href="mostra_operacoes_feitas_sistema.php"><img src="img/op_por_operador.jpg" border="none"></a></li>
       <!--ROT -072 ok-->  <li><a href="mostra_operacoes_feitas_hawb.php"><img src="img/op_por_hawb.jpg" border="none"></a></li>
       <!--ROT -101 ok-->  <li><a href="mostra_detalhes_operador.php"><img src="img/detalhes_por_operador.jpg" border="none"></a></li>
       <!--ROT -073 ok-->  <li><a href="corrige_servico_remessa.php"><img src="img/corrige_servi_remessa.jpg" border="none"></a></li>
       <!--ROT -102 ok-->  <li><a href="corrige_cliente_remessa.php"><img src="img/corrige_cliente_remessa.jpg" border="none"></a></li>
                      </ul>
     <!--ROT -103 ok-->    <li class="submenu"><a href="mostra_inconsistencias_movimento.php"><img src="img/auditoria_movimento.jpg" border="none"></a>
                           <li class="submenu"><a href="arquivo_morto_movimento.php"><img src="img/arquivo_morto.jpg" border="none"></a>
                           <li class="submenu"><a href="excluir_movimento_morto.php"><img src="img/exclui_movimento.jpg" border="none"></a>
               </ul>
            </li>
            <li class="menuvertical"><a href="#"><img src="img/sobre.jpg" border="none"></a></li>
            <li class="menuvertical"><a href="index.php"><img src="img/sair.jpg" border="none"></a></li>
         </ul>
  </table>
  <?php
  
    $matricula_m   =$_SESSION['matricula_m'];

    $declara = "SELECT matricula FROM controle_recados WHERE ((matricula='$matricula_m')
    AND (lido='N'))";
	
    $query = mysqli_query($con,$declara) or die ("Não foi possivel acessar o banco");
    $achou = mysqli_num_rows($query);
	
    //echo "Achou :$achou";
    If ($achou > 0 ) {
       ?>
       
         <script language="Javascript">
         
         ///FUNÇÃO ANTIGA
         
           var width = 800;
           var height = 550;

           var left = 50;
           var top = 50;

           URL = "mostra_recados_por_destino.php";

           window.open(URL,'popup_1', 'width='+width+', height='+height+', top='+top+', left='+left+', scrollbars=yes, status=no, toolbar=no, location=no, directories=no, menubar=no, resizable=yes, fullscreen=no');

         </script>

       <?php
    }
    ?>

    <?php
     $escritorio=$_SESSION['depto_m'];
     $adm_v     =$_SESSION['adm_m'];
     $data  =date("Y/m/d");
     $dt_hoje_co= strtotime($data);
     $_SESSION['v_hoje']  =$dt_hoje_co;
     
     $busca ="SELECT prazo_pod,nome FROM regi_dep WHERE codigo='$escritorio'";
     
     $query = mysqli_query($con,$busca) or die ("Não foi possivel acessar o banco");
     $total = mysqli_num_rows($query);
	 
     for($i=0; $i<$total; $i++){
        $dados = mysqli_fetch_row($query);
        $prazo       =$dados[0];
     }
     $_SESSION['prazo']  =$prazo;
     if ($adm_v <> 'S') {
         $resultado = "SELECT dt_remessa FROM remessa
         WHERE ((escritorio='$escritorio')
         AND (dt_envio='0000-00-00')
         AND (dt_remessa>='2019-01-01'))";
     }
     If($adm_v == 'S') {
         $resultado = "SELECT dt_remessa FROM remessa
         WHERE ((dt_envio='0000-00-00')
         AND (dt_remessa>='2019-01-01'))";
     }
	 
	 $query = mysqli_query($con,$resultado) or die ("Não foi possivel acessar o banco");
     $vtotal = mysqli_num_rows($query);
	 
     $conta=0;
     while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
        $dt_remessa     =$row['dt_remessa'];
        $dt_remessa_co  = strtotime($dt_remessa);
        $prazo          =$_SESSION['prazo'];
        $dt_hoje_co     =$_SESSION['v_hoje'];
        $segundos       = ($dt_hoje_co-$dt_remessa_co);
        $horas = round(($segundos/60/60));
        If ($horas >= $prazo) {
           $conta=$conta+1;
        }
     }
     if ($conta > 0) {
        ?>
         <script language="Javascript">
            var width = 1000;
            var height = 700;
            var left = 200;
            var top = 100;
            URL = "mostra_pendencia_escritorio.php";

            window.open(URL,'popup_2', 'width='+width+', height='+height+', top='+top+', left='+left+', scrollbars=yes, resizable=yes');
         </script>
        <?php
     }
  ?>
  </table>
  <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
     <tr>
<!--ROT -032 ok--> <td align="center" width="20%"><a href="lanca_remessa_com_leitora.php"><img src="img/botao_bip1.gif" alt="Lançamento de HAWBs Com Leitora." border="none"></a></td>
<!--ROT -035 ok--> <td align="center" width="20%"><a href="elabora_lista_leitora.php"><img src="img/botao_bip2.gif" alt="Elabora Lista de HAWBs Para Entrega." border="none"></a></td>
<!--ROT -038 ok--> <td align="center" width="20%"><a href="baixa_remessa_leitora.php"><img src="img/botao_bip3.gif" alt="Baixa de HAWBs Entregues." border="none"></a></td>
<!--ROT -040 ok--> <td align="center" width="20%"><a href="envia_fisico_remessa.php"><img src="img/botao_bip4.gif" alt="Envio de HAWBs de Volta a Origem." border="none"></a></td>
<!--ROT -104 ok--> <td align="center" width="10%"><a href="inclui_detalhes_entrega.php"><img src="img/botao_bip5.gif" alt="Registro de eventos." border="none"></a></td>
     </tr>
     <tr>
         <td width="10%">
            <table>
               <tr>
 <!--ROT -033 ok-->  <td align="center" width="10%"><a href="altera_remessa_com_leitora.php"><img src="img/alteracao.jpg" alt="Altera Dados HAWB." border="none"></a>
               </tr>
               <tr>
 <!--ROT -034 ok-->  <td align="center" width="10%"><a href="exclui_remessa_com_leitora.php"><img src="img/exclusao.jpg" alt="Exclui HAWB Lançada." border="none"></a>
               </tr>
               <tr>
 <!--ROT -107 ok-->  <td align="center" width="10%"><a href="lanca_remessa_emite_hawb.php"><img src="img/bip_1_com_impressao_hawb.jpg" alt="BIP 1 - Emite HAWB." border="none"></a>
               </tr>
            </table
         </td>
         <td width="10%">
            <table>
               <tr>
  <!--ROT -108 ok--> <td align="center" width="10%"><a href="elabora_lista_leitora_retira.php"><img src="img/bip_2_retira_hawb_lista.jpg" alt="Retira HAWB da Lista de Entrega." border="none"></a>
               </tr>
               <tr>
  <!--ROT -037 ok-->  <td align="center" width="10%"><a href="elabora_lista_manual.php"><img src="img/bip_2_altera_lista_manual.jpg" alt="Elabora Lista de Entrega Manual." border="none"></a>
               </tr>
            </table
         </td>
         <td width="10%">
            <table>
               <tr>
  <!--ROT -109 ok-->  <td align="center" width="10%"><a href="baixa_hawb_imagem_manual.php"><img src="img/baixa_hawb_imagem_manual.jpg" alt="Elabora Lista de Entrega Manual." border="none"></a>
               </tr>
            </table
         </td>
         <td width="20%">
            <table>
               <tr>
  <!--ROT -040 ok--> <!--<td align="center" width="10%"><a href="envia_fisico_remessa.php"><img src="img/bip_4_fisico_remessa.jpg" alt="Lista devolução HAWB a Origem." border="none"></a>-->
               </tr>
               <tr>
  <!--ROT -041 ok--> <td align="center" width="10%"><a href="envia_fisico_remessa_continua.php"><img src="img/bip_4_fisico_remessa_continua.jpg" alt="Continua Lista já começada." border="none"></a>
               </tr>
               <tr>
  <!--ROT -042 ok--> <td align="center" width="10%"><a href="envia_fisico_remessa_retira.php"><img src="img/bip_4_fisico_remessa_retira.jpg" alt="Continua Lista já começada." border="none"></a>
               </tr>
            </table
         </td>
     </tr>
     <tr><td colspan="8" height="40"> </td></tr>
     <tr>
        <table width="80%" border="0" cellspacing="0" cellpadding="0" align="center">
               <tr>
                  <td align="center" width="20%"><a href="rela_hawb_pendente_entregador.php"><img src="img/botao_hawb_pendente_entregador.gif" alt="Relatorio hawb pendente por entregador." border="none"></a></td>
                  <td align="center" width="20%"><a href="rela_hawb_pendente_escritorio.php"><img src="img/botao_hawb_pendente_base.gif" alt="Relatorio hawb pendente por base." border="none"></a></td>
                  <td align="center" width="20%"><a href="inclui_detalhes_entrega.php"><img src="img/botao_eventos_hawb.gif" alt="Inclusão eventos baixa HAWB." border="none"></a></td>
               </tr>
               <tr>
                  <td width="15%"></td>
                  <td width="15%"></td>
                  <td width="15%">
                     <table>
                       <tr>
          <!--ROT -105 ok--> <td align="center" width="10%"><a href="altera_detalhes_entrega.php"><img src="img/alteracao.jpg" alt="Altera eventos." border="none"></a>
                       </tr>
                       <tr>
          <!--ROT -106 ok-->  <td align="center" width="10%"><a href="exclui_detalhes_entrega.php"><img src="img/exclusao.jpg" alt="Exclui eventos." border="none"></a>
                       </tr>
                    </table>
                  </td>
               </tr>
        </table>
     </tr>
  </table>
  <table width="100%" border="0" cellspacing="10" cellpadding="0" align="center">
     <tr>
       <td color="white" align="left" width="100%" height="350"></td>
     </tr>
  </table>
  <table border="0" width="100%" cellspacing="0" cellpadding="0" background="img/blue.jpg">
  <tr>
    <td colspan="1" align="left" width="15%"><INPUT type=button size="3" value="Geral Sobre Sistema"
       onClick="window.open('mostra_ajuda.php','janela_1',
       'scrollbars=yes,resizable=yes,width=400,height=700');" style="width:100;height:30;color=red;font: bold 16px Arial;">
    </td>
    <td width="100%" height="25" align="center"></font><font color="white" size="1" face="Arial">COPYRIGHT NUNESTECH Tecnologia em Sistemas Ltda</font></td>
  </tr>
</table>
</BODY>
</HTML>
