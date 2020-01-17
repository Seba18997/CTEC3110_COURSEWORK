<?php
/** index.php
 * Coursework
 *
 * @package coursework
 */

$make_trace = true;

ini_set('xdebug.trace_output_name', 'coursework');
ini_set('display_errors', 'On');
ini_set('html_errors', 'On');


if ($make_trace == true && function_exists(xdebug_start_trace()))
{
    xdebug_start_trace();
}

include 'ctec3110coursework_private/bootstrap.php';

if ($make_trace == true && function_exists(xdebug_stop_trace()))
{
    xdebug_stop_trace();
}
