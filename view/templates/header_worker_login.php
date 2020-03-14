<header>
  <nav class="navbar navbar-expand-sm navbar-light bg-light">
    <h1>名古屋市粗大ごみ回収サイト</h1>
    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#headerNav" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="ナビゲーションの切替">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="headerNav">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item">
          <a class="nav-link" href="<?php print h(WORKER_ASSIGNED_URL);?>">担当地域のごみ一覧</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php print h(WORKER_GARBAGES_URL);?>">すべてのごみ</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php print h(WORKER_LOGOUT_URL);?>">ログアウト</a>
        </li>
      </ul>
    </div>
  </nav>
  <div class="d-flex justify-content-between p-2">
    <p>※このサイトは本物ではありません。</p>
    <p class="text-right">ログイン中: <?php print h($worker['worker_name']);?>さん</p>
  </div>
</header>