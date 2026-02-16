<?php

namespace App\Services;

class EncryptionService
{
    public function generateUserKey(): string
    {
        return random_bytes(32);
    }

    public function encryptUserKey(string $userKey, string $masterPassword): string
    {
        $key = hash('sha256', $masterPassword, true);
        $iv = random_bytes(16);
        
        $encrypted = openssl_encrypt($userKey, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv);
        
        return base64_encode($iv . $encrypted);
    }

    public function decryptUserKey(?string $encryptedKey, string $masterPassword): ?string
    {
        if (!$encryptedKey) {
            return null;
        }

        try {
            $key = hash('sha256', $masterPassword, true);
            $data = base64_decode($encryptedKey);
            $iv = substr($data, 0, 16);
            $encrypted = substr($data, 16);
            
            $decrypted = openssl_decrypt($encrypted, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv);
            return $decrypted === false ? null : $decrypted;
        } catch (\Exception $e) {
            return null;
        }
    }

    public function hashMasterPassword(string $password): string
    {
        return hash('sha256', $password);
    }

    public function verifyMasterPassword(string $password, ?string $hash): bool
    {
        if (!$hash) {
            return false;
        }

        return hash_equals($hash, $this->hashMasterPassword($password));
    }
}