<?php

/**
 * @file
 * Content administration and module settings UI.
 */

/**
 * Menu callback: confirm rebuilding of permissions.
 *
 * @see node_configure_rebuild_confirm_submit()
 * @see node_menu()
 * @ingroup forms
 */
function node_configure_rebuild_confirm() {
    return confirm_form(array(), t('Are you sure you want to rebuild the permissions on site content?'),
        'admin/reports/status', t('This action rebuilds all permissions on site content, and may be a lengthy process. This action cannot be undone.'), t('Rebuild permissions'), t('Cancel'));
}

/**
 * Handler for wipe confirmation
 *
 * @see node_configure_rebuild_confirm()
 */
function node_configure_rebuild_confirm_submit($form, &$form_state) {
    node_access_rebuild(TRUE);
    $form_state['redirect'] = 'admin/reports/status';
}

/**
 * Implements hook_node_operations().
 */
function node_node_operations() {
    $operations = array(
        'publish' => array(
            'label' => t('Publish selected content'),
            'callback' => 'node_mass_update',
            'callback arguments' => array('updates' => array('status' => NODE_PUBLISHED)),
        ),
        'unpublish' => array(
            'label' => t('Unpublish selected content'),
            'callback' => 'node_mass_update',
            'callback arguments' => array('updates' => array('status' => NODE_NOT_PUBLISHED)),
        ),
        'promote' => array(
            'label' => t('Promote selected content to front page'),
            'callback' => 'node_mass_update',
            'callback arguments' => array('updates' => array('status' => NODE_PUBLISHED, 'promote' => NODE_PROMOTED)),
        ),
        'demote' => array(
            'label' => t('Demote selected content from front page'),
            'callback' => 'node_mass_update',
            'callback arguments' => array('updates' => array('promote' => NODE_NOT_PROMOTED)),
        ),
        'sticky' => array(
            'label' => t('Make selected content sticky'),
            'callback' => 'node_mass_update',
            'callback arguments' => array('updates' => array('status' => NODE_PUBLISHED, 'sticky' => NODE_STICKY)),
        ),
        'unsticky' => array(
            'label' => t('Make selected content not sticky'),
            'callback' => 'node_mass_update',
            'callback arguments' => array('updates' => array('sticky' => NODE_NOT_STICKY)),
        ),
        'delete' => array(
            'label' => t('Delete selected content'),
            'callback' => NULL,
        ),
    );
    return $operations;
}

/**
 * List node administration filters that can be applied.
 *
 * @return
 *   An associative array of filters.
 */
function node_filters() {
    // Regular filters
    $filters['status'] = array(
        'title' => t('status'),
        'options' => array(
            '[any]' => t('any'),
            'status-1' => t('published'),
            'status-0' => t('not published'),
            'promote-1' => t('promoted'),
            'promote-0' => t('not promoted'),
            'sticky-1' => t('sticky'),
            'sticky-0' => t('not sticky'),
        ),
    );
    // Include translation states if we have this module enabled
    if (module_exists('translation')) {
        $filters['status']['options'] += array(
            'translate-0' => t('Up to date translation'),
            'translate-1' => t('Outdated translation'),
        );
    }

    //删除掉节点类型过滤选项
    /*$filters['type'] = array(
        'title' => t('type'),
        'options' => array(
                '[any]' => t('any'),
            ) + node_type_get_names(),
    );*/

    //删除掉语言过滤选项
    // Language filter if there is a list of languages
    /*if ($languages = module_invoke('locale', 'language_list')) {
        $languages = array(LANGUAGE_NONE => t('Language neutral')) + $languages;
        $filters['language'] = array(
            'title' => t('language'),
            'options' => array(
                    '[any]' => t('any'),
                ) + $languages,
        );
    }*/
    return $filters;
}

/**
 * Applies filters for node administration filters based on session.
 *
 * @param $query
 *   A SelectQuery to which the filters should be applied.
 */
function node_build_filter_query(SelectQueryInterface $query) {
    // Build query
    $filter_data = isset($_SESSION['node_overview_filter']) ? $_SESSION['node_overview_filter'] : array();
    foreach ($filter_data as $index => $filter) {
        list($key, $value) = $filter;
        switch ($key) {
            case 'status':
                // Note: no exploitable hole as $key/$value have already been checked when submitted
                list($key, $value) = explode('-', $value, 2);
            case 'type':
            case 'language':
                $query->condition('n.' . $key, $value);
                break;
        }
    }
}

/**
 * Returns the node administration filters form array to node_admin_content().
 *
 * @see node_admin_nodes()
 * @see node_admin_nodes_submit()
 * @see node_admin_nodes_validate()
 * @see node_filter_form_submit()
 * @see node_multiple_delete_confirm()
 * @see node_multiple_delete_confirm_submit()
 *
 * @ingroup forms
 */
