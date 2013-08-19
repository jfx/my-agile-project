<?php
/**
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
 */

namespace Map\ProjectBundle\Controller;

use JMS\SecurityExtraBundle\Annotation\Secure;
use Map\CoreBundle\Form\FormHandler;
use Map\DomainBundle\Entity\Domain;
use Map\DomainBundle\Form\DomainType;
use Map\UserBundle\Entity\Role;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

/**
 * Project controller class.
 *
 * @category  MyAgileProject
 * @package   Project
 * @author    Francois-Xavier Soubirou <soubirou@yahoo.fr>
 * @copyright 2013 Francois-Xavier Soubirou
 * @license   http://www.gnu.org/licenses/   GPLv3
 * @link      http://www.myagileproject.org
 * @since     2
 *
 */
class ProjectController extends Controller
{

    /**
     * Add a domain
     *
     * @return Response A Response instance
     *
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

    /**
     * View a project.
     *
     * @param int $id The project to view.
     *
     * @return Response A Response instance
     *
     * @Secure(roles="ROLE_USER")
     */
    public function viewAction($id)
    {
        $domain = $this->getCurrentDomainFromUser();

        if (is_null($domain)) {
            return $this->redirect($this->generateUrl('domain_index'));
        }
        
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('MapProjectBundle:Project');

        try {
            $project = $repository->findByProjectIdDomainId(
                $id,
                $domain->getId()
            );
        } catch (Exception $e) {
            throw $this->createNotFoundException(
                'Project[id='.$id.'] not found for this domain'
            );
        }

        return $this->render(
            'MapProjectBundle:Project:view.html.twig',
            array(
                'project' => $project,
                'domain' => $domain
            )
        );
    }

    /**
     * Edit a domain
     *
     * @param Domain $domain The domain to edit.
     *
     * @return Response A Response instance
     *
     * @Secure(roles="ROLE_USER")
     */
    public function editAction(Domain $domain)
    {
        $service = $this->container->get('map_user.updatedomain4user');
        $service->setCurrentDomain($domain);

        $sc = $this->container->get('security.context');

        if (!($sc->isGranted('ROLE_SUPER_ADMIN')
            || $sc->isGranted(Role::MANAGER_ROLE))
        ) {
            throw new AccessDeniedHttpException(
                'You are not allowed to access this resource'
            );
        }

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
     * Delete a domain
     *
     * @param Domain $domain The domain to delete.
     *
     * @return Response A Response instance
     *
     * @Secure(roles="ROLE_SUPER_ADMIN")
     */
    public function delAction(Domain $domain)
    {
        $service = $this->container->get('map_user.updatedomain4user');

        $success = true;

        if ($this->get('request')->getMethod() == 'POST') {

            $em = $this->getDoctrine()->getManager();

            $service->setCurrentDomain(null);

            $em->remove($domain);

            try {
                $em->flush();

            } catch (\Exception $e) {
                $success = false;

                $this->get('session')->getFlashBag()->add(
                    'error',
                    'Impossible to remove this item'
                    .' - Integrity constraint violation !'
                );
            }
            if ($success) {
                $this->get('session')->getFlashBag()
                    ->add('success', 'Domain removed successfully !');

                return $this->redirect(
                    $this->generateUrl('domain_index')
                );
            }
        }
        if ($success) {
            $service->setCurrentDomain($domain);
        }

        return $this->render(
            'MapDomainBundle:Domain:del.html.twig',
            array('domain' => $domain)
        );
    }
    
    /**
     * Return the current domain from user context.
     *
     * @return Domain
     */
    private function getCurrentDomainFromUser()
    {
        $user = $this->container->get('security.context')->getToken()
            ->getUser();

        $domain = $user->getCurrentDomain();

        return $domain;
    }
}
