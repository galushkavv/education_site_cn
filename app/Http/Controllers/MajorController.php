<?php

namespace App\Http\Controllers;

use App\Services\ImageTinyMCEHelper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Major;
use App\Models\MajorTranslation;
use App\Models\Teacher;
use App\Models\University;
use Illuminate\Support\Facades\Storage;

class MajorController extends Controller
{
    protected $picturesFolder = 'images/majors';

    public function index()
    {
        $canEdit = Auth::check();

        $locale = app()->getLocale();

        // Получаем все majors с переводами на текущей локали и логотипами университетов
        $majors = Major::with(['translations', 'universities' => function ($query) {
            $query->select('universities.id', 'logo_path');
        }])->paginate(6);

        // Для каждого major добавляем поля перевода на основе текущей локали
        $majors->each(function ($major) use ($locale)
            {
                $preferredTranslation = $this->getPreferredTranslation($major, $locale);

                if ($preferredTranslation) {
                    // Добавление переведённых полей к объекту
                    $major->name = $preferredTranslation->name;
                    $major->summary = $preferredTranslation->summary;
                    $major->introduction = $preferredTranslation->introduction;
                    $major->detailed_description = $preferredTranslation->detailed_description;
                    $major->subjects = $preferredTranslation->subjects;
                    $major->translation_locale = $preferredTranslation->used_locale;
                }
            });


        return view('majors.index', compact('majors', 'canEdit'));
    }

    private function getPreferredTranslation($major, $locale)
    {
        // Получить все переводы для преподавателя
        $translations = $major->translations->keyBy('locale');

        // 0) Если переводов нет, вернуть объект с текстом "нет информации"
        if ($translations->isEmpty()) {
            return new MajorTranslation([
                'name' => __('translatable_model.no_info'),
                'summary' => __('translatable_model.no_info'),
                'introduction' => __('translatable_model.no_info'),
                'detailed_description' => __('translatable_model.no_info'),
                'subjects' => __('translatable_model.no_info'),
                'locale' => $locale,
                'used_locale' => __('translatable_model.empty')
            ]);
        }

        // 1) Проверка перевода на выбранный язык
        if ($translations->has($locale)) {
            $translation = $translations->get($locale);
            $translation->used_locale = $locale;
            return $translation;
        }

        // 2) Проверка перевода на английский язык
        if ($translations->has('en')) {
            $translation = $translations->get('en');
            $translation->used_locale = 'en';
            return $translation;
        }

        // 3) Если ничего выше не найдено, возвращаем первый попавшийся перевод
        $translation = $translations->first();
        $translation->used_locale = $translation->locale;
        return $translation;
    }

    public function create()
    {
        $locale = app()->getLocale();

        $universities = University::Translated();
        $teachers = Teacher::Translated();

        return view('majors.form', compact('universities', 'teachers'));
    }

