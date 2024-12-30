<?php

namespace App\Enum;

enum StatutInscription: string
{
    case EN_ATTENTE = 'inscription.statut.pending';
    case VALIDE = 'inscription.statut.valide';
    case REJETE = 'inscription.statut.rejete';
    case TERMINE = 'inscription.statut.termine';
}

