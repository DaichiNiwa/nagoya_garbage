<!DOCTYPE html>
<html lang="ja">

<head>
  <?php include VIEW_PATH . 'templates/head.php'; ?>
  <title>管理者情報/名古屋市粗大ごみ</title>
</head>

<body>
  <?php include VIEW_PATH . 'templates/header_admin_login.php';?>

  <div class="container">
    <?php include VIEW_PATH . 'templates/messages.php'; ?>
    <h2 class="border-bottom border-primary">管理者情報</h2>
    <p>現在のログインID: <?php print h($admin['login_id']); ?></p>
    <p>現在のパスワード: 非表示</p>
    <p>ログインID、パスワードの最終更新日時: <?php print h($admin['updatedate']); ?></p>
    <?php if(AUTH_ADMIN_CHANGE === false){ ?>
      <p class="bg-warning">現在、ログインIDとパスワードの変更はできない設定になっています。</p>
    <?php } ?>

    <h2 class="border-bottom border-primary">ログインIDを変更</h2>
    <form method="post" action="admin_change_id.php">
      <div class="form-group">
        <label for="login_id">新しいログインID（半角英数字5文字以上10文字以内）</label>
        <input class="form-control" type="text" name="login_id">
        <input type="hidden" name="csrf_token" value="<?php print h($token); ?>">
        <input type="submit" value="ログインIDを変更" class="btn btn-success m-2">
      </div>
    </form>

    <h2 class="border-bottom border-primary">パスワードを変更</h2>
    <form method="post" action="admin_change_password.php">
      <div class="form-group">
        <label for="current_password">現在のパスワード</label>
        <input class="form-control" type="password" name="current_password">
        <label for="new_password">新しいパスワード（半角英数字5文字以上10文字以内）</label>
        <input class="form-control" type="password" name="new_password">
        <label for="confirm_new_password">新しいパスワード（確認）</label>
        <input class="form-control" type="password" name="confirm_new_password">
        <input type="hidden" name="csrf_token" value="<?php print h($token); ?>">
        <input type="submit" value="パスワードを変更" class="btn btn-primary m-2">
      </div>
    </form>
</body>
</html>