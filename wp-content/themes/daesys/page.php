<?php get_header(); ?>

<?php

/* PHP */

preg_match_all('/\d+/', $post->post_name, $yn);
$ano = $yn[0][0];

$bar_max =  15;

$cor1 = "'rgb(0,0,255)','rgb(30,144,255)','rgb(0,191,255)','rgb(135,206,250)','rgb(64,224,208)','rgb(72,209,204)','rgb(32,178,170)','rgb(0,255,127)','rgb(152,251,152)','rgb(144,238,144)','rgb(0,100,0)','rgb(0,128,0)','rgb(34,139,34)','rgb(186,85,211)','rgb(128,0,128)','rgb(139,0,139)','rgb(255,127,80)','rgb(255,99,71)','rgb(255,0,0)'";
$cor2 = "'rgb(255,0,0)','rgb(255,99,71)','rgb(255,127,80)','rgb(139,0,139)','rgb(128,0,128)','rgb(186,85,211)','rgb(34,139,34)','rgb(0,128,0)','rgb(0,100,0)','rgb(144,238,144)','rgb(152,251,152)','rgb(0,255,127)','rgb(32,178,170)','rgb(72,209,204)','rgb(64,224,208)','rgb(135,206,250)','rgb(0,191,255)','rgb(30,144,255)','rgb(0,0,255)'";

$array_meses = [
    "1" => "janeiro",
    "2" => "fevereiro",
    "3" => "março",
    "4" => "abril",
    "5" => "maio",
    "6" => "junho",
    "7" => "julho",
    "8" => "agosto",
    "9" => "setembro",
    "10" => "outubro",
    "11" => "novembro",
    "12" => "dezembro"
];

global $wpdb;
$charset_collate = $wpdb->get_charset_collate();
$table_name = $wpdb->prefix . 'ano' . $ano;
$sql = "CREATE TABLE $table_name (`ID` INT PRIMARY KEY NOT NULL AUTO_INCREMENT,`DATA_MES` TEXT,`NOME_DETALHE` TEXT,`VALOR` TEXT,`TIPO` TEXT,`EXERCICIO` TEXT)$charset_collate;";
if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
    $sql1 = "SELECT EXTRACT(month from DATA),NOME_DETALHE,VALOR,TIPO,EXERCICIO FROM MOVIMENTO_EMPENHOS_RECEITAS WHERE (TIPO LIKE 'RECEITA' OR TIPO LIKE 'PAGAMENTO') AND EXERCICIO LIKE '$ano' AND DATA BETWEEN TO_DATE('01-JAN-$ano','DD-MON-YYYY') AND TO_DATE('31-DEC-$ano','DD-MON-YYYY') ORDER BY 1 ASC;";
    $sql2 =  "INSERT INTO $table_name VALUES " . DAE::oracle2mysql($sql1);
    $conexao = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    $conexao->query($sql2);
}

//Linhas, BarrasV, Card e Pizza (RECEITA/PAGAMENTO) *******************************************

$list_mes_receitas = list_data("SELECT DATA_MES, SUM(VALOR) as VALOR from $table_name WHERE (TIPO LIKE 'RECEITA') GROUP BY DATA_MES ORDER BY 1");

$sum_receitas = 0;
$string_meses = "";
$string_receitas = "";

foreach ($list_mes_receitas as $val) {
    $string_meses .= '"' . $array_meses[trim($val->DATA_MES)] . '",';
    $string_receitas .= number_format($val->VALOR, 2, '.', '') . ',';
    $sum_receitas += number_format($val->VALOR, 2, '.', '');
}

$list_mes_pagamentos = list_data("SELECT DATA_MES, SUM(VALOR) as VALOR from $table_name WHERE (TIPO LIKE 'PAGAMENTO') GROUP BY DATA_MES ORDER BY 1");

$sum_pagamentos = 0;
$string_pagamentos = "";

foreach ($list_mes_pagamentos as $val) {
    $string_pagamentos .= number_format($val->VALOR, 2, '.', '') . ',';
    $sum_pagamentos += number_format($val->VALOR, 2, '.', '');
}

$sum_receitasF = number_format($sum_receitas, 2, ',', '.');
$sum_pagamentosF = number_format($sum_pagamentos, 2, ',', '.');


