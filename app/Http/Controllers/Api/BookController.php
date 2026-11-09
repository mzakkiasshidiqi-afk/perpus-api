<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use OpenApi\Attributes as OA;

class BookController extends Controller
{
    // MENAMPILKAN SEMUA BUKU
    #[OA\Get(
        path: '/api/books',
        summary: 'Menampilkan semua data buku',
        tags: ['Books'],
        security: [['sanctum' => []]],
        responses: [
            new OA\Response(response: 200, description: 'Data buku berhasil ditampilkan'),
            new OA\Response(response: 401, description: 'Unauthenticated')
        ]
    )]
    public function index()
    {
        return response()->json([
            'success' => true,
            'message' => 'Data buku berhasil ditampilkan',
            'data' => Book::all()
        ]);
    }

    // MENAMBAHKAN BUKU
    #[OA\Post(
        path: '/api/books',
        summary: 'Menambahkan data buku',
        tags: ['Books'],
        security: [['sanctum' => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['judul', 'penulis', 'penerbit', 'tahun_terbit', 'stok'],
                properties: [
                    new OA\Property(property: 'judul', type: 'string', example: 'Pemrograman Laravel'),
                    new OA\Property(property: 'penulis', type: 'string', example: 'Zakki'),
                    new OA\Property(property: 'penerbit', type: 'string', example: 'Informatika'),
                    new OA\Property(property: 'tahun_terbit', type: 'integer', example: 2026),
                    new OA\Property(property: 'stok', type: 'integer', example: 10)
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: 'Buku berhasil ditambahkan'),
            new OA\Response(response: 401, description: 'Unauthenticated'),
            new OA\Response(response: 422, description: 'Validasi gagal')
        ]
    )]
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'penerbit' => 'required|string|max:255',
            'tahun_terbit' => 'required|integer|min:1000|max:'.date('Y'),
            'stok' => 'required|integer|min:0',
        ]);

        $book = Book::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Buku berhasil ditambahkan',
            'data' => $book
        ], 201);
    }

    // MENAMPILKAN DETAIL BUKU
    #[OA\Get(
        path: '/api/books/{id}',
        summary: 'Menampilkan detail buku',
        tags: ['Books'],
        security: [['sanctum' => []]],
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer')
            )
        ],
        responses: [
            new OA\Response(response: 200, description: 'Detail buku berhasil ditampilkan'),
            new OA\Response(response: 404, description: 'Buku tidak ditemukan'),
            new OA\Response(response: 401, description: 'Unauthenticated')
        ]
    )]
    public function show(string $id)
    {
        $book = Book::findOrFail($id);

        return response()->json([
            'success' => true,
            'message' => 'Detail buku berhasil ditampilkan',
            'data' => $book
        ]);
    }

    // MENGUBAH DATA BUKU
    #[OA\Put(
        path: '/api/books/{id}',
        summary: 'Mengubah data buku',
        tags: ['Books'],
        security: [['sanctum' => []]],
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer')
            )
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'judul', type: 'string', example: 'Pemrograman Laravel 12'),
                    new OA\Property(property: 'penulis', type: 'string', example: 'Zakki'),
                    new OA\Property(property: 'penerbit', type: 'string', example: 'Informatika'),
                    new OA\Property(property: 'tahun_terbit', type: 'integer', example: 2026),
                    new OA\Property(property: 'stok', type: 'integer', example: 15)
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: 'Buku berhasil diperbarui'),
            new OA\Response(response: 404, description: 'Buku tidak ditemukan'),
            new OA\Response(response: 401, description: 'Unauthenticated')
        ]
    )]
    public function update(Request $request, string $id)
    {
        $book = Book::findOrFail($id);

        $validated = $request->validate([
            'judul' => 'sometimes|required|string|max:255',
            'penulis' => 'sometimes|required|string|max:255',
            'penerbit' => 'sometimes|required|string|max:255',
            'tahun_terbit' => 'sometimes|required|integer|min:1000|max:'.date('Y'),
            'stok' => 'sometimes|required|integer|min:0',
        ]);

        $book->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Buku berhasil diperbarui',
            'data' => $book
        ]);
    }

    // MENGHAPUS DATA BUKU
    #[OA\Delete(
        path: '/api/books/{id}',
        summary: 'Menghapus data buku',
        tags: ['Books'],
        security: [['sanctum' => []]],
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer')
            )
        ],
        responses: [
            new OA\Response(response: 200, description: 'Buku berhasil dihapus'),
            new OA\Response(response: 404, description: 'Buku tidak ditemukan'),
            new OA\Response(response: 401, description: 'Unauthenticated')
        ]
    )]
    public function destroy(string $id)
    {
        $book = Book::findOrFail($id);
        $book->delete();

        return response()->json([
            'success' => true,
            'message' => 'Buku berhasil dihapus'
        ]);
    }
}