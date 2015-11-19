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
 * A set of classes to abstract out the properties of various iCalendar
 * components
 *
 * Also see the specification @link http://www.kanzaki.com/docs/ical/
 *
 * @package iCal
 * @author Julian Ospald <hasufell@hasufell.de>
 * @copyright MIT
 */

/**
 * Abstract interface class for iCalendar properties
 */
abstract class iCalProperties {

}

/**
 * Class representing the properties for the "VCALENDAR" component
 */
class VCalendarProperties extends iCalProperties
{
    private $version  = "";
    private $method   = "";
    private $prodid   = "";
    private $calname  = "";
    private $caldesc  = "";
    private $calcolor = "";
    private $timezone = "";
    private $calscale = "";

    function __toString()
    {
        return "VERSION:"                .$this->version.  "\n".
               "METHOD:"                 .$this->method.   "\n".
               "PRODID:"                 .$this->prodid.   "\n".
               "X-WR-CALNAME:"           .$this->calname.  "\n".
               "X-WR-CALDESC:"           .$this->caldesc.  "\n".
               "X-APPLE-CALENDAR-COLOR:" .$this->calcolor. "\n".
               "X-WR-TIMEZONE:"          .$this->timezone. "\n";
    }

    function __construct($version, $method, $prodid, $calname,
            $caldesc, $calcolor, $timezone, $calscale)
    {
        $this->version  = $version;
        $this->method   = $method;
        $this->prodid   = $prodid;
        $this->calname  = $calname;
        $this->caldesc  = $caldesc;
        $this->calcolor = $calcolor;
        $this->timezone = $timezone;
        $this->calscale = $calscale;
    }
}

/**
 * Class representing the properties for the "VEVENT" component
 */
class VEventProperties extends iCalProperties
{
    private $uid         = "";
    private $dtstart     = "";
    private $dtend       = "";
    private $summary     = "";
    private $description = "";
    private $dtstamp     = "";

    function __toString()
    {
        return "UID:"         .$this->uid.         "\n".
               "DTSTART:"     .$this->dtstart.     "\n".
               "DTEND:"       .$this->dtend.       "\n".
               "SUMMARY:"     .$this->summary.     "\n".
               "DESCRIPTION:" .$this->description. "\n".
               "DTSTAMP:"     .$this->dtstamp.     "\n";
    }

    function __construct($uid, $dtstart, $dtend, $summary,
            $description, $dtstamp)
    {
        $this->uid         = $uid;
        $this->dtstart     = $dtstart;
        $this->dtend       = $dtend;
        $this->summary     = $summary;
        $this->description = $description;
        $this->dtstamp     = $dtstamp;
    }
}

/**
 * Class representing the properties for the "VTIMEZONE" component
 */
class VTimezoneProperties extends iCalProperties
{
    private $tzid = "";

    function __toString()
    {
        return "TZID:" .$this->tzid. "\n";
    }

    function __construct($tzid)
    {
        $this->tzid = $tzid;
    }

}

/**
 * Class representing the properties for the "DAYLIGHT" component
 */
class DaylightProperties extends iCalProperties
{
    private $tzoffsetfrom = "";
    private $tzoffsetto   = "";
    private $dtstart      = "";
    private $tzname       = "";

    function __toString()
    {
        return "TZOFFSETFROM:" .$this->tzoffsetfrom. "\n".
               "TZOFFSETTO:"   .$this->tzoffsetto.   "\n".
               "DTSTART:"      .$this->dtstart.      "\n".
               "TZNAME:"       .$this->tzname.       "\n";
    }

    function __construct($tzoffsetfrom, $tzoffsetto, $dtstart, $tzname)
    {
        $this->tzoffsetfrom = $tzoffsetfrom;
        $this->tzoffsetto   = $tzoffsetto;
        $this->dtstart      = $dtstart;
        $this->tzname       = $tzname;
    }
}

/**
 * Class representing the properties for the "STANDARD" component
 */
class StandardProperties extends DaylightProperties
{

}

class Defaults {
    public static $vcalendarProperties;
    public static $veventProperties;
    public static $vtimezoneProperties;
    public static $daylightProperties;
    public static $standardProperties;
}

// defaults for the properties
Defaults::$vcalendarProperties =  new VCalendarProperties(
    "", "", "", "", "", "", "", "");
Defaults::$veventProperties = new VEventProperties(
    "", "", "", "", "", "");
Defaults::$vtimezoneProperties = new VTimezoneProperties("");
Defaults::$daylightProperties = new DaylightProperties("", "", "", "");
Defaults::$standardProperties =  new StandardProperties("", "", "", "");
