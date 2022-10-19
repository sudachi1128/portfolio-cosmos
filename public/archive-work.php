<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
  <?php get_header(); ?>
</head>

<body>
  <?php get_template_part('template-parts/loading'); ?>
  <?php get_template_part('template-parts/header-nav'); ?>
  <main>
    <section class="archive-work">
      <h1 class="archive-work__title">Programs</h1>
      <ul class="archive-work__list">
        <?php if (have_posts()) : ?>
          <?php while (have_posts()) : the_post(); ?>
            <li class="archive-work__item">
              <a class="archive-work__link" href="<?php the_permalink(); ?>">
                <h2 class="archive-work__item-title"><?php the_title(); ?></h2>
                <div class="archive-work__flame">
                  <div class="archive-work__flame-inner">
                    <img class="archive-work__item-img" src="<?php the_post_thumbnail_url(); ?>" alt="上映作品画像">
                  </div>
                </div>
                <p class="archive-work__item-text"><?php echo esc_html(get_the_excerpt()); ?></p>
              </a>
            </li>
          <?php endwhile; ?>
        <?php else : ?>
          <p>記事は見つかりませんでした</p>
        <?php endif; ?>
      </ul>
      <div class="archive-work__btn">
        <?php
        $prev = get_previous_posts_link('Prev');
        if ($prev) {
          $prev = str_replace('<a', '<a class = "archive-work__btn-left"', $prev);
          echo $prev;
        }
        ?>
        <?php
        $next = get_next_posts_link('Next');
        if ($next) {
          $next = str_replace('<a', '<a class = "archive-work__btn-right"', $next);
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