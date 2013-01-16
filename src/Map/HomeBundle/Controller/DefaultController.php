<?php

namespace Map\HomeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('MapHomeBundle:Default:index.html.twig');
    }
}
