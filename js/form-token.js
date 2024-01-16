/**
 * @file
 * Defines Javascript behaviors for the Tome Forms module. TODO
 */

// Drupal.behaviors is not working for FKW reasons, so ditching it. There's no
// AJAX anyway!
(async () => {
  const response = await fetch(drupalSettings.tome_forms.formTokenPath);
  const token = await response.text();
  console.log(token);

  document.getElementsByName('tome_form_token')[0].value = token;
})()

