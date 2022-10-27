<?php
// // All in One SEOに<title><meta>の出力は任せる
// // titleタグの出力
// // ドキュメントのタイトルを管理するためのプラグインやテーマを可能にします。これはwp_title()関数の代わりに使用する必要があります。
// add_action('after_setup_theme', function () {
//   add_theme_support('title-tag');
// });
// // タイトルタグの内容（セパレーターを変更する)
// add_filter('document_title_separator', function ($sep) {
//   $sep = '|';
//   return $sep;
// });

// 以下セキュリティ対策

// 投稿者一覧ページを自動で生成されないようにする
add_filter('author_rewrite_rules', '__return_empty_array');

// /?author=1 などでアクセスしたらリダイレクトさせる
// @see https://www.webdesignleaves.com/pr/wp/wp_user_enumeration.html
if (!is_admin()) {
  // default URL format
  if (preg_match('/author=([0-9]*)/i', $_SERVER['QUERY_STRING'])) die();
  add_filter('redirect_canonical', 'my_shapespace_check_enum', 10, 2);
}
function my_shapespace_check_enum($redirect, $request)
{
  // permalink URL format
  if (preg_match('/\?author=([0-9]*)(\/*)/i', $request)) die();
  else return $redirect;
}

// WordPress REST API によるユーザー情報を隠す
function my_filter_rest_endpoints($endpoints)
{
  if (isset($endpoints['/wp/v2/users'])) {
    unset($endpoints['/wp/v2/users']);
  }
  if (isset($endpoints['/wp/v2/users/(?P<id>[\d]+)'])) {
    unset($endpoints['/wp/v2/users/(?P<id>[\d]+)']);
  }
  return $endpoints;
}
add_filter('rest_endpoints', 'my_filter_rest_endpoints', 10, 1);

// javascriptとcssの読み込み
add_action('wp_enqueue_scripts', function () {
  // cssの読み込み(style.css)
  wp_enqueue_style('style', get_stylesheet_uri());
  // JavaScriptの読み込み(main.js)
  wp_enqueue_script(
    'main.js',
    get_template_directory_uri() . '/main.js',
    // 依存する（このスクリプトより前に読み込まれる必要がある）他のスクリプトのハンドル名を配列で指定する。依存関係がない場合は falseを指定する
    array(),
    // 任意のバージョンを指定
    false,
    // スクリプトの読み込み位置を指定。trueにするとwp_footer()で読み込める
    true,
  );
});

// archive.phpのデフォルト状態では、単純な記事の一覧を表示することが出来ない仕様となっているため、上記のコードでカスタマイズする必要があります。また”任意のスラッグ名"とコメントされた行の内容を変えれば「/blog/」以外のURLでアクセスできる様にすることも出来ます。
// 投稿のアーカイブページを作成する
// 設定後はパーマリンクの更新を行う
function post_has_archive($args, $post_type)
{
  if ('post' == $post_type) {
    $args['rewrite'] = true; // リライトを有効にする
    $args['has_archive'] = 'news'; // 任意のスラッグ名
    $args['label'] = 'お知らせ'; // ラベルの名前
  }
  return $args;
}
add_filter('register_post_type_args', 'post_has_archive', 10, 2);

// 先ほど作成した「投稿」のアーカイブページURLに、内部構造を合わせていきます。
// 変更後はパーマリンクの更新を忘れずに
add_filter('post_type_archive_link', function ($link, $post_type) {
  if ('post' === $post_type) {
    $post_type_object = get_post_type_object('post');
    $slug = $post_type_object->has_archive;
    $link = get_home_url(null, '/' . $slug . '/');
  }
  return $link;
}, 10, 2);
function add_article_post_permalink($permalink)
{
  $permalink = '/news' . $permalink;
  return $permalink;
}
add_filter('pre_post_link', 'add_article_post_permalink');
function add_article_post_rewrite_rules($post_rewrite)
{
  $return_rule = array();
  foreach ($post_rewrite as $regex => $rewrite) {
    $return_rule['news/' . $regex] = $rewrite;
  }
  return $return_rule;
}
add_filter('post_rewrite_rules', 'add_article_post_rewrite_rules');

