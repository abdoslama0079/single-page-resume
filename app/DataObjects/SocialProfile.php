<?php

namespace App\DataObjects;

readonly class SocialProfile
{
    public function __construct(
        public string $network = '',
        public string $username = '',
        public string $url = '',
    ) {
    }

    public static function fromArray(array $data)
    {
        return new self(
            network: $data['network'] ?? '',
            username: $data['username'] ?? '',
            url: $data['url'] ?? '',
        );
    }
}
