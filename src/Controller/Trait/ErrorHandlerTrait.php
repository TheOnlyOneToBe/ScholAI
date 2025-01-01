<?php

namespace App\Controller\Trait;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
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
        return $this->redirectToRoute('app_home');
    }

    private function handleGenericException(\Exception $exception): Response
    {
        $this->addErrorFlash($exception->getMessage());
        return $this->redirectToRoute('app_home');
    }

    protected function handleException(\Exception $e): void
    {
        if ($e instanceof NotFoundHttpException) {
            $this->addErrorFlash($this->translator->trans('error.not_found'));
        } elseif ($e instanceof ForeignKeyConstraintViolationException) {
            $this->addErrorFlash($this->translator->trans('error.foreign_key_constraint'));
        } else {
            $this->addErrorFlash($e->getMessage());
        }
    }


}
