<?php
/**
 * Flexsmith
 *
 * @package flexsmith
 */



if (!defined('ABSPATH')) {
  exit;
}
$icon_and_text = new \Blockbooster\IconAndText_Block('block-booster-icon-and-text', $attributes);
$block_booster_text = !empty($attributes['text']) ? $attributes['text'] : '';
$block_booster_image_url = !empty($attributes['imageUrl']) ? $attributes['imageUrl'] : '';
$block_booster_image_is_svg = strtolower(pathinfo($block_booster_image_url, PATHINFO_EXTENSION)) === 'svg';
$block_booster_image_content = !empty($attributes['imageContent']) ? $attributes['imageContent'] : '';

$block_booster_svg_allowed_attributes = array(
  'svg' => array(
    'class' => true,
    'aria-hidden' => true,
    'role' => true,
    'xmlns' => true,
    'width' => true,
    'height' => true,
    'viewbox' => true,
    'fill' => true,
  ),
  'path' => array(
    'd' => true,
    'fill' => true,
  ),
);
?>
<?php // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
<div <?php echo get_block_wrapper_attributes($icon_and_text->wrapper_attributes()); ?>>
  <div class="block-booster-icon-and-text--left">
    <?php if (!empty($attributes['imageUrl'])) { ?>
      <?php if ($block_booster_image_is_svg) { ?>
        <?php
        echo wp_kses(
          $block_booster_image_content,
          $block_booster_svg_allowed_attributes
        );
        ?>
      <?php } else { ?>
        <img src="<?php echo esc_url($attributes['imageUrl']); ?>" alt="<?php echo esc_attr($attributes['imageName']); ?>" width="<?php echo esc_attr($block_booster_image_width); ?>" height="<?php echo esc_attr($block_booster_image_height); ?>"> <?php } ?>
    <?php } ?>
  </div>
  <div class="block-booster-icon-and-text--right">
    <?php echo wp_kses_post($block_booster_text); ?>
  </div>
</div>