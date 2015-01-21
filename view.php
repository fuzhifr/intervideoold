<?php

// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Prints a particular instance of intervideoold
 *
 * You can have a rather longer description of the file as well,
 * if you like, and it can span multiple lines.
 *
 * @package    mod
 * @subpackage intervideoold
 * @copyright  2011 Your Name
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/// (Replace intervideoold with the name of your module and remove this line)

require_once(dirname(dirname(dirname(__FILE__))).'/config.php');
require_once(dirname(__FILE__).'/lib.php');

$id = optional_param('id', 0, PARAM_INT); // course_module ID, or
$n  = optional_param('n', 0, PARAM_INT);  // intervideoold instance ID - it should be named as the first character of the module

if ($id) {
    $cm         = get_coursemodule_from_id('intervideoold', $id, 0, false, MUST_EXIST);
    $course     = $DB->get_record('course', array('id' => $cm->course), '*', MUST_EXIST);
    $intervideoold  = $DB->get_record('intervideoold', array('id' => $cm->instance), '*', MUST_EXIST);
} elseif ($n) {
    $intervideoold  = $DB->get_record('intervideoold', array('id' => $n), '*', MUST_EXIST);
    $course     = $DB->get_record('course', array('id' => $intervideoold->course), '*', MUST_EXIST);
    $cm         = get_coursemodule_from_instance('intervideoold', $intervideoold->id, $course->id, false, MUST_EXIST);
} else {
    error('You must specify a course_module ID or an instance ID');
}

require_login($course, true, $cm);
$context = get_context_instance(CONTEXT_MODULE, $cm->id);

add_to_log($course->id, 'intervideoold', 'view', "view.php?id={$cm->id}", $intervideoold->name, $cm->id);

/// Print the page header

$PAGE->set_url('/mod/intervideoold/view.php', array('id' => $cm->id));
$PAGE->set_title(format_string($intervideoold->name));
$PAGE->set_heading(format_string($course->fullname));
$PAGE->set_context($context);

// other things you may want to set - remove if not needed
//$PAGE->set_cacheable(false);
//$PAGE->set_focuscontrol('some-html-id');
//$PAGE->add_body_class('intervideoold-'.$somevar);

// Output starts here
echo $OUTPUT->header();

if ($intervideoold->intro) { // Conditions to show the intro can change to look for own settings or whatever
    echo $OUTPUT->box(format_module_intro('intervideoold', $intervideoold, $cm->id), 'generalbox mod_introbox', 'intervideooldintro');
}
Global $USER;
// Replace the following lines with you own code
echo $OUTPUT->heading($USER->username);
$username=$USER->username;
if(has_capability('mod/intervideoold:view',$context)&&has_capability('mod/intervideoold:submit',$context)){
	echo "<iframe src='cacophony-test/index.html?username=$username' width=100% height=700px>
				<p>Your browser does not support iframes.</p>
			</iframe>";
}else{
	echo "Désole ".$username.", vous n'avez pas les capabilités";
}
// Finish the page
echo $OUTPUT->footer();
