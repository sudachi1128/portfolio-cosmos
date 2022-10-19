<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
  <?php get_header(); ?>
</head>

<body>
  <?php get_template_part('template-parts/loading'); ?>
  <?php get_template_part('template-parts/header-nav'); ?>
  <main>
    <section class="page-contact">
      <h1 class="page-contact__title">Contact</h1>
      <?php the_content(); ?>
    </section>
  </main>
  <?php get_template_part('template-parts/footer-nav'); ?>
  <?php get_footer(); ?>
</body>

</html>