<?php

namespace HTML5test\Data;

use GuzzleHttp\Client;

class Main {

    public function __construct($config) {
        $this->config = $config;

        $this->client = new Client([
            'base_uri'  => $this->config['endpoint'],
            'timeout'   => 5.0
        ]);
    }

    public function run() {
        $scores = json_decode(file_get_contents(__DIR__ . '/../data/scores.json'));
        $fingerprints = [];

        foreach ($scores as $key => $value) {
            $data = $this->getFingerprint($value);

            if ($data) {
                $fingerprints[] = [
                    'release'       => $data->release,
                    'variant'       => $value->variant,
                    'version'       => $value->version,
                    'fingerprint'   => $data->fingerprint
                ];
            }
        }

        file_put_contents(__DIR__ . '/../data/fingerprints.json', json_encode($fingerprints, JSON_PRETTY_PRINT));
    }

    private function getFingerprint($value) {
        $parameters = [];

        if (!empty($value->identifier) && !empty($value->source)) {
            $parameters['identifier'] = $value->identifier;
            $parameters['source'] = $value->source;
        }

        if (!empty($value->uniqueid)) {
            $parameters['uniqueid'] = $value->uniqueid;
        }

        $response = $this->client->get('getFingerprint', [
            'query' => $parameters
        ]);

        return json_decode((string) $response->getBody());
    }
}