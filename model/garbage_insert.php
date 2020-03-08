<?php
require_once 'functions.php';
require_once 'db.php';
require_once 'garbage_function.php';

// ごみの登録
function regist_garbage($db, $collect_day, $type, $comment, $username, $phone_number, $email, $area, $address){
  if(validate_garbage($type, $comment, $username, $phone_number, $email, $area, $address) === false){
    return false;
  }
  return regist_garbage_transaction($db, $collect_day, $type, $comment, $username, $phone_number, $email, $area, $address);
}

function regist_garbage_transaction($db, $collect_day, $type, $comment, $username, $phone_number, $email, $area, $address){
  $db->beginTransaction();
  if(insert_garbage($db, $collect_day, $type, $comment, $username, $phone_number, $email, $area, $address) ){
    $db->commit();
    return true;
  }
  $db->rollback();
  return false;
  
}

function insert_garbage($db, $collect_day, $type, $comment, $username, $phone_number, $email, $area, $address){
  $sql = "
    INSERT INTO
      garbages(
        type,
        collect_day,
        username,
        phone_number,
        email,
        area,
        address,
        user_comment
      )
    VALUES(:type, :collect_day, :username, :phone_number, :email, :area, :address, :user_comment);
  ";

  $params = array(
    ':type' => $type,
    ':collect_day' => $collect_day,
    ':username' => $username,
    ':phone_number' => $phone_number,
    ':email' => $email,
    ':area' => $area,
    ':address' => $address,
    ':user_comment' => $comment,
  );

  return execute_query($db, $sql, $params);
}

// ごみのステータス変更
function update_garbage_status($db, $garbage_id, $status){
  $sql = "
    UPDATE
      garbages
    SET
      status = :status
    WHERE
      garbage_id = :garbage_id
  ";

  $params = array(
    ':status' => $status,
    ':garbage_id' => $garbage_id
  );

  return execute_query($db, $sql, $params);
}

// ごみの管理者コメントの変更
function update_garbage_comment($db, $garbage_id, $admin_comment){
  $sql = "
    UPDATE
      garbages
    SET
      admin_comment = :admin_comment
    WHERE
      garbage_id = :garbage_id
    LIMIT 1
  ";
  
  $params = array(
    ':admin_comment' => $admin_comment,
    ':garbage_id' => $garbage_id
  );

  return execute_query($db, $sql, $params);
}

// ごみを１件削除
function delete_garbage($db, $garbage_id){
  $sql = "
    DELETE FROM
      garbages
    WHERE
      garbage_id = :garbage_id
    LIMIT 1
  ";

  $params = array(
    ':garbage_id' => $garbage_id
  );
  
  return execute_query($db, $sql, $params);
}

// 全ての回収済ごみを削除
function delete_garbages($db){
  $sql = "
    DELETE FROM
      garbages
    WHERE
      status = 1
  ";

  return execute_query($db, $sql);
}