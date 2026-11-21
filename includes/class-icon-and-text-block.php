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

final class IconAndText_Block
{

  private $id = '';
  private $attributes = [];
  public $block_name = '';

  private const CLASS_PROPS = [
    'reversed' => 'reversed',
    'stacked' => 'stacked',
  ];


  private const STYLE_PROPS = array(
    'width' => 'width',
    'columnGap' => 'column-gap',
    'rowGap' => 'row-gap',
    'top' => 'top',
    'right' => 'right',
    'bottom' => 'bottom',
    'left' => 'left',
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
    // $this->add_inline_styles();
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

    foreach (self::CLASS_PROPS as $slug => $name) {

      foreach (array_keys(self::BREAKPOINTS) as $breakpoint) {

        $key = $this->attribute_key($breakpoint, $slug);

        if (empty($this->attributes[$key])) {
          continue;
        }
        $value = $this->attributes[$key];
        if (is_bool($value)) {
          if ($value === true) {
            $classes[] = sanitize_html_class(
              '' === $breakpoint
              ? $this->block_name . "--is-{$name}"
              : $this->block_name . "--{$breakpoint}-is-{$name}"
            );
          }
        } else {
          $classes[] = sanitize_html_class(
            '' === $breakpoint
            ? $this->block_name . "--{$name}-{$value}"
            : $this->block_name . "--{$name}-{$breakpoint}-{$value}"
          );
        }

      }
    }
    return $classes;

  }
}

?>