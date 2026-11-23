<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMediaRequest;
use App\Http\Requests\UpdateMediaRequest;
use App\Http\Resources\MediaResource;
use App\Models\Media;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class MediaController extends Controller
{
    public function index()
{
    $search = trim((string) request()->query('search', ''));

    $query = Media::with([
        'animeDetail',
        'mangaDetail',
        'lightNovelDetail',
    ]);

    // Pencarian berdasarkan judul media.
    if ($search !== '') {
        $query->whereRaw(
            'LOWER(title) LIKE ?',
            ['%' . Str::lower($search) . '%']
        );
    }

    $media = $query->latest()->get();

    return MediaResource::collection($media)->additional([
        'success' => true,
        'message' => 'Daftar media berhasil diambil.',
    ]);
}


public function store(StoreMediaRequest $request)
{
    $validated = $request->validated();

    $media = DB::transaction(function () use ($validated) {
        $media = Media::create([
            'title' => $validated['title'],
            'type' => $validated['type'],
            'release_year' => $validated['release_year'],
        ]);

        switch ($validated['type']) {
            case 'anime':
                $media->animeDetail()->create(
                    $validated['anime_detail']
                );
                break;

            case 'manga':
                $media->mangaDetail()->create(
                    $validated['manga_detail']
                );
                break;

            case 'light_novel':
                $media->lightNovelDetail()->create(
                    $validated['light_novel_detail']
                );
                break;
        }

        return $media->load([
            'animeDetail',
            'mangaDetail',
            'lightNovelDetail',
        ]);
    });

    return (new MediaResource($media))
        ->additional([
            'success' => true,
            'message' => 'Media berhasil ditambahkan.',
        ])
        ->response()
        ->setStatusCode(201);
}

public function show(int $id)
{
    $media = Media::with([
    'animeDetail',
    'mangaDetail',
    'lightNovelDetail',
    'users',
])->findOrFail($id);

    return (new MediaResource($media))->additional([
        'success' => true,
        'message' => 'Detail media berhasil diambil.',
    ]);
}


public function update(UpdateMediaRequest $request, int $id)
{
    $validated = $request->validated();

    $media = DB::transaction(function () use ($validated, $id) {
        $media = Media::findOrFail($id);

        $media->update([
            'title' => $validated['title'],
            'type' => $validated['type'],
            'release_year' => $validated['release_year'],
        ]);

        // Hapus detail yang tidak sesuai dengan jenis media baru.
        if ($validated['type'] !== 'anime') {
            $media->animeDetail()->delete();
        }

        if ($validated['type'] !== 'manga') {
            $media->mangaDetail()->delete();
        }

        if ($validated['type'] !== 'light_novel') {
            $media->lightNovelDetail()->delete();
        }

        // Perbarui atau buat detail sesuai jenis media.
        switch ($validated['type']) {
            case 'anime':
                $media->animeDetail()->updateOrCreate(
                    [],
                    $validated['anime_detail']
                );
                break;

            case 'manga':
                $media->mangaDetail()->updateOrCreate(
                    [],
                    $validated['manga_detail']
                );
                break;

            case 'light_novel':
                $media->lightNovelDetail()->updateOrCreate(
                    [],
                    $validated['light_novel_detail']
                );
                break;
        }

        return $media->load([
            'animeDetail',
            'mangaDetail',
            'lightNovelDetail',
        ]);
    });

    return (new MediaResource($media))->additional([
        'success' => true,
        'message' => 'Media berhasil diperbarui.',
    ]);
}

    public function destroy(int $id): JsonResponse
    {
        $media = Media::findOrFail($id);

        $media->delete();

        return response()->json([
            'success' => true,
            'message' => 'Media berhasil dihapus.',
        ]);
    }

}