function node_filter_form() {
    $session = isset($_SESSION['node_overview_filter']) ? $_SESSION['node_overview_filter'] : array();
    $filters = node_filters();

    $i = 0;
    $form['filters'] = array(
        '#type' => 'fieldset',
        '#title' => t('Show only items where'),
        '#theme' => 'exposed_filters__node',
    );
    foreach ($session as $filter) {
        list($type, $value) = $filter;
        if ($type == 'term') {
            // Load term name from DB rather than search and parse options array.
            $value = module_invoke('taxonomy', 'term_load', $value);
            $value = $value->name;
        }
        elseif ($type == 'language') {
            $value = $value == LANGUAGE_NONE ? t('Language neutral') : module_invoke('locale', 'language_name', $value);
        }
        else {
            $value = $filters[$type]['options'][$value];
        }
        $t_args = array('%property' => $filters[$type]['title'], '%value' => $value);
        if ($i++) {
            $form['filters']['current'][] = array('#markup' => t('and where %property is %value', $t_args));
        }
        else {
            $form['filters']['current'][] = array('#markup' => t('where %property is %value', $t_args));
        }
        if (in_array($type, array('type', 'language'))) {
            // Remove the option if it is already being filtered on.
            unset($filters[$type]);
        }
    }

    $form['filters']['status'] = array(
        '#type' => 'container',
        '#attributes' => array('class' => array('clearfix')),
        '#prefix' => ($i ? '<div class="additional-filters">' . t('and where') . '</div>' : ''),
    );
    $form['filters']['status']['filters'] = array(
        '#type' => 'container',
        '#attributes' => array('class' => array('filters')),
    );
    foreach ($filters as $key => $filter) {
        $form['filters']['status']['filters'][$key] = array(
            '#type' => 'select',
            '#options' => $filter['options'],
            '#title' => $filter['title'],
            '#default_value' => '[any]',
        );
    }

    $form['filters']['status']['actions'] = array(
        '#type' => 'actions',
        '#attributes' => array('class' => array('container-inline')),
    );
    $form['filters']['status']['actions']['submit'] = array(
        '#type' => 'submit',
        '#value' => count($session) ? t('Refine') : t('Filter'),
    );
    if (count($session)) {
        $form['filters']['status']['actions']['undo'] = array('#type' => 'submit', '#value' => t('Undo'));
        $form['filters']['status']['actions']['reset'] = array('#type' => 'submit', '#value' => t('Reset'));
    }

    drupal_add_js('misc/form.js');

    return $form;
}

/**
 * Form submission handler for node_filter_form().
 *
 * @see node_admin_content()
 * @see node_admin_nodes()
 * @see node_admin_nodes_submit()
 * @see node_admin_nodes_validate()
 * @see node_filter_form()
 * @see node_multiple_delete_confirm()
 * @see node_multiple_delete_confirm_submit()
 */
function node_filter_form_submit($form, &$form_state) {
    $filters = node_filters();
    switch ($form_state['values']['op']) {
        case t('Filter'):
        case t('Refine'):
            // Apply every filter that has a choice selected other than 'any'.
            foreach ($filters as $filter => $options) {
                if (isset($form_state['values'][$filter]) && $form_state['values'][$filter] != '[any]') {
                    // Flatten the options array to accommodate hierarchical/nested options.
                    $flat_options = form_options_flatten($filters[$filter]['options']);
                    // Only accept valid selections offered on the dropdown, block bad input.
                    if (isset($flat_options[$form_state['values'][$filter]])) {
                        $_SESSION['node_overview_filter'][] = array($filter, $form_state['values'][$filter]);
                    }
                }
            }
            break;
        case t('Undo'):
            array_pop($_SESSION['node_overview_filter']);
            break;
        case t('Reset'):
            $_SESSION['node_overview_filter'] = array();
            break;
    }
}

/**
 * Make mass update of nodes, changing all nodes in the $nodes array
 * to update them with the field values in $updates.
 *
 * IMPORTANT NOTE: This function is intended to work when called from a form
 * submission handler. Calling it outside of the form submission process may not
 * work correctly.
 *
 * @param array $nodes
 *   Array of node nids to update.
 * @param array $updates
 *   Array of key/value pairs with node field names and the value to update that
 *   field to.
 */
function node_mass_update($nodes, $updates) {
    // We use batch processing to prevent timeout when updating a large number
    // of nodes.
    if (count($nodes) > 10) {
        $batch = array(
            'operations' => array(
                array('_node_mass_update_batch_process', array($nodes, $updates))
            ),
            'finished' => '_node_mass_update_batch_finished',
            'title' => t('Processing'),
            // We use a single multi-pass operation, so the default
            // 'Remaining x of y operations' message will be confusing here.
            'progress_message' => '',
            'error_message' => t('The update has encountered an error.'),
            // The operations do not live in the .module file, so we need to
            // tell the batch engine which file to load before calling them.
            'file' => drupal_get_path('module', 'node') . '/node.admin.inc',
        );
        batch_set($batch);
    }
    else {
        foreach ($nodes as $nid) {
            _node_mass_update_helper($nid, $updates);
        }
        drupal_set_message(t('The update has been performed.'));
    }
}

