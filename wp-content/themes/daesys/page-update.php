<?php
if (isset($_POST['table'])) {
    $table = $_POST['table'];
    $sql =  "drop table $table;";
    global $wpdb;
    echo $wpdb->query($sql);
} else {
    echo "CEBI ERRO";
}
