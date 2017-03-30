<!DOCTYPE html>
<?php
/**
 * DokuWiki Image Detail Page
 *
 * @author   Andreas Gohr <andi@splitbrain.org>
 * @author   Anika Henke <anika@selfthinker.org>
 * @license  GPL 2 (http://www.gnu.org/licenses/gpl.html)
 */

// must be run from within DokuWiki
if (!defined('DOKU_INC')) die();
header('X-UA-Compatible: IE=edge,chrome=1');

?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $conf['lang']?>"
 lang="<?php echo $conf['lang']?>" dir="<?php echo $lang['direction'] ?>" class="no-js">
<head>
    <meta charset="UTF-8" />
    <title>
        <?php echo hsc(tpl_img_getTag('IPTC.Headline',$IMG))?>
        [<?php echo strip_tags($conf['title'])?>]
    </title>
    <script>(function(H){H.className=H.className.replace(/\bno-js\b/,'js')})(document.documentElement)</script>
    <?php tpl_metaheaders()?>
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <?php echo tpl_favicon(array('favicon', 'mobile')) ?>
    <?php tpl_includeFile('meta.html') ?>
</head>

<body id="dokuwiki__top" class="<?php echo tpl_classes(); ?> wide-content showSidebar">
<div id="dokuwiki__site">
    <?php include('tpl/nav-direct.php') ?>


    <div class="page-wrapper <?php echo ($showSidebar) ? 'hasSidebar' : ''; ?>">
        <?php
        tpl_includeFile('header.html');
        ?>

        <div id="dokuwiki__header" class="header no-print">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="claim main-sidebar">
                            <?php if (tpl_getConf('logo') && file_exists(mediaFN(tpl_getConf('logo')))){

                                /* upload your logo into the data/media folder (root of the media manager) and replace 'logo.png' in der template config accordingly: */
                                include('tpl/main-sidebar-logo.php');
                            } ?>
                            <?php if ($conf['tagline']): ?>
                                <p class="claim"><?php echo $conf['tagline'] ?></p>
                            <?php endif ?>

                        </div><!-- .headings -->
                    </div><!-- .col -->
                </div><!-- .row -->
            </div><!-- .container -->
        </div><!-- .header -->

        <div class="sr-only nav-area-head">
            <h5 class="sr-only" aria-level="1"><?php echo tpl_getLang('nav-area-head') ?></h5>
        </div><!-- .nav-area-head -->

        <div class="tools">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">

                        <div class="sidebarheader main-sidebar">
                            <?php
                            tpl_includeFile('sidebarheader.html')
                            ?>
                        </div><!-- .sidebarheader -->

                        <div class="search main-sidebar">
                            <?php
                            include('tpl/main-sidebar-search.php');
                            ?>
                        </div><!-- .search -->

                        <div id="dokuwiki__aside">
                            <?php
                            include('tpl/main-sidebar-nav.php');
                            ?>
                        </div><!-- .aside -->

                    </div><!-- .col -->
                </div><!-- .row -->
            </div><!-- .container -->
        </div><!-- .tools -->

        <div class="top-header">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">

                        <?php
                        $showTools = true;
                        include('tpl/nav-usertools-buttons.php');
                        tpl_includeFile('header.html');
                        ?>

                    </div><!-- .col -->
                </div><!-- .row -->
            </div><!-- .container -->
        </div><!-- /top-header -->


        <div id="dokuwiki__detail">
        <?php html_msgarea() ?>

            <div class="content group">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="breadcrumbs" data-do="<?php echo $ACT?>">

                                <div class="togglelink page_main-content">
                                    <a href="#">&lt; &gt;<span class="sr-out"><?php echo tpl_getLang('a11y_sidebartoggle')?></span></a>
                                </div>

                                <h6 class="sr-only" role="heading" aria-level="2"><?php echo  tpl_getLang('head_menu_status')  ?></h6>

                                <?php

                                /* + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + */
                                /* page quality / page tasks */
                                /* + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + */
                                include('tpl/nav-page-quality-tasks.php');
                                ?>

                                <?php
                                /* + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + */
                                /* breadcrumb */
                                /* + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + */
                                include('tpl/nav-breadcrumb.php');
                                ?>

                                <h6 class="sr-only" role="heading" aria-level="2"><?php echo  $lang['page_tools']  ?></h6>

                                <?php


                                /**
                                 * FIXME implement proper pagetools as in https://www.dokuwiki.org/_detail/wiki:dokuwiki-128.png
                                 * after the new svg-page-tool mechanism has been merged into master
                                 *
                                 * see https://cosmocode.jira.com/browse/SPR-837
                                 */
                                include('tpl/nav-page-tools.php');
                                ?>

                            </div>
                            <div id="dokuwiki__content" class="page main-content">

                                <div id="spr__meta-box"></div>

        <?php if($ERROR): print $ERROR; ?>
        <?php else: ?>

            <?php if($REV) echo p_locale_xhtml('showrev');?>
            <h1><?php echo hsc(tpl_img_getTag('IPTC.Headline', $IMG))?></h1>


                <?php tpl_img(900, 700); /* the image; parameters: maximum width, maximum height (and more) */ ?>

                <div class="img_detail">
                    <h2><?php print nl2br(hsc(tpl_img_getTag('simple.title'))); ?></h2>

                    <?php if(function_exists('tpl_img_meta')): ?>
                        <?php tpl_img_meta(); ?>
                    <?php else: /* deprecated since Release 2014-05-05 */ ?>
                        <dl>
                            <?php
                                $config_files = getConfigFiles('mediameta');
                                foreach ($config_files as $config_file) {
                                    if(@file_exists($config_file)) {
                                        include($config_file);
                                    }
                                }

                                foreach($fields as $key => $tag){
                                    $t = array();
                                    if (!empty($tag[0])) {
                                        $t = array($tag[0]);
                                    }
                                    if(is_array($tag[3])) {
                                        $t = array_merge($t,$tag[3]);
                                    }
                                    $value = tpl_img_getTag($t);
                                    if ($value) {
                                        echo '<dt>'.$lang[$tag[1]].':</dt><dd>';
                                        if ($tag[2] == 'date') {
                                            echo dformat($value);
                                        } else {
                                            echo hsc($value);
                                        }
                                        echo '</dd>';
                                    }
                                }
                            ?>
                        </dl>
                    <?php endif; ?>
                    <?php //Comment in for Debug// dbg(tpl_img_getTag('Simple.Raw')); ?>
                </div>
            <p class="back">
                <?php tpl_action('mediaManager', 1) ?><br />
                &larr; <?php tpl_action('img_backto', 1) ?>
            </p>

                            </div><!-- .main-content -->
                        </div><!-- .col -->
                    </div><!-- .row -->
                </div><!-- .container -->
            </div><!-- /.content -->


        <?php endif; ?>
    </div>
    </div><!-- /wrapper -->



    <!-- ********** FOOTER ********** -->

    <div id="dokuwiki__footer">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">

                    <div class="main-footer">
                        <p>
                            <?php


                            /* + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + */
                            /* copyright */
                            /* + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + */
                            tpl_license($img = false, $imgonly = false, $return = false, $wrap = false);
                            ?>
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </div><!-- /footer -->


    <?php tpl_includeFile('footer.html') ?>
</div><!-- .dokuwiki__site -->

<div class="no"><?php tpl_indexerWebBug() /* provide DokuWiki housekeeping, required in all templates */ ?></div>

</body>
</html>
