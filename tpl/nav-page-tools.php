<?php
    if (!defined('DOKU_INC')) die();
?>

<?php if ($showTools): ?>
    <nav id="dokuwiki__pagetools">

        <?php include('nav-status.php');?>
        <ul>
            <?php tpl_toolsevent('pagetools', array(
                'edit'      => tpl_action('edit', 1, 'li', 1),
                'revisions' => tpl_action('revisions', 1, 'li', 1),
                'backlink'  => tpl_action('backlink', 1, 'li', 1),
                'subscribe' => tpl_action('subscribe', 1, 'li', 1),
                'revert'    => tpl_action('revert', 1, 'li', 1),
                'top'       => tpl_action('top', 1, 'li', 1),
            )); ?>
        </ul>
    </nav>
<?php endif; ?>
