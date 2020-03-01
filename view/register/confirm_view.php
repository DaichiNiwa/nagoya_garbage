<!DOCTYPE html>
<html lang="ja">

<head>
  <?php include VIEW_PATH . 'templates/head.php'; ?>
  <title>確認/名古屋市粗大ごみ</title>
</head>

<body>
  <?php
  include VIEW_PATH . 'templates/header.php';
  ?>
  <div class="container">
    
    <h1>入力の確認</h1>
    <!--　入力値に間違いがあればエラーメッセージを表示  -->
    <?php include VIEW_PATH . 'templates/messages.php'; ?>

    <h2 class="border-bottom border-primary">ごみの登録</h2>
    <p>回収予定日: <?php print h($collect_day->format('Y年m月d日')); ?>（水）</p>
    <p>※申込完了日の次の水曜日となります。</p>
    <p>ごみの種類:</p>
    <p><?php print h($garbage_name); ?></p>
    <p>コメント(任意、200文字以内):</p>
    <p><?php print h($comment); ?></p>
    <h2 class="border-bottom border-primary">申込者の登録</h2>
    <p>氏名:</p>
    <p><?php print h($username); ?></p>
    <p>電話番号(半角数字、ハイフンなし):</p>
    <p><?php print h($phone_number); ?></p>
    <p>Eメール:</p>
    <p><?php print h($email); ?></p>
    <p>お住まいの区:</p>
    <p><?php print h($area_name); ?></p>
    <p>以下の住所:</p>
    <p><?php print h($address); ?></p>

    <!-- バリデーションで問題なければ確定ボタン、問題があれば入力画面に戻るボタンを表示する -->
    <form method="post" action="<?php $is_valid_information === true ? (print h(FINISH_URL)) : (print h(REGISTER_URL)); ?>">
      <input type="hidden" name="type" value="<?php print h($type) ?>" readonly>
      <input type="hidden" name="comment" value="<?php print h($comment) ?>" readonly>
      <input type="hidden" name="username" value="<?php print h($username)  ?>" readonly>
      <input type="hidden" name="phone_number" value="<?php print h($phone_number) ?>" readonly>
      <input type="hidden" name="email" value="<?php print h($email) ?>" readonly>
      <input type="hidden" name="area" value="<?php print h($area) ?>" readonly>
      <input type="hidden" name="address" value="<?php print h($address) ?>" readonly>
      <!-- トークンを送信 -->
      <input type="hidden" name="csrf_token" value="<?php print h($token); ?>">
      <input type="submit" value="<?php $is_valid_information === true ? (print h("確定する")) : (print h("入力画面に戻る")); ?>" class="btn btn-primary">
    </form>

    <!-- <form method="post" action="<?php print h(REGISTER_URL) ?>">
      <input type="hidden" name="type" value="<?php print h($type) ?>" readonly>
      <input type="hidden" name="comment" value="<?php print h($comment) ?>" readonly>
      <input type="hidden" name="username" value="<?php print h($username)  ?>" readonly>
      <input type="hidden" name="phone_number" value="<?php print h($phone_number) ?>" readonly>
      <input type="hidden" name="email" value="<?php print h($email) ?>" readonly>
      <input type="hidden" name="area" value="<?php print h($area) ?>" readonly>
      <input type="hidden" name="address" value="<?php print h($address) ?>" readonly>
      トークンを送信 
      <input type="hidden" name="csrf_token" value="<?php print h($token); ?>">
      <input type="submit" value="入力画面に戻る" class="btn btn-info mt-1">
    </form> -->
  </div>
</body>