<?php
/**
 * Created by IntelliJ IDEA.
 * User: lvljh
 * Date: 2016/4/10
 * Time: 14:32
 */



/**
* Override or insert variables into the html template.
*/
function xinxin_front_preprocess_html(&$vars) {

    // Get adminimal folder path.
    $xinxin_front = drupal_get_path('theme', 'xinxin_front');

    // Add default styles.
    drupal_add_css($xinxin_front . '/css/style.css', array('group' => CSS_THEME, 'media' => 'all', 'weight' => 1));
    drupal_add_css($xinxin_front . '/css/styles_GUUS-LAPTOP_1.css', array('group' => CSS_THEME, 'media' => 'all', 'weight' => 1));
    drupal_add_css($xinxin_front . '/css/styles_GUUS-LAPTOP_2.css', array('group' => CSS_THEME, 'media' => 'all', 'weight' => 1));
    drupal_add_css($xinxin_front . '/css/styles_GUUS-LAPTOP_3.css', array('group' => CSS_THEME, 'media' => 'all', 'weight' => 1));
    drupal_add_css($xinxin_front . '/css/styles_GUUS-LAPTOP_4.css', array('group' => CSS_THEME, 'media' => 'all', 'weight' => 1));
    drupal_add_css($xinxin_front . '/css/styles_GUUS-LAPTOP_5.css', array('group' => CSS_THEME, 'media' => 'all', 'weight' => 1));
    drupal_add_css($xinxin_front . '/css/styles_GUUS-LAPTOP_6.css', array('group' => CSS_THEME, 'media' => 'all', 'weight' => 1));

}
?>
