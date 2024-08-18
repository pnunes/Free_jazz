<?php
session_start();
$nome           =$_SESSION['nome_desti_h'];
$endereco       =$_SESSION['rua_desti_h'];
$numero         =$_SESSION['numero_desti_h'];
$comple         =$_SESSION['comple_desti_h'];
$bairro         =$_SESSION['bairro_desti_h'];
$cidade         =$_SESSION['cidade_desti_h'];
$estado         =$_SESSION['estado_desti_h'];
$cep            =$_SESSION['cep_desti_h'];
$cd_barra       =$_SESSION['cod_barra_h'];
$servico        =$_SESSION['servico_h'];
$n_hawb         =$_SESSION['n_hawb_h'];
$escritorio     =$_SESSION['escritorio_h'];

include ("funcao_cb.php");
include ("layout_cb.php");
?>

