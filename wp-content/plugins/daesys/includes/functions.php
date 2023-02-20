<?php

// ***************** Add style & script for Admin
function style_and_script()
{
?>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.8.1/js/bootstrap-select.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
	<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
	<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.8.1/css/bootstrap-select.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
	<link rel='stylesheet' href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css'>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css">

	<link href="<?php echo SITEPATH; ?>assets/vendor/remixicon/remixicon.css" rel="stylesheet">

<?php
	wp_enqueue_style('stilos', '/wp-content/plugins/daesys/assets/daesys.css');
	wp_enqueue_script('scripts', '/wp-content/plugins/daesys/assets/daesys.js');
}
add_action('admin_enqueue_scripts', 'style_and_script');


//***************** Add General Configuration Roles
function general_configuration_role_caps()
{
	$roles = array('editor');
	foreach ($roles as $the_role) {
		$role = get_role($the_role);
		$role->remove_cap('list_users');
		$role->remove_cap('create_users');
		$role->remove_cap('remove_users');
		$role->remove_cap('promote_users');
		$role->remove_cap('edit_users');
		$role->add_cap('manage_options');
	}
}
add_action('admin_init', 'general_configuration_role_caps', 999);


//***************** Add Remove menu page Admin
function wpdocs_remove_menus()
{
	if (current_user_can('editor')) {
		remove_menu_page('index.php'); //Dashboard		
		remove_menu_page('themes.php'); //Appearance
		remove_menu_page('edit-comments.php');
		remove_menu_page('plugins.php'); //Plugins
		remove_menu_page('users.php'); //Users
		remove_menu_page('tools.php'); //Tools
		remove_menu_page('profile.php'); //Profile
		remove_menu_page('options-general.php'); //Settings
		remove_menu_page('edit.php?post_type=page'); // Pages
	}
}
add_action('admin_menu', 'wpdocs_remove_menus');


//Rename menu iten Admin
function wd_admin_menu_rename()
{
	global $menu;
	//$menu[5][0] = 'Posts?';
}
add_action('admin_menu', 'wd_admin_menu_rename');


// ***************** Add in Menu
function menu_daesys()
{
	add_menu_page('DAESys', 'DAESys', 'edit_posts', 'daesys', 'function_about', 'dashicons-welcome-view-site', 1);
	add_submenu_page('daesys', 'Acessos','Acessos', 'edit_posts', 'acess', 'function_access', 1);
	//add_submenu_page('daesys', 'Login','Login', 'edit_posts', 'login', 'function_login', 2);
}
add_action('admin_menu', 'menu_daesys');

// ***************** Add About
function function_about()
{
	include ABSPATH . '/wp-content/plugins/daesys/includes/about.php';
}
add_action('function_about', 'function_about');

// ***************** Add Access
function function_access()
{
	include ABSPATH . '/wp-content/plugins/daesys/includes/access.php';
}
add_action('function_access', 'function_access');

/***************** Add Login
function function_login()
{
	include ABSPATH . '/wp-content/plugins/daesys/includes/login.php';
}
add_action('function_login', 'function_login');*/

// ***************** Add Media
function load_media_files()
{
	wp_enqueue_media();
}
add_action('admin_enqueue_scripts', 'load_media_files');

//************* Add thumbnails
//add_theme_support('post-thumbnails', array('post'));


//************* Data Base
function registerdb($ip) // register in db
{
	global $wpdb;
	$table_name = $wpdb->prefix . 'access';
	$resp = $wpdb->insert($table_name, array('ipadress' => $ip, 'time' => current_time('mysql')));
	if ($resp == 1) {
		return "register db: SUCESS";
	} else {
		return "register db: ERROR";
	}
}
add_action('registerdb', 'registerdb');

function registerdb2($user,$ip) // register in db
{	
	global $wpdb;
	$table_name = $wpdb->prefix . 'login';
	$resp = $wpdb->insert($table_name, array('user' => $user,'ipadress' => $ip, 'time' => current_time('mysql')));
	if ($resp == 1) {
		return "register db: SUCESS";
	} else {
		return "register db: ERROR";
	}
}
add_action('registerdb2', 'registerdb2');

function list_access($table) // list access
{
	global $wpdb;
	$table_name = $wpdb->prefix . $table;
	$results = $wpdb->get_results(
		"SELECT * FROM $table_name ORDER BY id DESC"
	);
	return $results;
}
add_action('list_access', 'list_access');


function list_snis($sql) // list snis
{
	global $wpdb;
	$results = $wpdb->get_results($sql);
	return $results;
}
add_action('list_snis', 'list_snis');


//************* Hide admin bar for users
/*function remove_admin_bar()
{
	if (current_user_can('subscriber')) {
		show_admin_bar(false);
	}
}
add_action('after_setup_theme', 'remove_admin_bar');
*/


//************* Remove tags support from posts
function myprefix_unregister_tags()
{
	unregister_taxonomy_for_object_type('post_tag', 'post');
}
add_action('init', 'myprefix_unregister_tags');


//************* Add Menu
function register_my_menu()
{
	register_nav_menu('daesys-nav', __('daesys NAV'));
}
add_action('init', 'register_my_menu');
