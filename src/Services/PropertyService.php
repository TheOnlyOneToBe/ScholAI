<?php

namespace App\Services;
use App\Repository\AnneeRepository;
use Symfony\Component\HttpFoundation\RequestStack;


class PropertyService
{
    public RequestStack $requestStack;

    public  function __construct(RequestStack $requestStack)
    {
        $this->requestStack=$requestStack;
    }
}