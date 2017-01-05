<?php

namespace AnimalBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AnimalBundle\Entity\Animal;
use AnimalBundle\Form\AnimalType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;



class DefaultController extends Controller
{
    public function indexAction()
    {
       $em=$this->getDoctrine()->getEntityManager();
        $animaux= $em->getRepository("AnimalBundle:Animal")->findAll();
        return $this->render('AnimalBundle:Default:index.html.twig',
                       array('animaux'=> $animaux,));
    }
    public function ajouterAction(Request $request)
    {
        $em=$this->getDoctrine()->getEntityManager();
        $animal=new Animal();
        $form = $this->createForm(AnimalType::class,$animal);
                
if($request->isMethod('POST') )
{
        $form->handleRequest($request);  
        if($form->isValid())
        {
        $animal=$form->getData();
        $em->persist($animal);
        $em->flush();
        return $this->redirect($this->generateUrl("animal_homepage",array('id' => $animal->getId(),)));
        }
}
        return $this->render('AnimalBundle:Default:ajouter.html.twig', array('form'=> $form->createView()));
    }
    public function informationsAction(Animal $animal)
    {
      
        return $this->render('AnimalBundle:Default:info.html.twig',
                       array('animal'=> $animal,));
    }
      public function suppressionAction(Animal $animal)
    {
               $em=$this->getDoctrine()->getEntityManager();
               $em->remove($animal);
               $em->flush();
               return $this->redirect($this->generateUrl("animal_homepage"));

        
    }
     public function modificationAction(Animal $animal,Request $request)
    {
        $em=$this->getDoctrine()->getEntityManager();
        $form = $this->createForm(AnimalType::class,$animal);
                
if($request->isMethod('POST') )
{
        $form->handleRequest($request);  
        if($form->isValid())
        {
        $animal=$form->getData();
        $em->persist($animal);
        $em->flush();
        return $this->redirect($this->generateUrl("animal_info",
                array('id' => $animal->getId())));
        }
}
        return $this->render('AnimalBundle:Default:modif.html.twig', 
                array('id'=> $animal->getId(),'form'=> $form->createView()));
    }
}


