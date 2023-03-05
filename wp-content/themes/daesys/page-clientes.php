<?php get_header(); ?>

<?php

$table_name = 'wp_clientes_ativos';

$array_nome_meses = ["janeiro", "fevereiro", "marco", "abril", "maio", "junho", "julho", "agosto", "setembro", "outubro", "novembro", "dezembro"];

//tabelas 2021, ...

$list_mes = list_data("SELECT janeiro,fevereiro,marco,abril,maio,junho,julho,agosto,setembro,outubro,novembro,dezembro from $table_name;");

$string_meses = "";
$string_clientes_2021 = "";
$string_clientes_2022 = "";
$array_val = [];
$clientes_ativos_ano_atual = 0;
$clientes_ativos_total = 0;

foreach ($list_mes as $key => $val) {
  $array_val[] = $val;
}

foreach ($array_val[0] as $key => $val) {
  $string_meses .= '"' . $key . '",';
  $string_clientes_2021 .= $val . ',';
  $clientes_ativos_total += $val;
}

foreach ($array_val[1] as $key => $val) {
  $string_clientes_2022 .= $val . ',';
  $clientes_ativos_total += $val;
}

foreach ($array_val[2] as $key => $val) {
  $string_clientes_2023 .= $val . ',';
  $clientes_ativos_total += $val;
  $clientes_ativos_ano_atual += $val;
}

$total_clientes_ativos = intval(get_post_meta($post->ID, 'total_clientes_ativos_1990_2020', true)) + $clientes_ativos_total;

?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<script>
  window.onload = () => {

    const reports1 = {
      series: [{
        name: '2021',
        data: [<?php echo $string_clientes_2021; ?>]
      }, {
        name: '2022',
        data: [<?php echo $string_clientes_2022; ?>]
      }, {
        name: '2023',
        data: [<?php echo $string_clientes_2023; ?>]
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
      colors: ['#0000FF', '#00FF00', '#00FFFF'],
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
      yaxis: {
        title: {
          text: 'Número de Clientes'
        }
      }
    }

    const reportsChart = new ApexCharts(document.querySelector("#reportsChart"), reports1).render();

    const reports2 = {
      series: [{
        name: '2021',
        data: [<?php echo $string_clientes_2021; ?>]
      }, {
        name: '2022',
        data: [<?php echo $string_clientes_2022; ?>],
      }, {
        name: '2023',
        data: [<?php echo $string_clientes_2023; ?>],
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
          text: 'Número de Clientes'
        }
      },
      markers: {
        size: 4
      },
      colors: ['#0000FF', '#00FF00', '#00FFFF'],
      fill: {
        opacity: 1,
        colors: ['#0000FF', '#00FF00', '#00FFFF']
      }

    }

    const columnChart = new ApexCharts(document.querySelector("#columnChart"), reports2).render();

    //BTN-UPDATECLI
    document.querySelector('#btn-updatecli').addEventListener('click', () => {
            loadPage();
            $.ajax({
                url: '/updatecli',
                type: 'POST',
                data: {
                    'intervalo': 'ano'
                },
                success: (res) => {
                    console.log(res);
                    window.location.reload();
                }
            });
        });

  }
</script>

<main id="main" class="main">

  <div class="pagetitle">
    <h1><strong>Clientes</strong></h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.html">home</a></li>
        <li class="breadcrumb-item active">clientes</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section dashboard">
    <div class="row">
      <!-- Revenue Card -->
      <div class="col-lg-6">
        <div class="card info-card revenue-card">

          <div class="card-body">
            <h5 class="card-title">Clientes Ativos <span>(1990 - <?php echo date('Y'); ?>)</span></h5>

            <div class="d-flex align-items-center">
              <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                <i class="bi bi-person-check"></i>
              </div>
              <div class="ps-3">
                <h6><?php echo number_format($total_clientes_ativos,0,'','.'); ?></h6>
              </div>
            </div>
          </div>

        </div>
      </div><!-- End Revenue Card -->


      <!-- Revenue Card -->
      <div class="col-lg-6">
        <div class="card info-card revenue-card">

          <div class="card-body">
            <h5 class="card-title">Clientes Novos do Ano <span>(<?php echo date('Y'); ?>)</span></h5>

            <div class="d-flex align-items-center">
              <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                <i class="bi bi-person-check"></i>
              </div>
              <div class="ps-3">
                <h6><?php echo number_format($clientes_ativos_ano_atual, 0, '', '.'); ?></h6>
              </div>
            </div>
          </div>

        </div>
      </div><!-- End Revenue Card -->

    </div>


    <div class="row">
      <!-- Reports -->
      <div class="col-12">
        <div class="card">

          <div class="card-body">
            <h5 class="card-title">Clientes Novos <span>(2021 - <?php echo date('Y'); ?>)</span></h5>

            <!-- Line Chart -->
            <div id="reportsChart"></div>

          </div>

        </div>
      </div>

      <div class="col-12">
        <div class="card">

          <div class="card-body">
            <h5 class="card-title">Clientes Novos <span>(2021 - <?php echo date('Y'); ?>)</span></h5>

            <!-- Column Chart -->
            <div id="columnChart"></div>

          </div>

        </div>
      </div><!-- End Reports -->
    </div>

    <div class="row">

      <div class="col-lg-12">
        <form method="POST">
          <input type="bytton" value="Sincronizar" title="Sincronizar com ASSESSOR" id="btn-updatecli" class="btn btn-secondary btn-update">
        </form>
      </div>

    </div>

  </section>

</main><!-- End #main -->

<?php get_footer(); ?>

<?php get_footer(); ?>