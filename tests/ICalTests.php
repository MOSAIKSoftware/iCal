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

const EXPECTED_DEF_VCAL = "BEGIN:VCALENDAR\n" .
    "VERSION:\n" .
    "METHOD:\n" .
    "PRODID:\n" .
    "X-WR-CALNAME:\n" .
    "X-WR-CALDESC:\n" .
    "X-APPLE-CALENDAR-COLOR:\n" .
    "X-WR-TIMEZONE:\n" .
    "CALSCALE:\n" .
    "END:VCALENDAR\n";

const EXPECTED_DEF_VEV = "BEGIN:VEVENT\n" .
    "UID:\n" .
    "DTSTART:\n" .
    "DTEND:\n" .
    "SUMMARY:\n" .
    "DESCRIPTION:\n" .
    "DTSTAMP:\n" .
    "END:VEVENT\n";

const EXPECTED_DEF_VT = "BEGIN:VTIMEZONE\n" .
    "TZID:\n" .
    "END:VTIMEZONE\n";

const EXPECTED_DEF_DL = "BEGIN:DAYLIGHT\n" .
    "TZOFFSETFROM:\n" .
    "TZOFFSETTO:\n" .
    "DTSTART:\n" .
    "TZNAME:\n" .
    "END:DAYLIGHT\n";

const EXPECTED_DEF_STD = "BEGIN:STANDARD\n" .
    "TZOFFSETFROM:\n" .
    "TZOFFSETTO:\n" .
    "DTSTART:\n" .
    "TZNAME:\n" .
    "END:STANDARD\n";

const EXPECTED_VCAL = "BEGIN:VCALENDAR\n" .
    "VERSION:2.0\n" .
    "METHOD:PUBLISH\n" .
    "PRODID:-//mynet/mydomain.de 3.0.1//DE\n" .
    "X-WR-CALNAME:Calendar name\n" .
    "X-WR-CALDESC:Calendar desc\n" .
    "X-APPLE-CALENDAR-COLOR:#B027AE\n" .
    "X-WR-TIMEZONE:Europe/Berlin\n" .
    "CALSCALE:GREGORIAN\n" .
    "BEGIN:VTIMEZONE\n" .
    "TZID:Europe/Berlin\n" .
    "BEGIN:DAYLIGHT\n" .
    "TZOFFSETFROM:+100\n" .
    "TZOFFSETTO:+200\n" .
    "DTSTART:19961027T030000\n" .
    "TZNAME:CET\n" .
    "END:DAYLIGHT\n" .
    "BEGIN:STANDARD\n" .
    "TZOFFSETFROM:+200\n" .
    "TZOFFSETTO:+100\n" .
    "DTSTART:19961027T030000\n" .
    "TZNAME:CEST\n" .
    "END:STANDARD\n" .
    "END:VTIMEZONE\n" .
    "BEGIN:VEVENT\n" .
    "UID:DE-IF-1225\n" .
    "DTSTART:19810329T020000\n" .
    "DTEND:20000101T000000Z\n" .
    "SUMMARY:Test summary 1\n" .
    "DESCRIPTION:Test description 1\n" .
    "DTSTAMP:20000101T000000Z\n" .
    "END:VEVENT\n" .
    "BEGIN:VEVENT\n" .
    "UID:DE-IF-1233\n" .
    "DTSTART:19810329T020000\n" .
    "DTEND:20000101T000000Z\n" .
    "SUMMARY:Test summary 2\n" .
    "DESCRIPTION:Test description 2\n" .
    "DTSTAMP:20000101T000000Z\n" .
    "END:VEVENT\n" .
    "END:VCALENDAR\n";

const EXPECTED_VEV = "BEGIN:VEVENT\n" .
    "UID:DE-IF-1225\n" .
    "DTSTART:19810329T020000\n" .
    "DTEND:20000101T000000Z\n" .
    "SUMMARY:Test summary\n" .
    "DESCRIPTION:Test description\n" .
    "DTSTAMP:20000101T000000Z\n" .
    "END:VEVENT\n";

