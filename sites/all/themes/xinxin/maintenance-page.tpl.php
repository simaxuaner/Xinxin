<?php

/**
 * @file
 * Override of the default maintenance page.
 *
 * This is an override of the default maintenance page. Used for eBook Annotation and
 * Minnelli, this file should not be moved or modified since the installation
 * and update pages depend on this file.
 *
 * This mirrors closely page.tpl.php for eBook Annotation in order to share the same
 * styles.
 */
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php print $language->language ?>" lang="<?php print $language->language ?>" dir="<?php print $language->dir ?>">
  <head>
    <title><?php print $head_title ?></title>
    <?php print $head ?>
    <?php print $styles ?>
    <?php print $scripts ?>
  </head>
  <body class="<?php print $classes ?>">

<!-- Layout -->
  <div id="header-region" class="clearfix"><?php print $header; ?></div>

    <div id="wrapper">
    <div id="container" class="clearfix">

      <div id="header">
        <div id="logo-floater">
        <?php
          // Prepare header
          $site_fields = array();
          if ($site_name) {
            $site_fields[] = $site_name;
          }
          if ($site_slogan) {
            $site_fields[] = $site_slogan;
          }
          $site_title = implode(' ', $site_fields);
          if ($site_fields) {
            $site_fields[0] = '<span>' . $site_fields[0] . '</span>';
          }
          $site_html = implode(' ', $site_fields);

          if ($logo || $site_title) {
            print '<h1 id="branding"><a href="' . $base_path . '" title="' . $site_title . '">';
            if ($logo) {
              print '<img src="' . $logo . '" alt="' . $site_title . '" id="logo" />';
            }
            print $site_html . '</a></h1>';
          }
        ?>
        </div>

      </div> <!-- /header -->

      <div id="center"><div id="squeeze"><div class="right-corner"><div class="left-corner">
          <?php if ($title): ?><h2><?php print $title ?></h2><?php endif; ?>
          <?php print $messages; ?>
          <div class="clearfix">
            <?php print $content ?>
          </div>
      </div></div></div></div> <!-- /.left-corner, /.right-corner, /#squeeze, /#center -->

    </div> <!-- /container -->
    <div id="footer">
	    <div class="container">
	      <div class="address">
	        � 2016 Xinxin
	        <div class="pull-right">
	          <a href="">About Us</a> �
	          <a href="">Terms and Conditions</a> 
	        </div>
	      </div>
	    </div>
	</div> <!-- /#footer -->
  </div>
<!-- /layout -->

  </body>
</html>
