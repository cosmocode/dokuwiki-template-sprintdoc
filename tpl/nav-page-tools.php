<?php
    if (!defined('DOKU_INC')) die();
?>

<?php if ($showTools): ?>
    <nav id="dokuwiki__pagetools">
        <div class="tools">

        <?php include('nav-status.php');?>
            <ul>
                <?php
                $data = array(
                    'view'  => 'main-svg',
                    'items' => array(
                            'edit'      => dokuwiki\template\sprintdoc\tpl::pageToolAction('edit'),
                            'revert'    => dokuwiki\template\sprintdoc\tpl::pageToolAction('revert'),
                            'revisions' => dokuwiki\template\sprintdoc\tpl::pageToolAction('revisions'),
                            'backlink'  => dokuwiki\template\sprintdoc\tpl::pageToolAction('backlink'),
                            'subscribe' => dokuwiki\template\sprintdoc\tpl::pageToolAction('subscribe'),
                            'top'       => dokuwiki\template\sprintdoc\tpl::pageToolAction('top'),
                         )
                     );

                     // the page tools can be amended through a custom plugin hook
                     $evt = new Doku_Event('TEMPLATE_PAGETOOLS_DISPLAY', $data);
                     if($evt->advise_before()){
                        foreach($evt->data['items'] as $k => $html) {
                            if($html)
                                echo "<li>$html</li>";
                        }
                     }
                     $evt->advise_after();
                     unset($data);
                ?>
            </ul>
        </div>
    </nav>
<?php endif; ?>
