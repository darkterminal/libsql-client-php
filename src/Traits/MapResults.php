<?php

namespace Darkterminal\LibSQL\Traits;

/**
 * Trait MapResults
 *
 * This trait provides methods to map results from JSON data to arrays or JSON objects.
 */
trait MapResults
{
    /**
     * Fetch the results as an array.
     *
     * @param string|array $json The JSON data containing the results.
     *
     * @return array The results mapped as an array.
     */
    protected function fetchArray(string|array $json): array
    {
        return $this->_results($json);
    }

    /**
     * Fetch the results as a JSON object.
     *
     * @param string|array $json The JSON data containing the results.
     *
     * @return string The results mapped as a JSON object.
     */
    protected function fetchObject(string|array $json): string
    {
        return \json_encode($this->_results($json));
    }

    /**
     * Parse the JSON data and extract the results.
     *
     * @param string $json The JSON data containing the results.
     *
     * @return array The extracted results.
     */
    private function _results(string|array $json): array
    {
        if (\is_string($json)) {
            $data = json_decode($json, true);
        }

        $result = [];

        // Iterate over each row
        foreach ($data['results'][0]['response']['result']['rows'] as $row) {
            $rowData = [];
            $cols = $data['results'][0]['response']['result']['cols'];

            // Iterate over each column
            for ($i = 0; $i < count($cols); $i++) {
                $colName = $cols[$i]['name'];
                $colValue = $row[$i]['value'];
                $rowData[$colName] = $colValue;
            }

            // Use 'name' column as key and 'value' column as value
            $result[] = $rowData;
        }

        return $result;
    }
}
