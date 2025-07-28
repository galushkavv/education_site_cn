<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\University;
use App\Models\UniversityTranslation;
use App\Models\Country;
use App\Services\ImageTinyMCEHelper;


class UniversityController extends Controller
{
    protected $picturesFolder = 'images/universities';

    public function index()
    {
        $canEdit = Auth::check();

        $universities = University::TranslatedAndPaginated(6);

        return view('universities.index', compact('universities', 'canEdit'));
    }

    public function indexByCountry($country)
    {
        $canEdit = Auth::check();

        $countryId = Country::where('name', $country)->first()->id;
        $universities = University::TranslatedAndPaginated(6, ['country_id' => $countryId]);

        return view('universities.index', compact('country','universities', 'canEdit'));
    }

    public function create()
    {
        $countries = Country::all();

        return view('universities.form', compact('countries'));
    }

    public function store(Request $request)
    {
        $locale = app()->getLocale();

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'country' => 'required|exists:countries,id',
            'short_description' => 'nullable|string',
            'detailed_description' => 'nullable|string',
            'logo' => 'nullable|image|max:2048',
            'picture' => 'nullable|image|max:2048',
        ]);

        // Сохранение логотипа, если он был загружен
        $logoPath = null;
        if ($request->hasFile('logo'))
            $logoPath = $request->file('logo')->store($this->picturesFolder, 'public');

        // Сохранение дополнительного изображения, если оно было загружено
        $picturePath = null;
        if ($request->hasFile('picture'))
            $picturePath = $request->file('picture')->store($this->picturesFolder, 'public');

        // Создание записи в основной таблице
        $university = University::create([
            'logo_path' => $logoPath,
            'picture_path' => $picturePath,
            'country_id' => $validatedData['country'],
        ]);

        // Обработка поля detailed_description, содержащего изображения
        $content = $validatedData['detailed_description'];

        $imageHelper = new ImageTinyMCEHelper();

        // Извлекает картинки, сохраняет их на диск и заменяет в html-коде нормальными ссылками
        $processedDescription = $imageHelper->extractAndSaveImages($content, $this->picturesFolder);

        // Создание записи в таблице переводов
        UniversityTranslation::create([
            'university_id' => $university->id,
            'locale' => $locale,
            'name' => $validatedData['name'],
            'summary' => $validatedData['short_description'],
            'article' => $processedDescription, // Сохранение текста с обновленными ссылками на изображения
        ]);

        /*
        $redirectTo = $request->input('redirect_to');

        if ($redirectTo && url()->isValidUrl($redirectTo))
        {
            return redirect($redirectTo);
        }
        */

        return redirect()->route('universities.index');
    }

    public function show($id)
    {
        $locale = app()->getLocale();

        // Поиск университета по id
        $university = University::where('id', $id)->with(['translations' => function ($query) {
            $query->where('locale', app()->getLocale());
        }])->firstOrFail();

        // Применение перевода, если он существует
        $translation = $university->getExactTranslation($locale);

        if ($translation) {
            $university->name = $translation->name;
            $university->summary = $translation->summary;
            $university->article = $translation->article;
        }

        // Возвращение представления с университетами
        return view('universities.show', [
            'university' => $university
        ]);
    }

    public  function edit($id)
    {
        $locale = app()->getLocale();

        // Поиск университета по id
        $university = University::where('id', $id)->with(['translations' => function ($query) {
            $query->where('locale', app()->getLocale());
        }])->firstOrFail();

        // Применение перевода, если он существует
        $translation = $university->getExactTranslation($locale);

        if ($translation) {
            $university->name = $translation->name;
            $university->summary = $translation->summary;
            $university->article = $translation->article;
        }

        $countries = Country::all();

        return view('universities.form', compact('university', 'countries'));
    }

    public function update(Request $request, $id)
    {
        $locale = app()->getLocale();

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'country' => 'required|exists:countries,id',
            'short_description' => 'nullable|string',
            'detailed_description' => 'nullable|string',
            'logo' => 'nullable|image|max:2048',
            'picture' => 'nullable|image|max:2048',
        ]);

        $university = University::findOrFail($id);

        // Найти и сохранить уже существующю информацию об университете
        $previousTranslation = UniversityTranslation::where([
            ['university_id', $university->id],
            ['locale', $locale],
        ])->first();

        // Обработка загрузки логотипа
        if ($request->hasFile('logo')) {
            if ($university->logo_path) {
                Storage::disk('public')->delete($university->logo_path);
            }
            $logoPath = $request->file('logo')->store($this->picturesFolder, 'public');
            $university->logo_path = $logoPath;
        }

        // Обработка загрузки изображения
        if ($request->hasFile('picture')) {
            if ($university->picture_path) {
                Storage::disk('public')->delete($university->picture_path);
            }
            $picturePath = $request->file('picture')->store($this->picturesFolder, 'public');
            $university->picture_path = $picturePath;
        }

        // Обработка поля detailed_description, содержащего изображения
        $content = $validatedData['detailed_description'];

        $imageHelper = new ImageTinyMCEHelper();

        // Извлекает картинки, сохраняет их на диск и заменяет в html-коде нормальными ссылками
        $processedDescription = $imageHelper->extractAndSaveImages($content, $this->picturesFolder);

        // Обновление информации об университете в основной таблице
        $university->country_id = $validatedData['country'];
        $university->save();

        // Обновление информации об университете в таблице переводов
        UniversityTranslation::updateOrCreate(
            [
                'university_id' => $university->id,
                'locale' => $locale,
            ],[
                'name' => $validatedData['name'],
                'summary' => $validatedData['short_description'],
                'article' => $processedDescription,
            ]
        );

        // Если ранее была найдена статья, удалить старые изображения, вставленные в неё,
        // но только после того, как все предыдущие шаги завершены
        if ($previousTranslation && $previousTranslation->article)
        {
            $oldImagePaths = $imageHelper->extractImagePaths($previousTranslation->article);
            $imageHelper->deleteImages($oldImagePaths);
        }

        return redirect()->route('universities.index');
    }

    public function hide(University $university)
    {
        $university->hidden = true;
        $university->save();

        return redirect()->back();
    }

    public function unhide(University $university)
    {
        $university->hidden = false;
        $university->save();

        return redirect()->back();
    }

    public function destroy($id)
    {
        $university = University::findOrFail($id);

        $university->delete();

        return redirect()->route('universities.index')->with('success', __('universities.messageRemoveSuccess'));
    }
}
