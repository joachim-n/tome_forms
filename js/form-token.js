/**
 * @file
 * Adds values from the PHP script into the form.
 */

// Drupal.behaviors is not working for FKW reasons, so ditching it. There's no
// AJAX anyway!
(async () => {
  // Get the form values from the PHP script.
  const response = await fetch(drupalSettings.tome_forms.formTokenPath);
  const json = await response.json();
  console.log(json);

  // Set them on the hidden form elements which were added by hook_form_alter().
  document.getElementsByName('tome_form_token')[0].value = json['token'];
  document.getElementsByName('tome_form_timestamp')[0].value = json['timestamp'];
})()

