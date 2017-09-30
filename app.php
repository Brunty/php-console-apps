#!/usr/bin/env php
<?php

// WRITING CONSOLE APPLICATIONS IN PHP :)

// if --bye is set then say goodbye
// if --bye has a value then use that value instead

$shortopts  = "";
$shortopts .= "f:";  // Required value
$shortopts .= "v::"; // Optional value
$shortopts .= "abc"; // These options do not accept values

$longopts  = array(
    "required:",     // Required value
    "optional::",    // Optional value
    "option",        // No value
    "opt",           // No value
);
$options = getopt($shortopts, $longopts);

var_dump($options);

fwrite(STDOUT, "What is your name? ");

$name = trim(fgets(STDIN));

fwrite(STDOUT, "Nice to meet you \e[32;47m{$name}\e[0m - have a \e[35mnice\e[0m day." . PHP_EOL);

exit(0);





