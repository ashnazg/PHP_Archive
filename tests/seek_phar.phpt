--TEST--
Test seeking a .phar stream [phar extension]
--INI--
phar.require_hash=Off
--SKIPIF--
<?php
if (version_compare(phpversion(), '5.0.0', '<')) {
    echo 'skip php5-only test';
}
if (!extension_loaded('phar')) { echo 'skip test needs phar extension'; }
?>
--FILE--
<?php
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'setup.php';
require dirname(__FILE__) . DIRECTORY_SEPARATOR . 'longfilename' . DIRECTORY_SEPARATOR .
    'longphar.phar';
$phpunit = new PEAR_PHPTest(true);
$fp = fopen('phar://longphar.phar/testtesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttest.php', 'r');
echo "pos: start\n";
var_dump(ftell($fp));
var_dump(fread($fp, 2));

echo "pos: +3,2\n";
fseek($fp, 3);
var_dump(ftell($fp));
var_dump(fread($fp, 2));
var_dump(ftell($fp));

echo "pos: end\n";
fseek($fp, 0, SEEK_END);
var_dump(ftell($fp));
fseek($fp, -1, SEEK_END);
var_dump(ftell($fp));
fseek($fp, -61, SEEK_END);
var_dump(ftell($fp));
fseek($fp, -1, SEEK_CUR);
var_dump(ftell($fp));
fseek($fp, 20, SEEK_CUR);
var_dump(ftell($fp));
fseek($fp, 1, SEEK_END);
var_dump(ftell($fp));
fclose($fp);
echo 'tests done';
?>
--EXPECTF--
phar://%slongphar.phar/testtesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttest.phpstring(5) "hello"
pos: start
int(0)
string(2) "<?"
pos: +3,2
int(3)
string(2) "hp"
int(5)
pos: end
int(43)
int(42)
bool(false)
bool(false)
int(19)
bool(false)
tests done