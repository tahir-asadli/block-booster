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

final class CategoryCard_Block
{

  private $id = '';
  private $attributes = [];
  public $block_name = '';

  // private const CLASS_PROPS = [
  //   'disableCSS' => 'reversed',
  //   'vertical' => 'stacked',
  // ];

  private const STYLE_PROPS = array(
    'gap' => 'gap',
  );

  private const SVG_STYLE_PROPS = array(
    'imageWidth' => 'width',
  );

  private const BREAKPOINTS = array(
    '' => 'only screen',
    'tablet' => '(min-width: 481px) and (max-width: 782px)',
    'mobile' => '(max-width: 480px)',
  );

  public function __construct($block_name, $attributes = [])
  {
    $this->block_name = $block_name;
    $this->id = wp_unique_id($this->block_name . '-');
    $this->attributes = $attributes;
    $this->add_inline_styles();
  }

  private function attribute_key(string $breakpoint, string $name): string
  {
    return '' === $breakpoint ? $name : $breakpoint . ucfirst($name);
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
    if (!empty($this->attributes['vertical']) && true === $this->attributes['vertical']) {
      $classes[] = 'block-booster-category-card--vertical';
    }
    if (!empty($this->attributes['disableCSS']) && true === $this->attributes['disableCSS']) {
      $classes[] = 'block-booster-category-card--no-css';
    }
    return $classes;
  }



  public function add_inline_styles()
  {
    $css = '';
    foreach (self::BREAKPOINTS as $breakpoint => $media) {
      $rules = '';
      $svg_selector = $this->id . ' .block-booster-category-card--image-wrapper';

      if ($rules) {
        $css .= sprintf('@media %s{#%s{%s}}', $media, $svg_selector, $rules);
      }
      $rules = '';
      foreach (self::STYLE_PROPS as $name => $property) {
        $key = $this->attribute_key($breakpoint, $name);
        if (empty($this->attributes[$key])) {
          continue;
        }
        if ($key == 'imageWidth') {
          $declaration = safecss_filter_attr($property . ':' . $this->attributes[$key] . 'px');
        } else {
          $declaration = safecss_filter_attr($property . ':' . $this->attributes[$key]);
        }
        if ($declaration) {
          $rules .= $declaration . ';';
        }
      }
      if ($rules) {
        $css .= sprintf('@media %s{#%s{%s}}', $media, $this->id, $rules);
      }
      $rules = '';
      $the_selector = $this->id . ' .block-booster-category-card--image-wrapper';
      foreach (self::SVG_STYLE_PROPS as $name => $property) {
        $key = $this->attribute_key($breakpoint, $name);
        if (empty($this->attributes[$key])) {
          continue;
        }
        if ($key == 'imageWidth') {
          $declaration = safecss_filter_attr('width' . ':' . $this->attributes[$key] . 'px');
          $rules .= $declaration . ';';
          $declaration = safecss_filter_attr('height' . ':' . $this->attributes[$key] . 'px');
          $rules .= $declaration . ';';
          $declaration = safecss_filter_attr('border-radius' . ':' . $this->attributes[$key] . 'px');
          $rules .= $declaration . ';';

        } else {
          $declaration = safecss_filter_attr($property . ':' . $this->attributes[$key]);
          $rules .= $declaration . ';';
        }
      }
      if ($rules) {
        $css .= sprintf('@media %s{#%s{%s}}', $media, $the_selector, $rules);
      }
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