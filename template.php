<?php

/**
 * @file
 * This file is empty by default because the base theme chain (Alpha & Omega) provides
 * all the basic functionality. However, in case you wish to customize the output that Drupal
 * generates through Alpha & Omega this file is a good place to do so.
 * 
 * Alpha comes with a neat solution for keeping this file as clean as possible while the code
 * for your subtheme grows. Please read the README.txt in the /preprocess and /process subfolders
 * for more information on this topic.
 */

/**
 * implements hook_preprocess_page()
 *
 **/
function ishojsub_preprocess_html(&$variables) { 
  drupal_add_css(path_to_theme() . '/css/font-awesome/css/font-awesome.min.css');
  //$file = theme_get_setting('theme_color') . '-style.css';
  //drupal_add_css(path_to_theme() . '/css/'. $file, array('group' => CSS_THEME, 'weight' => 115,'browsers' => array(), 'preprocess' => FALSE));
}

/**
 * Implements template_process_page().
 */
function ishojsub_process_page(&$variables, $hook) {
  // Hook into color.module.
  if (module_exists('color')) {
    _color_page_alter($variables);
  }
}


function ishojsub_preprocess_page(&$variables, $hook) {
  // Add the site structure term id to the page div
  $node = node_load(arg(1));

  if(is_object($node) && isset($node->field_site_structure))
  {
    $termParents = taxonomy_get_parents($node->field_site_structure[LANGUAGE_NONE][0]['tid']);
    $termId = 'tid-'.$node->field_site_structure[LANGUAGE_NONE][0]['tid'];
    $termIdParent = "";
    if(!empty($termParents))
    {
      $termIdParent = 'tid-'.key($termParents);  
    }

    $variables['attributes_array']['class'] = $termIdParent . ' ' . $termId;
  }
}

function ishojsub_image_style($variables) {
  // Determine the dimensions of the styled image.
  $dimensions = array(
    'width' => $variables['width'], 
    'height' => $variables['height'],
  );

  image_style_transform_dimensions($variables['style_name'], $dimensions);

  $variables['width'] = $dimensions['width'];
  $variables['height'] = $dimensions['height'];

  $variables['attributes'] = array(
    'class' => $variables['style_name'],
  );

  // Determine the url for the styled image.
  $variables['path'] = image_style_url($variables['style_name'], $variables['path']);
  return theme('image', $variables);
}

/**
 * Implements hook_form_alter().
 */
function ishojsub_form_alter(&$form, &$form_state, $form_id) {
  if ($form_id == 'search_block_form') {
    $form['search_block_form']['#attributes']['placeholder'] = t('Hvad kan vi hjælpe med?');
  }

}
