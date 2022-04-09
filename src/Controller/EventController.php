<?php

namespace App\Controller;
use App\Service\FileUploader;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Event;
use App\Form\EventType;


class EventController extends AbstractController
{
    #[Route('/', name: 'home_event')]
    public function index(): Response
    {
        $home = 'Home';
        return $this->render('event/index.html.twig', [
            'home' => $home
        ]);
    }
    #[Route('/event', name: 'event_event')]
    public function eventEvent(ManagerRegistry $doctrine): Response
    {
        $eventTitle = 'Event';
       
          $events = $doctrine->getManager()->getRepository(Event::class)->findAll();
          
            return $this->render('event/event.html.twig', [
                "events" => $events,
                "eventTitle" => $eventTitle

            ]);
           }  
           #[Route('/create', name: 'create_Event')]
           public function createProduct(Request $request, ManagerRegistry $doctrine, FileUploader $fileUploader ): Response
           {
               $event = new Event();
               //  dd($product);
               $form = $this->createForm(EventType::class, $event);
               $form->handleRequest($request);
       
               if($form->isSubmitted() && $form->isValid()){
                   $pictureFile = $form->get('picture')->getData();
                   //pictureUrl is the name given to the input field
                   if ($pictureFile) {
                   $pictureFileName = $fileUploader->upload($pictureFile);
                   $event->setPicture($pictureFileName);
                   }
                   $eventForm = $form->getData();
                   //  dd($product);
                   $em = $doctrine->getManager();
                   $em ->persist($eventForm);
                   $em->flush();
                   $this->addFlash("success", "New Event Added");
       
                   return $this->redirectToRoute("event_event");
               }
               return $this->render('event/create.html.twig', [
                  "form" => $form->createView()
               ]);
           }
        
        
    #[Route('/details/{id}', name: 'details_event')]
    public function detailsEvent( $id, ManagerRegistry $doctrine): Response
    {
        $event = $doctrine->getManager()->getRepository(Event::class)->find($id);
    //   dd($event);
        $details = 'Details of the Event';
        return $this->render('event/details.html.twig', [
            'details' => $details,
            'event' => $event
        ]);
    }
    #[Route('/edit/{id}', name: 'edit_event')]
    public function editEvent(Request $request,$id,ManagerRegistry $doctrine): Response
    {
       
        $event = $doctrine->getManager()->getRepository(Event::class)->find($id);
        //  dd($product);
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            
            $event = $form->getData();
            //  dd($product);
            $em = $doctrine->getManager();
            $em ->persist($event);
            $em->flush();
            $this->addFlash("success", "The Product has been updated");

            return $this->redirectToRoute("event_event");
        }
        return $this->render('event/edit.html.twig', [
            "form" => $form->createView()
           
        ]);
    }
    #[Route('/delete/{id}', name: 'delete_event')]
    public function deleteEvent($id, ManagerRegistry $doctrine): Response
    {
        $event = $doctrine->getManager()->getRepository(Event::class)->find($id);
        $em = $doctrine->getManager();
        
        $em->remove($event);
        
        $em->flush();

        $this->addFlash("success", "One Event has removed");

        return $this->redirectToRoute('home_event');
    }
    #[Route('/filter', name: 'filter_event')]
    public function filterEvent( ManagerRegistry $doctrine): Response
    {
        $type =["Music","Sport","Movie","Theater"];
        $repository =  $doctrine->getRepository(Event::class);
        $events = $repository->findBy(array('type'=> array('Music','Sport','Movie','Theater')));

        // dd($event);
       
        return $this->render('event/filter.html.twig', [
            "events" => $events,
            

        ]);

         return $this->redirectToRoute('home_event');
    }

}
