<?php

namespace App\Utils;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class FileUtil
{
    public function save(Request $request,$paramName='image', $folder = "users",$prefixName = "img_"): ?string
    {
        if ($request->hasFile($paramName))
            return FileUtil::saveFile($request->file($paramName), $folder, $prefixName);
        elseif ($request->has($paramName))
            return FileUtil::saveBase64($request->get($paramName), $folder, $prefixName);
        else
            return null;
    }

    private function saveFile($file, $folder = "users",$prefixName = "img_"): ?string
    {
        if ($file) {
            $file_name = $prefixName . ($file->getClientOriginalName() ?? ".png");

            $folder = "uploads/{$folder}/" . date('Ymd') . '/';

            if (!file_exists(public_path($folder))) {
                mkdir(public_path($folder), 0777, true);
            }
            $destination_path = public_path($folder);

            if ($file->move($destination_path, $file_name)) {
                return self::getFullUrl($folder,$file_name);
            } else return null;
        } else return null;
    }

    private function saveBase64($file, $folder = "users",$prefixName = "img_"): ?string
    {
        if ($file && $file != '') {
            $decodeImage = base64_decode($file);

            $folder = "uploads/{$folder}/" . date('Ymd') . '/';
            $file_name = $prefixName . date('-His') . ".png";
            $img_url = $folder . $file_name;

            if (!is_dir($folder))
                mkdir($folder, 0777, TRUE);

            file_put_contents($img_url, $decodeImage);

            return self::getFullUrl($folder,$file_name);
        } else return null;
    }

    private function getFullUrl($folder,$file_name): string
    {
        $baseUrl = URL::to(''); // Base URL

        // http://10.0.2.2:8000/uploads/images/20220402/img_-182729.png
        // http://10.0.2.2:8000/uploads/images/20220402/img_-182729.png

        if ($baseUrl == "http://127.0.0.1:8000" || $baseUrl == "http://10.0.2.2:8000")
            return "{$baseUrl}/{$folder}{$file_name}";
        else
            return "{$baseUrl}/public/{$folder}{$file_name}";
    }
}
