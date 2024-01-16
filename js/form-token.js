/**
 * @file
 * Defines Javascript behaviors for the Tome Forms module. TODO
 */

(function ($, Drupal, drupalSettings) {
  'use strict';

  Drupal.behaviors.tomeForms = {
    attach: function (context, settings) {
      console.log(drupalSettings.tome_forms.formTokenPath);
      console.log('fuck');

      const response = fetch(drupalSettings.tome_forms.formTokenPath);
      const token = response.body;
      console.log(token);

      document.getElementsByName('tome_form_token')[0].value = token;

      // tome_form_token
    }
  };
})(Drupal, drupalSettings);
