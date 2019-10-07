<?php

namespace Drupal\locale_ui_translations\Routing;

use Drupal\Core\Routing\RouteSubscriberBase;
use Drupal\migrate\Plugin\migrate\process\Route;
use Symfony\Component\Routing\RouteCollection;

/**
 * Add permissions.
 *
 * The permission "administer permissions" will give a user access
 * to add a role to a user, manage roles and change permissions.
 * These 3 things should not be managed by a single permission.
 * Drupal core is working on a solution but for now we add some extra
 * permissions of our own so we can make sure a user can add roles to
 * a newly created user without necessarily having access to the
 * permission page and the roles page.
 *
 * (https://www.drupal.org/project/drupal/issues/151311).
 */
class RouteSubscriber extends RouteSubscriberBase {

  /**
   * Alter the permissions.
   *
   * @param \Symfony\Component\Routing\RouteCollection $collection
   * @param $route_path
   * @param $permission
   */
  private function alterPermission(RouteCollection $collection, $route_path, $permission) {
    if ($collection->get($route_path)) {
      $route = $collection->get($route_path);
      $route->setRequirement('_permission', $permission);
    }
  }

  /**
   * {@inheritdoc}
   */
  protected function alterRoutes(RouteCollection $collection) {

    // Better permissions for permission management page.
    $route_paths = [
      'locale.settings' => 'translate interface settings',
      'locale.check_translation' => 'translate interface check translation',
      'locale.translate_page' => 'translate interface page',
      'locale.translate_import' => 'translate interface import',
      'locale.translate_export' => 'translate interface export',
      'locale.translate_status' => 'translate interface status',
      'potx.extract_translation' => 'translate interface extract'
    ];

    foreach ($route_paths as $route_path => $permission) {
        $this->alterPermission($collection, $route_path, $permission);
    }
  }

}
