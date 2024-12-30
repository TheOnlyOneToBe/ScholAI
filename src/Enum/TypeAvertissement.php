<?php

namespace App\Enum;

enum TypeAvertissement: string
{
    case DISCIPLINAIRE = 'avertissement.type.disciplinaire';
    case ACADEMIQUE = 'avertissement.type.academique';
    case AUTRE = 'avertissement.type.autre';
}