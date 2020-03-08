<nav aria-label="Page Navigation">
	<ul class="pagination">
    <li class="page-item disabled">
			<a  class="page-link" href="#" aria-label="Previous Page">
				<span aria-hidden="true">&laquo;</span>
			</a>
		</li>
    <li class="page-item active"><a class="page-link" href="#">1</a></li>
    <li class="page-item"><a class="page-link" href="#">2</a></li>
    <li class="page-item"><a class="page-link" href="#">3</a></li>
    <li class="page-item"><a class="page-link" href="#">4</a></li>
    <li class="page-item"><a class="page-link" href="#">5</a></li>
    <li class="page-item">
			<a href="#"  class="page-link" aria-label="Next Page">
				<span aria-hidden="true">&raquo;</span>
			</a>
		</li>
	</ul>
</nav>


<nav aria-label="Page Navigation">
	<ul class="pagination">
		<li class="page-item <?php if($current_page <= 1){ print h('disabled');?>">
			<a  class="page-link" href="<?php print h(ADMIN_GARBAGES_URL . '?=' . $current_page - 1) ?>" aria-label="Previous Page">
				<span aria-hidden="true">&laquo;</span>
			</a>
		</li>
		<?php for ($i = 1; $i <= $total_pages_number; $i++){ ?>
			<li class="page-item <?php if($current_page === $i){ print h('active');?>">
				<a class="page-link" href="<?php print h(ADMIN_GARBAGES_URL . '?=' . $current_page) ?>"><?php print h($i) ?></a>
			</li>
		<?php } ?>
		<li class="page-item <?php if($current_page >= $total_pages_number){ print h('disabled');?>">
			<a href="<?php print h(ADMIN_GARBAGES_URL . '?=' . $current_page + 1) ?>"  class="page-link" aria-label="Next Page">
				<span aria-hidden="true">&raquo;</span>
			</a>
		</li>
	</ul>
</nav>
<p><?php print h($garbages_count_text) ?></p>