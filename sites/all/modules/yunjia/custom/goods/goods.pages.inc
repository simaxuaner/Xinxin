<?php
/**
 * Created by PhpStorm.
 * User: yunjia
 * Date: 2016/3/27
 * Time: 16:18
 */

function goods_page_callback() {
    $query = db_select('node', 'n')->extend('PagerDefault');
    $nids = $query
        ->fields('n', array('nid', 'created'))
        ->condition('type', 'goods')
        ->orderBy('created', 'DESC')
        ->limit(variable_get('default_nodes_main', 10))
        ->addTag('node_access')
        ->execute()
        ->fetchCol();

    if (!empty($nids)) {
        $tables = node_load_multiple($nids);
        if(is_array($tables)){
            foreach($tables as $key => $value){
                $rows[$key]['title'] = $value->title;
                $rows[$key]['price'] = $value->field_price['und'][0]['value'];
                $rows[$key]['quantity'] = $value->field_quantity['und'][0]['value'];
                if($value->status==0){
                    $rows[$key]['status'] = "未发布";
                }else{
                    $rows[$key]['status'] = "已发布";
                }
                if($value->field_isput['und'][0]['value']==0){
                    $rows[$key]['isput'] = "未上架";
                }else{
                    $rows[$key]['isput'] = "已上架";
                }
                $rows[$key]['caozuo'] = "<a>上架</a>--<a>下架</a>--<a href='goodsinfo/$value->nid'>编辑</a>--<a onclick='goods_del($value->nid)'>删除</a>";
            }
            $header = array('商品名称','价格','库存','状态','是否上架','操作');
            $table = theme('table', array('header' => $header,'rows' => $rows ,'attributes' => array('class' => array('private-table'))));
            return $table;
        }else{
            return $tables;
        }
    }
    else {
        drupal_set_message(t('No goods entries have been created.'));
    }

}

function goods_del($nid){
    /*db_delete('node')
         ->condition('type', 'goods')
         ->condition('nid', $nid)
         ->execute();*/
}

function goods_put($nid){

}
