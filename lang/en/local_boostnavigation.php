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
 * Local plugin "Boost navigation fumbling" - Language pack
 *
 * @package    local_boostnavigation
 * @copyright  2017 Alexander Bias, Ulm University <alexander.bias@uni-ulm.de>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['pluginname'] = 'Boost navigation fumbling';
$string['setting_currentcoursepresentation'] = 'Improve the current course\'s presentation in Boost\'s nav drawer';
$string['setting_currentcoursefullname'] = 'Switch shortname to fullname';
$string['setting_currentcoursefullname_desc'] = 'Enabling this setting will show the course\'s fullname instead of the course\'s shortname in Boost\'s nav drawer.<br />Technically, this can currently only be done by replacing the shortname globally at runtime, thus enabling this setting might have side effects to other parts of Moodle.';
$string['setting_removenodesheading'] = 'Remove root nodes from Boost\'s nav drawer';
$string['setting_removenodesperformancehint'] = 'Technically, this is done by setting the node\'s showinflatnavigation attribute to false. Thus, the node will only be hidden from the nav drawer, but it will remain in the navigation tree and can still be accessed by other parts of Moodle.';
$string['setting_removecalendarnode'] = 'Remove "Calendar" node';
$string['setting_removecalendarnode_desc'] = 'Enabling this setting will remove the "Calendar" node from Boost\'s nav drawer.';
$string['setting_removehomenode'] = 'Remove "Home" node';
$string['setting_removehomenode_desc'] = 'Enabling this setting will remove the "Home" node from Boost\'s nav drawer.';
$string['setting_removesecondhomenode'] = 'Remove second "Home" or "Dashboard" node';
$string['setting_removesecondhomenode_desc'] = 'Enabling this setting will remove the "Home" or "Dashboard" node, depending on what the user chose not to be his home page, from Boost\'s nav drawer.';
$string['setting_removedashboardnode'] = 'Remove "Dashboard" node';
$string['setting_removedashboardnode_desc'] = 'Enabling this setting will remove the "Dashboard" node from Boost\'s nav drawer.';
$string['setting_removemycoursesnode'] = 'Remove "My courses" node';
$string['setting_removemycoursesnode_desc'] = 'Enabling this setting will remove the "My courses" node from Boost\'s nav drawer.';
$string['setting_removemycoursesnodeperformancehint'] = 'Please note: If you enable this setting and have also enabled the setting <a href="/admin/search.php?query=navshowmycoursecategories">navshowmycoursecategories</a>, removing the "My courses" node takes more time and you should consider disabling the navshowmycoursecategories setting.';
$string['setting_removeprivatefilesnode'] = 'Remove "Private files" node';
$string['setting_removeprivatefilesnode_desc'] = 'Enabling this setting will remove the "Private files" node from Boost\'s nav drawer.';
