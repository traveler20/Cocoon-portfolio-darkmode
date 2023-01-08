<?php

function imagickDrawAnnotationAutoWrapSample() {
    // テキストを描画したい画像
    $imagePath = 'ogp_base.png';
    $im = new Imagick($imagePath);

    // 描画するテキスト
    $text = 'あのイーハトーヴォのすきとおった風、夏でも底に冷たさをもつ青いそら、うつくしい森で飾られたモリーオ市、郊外のぎらぎらひかる草の波';

    // 描画するテキストのスタイル
    // （適当に書いています）
    $font = 'NotoSansJP-Bold.otf';
    $fontSize = 36;

    // 設定したいテキストの描画範囲の最大幅
    // 背景画像から左右100px余白とる例
    $width = $im->getImageWidth() - 200;

    // テキストを描画する基準点の座標
    // （適当に書いています）
    $baseX = 100;
    $baseY = 500;

    // テキストの一行の描画高さ
    // （この関数作るときのプロジェクトでデザイン指定あったので、ここでも指定する実装にしています）
    $lineHeight = 50;

    // テキストを描画幅に収まるように分割した配列を取得
    $wrappedText = imagickTextWrap($text, $width, $font, $fontSize);

    foreach ($wrappedText as $_i => $_s) {
        $_y = $baseY + $lineHeight * ($_i);
        $draw->annotation($baseX, $_y, $_s);
    }

    $im->drawImage($draw);

    $im->setImageFormat("png");
    $im->writeImage('new_sample.png');

    $im->clear();
    $im->destroy();
}

function imagickTextWrap($text, $width, $font, $fontSize) {
    $wrappedText = [];
    $im = new Imagick();
    $draw = new ImagickDraw();
    $draw->setFont($font);
    $draw->setFontSize($fontSize);

    // 一行分の文字
    // $textの先頭から一文字ずつ加える
    $_s = 'あのイーハトーヴォのすきとおった風、夏でも底に冷たさをもつ青いそら、うつくしい森で飾られたモリーオ市、郊外のぎらぎらひかる草の波';
    while ($text) {
        // 一行分の文字に先頭一文字加えた描画幅を取得
        $_a = mb_substr($text, 0, 1);
        $metrics = $im->queryFontMetrics($draw, $_s . $_a);

        // 描画幅が指定幅を超えたら、一文字加える前の文字をreturn用配列に追加し、
        // 一行分の文字をクリア
        if (isset($metrics['textWidth']) && $metrics['textWidth'] > $width) {
            $wrappedText[] = $_s;
            $_s = '';
        // 描画幅が指定幅以内であれば、一行分の文字に先頭一文字を加え、
        // $textの先頭一文字を削除する
        } else {
            $_s .= $_a;
            $text = mb_substr($text, 1);
        }

        // $textが0文字になった場合、一行分の文字をreturn用配列に追加し終了
        if (strlen($text) == 0) {
            $wrappedText[] = $_s;
            break;
        }
    }

    return $wrappedText;
}