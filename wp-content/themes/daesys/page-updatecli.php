<?php
if (isset($_POST['intervalo']) && $_POST['intervalo'] == 'ano') {

    global $wpdb;

    $ano = date('Y');

    $array_nome_meses = ["janeiro", "fevereiro", "marco", "abril", "maio", "junho", "julho", "agosto", "setembro", "outubro", "novembro", "dezembro"];

    $array_datai = [
        "01.01.$ano",
        "01.02.$ano",
        "01.03.$ano",
        "01.04.$ano",
        "01.05.$ano",
        "01.06.$ano",
        "01.07.$ano",
        "01.08.$ano",
        "01.09.$ano",
        "01.10.$ano",
        "01.11.$ano",
        "01.12.$ana"
    ];

    $array_dataf = [
        "31.01.$ano",
        "28.02.$ano",
        "31.03.$ano",
        "30.04.$ano",
        "31.05.$ano",
        "30.06.$ano",
        "31.07.$ano",
        "31.08.$ano",
        "30.09.$ano",
        "31.10.$ano",
        "30.11.$ano",
        "31.12.$ano"
    ];

    if (($ano%4==0 && $ano%100!=0) || $ano%400 == 0){
        $array_dataf[1] = "29.02.$ano";
    }

    $table_name = $wpdb->prefix . 'clientes_ativos';

    $conn = DAE::firebird();

    $f=intval(date('m'));

    for ($i = 0; $i < $f; $i++) {

        $datai = $array_datai[$i];
        $dataf = $array_dataf[$i];

        $mes = $array_nome_meses[$i];

        $sql1 = "EXECUTE PROCEDURE PR_LISTA_LIGACOES('$datai','$dataf')";

        $conn->exec($sql1);

        $sql2 = "SELECT COUNT(LIG_L_EST) FROM LIGACOES WHERE LIG_L_EST LIKE 'T';";

        $query = $conn->query($sql2)->fetchAll(PDO::FETCH_ASSOC);

        $clientes_ativos = number_format($query[0]['COUNT'], 0, '', '.');

        $sql3 = "UPDATE $table_name SET $mes = $clientes_ativos WHERE `ano` = $ano;";

        $wpdb->query($sql3);
    }

    echo "OK";

} else {
    echo "ASSESSOR ERRO";
}
