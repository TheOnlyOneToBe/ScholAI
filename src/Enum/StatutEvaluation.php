<?php

namespace App\Enum;


use Symfony\Contracts\Translation\TranslatorInterface;

enum StatutEvaluation: string
{

    case EN_ATTENTE = 'evaluation.status.pending';
    case OUVERTE = 'evaluation.status.open';
    case FERMEE = 'evaluation.status.closed';
}