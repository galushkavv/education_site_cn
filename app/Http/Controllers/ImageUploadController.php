<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImageUploadController extends Controller
{
    public function store(Request $request)
    {
        if ($request->hasFile('file'))
        {
            $path = $request->file('file')->store('images', 'public');

            return response()->json(['location' => "/storage/$path"]);
        }

        return response()->json(['error' => 'Ошибка загрузки изображения'], 400);
    }

    public function storeTeacherPhoto(Request $request)
    {
        if ($request->hasFile('file')) {
            // Валидация файла
            $request->validate([
                'file' => 'image|max:2048', // Ограничение на размер файла в 2Мб
            ]);

            $path = $request->file('file')->store('teachers', 'public');

            //$teacher = Teacher::find($request->teacher_id);

            //$teacher->photo_path = "/storage/$path";
            //$teacher->save();

            return response()->json(['location' => "/storage/$path"]);
        }

        return response()->json(['error' => 'Ошибка загрузки фотографии'], 400);
    }
}
