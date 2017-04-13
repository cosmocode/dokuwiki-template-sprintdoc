<?php
    if (!defined('DOKU_INC')) die();
?>

<?php if ($showTools): ?>
    <nav id="dokuwiki__pagetools">
        <div class="tools">

        <?php include('nav-status.php');?>
            <ul>
                <?php
                $data = dokuwiki\template\sprintdoc\tpl::assemblePageTools();

                foreach ($data['items'] as $k => $html) {
                    echo $html;
                }



                ?>
            </ul>
        </div>
    </nav>
<?php endif; ?>
