<?php
if (!defined('DOKU_INC')) {
    die();
}
?>


<nav id="dokuwiki__pagetools">
    <div class="tools">

        <?php include('nav-status.php'); ?>
        <ul>
            <?php
            if (file_exists(DOKU_INC . '/inc/Menu/PageMenu.php')) {
                echo (new \dokuwiki\Menu\PageMenu())->getListItems();
            } else {
                //Pre-Greebo Backwards compatibility
                $data = dokuwiki\template\sprintdoc\tpl::assemblePageTools();

                foreach ($data['items'] as $k => $html) {
                    echo $html;
                }
            }
            ?>
        </ul>
    </div>
</nav>
