<?php

namespace App\Services;

use App\Repository\InscriptionRepository;
use App\Repository\ReglementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class InscriptionService
{
    private RequestStack $requestStack;
    private EntityManagerInterface $entityManager;
    private  InscriptionRepository $inscriptionRepository;
    private HomeService $homeService;


    public function __construct(RequestStack $requestStack,
                                EntityManagerInterface $entityManager,
                                InscriptionRepository $inscriptionRepository,
                                HomeService $homeService)
    {
        $this->entityManager=$entityManager;
        $this->requestStack=$requestStack;
        $this->inscriptionRepository=$inscriptionRepository;
        $this->homeService=$homeService;
    }

    public function listedesinscriptions():array
    {
      return $this->inscriptionRepository->listedesinscriptions($this->homeService->anneeActive());
    }

    public function existeinscription($string1,$string2)
    {
     return $this->inscriptionRepository->existestudent($this->homeService->idanneeActive(),$string1,$string2);

}

}