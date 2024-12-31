<?php

namespace App\Controller\Trait;

trait FlashMessageTrait
{
    private function addFlash(string $type, string $message): void
    {
        $this->container->get('session')->getFlashBag()->add($type, $message);
    }

    private function addSuccessFlash(string $message): void
    {
        $this->addFlash('success', $message);
    }

    private function addErrorFlash(string $message): void
    {
        $this->addFlash('error', $message);
    }

    private function addWarningFlash(string $message): void
    {
        $this->addFlash('warning', $message);
    }

    private function addInfoFlash(string $message): void
    {
        $this->addFlash('info', $message);
    }
}
