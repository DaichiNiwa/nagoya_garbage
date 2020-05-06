<!DOCTYPE html>
<html lang="ja">

<head>
  <?php include VIEW_PATH . 'templates/head.php'; ?>
  <title>このサイトについて/名古屋市粗大ごみ</title>
</head>

<body>
  <?php include VIEW_PATH . 'templates/header.php';?>

  <div class="container">
    <h1>このサイトについて</h1>
    <p>このサイトは本物の名古屋市粗大ごみ回収サイトではありません。申し込みをしても回収には行きませんのでご了承ください。</p>
    <p>このサイトは市民用ページ、管理者用ページ、回収作業員用ページの３つで構成されています。</p>
    <a class="btn btn-secondary m-2" href="<?php print h(REGISTER_URL); ?>">市民用ページへ</a>
    <a class="btn btn-info m-2" href="<?php print h(ADMIN_LOGIN_URL); ?>">管理者用ページへ</a>
    <a class="btn btn-primary m-2" href="<?php print h(WORKER_LOGIN_URL); ?>">回収作業員用ページへ</a>
    <p><a class="btn btn-warning m-2" href="<?php print h(PORTFOLIO_URL); ?>">ポートフォリオサイトへ</a></p>
  </div>
</body>