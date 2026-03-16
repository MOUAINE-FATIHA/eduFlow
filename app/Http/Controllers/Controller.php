<?php

namespace App\Http\Controllers;

/**
 * @OA\Info(
 *     title="EduFlow API",
 *     version="1.0.0",
 *     description="API de gestion pédagogique"
 * )
 *
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT"
 * )
 *
 * @OA\Server(
 *     url="/api",
 *     description="Serveur local"
 * )
 */
abstract class Controller
{
}