<?php get_header(); ?>
<?php
if ($_SERVER['REMOTE_ADDR'] != "143.106.16.153" && $_SERVER['REMOTE_ADDR'] != "177.55.129.61" && $_SERVER['REMOTE_ADDR'] != "187.106.41.166") {
  registerdb($_SERVER['REMOTE_ADDR']);
}
?>
<main id="main" class="main">

  <section class="section home">
    <div class="row">
      <div class="col-lg-12">
        <img src="<?php echo SITEPATH; ?>screenshot.png" alt="">
      </div>
    </div>
  </section>

</main>


<?php get_footer(); ?>