<?php

namespace Map\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ApplicationController extends Controller {

    public function indexAction() {

        $repository = $this->getDoctrine()
                            ->getEntityManager()
                            ->getRepository('MapAdminBundle:Application');

        $applications = $repository->findAll();
        
        return $this->render(
            'MapAdminBundle:Application:index.html.twig',
            array('applications' => $applications)
        );
    }

}