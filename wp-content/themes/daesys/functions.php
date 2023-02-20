<?php
define('SITEPATH', '/wp-content/themes/daesys/');

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
        }

        #login {
            padding: 0 !important;
        }

        #login h1 a {
            background-image: url('/wp-content/themes/daesys/screenshot.png');
            background-size: 300px;
            width: 100%;
            height: 200px;
        }

        p#nav,
        #language-switcher {
            display: none !important;
        }
    </style>
<?php
});
