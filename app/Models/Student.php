<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

/**
 * @OA\Schema(
 *     schema="Student",
 *     required={"firstName", "lastName", "email", "password", "age", "grade", "phone_number"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="firstName", type="string", example="John"),
 *     @OA\Property(property="lastName", type="string", example="Doe"),
 *     @OA\Property(property="email", type="string", format="email", example="john@example.com"),
 *     @OA\Property(property="password", type="string", format="password", example="password123"),
 *     @OA\Property(property="age", type="integer", example=20),
 *     @OA\Property(property="grade", type="string", example="A"),
 *     @OA\Property(property="phone_number", type="string", example="+123456789"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time"),
 * )
 */

class Student extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $fillable = [
        'firstName',
        'lastName',
        'age',
        'grade',
        'email',
        'phone_number',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}