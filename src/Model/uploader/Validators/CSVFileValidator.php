<?php

namespace Model\uploader\Validators;

use Exception;
use Model\uploader\ReadCSV;

/**
 * Class CSVFileValidator
 * @package Model\uploader\Validators
 */

class CSVFileValidator
{
    use ReadCSV;

    /**
     * @param string $filename
     * @param int $nr
     * @param bool $isMin
     * @throws Exception
     */
    public function validate(string $filename, int $nr, bool $isMin = false) : void
    {
        if ($this->checkIfFileExists($filename) === false) {
            throw new Exception("CSV file $filename doesn't exists!");
        }
        if ($isMin && $this->checkIfHasMinNrOfColumns($filename, $nr) === false) {
            throw new Exception("Too few fields in CSV file $filename!");
        }
        if ($isMin === false && $this->checkIfHasNrOfColumns($filename, $nr) === false) {
            throw new Exception("Too few or too much fields in CSV file $filename!");
        }
    }

    private function checkIfFileExists(string $filename) : bool
    {
        return file_exists($filename);
    }

    private function checkIfHasNrOfColumns(string $filename, $nr) : bool
    {
        $data = $this->readCSV($filename);
        foreach ($data as $entry) {
            if (count($entry) !== $nr) {
                return false;
            }
        }
        return true;
    }

    private function checkIfHasMinNrOfColumns(string $filename, int $minNr) : bool
    {
        $data = $this->readCSV($filename);
        foreach ($data as $entry) {
            if (count($entry) < $minNr) {
                return false;
            }
        }
        return true;
    }
}