<?php
require_once '../../conf/const.php';
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'admin.php';

session_start();

// 管理者としてログインしていなければログイン画面へ
if(is_admin_logged_in() === false){
  redirect_to(ADMIN_LOGIN_URL);
}

$db = get_db_connect();

// 管理者のログインIDと更新日時を取得
$admin = get_admin($db);

include_once '../../view/admin/admin_view.php';
