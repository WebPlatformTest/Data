<?php

$data = [];

$variants = json_decode(file_get_contents(__DIR__ . '/../data/platforms.json'));

$data[] = "TRUNCATE data_platforms;";
foreach ($variants as $key => $value) {
    $data[] = "INSERT INTO data_platforms SET " .
        "`platform`='" . addslashes($value->platform) . "', " .
        "`related`=" . (!empty($value->related) ? "'" . addslashes($value->related) . "'" : 'NULL') . ", " .
        "`name`='" . addslashes($value->name) . "', " .
        "`order`=" . intval($value->order) . ", " .
        "`type`='" . addslashes($value->type) . "';";
}


$versions = json_decode(file_get_contents(__DIR__ . '/../data/versions.json'));

$data[] = "TRUNCATE data_versions;";
foreach ($versions as $key => $value) {
    $data[] = "INSERT INTO data_versions SET " .
        "`platform`='" . addslashes($value->platform) . "', " .
        "`version`='" . addslashes($value->version) . "', " .
        "`nickname`='" . addslashes($value->nickname) . "', " .
        "`details`=" . (!empty($value->details) ? "'" . addslashes($value->details) . "'" : 'NULL') . ", " .
        "`releasedate`=" . (!empty($value->releasedate) ? "'" . addslashes($value->releasedate) . "'" : 'NULL') . ", " .
        "`type`='" . addslashes($value->type) . "', " .
        "`status`='" . addslashes($value->status) . "', " .
        "`visible`=" . intval($value->visible) . ";";
}


$identifiers = json_decode(file_get_contents(__DIR__ . '/../data/tests.json'));

$data[] = "TRUNCATE data_tests;";
foreach ($identifiers as $key => $value) {
    $data[] = "INSERT INTO data_tests SET " .
        "`platform`='" . addslashes($value->platform) . "', " .
        "`version`='" . addslashes($value->version) . "', " .
        "`uniqueid`=" . (!empty($value->uniqueid) ? "'" . addslashes($value->uniqueid) . "'" : 'NULL') . ", " .
        "`identifier`=" . (!empty($value->identifier) ? "'" . addslashes($value->identifier) . "'" : 'NULL') . ", " .
        "`source`=" . (!empty($value->source) ? "'" . addslashes($value->source) . "'" : 'NULL') . "; ";
}


$data[] = "REPLACE INTO scores (`release`, `platform`, `version`, `fingerprint`) " .
    "SELECT r.release, t.platform, t.version, r.fingerprint FROM data_tests as t LEFT JOIN results AS r ON ((t.uniqueid IS NULL AND t.identifier = r.identifier AND t.source = r.source) OR t.uniqueid = r.uniqueid) HAVING fingerprint IS NOT NULL";


echo implode("\n", $data) . "\n";
