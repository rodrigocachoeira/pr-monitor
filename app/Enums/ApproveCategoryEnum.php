<?php

namespace App\Enums;

enum ApproveCategoryEnum: string
{
    case BACKEND = 'backend';
    
    case FRONTEND = 'frontend';
    
    case INFRASTRUCTURE = 'infrastructure';
}
