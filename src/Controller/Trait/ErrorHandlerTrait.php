<?php

namespace App\Controller\Trait;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

trait ErrorHandlerTrait
{
    private function handleNotFoundException(string $entityName): void
    {
        $message = $this->translator->trans('flash.error.not_found', [
            '%entity%' => $this->translator->trans('entity.' . $entityName)
        ]);
        
        throw new NotFoundHttpException($message);
    }

    private function handleAccessDeniedException(): void
    {
        $message = $this->translator->trans('flash.error.access_denied');
        throw new AccessDeniedException($message);
    }

    private function handleEntityNotFoundException(EntityNotFoundException $exception): Response
    {
        $this->addErrorFlash($exception->getMessage());
        return $this->redirectToRoute('homepage');
    }

    private function handleGenericException(\Exception $exception): Response
    {
        $this->addErrorFlash($exception->getMessage());
        return $this->redirectToRoute('homepage');
    }
}
