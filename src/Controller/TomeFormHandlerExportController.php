<?php

namespace Drupal\tome_forms\Controller;

use Drupal\tome_forms\Entity\TomeFormInterface;
use Symfony\Component\HttpFoundation\Response;

/**
 * Controller for the form handler PHP script.
 *
 * This outputs raw PHP code for the Tome export process to write to a PHP file.
 *
 * @see \Drupal\tome_forms\EventSubscriber\StaticFormSubscriber
 */
class TomeFormHandlerExportController {

  /**
   * Callback for the tome_forms.tome_form_handler_export route.
   */
  public function content(TomeFormInterface $tome_form) {
    $php = $tome_form->getFormHandlerScriptPhp();
    $response = new Response($php);

    return $response;
  }

}
