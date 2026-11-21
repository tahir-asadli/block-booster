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

?>
<?php // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
<div <?php echo get_block_wrapper_attributes($icon_and_text->wrapper_attributes()); ?>>
  <div class="block-booster-icon-and-text--left">left </div>
  <div class="block-booster-icon-and-text--right">right </div>
  <?php
  // if (!empty($block->inner_blocks)) {
  //   foreach ($block->inner_blocks as $flexsmith_inner_block) {
  //     echo $flexsmith_inner_block->render();
  //   }
  // }
  
  ?>
</div>