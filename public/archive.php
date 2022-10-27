<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
  <?php get_header(); ?>
</head>

<body>
  <?php get_template_part('template-parts/loading'); ?>
  <?php get_template_part('template-parts/header-nav'); ?>
  <main>
    <section class="archive">
      <h1 class="archive__title">News</h1>
      <ul class="archive__list">
        <?php if (have_posts()) : ?>
          <?php while (have_posts()) : the_post(); ?>
            <li class="archive__item">
              <a class="archive__link" href="<?php the_permalink(); ?>">
                <div class="archive__date-box">
                  <time class="archive__date-small"><?php the_time(get_option('date_format')); ?></time>
                  <time class="archive__date-big"><?php the_time('md'); ?></time>
                </div>
                <div class="archive__flame">
                  <div class="archive__flame-inner">
                    <img class="archive__item-img" src="<?php the_post_thumbnail_url(); ?>" alt="ニュース画像">
                  </div>
                </div>
                <h2 class="archive__item-title"><?php the_title(); ?></h2>
                <p class="archive__item-text"><?php echo esc_html(get_the_excerpt()); ?></p>
              </a>
            </li>
          <?php endwhile; ?>
        <?php else : ?>
          <p>記事は見つかりませんでした</p>
        <?php endif; ?>
      </ul>
      <div class="archive__btn">
        <?php
        $prev = get_previous_posts_link('Prev');
        if ($prev) {
          $prev = str_replace('<a', '<a class = "archive__btn-left"', $prev);
          echo $prev;
        }
        ?>
        <?php
        $next = get_next_posts_link('Next');
        if ($next) {
          $next = str_replace('<a', '<a class = "archive__btn-right"', $next);
          echo $next;
        }
        ?>
      </div>
    </section>
  </main>

  <?php get_template_part('template-parts/footer-nav'); ?>

  <?php get_footer(); ?>

</body>

</html>