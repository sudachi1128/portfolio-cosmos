<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
  <?php get_header(); ?>
</head>

<body>
  <?php get_template_part('template-parts/loading'); ?>
  <?php get_template_part('template-parts/header-nav'); ?>
  <main>
    <section class="page-price">
      <h1 class="page-price__title">Price</h1>
      <div class="page-price__wrapper">
        <div class="page-price__container">
          <h2 class="page-price__section-title">通常料金</h2>
          <div class="page-price__list">
            <div class="page-price__item">
              <div class="page-price__table">
                <div class="page-price__term">
                  <div class="page-price__jp-term">一般</div>
                  <div class="page-price__en-term">General</div>
                </div>
                <?php
                $general = get_field('general');
                ?>
                <div class="page-price__fee">¥<?php echo esc_html(number_format($general)); ?></div>
              </div>
            </div>
            <div class="page-price__item">
              <div class="page-price__table">
                <div class="page-price__term">
                  <div class="page-price__jp-term">学生（大学・専門学校）</div>
                  <div class="page-price__en-term">Student（college）</div>
                  <div class="page-price__caution">※学生証をご提示いただく場合がございます。</div>
                </div>
                <?php
                $college = get_field('college');
                ?>
                <div class="page-price__fee">¥<?php echo esc_html(number_format($college)); ?></div>
              </div>
            </div>
            <div class="page-price__item">
              <div class="page-price__table">
                <div class="page-price__term">
                  <div class="page-price__jp-term">高校生</div>
                  <div class="page-price__en-term">Student（high）</div>
                  <div class="page-price__caution">※学生証をご提示いただく場合がございます。</div>
                </div>
                <?php
                $high = get_field('high');
                ?>
                <div class="page-price__fee">¥<?php echo esc_html(number_format($high)); ?></div>
              </div>
            </div>
            <div class="page-price__item">
              <div class="page-price__table">
                <div class="page-price__term">
                  <div class="page-price__jp-term">中学生</div>
                  <div class="page-price__en-term">Student（middle）</div>
                </div>
                <?php
                $middle = get_field('middle');
                ?>
                <div class="page-price__fee">¥<?php echo esc_html(number_format($middle)); ?></div>
              </div>
            </div>
            <div class="page-price__item">
              <div class="page-price__table">
                <div class="page-price__term">
                  <div class="page-price__jp-term">小学生以下</div>
                  <div class="page-price__en-term">Student（below elementary）</div>
                </div>
                <?php
                $elementary = get_field('elementary');
                ?>
                <div class="page-price__fee">¥<?php echo esc_html(number_format($elementary)); ?></div>
              </div>
            </div>
          </div>
        </div>
        <div class="page-price__container">
          <h2 class="page-price__section-title page-price__section-title--discount">割引料金</h2>
          <div class="page-price__list">
            <div class="page-price__item">
              <div class="page-price__table">
                <div class="page-price__term">
                  <div class="page-price__jp-term">レイトショー</div>
                  <div class="page-price__en-term">Late show</div>
                  <div class="page-price__caution">※午後8時以降は割引となります。</div>
                </div>
                <?php
                $late = get_field('late');
                ?>
                <div class="page-price__fee">¥<?php echo esc_html(number_format($late)); ?></div>
              </div>
            </div>
            <div class="page-price__item">
              <div class="page-price__table">
                <div class="page-price__term">
                  <div class="page-price__jp-term">メンズデイ</div>
                  <div class="page-price__en-term">Mens day</div>
                  <div class="page-price__caution">※毎週月曜日は男性の方が割引となります。</div>
                </div>
                <?php
                $male = get_field('male');
                ?>
                <div class="page-price__fee">¥<?php echo esc_html(number_format($male)); ?></div>
              </div>
            </div>
            <div class="page-price__item">
              <div class="page-price__table">
                <div class="page-price__term">
                  <div class="page-price__jp-term">レディースデイ</div>
                  <div class="page-price__en-term">Ladies Day</div>
                  <div class="page-price__caution">※毎週水曜日は女性の方が割引となります。</div>
                </div>
                <?php
                $female = get_field('female');
                ?>
                <div class="page-price__fee">¥<?php echo esc_html(number_format($female)); ?></div>
              </div>
            </div>
            <div class="page-price__item">
              <div class="page-price__table">
                <div class="page-price__term">
                  <div class="page-price__jp-term">夫婦割引</div>
                  <div class="page-price__en-term">Couple</div>
                  <div class="page-price__caution">※夫婦で来場された場合に割引となります。</div>
                </div>
                <?php
                $couple = get_field('couple');
                ?>
                <div class="page-price__fee">¥<?php echo esc_html(number_format($couple)); ?></div>
              </div>
            </div>
            <div class="page-price__item">
              <div class="page-price__table">
                <div class="page-price__term">
                  <div class="page-price__jp-term">障がい者手帳をお持ちの方</div>
                  <div class="page-price__en-term">Disabled</div>
                  <div class="page-price__caution">※障がい者手帳をお持ちの方が割引となります。</div>
                </div>
                <?php
                $disability = get_field('disability');
                ?>
                <div class="page-price__fee">¥<?php echo esc_html(number_format($disability)); ?></div>
              </div>
            </div>
            <div class="page-price__item">
              <div class="page-price__table">
                <div class="page-price__term">
                  <div class="page-price__jp-term">シニア（60歳以上）</div>
                  <div class="page-price__en-term">Senior</div>
                  <div class="page-price__caution">※60歳以上の方が割引となります。</div>
                </div>
                <?php
                $senior = get_field('senior');
                ?>
                <div class="page-price__fee">¥<?php echo esc_html(number_format($senior)); ?></div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="page-price__container page-price__container--group">
        <h2 class="page-price__section-title page-price__section-title--group">団体・学校・企業でのご利用案内</h2>
        <p class="page-price__group-text">20名様以上でのプラネタリウム鑑賞予定のお客様に団体割引をご用意しております。また学校・企業での行事の一環としてのご利用も承ります。事前にご連絡いただけますとスムーズにご案内することができます。</p>
      </div>
    </section>
  </main>
  <?php get_template_part('template-parts/footer-nav'); ?>
  <?php get_footer(); ?>
</body>

</html>