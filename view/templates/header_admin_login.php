<header>
  <nav class="navbar navbar-expand-sm navbar-light bg-light">
    <h1>名古屋市粗大ごみ回収サイト</h1>
    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#headerNav" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="ナビゲーションの切替">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="headerNav">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item">
          <a class="nav-link" href="<?php print h(ADMIN_GARBAGES_URL);?>">ごみ一覧</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php print h(ADMIN_WORKERS_URL);?>">作業員一覧</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php print h(ADMIN_ADMIN_URL);?>">IDパスワード変更</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php print h(ADMIN_LOGOUT_URL);?>">ログアウト</a>
        </li>
      </ul>
    </div>
  </nav>
  <p>※このサイトは本物ではありません。</p>
</header>