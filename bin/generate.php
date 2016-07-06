<?php

$data = [];

$variants = json_decode(file_get_contents(__DIR__ . '/../data/variants.json'));

$data[] = "TRUNCATE browserVariants;";
foreach ($variants as $key => $value) {
    $data[] = "INSERT INTO browserVariants SET " .
        "`id`='" . addslashes($value->id) . "', " .
        "`replaced`=" . (!empty($value->replaced) ? "'" . addslashes($value->replaced) . "'" : 'NULL') . ", " .
        "`name`='" . addslashes($value->name) . "', " .
        "`grouped`='" . addslashes($value->grouped) . "', " .
        "`importance`=" . intval($value->importance) . ", " .
        "`type`='" . addslashes($value->type) . "';";
}


$versions = json_decode(file_get_contents(__DIR__ . '/../data/versions.json'));

$data[] = "TRUNCATE browserVersions;";
foreach ($versions as $key => $value) {
    $data[] = "INSERT INTO browserVersions SET " .
        "`variant`='" . addslashes($value->id) . "', " .
        "`version`='" . addslashes($value->version) . "', " .
        "`nickname`='" . addslashes($value->nickname) . "', " .
        "`details`=" . (!empty($value->details) ? "'" . addslashes($value->details) . "'" : 'NULL') . ", " .
        "`release`=" . (!empty($value->release) ? "'" . addslashes($value->release) . "'" : 'NULL') . ", " .
        "`type`='" . addslashes($value->type) . "', " .
        "`status`='" . addslashes($value->status) . "', " .
        "`listed`=" . intval($value->listed) . ";";
}


$identifiers = json_decode(file_get_contents(__DIR__ . '/../data/identifiers.json'));

$data[] = "TRUNCATE browserIdentifier;";
foreach ($identifiers as $key => $value) {
    $data[] = "INSERT INTO browserIdentifier SET " .
        "`variant`='" . addslashes($value->id) . "', " .
        "`version`='" . addslashes($value->version) . "', " .
        "`uniqueid`=" . (!empty($value->uniqueid) ? "'" . addslashes($value->uniqueid) . "'" : 'NULL') . ", " .
        "`identifier`=" . (!empty($value->identifier) ? "'" . addslashes($value->identifier) . "'" : 'NULL') . ", " .
        "`source`=" . (!empty($value->source) ? "'" . addslashes($value->source) . "'" : 'NULL') . "; ";
}


$data[] = "REPLACE INTO scores (`release`, `variant`, `version`, `fingerprint`) " .
    "SELECT r.release, i.variant, i.version, r.fingerprint FROM browserIdentifier as i LEFT JOIN results AS r ON ((i.uniqueid IS NULL AND i.identifier = r.identifier AND i.source = r.source) OR i.uniqueid = r.uniqueid) HAVING fingerprint IS NOT NULL";


echo implode("\n", $data) . "\n";
