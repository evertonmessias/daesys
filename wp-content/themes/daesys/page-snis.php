<?php get_header(); ?>
<?php
$string_campos = "IN023,IN024,IN016,IN084,IN082,IN049,IN009,IN102,IN026,IN008,IN011,IN060,IN030,IN020,IN001,IN053";
$array_titulos = ["IN023 - Índice de atendimento urbano de água", "IN024 - Índice de atendimento urbano de esgoto referido aos municípios atendidos com água", "IN016 - Índice de tratamento de esgoto", "IN084 - Incidência das análises de coliformes totais fora do padrão", "IN082 - Extravasamentos de esgotos por extensão de rede", "IN049 - Índice de perdas na distribuição", "IN009 - Índice de hidrometração", "IN102 - Índice de produtividade de pessoal total (equivalente)", "IN026 - Despesa de exploração por m3 faturado", "IN008 - Despesa média anual por empregado", "IN011 - Índice de macromedição", "IN060 - Índice de despesas por consumo de energia elétrica nos sistemas de água e esgotos", "IN030 - Margem da despesa de exploração", "IN020 - Extensão da rede de água por ligação", "IN001 - Densidade de economias de água por ligação", "IN053 - Consumo médio de água por economia"];
$array_campos = explode(',', $string_campos);
$cor1 = "'rgb(105,105,105)','rgb(128,128,128)','rgb(105,89,205)','rgb(72,61,139)','rgb(0,0,139)','rgb(0,0,205)','rgb(0,0,255)','rgb(30,144,255)','rgb(0,191,255)','rgb(135,206,250)','rgb(64,224,208)','rgb(72,209,204)','rgb(32,178,170)','rgb(0,255,127)','rgb(152,251,152)','rgb(144,238,144)','rgb(0,100,0)','rgb(0,128,0)','rgb(34,139,34)','rgb(186,85,211)','rgb(128,0,128)','rgb(139,0,139)','rgb(255,127,80)','rgb(255,99,71)','rgb(255,0,0)'";
$cor2 = "'rgb(255,0,0)','rgb(255,99,71)','rgb(255,127,80)','rgb(139,0,139)','rgb(128,0,128)','rgb(186,85,211)','rgb(34,139,34)','rgb(0,128,0)','rgb(0,100,0)','rgb(144,238,144)','rgb(152,251,152)','rgb(0,255,127)','rgb(32,178,170)','rgb(72,209,204)','rgb(64,224,208)','rgb(135,206,250)','rgb(0,191,255)','rgb(30,144,255)','rgb(0,0,255)','rgb(0,0,205)','rgb(0,0,139)','rgb(72,61,139)','rgb(105,89,205)','rgb(128,128,128)','rgb(105,105,105)'";
$snis = list_snis('select ANO,' . $string_campos . ' from wp_snis');
$ANO = "";
$IN023 = "";
$IN024 = "";
$IN016 = "";
$IN084 = "";
$IN082 = "";
$IN049 = "";
$IN009 = "";
$IN102 = "";
$IN026 = "";
$IN008 = "";
$IN011 = "";
$IN060 = "";
$IN030 = "";
$IN020 = "";
$IN001 = "";
$IN053 = "";

foreach ($snis as $val) {
  $ANO .= '"' . $val->ANO . '",';
  $IN023 .= $val->IN023 . ',';
  $IN024 .= $val->IN024 . ',';
  $IN016 .= $val->IN016 . ',';
  $IN084 .= $val->IN084 . ',';
  $IN082 .= $val->IN082 . ',';
  $IN049 .= $val->IN049 . ',';
  $IN009 .= $val->IN009 . ',';
  $IN102 .= $val->IN102 . ',';
  $IN026 .= $val->IN026 . ',';
  $IN008 .= $val->IN008 . ',';
  $IN011 .= $val->IN011 . ',';
  $IN060 .= $val->IN060 . ',';
  $IN030 .= $val->IN030 . ',';
  $IN020 .= $val->IN020 . ',';
  $IN001 .= $val->IN001 . ',';
  $IN053 .= $val->IN053 . ',';
}
?>

