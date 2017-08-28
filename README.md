# Moodle revert glossary script

## Purpose

This script is used to generate a reverted glossary extracted from Moodle.

Let's say, you are having a german word with a french equivalent word, this script will permute the french and german world. An importable XML File will be generated, to be imported in MOODLE.

## Usage

## CLI

        php revert-glossary.php glossary-from-moodle-to-reverse.xml

This will generate `glossary-from-moodle-to-reverse-reversed-to-import.xml` file to import in moodle        