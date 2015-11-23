<?php
// @codingStandardsIgnoreFile
// @codeCoverageIgnoreStart
spl_autoload_register(
    function($class) {
        static $classes = null;
        if ($classes === null) {
            $classes = array(
                'MsiCal\\VCalendar' => '/iCalObject.php',
                'MsiCal\\VCalendarProperties' => '/iCalProperties.php',
            );
        }
        if (isset($classes[$class])) {
            require __DIR__ . $classes[$class];
		}
    },
    true,
    false
);
// @codeCoverageIgnoreEnd

