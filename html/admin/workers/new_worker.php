<?php
require_once '../../../conf/const.php';
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'admin.php';

session_start();

if(is_admin_logged_in() === false){
  redirect_to(ADMIN_LOGIN_URL);
}

$token = get_csrf_token();
include_once '../../../view/admin/new_worker_view.php';