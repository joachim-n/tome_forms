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
 * Perform alterations on Static Form Handler definitions.
 *
 * @param array &$info
 *   Array of information on Static Form Handler plugins.
 */
function hook_static_form_handler_info_alter(array &$info) {
  // Change the class of the 'foo' plugin.
  $info['foo']['class'] = SomeOtherClass::class;
}

/**
 * @} End of "addtogroup hooks".
 */
