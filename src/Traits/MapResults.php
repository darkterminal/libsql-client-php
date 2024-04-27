<?php

namespace Darkterminal\LibSQL\Traits;

use Darkterminal\LibSQL\Types\HttpResultSets;

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
     * @param string|array|HttpResultSets $data The JSON data containing the results.
     *
     * @return array The results mapped as an array.
     */
    protected function fetchArray(string|array|HttpResultSets $data): array
    {
        return $this->_results($data);
    }

    /**
     * Fetch the results as a JSON object.
     *
     * @param string|array|HttpResultSets $data The JSON data containing the results.
     *
     * @return string The results mapped as a JSON object.
     */
    protected function fetchObject(string|array|HttpResultSets $data): string
    {
        return \json_encode($this->_results($data), \JSON_PRETTY_PRINT);
    }

    /**
     * Parse the JSON data and extract the results.
     *
     * @param string|array|HttpResultSets $data The JSON data containing the results.
     *
     * @return array The extracted results.
     */
    private function _results(string|array|HttpResultSets $data): array
    {
        $result = [];

        if (\is_string($data)) {
            $data = json_decode($data, true);
        }

        if (\is_array($data)) {

            foreach ($data as $dataTable) {
                if (isset($dataTable['rows']) && isset($dataTable['cols'])) {
                    foreach ($dataTable['rows'] as $row) {
                        $rowData = [];
                        $cols = $dataTable['cols'];

                        for ($i = 0; $i < count($cols); $i++) {
                            switch ($row[$i]['type']) {
                                case 'text':
                                    $value = (string) $row[$i]['value'];
                                    break;
                                case 'integer':
                                    $value = (int) $row[$i]['value'];
                                    break;
                                case 'float':
                                    $value = (float) $row[$i]['value'];
                                    break;
                                case 'null':
                                    $value = null;
                                    break;
                            }

                            $colName = $cols[$i]['name'];
                            $colValue = $value;
                            $rowData[$colName] = $colValue;
                        }

                        $result[] = $rowData;
                    }
                }
            }
        }

        // Iterate over each row
        if (isset($data['results'][0]['response']['result']['rows'])) {
            foreach ($data['results'][0]['response']['result']['rows'] as $row) {
                $rowData = [];
                $cols = $data['results'][0]['response']['result']['cols'];

                // Iterate over each column
                for ($i = 0; $i < count($cols); $i++) {
                    switch ($row[$i]['type']) {
                        case 'text':
                            $value = (string) $row[$i]['value'];
                            break;
                        case 'integer':
                            $value = (int) $row[$i]['value'];
                            break;
                        case 'float':
                            $value = (float) $row[$i]['value'];
                            break;
                        case 'null':
                            $value = null;
                            break;
                        default:
                            $value = (string) $row[$i]['value'];
                            break;
                    }

                    $colName = $cols[$i]['name'];
                    $colValue = $value;
                    $rowData[$colName] = $colValue;
                }

                // Use 'name' column as key and 'value' column as value
                $result[] = $rowData;
            }
        }

        return $result;
    }
}
