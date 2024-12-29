<?php

namespace App\Services;
use App\Repository\FiliereCycleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class FilCycleSerivce
{
    private RequestStack $requestStack;
    private EntityManagerInterface $entityManager;
    public  UtilService $utilService;
    private FiliereCycleRepository $FilierecycleRepository;

    public function __construct(EntityManagerInterface $entityManager,
                                FiliereCycleRepository $filierecycleRepository,
                                RequestStack $requestStack,UtilService $utilService)
    {
        $this->FilierecycleRepository=$filierecycleRepository;
        $this->utilService=$utilService;
        $this->requestStack=$requestStack;
        $this->entityManager=$entityManager;

    }

    public function listespecialite()
    {
    return $this->FilierecycleRepository->listespecialitesbystatut($this->utilService->getyearinsession());
    }
    public function existespecialite($value1,$value2):bool
    {
     if(count($this->FilierecycleRepository->existespecialite($value1,$value2))!==0){
         return true;
     }
     return false;
    }
}