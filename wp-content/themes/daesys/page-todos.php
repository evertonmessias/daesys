<?php get_header(); ?>

<?php

$anoi = 2014;
$anof = date('Y');

$string_ano_receitas = "";
$string_ano_pagamentos = "";
$sum_ano_receitas = 0;
$sum_ano_pagamentos = 0;
$string_anos = "";


for ($i = $anoi; $i <= $anof; $i++) {

  $table_name = "wp_ano" . $i;

  $list_receitas = list_data("SELECT SUM(VALOR) as VALOR from $table_name WHERE (TIPO LIKE 'RECEITA')");
  $list_pagamentos = list_data("SELECT SUM(VALOR) as VALOR from $table_name WHERE (TIPO LIKE 'PAGAMENTO')");

  $sum_mes_receitas = 0;
  $sum_mes_pagamentos = 0;

  foreach ($list_receitas as $val) {
    $sum_mes_receitas += number_format($val->VALOR, 2, '.', '');
  }

  foreach ($list_pagamentos as $val) {
    $sum_mes_pagamentos += number_format($val->VALOR, 2, '.', '');
  }

  $sum_ano_receitas += $sum_mes_receitas;
  $sum_ano_pagamentos += $sum_mes_pagamentos;
  $string_ano_receitas .= $sum_mes_receitas . ",";
  $string_ano_pagamentos .= $sum_mes_pagamentos . ",";
  $string_anos .= '"'. $i . '",';
}

$sum_ano_receitasF = number_format($sum_ano_receitas, 2, ',', '.');
$sum_ano_pagamentosF = number_format($sum_ano_pagamentos, 2, ',', '.');

?>

<script>
  var formatter = new Intl.NumberFormat('pt-br', {
    style: 'currency',
    currency: 'BRL',
  });

  window.onload = () => {

    const reports1 = {
      series: [{
        name: 'Receitas',
        data: [<?php echo $string_ano_receitas; ?>]
      }, {
        name: 'Pagamentos',
        data: [<?php echo $string_ano_pagamentos; ?>]
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
        categories: [<?php echo $string_anos; ?>]
      },
      tooltip: {
        y: {
          formatter: function(val) {
            return formatter.format(val)
          }
        }
      }
    }

    const reportsChart = new ApexCharts(document.querySelector("#reportsChart"), reports1).render();


    const reports2 = {
      series: [{
        name: 'Receitas',
        data: [<?php echo $string_ano_receitas; ?>]
      }, {
        name: 'Pagamentos',
        data: [<?php echo $string_ano_pagamentos; ?>],
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
        categories: [<?php echo $string_anos; ?>],
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
    }

    const columnChart = new ApexCharts(document.querySelector("#columnChart"), reports2).render();

  }
</script>

<main id="main" class="main">

  <div class="pagetitle">
    <h1>CEBI - DAE AME <strong>(comparativo)</strong></h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.html">home</a></li>
        <li class="breadcrumb-item active">todos</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section dashboard">
    <div class="row">
      <!-- Revenue Card -->
      <div class="col-lg-6">
        <div class="card info-card revenue-card">

          <div class="card-body">
            <h5 class="card-title">Receitas <span>/ (2014 - <?php echo date('Y'); ?> )</span></h5>

            <div class="d-flex align-items-center">
              <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                <i class="bi bi-currency-dollar"></i>
              </div>
              <div class="ps-3">
                <h6><?php echo 'R$ ' . $sum_ano_receitasF; ?></h6>
              </div>
            </div>
          </div>

        </div>
      </div><!-- End Revenue Card -->

      <!-- Customers Card -->
      <div class="col-lg-6">
        <div class="card info-card customers-card">

          <div class="card-body">
            <h5 class="card-title">Pagamentos <span>/ (2014 - <?php echo date('Y'); ?> )</span></h5>

            <div class="d-flex align-items-center">
              <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                <i class="bi bi-currency-dollar"></i>
              </div>
              <div class="ps-3">
                <h6><?php echo 'R$ ' . $sum_ano_pagamentosF; ?></h6>
              </div>
            </div>
          </div>

        </div>
      </div><!-- End Customers Card -->


      <!-- Reports -->
      <div class="col-12">
        <div class="card">

          <div class="card-body">
            <h5 class="card-title">Receitas | Pagamentos <span>/ (2014 - <?php echo date('Y'); ?> )</span></h5>

            <!-- Line Chart -->
            <div id="reportsChart"></div>

          </div>

        </div>
      </div>

      <div class="col-12">
        <div class="card">

          <div class="card-body">
            <h5 class="card-title">Receitas | Pagamentos <span>/ (2014 - <?php echo date('Y'); ?> )</span></h5>

            <!-- Column Chart -->
            <div id="columnChart"></div>

          </div>

        </div>
      </div><!-- End Reports -->

    </div>
  </section>

</main><!-- End #main -->

<?php get_footer(); ?>