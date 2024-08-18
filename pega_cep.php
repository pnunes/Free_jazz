<?php
function pega_cep($cep){
	
	Include('conexao_free.php');
    
    $busca="SELECT logradouros.no_logradouro_cep,logradouros.ds_logradouro_nome,
    bairros.ds_bairro_nome,cidades.ds_cidade_nome,uf.ds_uf_nome,uf.ds_uf_sigla,logradouros.classe_cep
    FROM logradouros,bairros,cidades,uf
    WHERE ((logradouros.cd_bairro=bairros.cd_bairro)
    AND (bairros.cd_cidade=cidades.cd_cidade)
    AND (uf.cd_uf=cidades.cd_uf)
    AND (logradouros.no_logradouro_cep='$cep'))";

    $resu = mysqli_query($con,$busca) or die ("Não foi possivel acessar o banco - Função Busca Cep");
    $total = mysqli_num_rows($resu);

    for($ic=0; $ic<$total; $ic++){
       $row = mysqli_fetch_row($resu);
	   
	   $cep            = $row[0];
       $rua            = $row[1];
	   $bairro         = $row[2];
	   $cidade         = $row[3];
	   $estado_n       = $row[4];
	   $estado_s       = $row[5];
	   $classe_cep     = $row[6];  
    }
	         
}

?>