/**
 * Updates individual nodes when fewer than 10 are queued.
 *
 * @param $nid
 *   ID of node to update.
 * @param $updates
 *   Associative array of updates.
 *
 * @return object
 *   An updated node object.
 *
 * @see node_mass_update()
 */
function _node_mass_update_helper($nid, $updates) {
    $node = node_load($nid, NULL, TRUE);
    // For efficiency manually save the original node before applying any changes.
    $node->original = clone $node;
    foreach ($updates as $name => $value) {
        $node->$name = $value;
    }
    node_save($node);
    return $node;
}

/**
 * Implements callback_batch_operation().
 *
 * Executes a batch operation for node_mass_update().
 *
 * @param array $nodes
 *   An array of node IDs.
 * @param array $updates
 *   Associative array of updates.
 * @param array $context
 *   An array of contextual key/values.
 */
function _node_mass_update_batch_process($nodes, $updates, &$context) {
    if (!isset($context['sandbox']['progress'])) {
        $context['sandbox']['progress'] = 0;
        $context['sandbox']['max'] = count($nodes);
        $context['sandbox']['nodes'] = $nodes;
    }

    // Process nodes by groups of 5.
    $count = min(5, count($context['sandbox']['nodes']));
    for ($i = 1; $i <= $count; $i++) {
        // For each nid, load the node, reset the values, and save it.
        $nid = array_shift($context['sandbox']['nodes']);
        $node = _node_mass_update_helper($nid, $updates);

        // Store result for post-processing in the finished callback.
        $context['results'][] = l($node->title, 'node/' . $node->nid);

        // Update our progress information.
        $context['sandbox']['progress']++;
    }

    // Inform the batch engine that we are not finished,
    // and provide an estimation of the completion level we reached.
    if ($context['sandbox']['progress'] != $context['sandbox']['max']) {
        $context['finished'] = $context['sandbox']['progress'] / $context['sandbox']['max'];
    }
}

/**
 * Implements callback_batch_finished().
 *
 * Reports the status of batch operation for node_mass_update().
 *
 * @param bool $success
 *   A boolean indicating whether the batch mass update operation successfully
 *   concluded.
 * @param int $results
 *   The number of nodes updated via the batch mode process.
 * @param array $operations
 *   An array of function calls (not used in this function).
 */
function _node_mass_update_batch_finished($success, $results, $operations) {
    if ($success) {
        drupal_set_message(t('The update has been performed.'));
    }
    else {
        drupal_set_message(t('An error occurred and processing did not complete.'), 'error');
        $message = format_plural(count($results), '1 item successfully processed:', '@count items successfully processed:');
        $message .= theme('item_list', array('items' => $results));
        drupal_set_message($message);
    }
}

/**
 * Page callback: Form constructor for the content administration form.
 *
 * @see node_admin_nodes()
 * @see node_admin_nodes_submit()
 * @see node_admin_nodes_validate()
 * @see node_filter_form()
 * @see node_filter_form_submit()
 * @see node_menu()
 * @see node_multiple_delete_confirm()
 * @see node_multiple_delete_confirm_submit()
 * @ingroup forms
 */
function node_admin_content($form, $form_state) {

    if (isset($form_state['values']['operation']) && $form_state['values']['operation'] == 'delete') {
        return node_multiple_delete_confirm($form, $form_state, array_filter($form_state['values']['nodes']));
    }
    $form['filter'] = node_filter_form();
    $form['#submit'][] = 'node_filter_form_submit';
    $form['admin'] = node_admin_nodes();

    return $form;
}

/**
 * Form builder: Builds the node administration overview.
 *
 * @see node_admin_nodes_submit()
 * @see node_admin_nodes_validate()
 * @see node_filter_form()
 * @see node_filter_form_submit()
 * @see node_multiple_delete_confirm()
 * @see node_multiple_delete_confirm_submit()
 *
 * @ingroup forms
 */
