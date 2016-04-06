<?php
/**
 * Created by PhpStorm.
 * User: yunjia
 * Date: 2016/3/27
 * Time: 22:08
 */

/*
 *定义表单
 */
function goodsInfo_form(){
    //文本框
    $form['name'] = array(
        '#type'=>'textfield',
        '#title'=>t('Goods Name'),
        '#description'=>t('please insert goods name'),
    );
    //提交按钮
    $form['submit']=array(
        '#type'=>'submit',
        '#value'=>t('Save'),
    );
    return $form;
}
/*
 * 表单验证
 */
function goodsInfo_form_validate($form_id,$form_values){
    if($form_values['name']==''){
        form_set_error('',t('You must input a name.'));
    }
}
/*
 * 处理表单
 */
function goodsInfo_form_submit($form_id,$form_values){
    drupal_get_message(t('Goods name is '.$form_values['name'])
    );
}

