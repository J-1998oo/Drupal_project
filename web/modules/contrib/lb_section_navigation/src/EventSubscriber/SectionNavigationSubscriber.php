<?php

namespace Drupal\lb_section_navigation\EventSubscriber;

use Drupal\Component\Utility\SortArray;
use Drupal\Core\Link;
use Drupal\Core\Url;
use Drupal\layout_builder\Event\SectionComponentBuildRenderArrayEvent;
use Drupal\layout_builder\LayoutBuilderEvents;
use Drupal\layout_builder\SectionStorage\SectionStorageManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Section navigation event subscriber.
 */
class SectionNavigationSubscriber implements EventSubscriberInterface {

  /**
   * The section storage manager.
   *
   * @var \Drupal\layout_builder\SectionStorage\SectionStorageManagerInterface
   */
  protected $sectionStorageManager;

  /**
   * Constructs event subscriber.
   */
  public function __construct(SectionStorageManagerInterface $sectionStorageManager) {
    $this->sectionStorageManager = $sectionStorageManager;
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    // Layout Builder also subscribes to this event to build the initial render
    // array. We use a higher weight so that we execute after it.
    $events[LayoutBuilderEvents::SECTION_COMPONENT_BUILD_RENDER_ARRAY] = ['onBuildRender', 50];
    return $events;
  }

  /**
   * Add an id to components in the render array.
   *
   * @param \Drupal\layout_builder\Event\SectionComponentBuildRenderArrayEvent $event
   *   The section component render event.
   */
  public function onBuildRender(SectionComponentBuildRenderArrayEvent $event) {
    $build = $event->getBuild();
    if (empty($build)) {
      return;
    }

    $sectionStorage = $this->sectionStorageManager->findByContext(
      $event->getContexts(),
      $event->getCacheableMetadata()
    );

    if (empty($sectionStorage)) {
      return;
    }

    $section = $this->getParentSection($event->getComponent(), $sectionStorage->getSections());
    if ($section) {
      if ($event->getPlugin()->getPluginId() === 'section_navigation_block') {
        $build['content'] = $this->buildSectionLinks($section, $event->getComponent(), $event->getContexts());
      }
      elseif ($this->sectionHasNavigationBlock($section, $event->getContexts())) {
        $build['#attributes']['id'] = $event->getComponent()->get('uuid');
      }
      $event->setBuild($build);
    }
  }

  /**
   * Given a component, return the section it belongs to.
   */
  protected function getParentSection($component, $sections) {
    foreach ($sections as $section) {
      // Component belongs to this section.
      if (in_array($component, $section->getComponents())) {
        return $section;
      }
    }
  }

  /**
   * Wether a given section has a navigation inside it.
   */
  protected function sectionHasNavigationBlock($section, $contexts) {
    foreach ($section->getComponents() as $componentUuid => $component) {
      if ($component->getPlugin($contexts)->getPluginId() === 'section_navigation_block') {
        return TRUE;
      }
    }
    return FALSE;
  }

  /**
   * Assemble a render array with the link to the components.
   */
  protected function buildSectionLinks($section, $currentComponent, $contexts) {
    $build = [
      '#theme' => 'section_navigation',
      '#links' => [],
    ];
    foreach ($section->getComponents() as $componentUuid => $component) {
      if ($componentUuid != $currentComponent->get('uuid')) {
        $build['#links'][$componentUuid] = Link::fromTextAndUrl(
          $component->getPlugin($contexts)->label(),
          Url::fromUserInput('#' . $componentUuid)
        )
          ->toRenderable();

        $build['#links'][$componentUuid]['#weight'] = $component->getWeight();
      }
    }
    uasort($build['#links'], [SortArray::class, 'sortByWeightProperty']);
    return $build;
  }

}