// トップページでは新着投稿を３件表示させるようにします。
function news_posts_per_page($query)
{
  if (is_admin() || !$query->is_main_query()) {
    return;
  }
  if ($query->is_front_page()) {
    $query->set('posts_per_page', '3');
  }
}
add_action('pre_get_posts', 'news_posts_per_page');

// add_action()はアクションフックと呼ばれるもので、第一引数で指定したタイミングで、第二引数で指定した関数を発火させる関数である。initはwordpressのロードが終わった段階を指す。
// デフォルトではサポートされていない項目をサポート
add_action('init', function () {
  //アイキャッチ画像をサポート
  add_theme_support('post-thumbnails');
  // メニューをサポート（登録）
  register_nav_menus([
    'global_nav' => 'グローバルナビゲーション'
  ]);

  // カスタム投稿タイプ
  // 設定後はパーマリンクの更新を行う
  // register_post_typeの第一引数がスラッグとなる
  register_post_type('work', [
    // 投稿タイプの名前
    'label' => '上映作品',
    // ダッシュボードに表示するかとりあえずtrueにする
    'public' => true,
    // ダッシュボードの投稿タイプラベルが表示される位置(5が一番上でデフォルトの投稿タイプの下、5刻みで表示位置が下に下がっていく)
    'menu_position' => 5,
    // メニューに表示されるアイコンDashiconsというサイトでアイコンは探せる。
    'menu_icon' => 'dashicons-editor-video',
    // 何をサポートするか(カスタムフィールドの追加など)
    'supports' => ['title', 'thumbnail', 'editor', 'custom-fields', 'excerpt'],
    // カスタム投稿タイプの一覧を生成するかどうか ※デフォルトでは、アーカイブのスラッグとして ↑$post_type が使われる
    'has_archive' => true,
    // 新エディタを使用できる
    'show_in_rest' => true,
  ]);
});

// アイキャッチの画像がなければ、標準画像を表示する。
function get_eye_catch()
{
  if (has_post_thumbnail()) {
    $id = get_post_thumbnail_id();
    $img = wp_get_attachment_image_src($id, 'full');
  } else {
    $img = array(get_theme_file_uri('images/substitute.jpeg'));
  }
  // 関数で変数$imgを定義した場合、関数スコープで$imgが使えなくなるのでreturnで戻り値として外でも使えるようにする。
  return $img;
}

//概要（抜粋）の文字数調整
add_filter('excerpt_length', function () {
  return 70;
}, 999);

//概要（抜粋）の省略文字
add_filter('excerpt_more', function () {
  return '&nbsp;&#46;&#46;&#46;';
});

// MW WP FORMのエラーメッセージカスタマイズ
function my_error_message($error, $key, $rule)
{
  if ($key === 'username' && $rule === 'noempty') {
    return 'お名前を入力してください。';
  }
  if ($key === 'email' && $rule === 'noempty') {
    return 'メールアドレスを入力してください。';
  }
  if ($key === 'telephone' && $rule === 'noempty') {
    return '電話番号を入力してください。';
  }
  if ($key === 'message' && $rule === 'noempty') {
    return 'お問い合わせ内容を入力してください。';
  }
  return $error;
}
add_filter('mwform_error_message_mw-wp-form-264', 'my_error_message', 10, 3);

// MW WP FORMのエラーメッセージカスタマイズ
function custom_mwform_error_message_html($tag, $error)
{
  $start_tag = '<p class="page-contact__error">';
  $end_tag = '</p>';
  return $start_tag . esc_html($error) . $end_tag;
}
add_filter('mwform_error_message_html', 'custom_mwform_error_message_html', 10, 2);
