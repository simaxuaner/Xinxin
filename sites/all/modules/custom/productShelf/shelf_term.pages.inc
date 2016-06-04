<?php

/**
 * @file
 * Page callbacks for the taxonomy module.
 */

/**
 * Menu callback; displays all nodes associated with a term.
 *
 * @param $term
 *   The taxonomy term.
 * @return
 *   The page content.
 */
function productShelf_term_page($term)
{
    // If there is a menu link to this term, the link becomes the last part of
    // the active trail, and the link name becomes the page title. Thus, we must
    // explicitly set the page title to be the term title.
    drupal_set_title($term->name);
    drupal_add_css(drupal_get_path('module', 'productShelf') . '/shelf_term.css');
    // Set the term path as the canonical URL to prevent duplicate content.
    $uri = entity_uri('taxonomy_term', $term);
    drupal_add_html_head_link(array('rel' => 'canonical', 'href' => url($uri['path'], $uri['options'])), TRUE);
    // Set the non-aliased path as a default shortlink.
    drupal_add_html_head_link(array('rel' => 'shortlink', 'href' => url($uri['path'], array_merge($uri['options'], array('alias' => TRUE)))), TRUE);

    $header = array('名称', '图片','作者','操作');
    $nids = taxonomy_select_nodes($term->tid, TRUE, variable_get('default_nodes_main', 10));
    $nodes = node_load_multiple($nids);
    $count = count($nodes);
    if($count==0){
        $build = "此货架中还没有添加产品.";
        return $build;
    }
    else{
        foreach($nodes as $key => $node){
            //获取图片
            $myfield_array = field_get_items('node', $node,'field_product_photo');
            $image = isset($myfield_array[0]) ? $myfield_array[0] :'';
            $search_image_filepath = ($image && isset($image['uri'])) ? file_create_url($image['uri']) : '';
            $rows[$key]['title'] = array(
                'data' => array(
                    '#type' => 'link',
                    '#title' => $node->title,
                    '#href' => $uri['path'],
                ),
            );
            $rows[$key]['image'] = "<img class='product-img' src=".$search_image_filepath.">";
            $rows[$key]['author'] = theme('username', array('account' => $node));

            //下架的ajax处理
            drupal_add_library('system', 'drupal.ajax');
            $class = "rp-shelf rp-shelf-out";
            $url = "admin/productShelf/".$node->nid."/nojs";
            $title = l('下架', $url, array('attributes'=>array('class'=>"use-ajax {$class}",'id'=>"outshelf-links".$node->nid)));
            $rows[$key]['option'] = $title;
        }
        $table = theme('table', array('header' => $header,'rows' => $rows ,'attributes' => array('class' => array('shelf-term-table'))));

        return $table;
    }
}

/**
 * Generate the content feed for a taxonomy term.
 *
 * @param $term
 *   The taxonomy term.
 */
function taxonomy_term_feed($term) {
    $channel['link'] = url('admin/taxonomy/term/' . $term->tid, array('absolute' => TRUE));
    $channel['title'] = variable_get('site_name', 'Drupal') . ' - ' . $term->name;
    // Only display the description if we have a single term, to avoid clutter and confusion.
    // HTML will be removed from feed description.
    $channel['description'] = check_markup($term->description, $term->format, '', TRUE);
    $nids = taxonomy_select_nodes($term->tid, FALSE, variable_get('feed_default_items', 10));

    node_feed($nids, $channel);
}

/**
 * Page callback: Outputs JSON for taxonomy autocomplete suggestions.
 *
 * Path: taxonomy/autocomplete
 *
 * This callback outputs term name suggestions in response to Ajax requests
 * made by the taxonomy autocomplete widget for taxonomy term reference
 * fields. The output is a JSON object of plain-text term suggestions, keyed by
 * the user-entered value with the completed term name appended.  Term names
 * containing commas are wrapped in quotes.
 *
 * For example, suppose the user has entered the string 'red fish, blue' in the
 * field, and there are two taxonomy terms, 'blue fish' and 'blue moon'. The
 * JSON output would have the following structure:
 * @code
 *   {
 *     "red fish, blue fish": "blue fish",
 *     "red fish, blue moon": "blue moon",
 *   };
 * @endcode
 *
 * @param $field_name
 *   The name of the term reference field.
 * @param $tags_typed
 *   (optional) A comma-separated list of term names entered in the
 *   autocomplete form element. Only the last term is used for autocompletion.
 *   Defaults to '' (an empty string).
 *
 * @see taxonomy_menu()
 * @see taxonomy_field_widget_info()
 */
function taxonomy_autocomplete($field_name = '', $tags_typed = '') {
    // If the request has a '/' in the search text, then the menu system will have
    // split it into multiple arguments, recover the intended $tags_typed.
    $args = func_get_args();
    // Shift off the $field_name argument.
    array_shift($args);
    $tags_typed = implode('/', $args);

    // Make sure the field exists and is a taxonomy field.
    if (!($field = field_info_field($field_name)) || $field['type'] !== 'taxonomy_term_reference') {
        // Error string. The JavaScript handler will realize this is not JSON and
        // will display it as debugging information.
        print t('Taxonomy field @field_name not found.', array('@field_name' => $field_name));
        exit;
    }

    // The user enters a comma-separated list of tags. We only autocomplete the last tag.
    $tags_typed = drupal_explode_tags($tags_typed);
    $tag_last = drupal_strtolower(array_pop($tags_typed));

    $term_matches = array();
    if ($tag_last != '') {

        // Part of the criteria for the query come from the field's own settings.
        $vids = array();
        $vocabularies = taxonomy_vocabulary_get_names();
        foreach ($field['settings']['allowed_values'] as $tree) {
            $vids[] = $vocabularies[$tree['vocabulary']]->vid;
        }

        $query = db_select('taxonomy_term_data', 't');
        $query->addTag('translatable');
        $query->addTag('term_access');

        // Do not select already entered terms.
        if (!empty($tags_typed)) {
            $query->condition('t.name', $tags_typed, 'NOT IN');
        }
        // Select rows that match by term name.
        $tags_return = $query
            ->fields('t', array('tid', 'name'))
            ->condition('t.vid', $vids)
            ->condition('t.name', '%' . db_like($tag_last) . '%', 'LIKE')
            ->range(0, 10)
            ->execute()
            ->fetchAllKeyed();

        $prefix = count($tags_typed) ? drupal_implode_tags($tags_typed) . ', ' : '';

        foreach ($tags_return as $tid => $name) {
            $n = $name;
            // Term names containing commas or quotes must be wrapped in quotes.
            if (strpos($name, ',') !== FALSE || strpos($name, '"') !== FALSE) {
                $n = '"' . str_replace('"', '""', $name) . '"';
            }
            $term_matches[$prefix . $n] = check_plain($name);
        }
    }

    drupal_json_output($term_matches);
}