    public function store(Request $request)
    {
        $locale = app()->getLocale();

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'short_description' => 'nullable|string',
            'introduction' => 'nullable|string',
            'detailed_description' => 'nullable|string',
            'universities' => 'nullable|array',
            'teachers' => 'nullable|array',
            'image' => 'nullable|image|max:2048',
            'subjects' => 'nullable|string',
        ]);

        // Сохранение картинки изображения, если она была загружена
        $imagePath = null;
        if ($request->hasFile('image'))
            $imagePath = $request->file('image')->store($this->picturesFolder, 'public');

        // Создание записи в основной таблице
        $major = Major::create([
            'image_path' => $imagePath
        ]);

        // Обработка поля detailed_description, содержащего изображения
        $content = $validatedData['detailed_description'];

        $imageHelper = new ImageTinyMCEHelper();

        // Извлекает картинки, сохраняет их на диск и заменяет в html-коде нормальными ссылками
        $processedDescription = $imageHelper->extractAndSaveImages($content, $this->picturesFolder);

        if ($request->has('universities'))
            $major->universities()->attach($validatedData['universities']);

        if ($request->has('teachers'))
            $major->teachers()->attach($validatedData['teachers']);

        // Создание записи в таблице переводов
        MajorTranslation::create([
            'major_id' => $major->id,
            'locale' => $locale,
            'name' => $validatedData['name'],
            'summary' => $validatedData['short_description'],
            'introduction' => $validatedData['introduction'],
            'detailed_description' => $processedDescription,
            'subjects' => $validatedData['subjects'],
        ]);

        // Вместо обычного перенаправление возвращается путь на который перенаправит javascript на форме
        //return response()->json([
        //    'success' => true,
        //    'redirect_url' => route('majors.index')
        //]);

        return redirect()->route('majors.index');
    }

    public function show($id)
    {
        $locale = app()->getLocale();

        $major = Major::with(['universities', 'teachers'])->findOrFail($id);

        $universityIds = $major->universities->pluck('id')->toArray();
        $teacherIds = $major->teachers->pluck('id')->toArray();

        $universities = University::Translated(function($query) use ($universityIds) {
            $query->whereIn('id', $universityIds);
        });

        $teachers = Teacher::Translated(function($query) use ($teacherIds) {
            $query->whereIn('id', $teacherIds);
        });

        $preferredTranslation = $this->getPreferredTranslation($major, $locale);

        if ($preferredTranslation) {
            // Добавление переведённых полей к объекту
            $major->name = $preferredTranslation->name;
            $major->summary = $preferredTranslation->summary;
            $major->introduction = $preferredTranslation->introduction;
            $major->detailed_description = $preferredTranslation->detailed_description;
            $major->subjects = $preferredTranslation->subjects;
            $major->translation_locale = $preferredTranslation->used_locale;
        }

        $warnings = [];

        if($major->translation_locale != $locale)
            $warnings[] = __('common.languageNotFound');


        return view('majors.show', compact('major', 'universities', 'teachers', 'warnings'));
    }


    public function edit($id)
    {
        $locale = app()->getLocale();

        $major = Major::with(['translations', 'universities', 'teachers'])->findOrFail($id);

        $major->university_ids = $major->universities->pluck('id')->toArray();
        $major->teacher_ids = $major->teachers->pluck('id')->toArray();

        $translation = $major->getExactTranslation($locale);

        if ($translation) {
            $major->name = $translation->name;
            $major->summary = $translation->summary;
            $major->introduction = $translation->introduction;
            $major->detailed_description = $translation->detailed_description;
            $major->subjects = $translation->subjects;
        }

        $universities = University::Translated();
        $teachers = Teacher::Translated();


        return view('majors.form', compact('major', 'universities', 'teachers'));
    }

    public function update(Request $request, $id)
    {
        $locale = app()->getLocale();

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'short_description' => 'nullable|string',
            'introduction' => 'nullable|string',
            'detailed_description' => 'nullable|string',
            'universities' => 'nullable|array',
            'teachers' => 'nullable|array',
            'image' => 'nullable|image|max:2048',
            'subjects' => 'nullable|string',
        ]);

        $major = Major::findOrFail($id);

        // Найти и сохранить уже существующю информацию об образоватлеьной программе
        $previousTranslation = MajorTranslation::where([
            ['major_id', $major->id],
            ['locale', $locale],
        ])->first();

        // Обработка загрузки изображения
        if ($request->hasFile('image')) {
            if ($major->image_path) {
                Storage::disk('public')->delete($major->image_path);
            }
            $imagePath = $request->file('image')->store($this->picturesFolder, 'public');
            $major->image_path = $imagePath;
        }

        // Обработка поля detailed_description, содержащего изображения
        $content = $validatedData['detailed_description'];

        $imageHelper = new ImageTinyMCEHelper();

        // Извлекает картинки, сохраняет их на диск и заменяет в html-коде нормальными ссылками
        $processedDescription = $imageHelper->extractAndSaveImages($content, $this->picturesFolder);

        // Обновление информации в основной таблице
        $major->save();

        // Обновление информации об университете в таблице переводов
        MajorTranslation::updateOrCreate(
            [
                'major_id' => $major->id,
                'locale' => $locale
            ],[
                'name' => $validatedData['name'],
                'summary' => $validatedData['short_description'],
                'introduction' => $validatedData['introduction'],
                'detailed_description' => $processedDescription,
                'subjects' => $validatedData['subjects'],
            ]
        );

        // Обновление связей с преподавателями (majors_teachers_connection), если переданы данные
        if ($request->has('teachers')) {
            $major->teachers()->sync($request->input('teachers'));
        }

        // Обновление связей с университетами (universities_majors), если переданы данные
        if ($request->has('universities')) {
            $major->universities()->sync($request->input('universities'));
        }

        // Если ранее было найдено подробное описание (которое может содержать картинки), удалить старые изображения, вставленные в него,
        // но только после того, как все предыдущие шаги завершены
        if ($previousTranslation && $previousTranslation->detailed_description)
        {
            $oldImagePaths = $imageHelper->extractImagePaths($previousTranslation->detailed_description);
            $imageHelper->deleteImages($oldImagePaths);
        }

        //return response()->json([
        //    'success' => true,
        //    'redirect_url' => route('majors.index')
        //]);

        return redirect()->route('majors.index');
    }

    public function hide(Major $major)
    {
        $major->hidden = true;
        $major->save();

        return redirect()->back();
    }

    public function unhide(Major $major)
    {
        $major->hidden = false;
        $major->save();

        return redirect()->back();
    }

    public function destroy($id)
    {
        $major = Major::findOrFail($id);

        $major->delete();

        return redirect()->route('majors.index');
    }
}
