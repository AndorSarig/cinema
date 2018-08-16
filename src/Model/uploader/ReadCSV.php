<?php

namespace Model\uploader;


trait ReadCSV
{
    public function readCSV($filename) : array
    {
        $content = [];
        if (($handle = fopen($filename, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, "|")) !== FALSE) {
                $content[] = $data;
            }
            fclose($handle);
        }
        return $content;
    }
}
