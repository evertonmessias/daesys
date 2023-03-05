<?php get_header(); ?>

<?php

global $wpdb;

$array_nome_meses = ["janeiro","fevereiro","marco","abril","maio","junho","julho","agosto","setembro","outubro","novembro","dezembro"];

$array_datai = [
    '01.01.2023',
    '01.02.2023',
    '01.03.2023',
    '01.04.2023',
    '01.05.2023',
    '01.06.2023',
    '01.07.2023',
    '01.08.2023',
    '01.09.2023',
    '01.10.2023',
    '01.11.2023',
    '01.12.2023'
];

//mes atual

$table_name = $wpdb->prefix . 'clientes_ativos';

$i=intval(date('m'))-1;

$datai = $array_datai[$i];
$dataf = date('d.m.Y');
$mes = $array_nome_meses[$i];

$conn = DAE::firebird();

$sql1 = "EXECUTE PROCEDURE PR_LISTA_LIGACOES('$datai','$dataf')";

$conn->exec($sql1);

$sql2 = "SELECT COUNT(LIG_L_EST) FROM LIGACOES WHERE LIG_L_EST LIKE 'T';";

$query = $conn->query($sql2)->fetchAll(PDO::FETCH_ASSOC);

$clientes_ativos_mes_atual = number_format($query[0]['COUNT'], 0, '', '.');

$sql3 = "UPDATE $table_name SET $mes = $clientes_ativos_mes_atual WHERE `ano` = 2023;";

$wpdb->query($sql3);

$total_clientes_ativos = get_post_meta($post->ID, 'total_clientes_ativos_1990_2020', true);

//tabelas 2021 e 2022

$list_mes = list_data("SELECT janeiro,fevereiro,marco,abril,maio,junho,julho,agosto,setembro,outubro,novembro,dezembro from $table_name;");

$string_meses = "";
$string_clientes_2021 = "";
$string_clientes_2022 = "";
$array_val = [];

foreach ($list_mes as $key => $val) {
    $array_val[] = $val;
}
foreach ($array_val[0] as $key => $val) {
    $string_meses .= '"' . $key . '",';
    $string_clientes_2021 .= $val . ',';
}

foreach ($array_val[1] as $key => $val) {
    $string_clientes_2022 .= $val . ',';
}

?>

<script>

  window.onload = () => {

    const reports1 = {
      series: [{
        name: '2021',
        data: [<?php echo $string_clientes_2021; ?>]
      }, {
        name: '2022',
        data: [<?php echo $string_clientes_2022; ?>]
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
      colors: ['#0000FF', '#00FF00'],
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
      colors: ['#0000FF', '#00FF00'],
      fill: {
        opacity: 1,
        colors: ['#0000FF', '#00FF00']
      }

    }

    const columnChart = new ApexCharts(document.querySelector("#columnChart"), reports2).render();

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
            <h5 class="card-title">Clientes Ativos <span>(1990 - 2020)</span></h5>

            <div class="d-flex align-items-center">
              <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                <i class="bi bi-person-check"></i>
              </div>
              <div class="ps-3">
                <h6><?php echo $total_clientes_ativos; ?></h6>
              </div>
            </div>
          </div>

        </div>
      </div><!-- End Revenue Card -->


      <!-- Revenue Card -->
      <div class="col-lg-6">
        <div class="card info-card revenue-card">

          <div class="card-body">
            <h5 class="card-title">Clientes Novos do Mês <span>(<?php echo $array_nome_meses[$i]; ?>/2023)</span></h5>

            <div class="d-flex align-items-center">
              <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                <i class="bi bi-person-check"></i>
              </div>
              <div class="ps-3">
                <h6><?php echo $clientes_ativos_mes_atual; ?></h6>
              </div>
            </div>
          </div>

        </div>
      </div><!-- End Revenue Card -->
      

      <!-- Reports -->
      <div class="col-12">
        <div class="card">

          <div class="card-body">
            <h5 class="card-title">Clientes Ativos <span>(2021 - <?php echo date('Y'); ?>)</span></h5>

            <!-- Line Chart -->
            <div id="reportsChart"></div>

          </div>

        </div>
      </div>

      <div class="col-12">
        <div class="card">

          <div class="card-body">
            <h5 class="card-title">Clientes Ativos <span>(2021 - <?php echo date('Y'); ?>)</span></h5>

            <!-- Column Chart -->
            <div id="columnChart"></div>

          </div>

        </div>
      </div><!-- End Reports -->

    </div>
  </section>

</main><!-- End #main -->

<?php get_footer(); ?>

<?php get_footer(); ?>