<?php

namespace Map\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Map\AdminBundle\Entity\Application;
use Map\AdminBundle\Form\ApplicationType;
use Map\CoreBundle\Util\Form\FormHandler;

class ApplicationController extends Controller
{
    public function indexAction()
    {
        $repository = $this->getDoctrine()
            ->getEntityManager()
            ->getRepository('MapAdminBundle:Application');

        $applications = $repository->findAllOrderByName();

        return $this->render(
            'MapAdminBundle:Application:index.html.twig',
            array('applications' => $applications)
        );
    }

    public function addAction()
    {
        $application = new Application();
        $form        = $this->createForm(new ApplicationType(), $application);
        
        $handler = new FormHandler(
            $form,
            $this->getRequest(),
            $this->getDoctrine()->getEntityManager()
        );
        
        if ($handler->process()) {
            
            $id = $application->getId();
            
            $this->get('session')->getFlashBag()
                ->add('success', 'Application added successfully !');
                        
            return $this->redirect(
                $this->generateUrl('adminApplication_view', array('id' => $id))
            );
        }
        return $this->render(
            'MapAdminBundle:Application:add.html.twig',
            array('form' => $form->createView())
        );
    }

    public function viewAction(Application $application)
    {
        return $this->render(
            'MapAdminBundle:Application:view.html.twig',
            array('application' => $application)
        );
    }
    
    public function editAction(Application $application)
    {
        $form    = $this->createForm(new ApplicationType(), $application);
        
        $handler = new FormHandler(
            $form,
            $this->getRequest(),
            $this->getDoctrine()->getEntityManager()
        );
        
        if ($handler->process()) {
            
            $id = $application->getId();
            
            $this->get('session')->getFlashBag()
                ->add('success', 'Application edited successfully !');
            
            return $this->redirect(
                $this->generateUrl('adminApplication_view', array('id' => $id))
            );
        }
        return $this->render(
            'MapAdminBundle:Application:edit.html.twig',
            array('form' => $form->createView(), 'application' => $application)
        );
    }
    
    public function delAction(Application $application)
    {
        if( $this->get('request')->getMethod() == 'POST' ) {
            
            $em = $this->getDoctrine()->getEntityManager();
            
            $em->remove($application);
            $em->flush();
            
            $this->get('session')->getFlashBag()
                ->add('success', 'Application removed successfully !');
                        
            return $this->redirect(
                $this->generateUrl('adminApplication_index')
            );
        }
        return $this->render(
            'MapAdminBundle:Application:del.html.twig',
            array('application' => $application)
        );
    }
}