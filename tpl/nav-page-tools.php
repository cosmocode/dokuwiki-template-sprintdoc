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


                foreach ($data['items'] as $k => $html) {
                    if ($html) {
                        echo "<li>$html</li>";
                    }
                }

                /**
                 * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
                 * Begin shims as a temporary solution until the svg-approach is mainlined and the plugins have adapted
                 * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
                 */
                global $ACT;
                if (act_clean($ACT) === 'show') {
                    /** @var action_plugin_move_rename $move */
                    $move = plugin_load('action', 'move_rename');
                    if ($move && $move->getConf('pagetools_integration')) {
                        $attr = array(
                            'style' => 'background-image: none;',
                        );
                        $item = \dokuwiki\template\sprintdoc\tpl::pageToolItem('', $move->getLang('renamepage'), __DIR__ . '/../images/tools/41-format-paint.svg', $attr);
                        echo '<li class="plugin_move_page">' . $item . '</li>';
                    }

                    /** @var action_plugin_odt_export $odt */
                    $odt = plugin_load('action', 'odt_export');
                    if ($odt && $odt->getConf('showexportbutton')) {
                        global $ID, $REV;
                        $params = array('do' => 'export_odt');
                        if ($REV) {
                            $params['rev'] = $REV;
                        }
                        $attr = array(
                            'class' => 'action export_pdf',
                            'style' => 'background-image: none;',
                        );
                        $svg = __DIR__ . '/../images/tools/FIXME';
                        $item = \dokuwiki\template\sprintdoc\tpl::pageToolItem(wl($ID, $params), $odt->getLang('export_odt_button'), $svg, $attr);
                        echo '<li>' . $item . '</li>';
                    }

                    /** @var action_plugin_dw2pdf $dw2pdf */
                    $dw2pdf = plugin_load('action', 'dw2pdf');
                    if ($dw2pdf && $dw2pdf->getConf('showexportbutton')) {
                        global $ID, $REV;

                        $params = array('do' => 'export_pdf');
                        if ($REV) {
                            $params['rev'] = $REV;
                        }
                        $attr = array(
                            'class' => 'action export_pdf',
                            'style' => 'background-image: none;',
                        );
                        $svg = __DIR__ . '/../images/tools/40-pdf-file.svg';
                        $item = \dokuwiki\template\sprintdoc\tpl::pageToolItem(wl($ID, $params), $dw2pdf->getLang('export_pdf_button'), $svg, $attr);
                        echo '<li>' . $item . '</li>';
                    }
                }
                /**
                 * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
                 * End of shims
                 * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
                 */

                ?>
            </ul>
        </div>
    </nav>
<?php endif; ?>
