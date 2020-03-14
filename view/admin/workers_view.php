<!DOCTYPE html>
<html lang="ja">

<head>
  <?php include VIEW_PATH . 'templates/head.php'; ?>
  <title>作業員一覧/名古屋市粗大ごみ</title>
</head>

<body>
  <?php include VIEW_PATH . 'templates/header_admin_login.php';?>

  <div class="container">
    <h1>作業員一覧</h1>
    <a class="btn btn-success mb-2" href="<?php print h(NEW_WORKER_URL) ?>">作業員新規登録</a>
    <?php include VIEW_PATH . 'templates/messages.php'; ?>

    <nav aria-label="Page Navigation">
      <ul class="pagination row text-center">
        <li class="col-1 p-0 page-item <?php if($current_page <= 1){ print h('disabled');}?>">
          <a  class="page-link" href="<?php print h(ADMIN_WORKERS_URL . '?current_page=' . ($current_page - 1)) ?>" aria-label="Previous Page">
            <span aria-hidden="true">&laquo;</span>
          </a>
        </li>
        <?php for ($i = 1; $i <= $total_pages_number; $i++){ ?>
        <li class="col-1 p-0 page-item <?php if($current_page === $i){ print h('active');}?>">
            <a class="page-link" href="<?php print h(ADMIN_WORKERS_URL . '?current_page=' . $i) ?>"><?php print h($i) ?></a>
          </li>
        <?php } ?>
        <li class="col-1 p-0 page-item <?php if($current_page >= $total_pages_number){ print h('disabled');}?>">
          <a href="<?php print h(ADMIN_WORKERS_URL . '?current_page=' . ($current_page + 1)) ?>"  class="page-link" aria-label="Next Page">
            <span aria-hidden="true">&raquo;</span>
          </a>
        </li>
      </ul>
    </nav>
    <p><?php print h($workers_count_text) ?></p>
    
    <?php if($all_workers_amount > 0){ ?>
      <?php foreach($workers as $worker){ ?>
        <div class="border" style="background-color: #d9edf7">
          <div class="row m-0 text-center">
            <div class="col-md-1 border"><?php print h($worker['worker_id']); ?></div>
            <div class="col-md-2 border"><?php print h($worker['login_id']); ?></div>
            <div class="col-md-2 border"><?php print h($worker['worker_name']); ?></div>
            <div class="form-group col-md-3 border m-0">
              <form method="post" action="worker_change_area.php" class="row">
                <select class="form-control col" name="area" id="area">
                  <option value="0" <?php if($worker['area'] === 0) { print h('selected');} ?>>千種区</option>
                  <option value="1" <?php if($worker['area'] === 1) { print h('selected');} ?>>東区</option>
                  <option value="2" <?php if($worker['area'] === 2) { print h('selected');} ?>>北区</option>
                  <option value="3" <?php if($worker['area'] === 3) { print h('selected');} ?>>西区</option>
                  <option value="4" <?php if($worker['area'] === 4) { print h('selected');} ?>>中村区</option>
                  <option value="5" <?php if($worker['area'] === 5) { print h('selected');} ?>>中区</option>
                  <option value="6" <?php if($worker['area'] === 6) { print h('selected');} ?>>昭和区</option>
                  <option value="7" <?php if($worker['area'] === 7) { print h('selected');} ?>>瑞穂区</option>
                  <option value="8" <?php if($worker['area'] === 8) { print h('selected');} ?>>熱田区</option>
                  <option value="9" <?php if($worker['area'] === 9) { print h('selected');} ?>>中川区</option>
                  <option value="10" <?php if($worker['area'] === 10) { print h('selected');} ?>>港区</option>
                  <option value="11" <?php if($worker['area'] === 11) { print h('selected');} ?>>名東区</option>
                  <option value="12" <?php if($worker['area'] === 12) { print h('selected');} ?>>天白区</option>
                </select>
                <input type="hidden" name="worker_id" value="<?php print h($worker['worker_id']); ?>">
                <input type="hidden" name="csrf_token" value="<?php print h($token); ?>">
                <input type="submit" value="変更" class="btn btn-secondary">
              </form>
            </div>
            <div class="col-md-3 border">
              <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#modal-<?php print h($worker['worker_id']); ?>">コメント記入</button>
            </div>
            
            <form method="post" action="worker_delete.php" class="col-md-1 p-0">
              <input type="hidden" name="csrf_token" value="<?php print h($token); ?>">
              <input type="hidden" name="worker_id" value="<?php print h($worker['worker_id']); ?>">
              <input type="submit" value="削除" class="btn btn-danger delete">
            </form>
          </div>

          <?php if(has_worker_comment($worker['comment']) === true){; ?>
              <div class="border p-1">
                <p><?php print h($worker['comment']); ?></p>
              </div>
          <?php } ?>
        </div>  

        <!-- コメント入力用モーダル -->
        <div class="modal fade" id="modal-<?php print h($worker['worker_id']); ?>" tabindex="-1">
          <div class="modal-dialog">
            <div class="modal-content">
              <form method="post" action="worker_change_comment.php" class="p-2">
                <p>コメント記入（200文字以内）</p>
                <div class="form-group">
                  <textarea class="form-control" type="text" name="comment" id="comment"><?php if (isset($worker['comment'])) {print h($worker['comment']);} ?></textarea>
                </div>
                <input type="submit" value="記入" class="btn btn-secondary">
                <input type="hidden" name="csrf_token" value="<?php print h($token); ?>">
                <input type="hidden" name="worker_id" value="<?php print h($worker['worker_id']); ?>">
              </form> 
            </div>
          </div>
        </div>
      <?php } ?>
    <?php } ?> 
  </div> 

  <script>
    $('.delete').on('click', () => confirm('本当に削除しますか？'))  
  </script>
</body>
</html>