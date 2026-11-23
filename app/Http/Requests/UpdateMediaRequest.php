<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMediaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'type' => ['required', 'in:anime,manga,light_novel'],
            'release_year' => ['required', 'integer', 'min:1900', 'max:2100'],

            'anime_detail' => [
                'required_if:type,anime',
                'prohibited_unless:type,anime',
                'array:episodes',
            ],
            'anime_detail.episodes' => [
                'required_if:type,anime',
                'integer',
                'min:1',
                'max:65535',
            ],

            'manga_detail' => [
                'required_if:type,manga',
                'prohibited_unless:type,manga',
                'array:volumes',
            ],
            'manga_detail.volumes' => [
                'required_if:type,manga',
                'integer',
                'min:1',
                'max:65535',
            ],

            'light_novel_detail' => [
                'required_if:type,light_novel',
                'prohibited_unless:type,light_novel',
                'array:chapters',
            ],
            'light_novel_detail.chapters' => [
                'required_if:type,light_novel',
                'integer',
                'min:1',
                'max:65535',
            ],
        ];
    }
}
