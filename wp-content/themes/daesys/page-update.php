<?php
if (isset($_POST['table'])) {
    $table = $_POST['table'];
    $sql =  "drop table $table;";
    $conexao = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    echo $conexao->query($sql);
} else {
    echo "ERRO";
}
