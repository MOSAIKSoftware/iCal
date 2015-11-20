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
     * This array holds the members of the current object and
     * is used in the default constructor to be merged with
     * an incoming array which may be empty or only have a few
     * keys defined.
     *
     * The keys usually match the component string in the iCal file
     * and are relied upon in @see __toString().
     *
     * @access protected
     * @var array
     */
    protected $memberArray = [];

    /**
     * The standard toString function
     *
     * This is used to print the actual iCalendar object in proper
     * string format, suitable for serving.
     */
    function __toString()
    {
        $reflect = new \ReflectionClass($this);
        $classname = strtoupper($reflect->getShortName());
        $mystring = "BEGIN:" .$classname. "\n";

        foreach($this->memberArray as $key => $value) {
            // if the member is a string, just print it
            if (is_string($value) === true) {
                $mystring .= $key. ":" .$value. "\n";
            // if it's an array, it can be a list of VEVENTS or VTODOS
            } else if (is_array($value) === true) {
                foreach($value as $val) {
                    $mystring .= $val;
                }
            // if it's an object (e.g. VEVENT), then call __toString
            //  recursively on it
            } else if (method_exists($value, "__toString") === true) {
                $mystring .= $value;
            }
        }

        $mystring .= "END:" .$classname. "\n";

        return $mystring;
    }

    /**
     * Default constructor
     *
     * Merges the incoming array with the object defaults.
     *
     * @param array $incoming the array containing the object configuration
     */
    function __construct(array $incoming)
    {
        // a little indirection to avoid injecting new invalid keys
        $values = array_merge($this->memberArray, array_intersect_key($incoming,
            $this->memberArray));
        foreach($values as $key => $value) {
            $this->memberArray[$key] = $value;
        }
    }

    /**
     * Checks if the given child object has a valid class
     *
     * stdClass is always valid.
     *
     * @param $childObject the child object
     * @param $classname the class name we expect (other than stdClass)
     * @throws if the class is invalid
     */
    function validClassForChild($childObject, $classname)
    {
        $reflect = new \ReflectionClass($childObject);
        $realclassname = $reflect->getShortName();

        if ($realclassname !== "stdClass" &&
                $realclassname !== $classname) {
                throw new \Exception("Invalid class " .$realclassname.
                    " for child object! Expected stdClass or " .$classname);
        }
    }
}

/**
 * Class for the "VCALENDAR" component
 */
class VCalendar extends iCalObject
{
    private $version  = "";
    private $method   = "";
    private $prodid   = "";
    private $calname  = "";
    private $caldesc  = "";
    private $calcolor = "";
    private $timezone = "";
    private $calscale = "";

    private $vtimezone = null;
    private $vevents   = [];
    private $vtodo     = null;

    function __construct(array $incoming)
    {
        $this->memberArray = [
              "VERSION"                => &$this->version
            , "METHOD"                 => &$this->method
            , "PRODID"                 => &$this->prodid
            , "X-WR-CALNAME"           => &$this->calname
            , "X-WR-CALDESC"           => &$this->caldesc
            , "X-APPLE-CALENDAR-COLOR" => &$this->calcolor
            , "X-WR-TIMEZONE"          => &$this->timezone

            , "VTIMEZONE"              => &$this->vtimezone
            , "VEVENTS"                => &$this->vevent
            , "VTODO"                  => &$this->vtodo
        ];

        $this->vtimezone = new \stdClass();
        $this->vtodo = new \stdClass();

        parent::__construct($incoming);

        $this->validClassForChild($this->vtimezone, "VTimezone");
        foreach($this->vevents as $vevent) {
            $this->validClassForChild($vevent, "VEvent");
        }
        $this->validClassForChild($this->vtodo, "VTodo");
    }
}

/**
 * Class for the "VEVENT" component
 */
class VEvent extends iCalObject
{
    private $uid         = "";
    private $dtstart     = "";
    private $dtend       = "";
    private $summary     = "";
    private $description = "";
    private $dtstamp     = "";

    function __construct(array $incoming)
    {
        $this->memberArray = [
              "UID"         => &$this->uid
            , "DTSTART"     => &$this->dtstart
            , "DTEND"       => &$this->dtend
            , "SUMMARY"     => &$this->summary
            , "DESCRIPTION" => &$this->description
            , "DTSTAMP"     => &$this->dtstamp
        ];

        parent::__construct($incoming);
    }
}

/**
 * Class for the "VTODO" component
 */
class VTodo extends iCalObject
{


}

/**
 * Class for the "VTIMEZONE" component
 */
class VTimezone extends iCalObject
{
    private $tzid = "";

    private $daylight = null;
    private $standard = null;

    function __construct(array $incoming)
    {
        $this->memberArray = [
              "TZID"     => &$this->tzid
            , "DAYLIGHT" => &$this->daylight
            , "STANDARD" => &$this->standard
        ];

        $this->daylight = new \stdClass();
        $this->standard = new \stdClass();

        parent::__construct($incoming);

        $this->validClassForChild($this->daylight, "Daylight");
        $this->validClassForChild($this->standard, "Standard");
    }

}

/**
 * Class for the "DAYLIGHT" component
 */
class Daylight extends iCalObject
{
    private $tzoffsetfrom = "";
    private $tzoffsetto   = "";
    private $dtstart      = "";
    private $tzname       = "";

    function __construct(array $incoming)
    {
        $this->memberArray = [
              "TZOFFSETFROM" => &$this->tzoffsetfrom
            , "TZOFFSETTO"   => &$this->tzoffsetto
            , "DTSTART"      => &$this->dtstart
            , "TZNAME"       => &$this->tzname
        ];

        parent::__construct($incoming);
    }
}

/**
 * Class for the "STANDARD" component
 */
class Standard extends Daylight
{
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

