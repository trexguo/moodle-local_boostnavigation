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
 * Local plugin "Boost navigation fumbling" - Library
 *
 * @package    local_boostnavigation
 * @copyright  2017 Alexander Bias, Ulm University <alexander.bias@uni-ulm.de>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Fumble with Moodle's global navigation by leveraging Moodle's *_extend_navigation() hook.
 *
 * @param global_navigation $navigation
 */
function local_boostnavigation_extend_navigation(global_navigation $navigation) {
    global $PAGE, $CFG;

    // Fetch config.
    $config = get_config('local_boostnavigation');

    // Check if admin wanted us to remove the home node from Boost's nav drawer.
    if (isset($config->removehomenode) && $config->removehomenode == true) {
        // If yes, do it.
        if ($homenode = $navigation->find('home', global_navigation::TYPE_ROOTNODE)) {
            // Hide home node.
            $homenode->showinflatnavigation = false;
        }
    }

    // Check if admin wanted us to remove the calendar node from Boost's nav drawer.
    if (isset($config->removecalendarnode) && $config->removecalendarnode == true) {
        // If yes, do it.
        if ($calendarnode = $navigation->find('calendar', global_navigation::TYPE_CUSTOM)) {
            // Hide calendar node.
            $calendarnode->showinflatnavigation = false;
        }
    }

    // Check if admin wanted us to remove the privatefiles node from Boost's nav drawer.
    if (isset($config->removeprivatefilesnode) && $config->removeprivatefilesnode == true) {
        // If yes, do it.
        if ($privatefilesnode = local_boostnavigation_find_privatefiles_node($navigation)) {
            // Hide privatefiles node.
            $privatefilesnode->showinflatnavigation = false;
        }
    }

    // Check if admin wanted us to remove the mycourses node from Boost's nav drawer.
    if (isset($config->removemycoursesnode) && $config->removemycoursesnode == true) {
        // If yes, do it.
        if ($mycoursesnode = $navigation->find('mycourses', global_navigation::TYPE_ROOTNODE)) {
            // Hide mycourses node.
            $mycoursesnode->showinflatnavigation = false;

            // Hide all courses below the mycourses node.
            $mycourseschildrennodeskeys = $mycoursesnode->get_children_key_list();
            foreach ($mycourseschildrennodeskeys as $k) {
                // If the admin decided to display categories, things get slightly complicated.
                if ($CFG->navshowmycoursecategories) {
                    // We need to find all children nodes first.
                    $allchildrennodes = local_boostnavigation_get_all_childrenkeys($mycoursesnode->get($k));
                    // Then we can hide each children node.
                    // Unfortunately, the children nodes have navigation_node type TYPE_MY_CATEGORY or navigation_node type
                    // TYPE_COURSE, thus we need to search without a specific navigation_node type.
                    foreach ($allchildrennodes as $cn) {
                        $mycoursesnode->find($cn, null)->showinflatnavigation = false;
                    }
                }
                // Otherwise we have a flat navigation tree and hiding the courses is easy.
                else {
                    $mycoursesnode->get($k)->showinflatnavigation = false;
                }
            }
        }
    }

    // Check if admin wanted us to show the current course's shortname instead of the course's fullname in Boost's nav drawer.
    if (isset($config->currentcoursefullname) && $config->currentcoursefullname == true) {
        // If yes, do it.
        if (!empty($PAGE->course->shortname) && !empty($PAGE->course->fullname)) {
            // Unfortunately, the navigation node with the course's shortname is contained in the flat_navigation object and not in
            // the global_navigation object. We can't access flat_navigation here, so change the strings with a sledgehammer method.
            $PAGE->course->shortname = format_string($PAGE->course->fullname);
        }
    }
}


/**
 * Moodle core does not add a key to the privatefiles node when adding it to the navigation,
 * so we need to find it with some overhead.
 *
 * @param global_navigation $navigation
 * @return navigation_node
 */
function local_boostnavigation_find_privatefiles_node(global_navigation $navigation) {
    // Get front page course node.
    if ($coursenode = $navigation->find('1', null)) {
        // Get children of the front page course node.
        $coursechildrennodeskeys = $coursenode->get_children_key_list();

        // Get text string to look for.
        $needle = get_string('privatefiles');

        // Check all children to find the privatefiles node.
        foreach ($coursechildrennodeskeys as $k) {
            // Get child node.
            $childnode = $coursenode->get($k);
            // Check if we have found the privatefiles node.
            if ($childnode->text == $needle) {
                // If yes, return the node.
                return $childnode;
            }
        }
    }

    // This should not happen.
    return false;
}


/**
 * Moodle core does not have a built-in functionality to get all keys of all children of a navigation node,
 * so we need to get these ourselves.
 *
 * @param navigation_node $navigationnode
 * @return array
 */
function local_boostnavigation_get_all_childrenkeys(navigation_node $navigationnode) {
    // Empty array to hold all children.
    $allchildren = array();

    // No, this node does not have children anymore.
    if (count($navigationnode->children) == 0) {
        return array();
    }
    // Yes, this node has children.
    else {
        // Get own own children keys.
        $childrennodeskeys = $navigationnode->get_children_key_list();
        // Get all children keys of our children recursively.
        foreach ($childrennodeskeys as $ck) {
            $allchildren = array_merge($allchildren, local_boostnavigation_get_all_childrenkeys($navigationnode->get($ck)));
        }
        // And add our own children keys to the result.
        $allchildren = array_merge($allchildren, $childrennodeskeys);

        // Return everything.
        return $allchildren;
    }
}

