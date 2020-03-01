<!DOCTYPE html>
<html lang="ja">

<head>
  <?php include VIEW_PATH . 'templates/head.php'; ?>
  <title>申込完了/名古屋市粗大ごみ</title>
</head>

<body>
  <?php
  include VIEW_PATH . 'templates/header.php';
  ?>
  <div class="container">
    
    <!--　入力値に間違いがあればエラーメッセージを表示  -->
    <?php include VIEW_PATH . 'templates/messages.php'; ?>
    <a class="btn btn-success mt-1 mb-1" role="button" href="<?php print h(REGISTER_URL) ?>">最初の画面に戻る</a>

    <h2 class="border-bottom border-primary">ごみ</h2>
    <p>回収日: <?php print h($collect_day->format('Y年m月d日')); ?>（水）</p>
    <p>※申込完了日の次の水曜日となります。</p>
    <p>ごみの種類:</p>
    <p><?php print h($garbage_name); ?></p>
    <p>コメント</p>
    <p><?php print h($comment); ?></p>
    <h2 class="border-bottom border-primary">申込者</h2>
    <p>氏名:</p>
    <p><?php print h($username); ?></p>
    <p>電話番号:</p>
    <p><?php print h($phone_number); ?></p>
    <p>Eメール:</p>
    <p><?php print h($email); ?></p>
    <p>お住まいの区:</p>
    <p><?php print h($area_name); ?></p>
    <p>以下の住所:</p>
    <p><?php print h($address); ?></p>

    
  </div>
</body>