function node_admin_nodes() {
    $admin_access = user_access('administer nodes');

    // Build the 'Update options' form.
    $form['options'] = array(
        '#type' => 'fieldset',
        '#title' => t('Update options'),
        '#attributes' => array('class' => array('container-inline')),
        '#access' => $admin_access,
    );

    $options = array();
    foreach (module_invoke_all('node_operations') as $operation => $array) {
        $options[$operation] = $array['label'];
    }
    $form['options']['operation'] = array(
        '#type' => 'select',
        '#title' => t('Operation'),
        '#title_display' => 'invisible',
        '#options' => $options,
        '#default_value' => 'approve',
    );
    $form['options']['submit'] = array(
        '#type' => 'submit',
        '#value' => t('Update'),
        '#validate' => array('node_admin_nodes_validate'),
        '#submit' => array('node_admin_nodes_submit'),
    );

    // Enable language column if translation module is enabled or if we have any
    // node with language.
    $multilanguage = (module_exists('translation') || db_query_range("SELECT 1 FROM {node} WHERE language <> :language", 0, 1, array(':language' => LANGUAGE_NONE))->fetchField());

    // Build the sortable table header.
    $header = array(
        'title' => array('data' => t('Title'), 'field' => 'n.title'),
        'type' => array('data' => t('Type'), 'field' => 'n.type'),
        'shelf' => array('data' => t('货架'), 'field' => 'n.shelf'),//增添了货架列
        'author' => t('Author'),
        'status' => array('data' => t('Status'), 'field' => 'n.status'),
        'changed' => array('data' => t('Updated'), 'field' => 'n.changed', 'sort' => 'desc')
    );

    //删除语言列
   /* if ($multilanguage) {
        $header['language'] = array('data' => t('Language'), 'field' => 'n.language');
    }*/
    $header['operations'] = array('data' => t('Operations'));

    $query = db_select('node', 'n')->extend('PagerDefault')->extend('TableSort');
    $query->addTag('node_admin_filter');
    node_build_filter_query($query);

    if (!user_access('bypass node access')) {
        // If the user is able to view their own unpublished nodes, allow them
        // to see these in addition to published nodes. Check that they actually
        // have some unpublished nodes to view before adding the condition.
        if (user_access('view own unpublished content') && $own_unpublished = db_query('SELECT nid FROM {node} WHERE uid = :uid AND status = :status', array(':uid' => $GLOBALS['user']->uid, ':status' => 0))->fetchCol()) {
            $query->condition(db_or()
                ->condition('n.status', 1)
                ->condition('n.nid', $own_unpublished, 'IN')
            );
        }
        else {
            // If not, restrict the query to published nodes.
            $query->condition('n.status', 1);
        }
    }
    $nids = $query
        ->fields('n',array('nid'))
        ->condition('type', 'product')   //山选出产品类型的node
        ->limit(50)
        ->orderByHeader($header)
        ->addTag('node_access')
        ->execute()
        ->fetchCol();
    $nodes = node_load_multiple($nids);

    // Prepare the list of nodes.
    $languages = language_list();
    $destination = drupal_get_destination();
    $options = array();
    foreach ($nodes as $node) {

        //查询产品的类型
        $myfield_array = field_get_items('node', $node,'field_product_type');
        $myfield = isset($myfield_array[0]) ? $myfield_array[0] :'';
        $tid = $myfield['tid'];
        $product_type = taxonomy_term_load($tid);//使用API函数查找出类型

        //查询产品的货架
        $myfield_array = field_get_items('node', $node,'field_product_shelf');
        $myfield = isset($myfield_array[0]) ? $myfield_array[0] :'';
        if($myfield)
        {
            $tid = $myfield['tid'];
            $product_shelf = taxonomy_term_load($tid);
        }else{
            $product_shelf = NULL;
        }

        $langcode = entity_language('node', $node);
        $uri = entity_uri('node', $node);
        if ($langcode != LANGUAGE_NONE && isset($languages[$langcode])) {
            $uri['options']['language'] = $languages[$langcode];
        }
        $options[$node->nid] = array(
            'title' => array(
                'data' => array(
                    '#type' => 'link',
                    '#title' => $node->title,
                    '#href' => $uri['path'],
                    '#options' => $uri['options'],
                    '#suffix' => ' ' . theme('mark', array('type' => node_mark($node->nid, $node->changed))),
                ),
            ),
            'type' => check_plain($product_type->name),//查询数据库中产品类型的名称，并转换为utf-8
            'author' => theme('username', array('account' => $node)),
            'status' => $node->status ? t('published') : t('not published'),
            'changed' => format_date($node->changed, 'short'),
        );
        if(!$product_shelf){
            $options[$node->nid]['shelf'] = '未上架' ;
        }else{
            $options[$node->nid]['shelf'] = array(
                'data' => array(
                    '#type' => 'link',
                    '#title' => $product_shelf->name,
                    '#href' => 'taxonomy/term/'.$product_shelf->tid,
                ),
            );
        }
        //不需要语言列的数据
        /*if ($multilanguage) {
            if ($langcode == LANGUAGE_NONE || isset($languages[$langcode])) {
                $options[$node->nid]['language'] = $langcode == LANGUAGE_NONE ? t('Language neutral') : t($languages[$langcode]->name);
            }
            else {
                $options[$node->nid]['language'] = t('Undefined language (@langcode)', array('@langcode' => $langcode));
            }
        }*/
        // Build a list of all the accessible operations for the current node.
        $operations = array();
        if (node_access('update', $node)) {
            $operations['edit'] = array(
                'title' => t('edit'),
                'href' => 'node/' . $node->nid . '/edit',
                'query' => $destination,
            );
        }
        if (node_access('delete', $node)) {
            $operations['delete'] = array(
                'title' => t('delete'),
                'href' => 'node/' . $node->nid . '/delete',
                'query' => $destination,
            );
        }
        //上架的ajax处理
        drupal_add_library('system', 'drupal.ajax');
        $class = "rp-shelf rp-shelf-on";
        $url = "admin/products/".$node->vid."/nojs";
       // $title = l('上架', $url, array('attributes'=>array('class'=>"use-ajax {$class}",'id'=>"onshelf-links")));
        if (!$product_shelf) {
            $operations['onshelf'] = array(
                'title' => t('上架'),
                'href' => $url,
                'attributes' => array('class'=>"use-ajax {$class}",'id'=>"onshelf-links") ,
            );
        }

        $options[$node->nid]['operations'] = array();
        if (count($operations) > 1) {
            // Render an unordered list of operations links.
            $options[$node->nid]['operations'] = array(
                'data' => array(
                    '#theme' => 'links__node_operations',
                    '#links' => $operations,
                    '#attributes' => array('class' => array('links', 'inline')),
                ),
            );
        }
        elseif (!empty($operations)) {
            // Render the first and only operation as a link.
            $link = reset($operations);
            $options[$node->nid]['operations'] = array(
                'data' => array(
                    '#type' => 'link',
                    '#title' => $link['title'],
                    '#href' => $link['href'],
                    '#options' => array('query' => $link['query']),
                ),
            );
        }
    }

    // Only use a tableselect when the current user is able to perform any
    // operations.
    if ($admin_access) {
        $form['nodes'] = array(
            '#type' => 'tableselect',
            '#header' => $header,
            '#options' => $options,
            '#empty' => t('No content available.'),
        );
    }
    // Otherwise, use a simple table.
    else {
        $form['nodes'] = array(
            '#theme' => 'table',
            '#header' => $header,
            '#rows' => $options,
            '#empty' => t('No content available.'),
        );
    }

    $form['pager'] = array('#markup' => theme('pager'));
    return $form;
}

