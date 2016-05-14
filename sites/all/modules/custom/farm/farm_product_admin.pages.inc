<?php

/**
 * Menu callback; displays all products associated with a node.
 *
 * @param $farm
 *   The farm node.
 * @return
 *   The page content.
 */
function farm_product_page($farm)
{
    // If there is a menu link to this term, the link becomes the last part of
    // the active trail, and the link name becomes the page title. Thus, we must
    // explicitly set the page title to be the term title.
    drupal_set_title($farm->title);

    // Set the term path as the canonical URL to prevent duplicate content.
    $uri = entity_uri('node', $farm);
    drupal_add_html_head_link(array('rel' => 'canonical', 'href' => url($uri['path'], $uri['options'])), TRUE);
    // Set the non-aliased path as a default shortlink.
    drupal_add_html_head_link(array('rel' => 'shortlink', 'href' => url($uri['path'], array_merge($uri['options'], array('alias' => TRUE)))), TRUE);
    drupal_add_css(drupal_get_path('module', 'farm') . '/farm_product.css');

    $destination = drupal_get_destination();
    $header = array('名称', '图片','作者','操作');

    $fid = $farm->nid;

    //查询出此农场中的产品
    $query = db_select('field_data_field_product_farm', 'f')->extend('PagerDefault');
    $nids = $query
        ->fields('f', array('entity_id'))
        ->condition('f.field_product_farm_value', $fid)
        ->orderBy('entity_id', 'DESC')
        ->addTag('node_access')
        ->limit(10)
        ->execute()
        ->fetchCol();

    $nodes = node_load_multiple($nids);
    $count = count($nodes);
    if($count==0){
        $build = "此农场中还没有添加产品";
        return $build;
    }
    else{
        foreach($nodes as $key => $node){
            //获取产品图片
            $myfield_array = field_get_items('node', $node,'field_product_photo');
            $image = isset($myfield_array[0]) ? $myfield_array[0] :'';
            $search_image_uri = $image['uri'];
            // assuming that the uri starts with "public://"
            $search_image_locate = explode('//', $search_image_uri);
            $search_image_filepath = $GLOBALS['base_url'] .'/sites/default/files/' . $search_image_locate[1];

            $rows[$key]['title'] = array(
                'data' => array(
                    '#type' => 'link',
                    '#title' => $node->title,
                    '#href' => $uri['path'],
                ),
            );
            $rows[$key]['image'] = "<img class='product-img' src=".$search_image_filepath.">";
            $rows[$key]['author'] = theme('username', array('account' => $node));

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

            if (count($operations) > 1) {
                // Render an unordered list of operations links.
                $rows[$key]['operations'] = array(
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
                $rows[$key]['operations'] = array(
                    'data' => array(
                        '#type' => 'link',
                        '#title' => $link['title'],
                        '#href' => $link['href'],
                        '#options' => array('query' => $link['query']),
                    ),
                );
            }
        }
        $table = theme('table', array('header' => $header,'rows' => $rows ,'attributes' => array('class' => array('shelf-term-table'))));

        return $table;
    }
}

/**
 * Returns a product submission form.
 *
 * @param $farm
 *   The product farm for the submitted product.
 *
 * @return
 *   The themed form.
 */
function farm_product_add($farmid) {
    global $user;

    $type = 'product';
    $types = node_type_get_types();

    //$farmid = $farm->nid;
    $node = (object) array(
        'uid' => $user->uid,
        'name' => (isset($user->name) ? $user->name : ''),
        'type' => $type,
        'language' => LANGUAGE_NONE,
        'field_product_farm' => array('und'=>array(array('value'=>$farmid))),
    );
    drupal_set_title(t('Create @name', array('@name' => $types[$type]->name)), PASS_THROUGH);
    $output = drupal_get_form($type . '_form', $node);

    return $output;
}

/**
 * Form constructor for the node add/edit form.
 *
 * @see product_form_submit()
 * @see product_form_build_preview()
 * @see product_form_delete_submit()
 * @ingroup forms
 */
function product_form($form, &$form_state, $node) {
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
    if (isset($form_state['product_preview'])) {
        $form['#prefix'] = $form_state['product_preview'];
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
        '#access' => variable_get('product_preview_' . $node->type, DRUPAL_OPTIONAL) != DRUPAL_REQUIRED || (!form_get_errors() && isset($form_state['product_preview'])),
        '#value' => t('Save'),
        '#weight' => 5,
        '#submit' => array('product_form_submit'),
    );
    $form['actions']['preview'] = array(
        '#access' => variable_get('product_preview_' . $node->type, DRUPAL_OPTIONAL) != DRUPAL_DISABLED,
        '#type' => 'submit',
        '#value' => t('Preview'),
        '#weight' => 10,
        '#submit' => array('product_form_build_preview'),
    );
    if (!empty($node->nid) && node_access('delete', $node)) {
        $form['actions']['delete'] = array(
            '#type' => 'submit',
            '#value' => t('Delete'),
            '#weight' => 15,
            '#submit' => array('product_form_delete_submit'),
        );
    }
    // This form uses a button-level #submit handler for the form's main submit
    // action. product_form_submit() manually invokes all form-level #submit handlers
    // of the form. Without explicitly setting #submit, Form API would auto-detect
    // product_form_submit() as submit handler, but that is the button-level #submit
    // handler for the 'Save' action. To maintain backwards compatibility, a
    // #submit handler is auto-suggested for custom node type modules.
    $form['#validate'][] = 'product_form_validate';
    if (!isset($form['#submit']) && function_exists($node->type . '_product_form_submit')) {
        $form['#submit'][] = $node->type . '_product_form_submit';
    }
    $form += array('#submit' => array());

    field_attach_form('node', $node, $form, $form_state, entity_language('node', $node));
    return $form;
}

/**
 * Form submission handler for product_form().
 *
 * @see product_form()
 */
function product_form_submit($form, &$form_state) {
    $node = product_form_submit_build_node($form, $form_state);
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
 * Form submission handler for product_form().
 *
 * Handles the 'Preview' button on the node form.
 *
 * @see product_form()
 */
function product_form_build_preview($form, &$form_state) {
    $node = product_form_submit_build_node($form, $form_state);
    $form_state['product_preview'] = product_preview($node);
    $form_state['rebuild'] = TRUE;
}

/**
 * Form submission handler for product_form().
 *
 * Handles the 'Delete' button on the node form.
 *
 * @see product_form()
 */
function product_form_delete_submit($form, &$form_state) {
    $destination = array();
    if (isset($_GET['destination'])) {
        $destination = drupal_get_destination();
        unset($_GET['destination']);
    }
    $node = $form['#node'];
    $form_state['redirect'] = array('node/' . $node->nid . '/delete', array('query' => $destination));
}

/**
 * Form validation handler for product_form().
 *
 * @see product_form()
 * @see product_form_submit()
 */
function product_form_validate($form, &$form_state) {
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
 * @see product_form()
 */
function product_form_submit_build_node($form, &$form_state) {
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
 * @see product_form_build_preview()
 */
function product_preview($node) {
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
            $output = theme('product_preview', array('node' => $cloned_node));
            unset($cloned_node->in_preview);
        }
        drupal_set_title(t('Preview'), PASS_THROUGH);

        return $output;
    }
}

