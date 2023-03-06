<?php

/*
$datai = '01.01.1900';
$dataf = '31.12.2020';

$sql1 = "EXECUTE PROCEDURE PR_LISTA_LIGACOES('$datai','$dataf')";

$conn = DAE::firebird();

$conn->exec($sql1);

$sql2 = "SELECT COUNT(LIG_L_EST) FROM LIGACOES WHERE LIG_L_EST LIKE 'T';";

$query = $conn->query($sql2)->fetchAll(PDO::FETCH_ASSOC);

$clientes_ativos = number_format($query[0]['COUNT'], 0, '', '.');

echo $clientes_ativos;
*/