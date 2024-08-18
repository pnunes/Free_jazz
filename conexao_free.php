<?php
  //parametros da conexao
  
   //no meu micro - desenvolvimento
   $base_d     ='localhost';
   $banco_d    ='entregas_web';
   $usuario_d  ='root';
   $senha_d    ='';
  
   //na internet
   /*$base_d     ='localhost';
   $banco_d    ='u803786208_entregas_web';
   $usuario_d  ='u803786208_pnunes';
   $senha_d    ='Ps@251857';*/
  
   //estabelece conexao
   $con = mysqli_connect($base_d, $usuario_d,$senha_d,$banco_d) or die ("Erro de conexão");

?>