const EXPECTED_VT = "BEGIN:VTIMEZONE\n" .
    "TZID:Europe/Berlin\n" .
    "BEGIN:DAYLIGHT\n" .
    "TZOFFSETFROM:+100\n" .
    "TZOFFSETTO:+200\n" .
    "DTSTART:19961027T030000\n" .
    "TZNAME:CET\n" .
    "END:DAYLIGHT\n" .
    "BEGIN:STANDARD\n" .
    "TZOFFSETFROM:+200\n" .
    "TZOFFSETTO:+100\n" .
    "DTSTART:19961027T030000\n" .
    "TZNAME:CEST\n" .
    "END:STANDARD\n" .
    "END:VTIMEZONE\n";

const EXPECTED_DL = "BEGIN:DAYLIGHT\n" .
    "TZOFFSETFROM:+100\n" .
    "TZOFFSETTO:+200\n" .
    "DTSTART:19961027T030000\n" .
    "TZNAME:CET\n" .
    "END:DAYLIGHT\n";

const EXPECTED_STD = "BEGIN:STANDARD\n" .
    "TZOFFSETFROM:+200\n" .
    "TZOFFSETTO:+100\n" .
    "DTSTART:19961027T030000\n" .
    "TZNAME:CEST\n" .
    "END:STANDARD\n";


class ICalTest extends \PHPUnit_Framework_TestCase
{


    /**
     * @covers \MsiCal\VCalendar::__construct
     * @uses \MsiCal\VCalendarProperties::__construct
     * @uses \MsiCal\VCalendar::__toString
     * @uses \MsiCal\Defaults::vcalendarProperties
     */
    public function testDefaultVCalendarObject1()
    {
        $obj = new VCalendar(Defaults::$vcalendarProperties, []);

        $actualString = "" . $obj . "";
        $this->assertEquals($actualString, EXPECTED_DEF_VCAL);
    }

    /**
     * @covers \MsiCal\VEvent::__construct
     * @uses \MsiCal\VEventProperties::__construct
     * @uses \MsiCal\VEvent::__toString
     * @uses \MsiCal\Defaults::veventProperties
     */
    public function testDefaultVEventObject1()
    {
        $obj = new VEvent(Defaults::$veventProperties);

        $actualString = "" . $obj . "";
        $this->assertEquals($actualString, EXPECTED_DEF_VEV);
    }

    /**
     * @covers \MsiCal\VTodo::__construct
     * @uses \MsiCal\VTodoProperties::__construct
     * @uses \MsiCal\VTodo::__toString
     * @uses \MsiCal\Defaults::vtodoProperties
     */
    public function testDefaultVTodoObject1()
    {
    }

    /**
     * @covers \MsiCal\VTimezone::__construct
     * @uses \MsiCal\VTimezoneProperties::__construct
     * @uses \MsiCal\VTimezone::__toString
     * @uses \MsiCal\Defaults::vtimezoneProperties
     */
    public function testDefaultVTimezoneObject1()
    {
        $obj = new VTimezone(Defaults::$vtimezoneProperties, []);

        $actualString = "" . $obj . "";
        $this->assertEquals($actualString, EXPECTED_DEF_VT);
    }

    /**
     * @covers \MsiCal\Daylight::__construct
     * @uses \MsiCal\DaylightProperties::__construct
     * @uses \MsiCal\Daylight::__toString
     * @uses \MsiCal\Defaults::daylightProperties
     */
    public function testDefaultDaylightObject1()
    {
        $obj = new Daylight(Defaults::$daylightProperties);

        $actualString = "" . $obj . "";
        $this->assertEquals($actualString, EXPECTED_DEF_DL);
    }

    /**
     * @covers \MsiCal\Standard::__construct
     * @uses \MsiCal\StandardProperties::__construct
     * @uses \MsiCal\Standard::__toString
     * @uses \MsiCal\Defaults::standardProperties
     */
    public function testDefaultStandardObject1()
    {
        $obj = new Standard(Defaults::$standardProperties);

        $actualString = "" . $obj . "";
        $this->assertEquals($actualString, EXPECTED_DEF_STD);
    }

