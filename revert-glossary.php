<?php
$suffix = '-reversed-to-import.xml';
if (count($argv) !== 2) {
    echo sprintf('USAGE: php revert-glossary.php glossary-from-moodle-to-reverse.xml' . PHP_EOL);
    echo sprintf('This will generate a reverted glossary with suffix: %s %s', $suffix, PHP_EOL);
    die;
}
$fileNameToProcess = $argv[1];
$resultFile = str_replace('.xml', '', $fileNameToProcess) . $suffix;
$xml = simplexml_load_file($fileNameToProcess, 'SimpleXMLElement', LIBXML_NOWARNING);
if ($xml) {
    echo sprintf('processing file \'%s\' %s', $fileNameToProcess, PHP_EOL . PHP_EOL);
    $counter = 0;
    foreach ($xml->xpath("/GLOSSARY/INFO/ENTRIES/ENTRY") as $e) {
        $key = $e->CONCEPT[0];
        $val = str_replace(PHP_EOL, '', trim(strip_tags($e->DEFINITION[0])));
        echo sprintf('processing item: **%s** => **%s** %s', $key, $val, PHP_EOL);
        $e->DEFINITION[0] = $key;
        $e->CONCEPT[0] = substr($val, 0, 255);
        $counter++;
    }
    $xml->asXML($resultFile);
    echo sprintf('Script ends. See `%s` file. %d items processed %s.', $resultFile, $counter, PHP_EOL);
} else {
    echo 'invalid XML file';
}