<script>
  window.onload = () => {

    // ************  Chart IN023
    const IN023 = {
      type: 'bar',
      data: {
        labels: [<?php echo $ANO; ?>],
        datasets: [{
          label: 'IN023',
          data: [<?php echo $IN023; ?>],
          backgroundColor: [<?php echo $cor1; ?>],
          borderWidth: 1
        }]
      },
      options: {
        scales: {
          y: {
            beginAtZero: false
          }
        }
      }
    };
    const ChartIN023 = new Chart(document.querySelector('#IN023'), IN023);
    document.querySelector('#IN023-line').addEventListener('click', () => {
      ChartIN023.config.type = 'line';
      ChartIN023.update();
    });
    document.querySelector('#IN023-bar').addEventListener('click', () => {
      ChartIN023.config.type = 'bar';
      ChartIN023.update();
    });
    // *****************************

    // ************  Chart IN024
    const IN024 = {
      type: 'bar',
      data: {
        labels: [<?php echo $ANO; ?>],
        datasets: [{
          label: 'IN024',
          data: [<?php echo $IN024; ?>],
          backgroundColor: [<?php echo $cor2; ?>],
          borderWidth: 1
        }]
      },
      options: {
        scales: {
          y: {
            beginAtZero: false
          }
        }
      }
    };
    const ChartIN024 = new Chart(document.querySelector('#IN024'), IN024);
    document.querySelector('#IN024-line').addEventListener('click', () => {
      ChartIN024.config.type = 'line';
      ChartIN024.update();
    });
    document.querySelector('#IN024-bar').addEventListener('click', () => {
      ChartIN024.config.type = 'bar';
      ChartIN024.update();
    });
    // *****************************

    // ************  Chart IN016
    const IN016 = {
      type: 'bar',
      data: {
        labels: [<?php echo $ANO; ?>],
        datasets: [{
          label: 'IN016',
          data: [<?php echo $IN016; ?>],
          backgroundColor: [<?php echo $cor1; ?>],
          borderWidth: 1
        }]
      },
      options: {
        scales: {
          y: {
            beginAtZero: false
          }
        }
      }
    };
    const ChartIN016 = new Chart(document.querySelector('#IN016'), IN016);
    document.querySelector('#IN016-line').addEventListener('click', () => {
      ChartIN016.config.type = 'line';
      ChartIN016.update();
    });
    document.querySelector('#IN016-bar').addEventListener('click', () => {
      ChartIN016.config.type = 'bar';
      ChartIN016.update();
    });
    // *****************************

    // ************  Chart IN084
    const IN084 = {
      type: 'bar',
      data: {
        labels: [<?php echo $ANO; ?>],
        datasets: [{
          label: 'IN084',
          data: [<?php echo $IN084; ?>],
          backgroundColor: [<?php echo $cor2; ?>],
          borderWidth: 1
        }]
      },
      options: {
        scales: {
          y: {
            beginAtZero: false
          }
        }
      }
    };
    const ChartIN084 = new Chart(document.querySelector('#IN084'), IN084);
    document.querySelector('#IN084-line').addEventListener('click', () => {
      ChartIN084.config.type = 'line';
      ChartIN084.update();
    });
    document.querySelector('#IN084-bar').addEventListener('click', () => {
      ChartIN084.config.type = 'bar';
      ChartIN084.update();
    });
    // *****************************

    // ************  Chart IN082
    const IN082 = {
      type: 'bar',
      data: {
        labels: [<?php echo $ANO; ?>],
        datasets: [{
          label: 'IN082',
          data: [<?php echo $IN082; ?>],
          backgroundColor: [<?php echo $cor1; ?>],
          borderWidth: 1
        }]
      },
      options: {
        scales: {
          y: {
            beginAtZero: false
          }
        }
      }
    };
    const ChartIN082 = new Chart(document.querySelector('#IN082'), IN082);
    document.querySelector('#IN082-line').addEventListener('click', () => {
      ChartIN082.config.type = 'line';
      ChartIN082.update();
    });
    document.querySelector('#IN082-bar').addEventListener('click', () => {
      ChartIN082.config.type = 'bar';
      ChartIN082.update();
    });
    // *****************************

    // ************  Chart IN049
    const IN049 = {
      type: 'bar',
      data: {
        labels: [<?php echo $ANO; ?>],
        datasets: [{
          label: 'IN049',
          data: [<?php echo $IN049; ?>],
          backgroundColor: [<?php echo $cor2; ?>],
          borderWidth: 1
        }]
      },
      options: {
        scales: {
          y: {
            beginAtZero: false
          }
        }
      }
    };
    const ChartIN049 = new Chart(document.querySelector('#IN049'), IN049);
    document.querySelector('#IN049-line').addEventListener('click', () => {
      ChartIN049.config.type = 'line';
      ChartIN049.update();
    });
    document.querySelector('#IN049-bar').addEventListener('click', () => {
      ChartIN049.config.type = 'bar';
      ChartIN049.update();
    });
    // *****************************

    // ************  Chart IN009
    const IN009 = {
      type: 'bar',
      data: {
        labels: [<?php echo $ANO; ?>],
        datasets: [{
          label: 'IN009',
          data: [<?php echo $IN009; ?>],
          backgroundColor: [<?php echo $cor1; ?>],
          borderWidth: 1
        }]
      },
      options: {
        scales: {
          y: {
            beginAtZero: false
          }
        }
      }
    };
    const ChartIN009 = new Chart(document.querySelector('#IN009'), IN009);
    document.querySelector('#IN009-line').addEventListener('click', () => {
      ChartIN009.config.type = 'line';
      ChartIN009.update();
    });
    document.querySelector('#IN009-bar').addEventListener('click', () => {
      ChartIN009.config.type = 'bar';
      ChartIN009.update();
    });
    // *****************************

    // ************  Chart IN102
    const IN102 = {
      type: 'bar',
      data: {
        labels: [<?php echo $ANO; ?>],
        datasets: [{
          label: 'IN102',
          data: [<?php echo $IN102; ?>],
          backgroundColor: [<?php echo $cor2; ?>],
          borderWidth: 1
        }]
      },
      options: {
        scales: {
          y: {
            beginAtZero: false
          }
        }
      }
    };
    const ChartIN102 = new Chart(document.querySelector('#IN102'), IN102);
    document.querySelector('#IN102-line').addEventListener('click', () => {
      ChartIN102.config.type = 'line';
      ChartIN102.update();
    });
    document.querySelector('#IN102-bar').addEventListener('click', () => {
      ChartIN102.config.type = 'bar';
      ChartIN102.update();
    });
    // *****************************

    // ************  Chart IN026
    const IN026 = {
      type: 'bar',
      data: {
        labels: [<?php echo $ANO; ?>],
        datasets: [{
          label: 'IN026',
          data: [<?php echo $IN026; ?>],
          backgroundColor: [<?php echo $cor1; ?>],
          borderWidth: 1
        }]
      },
      options: {
        scales: {
          y: {
            beginAtZero: false
          }
        }
      }
    };
    const ChartIN026 = new Chart(document.querySelector('#IN026'), IN026);
    document.querySelector('#IN026-line').addEventListener('click', () => {
      ChartIN026.config.type = 'line';
      ChartIN026.update();
    });
    document.querySelector('#IN026-bar').addEventListener('click', () => {
      ChartIN026.config.type = 'bar';
      ChartIN026.update();
    });
    // *****************************

    // ************  Chart IN008
    const IN008 = {
      type: 'bar',
      data: {
        labels: [<?php echo $ANO; ?>],
        datasets: [{
          label: 'IN008',
          data: [<?php echo $IN008; ?>],
          backgroundColor: [<?php echo $cor2; ?>],
          borderWidth: 1
        }]
      },
      options: {
        scales: {
          y: {
            beginAtZero: false
          }
        }
      }
    };
    const ChartIN008 = new Chart(document.querySelector('#IN008'), IN008);
    document.querySelector('#IN008-line').addEventListener('click', () => {
      ChartIN008.config.type = 'line';
      ChartIN008.update();
    });
    document.querySelector('#IN008-bar').addEventListener('click', () => {
      ChartIN008.config.type = 'bar';
      ChartIN008.update();
    });
    // *****************************

    // ************  Chart IN011
    const IN011 = {
      type: 'bar',
      data: {
        labels: [<?php echo $ANO; ?>],
        datasets: [{
          label: 'IN011',
          data: [<?php echo $IN011; ?>],
          backgroundColor: [<?php echo $cor1; ?>],
          borderWidth: 1
        }]
      },
      options: {
        scales: {
          y: {
            beginAtZero: false
          }
        }
      }
    };
    const ChartIN011 = new Chart(document.querySelector('#IN011'), IN011);
    document.querySelector('#IN011-line').addEventListener('click', () => {
      ChartIN011.config.type = 'line';
      ChartIN011.update();
    });
    document.querySelector('#IN011-bar').addEventListener('click', () => {
      ChartIN011.config.type = 'bar';
      ChartIN011.update();
    });
    // *****************************

    // ************  Chart IN060
    const IN060 = {
      type: 'bar',
      data: {
        labels: [<?php echo $ANO; ?>],
        datasets: [{
          label: 'IN060',
          data: [<?php echo $IN060; ?>],
          backgroundColor: [<?php echo $cor2; ?>],
          borderWidth: 1
        }]
      },
      options: {
        scales: {
          y: {
            beginAtZero: false
          }
        }
      }
    };
    const ChartIN060 = new Chart(document.querySelector('#IN060'), IN060);
    document.querySelector('#IN060-line').addEventListener('click', () => {
      ChartIN060.config.type = 'line';
      ChartIN060.update();
    });
    document.querySelector('#IN060-bar').addEventListener('click', () => {
      ChartIN060.config.type = 'bar';
      ChartIN060.update();
    });
    // *****************************

    // ************  Chart IN030
    const IN030 = {
      type: 'bar',
      data: {
        labels: [<?php echo $ANO; ?>],
        datasets: [{
          label: 'IN030',
          data: [<?php echo $IN030; ?>],
          backgroundColor: [<?php echo $cor1; ?>],
          borderWidth: 1
        }]
      },
      options: {
        scales: {
          y: {
            beginAtZero: false
          }
        }
      }
    };
    const ChartIN030 = new Chart(document.querySelector('#IN030'), IN030);
    document.querySelector('#IN030-line').addEventListener('click', () => {
      ChartIN030.config.type = 'line';
      ChartIN030.update();
    });
    document.querySelector('#IN030-bar').addEventListener('click', () => {
      ChartIN030.config.type = 'bar';
      ChartIN030.update();
    });
    // *****************************

    // ************  Chart IN020
    const IN020 = {
      type: 'bar',
      data: {
        labels: [<?php echo $ANO; ?>],
        datasets: [{
          label: 'IN020',
          data: [<?php echo $IN020; ?>],
          backgroundColor: [<?php echo $cor2; ?>],
          borderWidth: 1
        }]
      },
      options: {
        scales: {
          y: {
            beginAtZero: false
          }
        }
      }
    };
    const ChartIN020 = new Chart(document.querySelector('#IN020'), IN020);
    document.querySelector('#IN020-line').addEventListener('click', () => {
      ChartIN020.config.type = 'line';
      ChartIN020.update();
    });
    document.querySelector('#IN020-bar').addEventListener('click', () => {
      ChartIN020.config.type = 'bar';
      ChartIN020.update();
    });
    // *****************************

    // ************  Chart IN001
    const IN001 = {
      type: 'bar',
      data: {
        labels: [<?php echo $ANO; ?>],
        datasets: [{
          label: 'IN001',
          data: [<?php echo $IN001; ?>],
          backgroundColor: [<?php echo $cor1; ?>],
          borderWidth: 1
        }]
      },
      options: {
        scales: {
          y: {
            min: 1.2,
            max: 1.36
          }
        }
      }
    };
    const ChartIN001 = new Chart(document.querySelector('#IN001'), IN001);
    document.querySelector('#IN001-line').addEventListener('click', () => {
      ChartIN001.config.type = 'line';
      ChartIN001.update();
    });
    document.querySelector('#IN001-bar').addEventListener('click', () => {
      ChartIN001.config.type = 'bar';
      ChartIN001.update();
    });
    // *****************************

    // ************  Chart IN053
    const IN053 = {
      type: 'bar',
      data: {
        labels: [<?php echo $ANO; ?>],
        datasets: [{
          label: 'IN053',
          data: [<?php echo $IN053; ?>],
          backgroundColor: [<?php echo $cor2; ?>],
          borderWidth: 1
        }]
      },
      options: {
        scales: {
          y: {
            beginAtZero: false
          }
        }
      }
    };
    const ChartIN053 = new Chart(document.querySelector('#IN053'), IN053);
    document.querySelector('#IN053-line').addEventListener('click', () => {
      ChartIN053.config.type = 'line';
      ChartIN053.update();
    });
    document.querySelector('#IN053-bar').addEventListener('click', () => {
      ChartIN053.config.type = 'bar';
      ChartIN053.update();
    });
    // *****************************


  }
