<?php

namespace App\Enum;

enum StatutPresence: string
{
    case PRESENT = 'presence.statut.present';
    case ABSENT = 'presence.statut.absent';
    case JUSTIFIE = 'presence.statut.justifie';
}
