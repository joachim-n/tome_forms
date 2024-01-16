# Tome Forms

This module allows Drupal forms to be exported a Tome static site, with the form
submission handled in a variety of ways.

This module is inspired by the [Static Site Contact Form
module](https://www.drupal.org/project/static_site_contact_form).

## Requirements

This module requires the following modules:

- [tome](https://www.drupal.org/project/tome)

## Installation

Install as you would normally install a contributed Drupal module. For further
information, see
[Installing Drupal Modules](https://www.drupal.org/docs/extending-drupal/installing-drupal-modules).

## Configuration

1. Go to Administration › Structure › Tome forms.
TODO create form security handlers
2. Click 'Add Tome form' to create a new Tome form configuration.
3. Enter the form ID of a form to use as a Tome static form.
4. Optionally, enter paths to export in Tome. If the path(s) on which your form
   is shown are already exported by Tome, leave this empty.
5. Select a form handler to use for this form. This determines what happens when
   the static version of the form is submitted.

## Usage

Deploy your Tome static site as normal. You can set form paths to add to the
export in the Tome form config entity, or take care of exporting them yourself.

## Developers

Each Tome static form is represented by a Tome form config entity. This uses a
Tome form handler plugin to create a PHP script which will handle the form
submission on the static site.

When the Tome static site is exported, a PHP script file is written to the
/tome-form-handler folder for each Tome form.

Forms in the HTML output which are the target of a Tome form config entity are
altered so that their form action points to the corresponding script. They also
have a honeypot form element added. TODO!

The script verifies the incoming form ID and the honeypot element. Further
actions of the script are specific to the form handler plugin. For example, the
mail form handler plugin sends all the form data in an email, whose recipient
can be configured in the Tome form config entity.

## Roadmap

- Add CSS library to hide honeypot form element
- Fix the Mail plugin so it sends the form data - remove assumptions from my
  frankencode.
- Consider whether to make the spam protection pluggable - are other methods of
  spam protection possible?
- Allow static forms to redirect to a custom path, e.g. a confirmation message
- Supply a basic confirmation message page?
- Add a form handler plugin to post to a REST endpoint?
- Consider adding a setting to output the form ID on every form, to help
  non-devs set up forms.
