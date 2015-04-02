<!DOCTYPE html>
<html class="<?php echo get_theme_option('Style Sheet'); ?>" lang="<?php echo get_html_lang(); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <?php if ($description = option('description')): ?>
    <meta name="description" content="<?php echo $description; ?>">
    <?php endif; ?>

    <?php
    if (isset($title)) {
        $titleParts[] = strip_formatting($title);
    }
    $titleParts[] = option('site_title');
    ?>
    <title><?php echo implode(' &middot; ', $titleParts); ?></title>

    <?php echo auto_discovery_link_tags(); ?>

    <!-- Plugin Stuff -->
    <?php fire_plugin_hook('public_head', array('view'=>$this)); ?>

    <!-- Stylesheets -->
    <?php
    queue_css_url('//fonts.googleapis.com/css?family=Ubuntu:300,400,500,700,300italic,400italic,500italic,700italic');
    queue_css_file(array('iconfonts', 'normalize', 'style', 'studens', 'lifeline'), 'screen');
    queue_css_file('print', 'print');
    echo head_css();
    ?>

    <!-- JavaScripts -->
    <?php queue_js_file('vendor/modernizr'); ?>
    <?php queue_js_file('vendor/selectivizr'); ?>
    <?php queue_js_file('jquery-extra-selectors'); ?>
    <?php queue_js_file('vendor/respond'); ?>
    <?php queue_js_file('globals'); ?>
    <?php echo head_js(); ?>
</head>
<?php echo body_tag(array('id' => @$bodyid, 'class' => @$bodyclass)); ?>

    <?php
        // Studen's header inclusion
        // require(WEB_ROOT.'/shared/header');
        // echo Zend_View_Helper_Partial->partial('shared/header.php'
//        $this->view->partial('shared/header.php');
    echo drawSharedHeader();
    ?>

    <div id="wrapper">
    <?php /*
        <div>
            <?php if($user = current_user()) {
                echo "connecté sur OMEKA";
            } else {
                echo "déconnecté de OMEKA";
            } ?>
        </div>
    */ ?>
    <?Php // echo search_form(); ?>
        

        <div id="wrap">
        
            <div id="content">
                <?php
                    if(! is_current_url(WEB_ROOT)) {
                      fire_plugin_hook('public_content_top', array('view'=>$this));
                    }
                ?>