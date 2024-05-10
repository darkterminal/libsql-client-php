<?php

use Darkterminal\LibSQL\Types\HttpResultSets;
use Darkterminal\LibSQL\Utils\Exceptions\LibsqlError;

/**
 * Map the JSON data to a structured format.
 *
 * @param string $data The JSON data to be mapped.
 *
 * @return array Mapped results.
 */
function map_results(string $data): array
{
    // Decode the JSON data
    $data = json_decode($data, true);

    // Initialize mapped results array
    $mapped_results = [
        'results' => []
    ];

    // Extract baton and base_url from the data
    $mapped_results['baton'] = $data['baton'];
    $mapped_results['base_url'] = $data['base_url'];

    // Iterate through each result in the data
    foreach ($data['results'] as $result) {
        // Check if the result is successful and has a response
        if ($result['type'] === 'ok' && isset($result['response']['result'])) {
            $response = $result['response']['result'];

            // Create a mapped result array
            $mapped_result = [
                'cols' => array_map(function ($col) {
                    return [
                        'name' => $col['name'],
                        'decltype' => $col['decltype']
                    ];
                }, $response['cols']),
                'column_types' => array_column($response['cols'], 'decltype'),
                'rows' => $response['rows'],
                'affected_row_count' => $response['affected_row_count'],
                'last_insert_rowid' => $response['last_insert_rowid'],
                'replication_index' => $response['replication_index']
            ];

            // Create HttpResultSets object
            $resultSet = HttpResultSets::create(
                $mapped_result['cols'],
                $mapped_result['rows'],
                $mapped_result['affected_row_count'],
                $mapped_result['last_insert_rowid'],
                $mapped_result['replication_index']
            );

            // Add the resultSet to mapped results
            array_push($mapped_results['results'], $resultSet);
        }

        if ($result['type'] === 'error') {
            throw new LibsqlError($result['error']['message'], $result['error']['code']);
        }
    }

    // Return mapped results
    return $mapped_results;
}

function objectToArray($object)
{
    if (!is_object($object) && !is_array($object))
        return $object;

    return array_map('objectToArray', (array) $object);
}
