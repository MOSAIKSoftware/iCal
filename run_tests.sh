#!/bin/sh

exec phpunit --bootstrap src/autoload.php tests/*.php
