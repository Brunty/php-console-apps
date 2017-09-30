
Stage 0:
* Ensure everyone is up and running
* Hello world
* Executable PHP files
    * `php app.php`
    * `chmod +x app.php`
    * `./app.php`
    * `#!/usr/bin/env php` 
* Look at the places PHP can run and how we can differentiate code based on that
    * PHP_SAPI
* Look at some pre-defined constants that will help us when writing console applications
    * PHP_EOL
* Look at some common command line conventions
    * --help
    * --version
    * -s vs --long

Stage 1
* Look at command line arguments & options and how we can use them in PHP
    * $argv $argv and getopt
    * getopt( string $options, array $longopts): array;
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

* Look at standard streams in PHP
    * STDIN $line = trim(fgets(STDIN)); or readline()
    * STDOUT fwrite(STDOUT, "OUTPUT\n");
    * STDERR fwrite(STDERR, "ERROR\n");
    * When writing to a console both stdout and stderr will be printed, this is useful so that I can see the errors as they happen. But what if I was redirecting the output to a file to send to somebody else, or save for later? In that case, STDERR would be echoed and STDOUT would be written to the file, this allows us to separate actual output from errors that may have occurred.
    * You can also redirect output to stderr too by using 2> like so:
        * php app.php > file.txt 2> error.txt
    * You can also capture both outputs from a command to a file by using &> like so:
        * php app.php &> combined.txt
    * 
* Exit codes
    * tldr: 0 = good >0 = bad
    * 1 = Catchall for general errors
    * There has been an attempt to systematize exit status numbers (see /usr/include/sysexits.h), but this is intended for C and C++ programmers. A similar standard for scripting might be appropriate. The author of the advanced bash scripting guide proposes restricting user-defined exit codes to the range 64 - 113
    * See the link for more detail on each of the others
* Console colours and styling output
    * Foreground are in the 30 range
    * Background in the 40 range
    * Original spec had 8 colours
    * Black 0
    * Red 1
    * Green 2
    * Yellow 3
    * Blue 4
    * Magenta 5
    * Cyan 6
    * White 7
    * Colours are set with \e[$COLOR;$COLORm
    * You need to reset colours after you've used them or consoles will continue with those colours - reset it with \e[0m
    * "\e[32mHello\e[0m"
    * Separate
* Console packages available to us in PHP
    * https://github.com/thephpleague/climate
    * symfony/console
    * https://github.com/php-school/cli-menu
* Using symfony/console
* Using input arguments and options in symfony/console
* Interactive input
* Symfony style













