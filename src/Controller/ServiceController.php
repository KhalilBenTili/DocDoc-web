<?php

namespace App\Controller;

use App\Entity\Service;
use App\Form\ServiceType;
use App\Repository\ServiceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
/**
 * @Route("/service")
 */
class ServiceController extends AbstractController
{
    /**
     * @Route("/", name="service")
     */
    public function index(): Response
    {
        return $this->render('service/index.html.twig', [
            'controller_name' => 'ServiceController'
        ]);
    }
    /**
     * @Route("/affiche", name="afficherservice")
     */
    public function affiche(ServiceRepository $repo){
        return $this->render('service/affiche.html.twig',['services'=>$repo->findAll()]);
    }
    /**
     * @Route("/delete/{id}",name="deleteservice")
     */
    public function delete( $id ,ServiceRepository $repo){
        $em=$this->getDoctrine()->getManager();
        $service=$repo->find($id);
        $em->remove($service);
        $em->flush();
        return $this->redirectToRoute('afficherservice');
    }
    /**
     * @Route("/ajouter",name="Ajouterservice")
     */
    function Ajout(Request $request){
        $service=new Service();
        $form=$this->createForm(ServiceType::class,$service);
        $form->add("ajouter",SubmitType::class);
        $form->handleRequest($request);
        if($form->isSubmitted()&&$form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->persist($service);//insert into
            $em->flush();//maj de la BD
            return $this->redirectToRoute("afficherservice");
        }
        return $this->render('service/ajout.html.twig',['f'=>$form->createView()]);
    }

    /**
     * @Route("/update/{id}",name="updateservice")
     */
    function update($id,ServiceRepository $repo,Request $request){
        $service=$repo->find($id) ;
        $form=$this->createForm(ServiceType::class,$service);
        $form->add("update",SubmitType::class);
        $form->handleRequest($request);
        if($form->isSubmitted()&&$form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->flush();//maj de la BD
            return $this->redirectToRoute("afficherservice");
        }

        return $this->render("service/update.html.twig",['f'=>$form->createView()]);

    }
}

