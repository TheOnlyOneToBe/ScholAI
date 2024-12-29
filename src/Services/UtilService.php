<?php

namespace App\Services;

use App\Repository\AnneeRepository;
use Symfony\Component\HttpFoundation\RequestStack;

class UtilService
{
    private AnneeRepository $anneeRepository;
    private RequestStack $requestStack;
    public AnneeService $anneeService;
    public const ANNEEACTIVE="annee";


    public function __construct(AnneeRepository $anneeRepository,RequestStack $requestStack)
    {
        $this->requestStack=$requestStack;
        $this->anneeRepository=$anneeRepository;
    }

    public function session()
    {
     return $this->requestStack->getSession();
    }

    public function getyearinsession()
    {

        return $this->session()->get(self::ANNEEACTIVE/*,$this->anneeRepository->findByStatut()->getId()*/);

}
    public function setyearinsession($id)
    {
        $this->session()->set(self::ANNEEACTIVE,$id);

    }

    public function verifyearactive()
    {
     if($this->getyearinsession()===$this->anneeRepository->findByStatut()->getId()){
         return true;
     }
     return false;
    }
}