<?php get_header(); ?>

<?php

$anoi = 2014;
$anof = date('Y');

$sql1 = "SELECT EXTRACT(year from DATA), SUM(VALOR) FROM MOVIMENTO_EMPENHOS_RECEITAS WHERE (TIPO LIKE 'RECEITA') AND DATA BETWEEN TO_DATE('01-JAN-$anoi','DD-MON-YYYY') AND TO_DATE('31-DEC-$anof','DD-MON-YYYY') GROUP BY EXTRACT(year from DATA) ORDER BY 1;";
$receitas =  DAE::oracle($sql1);

$sql2 = "SELECT EXTRACT(year from DATA), SUM(VALOR) FROM MOVIMENTO_EMPENHOS_RECEITAS WHERE (TIPO LIKE 'PAGAMENTO') AND DATA BETWEEN TO_DATE('01-JAN-$anoi','DD-MON-YYYY') AND TO_DATE('31-DEC-$anof','DD-MON-YYYY') GROUP BY EXTRACT(year from DATA) ORDER BY 1;";
$pagamentos =  DAE::oracle($sql2);

preg_match_all('/\d{5,}/', $receitas, $match1);
preg_match_all('/\d{5,}/', $pagamentos, $match2);

$soma_receitas = 0;
$string_receitas = "";
$string_anos = "";

foreach ($match1[0] as $val) {
  $soma_receitas += $val;
  $string_receitas .= $val . ",";
  $string_anos .= $anoi . ",";
  $anoi++;
}

$soma_pagamentos = 0;
$string_pagamentos = "";

foreach ($match2[0] as $val) {
  $soma_pagamentos += $val;
  $string_pagamentos .= $val . ",";
}

$sum_receitasF = number_format($soma_receitas, 2, ',', '.');
$sum_pagamentosF = number_format($soma_pagamentos, 2, ',', '.');

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
                <h6><?php echo 'R$ ' . $sum_receitasF; ?></h6>
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
                <h6><?php echo 'R$ ' . $sum_pagamentosF; ?></h6>
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