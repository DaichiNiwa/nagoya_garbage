<?php
require_once 'functions.php';
require_once 'db.php';

// 作業員一覧画面用に作業員の取得
function get_workers($db, $current_page){
  $list_start_number = DISPLAY_ITEMS_NUMBER * ($current_page - 1);
  return get_designated_workers($db, $list_start_number);
}

// 作業員一覧画面用に１０件ずつ作業員を取得
function get_designated_workers($db, $list_start_number = 0){
  $sql = '
    SELECT
      worker_id, 
      login_id,
      worker_name,
      area,
      comment
    FROM
      workers
    LIMIT :list_start_number,
  ' . DISPLAY_ITEMS_NUMBER;

    $params = array(
      ':list_start_number' => $list_start_number
    );

  return fetch_all_query($db, $sql, $params);
}

// ログイン中の作業員を取得
function get_login_worker($db){
  $login_id = get_session('worker_login_id');

  return get_worker($db, $login_id);
}

// ログインIDから作業員を1件取得
function get_worker($db, $login_id){
  $sql = "
    SELECT
      worker_id,
      login_id,
      password,
      worker_name,
      area
    FROM
      workers
    WHERE
      login_id = :login_id
    LIMIT 1
  ";
    
  $params = array(
    ':login_id' => $login_id
  );  
  return fetch_query($db, $sql, $params);
}

// 新規登録時、入力されたログインIDがすでに存在していないか確かめるため、そのログインIDの件数を取得
function count_login_id($db, $login_id){
  $sql = "
    SELECT
      COUNT(worker_id) as count
    FROM
      workers
    WHERE
      login_id = :login_id
  ";

  $params = array(
    ':login_id' => $login_id
  );
  $count_login_id = fetch_query($db, $sql, $params);
  return $count_login_id['count'];
}

// 作業員の総数を取得
function get_all_workers_amount($db){
  $sql = '
    SELECT
      COUNT(worker_id) as count
    FROM
      workers
  ';
  $all_workers_amount = fetch_query($db, $sql);
  return $all_workers_amount['count'];
}