<?php
require_once 'functions.php';
require_once 'db.php';

// 管理者情報を取得
function get_admin($db){
  $sql = "
    SELECT
      login_id,
      password,
      updatedate
    FROM
      admin
    LIMIT 1
  ";

  return fetch_query($db, $sql);
}

// 管理者ログインIDの変更
function change_admin_login_id($db, $login_id){
  if(is_valid_login_id($login_id) === false){
    return false;
  }
  return update_admin_login_id($db, $login_id);
}

// 管理者ログインIDの変更
function update_admin_login_id($db, $login_id){
  $sql = "
  UPDATE
  admin
  SET 
  login_id = :login_id
  WHERE
  admin_id = 1
  LIMIT 1
  ";
  
  $params = array(
    ':login_id' => $login_id,
  );
  
  return execute_query($db, $sql, $params);
}

// 管理者パスワードの変更
function change_admin_password($db, $current_password, $new_password, $confirm_new_password){
  if(is_valid_passwords($new_password, $confirm_new_password) === false){
    return false;
  }
  if(is_correct_password($db, $current_password) === false){
    return false;
  }
  return update_admin_password($db, $new_password);
}

// 管理者パスワードの変更
function update_admin_password($db, $password){
  $password = password_hash($password, PASSWORD_DEFAULT);
  $sql = "
  UPDATE
  admin
  SET 
  password = :password
  WHERE
  admin_id = 1
  LIMIT 1
  ";
  
  $params = array(
    ':password' => $password,
  );
  
  return execute_query($db, $sql, $params);
}

// 管理者ログイン
function admin_login($db, $login_id, $password){
  $admin = get_admin($db);
  if($admin === false){
    return false;
  }

  if($admin['login_id'] !== $login_id || password_verify($password, $admin['password']) === false){
    set_error('ログインIDまたはパスワードが間違っています。');
    return false;
  }

  session_regenerate_id(true);
  set_session('admin_login_id', $admin['login_id']);
  set_message('ログインしました。');
  return true;
}

// 管理者としてログインしているかどうか
function is_admin_logged_in(){
  return get_session('admin_login_id') !== '';
}

// パスワード変更の際、正しい現在のパスワードを入力したかどうか
function is_correct_password($db, $current_password){
  $admin = get_admin($db);
  if(password_verify($current_password, $admin['password']) === false){
    set_error('現在のパスワードが間違っています。');
    return false;
  }
  return true;
}


