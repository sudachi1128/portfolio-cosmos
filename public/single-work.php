<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
  <?php get_header(); ?>
</head>

<body>
  <?php get_template_part('template-parts/loading'); ?>
  <?php get_template_part('template-parts/header-nav'); ?>
  <main>
    <section class="single-work">
      <h1 class="single-work__title"><?php the_title(); ?></h1>
      <?php if (have_posts()) : ?>
        <?php while (have_posts()) : the_post(); ?>
          <div class="single-work__wrapper">
            <div class="single-work__img">
              <?php the_post_thumbnail("", ["alt" => "上映作品画像"]); ?>
            </div>
            <div class="single-work__container">
              <h2 class="single-work__detail">作品詳細</h2>
              <dl>
                <div class="single-work__box">
                  <dt class="single-work__item">監督&nbsp;:&nbsp;</dt>
                  <dd><?php the_field('director') ?></dd>
                </div>
                <div class="single-work__box">
                  <dt class="single-work__item">脚本&nbsp;:&nbsp;</dt>
                  <dd><?php the_field('script') ?></dd>
                </div>
                <div class="single-work__box">
                  <dt class="single-work__item">出演&nbsp;:&nbsp;</dt>
                  <dd><?php the_field('cast') ?></dd>
                </div>
                <div class="single-work__box">
                  <dt class="single-work__item" time>上映時間&nbsp;:&nbsp;</dt>
                  <dd><?php the_field('time') ?>分</dd>
                </div>
              </dl>
              <h2 class="single-work__recommend">こんな人におすすめ</h2>
              <?php the_field('recommend'); ?>
            </div>
          </div>
          <div class="single-work__content">
            <h2 class="single-work__content-title">作品概要</h2>
            <div class="single-work__content-box">
              <?php $img = get_field('summary_img')['url']; ?>
              <?php if ($img) : ?>
                <div class="single-work__summary-img"><img src="<?php echo esc_url($img) ?>" alt="作品概要の画像"></div>
              <?php endif; ?>
              <div class="single-work__summary-box">
                <h3 class="single-work__summary-title"><?php the_field('summary_title') ?></h3>
                <p class="single-work__summary-text"><?php the_field('summary_text') ?></p>
              </div>
            </div>
          </div>
        <?php endwhile; ?>
      <?php endif; ?>
    </section>
  </main>

  <?php get_template_part('template-parts/footer-nav'); ?>
  <?php get_footer(); ?>
</body>

</html>