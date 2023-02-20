<?php
if ($_SERVER['REMOTE_ADDR'] != "143.106.16.153" && $_SERVER['REMOTE_ADDR'] != "177.55.129.61") {
  registerdb($_SERVER['REMOTE_ADDR']);
}
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title><?php bloginfo() ?></title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="<?php echo SITEPATH; ?>assets/img/favicon.png" rel="icon">
    <link href="<?php echo SITEPATH; ?>assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="<?php echo SITEPATH; ?>assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo SITEPATH; ?>assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="<?php echo SITEPATH; ?>assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="<?php echo SITEPATH; ?>assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="<?php echo SITEPATH; ?>assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="<?php echo SITEPATH; ?>assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="<?php echo SITEPATH; ?>assets/vendor/simple-datatables/style.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" rel="stylesheet">


    <!-- Template Main CSS File -->
    <link href="<?php echo SITEPATH; ?>assets/css/style.css" rel="stylesheet">

    <script>
        function loadPage() {
            window.scrollTo({
                top: 0,
                left: 0,
                behavior: 'instant',
            });
            document.querySelector('#loader').style.display = 'block';
        }
    </script>

    <?php wp_head(); ?>
</head>

<body>

    <div id="loader" class="wait-submit">
        <div class="spinner-border text-primary" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>

    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center">

        <div class="d-flex align-items-center justify-content-between">
            <a href="/" class="logo d-flex align-items-center">
                <img src="<?php echo SITEPATH ?>assets/img/logo.png" alt="">
                <!--<span class="d-none d-lg-block">DAE</span>-->
            </a>
            <i class="bi bi-list toggle-sidebar-btn"></i>
        </div><!-- End Logo -->

        <?php
        if (is_user_logged_in()) {
            $current_user = wp_get_current_user();
            $userimg = "https://www.gravatar.com/avatar/" . md5($current_user->user_email);
            $userlogin = $current_user->user_login;
            $username = $current_user->user_firstname . " " . $current_user->last_name;
        ?>
            <nav class="header-nav ms-auto">
                <ul class="d-flex align-items-center">

                    <li class="nav-item dropdown pe-3">

                        <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                            <img src="<?php echo $userimg; ?>" alt="Profile" class="rounded-circle">
                            <span class="d-none d-md-block dropdown-toggle ps-2">&nbsp;<?php echo $userlogin; ?>&emsp;</span>
                        </a><!-- End Profile Iamge Icon -->

                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                            <li class="dropdown-header">
                                <h6><?php echo $username; ?></h6>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>

                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="/wp-admin">
                                    <i class="bi bi-gear"></i>
                                    <span>Account</span>
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>

                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="/wp-login.php?action=logout">
                                    <i class="bi bi-box-arrow-right"></i>
                                    <span>Sign Out</span>
                                </a>
                            </li>

                        </ul>
                    </li>

                </ul>
            </nav>


        <?php
        } else {
        ?>
            <nav class="header-nav ms-auto">
                <ul class="d-flex align-items-center">
                    <li class="nav-item dropdown pe-3">
                        <a class="nav-link nav-profile d-flex align-items-center pe-0" href="/wp-admin/">
                            <img src="<?php echo SITEPATH; ?>assets/img/user.jpg" alt="Profile" class="rounded-circle">
                            <span class="d-none d-md-block dropdown-toggle ps-2">&nbsp;Login&emsp;</span>
                        </a>
                    </li>
                </ul>
            </nav>
        <?php
        }
        ?>

    </header><!-- End Header -->

    <!-- ======= Sidebar ======= -->
    <aside id="sidebar" class="sidebar">

        <ul class="sidebar-nav" id="sidebar-nav">

            <li class="nav-item">
                <a onclick="loadPage()" class="nav-link " href="/">
                    <i class="bi bi-house"></i>
                    <span>Home</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#charts-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-grid"></i><span>CEBI - DAE AME</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="charts-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <?php for ($i = date('Y'); $i > 2013; $i--) { ?>
                        <li>
                            <a onclick="loadPage()" class="ano<?php echo $i; ?>" href="/ano<?php echo $i; ?>">
                                <i class="bi bi-circle"></i><span><?php echo $i; ?></span>
                            </a>
                        </li>
                    <?php } ?>

                    <li class="nav-item">
                        <a onclick="loadPage()" class="nav-link " href="/todos">
                            <i class="bi bi-circle"></i><span>Todos</span>
                        </a>
                    </li>

                </ul>
            </li><!-- End Charts Nav -->

            <li class="nav-item">
                <a onclick="loadPage()" class="nav-link " href="/snis">
                    <i class="bi bi-bar-chart"></i>
                    <span>ACERTAR BRASIL - SNIS</span>
                </a>
            </li><!-- End SNIS Nav -->

        </ul>
        <div class="aside-img">
            <img class="logo3" src="<?php echo SITEPATH ?>assets/img/acertar.png">
            <img class="logo4" src="<?php echo SITEPATH ?>assets/img/snis.png">
        </div>

    </aside><!-- End Sidebar-->