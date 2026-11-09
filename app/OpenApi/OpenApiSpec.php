<?php

namespace App\OpenApi;

use OpenApi\Attributes as OA;

#[OA\Info(
    version: '1.0.0',
    title: 'Perpustakaan API',
    description: 'REST API Laravel 12 untuk login (Sanctum) dan CRUD data buku.',
    contact: new OA\Contact(
        name: 'Admin Perpustakaan',
        email: 'admin@example.com'
    )
)]
#[OA\Server(
    url: 'http://127.0.0.1:8000',
    description: 'Server API'
)]
#[OA\SecurityScheme(
    securityScheme: 'sanctum',
    type: 'http',
    scheme: 'bearer',
    bearerFormat: 'Sanctum Token'
)]
#[OA\Tag(name: 'Auth', description: 'Registrasi, login, profil, dan logout')]
#[OA\Tag(name: 'Books', description: 'CRUD data buku (wajib login)')]
class OpenApiSpec
{
}