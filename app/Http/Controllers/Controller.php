<?php

namespace App\Http\Controllers;


/**
 * * @OA\Info(
 *     title="Laravel V12 Students Management API",
 *     version="1.0.0"
 * )
 * 
 * @OA\SecurityScheme(
 *     type="http",
 *     description="Enter the token returned at login",
 *     name="Authorization",
 *     in="header",
 *     scheme="bearer",
 *     bearerFormat="JWT",
 *     securityScheme="bearerAuth"
 * )
 */
abstract class Controller
{
    //
}