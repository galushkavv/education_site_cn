<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class ImageTinyMCEHelper
{
    /**
     * Обрабатывает HTML-контент, извлекает изображения в формате base64,
     * сохраняет их на сервере и заменяет ссылки в контенте.
     *
     * @param string $content HTML-контент для обработки.
     * @param string $storagePath Директория для сохранения изображений.
     * @return string Обновленный HTML-контент с замененными ссылками на изображения.
     */
    public function extractAndSaveImages($content, $storagePath)
    {
        if (!$content) return $content;

        $dom = new \DOMDocument();

        libxml_use_internal_errors(true); // Отключает ошибки из-за некорректного HTML
        $dom->loadHTML(mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8'));
        libxml_clear_errors();

        $images = $dom->getElementsByTagName('img');

        foreach ($images as $img)
        {
            $src = $img->getAttribute('src');

            // Проверка, является ли src изображением в формате base64
            if (preg_match('/^data:image\/(\w+);base64,/', $src, $type))
            {
                $imageData = substr($src, strpos($src, ',') + 1);
                $imageData = base64_decode($imageData);

                if ($imageData === false) continue; // Если декодирование не удалось, пропустить это изображение

                // Определить тип изображения для дальнейшего использования в качестве расширение файла
                $imageType = strtolower($type[1]); // jpg, png, gif и т.д.

                $fileName = uniqid() . '.' . $imageType;

                $filePath = $storagePath . '/' . $fileName;

                Storage::disk('public')->put($filePath, $imageData);
                $publicUrl = Storage::url($filePath);

                // Заменить src в img теге на URL сохраненного изображения
                $img->setAttribute('src', $publicUrl);
            }
        }

        $content = $dom->saveHTML($dom->documentElement);

        $content = preg_replace('~<(?:!DOCTYPE|/?(?:html|body))[^>]*>\s*~i', '', $content); // Убирает лишние теги <html> и <body>, добавленные DOMDocument

        return $content;
    }

    /**
     * Извлекает пути к изображениям из HTML-контента.
     *
     * @param string $content HTML-контент.
     * @return array Массив путей к изображениям.
     */
    public function extractImagePaths($content)
    {
        $paths = [];

        if (!$content) return $paths;

        $dom = new \DOMDocument();

        libxml_use_internal_errors(true);  // Отключает ошибки из-за некорректного HTML
        $dom->loadHTML(mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8'));
        libxml_clear_errors();

        $images = $dom->getElementsByTagName('img');

        foreach ($images as $img) {
            $src = $img->getAttribute('src');

            // Проверка, является ли src изображением в формате base64
            if (!preg_match('/^data:image\/(\w+);base64,/', $src))
            {
                $imagePath = parse_url($src, PHP_URL_PATH);

                $relativePath = ltrim($imagePath, '/storage/');

                $paths[] = $relativePath;
            }
        }

        return $paths;
    }

    /**
     * Удаляет изображения по указанным путям.
     *
     * @param array $paths Массив путей к изображениям.
     * @return void
     */
    public function deleteImages(array $paths)
    {
        foreach ($paths as $file)
        {
            if (Storage::disk('public')->exists($file))
            {
                Storage::disk('public')->delete($file);
            }
        }
    }
}
