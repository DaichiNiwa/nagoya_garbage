<!DOCTYPE html>
<html lang="ja">

<head>
  <?php include VIEW_PATH . 'templates/head.php'; ?>
  <title>申込/名古屋市粗大ごみ</title>
</head>

<body>
  <?php
  include VIEW_PATH . 'templates/header.php';
  ?>

  <div class="container">
    <h1>回収申し込み</h1>
    <!--　入力値に間違いがあればエラーメッセージを表示  -->
    <?php include VIEW_PATH . 'templates/messages.php'; ?>
    <h2 class="border-bottom border-primary">ごみの登録</h2>
    <p>回収予定日: <?php print h($collect_day->format('Y年m月d日')); ?>（水）</p>
    <p>※申込完了日の次の水曜日となります。</p>

    <form method="post" action="<?php print h(CONFIRM_URL) ?>">
      <div class="form-group">
        <label for="type">ごみの種類: </label>
        <p>1m以上の家具、家電はそれぞれ大型家具、大型家電にしてください。</p>
        <select class="form-control" name="type" id="type">
          <option value="0" <?php if($type === '0') { print h('selected');} ?>>大型家具</option>
          <option value="1" <?php if($type === '1') { print h('selected');} ?>>小型家具</option>
          <option value="2" <?php if($type === '2') { print h('selected');} ?>>大型家電</option>
          <option value="3" <?php if($type === '3') { print h('selected');} ?>>小型家電</option>
          <option value="4" <?php if($type === '4') { print h('selected');} ?>>布団マットレス類</option>
          <option value="5" <?php if($type === '5') { print h('selected');} ?>>スポーツ用具</option>
          <option value="6" <?php if($type === '6') { print h('selected');} ?>>その他</option>
        </select>
      </div>
      <div class="form-group">
        <label for="comment">コメント(任意、200文字以内): </label>
        <p>回収にあたって留意することがある場合、記入してください。</p>
        <textarea class="form-control" type="text" name="comment" id="comment"><?php if (isset($comment)) {print h($comment);} ?></textarea>
      </div>

      <h2 class="border-bottom border-primary">申込者の登録</h2>
      <div class="form-group">
        <label for="username">氏名: </label>
        <input class="form-control" type="text" name="username" id="username" placeholder="例：田中太郎" value="<?php if (isset($username)) {print h($username);} ?>">
      </div>
      <div class="form-group">
        <label for="phone_number">電話番号(半角数字、ハイフンなし): </label>
        <input class="form-control" type="number" name="phone_number" id="phone_number" placeholder="例：09077322109" value="<?php if (isset($phone_number)) {print h($phone_number);} ?>">
      </div>
      <div class="orm-group">
        <label for="email">Eメール: </label>
        <input class="form-control" type="email" name="email" id="email" placeholder="例：example@example.com" value="<?php if (isset($email)) {print h($email);} ?>">
      </div>
      <div class="form-group">
        <label for="area">お住まいの区: </label>
        <select class="form-control" name="area" id="area">
          <option value="0" <?php if($area === '0') { print h('selected');} ?>>千種区</option>
          <option value="1" <?php if($area === '1') { print h('selected');} ?>>東区</option>
          <option value="2" <?php if($area === '2') { print h('selected');} ?>>北区</option>
          <option value="3" <?php if($area === '3') { print h('selected');} ?>>西区</option>
          <option value="4" <?php if($area === '4') { print h('selected');} ?>>中村区</option>
          <option value="5" <?php if($area === '5') { print h('selected');} ?>>中区</option>
          <option value="6" <?php if($area === '6') { print h('selected');} ?>>昭和区</option>
          <option value="7" <?php if($area === '7') { print h('selected');} ?>>瑞穂区</option>
          <option value="8" <?php if($area === '8') { print h('selected');} ?>>熱田区</option>
          <option value="9" <?php if($area === '9') { print h('selected');} ?>>中川区</option>
          <option value="10" <?php if($area === '10') { print h('selected');} ?>>港区</option>
          <option value="11" <?php if($area === '11') { print h('selected');} ?>>名東区</option>
          <option value="12" <?php if($area === '12') { print h('selected');} ?>>天白区</option>
        </select>
      </div>
      <div class="form-group">
        <label for="address">以下の住所: </label>
        <input class="form-control" type="text" name="address" id="address" placeholder="例：平針１ー７２４　グランドコープ３０７" value="<?php if (isset($address)) {print h($address);} ?>">
      </div>

      <!-- トークンを送信 -->
      <input type="hidden" name="csrf_token" value="<?php print h($token); ?>">
      <input type="submit" value="確認画面へ" class="btn btn-primary">
    </form>
  </div>
</body>