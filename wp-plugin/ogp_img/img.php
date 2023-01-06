<?php

function mb_wordwrap($string, $width=75, $break="\n", $cut = false) {
  if (!$cut) {
      $regexp = '#^(?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){'.$width.',}\b#U';
  } else {
      $regexp = '#^(?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){'.$width.'}#';
  }
  $string_length = mb_strlen($string,'UTF-8');
  $cut_length = ceil($string_length / $width);
  $i = 1;
  $return = '';
  while ($i < $cut_length) {
      preg_match($regexp, $string, $matches);
      $new_string = (!$matches ? $string : $matches[0]);
      $return .= $new_string.$break;
      $string = substr($string, strlen($new_string));
      $i++;
  }
  return $return.$string;
}

  $fontSize = 52; // 文字サイズ
  $fontFamily = 'NotoSansJP-Bold.otf'; // 字体
  $txtX = $fontSize * 1.4; // 文字の横位置(文字の左が基準)
  $txtY = $fontSize * 3; // 文字の縦位置(文字のベースラインが基準)
  $txt = mb_wordwrap($_GET['text'], 16, "\n", true); // テキスト

  $img = imagecreatefromwebp('ogp.webp'); // テキストを載せる画像
//   $img = imagecreatefromjpg('ogp.jpg'); // 元画像がjpgの場合はこうなります
  $color = imagecolorallocate($img, 51, 51, 51); // テキストの色指定(RGB)

  // $string = $_GET['text'];
  // $l = 3;
  // $chunked = array();
  // for ($i=0; $i<$l; $i++) {
  //   $chunked[] = mb_substr($string,$i,14,'UTF-8');
  // }
  // $txt = join("\n",$chunked);

  imagettftext($img, $fontSize, 0, $txtX, $txtY, $color, $fontFamily, $txt);
  header('Content-Type: image/webp');
  imagewebp($img);
  imagedestroy($img);

  // $bbox = imagettfbbox($fontSize, 0, $fontFamily, 'Powered by PHP ' . phpversion());
//   $padding = 10;   
//   //生成するイメージの幅、高さを算出
// $txt    = mb_convert_encoding($txt,"UTF-8","auto");
// $result = ImageTTFBBox($fontSize, 0, $fontFamily, $txt);
// $width    = ($result[2]-$result[6]) + $padding*2;
// $height = ($result[3]-$result[7]) + $padding*2;