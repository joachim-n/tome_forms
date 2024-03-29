<?php

/**
 * @file
 * Hooks provided by the Tome Forms module.
 */

/**
 * @addtogroup hooks
 * @{
 */

/**
 * Perform alterations on Tome Form Handler definitions.
 *
 * @param array &$info
 *   Array of information on Tome Form Handler plugins.
 */
function hook_tome_form_handler_info_alter(array &$info) {
  // Change the class of the 'foo' plugin.
  $info['foo']['class'] = SomeOtherClass::class;
}

/**
 * Perform alterations on Tome Form Security definitions.
 *
 * @param array &$info
 *   Array of information on Tome Form Security plugins.
 */
function hook_tome_form_security_info_alter(array &$info) {
  // Change the class of the 'foo' plugin.
  $info['foo']['class'] = SomeOtherClass::class;
}

/**
 * @} End of "addtogroup hooks".
 */
