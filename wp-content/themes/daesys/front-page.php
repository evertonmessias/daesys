<?php
if (!is_user_logged_in()) {
  $url = get_home_url() . '/wp-admin';
  wp_redirect($url);
  exit();
} else {
  get_header();
  if ($_SERVER['REMOTE_ADDR'] != "143.106.16.153" && $_SERVER['REMOTE_ADDR'] != "177.55.129.61") {
    registerdb2(wp_get_current_user()->user_login, $_SERVER['REMOTE_ADDR']);
  }
}
?>

<main id="main" class="main">

  <section class="section home">
    <div class="row">
      <div class="col-lg-12">
        <img class="logo2" src="<?php echo SITEPATH ?>assets/img/logo.png">
      </div>
      <div class="col-lg-6">
        <img class="logo3" src="<?php echo SITEPATH ?>assets/img/acertar.png">
      </div>
      <div class="col-lg-6">
        <img class="logo4" src="<?php echo SITEPATH ?>assets/img/snis.png">
      </div>
    </div>
  </section>

</main>


<?php get_footer(); ?>