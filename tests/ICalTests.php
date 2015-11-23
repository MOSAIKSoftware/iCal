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
	 * @uses \MsiCal\VCalendar::__toString
     */
    public function testDefaultVCalendarObject1()
    {
        $obj = new VCalendar([]);
        $actualString = "" . $obj . "";
        $this->assertEquals($actualString, EXPECTED_DEF_VCAL);
    }

    /**
	 * @covers \MsiCal\VEvent::__construct
	 * @uses \MsiCal\VEvent::__toString
     */
    public function testDefaultVEventObject1()
    {
        $obj = new VEvent([]);
        $actualString = "" . $obj . "";
        $this->assertEquals($actualString, EXPECTED_DEF_VEV);
    }

    /**
	 * @covers \MsiCal\VTodo::__construct
	 * @uses \MsiCal\VTodo::__toString
     */
    public function testDefaultVTodoObject1()
    {
    }

    /**
	 * @covers \MsiCal\VTimezone::__construct
	 * @uses \MsiCal\VTimezone::__toString
     */
    public function testDefaultVTimezoneObject1()
    {
        $obj = new VTimezone([]);
        $actualString = "" . $obj . "";
        $this->assertEquals($actualString, EXPECTED_DEF_VT);
    }

    /**
	 * @covers \MsiCal\Daylight::__construct
	 * @uses \MsiCal\Daylight::__toString
     */
    public function testDefaultDaylightObject1()
    {
        $obj = new Daylight([]);
        $actualString = "" . $obj . "";
        $this->assertEquals($actualString, EXPECTED_DEF_DL);
	}

    /**
	 * @covers \MsiCal\Standard::__construct
	 * @uses \MsiCal\Standard::__toString
     */
    public function testDefaultStandardObject1()
    {
        $obj = new Standard([]);
        $expectedString = "BEGIN:STANDARD\n" .
            "TZOFFSETFROM:\n" .
            "TZOFFSETTO:\n" .
            "DTSTART:\n" .
            "TZNAME:\n" .
            "END:STANDARD\n";
        $actualString = "" . $obj . "";
        $this->assertEquals($actualString, EXPECTED_DEF_STD);
    }

    /**
	 * @covers \MsiCal\VCalendar::__construct
	 * @uses \MsiCal\VEvent::__construct
	 * @uses \MsiCal\Daylight::__construct
	 * @uses \MsiCal\Standard::__construct
	 * @uses \MsiCal\VTimezone::__construct
	 * @uses \MsiCal\VCalendar::__toString
     */
    public function testVCalendarObject1()
    {

        $veventObj1 = new VEvent([
            "UID" => "DE-IF-1225"
            , "DTSTART" => "19810329T020000"
            , "DTEND" => "20000101T000000Z"
            , "SUMMARY" => "Test summary 1"
            , "DESCRIPTION" => "Test description 1"
            , "DTSTAMP" => "20000101T000000Z"
        ]);
        $veventObj2 = new VEvent([
            "UID" => "DE-IF-1233"
            , "DTSTART" => "19810329T020000"
            , "DTEND" => "20000101T000000Z"
            , "SUMMARY" => "Test summary 2"
            , "DESCRIPTION" => "Test description 2"
            , "DTSTAMP" => "20000101T000000Z"
        ]);
        $daylightObj = new Daylight([
            "TZOFFSETFROM" => "+100"
            , "TZOFFSETTO" => "+200"
            , "DTSTART" => "19961027T030000"
            , "TZNAME" => "CET"
        ]);
        $standardObj = new Standard([
            "TZOFFSETFROM" => "+200"
            , "TZOFFSETTO" => "+100"
            , "DTSTART" => "19961027T030000"
            , "TZNAME" => "CEST"
        ]);

        $vtimezoneObj = new VTimezone([
            "TZID" => "Europe/Berlin"
            , "DAYLIGHT" => $daylightObj
            , "STANDARD" => $standardObj
        ]);

        $obj = new VCalendar([
            "VERSION" => "2.0"
            , "METHOD" => "PUBLISH"
            , "PRODID" => "-//mynet/mydomain.de 3.0.1//DE"
            , "X-WR-CALNAME" => "Calendar name"
            , "X-WR-CALDESC" => "Calendar desc"
            , "X-APPLE-CALENDAR-COLOR" => "#B027AE"
			, "X-WR-TIMEZONE" => "Europe/Berlin"
			, "CALSCALE" => "GREGORIAN"
            , "VTIMEZONE" => $vtimezoneObj
            , "VEVENTS" => [$veventObj1, $veventObj2]
            , "VTODO" => new \stdClass()
        ]);
        $actualString = "" . $obj . "";
        $this->assertEquals($actualString, EXPECTED_VCAL);
    }

    /**
	 * @covers \MsiCal\VEvent::__construct
	 * @uses \MsiCal\VEvent::__toString
     */
    public function testVEventObject1()
    {
        $obj = new VEvent([
            "UID" => "DE-IF-1225"
            , "DTSTART" => "19810329T020000"
            , "DTEND" => "20000101T000000Z"
            , "SUMMARY" => "Test summary"
            , "DESCRIPTION" => "Test description"
            , "DTSTAMP" => "20000101T000000Z"
        ]);

        $actualString = "" . $obj . "";
        $this->assertEquals($actualString, EXPECTED_VEV);
    }

    /**
	 * @covers \MsiCal\VTimezone::__construct
	 * @uses \MsiCal\Daylight::__construct
	 * @uses \MsiCal\Standard::__construct
	 * @uses \MsiCal\VTimezone::__toString
     */
    public function testVTimezoneObject1()
    {
        $daylightObj = new Daylight([
            "TZOFFSETFROM" => "+100"
            , "TZOFFSETTO" => "+200"
            , "DTSTART" => "19961027T030000"
            , "TZNAME" => "CET"
        ]);
        $standardObj = new Standard([
            "TZOFFSETFROM" => "+200"
            , "TZOFFSETTO" => "+100"
            , "DTSTART" => "19961027T030000"
            , "TZNAME" => "CEST"
        ]);

        $obj = new VTimezone([
            "TZID" => "Europe/Berlin"
            , "DAYLIGHT" => $daylightObj
            , "STANDARD" => $standardObj
        ]);

        $actualString = "" . $obj . "";
        $this->assertEquals($actualString, EXPECTED_VT);
    }

    /**
	 * @covers \MsiCal\Daylight::__construct
	 * @uses \MsiCal\Daylight::__toString
     */
    public function testDaylightObject1()
    {
        $obj = new Daylight([
            "TZOFFSETFROM" => "+100"
            , "TZOFFSETTO" => "+200"
            , "DTSTART" => "19961027T030000"
            , "TZNAME" => "CET"
        ]);

        $actualString = "" . $obj . "";
        $this->assertEquals($actualString, EXPECTED_DL);
    }

    /**
	 * @covers \MsiCal\Standard::__construct
	 * @uses \MsiCal\Standard::__toString
     */
    public function testStandardObject1()
    {
        $obj = new Standard([
            "TZOFFSETFROM" => "+200"
            , "TZOFFSETTO" => "+100"
            , "DTSTART" => "19961027T030000"
            , "TZNAME" => "CEST"
        ]);

        $actualString = "" . $obj . "";
        $this->assertEquals($actualString, EXPECTED_STD);
    }
}
