<?php

namespace App\Enum;

enum GraviteIncident: string
{
    case FAIBLE = 'incident.gravite.faible';
    case MOYENNE = 'incident.gravite.moyenne';
    case ELEVEE = 'incident.gravite.elevee';
}
