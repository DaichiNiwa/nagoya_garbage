<!DOCTYPE html>
<html lang="ja">

<head>
  <?php include VIEW_PATH . 'templates/head.php'; ?>
  <title>ごみ一覧/名古屋市粗大ごみ</title>
</head>

<body>
  <?php include VIEW_PATH . 'templates/header_worker_login.php';?>

  <div class="container">
    <h1>ごみ一覧（作業員用）</h1>
    <?php include VIEW_PATH . 'templates/messages.php'; ?>

    <h2 class="border-bottom border-primary">検索</h2>
    <p class="m-0">ごみのステータスと区を指定して検索</p>
    <form method="post" action="garbage_search.php" class="row">
      <select class="form-control col-4 m-2" name="status" id="status">
        <option value="">選択なし</option>
        <option value="0">未回収</option>
        <option value="1">回収済</option>
        <option value="2">回収前保留</option>
        <option value="3">回収後保留</option>
        <option value="4">回収不可</option>
      </select>
      <select class="form-control col-4 m-2" name="area" id="area">
          <option value="">選択なし</option>
          <option value="0">千種区</option>
          <option value="1">東区</option>
          <option value="2">北区</option>
          <option value="3">西区</option>
          <option value="4">中村区</option>
          <option value="5">中区</option>
          <option value="6">昭和区</option>
          <option value="7">瑞穂区</option>
          <option value="8">熱田区</option>
          <option value="9">中川区</option>
          <option value="10">港区</option>
          <option value="11">名東区</option>
          <option value="12">天白区</option>
      </select>
      <input type="hidden" name="csrf_token" value="<?php print h($token); ?>">
      <input type="submit" value="条件を指定して検索" class="btn btn-warning col-3 m-2">
    </form>

    <form method="post" action="garbage_select_user.php" class="">
      <div class="form-group row">
        <label for="username" class="col-4 m-2 text-center">ユーザの氏名で検索</label>
        <input class="form-control col-4 m-2" type="text" name="username" id="username" placeholder="例：田中太郎, 田中">
        <input type="hidden" name="csrf_token" value="<?php print h($token); ?>">
        <input type="submit" value="氏名を指定して検索" class="btn btn-success col-3 m-2">
      </div>
    </form>

    <h2 class="border-bottom border-primary">すべてのごみ</h2>
    <nav aria-label="Page Navigation">
      <ul class="pagination row text-center">
        <li class="col-1 p-0 page-item <?php if($current_page <= 1){ print h('disabled');}?>">
          <a  class="page-link" href="<?php print h(WORKER_GARBAGES_URL . '?current_page=' . ($current_page - 1)) ?>" aria-label="Previous Page">
            <span aria-hidden="true">&laquo;</span>
          </a>
        </li>
        <?php for($i = 1; $i <= $total_pages_number; $i++){ ?>
          <li class="col-1 p-0 page-item <?php if($current_page === $i){ print h('active');}?>">
            <a class="page-link" href="<?php print h(WORKER_GARBAGES_URL . '?current_page=' . $i) ?>"><?php print h($i) ?></a>
          </li>
        <?php } ?>
        <li class="col-1 p-0 page-item <?php if($current_page >= $total_pages_number){ print h('disabled');}?>">
          <a href="<?php print h(WORKER_GARBAGES_URL . '?current_page=' . ($current_page + 1)) ?>"  class="page-link" aria-label="Next Page">
            <span aria-hidden="true">&raquo;</span>
          </a>
        </li>
      </ul>
    </nav>
    <p><?php print h($garbages_count_text) ?></p>

    <?php if($all_garbages_amount > 0){ ?>
      <div class="text-center">
        <?php foreach($garbages as $garbage){ ?>
          <div class="border border-primary" style="background-color: <?php print h($garbage['bg_color']); ?>;">
          
            <div class="row m-0">
              <div class="col-md-2 border"><?php print h($garbage['garbage_id']); ?></div>
              <div class="col-md-2 border"><?php print h($garbage['type']); ?></div>
              <div class="form-group col-md-3 border m-0">
                <form method="post" action="garbage_change_status.php" class="row">
                  <select class="form-control col" name="status" id="status">
                    <option value="0" <?php if($garbage['status'] === '0') { print h('selected');} ?>>未回収</option>
                    <option value="1" <?php if($garbage['status'] === '1') { print h('selected');} ?>>回収済</option>
                    <option value="2" <?php if($garbage['status'] === '2') { print h('selected');} ?>>回収前保留</option>
                    <option value="3" <?php if($garbage['status'] === '3') { print h('selected');} ?>>回収後保留</option>
                    <option value="4" <?php if($garbage['status'] === '4') { print h('selected');} ?>>回収不可</option>
                  </select>
                  <input type="hidden" name="garbage_id" value="<?php print h($garbage['garbage_id']); ?>">
                  <input type="hidden" name="csrf_token" value="<?php print h($token); ?>">
                  <input type="submit" value="変更" class="btn mb-0 btn-secondary">
                </form>
              </div>
              <div class="col-md-3 border">
                <form method="post" action="garbage_change_status.php">
                  <input type="hidden" name="status" value="1">
                  <input type="hidden" name="garbage_id" value="<?php print h($garbage['garbage_id']); ?>">
                  <input type="hidden" name="csrf_token" value="<?php print h($token); ?>">
                  <input type="submit" value="回収済に変更" class="btn mb-0 btn-info">
                </form>
              </div>
              <div class="col-md-2 border">
                <button type="button" class="btn mb-0 btn-success" data-toggle="popover" data-html="true" data-content="
                  <?php print h($garbage['username'] . '<br/>' . $garbage['phone_number'] . '<br/>' . $garbage['email']);?>"
                data-placement="top">詳細</button>
              </div>
            </div>
            
            <div class="row m-0">
              <div class="col-md-2 border"><?php print h($garbage['area']); ?></div>
              <div class="col-md-10 border"><?php print h($garbage['address']); ?></div>
            </div>
            
            <div class="row m-0">
              <div class="col-md-4 border">回収: <?php print h($garbage['collect_day']); ?></div>
              <div class="col-md-5 border">担当者: <?php print h($garbage['worker_name']); ?></div>
              <div class="col-md-3 border">
                <button type="button" class="btn mb-0 btn-warning" data-toggle="modal" data-target="#modal-<?php print h($garbage['garbage_id']); ?>">コメント記入</button>
              </div>
            </div>

            <?php if(has_comment($garbage['user_comment'], $garbage['admin_comment'], $garbage['worker_comment']) === true){; ?>
              <div class="row m-0">
                <div class="col-md-4 border">
                  <p class="border-bottom">ユーザコメント</p>
                  <?php print h($garbage['user_comment']); ?>
                </div>
                <div class="col-md-4 border">
                  <p class="border-bottom">管理者コメント</p>
                  <?php print h($garbage['admin_comment']); ?>
                </div>
                <div class="col-md-4 border">
                  <p class="border-bottom">作業員コメント</p>
                  <?php print h($garbage['worker_comment']); ?>
                </div>
              </div>
            <?php } ?>
          </div>

          <!-- コメント入力用モーダル -->
          <div class="modal fade" id="modal-<?php print h($garbage['garbage_id']); ?>" tabindex="-1">
            <div class="modal-dialog">
              <div class="modal-content">
                <form method="post" action="garbage_change_comment.php" class="p-2">
                  <p>コメント記入（200文字以内）</p>
                  <div class="form-group">
                    <textarea class="form-control" type="text" name="comment" id="comment"><?php if (isset($garbage['worker_comment'])) {print h($garbage['worker_comment']);} ?></textarea>
                  </div>
                  <input type="submit" value="記入" class="btn mb-0 btn-secondary">
                  <input type="hidden" name="csrf_token" value="<?php print h($token); ?>">
                  <input type="hidden" name="garbage_id" value="<?php print h($garbage['garbage_id']); ?>">
                </form> 
              </div>
            </div>
          </div>
        <?php } ?>
      </div>
    <?php } ?> 
  </div> 

  <script>
    $('[data-toggle="popover"]').popover()
  </script>
</body>
</html>