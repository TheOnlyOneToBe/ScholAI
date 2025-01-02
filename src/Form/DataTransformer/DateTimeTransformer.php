<?php

namespace App\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use DateTime;

class DateTimeTransformer implements DataTransformerInterface
{
    public function transform(mixed $value): mixed
    {
        if (null === $value) {
            return '';
        }

        if (!$value instanceof \DateTime) {
            throw new TransformationFailedException('Expected a DateTime.');
        }

        return $value->format('Y-m-d H:i:s');
    }

    public function reverseTransform(mixed $value): mixed
    {
        if (!$value) {
            return null;
        }

        try {
            $date = DateTime::createFromFormat('Y-m-d H:i', $value);
            if (!$date) {
                throw new TransformationFailedException('Format de date invalide');
            }
            
            // Ajout des secondes à 0
            $date->setTime(
                (int) $date->format('H'),
                (int) $date->format('i'),
                0
            );

            // Vérification des erreurs de date
            $errors = DateTime::getLastErrors();
            if ($errors['warning_count'] > 0 || $errors['error_count'] > 0) {
                throw new TransformationFailedException('Date invalide');
            }

            return $date;
        } catch (\Exception $e) {
            throw new TransformationFailedException('Erreur lors de la conversion de la date');
        }
    }
}