</script>

<main id="main" class="main">

  <div class="pagetitle">
    <h1>SNIS - Sistema Nacional de Informações sobre Saneamento, DAE Americana</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">home</a></li>
        <li class="breadcrumb-item active">snis</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section">
    <div class="row">

      <?php
      $x = 0;
      foreach ($array_campos as $campo) { ?>
        <div class="col-lg-12">
          <?php if ($x == 0) { ?>
            <br>
            <h3 class="title-card-snis">Universalização:</h3>
          <?php } elseif ($x == 3) { ?>
            <br>
            <h3 class="title-card-snis">Qualidade::</h3>
          <?php } elseif ($x == 5) { ?>
            <br>
            <h3 class="title-card-snis">Eficiência:</h3>
          <?php } elseif ($x == 13) { ?>
            <br>
            <h3 class="title-card-snis">Contexto:</h3>
          <?php } ?>
          <div class="card">
            <div class="card-body">
              <h5 class="card-title"><?php echo $array_titulos[$x]; ?></h5>
              <canvas id="<?php echo $campo; ?>" style="max-height: 300px;"></canvas><br>
              <button class="btn btn-success btn-chart" id='<?php echo $campo; ?>-line'>Line</button>
              <button class="btn btn-primary btn-chart" id='<?php echo $campo; ?>-bar'>Bar</button>
            </div>
          </div>
        </div>
      <?php $x++;
      } ?>

    </div>
  </section>

</main><!-- End #main -->

<?php get_footer(); ?>