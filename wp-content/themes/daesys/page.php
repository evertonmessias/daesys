<?php get_header(); ?>

<?php

/* PHP */

preg_match_all('/\d+/', $post->post_name, $yn);
$ano = $yn[0][0];

$array_meses = ["janeiro", "fevereiro", "março", "abril", "maio", "junho", "julho", "agosto", "setembro", "outubro", "novembro", "dezembro"];
$cor1 = "'rgb(0,0,255)','rgb(30,144,255)','rgb(0,191,255)','rgb(135,206,250)','rgb(64,224,208)','rgb(72,209,204)','rgb(32,178,170)','rgb(0,255,127)','rgb(152,251,152)','rgb(144,238,144)','rgb(0,100,0)','rgb(0,128,0)','rgb(34,139,34)','rgb(186,85,211)','rgb(128,0,128)','rgb(139,0,139)','rgb(255,127,80)','rgb(255,99,71)','rgb(255,0,0)'";
$cor2 = "'rgb(255,0,0)','rgb(255,99,71)','rgb(255,127,80)','rgb(139,0,139)','rgb(128,0,128)','rgb(186,85,211)','rgb(34,139,34)','rgb(0,128,0)','rgb(0,100,0)','rgb(144,238,144)','rgb(152,251,152)','rgb(0,255,127)','rgb(32,178,170)','rgb(72,209,204)','rgb(64,224,208)','rgb(135,206,250)','rgb(0,191,255)','rgb(30,144,255)','rgb(0,0,255)'";

//Linhas, BarrasV, Card e Pizza (RECEITA/PAGAMENTO) *******************************************

$receitas = month_data($ano, 'RECEITA');
$pagamentos = month_data($ano, 'PAGAMENTO');

$sum_receitas = 0;
$sum_pagamentos = 0;

for ($i = 0; $i < sizeof($receitas); $i++) {
  $sum_receitas += $receitas[$i];
  $sum_pagamentos += $pagamentos[$i];
  $string_meses .= '"' . $array_meses[$i] . '",';
}

$sum_receitasF = number_format($sum_receitas, 2, ',', '.');
$string_receitas = implode(",", $receitas);

$sum_pagamentosF = number_format($sum_pagamentos, 2, ',', '.');
$string_pagamentos = implode(",", $pagamentos);


//BarrasH (RECEITAS/PAGAMENTOS) *************************************************************************

$barras_receitas = item_data($ano, 'RECEITA', 10);

$string_movimentos_receitas = $barras_receitas['iten'];

$string_receitas2 = $barras_receitas['data'];

$barras_pagamentos = item_data($ano, 'PAGAMENTO', 15);

$string_movimentos_pagamentos = $barras_pagamentos['iten'];

$string_pagamentos2 = $barras_pagamentos['data'];

?>

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
  </section>

</main><!-- End #main -->

<?php get_footer(); ?>