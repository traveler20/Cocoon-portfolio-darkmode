<?php
/*
Plugin Name: Test Plugin
Description: Test用のプラグイン
Version: 1.0
Author: ゆるけー
Author URI: https://yurukei-career.com
*/

// phpファイルを入力してもコードが見えないように
if ( ! defined( 'ABSPATH' ) ) exit;

// ──────────────────────────────
// wp_footerで「ほげええええぇぇぇ！」と出力する
add_action( 'wp_footer', function() {
	echo 'ほげええええぇぇぇ！';
});

// CSSやJSファイルの読み込ませ方
// define( 'MY_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
// define( 'MY_PLUGIN_URL', plugins_url( '/', __FILE__ ) );
// // それぞれ以下のような文字列を定数化しておけます
// // MY_PLUGIN_PATH -> "/app/public/wp-content/plugins/my-test-plugin/"
// // MY_PLUGIN_URL  -> "https://example.com/wp-content/plugins/my-test-plugin/"

// ──────────────────────────────
/**
 * 必要な定数を定義しておく
 */
define( 'MY_PLUGIN_VERSION', '1.0' );
define( 'MY_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'MY_PLUGIN_URL', plugins_url( '/', __FILE__ ) );

/**
 * スクリプト スタイルシートの読み込み
 */
add_action( 'wp_enqueue_scripts', function() {

	/** JS */
	wp_enqueue_script(
		'my-test-script',
		MY_PLUGIN_URL.'assets/my_script.js',
		array(),
		MY_PLUGIN_VERSION,
		true
	);

	/** CSS */
	wp_enqueue_style(
		'my-test-style',
		MY_PLUGIN_URL.'assets/my_style.css',
		array(),
		MY_PLUGIN_VERSION
	);
});

// 管理画面に「お知らせ通知アラート」を表示
// ──────────────────────────────
add_action('admin_notices', function() {
echo <<<EOF
<div class="notice notice-info is-dismissible">
    <p>お知らせ通知アラートのテスト</p>
</div>
EOF;
});

// 管理画面に「とりあえずメニュー」を追加登録する
// ──────────────────────────────
add_action('admin_menu', function(){
	// メインメニュー①
    add_menu_page(
		'とりあえずメニューです' // ページのタイトルタグ<title>に表示されるテキスト
		, 'とりあえずメニュー'   // 左メニューとして表示されるテキスト
		, 'manage_options'       // 必要な権限 manage_options は通常 administrator のみに与えられた権限
		, 'toriaezu_menu'        // 左メニューのスラッグ名 →URLのパラメータに使われる /wp-admin/admin.php?page=toriaezu_menu
		, 'toriaezu_mainmenu_page_contents' // メニューページを表示する際に実行される関数(サブメニュー①の処理をする時はこの値は空にする)
		, 'dashicons-admin-users'       // メニューのアイコンを指定 https://developer.wordpress.org/resource/dashicons/#awards
		, 0                             // メニューが表示される位置のインデックス(0が先頭) 5=投稿,10=メディア,20=固定ページ,25=コメント,60=テーマ,65=プラグイン,70=ユーザー,75=ツール,80=設定
	);
    // サブメニュー① ※事実上の親メニュー
	add_submenu_page(
		'toriaezu_menu'    // 親メニューのスラッグ
		, 'サブメニュー①です' // ページのタイトルタグ<title>に表示されるテキスト
		, 'サブメニュー①' // サブメニューとして表示されるテキスト
		, 'manage_options' // 必要な権限 manage_options は通常 administrator のみに与えられた権限
		, 'toriaezu_menu'  // サブメニューのスラッグ名。この名前を親メニューのスラッグと同じにすると親メニューを押したときにこのサブメニューを表示します。一般的にはこの形式を採用していることが多い。
		, 'toriaezu_submenu1_page_contents' //（任意）このページのコンテンツを出力するために呼び出される関数
		, 0
	);
	// サブメニュー②
	add_submenu_page(
		'toriaezu_menu'    // 親メニューのスラッグ
		, 'サブメニュー②' // ページのタイトルタグ<title>に表示されるテキスト
		, 'サブメニュー②' // サブメニューとして表示されるテキスト
		, 'manage_options' // 必要な権限 manage_options は通常 administrator のみに与えられた権限
		, 'toriaezu_submenu2' //サブメニューのスラッグ名
		, 'toriaezu_submenu2_page_contents' //（任意）このページのコンテンツを出力するために呼び出される関数
		, 1
	);
});


// メインメニューページ内容の表示・更新処理
// ──────────────────────────────
function toriaezu_mainmenu_page_contents() {
// HTML表示
echo <<<EOF
<div class="wrap">
	<h2>メインメニューです</h2>
	<p>
		toriaezu_menuのページです。
	</p>
</div>
EOF;
}
// サブメニュー①ページ内容の表示・更新処理
// ──────────────────────────────
function toriaezu_submenu1_page_contents() {
// HTML表示
echo <<<EOF
<div class="wrap">
	<h2>サブメニュー①</h2>
	<p>
		toriaezu_submenu1 のページです。
	</p>
</div>
EOF;
}

// サブメニュー②ページ内容の表示・更新処理
// ──────────────────────────────
function toriaezu_submenu2_page_contents() {
// HTML表示
echo <<<EOF
<div class="wrap">
	<h2>サブメニュー②</h2>
	<p>
		toriaezu_submenu2 のページです。
	</p>
</div>
EOF;
}