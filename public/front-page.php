<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
  <?php get_header(); ?>
</head>

<body>
  <?php get_template_part('template-parts/loading'); ?>
  <?php get_template_part('template-parts/header-nav'); ?>
  <section class="top">
    <div class="top__background">
      <h1 class="top__title js-appearing-text-animation">まだ見ぬ世界へ<br>宇宙に咲く星たちの物語<br><span>planetarium cosmos</span></h1>
      <div class="top__scroll"><span>Scroll</span></div>
    </div>
  </section>
  <main>
    <section class="concept">
      <h1 class="concept__title js-title-animation">Concept</h1>
      <div class="concept__item">
        <div class="concept__img-wrapper">
          <div class="concept__img-flame" data-index="projector">
            <img class="concept__img" src="<?php echo esc_url(get_theme_file_uri('images/projector.jpg')); ?>" alt="コンセプト画像">
          </div>
        </div>
        <p class="concept__text">最新鋭の光学式投影機「◯◯◯◯◯」で投影を行います。再現力に長けており、街中で見る星空や、山奥で見るような満天の星空など、見る場所によって異なる星空の情景もリアルに再現します。</p>
        <div class="concept__senses" data-index="sight">視覚</div>
        <h3 class="concept__subtitle js-float-animation">Observe the<br>universe</h3>
      </div>
      <div class="concept__item">
        <div class="concept__senses concept__senses--reverse" data-index="hearing">聴覚</div>
        <h3 class="concept__subtitle concept__subtitle--reverse js-float-animation">Enjoy the<br>music</h3>
        <div class="concept__img-wrapper concept__img-wrapper--reverse">
          <div class="concept__img-flame" data-index="music">
            <img class="concept__img" src="<?php echo esc_url(get_theme_file_uri('images/orchestra.jpg')); ?>" alt="コンセプト画像">
          </div>
        </div>
        <p class="concept__text concept__text--reverse">美しい星空と共に◯◯交響楽団によるクラシック音楽を3次元音響で楽しむことができます。宇宙のように壮大で臨場感あふれる音楽は感情を揺さぶり、忘れられない想い出になるでしょう。</p>
      </div>
      <div class="concept__item">
        <div class="concept__senses" data-index="olfaction">嗅覚</div>
        <h3 class="concept__subtitle js-float-animation">Relax with<br>a scent</h3>
        <div class="concept__img-wrapper">
          <div class="concept__img-flame" data-index="diffuser">
            <img class="concept__img" src="<?php echo esc_url(get_theme_file_uri('images/aroma.jpg')); ?>" alt="コンセプト画像">
          </div>
        </div>
        <p class="concept__text">美しい夜空と共にアロマテラピーを体験することができます。上映プログラムをイメージしたオリジナルの天然アロマは日頃のストレスを忘れさせ、心も身体も癒されることでしょう。</p>
      </div>
    </section>
    <section class="work">
      <div class="work__background">
        <h1 class="work__title js-title-animation">Programs</h1>
        <div class="work__wrapper">
          <div class="work__slider">
            <ul class="work__list">
              <?php
              $args = [
                'post_type' => 'work',
                'posts_per_page' => 5,
                'paged' => $paged
              ];
              // サブクエリを生成・取得
              $the_query = new WP_Query($args);
              ?>
              <?php if ($the_query->have_posts()) : ?>
                <?php while ($the_query->have_posts()) : $the_query->the_post(); ?>
                  <li class="work__item">
                    <a class="work__link" href="<?php the_permalink(); ?>">
                      <div class="work__box">
                        <?php the_post_thumbnail("", ["class" => "work__img", "alt" => "上映作品画像"]); ?>
                        <h2 class="work__item-title"><?php the_title(); ?></h2>
                      </div>
                    </a>
                  </li>
                <?php endwhile; ?>
                <?php wp_reset_postdata(); ?>
              <?php endif; ?>
            </ul>
          </div>
          <div class="work__controller">
            <div class="work__btn work__btn-prev">
              <div class="work__arrow work__arrow--prev"></div>
            </div>
            <div class="work__indicator">
              <span class="work__active"></span>
              <span></span>
              <span></span>
              <span></span>
              <span></span>
            </div>
            <div class="work__btn work__btn-next">
              <div class="work__arrow work__arrow--next"></div>
            </div>
          </div>
        </div>
        <a class="work__archive-btn" href="<?php echo esc_url(get_post_type_archive_link('work')); ?>">View More</a>
      </div>
    </section>
    <section class="news">
      <h1 class="news__title js-title-animation">News</h1>
      <ul class="news__list">
        <?php if (have_posts()) : ?>
          <?php while (have_posts()) : the_post(); ?>
            <li class="news__item">
              <a class="news__link" href="<?php the_permalink(); ?>">
                <div class="news__date-box">
                  <time class="news__date-small"><?php the_time(get_option('date_format')); ?></time>
                  <time class="news__date-big"><?php the_time('md'); ?></time>
                </div>
                <div class="news__flame">
                  <div class="news__flame-inner">
                    <img class="news__item-img" src="<?php the_post_thumbnail_url(); ?>" alt="ニュース画像">
                  </div>
                </div>
                <h2 class="news__item-title"><?php the_title(); ?></h2>
                <p class="news__item-text"><?php echo esc_html(get_the_excerpt()); ?></p>
              </a>
            </li>
          <?php endwhile; ?>
        <?php else : ?>
          <p>記事は見つかりませんでした</p>
        <?php endif; ?>
      </ul>
      <a class="news__btn" href="<?php echo esc_url(home_url('news')); ?>">View More</a>
    </section>
    <section class="contact">
      <div class="contact__background">
        <h1 class="contact__title js-title-animation">Contact</h1>
        <p class="contact__text">何かご不明点ございましたらお問い合わせください。また大人数(20名以上)での来場につきましては、事前にご連絡いただけますとスムーズにご案内することができます。</p>
        <a href="<?php echo esc_url(home_url('contact')); ?>" class="contact__btn">Contact</a>
      </div>
    </section>
    <section class="access">
      <h1 class="access__title js-title-animation">Access</h1>
      <div class="access__wrapper">
        <div class="access__circle">
          <img src="<?php echo esc_url(get_theme_file_uri('images/planetarium.jpg')); ?>" alt="アクセス画像">
        </div>
        <div class="access__box">
          <dl class="access__list">
            <div class="access__item">
              <dt class="access__term">郵便番号</dt>
              <dd class="access__desc">XXX-XXXX</dd>
            </div>
            <div class="access__item">
              <dt class="access__term">住所</dt>
              <dd class="access__desc">群馬県高崎市XXX-XX</dd>
            </div>
            <div class="access__item">
              <dt class="access__term">電話番号</dt>
              <dd class="access__desc">XXX-XXXX-XXXX</dd>
            </div>
            <div class="access__item">
              <dt class="access__term">アクセス</dt>
              <dd class="access__desc">JR高崎駅から徒歩7分</dd>
            </div>
            <div class="access__item">
              <dt class="access__term">営業時間</dt>
              <dd class="access__desc">土日祝…9:00～22:00<br>平日…10:00～22:00</dd>
            </div>
          </dl>
          <a class="access__btn" href="https://goo.gl/maps/hNw2fnXzPwdXaeFr8">Google Map</a>
        </div>
      </div>
      <button class="access__arrow-btn" id="access__arrow-btn">
        <img src="<?php echo esc_url(get_theme_file_uri('images/footer-arrow.svg')); ?>" alt="トップスクロール画像">
      </button>
    </section>
  </main>
  <?php get_template_part('template-parts/footer-nav'); ?>
  <?php get_footer(); ?>
</body>

</html>