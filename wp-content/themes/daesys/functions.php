<?php
define('SITEPATH', '/wp-content/themes/daesys/');

//Create New Page
$newpage = "ano" . date('Y');
if (!get_page_by_title($newpage)) {
    //create new page
    $add_new_page = array(
        'post_title'    => $newpage,
        'post_content'  => '',
        'post_status'   => 'publish',
        'post_author'   => 1,
        'post_type'     => 'page'
    );
    wp_insert_post($add_new_page);
}

add_filter('login_redirect', function () {
    return '/';
});

add_filter('login_headerurl', function () {
    return '/';
});

add_action('login_enqueue_scripts', function () {
?>
    <style type="text/css">
        body {
            background: #fff !important;
            background-image: url('<?php echo SITEPATH ?>assets/img/login-background.jpg') !important;
            background-repeat: no-repeat !important;
            background-position: center top !important;
            position: relative !important;
        }

        #login {
            margin: 0 !important;
            padding: 0 !important;
            display: block !important;
            position: relative !important;
            left: 20% !important;
            top: 15% !important;
            width: 30% !important;
            padding-top: 80px !important;
        }

        .login form {
            margin: 0 !important;
            padding: 5px !important;
            background: transparent !important;
            border: none !important;
            box-shadow: none !important;
        }

        .login form input {
            border: none !important;
            min-height: 30px !important;
        }

        .login form button {
            min-height: 30px !important;
        }

        #login h1 a,
        .galogin-or,
        .galogin-powered,
        #language-switcher,
        .forgetmenot,
        .login #nav,
        .login #backtoblog {
            display: none !important;
        }

        #user_pass {
            margin-bottom: 40px;
        }

        .login .button-primary {
            float: none !important;
            width: 100px !important;
            height: 35px !important;
            border-radius: 15px !important;
        }

        p.galogin {
            transform: scale(0.8);
            position: absolute;
            right: -20px;
            bottom: -5px;
        }

        p.galogin a {
            width: 250px !important;
            box-shadow: none !important;
            border: none !important;
            border-radius: 20px !important;
        }

        p.galogin a span.icon {
            margin-left: 20px !important;
        }


        #login-img {
            display: block;
            position: absolute;
            width: 30%;
            left: 50%;
            top: 15%;
            padding: 20px;
            min-height: 450px;
        }

        #login-img img {
            display: block;
            position: relative;
            margin: 0 auto;
            width: 100%;
        }

        #login-img .logo2 {
            width: 250px;
            margin-top: 50px;
            margin-bottom: 30px;
        }

        #login-img .logo3 {
            width: 200px;
            float: left;
            margin-left: 50px;
        }

        #login-img .logo4 {
            width: 80px;
            float: right;
            margin-right: 50px;
        }

        @media(max-width:900px) {
            #login {
                top: 100px !important;
            }

            #login,
            .login form,
            #login-img {
                padding: 20px !important;
                left: 0 !important;
                position: relative !important;
                width: 100% !important;
            }

            p.galogin {
                transform: scale(0.8);
                position: absolute;
                right: -15px;
                bottom: 15px;
            }
        }
    </style>

    <div id="login-img">
        <img class="logo1" src="<?php echo SITEPATH ?>assets/img/saneconn.png">
        <img class="logo2" src="<?php echo SITEPATH ?>assets/img/logo.png">
        <img class="logo3" src="<?php echo SITEPATH ?>assets/img/acertar.png">
        <img class="logo4" src="<?php echo SITEPATH ?>assets/img/snis.png">
    </div>

<?php
});

/*
//SOMA VALORES POR MES
function month_data($ano, $tipo)
{
    $sql = "SELECT EXTRACT(month from DATA), SUM(VALOR) FROM MOVIMENTO_EMPENHOS_RECEITAS WHERE (TIPO LIKE '$tipo') AND EXERCICIO LIKE '$ano' AND DATA BETWEEN TO_DATE('01-JAN-$ano','DD-MON-YYYY') AND TO_DATE('31-DEC-$ano','DD-MON-YYYY') GROUP BY EXTRACT(month from DATA) ORDER BY 1;";
    $query =  DAE::oracle($sql);

    preg_match_all('/\d+/', $query, $match);

    $array_results = [];

    foreach ($match[0] as $val) {
        if ($val > 1000) {
            $array_results[] = number_format($val, 2, '.', '');
        }
    }

    return $array_results;
}
add_action('month_data', 'month_data');

//SOMA VALORES POR ITEM
function item_data($ano, $tipo, $max)
{
    $sql = "SELECT NOME_DETALHE, SUM(VALOR) FROM MOVIMENTO_EMPENHOS_RECEITAS WHERE (TIPO LIKE '$tipo') AND EXERCICIO LIKE '$ano' AND DATA BETWEEN TO_DATE('01-JAN-$ano','DD-MON-YYYY') AND TO_DATE('31-DEC-$ano','DD-MON-YYYY') GROUP BY NOME_DETALHE ORDER BY 2 DESC;";
    $query =  DAE::oracle($sql);

    $string_data = "";
    $string_itens = "";

    preg_match_all('/<td>(.*?)<\/td>/s', $query, $match1);

    $content1 = preg_replace("/\r|\n/", "", str_replace(',', '', str_replace('</td>', '', str_replace('<td>', '', $match1[0]))));

    $x = 1;
    foreach ($content1 as $val) {
        if ($x <= $max) {
            $string_itens .= '"' . $val . '",';
        }
        $x++;
    }

    $y = 1;
    preg_match_all('/\d{3,}+/', $query, $match2);
    foreach ($match2[0] as $val) {
        if ($y <= $max) {
            $string_data .= $val . ',';
        }
        $y++;
    }

    $item_data = array(
        'iten' => $string_itens,
        'data' => $string_data
    );

    return $item_data;
}
add_action('item_data', 'item_data');
*/