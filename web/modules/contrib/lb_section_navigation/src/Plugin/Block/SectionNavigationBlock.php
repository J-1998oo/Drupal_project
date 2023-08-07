<?php

namespace Drupal\lb_section_navigation\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a placeholder block to be filled later.
 *
 * @see \Drupal\lb_section_navigation\EventSubscriber\SectionNavigationSubscriber;
 *
 * @Block(
 *   id = "section_navigation_block",
 *   admin_label = @Translation("Section navigation"),
 *   category = @Translation("Section navigation")
 * )
 */
class SectionNavigationBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build['content'] = [
      '#markup' => $this->t('Placeholder for the "Section navigation" block'),
    ];
    return $build;
  }

}
