<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'site_name',
        'category',
        'site_url',
        'encrypted_data',
        'iv',
        'auth_tag',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function setSensitiveData(array $data, string $encryptionKey): void
    {
        $iv = random_bytes(16);
        
        $encrypted = openssl_encrypt(
            json_encode($data),
            'AES-256-GCM',
            $encryptionKey,
            OPENSSL_RAW_DATA,
            $iv,
            $tag
        );

        $this->encrypted_data = base64_encode($encrypted);
        $this->iv = base64_encode($iv);
        $this->auth_tag = base64_encode($tag);
    }

    public function getSensitiveData(string $encryptionKey): array
    {
        $encrypted = base64_decode($this->encrypted_data);
        $iv = base64_decode($this->iv);
        $tag = base64_decode($this->auth_tag);

        $decrypted = openssl_decrypt(
            $encrypted,
            'AES-256-GCM',
            $encryptionKey,
            OPENSSL_RAW_DATA,
            $iv,
            $tag
        );

        return json_decode($decrypted, true) ?? [];
    }
}