    /**
     * @covers \MsiCal\VCalendar::__construct
     * @uses \MsiCal\VCalendarProperties::__construct
     * @uses \MsiCal\VEvent::__construct
     * @uses \MsiCal\VEventProperties::__construct
     * @uses \MsiCal\Daylight::__construct
     * @uses \MsiCal\DaylightProperties::__construct
     * @uses \MsiCal\Standard::__construct
     * @uses \MsiCal\StandardProperties::__construct
     * @uses \MsiCal\VTimezone::__construct
     * @uses \MsiCal\VTimezoneProperties::__construct
     * @uses \MsiCal\VCalendar::__toString
     */
    public function testVCalendarObject1()
    {
        $vevent1properties = new VEventProperties("DE-IF-1225",
            "19810329T020000", "20000101T000000Z", "Test summary 1",
            "Test description 1", "20000101T000000Z");
        $vevent1 = new VEvent($vevent1properties);
        $vevent2properties = new VEventProperties("DE-IF-1233",
            "19810329T020000", "20000101T000000Z", "Test summary 2",
            "Test description 2", "20000101T000000Z");
        $vevent2 = new VEvent($vevent2properties);

        $vdaylightProperties = new DaylightProperties("+100", "+200",
            "19961027T030000", "CET");
        $vdaylight = new Daylight($vdaylightProperties);
        $vstandardProperties = new StandardProperties("+200", "+100",
            "19961027T030000", "CEST");
        $vstandard = new Standard($vstandardProperties);
        $vtimezoneProperty = new VTimezoneProperties("Europe/Berlin");
        $vtimezone = new VTimezone($vtimezoneProperty, [$vdaylight, $vstandard]);

        $objProperties = new VCalendarProperties("2.0"
            , "PUBLISH"
            , "-//mynet/mydomain.de 3.0.1//DE"
            , "Calendar name"
            , "Calendar desc"
            , "#B027AE"
            , "Europe/Berlin"
            , "GREGORIAN");
        $obj = new VCalendar($objProperties, [
            $vtimezone, $vevent1, $vevent2
        ]);

        $actualString = "" . $obj . "";
        $this->assertEquals($actualString, EXPECTED_VCAL);
    }

    /**
     * @covers \MsiCal\VEvent::__construct
     * @uses \MsiCal\VEventProperties::__construct
     * @uses \MsiCal\VEvent::__toString
     */
    public function testVEventObject1()
    {
        $veventProperties = new VEventProperties("DE-IF-1225",
            "19810329T020000", "20000101T000000Z", "Test summary",
            "Test description", "20000101T000000Z");
        $vevent = new VEvent($veventProperties);


        $actualString = "" . $vevent . "";
        $this->assertEquals($actualString, EXPECTED_VEV);
    }

    /**
     * @covers \MsiCal\VTimezone::__construct
     * @uses \MsiCal\VTimezoneProperties::__construct
     * @uses \MsiCal\Daylight::__construct
     * @uses \MsiCal\DaylightProperties::__construct
     * @uses \MsiCal\Standard::__construct
     * @uses \MsiCal\StandardProperties::__construct
     * @uses \MsiCal\VTimezone::__toString
     */
    public function testVTimezoneObject1()
    {
        $vdaylightProperties = new DaylightProperties("+100", "+200",
            "19961027T030000", "CET");
        $vdaylight = new Daylight($vdaylightProperties);
        $vstandardProperties = new StandardProperties("+200", "+100",
            "19961027T030000", "CEST");
        $vstandard = new Standard($vstandardProperties);
        $vtimezoneProperty = new VTimezoneProperties("Europe/Berlin");
        $vtimezone = new VTimezone($vtimezoneProperty, [$vdaylight, $vstandard]);

        $actualString = "" . $vtimezone . "";
        $this->assertEquals($actualString, EXPECTED_VT);
    }

    /**
     * @covers \MsiCal\Daylight::__construct
     * @uses \MsiCal\DaylightProperties::__construct
     * @uses \MsiCal\Daylight::__toString
     */
    public function testDaylightObject1()
    {
        $vdaylightProperties = new DaylightProperties("+100", "+200",
            "19961027T030000", "CET");
        $vdaylight = new Daylight($vdaylightProperties);

        $actualString = "" . $vdaylight . "";
        $this->assertEquals($actualString, EXPECTED_DL);
    }

    /**
     * @covers \MsiCal\Standard::__construct
     * @uses \MsiCal\StandardProperties::__construct
     * @uses \MsiCal\Standard::__toString
     */
    public function testStandardObject1()
    {
        $vstandardProperties = new StandardProperties("+200", "+100",
            "19961027T030000", "CEST");
        $vstandard = new Standard($vstandardProperties);

        $actualString = "" . $vstandard . "";
        $this->assertEquals($actualString, EXPECTED_STD);
    }
}
