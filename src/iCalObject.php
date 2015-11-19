<?php

# Copyright 2015 Julian Ospald <hasufell@hasufell.de>
#
# Permission is hereby granted, free of charge, to any person
# obtaining a copy of this software and associated documentation files
# (the "Software"), to deal in the Software without restriction,
# including without limitation the rights to use, copy, modify, merge,
# publish, distribute, sublicense, and/or sell copies of the Software,
# and to permit persons to whom the Software is furnished to do so,
# subject to the following conditions:
#
# The above copyright notice and this permission notice shall be
# included in all copies or substantial portions of the Software.
#
# THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
# EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
# MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
# NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
# LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
# OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION
# WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
namespace MsiCal;
include 'iCalProperties.php';

/**
 * A set of classes and functions to deal with the iCalendar format
 *
 * Also see the specification @link http://www.kanzaki.com/docs/ical/
 *
 * @package iCal
 * @author Julian Ospald <hasufell@hasufell.de>
 * @copyright MIT
 */

/**
 * An abstract class for any kind of iCalender object
 *
 * @abstract
 */
abstract class iCalObject
{
    /**
     * The properties of the iCalendar object
     *
     * See the specification: @link http://www.kanzaki.com/docs/ical/
     * Initialized as null.
     *
     * @access protected
     * @var iCalProperties
     */
    protected    $properties    = null;
    /**
     * The child objects, if any
     *
     * Initialized as empty array.
     *
     * @access protected
     * @var iCalObject[]
     */
    protected    $child_objects = [];
    /**
     * The valid childs for this kind of object
     *
     * This is used to determine
     * in @see childIsValid if the given child is allowed. Initialized as
     * empty array. Represents the calendar components, such as "VEVENT".
     *
     * @access protected
     * @var string[]
     */
    protected    $valid_childs  = [];

    /**
     * Adds a child object to the current object
     *
     * @param iCalObject $child the child object to add
     * @throws if the child is not valid, throws an exception
     */
    function addChild(iCalObject $child)
    {
        if ($this->childIsValid($child) === true) {
            array_push($this->child_objects, $child);
        } else {
            throw new \Exception("Invalid child: " . get_class($child));
        }
    }

    /**
     * Checks if the child is valid for the current object
     *
     * @param iCalObject $child the child to validate
     * @return bool true if the child is valid, false otherwise
     */
    function childIsValid(iCalObject $child)
    {
        $classname = strtoupper(get_class($child));
        return in_array($classname, $this->valid_childs);
    }

    /**
     * The standard toString function
     *
     * This is used to print the actual iCalendar object in proper
     * string format, suitable for serving.
     */
    function __toString()
    {
        $classname = strtoupper(get_class($this));
        $mystring = "BEGIN:" .$classname. "\n";
        $mystring .= $this->properties;

        foreach($this->child_objects as $child) {
            $mystring .= $child;
        }

        $mystring .= "END:" .$classname. "\n";

        return $mystring;
    }
}

/**
 * Class for the "VCALENDAR" component
 */
class VCalendar extends iCalObject
{
    protected $valid_childs = [
        "MSICAL\\VEVENT"
        ,"MSICAL\\VTIMEZONE"
    ];

    function __construct(VCalendarProperties $properties, array $childs)
    {
        $this->properties = $properties;

        foreach($childs as $child) {
            $this->addChild($child);
        }
    }
}

/**
 * Class for the "VEVENT" component
 */
class VEvent extends iCalObject
{

    function __construct(VEventProperties $properties)
    {
        $this->properties = $properties;
    }
}


/**
 * Class for the "VTIMEZONE" component
 */
class VTimezone extends iCalObject
{
    protected $valid_childs = [
          "MSICAL\\DAYLIGHT"
        , "MSICAL\\STANDARD"
    ];

    function __construct(VTimezoneProperties $properties, array $childs)
    {
        $this->properties = $properties;

        foreach($childs as $child) {
            $this->addChild($child);
        }
    }
}

/**
 * Class for the "DAYLIGHT" component
 */
class Daylight extends iCalObject
{
    function __construct(DaylightProperties $properties)
    {
        $this->properties = $properties;
    }
}

/**
 * Class for the "STANDARD" component
 */
class Standard extends iCalObject
{
    function __construct(VTimezoneProperties $properties)
    {
        $this->properties = $properties;
    }
}

/**
 * Print a vcalendar
 *
 * This is used for serving the actual calendar once it has been
 * constructed.
 *
 * @param VCalendar $cal the calendar to print
 */
function print_vcalendar(VCalendar $cal)
{
	echo $cal;
}

?>
