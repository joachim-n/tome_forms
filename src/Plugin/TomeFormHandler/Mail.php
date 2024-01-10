<?php

namespace Drupal\tome_forms\Plugin\TomeFormHandler;

/**
 * TODO: class docs.
 *
 * @TomeFormHandler(
 *   id = "mail",
 *   label = @Translation("Mail"),
 * )
 */
class Mail extends TomeFormHandlerBase {

  public function getFormHandlerScriptPhp(): string {
    return <<<'EOPHP'
      <?php

      // Instantiate Script. You MUST edit these values:
      $to = 'you@example.com';
      $cc = '';
      $site_mail = 'site@example.com';
      $script_is_ready = FALSE; // Change to true when the above are correct!

      if ($script_is_ready && isset($_POST['form_id']) && ($_POST['form_id'] === 'static_site_contact_form')) {
        if (empty($_POST['h_mail'])) {
          $form_submitter = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL); // this is the sender's Email address
          $name = filter_var($_POST['name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
          $subject = "Form submission on " . $_POST['host'];
          $message = $name . " wrote the following:" . "\n\n" . filter_var($_POST['message'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

          $headers = [
            'From: ' . $site_mail,
            'Cc: ' . $cc,
            'Reply-To: ' . $form_submitter,
          ];
          // Send email to yourself, with form values.
          mail($to,$subject,$message,implode("\r\n", $headers));

          if ($_POST['send_copy']) {
            // Prepare a copy to send to the submitter of the form.
            $subject2 = "Copy of your form submission";
            $message2 = $name . " here is a copy of your message: \n\n" . $_POST['message'];
            $headers2 = "From:" . $to;
            mail($form_submitter,$subject2,$message2,$headers2);
          }

          // Redirect back to site.
          $location = 'Location: ' . $_POST['return_to'];
          header($location);
        }
      }
      else {
        // If you somehow landed on the script without submitting the form, go to the frontpage.
        header('Location: /');
      }
    EOPHP;
  }

}
