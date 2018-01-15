<?php

$data = [];

$variants = json_decode(file_get_contents(__DIR__ . '/../data/platforms.json'));

$data[] = "TRUNCATE data_platforms;";
foreach ($variants as $key => $value) {
    $data[] = "INSERT INTO data_platforms SET " .
        "`platform`='" . addslashes($value->platform) . "', " .
        "`related`=" . (!empty($value->related) ? "'" . addslashes($value->related) . "'" : 'NULL') . ", " .
        "`name`='" . addslashes($value->name) . "', " .
        "`nickname`=" . (!empty($value->nickname) ? "'" . addslashes($value->nickname) . "'" : 'NULL') . ", " .
        "`order`=" . intval($value->order) . ", " .
        "`type`='" . addslashes($value->type) . "';";
}


$versions = json_decode(file_get_contents(__DIR__ . '/../data/versions.json'));

$data[] = "TRUNCATE data_versions;";
foreach ($versions as $key => $value) {
    $data[] = "INSERT INTO data_versions SET " .
        "`platform`='" . addslashes($value->platform) . "', " .
        "`version`=" . (!empty($value->version) ? "'" . addslashes($value->version) . "'" : 'NULL') . ", " .
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
        "`version`=" . (!empty($value->version) ? "'" . addslashes($value->version) . "'" : 'NULL') . ", " .
        "`uniqueid`=" . (!empty($value->uniqueid) ? "'" . addslashes($value->uniqueid) . "'" : 'NULL') . ", " .
        "`useragent`=" . (!empty($value->useragent) ? "'" . addslashes($value->useragent) . "'" : 'NULL') . ", " .
        "`identifier`=" . (!empty($value->identifier) ? "'" . addslashes($value->identifier) . "'" : 'NULL') . ", " .
        "`source`=" . (!empty($value->source) ? "'" . addslashes($value->source) . "'" : 'NULL') . "; ";
}


$data[] = "TRUNCATE scores;";

$data[] = "INSERT INTO scores (`release`, `platform`, `version`, `fingerprint`) " .
    "SELECT r.release, t.platform, t.version, r.fingerprint " .
    "FROM data_tests as t " .
    "LEFT JOIN results AS r ON (" .
        "(t.uniqueid IS NULL AND t.identifier = r.identifier AND t.source = r.source)" .
    ") " .
    "GROUP BY r.release, t.platform, t.version " .
    "HAVING fingerprint IS NOT NULL;";

$data[] = "INSERT INTO scores (`release`, `platform`, `version`, `fingerprint`) " .
    "SELECT r.release, t.platform, t.version, r.fingerprint " .
    "FROM data_tests as t " .
    "LEFT JOIN results AS r ON (" .
        "(t.uniqueid IS NULL AND r.source = 'lab' AND t.useragent = r.useragent)" .
    ") " .
    "GROUP BY r.release, t.platform, t.version " .
    "HAVING fingerprint IS NOT NULL;";

$data[] = "INSERT INTO scores (`release`, `platform`, `version`, `fingerprint`) " .
    "SELECT r.release, t.platform, t.version, r.fingerprint " .
    "FROM data_tests as t " .
    "LEFT JOIN results AS r ON (" .
        "t.uniqueid = r.uniqueid" .
    ") " .
    "GROUP BY r.release, t.platform, t.version " .
    "HAVING fingerprint IS NOT NULL;";


echo implode("\n", $data) . "\n";
