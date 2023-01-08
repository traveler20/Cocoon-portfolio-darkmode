<?php

// 文字列とサイズをパラメータから取得
$text = (empty(trim($_GET['t']))) ? '404' : (string)trim($_GET['t']);
$size = (empty($_GET['s'])) ? 100 : (int)$_GET['s'];

// Twitterの横長OGP
$card_x = 1200;
$card_y = 630;
$im = imagecreatefrompng('ogp_base.png');

// カード背景色塗り潰し
// リソース, 左上x, 左上y, 右下x, 右下y, 色
// imagefilledrectangle($im, 0, 0, $card_x, $card_y, 0xffffff);

// 文字数から位置決めする
// 改行で文字列を切って行ごとに描画
$lines = explode('\n', $text);
foreach ($lines as $n => $line) {
  $length = mb_strlen($line);
  $xpos = ($card_x - ($length * $size)) / 2;
  $ypos = ($card_y + $size) / 2 - ((count($lines) - 1) * $size / 2) + ($n * $size);
  // 文字列ここで書く
  // リソース, フォントサイズ, 角度, x, y, 色, 文字
  imagettftext($im, $size, 0, $xpos, $ypos, 0x000000, 'NotoSansJP-Bold.otf', $line);
}

// PNG画像として出力
header('Content-Type: image/png;');
imagepng($im);
imagedestroy($im);