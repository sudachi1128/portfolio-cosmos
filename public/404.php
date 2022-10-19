<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
  <?php get_header(); ?>
</head>

<body>
  <?php get_template_part('template-parts/loading'); ?>
  <?php get_template_part('template-parts/header-nav'); ?>
  <main>
    <section class="error">
      <div class="error__wrapper">
        <h1 class="error__title-en">404</h1>
        <p class="error__text-en">Error File Not Found</p>
        <h2 class="error__title-ja">お探しのページが見つかりません。</h2>
        <p class="error__text-ja">申し訳ございません。お探しのページが見つかりません。<br>指定されたページは削除されたか、名前が変更されたか、一時的にご利用できない可能性がございます。</p>
        <a class="error__btn" href="<?php echo esc_url(home_url('/')); ?>">Top</a>
      </div>
    </section>
  </main>
  <?php get_template_part('template-parts/footer-nav'); ?>
  <?php get_footer(); ?>

</body>

</html>