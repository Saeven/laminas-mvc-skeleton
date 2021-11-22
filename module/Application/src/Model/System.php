<?php

declare(strict_types=1);

namespace Application\Model;

class System {
    public static function isSSL(): bool
    {
        if (!empty($_SERVER['https'])) {
            return true;
        }

        if (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
            return true;
        }

        if (isset($_SERVER['HTTP_CF_VISITOR'])) {
            $visitor = @json_decode($_SERVER['HTTP_CF_VISITOR'], false);
            if (json_last_error() === JSON_ERROR_NONE && isset($visitor->scheme) && $visitor->scheme === 'https') {
                return true;
            }
        }

        return false;
    }
}

