<?php
ini_set('display_errors', 1); // エラーログをHTMLに出力

define('MAX_FILE_SIZE', 1 * 1024 * 1024); // !MB
define('THUMBNAIL_WIDTH', 400); // サムネイルの幅
define('IMAGES_DIR', __DIR__ . '/images');  // 元画像を保存するディレクトリ
define('THUMBNAIL_DIR', __DIR__ . '/thumbs'); // サムネイルを保存するディレクトリ

// GDが入っているかチェック
if(!function_exists('imagecreatetruecolor')){
  echo 'GD not installed';
  exit;
}

// htmlで表示可能な文字列に変換
// text/plain→text/html
function h($s){
  return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}

// phpファイルの読み込み
require 'ImageUploader.php';

// 名前空間MyAppのクラスImageUploaderをインスタンス化
$uploader = new \MyApp\ImageUploader();

if($_SERVER['REQUEST_METHOD'] === 'POST'){
  $uploader->upload();
}

$images = $uploader->getImages();
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>Image Uploader</title>
  <style>
  body{
    text-align: center;
    font-family: Arial, sans-serif;
  }
  ul{
    list-style: none;
    margin: 0;
    padding: 0;
  }
  li{
    margin-bottom: 5px;
  }
  </style>
</head>
<body>
  <form action="" method="post" enctype="multipart/form-data">
    <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo h(MAX_FILE_SIZE); ?>">
    <input type="file" name="image">
    <input type="submit" value="upload">
  </form>

  <ul>
    <?php foreach($images as $image) : ?>
      <li>
        <a href="<?php echo h(basename(IMAGES_DIR) . '/' . basename($image));?>">
          <img src="<?php echo h($image);?>">
        </a>
      </li>
    <?php endforeach;?>
  </ul>
</body>
</html>
