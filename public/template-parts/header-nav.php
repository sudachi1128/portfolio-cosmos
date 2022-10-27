<header class="header">
  <?php $tag = is_home() ? 'h1' : 'div'; ?>
  <<?php echo $tag; ?> class="header__logo">
    <a class="header__logo-link" href="<?php echo esc_url(home_url('/')); ?>">
      <img class="header__logo-icon" src="<?php echo esc_url(get_theme_file_uri('images/header-logo.png')); ?>" alt="ロゴ">
    </a>
  </<?php echo $tag; ?>>
  <button class="header__hamburger">
    <span></span>
    <span></span>
    <span></span>
  </button>
</header>
<?php
// メニューIDを取得する一連の流れ
// ↓global_navはfunction.phpで定めたもの
$menu_name = "global_nav";
$locations = get_nav_menu_locations();
$menu = wp_get_nav_menu_object($locations[$menu_name]);
$menu_items = wp_get_nav_menu_items($menu->term_id);
?>
<canvas class="header__canvas"></canvas>
<nav class="header__nav">
  <ul class="header__list">
    <?php foreach ($menu_items as $item) : ?>
      <li class="header__item">
        <a class="header__link" href="<?php echo esc_attr($item->url); ?>"><?php echo esc_html($item->title); ?></a>
      </li>
    <?php endforeach; ?>
  </ul>
</nav>