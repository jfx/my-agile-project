<?php
/**
 * Application controller class.
 *
 * LICENSE : This file is part of My Agile Project.
 *
 * My Agile Project is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * My Agile Project is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @category  MyAgileProject
 * @package   Admin
 * @author    Francois-Xavier Soubirou <soubirou@yahoo.fr>
 * @copyright 2012 Francois-Xavier Soubirou
 * @license   http://www.gnu.org/licenses/   GPLv3
 * @link      http://www.myagileproject.org
 * @since     2
 *
 */

namespace Map\AdminBundle\Controller;

use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Map\AdminBundle\Entity\Application;
use Map\AdminBundle\Form\ApplicationType;
use Map\CoreBundle\Util\Form\FormHandler;

class ApplicationController extends Controller
{
    public function indexAction()
    {
        $repository = $this->getDoctrine()
            ->getManager()
            ->getRepository('MapAdminBundle:Application');

        $applications = $repository->findAllOrderByName();

        return $this->render(
            'MapAdminBundle:Application:index.html.twig',
            array('applications' => $applications)
        );
    }

   /**
    * @Secure(roles="ROLE_SUPER_ADMIN")
    */
    public function addAction()
    {
        $application = new Application();
        $form        = $this->createForm(new ApplicationType(), $application);
        
        $handler = new FormHandler(
            $form,
            $this->getRequest(),
            $this->getDoctrine()->getManager()
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
    
   /**
    * @Secure(roles="ROLE_SUPER_ADMIN")
    */
    public function editAction(Application $application)
    {
        $form    = $this->createForm(new ApplicationType(), $application);
        
        $handler = new FormHandler(
            $form,
            $this->getRequest(),
            $this->getDoctrine()->getManager()
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
    
   /**
    * @Secure(roles="ROLE_SUPER_ADMIN")
    */
    public function delAction(Application $application)
    {
        if( $this->get('request')->getMethod() == 'POST' ) {
            
            $em = $this->getDoctrine()->getManager();
            
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