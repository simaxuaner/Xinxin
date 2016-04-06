<?php
/**
 * Created by PhpStorm.
 * User: yunjia
 * Date: 2016/3/27
 * Time: 16:18
 */
/*
* 显示产品详细信息的form
*/
function goods_show_form($gid='')
{
    return drupal_get_form("goodsInfo_form",$gid);
}

/*
*定义表单
*/
function goodsInfo_form($form_state, $args='')
{
    $gid = $args['build_info']['args'][0];
    drupal_set_message(t('Goods id is ' .$gid));
    $result = db_select('node', 'n')
        ->fields('n')
        ->condition('type', 'goods') // 类型为goods
        ->condition('nid',$gid)  //nid等于gid的条件
        ->execute()
        ->fetchAssoc();
    $good = node_load($result['nid']);
    //产品ID
    $form['nid'] = array(
        '#type' => 'hidden',
        '#title' => t('产品ID'),
       '#default_value'=>$good->nid,
//'#description'=>t('please insert goods name'),
    );
    //产品名称
    $form['title'] = array(
        '#type' => 'textfield',
        '#title' => t('产品名称'),
       '#default_value'=>$good->title,
//'#description'=>t('please insert goods name'),
    );
    //价格
    $form['price'] = array(
        '#type' => 'textfield',
        '#title' => t('产品价格'),
       '#default_value'=>$good->field_price['und'][0]['value'],
//'#description'=>t('please insert goods name'),
    );
    //库存
    $form['quantity'] = array(
        '#type' => 'textfield',
        '#title' => t('产品库存'),
       '#default_value'=>$good->field_quantity['und'][0]['value'],
    //'#description'=>t('please insert goods name'),
    );
    //图片
    $form['image'] = array(
        '#type' => 'file',
        '#title' => t('产品图片'),
        //'#description'=>t('please insert goods name'),
    );
    //产品详细描述
    $form['description'] = array(
        '#type' => 'textarea',
        '#title' => t('产品的详细描述'),
       '#default_value'=>$good->field_description['und'][0]['value'],
        //'#description'=>t('please insert goods name'),
    );
    //上下架
    $form['select'] = array(
        '#type' => 'radios',
        '#title' => '上下架',
        '#default_value' =>  $good->status,
        '#options' => array('下架', '上架'),//单选项，若不指定值，则自动从0开始计算: 0 -> 下架， 1 -> 上架。
    );
    //提交按钮
    $form['submit'] = array(
        '#type' => 'submit',
        '#value' => t('Save'),
    );
    return $form;
}

/*
* 表单验证
*/
function goodsInfo_form_validate($form_id, $form_values)
{
   /* if ($form_values['name'] == '') {
        form_set_error('', t('You must input a name.'));
    }*/
}

/*
* 处理表单
*/
function goodsInfo_form_submit($form_id, $form_values)
{
    /*foreach($form_values['values'] as $key => $value)
    {
        drupal_set_message(t('Goods id is ' .$key.'--'.$value));
    }*/

    /*db_update('node')
        ->condition('type', 'goods')
        ->condition('nid', $form_values['values']['nid'])
        ->fields(array('title' => $form_values['values']['title']))
        ->execute();*/
}