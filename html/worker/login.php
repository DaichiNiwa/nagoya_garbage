<?php
require_once '../../conf/const.php';
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'worker_function.php';

session_start();

// 作業員としてすでにログイン状態なら、
if(is_worker_logged_in() === true){
  redirect_to(WORKER_ASSIGNED_URL);
}

$token = get_csrf_token();

include_once '../../view/worker/login_view.php';