//BarrasH (RECEITAS/PAGAMENTOS) *************************************************************************


$list_mov_receitas = list_data("SELECT NOME_DETALHE, SUM(VALOR) as VALOR from $table_name WHERE (TIPO LIKE 'RECEITA') GROUP BY NOME_DETALHE ORDER BY 2 DESC");

$string_movimentos_receitas = "";
$string_receitas2 = "";
$x = 1;

foreach ($list_mov_receitas as $val) {
    if ($x <= $bar_max) {
        $string_movimentos_receitas .= '"' . $val->NOME_DETALHE . '",';
        $string_receitas2 .= number_format($val->VALOR, 2, '.', '') . ',';
    }
    $x++;
}

$list_mov_pagamentos = list_data("SELECT NOME_DETALHE, SUM(VALOR) as VALOR from $table_name WHERE (TIPO LIKE 'PAGAMENTO') GROUP BY NOME_DETALHE ORDER BY 2 DESC");

$string_movimentos_pagamentos = "";
$string_pagamentos2 = "";
$y = 1;

foreach ($list_mov_pagamentos as $val) {
    if ($y <= $bar_max) {
        $string_movimentos_pagamentos .= '"' . $val->NOME_DETALHE . '",';
        $string_pagamentos2 .= number_format($val->VALOR, 2, '.', '') . ',';
    }
    $y++;
}

?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<script>
    /* JS */

    var formatter = new Intl.NumberFormat('pt-br', {
        style: 'currency',
        currency: 'BRL',
    });

    window.onload = () => {

        //Pizza **********************************************
        const pieC = {
            type: 'pie',
            data: {
                labels: [
                    'Receitas',
                    'Pagamentos'
                ],
                datasets: [{
                    data: [<?php echo $sum_receitas; ?>, <?php echo $sum_pagamentos; ?>],
                    backgroundColor: ['#2eca6a', '#ff771d'],
                    hoverOffset: 4
                }],
                options: {
                    tooltips: {
                        callbacks: {
                            label: function(val) {
                                return formatter.format(val)
                            }
                        }
                    }
                }
            }
        };
        const pieChart = new Chart(document.querySelector('#pieChart'), pieC);

        //Linhas **********************************************
        const reports1 = {
            series: [{
                name: 'Receitas',
                data: [<?php echo $string_receitas; ?>]
            }, {
                name: 'Pagamentos',
                data: [<?php echo $string_pagamentos; ?>]
            }],
            chart: {
                height: 350,
                type: 'area',
                toolbar: {
                    show: false
                },
            },
            markers: {
                size: 4
            },
            colors: ['#2eca6a', '#ff771d'],
            fill: {
                type: "gradient",
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.3,
                    opacityTo: 0.4,
                    stops: [0, 90, 100]
                }
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth',
                width: 2
            },
            xaxis: {
                categories: [<?php echo $string_meses; ?>]
            },
            tooltip: {
                y: {
                    formatter: function(val) {
                        return formatter.format(val)
                    }
                }
            }
        };
        const reportsChart = new ApexCharts(document.querySelector("#reportsChart"), reports1).render();

        //Barras **********************************************
        const reports2 = {
            series: [{
                name: 'Receitas',
                data: [<?php echo $string_receitas; ?>]
            }, {
                name: 'Pagamentos',
                data: [<?php echo $string_pagamentos; ?>],
            }],
            chart: {
                type: 'bar',
                height: 350
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '55%',
                    endingShape: 'rounded'
                },
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            xaxis: {
                categories: [<?php echo $string_meses; ?>],
            },
            yaxis: {
                title: {
                    text: 'R$'
                }
            },
            markers: {
                size: 4
            },
            colors: ['#2eca6a', '#ff771d'],
            fill: {
                opacity: 1,
                colors: ['#2eca6a', '#ff771d']
            },
            tooltip: {
                y: {
                    formatter: function(val) {
                        return formatter.format(val)
                    }
                }
            }
        };
        const columnChart = new ApexCharts(document.querySelector("#columnChart"), reports2).render();

        //Barras1 **********************************************
        const reports3 = {
            series: [{
                data: [<?php echo $string_receitas2; ?>]
            }],
            chart: {
                type: 'bar',
                height: 450
            },
            plotOptions: {
                bar: {
                    borderRadius: 4,
                    horizontal: true,
                }
            },
            dataLabels: {
                enabled: false
            },
            colors: ['#2eca6a'],
            xaxis: {
                categories: [<?php echo $string_movimentos_receitas; ?>],
            },
            tooltip: {
                y: {
                    formatter: function(val) {
                        return formatter.format(val)
                    }
                }
            }
        }
        const barChart1 = new ApexCharts(document.querySelector("#barChart1"), reports3).render();

        //Barras2 **********************************************
        const reports4 = {
            series: [{
                data: [<?php echo $string_pagamentos2; ?>]
            }],
            chart: {
                type: 'bar',
                height: 450
            },
            plotOptions: {
                bar: {
                    borderRadius: 4,
                    horizontal: true,
                }
            },
            dataLabels: {
                enabled: false
            },
            colors: ['#ff771d'],
            xaxis: {
                categories: [<?php echo $string_movimentos_pagamentos; ?>],
            },
            tooltip: {
                y: {
                    formatter: function(val) {
                        return formatter.format(val)
                    }
                }
            }
        }
        const barChart2 = new ApexCharts(document.querySelector("#barChart2"), reports4).render();

        //BTN-UPDATE
        document.querySelector('#btn-update').addEventListener('click', () => {
            loadPage();
            $.ajax({
                url: '/update',
                type: 'POST',
                data: {
                    'table': '<?php echo $table_name; ?>'
                },
                success: (res) => {
                    console.log(res);
                    window.location.reload();
                }
            });
        });

    }
