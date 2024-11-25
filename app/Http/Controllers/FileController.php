<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileController extends Controller
{
    public function download_vp(){
        $path = resource_path("files/open_vpn/OpenVPN.zip");
 
        // Проверяем, существует ли файл
        if (!file_exists($path)) {
          
            abort(404); // Файл не найден
        }
 
        // Возвращаем ответ с файлом для скачивания
        return response()->download($path);
    }
}
