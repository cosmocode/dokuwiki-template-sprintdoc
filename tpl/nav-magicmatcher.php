<?php
    if (!defined('DOKU_INC')) die();
?>

                            <div id="dokuwiki_magic-matcher" class="magic-matcher no-print">
                                <div class="container">
                                    <?php
                                    $mm = plugin_load('helper', 'magicmatcher_context');
                                    if($mm){
                                        echo "<h6 class=\"sr-only\" role=\"heading\" aria-level=\"2\">".tpl_getLang('head_magic_matcher')."</h6>";
                                        echo PHP_EOL;
                                        $mm->tpl();
                                        echo PHP_EOL;
                                    }
                                    ?>
                                </div><!-- .container -->
                            </div><!-- .magic-matcher -->
