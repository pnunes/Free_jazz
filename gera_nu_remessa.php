<?php
session_start();


function gera_nu_remessa(){
    $base_d     =$_SESSION['base_d'];
    $banco_d    =$_SESSION['banco_d'];
    $usuario_d  =$_SESSION['usuario_d'];
    $senha_d    =$_SESSION['senha_d'];

    $data_reme =date("Y-m-d");

    $con = mysql_connect($base_d, $usuario_d, $senha_d) or die ("Erro de conexão");
    $res = mysql_select_db($banco_d) or die ("Banco de dados inexistente");
    
    //Atiualiza a Tabela de numero de remessa

    $ultimo = "SELECT * FROM nu_reme_manu ORDER BY numero DESC LIMIT 1";
    $query = mysql_db_query($banco_d,$ultimo,$con) or die ("Não foi possivel acessar o banco");
    $total = mysql_num_rows($query);
    for($ic=0; $ic<$total; $ic++){
          $row = mysql_fetch_row($query);
          $n_reme       = $row[0];
    }
    $g_remessa          =$n_reme+1;

    $_SESSION['rem_envio_m']   =$g_remessa;

    //Grava o numero da lista na tabela

    $atualiza = "INSERT INTO nu_reme_manu(numero,dt_remessa)
    values('$g_remessa','$data_reme')";

    mysql_db_query($banco_d,$atualiza,$con);
    mysql_close();
}
?>

