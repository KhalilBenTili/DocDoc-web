<?php

namespace App\Controller;

use App\Entity\CategorieService;
use App\Repository\CategorieServiceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    /**
     * @Route("/index", name="index")
     */
    public function index(): Response
    {
        return $this->render('index/index.html.twig', [
            'controller_name' => 'IndexController',
        ]);
    }
    /**
     * @Route("/","accueil")
     */
    public function accueil( SessionInterface $session){
        $repo=$this->getDoctrine()->getRepository(CategorieService::class)->findAll();
        $session->set('categories',$repo);
        return $this->render('base.html.twig',['categories'=>$repo]);
    }
}
