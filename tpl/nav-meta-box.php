<?php
    if (!defined('DOKU_INC')) die();

?>
<div class="tab-container">
    <ul class="meta-tabs">

        <li><a href="#tab1" aria-expanded="false"><span class="prefix">Sitemap</span><span class="num"></span></a></li>
        <?php if ($tags !== null) { ?><li><a href="#tab2" aria-expanded="false"><span class="prefix">Tags</span><span class="num"></span></a></li><?php } ?>
        <li><a href="#tab3" aria-expanded="false"><span class="prefix">Jira</span><span class="num"></span></a></li>

    </ul>

    <div class="meta-content">
        <div class="box-content">
            <div id="tab1" class="tab-pane" aria-hidden="true">
                <?php  tpl_toc(); ?>
            </div>
            <?php if ($tags !== null) { ?>
                <div id="tab2" class="tab-pane" aria-hidden="true">
                    <?php $tags->tpl_tags(); ?>
                </div>
            <?php } ?>
            <div id="tab3" class="tab-pane" aria-hidden="true">

            </div>
        </div>
    </div>
</div>