/**
 * Validate node_admin_nodes form submissions.
 *
 * Checks whether any nodes have been selected to perform the chosen 'Update
 * option' on.
 *
 * @see node_admin_nodes()
 * @see node_admin_nodes_submit()
 * @see node_filter_form()
 * @see node_filter_form_submit()
 * @see node_multiple_delete_confirm()
 * @see node_multiple_delete_confirm_submit()
 */
function node_admin_nodes_validate($form, &$form_state) {
    // Error if there are no items to select.
    if (!is_array($form_state['values']['nodes']) || !count(array_filter($form_state['values']['nodes']))) {
        form_set_error('', t('No items selected.'));
    }
}

/**
 * Process node_admin_nodes form submissions.
 *
 * Executes the chosen 'Update option' on the selected nodes.
 *
 * @see node_admin_nodes()
 * @see node_admin_nodes_validate()
 * @see node_filter_form()
 * @see node_filter_form_submit()
 * @see node_multiple_delete_confirm()
 * @see node_multiple_delete_confirm_submit()
 */
function node_admin_nodes_submit($form, &$form_state) {
    $operations = module_invoke_all('node_operations');
    $operation = $operations[$form_state['values']['operation']];
    // Filter out unchecked nodes
    $nodes = array_filter($form_state['values']['nodes']);
    if ($function = $operation['callback']) {
        // Add in callback arguments if present.
        if (isset($operation['callback arguments'])) {
            $args = array_merge(array($nodes), $operation['callback arguments']);
        }
        else {
            $args = array($nodes);
        }
        call_user_func_array($function, $args);

        cache_clear_all();
    }
    else {
        // We need to rebuild the form to go to a second step. For example, to
        // show the confirmation form for the deletion of nodes.
        $form_state['rebuild'] = TRUE;
    }
}

/**
 * Multiple node deletion confirmation form for node_admin_content().
 *
 * @see node_admin_nodes()
 * @see node_admin_nodes_submit()
 * @see node_admin_nodes_validate()
 * @see node_filter_form()
 * @see node_filter_form_submit()
 * @see node_multiple_delete_confirm_submit()
 * @ingroup forms
 */
function node_multiple_delete_confirm($form, &$form_state, $nodes) {
    $form['nodes'] = array('#prefix' => '<ul>', '#suffix' => '</ul>', '#tree' => TRUE);
    // array_filter returns only elements with TRUE values
    foreach ($nodes as $nid => $value) {
        $title = db_query('SELECT title FROM {node} WHERE nid = :nid', array(':nid' => $nid))->fetchField();
        $form['nodes'][$nid] = array(
            '#type' => 'hidden',
            '#value' => $nid,
            '#prefix' => '<li>',
            '#suffix' => check_plain($title) . "</li>\n",
        );
    }
    $form['operation'] = array('#type' => 'hidden', '#value' => 'delete');
    $form['#submit'][] = 'node_multiple_delete_confirm_submit';
    $confirm_question = format_plural(count($nodes),
        'Are you sure you want to delete this item?',
        'Are you sure you want to delete these items?');
    return confirm_form($form,
        $confirm_question,
        'admin/content', t('This action cannot be undone.'),
        t('Delete'), t('Cancel'));
}

/**
 * Form submission handler for node_multiple_delete_confirm().
 *
 * @see node_admin_nodes()
 * @see node_admin_nodes_submit()
 * @see node_admin_nodes_validate()
 * @see node_filter_form()
 * @see node_filter_form_submit()
 * @see node_multiple_delete_confirm()
 */
