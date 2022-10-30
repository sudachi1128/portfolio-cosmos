<meta charset="UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="icon" type="image/png" href="<?php echo esc_url(get_theme_file_uri('images/favicon.png')); ?>">
<!-- ↓srcやhrefの先頭部分を//にすることによってhttpにもhttpsにも対応できる -->
<!-- Google Fontsの読み込み -->
<link rel="preconnect" href="//fonts.googleapis.com">
<link rel="preconnect" href="//fonts.gstatic.com" crossorigin>
<link href="//fonts.googleapis.com/css2?family=Cormorant+Infant:wght@300;500&family=Noto+Serif+JP:wght@200;300;400;600&display=swap" rel="stylesheet">
<!-- ページローダー（pace.js）の読み込み -->
<script src="//cdn.jsdelivr.net/npm/pace-js@latest/pace.min.js"></script>
<!-- 管理ツールバー表示&プラグインなどのために必須のタグ -->
<?php wp_head(); ?>