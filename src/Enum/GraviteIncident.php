<?php

namespace App\Enum;

enum : string
{
    case FAIBLE = 'incident.gravite.faible';
    case MOYENNE = 'incident.gravite.moyenne';
    case ELEVEE = 'incident.gravite.elevee';
}
