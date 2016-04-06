<?php

/**
 * Override or insert variables into the maintenance page template.
 */
function xinxin_preprocess_maintenance_page(&$vars) {
  // While markup for normal pages is split into page.tpl.php and html.tpl.php,
  // the markup for the maintenance page is all in the single
  // maintenance-page.tpl.php template. So, to have what's done in
  // readpeer_preprocess_html() also happen on the maintenance page, it has to be
  // called here.
  readpeer_preprocess_html($vars);
}

/**
 * Override or insert variables into the html template.
 */
function xinxin_process_html(&$vars) {
  // Hook into color.module
  if (module_exists('color')) {
    _color_html_alter($vars);
  }
}

/**
 * Override or insert variables into the page template.
 */
function xinxin_preprocess_page(&$vars) {
  if (empty($vars['tabs']['#primary']) && empty($vars['tabs']['#secondary']))
	$vars['tabs'] = FALSE;
	
  if (isset($vars['main_menu'])) {
  	$menu_links = '';
  	foreach ( $vars['main_menu'] as $menu_item ) {
  		$class = array();
  		$class[] = 'rp-nav';
  		global $language_url;
  		if (isset($menu_item['href']) && ($menu_item['href'] == $_GET['q'] || ($menu_item['href'] == '<front>' && drupal_is_front_page())) && (empty($menu_item['language']) || $menu_item['language']->language == $language_url->language)) {
        	
  			$class[] = 'rp-active';
   		}
  		$menu_links .= '<li ' . drupal_attributes(array('class' => $class)) . '>' . l($menu_item['title'], $menu_item['href']) . '</li>';
  	}
    $vars['primary_nav'] = $menu_links;
  }
  else {
    $vars['primary_nav'] = FALSE;
  }
  if (isset($vars['secondary_menu'])) {
    $vars['secondary_nav'] = theme('links__system_secondary_menu', array(
      'links' => $vars['secondary_menu'],
      'attributes' => array(
        'class' => array('dropdown-menu'),
      ),
    ));
  }
  else {
    $vars['secondary_nav'] = FALSE;
  }

  $vars['search_form'] = FALSE;
  if ( isset($vars['page']['header']) && isset($vars['page']['header']['search_form']) ) {
  	if (isset($vars['page']['header']['search_form'])) {
	  	$vars['search_form'] = $vars['page']['header']['search_form'];
	  	$vars['search_form']['actions']['submit']['#value'] = '';
  	}
  	$vars['page']['header'] = FALSE;
  }
  
  if ($vars['logged_in']) {
    $user = user_load($vars['user']->uid);
    $alt = t("@user's picture", array('@user' => format_username($user)));
    $style = variable_get('user_picture_style', 'thumbnail');
    $filepath = '';
    if ($user->picture){
      $filepath = $user->picture->uri;
    }
    else{
      $filepath = variable_get('user_picture_default', 'sites/all/themes/readpeer/images/avatar.png');
    }
  	if (module_exists('image') && file_valid_uri($filepath) ) {
        $vars['user_avatar'] = theme('image_style', array('style_name' => $style, 'path' => $filepath, 'alt' => $alt, 'title' => $alt));
    }
    else {
        $vars['user_avatar'] = theme('image', array('path' => $filepath, 'alt' => $alt, 'title' => $alt));
    }
  }
}

/**
 * Override or insert variables into the block template.
 */
function xinxin_preprocess_block(&$vars) {
  // In the header region visually hide block titles.
  if ($vars['block']->region == 'header') {
    $vars['title_attributes_array']['class'][] = 'element-invisible';
  }
  $vars['title_attributes_array']['class'][] = 'title';
  $vars['classes_array'][] = 'clearfix';
}

/**
 * Override or insert variables into the page template.
 */
function xinxin_process_page(&$vars) {
  // Hook into color.module
  if (module_exists('color')) {
    _color_page_alter($vars);
  }
}