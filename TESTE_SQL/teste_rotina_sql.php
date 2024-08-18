<?php
   // esta variaveis serão recebidas da rotina que chama esta função
   $codi_cli       ='11-9 3953-6262';
   $tabela         ='remessa';
   $campos         ='codi_cli,n_hawb,nome_desti,dt_remessa';
   $postsInclusao  ='';
   $postsAlteracao ='';
   $condicao ="codi_cli = '11-9 3953-6262' AND dt_remessa>='2021-12-10' AND dt_remessa<='2022-02-10'";
   $tipo     ='L'; // I para inclusao, A para alteração D para apagar L para listar.

   $resultado = executaQuery($tabela,$campos,$postsInclusao,$postsAlteracao,$condicao,$tipo);
  

  function executaQuery($tabela,$campos,$postsInclusao,$postsAlteracao,$condicao,$tipo)
  {
	//abre conexao com o banco dedados  
	Include('conexao_free.php');
	
	if($tipo == 'I') {
       $incluir    = "INSERT INTO $tabela ($campos) VALUES ($postsInclusao)";
	   $incluiu = mysqli_query($con,$incluir) or die ("Não foi possivel acessar a tabela remessa para incluir");
	   if($incluiu){
		   $resultado ='Inclusao bem sucedida!';   
	   }else {
		   $resultado ='Problemas na inclusão! Verifique.';
	   }
    }
    if($tipo == 'A') {
       $alterar    = "UPDADE $tabela ($postsAlteracao) WHERE $condicao";
	   $alterou = mysqli_query($con,$alterar) or die ("Não foi possivel acessar a tabela remessa para alterar");
	   if($alterou){
		   $resultado ='Alteração bem sucedida!';   
	   }else {
		   $resultado ='Problemas na Alteração! Verifique.';
	   }
    }
    if($tipo == 'D') {
       $excluir    = "DELETE FROM $tabela WHERE $condicao";
	   $excluiu = mysqli_query($con,$excluir) or die ("Não foi possivel acessar a tabela remessa para excluir");
	   if($excluiu){
		   $resultado ='Exclusão bem sucedida!';   
	   }else {
		   $resultado ='Problemas na Exclusão! Verifique.';
	   }
    }
    if($tipo == 'L') {
       $listar     = "SELECT $campos FROM $tabela WHERE $condicao";
	   $listou = mysqli_query($con,$listar) or die ("Não foi possivel acessar a tabela remessa para listar");
	   if($listou){
		   $resultado = $listou; 
	   }else{
		   $resultado ='Problemas na montagem da lista! Verifique.';
	   }
    }
    return($resultado);
	
  }
  
  foreach($resultado as $row){
	  echo "<p>".$row['codi_cli'].' - '.$row['n_hawb'].' - '.$row['nome_desti'].' - '.$row['dt_remessa']."</p>";  
  }

?>