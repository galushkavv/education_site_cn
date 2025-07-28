<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

abstract class TranslatableModel extends Model
{
    public static function Translated($filters = [])
    {
        $locale = app()->getLocale();

        $query = static::with(['translations', 'country']);

        // фильтрация
        if (!empty($filters)) {
            $query->where($filters);
        }
        $entities = $query->get();

        // поиск переводов для тех строк, что прошли фильтр
        foreach ($entities as $entity) {
            $entity->getTranslation($locale);
        }

        return $entities;
    }

    public static function TranslatedAndPaginated($perPage = 10, $filters = [])
    {
        $locale = app()->getLocale();

        $query = static::with(['translations', 'country']);

        if (!empty($filters)) {
            $query->where($filters);
        }

        $entities = $query->paginate($perPage);

        $entities->getCollection()->transform(function ($entity) use ($locale) {
            $entity->getTranslation($locale);
            return $entity;
        });

        return $entities;
    }

    // Выбирает перевод из тех что есть в БД согласно приоритетам
    protected function getTranslation($locale)
    {
        $translations = $this->translations->keyBy('locale');

        if ($translations->isEmpty())
        // 0) Если переводов нет, возвращаем объект с текстом "нет информации"
        {
            $preferredTranslation = $this->fillNoTranslation($locale);
        }
        elseif ($translations->has($locale))
        // 1) Проверка наличия перевода на выбранный язык
        {
            $preferredTranslation = $translations->get($locale);
            $preferredTranslation->used_locale = $locale;
        }
        elseif ($this->country && $translations->has($this->country->locale))
        // 2) Проверка наличия перевода на язык страны
        {
            $preferredTranslation = $translations->get($this->country->locale);
            $preferredTranslation->used_locale = $this->country->locale;
        }
        elseif ($translations->has('en'))
        // 3) Проверка наличия перевода на английский язык
        {
            $preferredTranslation = $translations->get('en');
            $preferredTranslation->used_locale = 'en';
        }
        else
        // 4) Если ничего выше не найдено, то используем первый попавшийся перевод
        {
            $preferredTranslation = $translations->first();
            $preferredTranslation->used_locale = $preferredTranslation->locale;
        }

        foreach ($preferredTranslation->getAttributes() as $key => $value)
        {
            if (in_array($key, ['id', $this->getForeignKey(), 'locale', 'used_locale', 'created_at', 'updated_at']))
            {
                continue;
            }
            $this->$key = $value;
        }
        $this->translation_locale = $preferredTranslation->used_locale ?? $locale;
    }

    protected function fillNoTranslation($locale)
    {
        $translationModel = $this->translations()->getRelated();
        $fillableAttributes = $translationModel->getFillable();
        $attributes = [];

        foreach ($fillableAttributes as $attribute) {
            if (in_array($attribute, [$this->getForeignKey(), 'locale', 'created_at', 'updated_at', 'id'])) {
                continue;
            }
            $attributes[$attribute] = __('translatable_model.no_info');
        }

        $attributes['locale'] = $locale;
        $attributes['used_locale'] = __('translatable_model.empty');

        return new $translationModel($attributes);
    }
}
