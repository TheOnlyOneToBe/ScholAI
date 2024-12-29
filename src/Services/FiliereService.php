<?php

namespace App\Services;

use App\Entity\Filiere;
use App\Repository\AnneeRepository;
use App\Repository\FiliereRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class FiliereService
{
    private RequestStack $requestStack;
    private EntityManagerInterface $entityManager;
    private FiliereRepository $FiliereRepository;


    public function __construct(EntityManagerInterface $entityManager,
                                FiliereRepository $filiereRepository,
                                RequestStack $requestStack)
    {
        $this->FiliereRepository=$filiereRepository;
        $this->requestStack=$requestStack;
        $this->entityManager=$entityManager;

    }

    public function existeLibelle($libelle)

    {
        $existe=$this->FiliereRepository->rechercheParLibelle(strtolower($libelle));
     if(count($existe)!=null) {
         return true;
     }

        return false;
    }

    public function listeDesFilieres()
    {
        return $this->FiliereRepository->findAll();

    }

    public function ajouterFiliere($filiere)
    {
     if(!$this->existeLibelle($filiere->getLibelleFiliere())){
         $this->entityManager->persist($filiere);
         $this->entityManager->flush();
         return true;
     }
     else {
         return false;
     }

    }
}