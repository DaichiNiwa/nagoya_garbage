<!DOCTYPE html>
<html lang="ja">
<head>
  <?php include VIEW_PATH . 'templates/head.php'; ?>
  <title>作業員ログイン</title>
</head>
<body>
  <?php include VIEW_PATH . 'templates/header.php'; ?>
  <div class="container">
    <h1>作業員ログイン</h1>
    <?php include VIEW_PATH . 'templates/messages.php'; ?>

    <form method="post" action="login_process.php" class="login_form mx-auto">
      <div class="form-group">
        <label for="login_id">ログインID: </label>
        <input type="text" name="login_id" id="login_id" class="form-control">
      </div>
      <div class="form-group">
        <label for="password">パスワード: </label>
        <input type="password" name="password" id="password" class="form-control">
      </div>
      <input type="hidden" name="csrf_token" value="<?php print h($token); ?>">
      <input type="submit" value="ログイン" class="btn btn-primary">
    </form>
    <p>ログインID: worker1、パスワード: passwordでログインできます。</p>
  </div>
</body>
</html>