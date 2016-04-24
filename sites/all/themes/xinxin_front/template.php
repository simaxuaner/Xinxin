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
function xinxin_front_preprocess_maintenance_page(&$vars)
{
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
function xinxin_front_preprocess_html(&$vars)
{

    // Get adminimal folder path.
    $xinxin_front = drupal_get_path('theme', 'xinxin_front');

    // Add default styles.
    drupal_add_css($xinxin_front . '/css/styles.css', array('group' => CSS_THEME, 'media' => 'all', 'weight' => 1));
//    drupal_add_css($xinxin_front . '/css/menu.css', array('group' => CSS_THEME, 'media' => 'all', 'weight' => 1));
    drupal_add_css($xinxin_front . '/css/member.css', array('group' => CSS_THEME, 'media' => 'all', 'weight' => 1));

    drupal_add_js($xinxin_front . '/js/scripts.js');

}

function menu_sort_weights($link1, $link2) {
    return $link1['link']['weight'] < $link2['link']['weight'] ? 1 : 0;
}

/**
 * Override or insert variables into the page template.
 */
function xinxin_front_preprocess_page(&$vars)
{
    if (empty($vars['tabs']['#primary']) && empty($vars['tabs']['#secondary']))
        $vars['tabs'] = FALSE;

    if (isset($vars['main_menu'])) {
        $sql = "SELECT m.load_functions, m.to_arg_functions, m.access_callback, m.access_arguments, m.page_callback, m.page_arguments, m.delivery_callback, m.title, m.title_callback, m.title_arguments, m.type, m.description, ml.*
    			FROM {menu_links} ml LEFT JOIN {menu_router} m ON m.path = ml.router_path
    			WHERE ml.menu_name = :menu
    			ORDER BY p1 ASC, p2 ASC, p3 ASC, p4 ASC, p5 ASC, p6 ASC, p7 ASC, p8 ASC, p9 ASC";
        $result = db_query($sql, array(':menu' => 'main-menu'), array('fetch' => PDO::FETCH_ASSOC));
        $links = array();
        foreach ($result as $item) {
            $links[] = $item;
        }
        $tree = menu_tree_data($links);
        uasort($tree, "menu_sort_weights");
        $menu_links = '';
        foreach ($tree as $menu_item) {
            if(!empty($menu_item['link']['title'])) {
                $menu_links .= '<li><a href="' . url($menu_item['link']['link_path']) . '">' . $menu_item['link']['title'] . '</a>';
                $sublink = $menu_item['below'];
                $menu_links .= '<ul>';
                foreach ($sublink as $sublinkitem) {
                    $menu_links .= '<li><a href="?q=' . $sublinkitem['link']['link_path'] . '">' . $sublinkitem['link']['title'] . '</a></li>';
                }
                $menu_links .= '</ul></li>';
            }
        }
        $vars['primary_nav'] = $menu_links;
    } else {
        $vars['primary_nav'] = FALSE;
    }
    if (isset($vars['secondary_menu'])) {
        $vars['secondary_nav'] = theme('links__system_secondary_menu', array(
            'links' => $vars['secondary_menu'],
            'attributes' => array(
                'class' => array('dropdown-menu'),
            ),
        ));
    } else {
        $vars['secondary_nav'] = FALSE;
    }

    $vars['search_form'] = FALSE;
    if (isset($vars['page']['header']) && isset($vars['page']['header']['search_form'])) {
        if (isset($vars['page']['header']['search_form'])) {
            $vars['search_form'] = $vars['page']['header']['search_form'];
            $vars['search_form']['actions']['submit']['#value'] = '';
        }
        $vars['page']['header'] = FALSE;
    }
}

/**
 * Override or insert variables into the block template.
 */
function xinxin_front_preprocess_block(&$vars)
{
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
function xinxin_front_process_page(&$vars)
{
    // Hook into color.module
    if (module_exists('color')) {
        _color_page_alter($vars);
    }
}

