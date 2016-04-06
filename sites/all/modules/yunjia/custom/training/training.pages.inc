<?php
/**
 * Created by PhpStorm.
 * User: yunjia
 * Date: 2016/3/16
 * Time: 16:18
 */

function product_admin_page_callback() {
    global $user;
    $build = "";

    $query = db_select('node', 'n')->extend('PagerDefault');
    $nids = $query
        ->fields('n', array('nid', 'created'))
        ->condition('type', 'product')
        ->orderBy('created', 'DESC')
        ->limit(variable_get('default_nodes_main', 10))
        ->addTag('node_access')
        ->execute()
        ->fetchCol();

    if (!empty($nids)) {

        $nodes = node_load_multiple($nids);
        foreach($nodes as $nid => $node){
            $title = $node->title;
            $view = "<p>$title</p>";
            $build .= $view;
        }
    }
    else {
        drupal_set_message(t('No product entries have been created.'));
    }

    return $build;
}