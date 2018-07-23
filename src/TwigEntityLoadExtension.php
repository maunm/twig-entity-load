<?php
namespace Drupal\twig_entity_load;

/**
 * Class DefaultService.
 *
 * @package Drupal\twig_entity_load
 */
class TwigEntityLoadExtension extends \Twig_Extension {

  /**
   * {@inheritdoc}
   * This function must return the name of the extension. It must be unique.
   */
  public function getName() {
    return 'twig_entity_load';
  }

  /**
   * {@inheritdoc}
   * In this function we can declare the extension function
   */
  public function getFunctions() {
    return array(
      new \Twig_SimpleFunction('load_entity',
        array($this, 'LoadEntity')
      ),
      new \Twig_SimpleFunction('load_entity_field',
        array($this, 'LoadEntityField')
      ),
      new \Twig_SimpleFunction('current_language',
        array($this, 'getCurrentLanguage')
      ),
      new \Twig_SimpleFunction('site_base_url',
        array($this, 'getSiteBaseURL')
      )
    );
  }

  /**
   * The php function to load a given entity
   *
   * @param string $entity_type
   *   The entity type name.
   * @param string $id
   *   The entity id.
   * @param string $view_mode
   *   The entity view mode.
   * @param integer $render
   *   Indicate response type.
   *
   * @return array
   *   A render o not render array of the entity.
   */
  public function LoadEntity($entity_type, $id = NULL, $view_mode = NULL, $render = NULL) {
    // get the entity type manager
    $entity_type_manager = \Drupal::entityTypeManager();
    // get the current language
    $language = \Drupal::languageManager()->getCurrentLanguage()->getId();
    // get the entity
    $entity = $id ? $entity_type_manager->getStorage($entity_type)->load($id) : \Drupal::routeMatch()->getParameter($entity_type);
    if ($entity) {
      if ($render === 1) {
        // render en return the entity
        $render_controller = $entity_type_manager->getViewBuilder($entity_type);
        return $render_controller->view($entity, $view_mode, $language);
      }
      else {
        // return the entity
        return $entity;
      }
    }
  }

  /**
   * The php function to load a given entity field
   *
   * @param string $entity_type
   *   The entity type name.
   * @param string $id
   *   The entity id.
   * @param string $field_name
   *   The entity field name.
   * @param integer $render
   *   Indicate response type.
   *
   * @return array
   *   A render o not render array of the entity.
   */
  public function LoadEntityField($entity_type, $id = NULL, $field_name = NULL, $render = NULL) {
    // get the entity type manager
    $entity_type_manager = \Drupal::entityTypeManager();
    // get the entity
    $entity = $id ? $entity_type_manager->getStorage($entity_type)->load($id) : \Drupal::routeMatch()->getParameter($entity_type);
    if ($entity) {
      $field = $entity->{$field_name};
      if ($render === 1) {
        // render en return the entity
        if (isset($field)) {
          return $field->view();
        }
      }
      else {
        // return the entity
        return $field;
      }
    }
  }

  /**
   * The php function to get the current language
   *
   * @return string
   *   A string with the language id.
   */
  public function getCurrentLanguage() {
    //To get the language code:
    $lan_id = \Drupal::languageManager()->getCurrentLanguage()->getId();

    if ($lan_id) {
      // return the data array
      return $lan_id;
    }
  }

  /**
   * The php function to get the site base path
   *
   * @return array
   *   A string with the base path.
   */
  public function getSiteBaseURL() {
    // get the base path
    $path = $GLOBALS['base_url'];

    if ($path) {
      // return the data
      return $path;
    }
  }
}
