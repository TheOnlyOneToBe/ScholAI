<?php

namespace App\Services;

use App\Repository\AnneeRepository;
use App\Repository\ReglementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class HomeService
{
    private RequestStack $requestStack;
    private EntityManagerInterface $entityManager;
    private ReglementRepository $reglementRepository;
    private AnneeRepository $anneeRepository;
    public  AnneeService $anneeService;

    public function __construct(EntityManagerInterface $entityManager, ReglementRepository $reglementRepository,
                                AnneeRepository $anneeRepository, RequestStack $requestStack,
                                AnneeService $anneeService)
    {
        $this->reglementRepository=$reglementRepository;
        $this->anneeRepository=$anneeRepository;
        $this->requestStack=$requestStack;
        $this->entityManager=$entityManager;
        $this->anneeService=$anneeService;

    }
    public function idanneeActive()
    {
        foreach ($this->anneeRepository->findAll() As $annee){{
            if($annee->isYearStatut()==1){
                $an=$annee;
            }
        }}

        return $an ;
    }

    public function anneeActive()
    {
        return $this->anneeRepository->find($this->idanneeActive());
    }


    public function montantReglement()
    {
        $annee=$this->anneeActive();
        $montantreglement=0;
       foreach ($this->reglementRepository->findAll() As $reglement) {
           if($reglement->getYear()==$annee->getId()){
               $montantreglement+=$reglement->getMontantReglement();
           }
       }
       return $montantreglement;
    }
}