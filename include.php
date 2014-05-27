<?php

/**
 * I guess we'll define all the stuff here.
 */

define('PROJECT_ROOT', __DIR__);
define('PUBLIC_ROOT', PROJECT_ROOT . "/public");
define('UPLOAD_ROOT', PUBLIC_ROOT . "/raw");

var_dump([PROJECT_ROOT, PUBLIC_ROOT, UPLOAD_ROOT]);

/**
 * Generates a (hopefully) random string.
 *
 * returns @string
 */
function generateRandomString($length = 7)
{
    // Available characters
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ123456789";

    $str = "";

    // Go through every character.
    for ($i = 0; $i < $length; $i++) {
        $str .= $chars[mt_rand(0, strlen($chars) - 1)];
    }

    return $str;
}

/**
 * Calls generateRandomString as many times as
 * needed to make sure there's an actually unique
 * filename and we're not overwriting stuff.
 *
 * @see generateRandomString()
 *
 * @param int $depth The current recursive depth.
 * @param int $maxDepth The maximum depth the file may go.
 *
 * @returns string
 */
function generateUniqueString($depth = 0, $maxDepth = 15)
{
    $identifier = generateRandomString();

    if (pasteFileExists($identifier)) {
        if($depth >= $maxDepth) {
            throw new Exception("fuq ur randomness");
        }
        return generateUniqueString($depth + 1, $maxDepth);
    } else {
        return $identifier;
    }
}

/**
 * Checks if a paste file exists already.
 *
 * @param string $identifier The identifier of the file
 *
 * @returns bool File does or does not exist
 */
function pasteFileExists($identifier)
{
    return file_exists(getPastePath($identifier));
}

/**
 * Builds a URI for the file
 *
 * @param string $identifier The paste identifier
 *
 * @return string The URI
 */
function getPastePath($identifier)
{
    return UPLOAD_ROOT . "/" . $identifier . '.txt';
}

/**
 * Creates a new paste and writes it to a text file.
 *
 * @param string $identifier Identifier of the paste.
 * @param string $content The contents of course!
 */
function createNewPaste($identifier, $content)
{
    $path = getPastePath($identifier);

    $handle = fopen($path, "w");
    fwrite($handle, $content);
    fclose($handle);
}
