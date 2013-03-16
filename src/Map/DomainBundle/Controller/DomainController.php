<?php
/**
 * Domain controller class.
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
 * @package   Domain
 * @author    Francois-Xavier Soubirou <soubirou@yahoo.fr>
 * @copyright 2012 Francois-Xavier Soubirou
 * @license   http://www.gnu.org/licenses/   GPLv3
 * @link      http://www.myagileproject.org
 * @since     2
 *
 */

namespace Map\DomainBundle\Controller;

use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Map\DomainBundle\Entity\Domain;
use Map\DomainBundle\Form\DomainType;
use Map\CoreBundle\Util\Form\FormHandler;

class DomainController extends Controller
{
    public function indexAction()
    {
        $repository = $this->getDoctrine()
            ->getManager()
            ->getRepository('MapDomainBundle:Domain');

        $domains = $repository->findAllOrderByName();

        return $this->render(
            'MapDomainBundle:Domain:index.html.twig',
            array('domains' => $domains)
        );
    }

   /**
    * @Secure(roles="ROLE_SUPER_ADMIN")
    */
    public function addAction()
    {
        $domain = new Domain();
        $form   = $this->createForm(new DomainType(), $domain);
        
        $handler = new FormHandler(
            $form,
            $this->getRequest(),
            $this->getDoctrine()->getManager()
        );
        
        if ($handler->process()) {
            
            $id = $domain->getId();
            
            $this->get('session')->getFlashBag()
                ->add('success', 'Domain added successfully !');
                        
            return $this->redirect(
                $this->generateUrl('domain_view', array('id' => $id))
            );
        }
        return $this->render(
            'MapDomainBundle:Domain:add.html.twig',
            array('form' => $form->createView())
        );
    }

    public function viewAction(Domain $domain)
    {
        return $this->render(
            'MapDomainBundle:Domain:view.html.twig',
            array('domain' => $domain)
        );
    }
    
   /**
    * @Secure(roles="ROLE_SUPER_ADMIN")
    */
    public function editAction(Domain $domain)
    {
        $form    = $this->createForm(new DomainType(), $domain);
        
        $handler = new FormHandler(
            $form,
            $this->getRequest(),
            $this->getDoctrine()->getManager()
        );
        
        if ($handler->process()) {
            
            $id = $domain->getId();
            
            $this->get('session')->getFlashBag()
                ->add('success', 'Domain edited successfully !');
            
            return $this->redirect(
                $this->generateUrl('domain_view', array('id' => $id))
            );
        }
        return $this->render(
            'MapDomainBundle:Domain:edit.html.twig',
            array('form' => $form->createView(), 'domain' => $domain)
        );
    }
    
   /**
    * @Secure(roles="ROLE_SUPER_ADMIN")
    */
    public function delAction(Domain $domain)
    {
        if( $this->get('request')->getMethod() == 'POST' ) {
            
            $em = $this->getDoctrine()->getManager();
            
            $em->remove($domain);
            $em->flush();
            
            $this->get('session')->getFlashBag()
                ->add('success', 'Domain removed successfully !');
                        
            return $this->redirect(
                $this->generateUrl('domain_index')
            );
        }
        return $this->render(
            'MapDomainBundle:Domain:del.html.twig',
            array('domain' => $domain)
        );
    }
}