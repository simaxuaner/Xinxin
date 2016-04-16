<?php
/**
 * Created by IntelliJ IDEA.
 * User: lvljh
 * Date: 2016/4/10
 * Time: 14:32
 */

/**
 * Override or insert variables into the maintenance page template.
 */
function xinxin_front_preprocess_maintenance_page(&$vars) {
    // While markup for normal pages is split into page.tpl.php and html.tpl.php,
    // the markup for the maintenance page is all in the single
    // maintenance-page.tpl.php template. So, to have what's done in
    // readpeer_preprocess_html() also happen on the maintenance page, it has to be
    // called here.
    xinxin_front_preprocess_html($vars);
}


/**
* Override or insert variables into the html template.
*/
function xinxin_front_preprocess_html(&$vars) {

    // Get adminimal folder path.
    $xinxin_front = drupal_get_path('theme', 'xinxin_front');

    // Add default styles.
    drupal_add_css($xinxin_front . '/css/bootstrap.css', array('group' => CSS_THEME, 'media' => 'all', 'weight' => 1));
    drupal_add_css($xinxin_front . '/css/farm.css', array('group' => CSS_THEME, 'media' => 'all', 'weight' => 1));
    drupal_add_css($xinxin_front . '/css/products.css', array('group' => CSS_THEME, 'media' => 'all', 'weight' => 1));
    drupal_add_css($xinxin_front . '/css/styles_GUUS-LAPTOP_1.css', array('group' => CSS_THEME, 'media' => 'all', 'weight' => 1));
    drupal_add_css($xinxin_front . '/css/styles_GUUS-LAPTOP_2.css', array('group' => CSS_THEME, 'media' => 'all', 'weight' => 1));
    drupal_add_css($xinxin_front . '/css/styles_GUUS-LAPTOP_3.css', array('group' => CSS_THEME, 'media' => 'all', 'weight' => 1));
    drupal_add_css($xinxin_front . '/css/styles_GUUS-LAPTOP_4.css', array('group' => CSS_THEME, 'media' => 'all', 'weight' => 1));
    drupal_add_css($xinxin_front . '/css/styles_GUUS-LAPTOP_5.css', array('group' => CSS_THEME, 'media' => 'all', 'weight' => 1));
    drupal_add_css($xinxin_front . '/css/styles_GUUS-LAPTOP_6.css', array('group' => CSS_THEME, 'media' => 'all', 'weight' => 1));
    drupal_add_css($xinxin_front . '/css/xinxin.css', array('group' => CSS_THEME, 'media' => 'all', 'weight' => 1));

    drupal_add_js($xinxin_front . '/js/scripts.css');
    drupal_add_js($xinxin_front . '/js/scripts_GUUS-LAPTOP_1.js');
    drupal_add_js($xinxin_front . '/js/scripts_GUUS-LAPTOP_2.js');
    drupal_add_js($xinxin_front . '/js/scripts_GUUS-LAPTOP_3.js');

}

/**
 * Override or insert variables into the page template.
 */
function xinxin_front_preprocess_page(&$vars) {
    if (empty($vars['tabs']['#primary']) && empty($vars['tabs']['#secondary']))
        $vars['tabs'] = FALSE;

    if (isset($vars['main_menu'])) {
        $menu_links = '';
        foreach ( $vars['main_menu'] as $menu_item ) {
            $class = array();
            $class[] = 'xinxin-nav';
            global $language_url;
            if (isset($menu_item['href']) && ($menu_item['href'] == $_GET['q'] || ($menu_item['href'] == '<front>' && drupal_is_front_page())) && (empty($menu_item['language']) || $menu_item['language']->language == $language_url->language)) {
                $class[] = 'xinxin-active';
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
            $filepath = variable_get('user_picture_default', 'sites/all/themes/xinxin_front/images/avatar.jpg');
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
function xinxin_front_preprocess_block(&$vars) {
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
function xinxin_front_process_page(&$vars) {
    // Hook into color.module
    if (module_exists('color')) {
        _color_page_alter($vars);
    }
}

