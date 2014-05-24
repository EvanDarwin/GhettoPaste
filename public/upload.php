<?php

require '../include.php';

if (!array_key_exists('content', $_POST) || empty($_POST['content'])) {
    print "I think you may have forgotten to paste it.";
    return;
}

$contents = $_POST['content'];
// 2097152 =~ 2MB
if (strlen($contents) > 2097152) {
    print "The maximum size is 2MB.";
    return;
}

/**
 * We handle all of the uploads here!
 */
$identifier = generateUniqueString();

try {
    createNewPaste($identifier, $contents);

    header('Location: /raw/' . $identifier . ".txt");
} catch (Exception $e) {
    die("Oh no, something bad happened. :(");
}

