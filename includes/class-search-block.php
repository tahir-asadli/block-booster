<?php
/**
 * Flexsmith
 *
 * @package block-booster
 */

namespace Blockbooster;


if (!defined('ABSPATH')) {
  exit;
}

final class Search_Block
{

  private $id = '';
  private $attributes = [];
  public $block_name = '';

  private const STYLE_PROPS = array(
    'width' => 'width',
    'height' => 'height',
  );

  public function getId()
  {
    return $this->id;
  }

  public function __construct($block_name, $attributes = [])
  {
    $this->block_name = $block_name;
    $this->id = wp_unique_id($this->block_name . '-');
    $this->attributes = $attributes;
    $this->add_inline_styles();
  }


  public function wrapper_attributes()
  {
    return array(
      'class' => implode(' ', $this->get_classes()),
      'id' => $this->id,
    );
  }

  public function get_classes()
  {
    $classes = array($this->block_name);

    $block_booster_show_category = !empty($this->attributes['showCategory']) && true === $this->attributes['showCategory'];
    $block_booster_show_search_icon = !empty($this->attributes['showSearchIcon']) && true === $this->attributes['showSearchIcon'];
    $block_booster_disable_css = !empty($this->attributes['disableCSS']) && true === $this->attributes['disableCSS'];
    if (!$block_booster_disable_css) {
      $classes[] = 'has-style';
    }
    if ($block_booster_show_search_icon) {
      $classes[] = 'show-search-icon';
    }
    if ($block_booster_show_category) {
      $classes[] = 'show-category';
    }
    return $classes;

  }



  public function add_inline_styles()
  {
    $css = '';
    $rules = '';
    foreach (self::STYLE_PROPS as $name => $property) {
      if (empty($this->attributes[$name])) {
        continue;
      }
      $declaration = safecss_filter_attr($property . ':' . $this->attributes[$name]);
      if ($declaration) {
        $rules .= $declaration . ';';
      }
    }
    if ($rules) {
      $css .= sprintf('#%s{%s}', $this->id, $rules);
    }
    if (!empty($css)) {
      wp_register_style($this->block_name, false, [], BLOCK_BOOSTER_VERSION);
      wp_enqueue_style($this->block_name);
      wp_add_inline_style(
        $this->block_name,
        $css
      );
    }

  }
}

?>