<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MediaResource;
use App\Models\Media;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class UserCollectionController extends Controller
{
    /**
     * Menampilkan koleksi media milik pengguna.
     */
    public function index(User $user)
    {
        $media = $user->media()
            ->with([
                'animeDetail',
                'mangaDetail',
                'lightNovelDetail',
            ])
            ->latest('media_user.created_at')
            ->get();

        return MediaResource::collection($media)->additional([
            'success' => true,
            'message' => 'Koleksi media berhasil diambil.',
        ]);
    }

    /**
     * Menambahkan media ke koleksi pengguna.
     */
    public function store(User $user, Media $media): JsonResponse
    {
        if ($user->media()->where('media.id', $media->id)->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Media sudah ada di koleksi pengguna.',
            ], 409);
        }

        $user->media()->attach($media->id);

        return response()->json([
            'success' => true,
            'message' => 'Media berhasil ditambahkan ke koleksi.',
        ], 201);
    }

    /**
     * Menghapus media dari koleksi pengguna.
     */
    public function destroy(User $user, Media $media): JsonResponse
    {
        $deleted = $user->media()->detach($media->id);

        if ($deleted === 0) {
            return response()->json([
                'success' => false,
                'message' => 'Media tidak ditemukan di koleksi pengguna.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Media berhasil dihapus dari koleksi.',
        ]);
    }
}
