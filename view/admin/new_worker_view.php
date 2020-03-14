<!DOCTYPE html>
<html lang="ja">

<head>
  <?php include VIEW_PATH . 'templates/head.php'; ?>
  <title>作業員新規登録/名古屋市粗大ごみ</title>
</head>

<body>
  <?php include VIEW_PATH . 'templates/header_admin_login.php';?>

  <div class="container">
    <h1>作業員新規登録</h1>
    <?php include VIEW_PATH . 'templates/messages.php'; ?>

    <form method="post" action="worker_insert.php">
      <div class="form-group">
        <label for="login_id">ログインID(半角英数字5文字以上10文字以内): </label>
        <input class="form-control" type="text" name="login_id" id="login_id"value="<?php if (isset($login_id)) {print h($login_id);} ?>">
      </div>
      <div class="form-group">
        <label for="password">パスワード(半角英数字5文字以上10文字以内): </label>
        <input class="form-control" type="password" name="password" id="password">
      </div>
      <div class="form-group">
        <label for="confirm_password">パスワード(確認): </label>
        <input class="form-control" type="password" name="confirm_password" id="confirm_password">
      </div>
      <div class="form-group">
        <label for="worker_name">氏名: </label>
        <input class="form-control" type="text" name="worker_name" id="worker_name" placeholder="例：田中太郎" value="<?php if (isset($worker_name)) {print h($worker_name);} ?>">
      </div>
      <div class="form-group">
        <label for="area">担当地区: </label>
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
        <label for="comment">コメント(任意、200文字以内): </label>
        <textarea class="form-control" type="text" name="comment" id="comment"><?php if (isset($comment)) {print h($comment);} ?></textarea>
      </div>

      <input type="hidden" name="csrf_token" value="<?php print h($token); ?>">
      <input type="submit" value="確定" class="btn btn-primary">
    </form>
  </div>
</body>
</html>