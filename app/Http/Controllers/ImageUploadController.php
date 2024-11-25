<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use App\Models\UserDetails;

class ImageUploadController extends Controller
{
    public function upload(Request $request)
    {
        $image = $request->file('image');

        if ($image) {
            // Получаем расширение файла
            $extension = $image->getClientOriginalExtension();
            
            // Генерация уникального названия файла
            do {
                $filename = Str::random(40) . '.' . $extension;
                $path = 'images/' . $filename;
            } while (Storage::exists($path)); // Проверяем, существует ли файл с таким именем
        
            // Сохраняем изображение в файловой системе
            if (Storage::put($path, file_get_contents($image))) {
                
            } else {
               
            }
        
            UserDetails::createOrUpdate(['avatar_path' => $path]);
        
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }
}
