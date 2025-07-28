<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Country;
use App\Models\Teacher;
use App\Models\TeacherTranslation;

class TeacherController extends Controller
{
    public function index()
    {
        $teachers = Teacher::TranslatedAndPaginated(8);
        return view('teachers.index', compact('teachers'));
    }

    public function create()
    {
        $countries = Country::all();

        return view('teachers.form', ['countries' => $countries]);
    }

    public function store(Request $request)
    {
        // Получаем локаль
        $locale = app()->getLocale();

        // Валидация данных формы
        $validated = $request->validate([
            'last_name' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'about' => 'nullable|string',
            'photo' => 'nullable|image|max:2048',
            'country' => 'required|exists:countries,id',
        ]);

        // Создаем новый объект Teacher
        $teacher = new Teacher;
        $teacher->country_id = $validated['country'];

        // Обработка фотографии
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('teachers', 'public');
            $teacher->photo_path = $photoPath;
        }

        // Сохраняем нового учителя
        $teacher->save();

        // Добавляем перевод
        $translation = new TeacherTranslation;
        $translation->teacher_id = $teacher->id;
        $translation->locale = $locale;
        $translation->first_name = $validated['first_name'];
        $translation->middle_name = $validated['middle_name'] ?? null;
        $translation->last_name = $validated['last_name'];
        $translation->about = $validated['about'] ?? null;

        // Сохраняем перевод
        $translation->save();

        return redirect()->route('teachers.index')->with('success', 'Учитель успешно добавлен.');
    }

    public function edit($id)
    {
        $locale = app()->getLocale(); // Получаем текущую локаль
        $countries = Country::all();

        $teacher = Teacher::with(['translations' => function($query) use ($locale) {
            $query->where('locale', $locale); // Фильтруем по текущей локали
        }])->findOrFail($id);

        // Если перевод найден для текущей локали, добавляем его данные в объект учителя
        if ($translation = $teacher->translations->first()) {
            $teacher->first_name = $translation->first_name;
            $teacher->middle_name = $translation->middle_name;
            $teacher->last_name = $translation->last_name;
            $teacher->about = $translation->about;
        }

        // Передаем данные учителя и стран в представление
        return view('teachers.form', compact('countries', 'teacher'));
    }

    public function update(Request $request, $id)
    {
        // Получаем локаль
        $locale = app()->getLocale();

        // Валидация данных формы
        $validated = $request->validate([
            'last_name' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'about' => 'nullable|string',
            'photo' => 'nullable|image|max:2048',
            'country' => 'required|exists:countries,id',
        ]);

        // Находим существующего учителя по ID
        $teacher = Teacher::findOrFail($id);
        $teacher->country_id = $validated['country'];

        // Обработка фотографии
        if ($request->hasFile('photo')) {
            // Удаляем старую фотографию, если она была загружена ранее
            if ($teacher->photo_path) {
                Storage::disk('public')->delete($teacher->photo_path);
            }

            // Загружаем новую фотографию и сохраняем путь
            $photoPath = $request->file('photo')->store('teachers', 'public');
            $teacher->photo_path = $photoPath;
        }

        // Сохраняем изменения
        $teacher->save();

        // Обрабатываем перевод
        $translation = TeacherTranslation::where('teacher_id', $teacher->id)
            ->where('locale', $locale)
            ->first();

        if (!$translation) {
            $translation = new TeacherTranslation;
            $translation->teacher_id = $teacher->id;
            $translation->locale = $locale;
        }

        // Обновляем данные перевода
        $translation->first_name = $validated['first_name'];
        $translation->middle_name = $validated['middle_name'] ?? null;
        $translation->last_name = $validated['last_name'];
        $translation->about = $validated['about'] ?? null;

        // Сохраняем перевод
        $translation->save();

        return redirect()->route('teachers.index')->with('success', 'Данные учителя успешно обновлены.');
    }

    public function destroy($id)
    {
        $teacher = Teacher::findOrFail($id);

        // Удаляем учителя и связанные переводы
        $teacher->delete();

        return redirect()->route('teachers.index')->with('success', 'Учитель был удален.');
    }
}
