<?php

namespace App\Enums;

enum SHA: string
{
    case SHA1 = 'sha1';
    case SHA2_224 = 'sha224';
    case SHA2_256 = 'sha256';
    case SHA2_384 = 'sha384';
    case SHA2_512 = 'sha512';
    case SHA2_512_224 = 'sha512/224';
    case SHA2_512_256 = 'sha512/256';
    case SHA3_224 = 'sha3-224';
    case SHA3_256 = 'sha3-256';
    case SHA3_384 = 'sha3-384';
    case SHA3_512 = 'sha3-512';

    /**
     * Hash specified string.
     *
     * @named-arguments-supported
     */
    public static function hash(string $string, SHA $algo = self::SHA3_256, bool $binary = false, array $options = []): string
    {
        return hash($algo->value, strtolower(trim($string)), $binary, $options);
    }

    /**
     * If hashed values is equal to specified string.
     *
     * @named-arguments-supported
     */
    public static function matches(string $string, string $hash, SHA $algo = self::SHA3_256, bool $binary = false, array $options = []): bool
    {
        return $hash === self::hash($string, $algo, $binary, $options);
    }
}
