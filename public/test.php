<?php
function removeFromEnd($haystack, $needle)
{
    $length = strlen($needle);
    if($needle.substr($haystack, $length) === $haystack)
    {
        $haystack = substr($haystack, $length);
    }
    return $haystack;
}


$trim = "www.";
$str = 'www.google.com';
var_dump(removeFromEnd($str, $trim));