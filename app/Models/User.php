<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['nama', 'email', 'password', 'no_hp', 'alamat', 'role'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Beritahu Laravel bahwa primary key tabel ini adalah user_id, bukan id.
     */
    protected $primaryKey = 'user_id'; // KUNCI UTAMA PERBAIKAN ERROR ID

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            // 'email_verified_at' dihilangkan karena kolomnya tidak ada di database kamu
            'password' => 'hashed',
        ];
    }
        public function pesananCustom()
    {
        return $this->hasMany(PesananCustom::class, 'user_id', 'user_id');
    }
}