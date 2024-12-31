<?php

namespace App\Controller\Trait;

use Symfony\Component\HttpFoundation\RequestStack;

trait FlashMessageTrait
{
    private RequestStack $requestStack;

    /**
     * @required
     */
    public function setRequestStack(RequestStack $requestStack): void
    {
        $this->requestStack = $requestStack;
    }

    protected function addFlash(string $type, mixed $message): void
    {
        $this->requestStack->getSession()->getFlashBag()->add($type, $message);
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
// Ok vérifie les entités et creer les ficture un fichier appfixture existe deja je veux que tu me géneres des données pour 04 années une seule doit etre active le reste non active
