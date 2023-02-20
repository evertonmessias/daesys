<?php
define('SITEPATH', '/wp-content/themes/daesys/');

//Create New Page
$newpage = "ano".date('Y');
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
