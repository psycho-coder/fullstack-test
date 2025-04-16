<?php if ($pager->getPageCount() > 1) { ?>
    <nav aria-label="Page navigation example">
        <ul class="pagination">
            <li class="page-item <?= 1 == $pager->getCurrentPage() ? 'disabled' : '' ?>"><a class="page-link" href="<?= $pager->getPreviousPageURI() ?>">Previous</a></li>
            
            <?php for ($page = 1; $page <= $pager->getPageCount(); $page++) : ?>
                <li class="page-item <?= $page == $pager->getCurrentPage() ? 'active' : '' ?>"><a class="page-link" href="<?= url_to('home') ?>?page=<?= $page ?>"><?= $page ?></a></li>
            <?php endfor; ?>
            
            <li class="page-item <?= $pager->getPageCount() == $pager->getCurrentPage() ? 'disabled' : '' ?>"><a class="page-link" href="<?= $pager->getNextPageURI() ?>">Next</a></li>
        </ul>
    </nav>
<?php } ?>