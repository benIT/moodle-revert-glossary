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
        $concept = $e->CONCEPT[0];
        $definition = str_replace(PHP_EOL, '', trim(strip_tags($e->DEFINITION[0])));
        $definition = preg_replace("/\(.*\)/", "", $definition);//replace parenthesis in value before permuting it as key
        echo sprintf('processing item: **%s** => **%s** %s', $concept, $definition, PHP_EOL);
        $e->DEFINITION[0] = $concept;
        $e->CONCEPT[0] = substr($definition, 0, 255);
        unset($e->ENTRYFILES);
        unset($e->ATTACHMENTFILES);
        unset($e->ALIASES);
        $counter++;
    }
    $xml->asXML($resultFile);
    echo sprintf('Script ends. See `%s` file. %d items processed %s.', $resultFile, $counter, PHP_EOL);
} else {
    echo 'invalid XML file';
}