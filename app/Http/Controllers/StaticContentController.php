<?php

namespace App\Http\Controllers;

class StaticContentController extends Controller
{
    public function show($slug)
    {
        $locale = app()->getLocale();
        $filePath = storage_path("articles/{$slug}_{$locale}.html");

        if (!file_exists($filePath)) {
            abort(404);
        }

        $htmlContent = file_get_contents($filePath);

        return view('static_content', compact('htmlContent'));
    }
}
