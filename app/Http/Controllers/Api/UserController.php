<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

class UserController extends Controller
{
    #[OA\Get(
        path: '/api/user',
        summary: 'Mendapatkan data pengguna yang sedang login',
        tags: ['Auth'],
        security: [['sanctum' => []]],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Data pengguna berhasil diambil'
            ),
            new OA\Response(
                response: 401,
                description: 'Unauthenticated'
            )
        ]
    )]
    public function show(Request $request)
    {
        return response()->json([
            'success' => true,
            'message' => 'Data pengguna berhasil diambil',
            'data' => $request->user()
        ]);
    }
}