function node_multiple_delete_confirm_submit($form, &$form_state) {
    if ($form_state['values']['confirm']) {
        node_delete_multiple(array_keys($form_state['values']['nodes']));
        cache_clear_all();
        $count = count($form_state['values']['nodes']);
        watchdog('content', 'Deleted @count posts.', array('@count' => $count));
        drupal_set_message(format_plural($count, 'Deleted 1 post.', 'Deleted @count posts.'));
    }
    $form_state['redirect'] = 'admin/content';
}

/**
 * Returns a node submission form.
 *
 * @param $type
 *   The node type for the submitted node.
 *
 * @return
 *   The themed form.
 */
function product_add() {
    global $user;

    $type = 'product';
    $types = node_type_get_types();
    $node = (object) array('uid' => $user->uid, 'name' => (isset($user->name) ? $user->name : ''), 'type' => $type, 'language' => LANGUAGE_NONE);
    drupal_set_title(t('Create @name', array('@name' => $types[$type]->name)), PASS_THROUGH);
    $output = drupal_get_form($type . '_node_form', $node);

    return $output;
}

/**
 * Form constructor for the node add/edit form.
 *
 * @see node_form_submit()
 * @see node_form_build_preview()
 * @see node_form_delete_submit()
 * @ingroup forms
 */
