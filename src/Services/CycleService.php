<?php

namespace App\Services;

use App\Form\CycleType;
use App\Repository\CycleRepository;
use App\Repository\FiliereRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;


class CycleService
{
    private RequestStack $requestStack;
    private EntityManagerInterface $entityManager;
    private CycleRepository $cycleRepository;

    public function __construct(EntityManagerInterface $entityManager,
                                CycleRepository $cycleRepository,
                                RequestStack $requestStack)
    {
        $this->cycleRepository=$cycleRepository;
        $this->requestStack=$requestStack;
        $this->entityManager=$entityManager;

    }

    public function existeLibelle($libelle)
    {
      if(count($this->cycleRepository->rechercheLibelle($libelle))!=null){
          return true;
      }
      return false;
    }

    public function listeCycles()
    {
     return $this->cycleRepository->findAll();
    }
    public function ajouterCycle($cycle): bool
    {
        if(!$this->existeLibelle($cycle->getLibelleCycle())){
            $this->entityManager->persist($cycle);
            $this->entityManager->flush();
            return true;
        }
        else {
            return false;
        }

    }

}