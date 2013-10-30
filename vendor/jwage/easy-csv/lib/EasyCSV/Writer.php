<?php

namespace EasyCSV;

class Writer extends AbstractBase
{
    public function writeRow($row)
    {
        if (is_string($row)) {
            $row = explode(',', $row);
            $row = array_map('trim', $row);
        }
        return fputcsv($this->handle, $row, $this->delimiter, $this->enclosure);
    }

    public function writeFromArray(array $array)
    {
        foreach ($array as $key => $value) {
            $this->writeRow($value);
        }
    }
}
