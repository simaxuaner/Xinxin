<?php
/**
 * Created by PhpStorm.
 * User: yunjia
 * Date: 2016/4/5
 * Time: 16:18
 */

function goods_shelf_callback() {
    $build = "";
    $query = db_select('node', 'n')->extend('PagerDefault');
    $nids = $query
        ->fields('n', array('nid', 'created'))
        ->condition('type', 'goods_shelf')
        ->condition('status', 1)
        ->orderBy('created', 'DESC')
        ->limit(variable_get('default_nodes_main', 10))
        ->addTag('node_access')
        ->execute()
        ->fetchCol();

    if (!empty($nids)) {
        $shelves = node_load_multiple($nids);
        foreach($shelves as  $key => $value){
            $build .= "<div style=\"border:1px solid #999;padding:3px;\"><h3>货架名称：$value->title</h3>";
            $query1 = db_select('node', 'n')->extend('PagerDefault');
            $nids1 = $query1
                ->fields('n', array('nid', 'created'))
                ->condition('type', 'goods')
                ->condition('status', 1)
                ->orderBy('created', 'DESC')
                ->limit(variable_get('default_nodes_main', 10))
                ->addTag('node_access')
                ->execute()
                ->fetchCol();
            if (!empty($nids1)){
                $goods = node_load_multiple($nids1);
                foreach($goods as  $gkey => $gvalue){
                    $sid = $gvalue->field_box['und'][0]['target_id'];
                    if($sid==$value->vid&&$sid!=NULL){
                        $rows[$gkey]['title'] = "<a href='node/$gvalue->vid'>$gvalue->title</a>";
                        $rows[$gkey]['price'] = $gvalue->field_price['und'][0]['value'];
                        $rows[$gkey]['quantity'] = $gvalue->field_quantity['und'][0]['value'];
                        if($gvalue->status==0){
                            $rows[$gkey]['status'] = "未发布";
                        }else{
                            $rows[$gkey]['status'] = "已发布";
                        }
                        $rows[$gkey]['caozuo'] = "<a>下架</a>";
                    }
                }
                $header = array('商品名称','价格','库存','状态','操作');
                $table = theme('table', array('header' => $header,'rows' => $rows ,'attributes' => array('class' => array('private-table'))));
                $build .= "<br>".$table;
            }
            $rows = NULL;
            $table = NULL;
            $build .= "</div><br>";
        }
        return $build;
    }
    else {
        drupal_set_message(t('No goods entries have been created.'));
    }

}
