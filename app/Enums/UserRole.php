<?php

namespace App\Enums;

enum UserRole: string
{
    case admin = 'admin';
    case employee = 'employee';
    case client = 'client';
}
