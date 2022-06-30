<?php

namespace App\Processor;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProcessUploadFile
{
    public function __construct($fileContent, array $params = [], $request)
    {
        $extension = ! empty($params['extension']) ? $params['extension'] : 'txt';

        $fileName = Str::random(16);

        // Define the path by which we will store the new image
        $fullFileName = 'file' . '/' . $fileName . '.' . $extension;
        if (isset($params['location'])) {
            $fullFileName = 'file' . '/' . $params['location'] . $fileName . '.' . $extension;
        }

        // Store image
        Storage::put($fullFileName, (string) $fileContent, 'public');

        // Merge the filename to column to request
        $request->merge([
            $params['field_name'] => $fullFileName
        ]);

        // Merge filename
        if (isset($params['filename'])) {
            $request->merge([
                'filename' => $request->name . '_' . $fileName . '.' . $extension
            ]);
        }
    }
}