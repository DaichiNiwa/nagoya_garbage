<?php
require_once '../../conf/const.php';
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'admin.php';

session_start();

// 管理者としてすでにログイン状態なら、ごみ一覧画面へリダイレクト
if(is_admin_logged_in() === true){
  redirect_to(ADMIN_GARBAGES_URL);
}

$token = get_csrf_token();

include_once '../../view/admin/login_view.php';