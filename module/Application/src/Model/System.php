<?php

declare(strict_types=1);

namespace Application\Model;

use function array_unshift;
use function count;
use function explode;
use function json_decode;
use function json_last_error;
use function preg_match;

use const JSON_ERROR_NONE;

class System
{
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

    public static function getIP(): ?string
    {
        $ip = false;

        if (!empty($_SERVER["HTTP_CLIENT_IP"])) {
            $ip = $_SERVER["HTTP_CLIENT_IP"];
        }

        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            // Put the IP's into an array which we shall work with shortly.
            $ips = explode(', ', $_SERVER['HTTP_X_FORWARDED_FOR']);
            if ($ip) {
                array_unshift($ips, $ip);
                $ip = false;
            }

            $totalIps = count($ips);
            for ($i = 0; $i < $totalIps; $i++) {
                if (!preg_match("#^(10|172\.16|192\.168)\.#i", $ips[$i])) {
                    $ip = $ips[$i];
                    break;
                }
            }
        }

        if (!$ip && !isset($_SERVER['REMOTE_ADDR'])) {
            return null;
        }

        return $ip ?: $_SERVER['REMOTE_ADDR'];
    }
}
