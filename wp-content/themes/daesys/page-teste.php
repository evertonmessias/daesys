<?php

$table_name = 'wp_clientes_ativos';

$list_mes = list_data("SELECT janeiro,fevereiro,marco,abril,maio,junho,julho,agosto,setembro,outubro,novembro,dezembro from $table_name;");

$array_val = [];

foreach ($list_mes as $key => $val) {
    $array_val[] = $val;
}

foreach ($array_val[2] as $key => $val) {
    echo $key . " =========> " . $val . "<br>";
}