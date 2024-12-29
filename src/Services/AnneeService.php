<?php

namespace App\Services;

use App\Entity\Annee;
use App\Repository\AnneeRepository;
use Carbon\Carbon;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Contracts\Translation\TranslatorInterface;

class AnneeService
{
private RequestStack $requestStack;
private EntityManagerInterface $entityManager;
private AnneeRepository $anneeRepository;
private TranslatorInterface $translator;
public UtilService $utilService;


    public function __construct(EntityManagerInterface $entityManager, AnneeRepository $anneeRepository,
                                RequestStack $requestStack, TranslatorInterface $translator,
                                UtilService $utilService)
    {
     $this->anneeRepository=$anneeRepository;
     $this->requestStack=$requestStack;
     $this->entityManager=$entityManager;
     $this->translator=$translator;
     $this->utilService=$utilService;

}

    public function session()
    {
     return $this->requestStack->getSession();
}


    public function listeDesAnnees(){

        return  $this->anneeRepository->listeAnnees();

    }

    public function DeleteAnnee($annee)
    {
        $annee=$this->anneeRepository->find($annee);
        if(count($annee->getFilierecycles())==0 && count($annee->getInscriptions())==0){
            $this->entityManager->remove($annee);
            $this->entityManager->flush();
            $this->session()->getFlashBag()->add('success', $this->translator->
            trans('annee.delete.delete',
                ['%$annee%'=>(date_format($annee->getYearStart(),'Y-m-d').  ' A ' .date_format($annee->getYearEnd(),'Y-m-d'))],
                'messages'));;
        }
        else{
            $this->session()->getFlashBag()->add('error',
                "L'année ".$annee->getId()." n'a pas pu étre supprimée.<br>
                Veuillez vérifiez si l'année en cours possède des données");
        }

    }
//  $yearstart=Carbon::createFromLocaleFormat('d F Y', 'fr', $an->getYearStart());
    /*$yearend=Carbon::createFromLocaleFormat('d F Y', 'fr', $an->getYearEnd());
    $yearstart=new \DateTime($yearstart->startofDay());
    $yearend=new \DateTime($yearend->startofDay());*/
    public function activeyear()
    {

     return $this->anneeRepository->findByStatut()->getId();
    }

    public function yearactive(): Annee
    {
        return $this->anneeRepository->findByStatut();
    }
    public function stringtodate($string)
    {

        $locale=$this->requestStack->getMainRequest()->getLocale();

        //Veuillez remplacer le fr par
        return (new \DateTime((Carbon::createFromLocaleFormat('d F Y', 'fr', $string))->startofDay()))->format('Y-m-d');
    }
    public function datetostring(\DateTimeInterface $dateTime):string
    {
        $dateformat=new \IntlDateFormatter(
            $this->requestStack->getMainRequest()->getLocale(),
            \IntlDateFormatter::FULL,
            \IntlDateFormatter::NONE);

        $dateformat->setPattern('d MMMM yyyy');
        return $dateformat->format($dateTime);
    }
    public function datetodatetime($date):\DateTime
    {
        return \DateTime::createFromFormat('Y-m-d',$this->stringtodate($date));
    }
}