function node_form($form, &$form_state, $node) {
    global $user;

    // During initial form build, add the node entity to the form state for use
    // during form building and processing. During a rebuild, use what is in the
    // form state.
    if (!isset($form_state['node'])) {
        if (!isset($node->title)) {
            $node->title = NULL;
        }
        node_object_prepare($node);
        $form_state['node'] = $node;
    }
    else {
        $node = $form_state['node'];
    }

    // Some special stuff when previewing a node.
    if (isset($form_state['node_preview'])) {
        $form['#prefix'] = $form_state['node_preview'];
        $node->in_preview = TRUE;
    }
    else {
        unset($node->in_preview);
    }

    // Identify this as a node edit form.
    // @todo D8: Remove. Modules can implement hook_form_BASE_FORM_ID_alter() now.
    $form['#node_edit_form'] = TRUE;

    $form['#attributes']['class'][] = 'node-form';
    if (!empty($node->type)) {
        $form['#attributes']['class'][] = 'node-' . $node->type . '-form';
    }

    // Basic node information.
    // These elements are just values so they are not even sent to the client.
    foreach (array('nid', 'vid', 'uid', 'created', 'type', 'language') as $key) {
        $form[$key] = array(
            '#type' => 'value',
            '#value' => isset($node->$key) ? $node->$key : NULL,
        );
    }

    // Changed must be sent to the client, for later overwrite error checking.
    $form['changed'] = array(
        '#type' => 'hidden',
        '#default_value' => isset($node->changed) ? $node->changed : NULL,
    );
    // Invoke hook_form() to get the node-specific bits. Can't use node_invoke(),
    // because hook_form() needs to be able to receive $form_state by reference.
    // @todo hook_form() implementations are unable to add #validate or #submit
    //   handlers to the form buttons below. Remove hook_form() entirely.
    $function = node_type_get_base($node) . '_form';
    if (function_exists($function) && ($extra = $function($node, $form_state))) {
        $form = array_merge_recursive($form, $extra);
    }
    // If the node type has a title, and the node type form defined no special
    // weight for it, we default to a weight of -5 for consistency.
    if (isset($form['title']) && !isset($form['title']['#weight'])) {
        $form['title']['#weight'] = -5;
    }
    // @todo D8: Remove. Modules should access the node using $form_state['node'].
    $form['#node'] = $node;

    $form['additional_settings'] = array(
        '#type' => 'vertical_tabs',
        '#weight' => 99,
    );

    // Add a log field if the "Create new revision" option is checked, or if the
    // current user has the ability to check that option.
    $form['revision_information'] = array(
        '#type' => 'fieldset',
        '#title' => t('Revision information'),
        '#collapsible' => TRUE,
        // Collapsed by default when "Create new revision" is unchecked
        '#collapsed' => !$node->revision,
        '#group' => 'additional_settings',
        '#attributes' => array(
            'class' => array('node-form-revision-information'),
        ),
        '#attached' => array(
            'js' => array(drupal_get_path('module', 'node') . '/node.js'),
        ),
        '#weight' => 20,
        '#access' => $node->revision || user_access('administer nodes'),
    );
    $form['revision_information']['revision'] = array(
        '#type' => 'checkbox',
        '#title' => t('Create new revision'),
        '#default_value' => $node->revision,
        '#access' => user_access('administer nodes'),
    );
    // Check the revision log checkbox when the log textarea is filled in.
    // This must not happen if "Create new revision" is enabled by default, since
    // the state would auto-disable the checkbox otherwise.
    if (!$node->revision) {
        $form['revision_information']['revision']['#states'] = array(
            'checked' => array(
                'textarea[name="log"]' => array('empty' => FALSE),
            ),
        );
    }
    $form['revision_information']['log'] = array(
        '#type' => 'textarea',
        '#title' => t('Revision log message'),
        '#rows' => 4,
        '#default_value' => !empty($node->log) ? $node->log : '',
        '#description' => t('Provide an explanation of the changes you are making. This will help other authors understand your motivations.'),
    );

    // Node author information for administrators
    $form['author'] = array(
        '#type' => 'fieldset',
        '#access' => user_access('administer nodes'),
        '#title' => t('Authoring information'),
        '#collapsible' => TRUE,
        '#collapsed' => TRUE,
        '#group' => 'additional_settings',
        '#attributes' => array(
            'class' => array('node-form-author'),
        ),
        '#attached' => array(
            'js' => array(
                drupal_get_path('module', 'node') . '/node.js',
                array(
                    'type' => 'setting',
                    'data' => array('anonymous' => variable_get('anonymous', t('Anonymous'))),
                ),
            ),
        ),
        '#weight' => 90,
    );
    $form['author']['name'] = array(
        '#type' => 'textfield',
        '#title' => t('Authored by'),
        '#maxlength' => 60,
        '#autocomplete_path' => 'user/autocomplete',
        '#default_value' => !empty($node->name) ? $node->name : '',
        '#weight' => -1,
        '#description' => t('Leave blank for %anonymous.', array('%anonymous' => variable_get('anonymous', t('Anonymous')))),
    );
    $form['author']['date'] = array(
        '#type' => 'textfield',
        '#title' => t('Authored on'),
        '#maxlength' => 25,
        '#description' => t('Format: %time. The date format is YYYY-MM-DD and %timezone is the time zone offset from UTC. Leave blank to use the time of form submission.', array('%time' => !empty($node->date) ? date_format(date_create($node->date), 'Y-m-d H:i:s O') : format_date($node->created, 'custom', 'Y-m-d H:i:s O'), '%timezone' => !empty($node->date) ? date_format(date_create($node->date), 'O') : format_date($node->created, 'custom', 'O'))),
        '#default_value' => !empty($node->date) ? $node->date : '',
    );

    // Node options for administrators
    $form['options'] = array(
        '#type' => 'fieldset',
        '#access' => user_access('administer nodes'),
        '#title' => t('Publishing options'),
        '#collapsible' => TRUE,
        '#collapsed' => TRUE,
        '#group' => 'additional_settings',
        '#attributes' => array(
            'class' => array('node-form-options'),
        ),
        '#attached' => array(
            'js' => array(drupal_get_path('module', 'node') . '/node.js'),
        ),
        '#weight' => 95,
    );
    $form['options']['status'] = array(
        '#type' => 'checkbox',
        '#title' => t('Published'),
        '#default_value' => $node->status,
    );
    $form['options']['promote'] = array(
        '#type' => 'checkbox',
        '#title' => t('Promoted to front page'),
        '#default_value' => $node->promote,
    );
    $form['options']['sticky'] = array(
        '#type' => 'checkbox',
        '#title' => t('Sticky at top of lists'),
        '#default_value' => $node->sticky,
    );

    // Add the buttons.
    $form['actions'] = array('#type' => 'actions');
    $form['actions']['submit'] = array(
        '#type' => 'submit',
        '#access' => variable_get('node_preview_' . $node->type, DRUPAL_OPTIONAL) != DRUPAL_REQUIRED || (!form_get_errors() && isset($form_state['node_preview'])),
        '#value' => t('Save'),
        '#weight' => 5,
        '#submit' => array('node_form_submit'),
    );
    $form['actions']['preview'] = array(
        '#access' => variable_get('node_preview_' . $node->type, DRUPAL_OPTIONAL) != DRUPAL_DISABLED,
        '#type' => 'submit',
        '#value' => t('Preview'),
        '#weight' => 10,
        '#submit' => array('node_form_build_preview'),
    );
    if (!empty($node->nid) && node_access('delete', $node)) {
        $form['actions']['delete'] = array(
            '#type' => 'submit',
            '#value' => t('Delete'),
            '#weight' => 15,
            '#submit' => array('node_form_delete_submit'),
        );
    }
    // This form uses a button-level #submit handler for the form's main submit
    // action. node_form_submit() manually invokes all form-level #submit handlers
    // of the form. Without explicitly setting #submit, Form API would auto-detect
    // node_form_submit() as submit handler, but that is the button-level #submit
    // handler for the 'Save' action. To maintain backwards compatibility, a
    // #submit handler is auto-suggested for custom node type modules.
    $form['#validate'][] = 'node_form_validate';
    if (!isset($form['#submit']) && function_exists($node->type . '_node_form_submit')) {
        $form['#submit'][] = $node->type . '_node_form_submit';
    }
    $form += array('#submit' => array());

    field_attach_form('node', $node, $form, $form_state, entity_language('node', $node));
    return $form;
}

/**
 * Form submission handler for node_form().
 *
 * @see node_form()
 */
