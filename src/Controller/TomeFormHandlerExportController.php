<?php

namespace Drupal\tome_forms\Controller;

use Drupal\tome_forms\Entity\TomeFormInterface;
use Symfony\Component\HttpFoundation\Response;

/**
 * TODO: class docs.
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
