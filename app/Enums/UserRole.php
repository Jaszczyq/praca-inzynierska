<?php

namespace App\Enums;

class UserRole {
    const ORGANIZER = 'organizer';
    const CLIENT = 'client';

    const TYPES = [
        self::ORGANIZER,
        self::CLIENT
    ];
}