function node_form_submit($form, &$form_state) {
    $node = node_form_submit_build_node($form, $form_state);
    $insert = empty($node->nid);
    node_save($node);
    $node_link = l(t('view'), 'node/' . $node->nid);
    $watchdog_args = array('@type' => $node->type, '%title' => $node->title);
    $t_args = array('@type' => node_type_get_name($node), '%title' => $node->title);

    if ($insert) {
        watchdog('content', '@type: added %title.', $watchdog_args, WATCHDOG_NOTICE, $node_link);
        drupal_set_message(t('@type %title has been created.', $t_args));
    }
    else {
        watchdog('content', '@type: updated %title.', $watchdog_args, WATCHDOG_NOTICE, $node_link);
        drupal_set_message(t('@type %title has been updated.', $t_args));
    }
    if ($node->nid) {
        $form_state['values']['nid'] = $node->nid;
        $form_state['nid'] = $node->nid;
        $form_state['redirect'] = node_access('view', $node) ? 'node/' . $node->nid : '<front>';
    }
    else {
        // In the unlikely case something went wrong on save, the node will be
        // rebuilt and node form redisplayed the same way as in preview.
        drupal_set_message(t('The post could not be saved.'), 'error');
        $form_state['rebuild'] = TRUE;
    }
    // Clear the page and block caches.
    cache_clear_all();
}

/**
 * Form submission handler for node_form().
 *
 * Handles the 'Preview' button on the node form.
 *
 * @see node_form()
 */
function node_form_build_preview($form, &$form_state) {
    $node = node_form_submit_build_node($form, $form_state);
    $form_state['node_preview'] = node_preview($node);
    $form_state['rebuild'] = TRUE;
}

/**
 * Form submission handler for node_form().
 *
 * Handles the 'Delete' button on the node form.
 *
 * @see node_form()
 */
function node_form_delete_submit($form, &$form_state) {
    $destination = array();
    if (isset($_GET['destination'])) {
        $destination = drupal_get_destination();
        unset($_GET['destination']);
    }
    $node = $form['#node'];
    $form_state['redirect'] = array('node/' . $node->nid . '/delete', array('query' => $destination));
}

/**
 * Form validation handler for node_form().
 *
 * @see node_form()
 * @see node_form_submit()
 */
function node_form_validate($form, &$form_state) {
    // $form_state['node'] contains the actual entity being edited, but we must
    // not update it with form values that have not yet been validated, so we
    // create a pseudo-entity to use during validation.
    $node = (object) $form_state['values'];
    node_validate($node, $form, $form_state);
    entity_form_field_validate('node', $form, $form_state);
}

/**
 * Updates the form state's node entity by processing this submission's values.
 *
 * This is the default builder function for the node form. It is called
 * during the "Save" and "Preview" submit handlers to retrieve the entity to
 * save or preview. This function can also be called by a "Next" button of a
 * wizard to update the form state's entity with the current step's values
 * before proceeding to the next step.
 *
 * @see node_form()
 */
function node_form_submit_build_node($form, &$form_state) {
    // @todo Legacy support for modules that extend the node form with form-level
    //   submit handlers that adjust $form_state['values'] prior to those values
    //   being used to update the entity. Module authors are encouraged to instead
    //   adjust the node directly within a hook_node_submit() implementation. For
    //   Drupal 8, evaluate whether the pattern of triggering form-level submit
    //   handlers during button-level submit processing is worth supporting
    //   properly, and if so, add a Form API function for doing so.
    unset($form_state['submit_handlers']);
    form_execute_handlers('submit', $form, $form_state);

    $node = $form_state['node'];
    entity_form_submit_build_entity('node', $node, $form, $form_state);

    node_submit($node);
    foreach (module_implements('node_submit') as $module) {
        $function = $module . '_node_submit';
        $function($node, $form, $form_state);
    }
    return $node;
}

/**
 * Generates a node preview.
 *
 * @param $node
 *   The node to preview.
 *
 * @return
 *   An HTML-formatted string of a node preview.
 *
 * @see node_form_build_preview()
 */
function node_preview($node) {
    // Clone the node before previewing it to prevent the node itself from being
    // modified.
    $cloned_node = clone $node;
    if (node_access('create', $cloned_node) || node_access('update', $cloned_node)) {
        _field_invoke_multiple('load', 'node', array($cloned_node->nid => $cloned_node));
        // Load the user's name when needed.
        if (isset($cloned_node->name)) {
            // The use of isset() is mandatory in the context of user IDs, because
            // user ID 0 denotes the anonymous user.
            if ($user = user_load_by_name($cloned_node->name)) {
                $cloned_node->uid = $user->uid;
                $cloned_node->picture = $user->picture;
            }
            else {
                $cloned_node->uid = 0; // anonymous user
            }
        }
        elseif ($cloned_node->uid) {
            $user = user_load($cloned_node->uid);
            $cloned_node->name = $user->name;
            $cloned_node->picture = $user->picture;
        }

        $cloned_node->changed = REQUEST_TIME;
        $nodes = array($cloned_node->nid => $cloned_node);

        // Display a preview of the node.
        if (!form_get_errors()) {
            $cloned_node->in_preview = TRUE;
            $output = theme('node_preview', array('node' => $cloned_node));
            unset($cloned_node->in_preview);
        }
        drupal_set_title(t('Preview'), PASS_THROUGH);

        return $output;
    }
}