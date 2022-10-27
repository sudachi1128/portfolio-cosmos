<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
  <?php get_header(); ?>
</head>

<body>
  <?php get_template_part('template-parts/loading'); ?>
  <?php get_template_part('template-parts/header-nav'); ?>
  <main>
    <section class="single-news">
      <?php if (have_posts()) : ?>
        <?php while (have_posts()) : the_post(); ?>
          <h1 class="single-news__title"><?php the_title(); ?></h1>
          <time class="single-news__date" datetime="<?php the_time('Y-m-d'); ?>"><?php the_time(get_option('date_format')); ?></time>
          <div class="single-news__img"><?php the_post_thumbnail("", ["alt" => "ニュース画像"]); ?></div>
          <div class="single-news__text"><?php the_content(); ?></div>
        <?php endwhile; ?>
      <?php endif; ?>
    </section>
  </main>
  <?php get_template_part('template-parts/footer-nav'); ?>
  <?php get_footer(); ?>
</body>

</html>