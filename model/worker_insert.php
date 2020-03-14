<?php
require_once 'functions.php';
require_once 'db.php';

// 作業員の新規登録
function regist_worker($db, $login_id, $password, $confirm_password, $worker_name, $area, $comment){
  // 入力値のバリデーション
  if(validate_worker($login_id, $password, $confirm_password, $worker_name, $area, $comment) === false){
    return false;
  }
  // 入力されたログインIDがすでに使用されていないか確認
  if(is_existing_login_id($db, $login_id) === true){
    return false;
  }
  return insert_worker($db, $login_id, $password, $worker_name, $area, $comment);
}

// 作業員の新規登録
function insert_worker($db, $login_id, $password, $worker_name, $area, $comment){
  $password = password_hash($password, PASSWORD_DEFAULT);
  $sql = "
    INSERT INTO
      workers(
        login_id,
        password,
        worker_name,
        area,
        comment
      )
    VALUES(:login_id, :password, :worker_name, :area, :comment);
  ";

  $params = array(
    ':login_id' => $login_id,
    ':password' => $password,
    ':worker_name' => $worker_name,
    ':area' => $area,
    ':comment' => $comment,
  );

  return execute_query($db, $sql, $params);
}

// 作業員の担当区変更
function change_worker_area($db, $garbage_id, $area){
  if(is_valid_area($area) === false){
    return false;
  }
  return update_worker_area($db, $garbage_id, $area);
}

// 作業員の担当区変更
function update_worker_area($db, $worker_id, $area){
  $sql = "
    UPDATE
      workers
    SET
      area = :area
    WHERE
      worker_id = :worker_id
  ";

  $params = array(
    ':area' => $area,
    ':worker_id' => $worker_id
  );

  return execute_query($db, $sql, $params);
}

// 作業員への管理者コメントの変更
function change_admin_worker_comment($db, $garbage_id, $comment){
  if(is_valid_comment($comment) === false){
    return false;
  }
  return updated_admin_worker_comment($db, $garbage_id, $comment);
}

// 作業員への管理者コメントの変更
function updated_admin_worker_comment($db, $worker_id, $comment){
  $sql = "
    UPDATE
      workers
    SET
      comment = :comment
    WHERE
      worker_id = :worker_id
    LIMIT 1
  ";
  
  $params = array(
    ':comment' => $comment,
    ':worker_id' => $worker_id
  );

  return execute_query($db, $sql, $params);
}

// 作業員を１件削除
function delete_worker($db, $worker_id){
  $sql = "
    DELETE FROM
      workers
    WHERE
      worker_id = :worker_id
    LIMIT 1
  ";

  $params = array(
    ':worker_id' => $worker_id
  );
  
  return execute_query($db, $sql, $params);
}