</script>

<!-- HTML -->

<main id="main" class="main">

    <div class="pagetitle">
        <h1>CEBI - DAE AME <strong><?php echo $ano; ?></strong></h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">home</a></li>
                <li class="breadcrumb-item active">dashboard <?php echo $ano; ?></li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">
            <div class="col-lg-8">
                <div class="row">
                    <!-- Reports -->
                    <div class="col-12">
                        <div class="card">

                            <div class="card-body">
                                <h5 class="card-title">Receitas | Pagamentos <span>/ <?php echo $ano; ?></span></h5>

                                <!-- Line Chart -->
                                <div id="reportsChart"></div>

                            </div>

                        </div>
                    </div>

                    <div class="col-12">
                        <div class="card">

                            <div class="card-body">
                                <h5 class="card-title">Receitas | Pagamentos <span>/ <?php echo $ano; ?></span></h5>

                                <!-- Column Chart -->
                                <div id="columnChart"></div>

                            </div>

                        </div>
                    </div><!-- End Reports -->

                </div>
            </div>

            <div class="col-lg-4">
                <div class="row">
                    <!-- Revenue Card -->
                    <div class="col-lg-12">
                        <div class="card info-card revenue-card">

                            <div class="card-body">
                                <h5 class="card-title">Receitas <span>| Total <?php echo $ano; ?></span></h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-currency-dollar"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6><?php echo 'R$ ' . $sum_receitasF; ?></h6>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div><!-- End Revenue Card -->

                    <!-- Customers Card -->
                    <div class="col-lg-12">
                        <div class="card info-card customers-card">

                            <div class="card-body">
                                <h5 class="card-title">Pagamentos <span>| Total <?php echo $ano; ?></span></h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-currency-dollar"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6><?php echo 'R$ ' . $sum_pagamentosF; ?></h6>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div><!-- End Customers Card -->

                    <!-- Pie Card -->
                    <div class="col-lg-12">
                        <div class="card info-card customers-card">
                            <div class="card-body">
                                <h5 class="card-title">Receitas | Pagamentos <span>/ <?php echo $ano; ?></span></h5><br><br>
                                <div class="d-flex align-items-center">
                                    <canvas id="pieChart" style="max-height: 400px;"></canvas>
                                </div>
                            </div>

                        </div>
                    </div><!-- End Customers Card -->

                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Receitas por Categoria</h5>
                        <div id="barChart1"></div>
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Pagamentos por Categoria</h5>
                        <div id="barChart2"></div>
                    </div>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-lg-12">
                <form method="POST">
                    <input type="bytton" value="Sincronizar" id="btn-update" class="btn btn-secondary btn-update">
                </form>
            </div>
        </div>
    </section>

</main><!-- End #main -->

<?php get_footer(); ?>