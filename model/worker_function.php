<?php
require_once 'functions.php';
require_once 'db.php';

// 作業員の新規登録時の入力値のバリデーション
function validate_worker($login_id, $password, $confirm_password, $worker_name, $area, $comment)
{
  $is_valid_login_id = is_valid_login_id($login_id);
  $is_valid_passwords = is_valid_passwords($password, $confirm_password);
  $is_valid_name = is_valid_username($worker_name);
  $is_valid_area = is_valid_area($area);
  $is_valid_comment = is_valid_comment($comment);

  return $is_valid_login_id
    && $is_valid_comment
    && $is_valid_passwords
    && $is_valid_name
    && $is_valid_area
    && $is_valid_comment;
}

// ログインIDがすでに存在しているか確認
function is_existing_login_id($db, $login_id)
{
  $is_existing = false;

  if(count_login_id($db, $login_id) > 0) {
    set_error('このログインIDはすでに使われています。');
    $is_existing = true;
  }

  return $is_existing;
}

// 作業員にコメントがついているかどうか（コメントがついていない場合、作業員管理画面でその作業員のコメント欄を表示しない）
function has_worker_comment($comment){
  $has_comment = false;
  if($comment !== '' && $comment !== null){
    $has_comment = true;
  }
  return $has_comment;
}

// 作業員ログイン
function worker_login($db, $login_id, $password){
  $worker = get_worker($db, $login_id);

  if($worker === false || password_verify($password, $worker['password']) === false){
    set_error('ログインIDまたはパスワードが間違っています。');
    return false;
  }
  
  session_regenerate_id(true);
  set_session('worker_login_id', $worker['login_id']);
  set_message('ログインしました。');
  return true;
}

// 作業員としてログインしているかどうか
function is_worker_logged_in(){
  return get_session('worker_login_id') !== '';
}
