<?php
$teste = array(",Seg 13,Ter 14,Quar 15,Qui 16,Sex 17,Sab 18,Dom 19|Saldo","200.00,200.00,200.00,200.00,200.00,200.00,200.00|Receita Realizada","0,0,0,null,null,null,null|Receita Prevista","null,null,0.00,0.00,0,0,0|Despesa Realizada","0,0,0,null,null,null,null|Despesa Prevista","null,null,0.00,0.00,0,0,0");

echo implode(",",$teste);
?>