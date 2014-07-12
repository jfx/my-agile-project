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

namespace Map\DomainBundle\Controller;

use Exception;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Map\DomainBundle\Entiy\Domain;
use Map\DomainBundle\Form\ResourceTypeAdd;
use Map\DomainBundle\Form\ResourceTypeEditDel;
use Map\DomainBundle\Form\ResourceFormHandler;
use Map\UserBundle\Entity\UserDmRole;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * Resource controller class.
 *
 * @category  MyAgileProject
 * @package   Domain
 * @author    Francois-Xavier Soubirou <soubirou@yahoo.fr>
 * @copyright 2013 Francois-Xavier Soubirou
 * @license   http://www.gnu.org/licenses/   GPLv3
 * @link      http://www.myagileproject.org
 * @since     2
 */
class ResourceController extends Controller
{
    /**
     * List of resources
     *
     * @return Response A Response instance
     *
     * @Secure(roles="ROLE_USER")
     */
    public function indexAction()
    {
        $domain = $this->getCurrentDomainFromUser();

        if ($domain === null) {
            return $this->redirect($this->generateUrl('domain_index'));
        }

        $repository = $this->getDoctrine()
            ->getManager()
            ->getRepository('MapUserBundle:UserDmRole');

        $resources = $repository->findUsersByDomain($domain);

        $service = $this->container->get('map_user.domaininfo');
        $child   = $service->getChildCount($domain);

        return $this->render(
            'MapDomainBundle:Resource:index.html.twig',
            array(
                'resources' => $resources,
                'domain' => $domain,
                'child' => $child
            )
        );
    }

    /**
     * Add a resource
     *
     * @return Response A Response instance
     *
     * @Secure(roles="ROLE_SUPER_ADMIN, ROLE_DM_MANAGER")
     */
    public function addAction()
    {
        $domain = $this->getCurrentDomainFromUser();

        if ($domain === null) {
            return $this->redirect($this->generateUrl('domain_index'));
        }

        $userDmRole = new UserDmRole();

        $repositoryRole = $this->getDoctrine()
            ->getManager()
            ->getRepository('MapUserBundle:Role');
        $defaultRole = $repositoryRole->findDefaultRole();
        $userDmRole->setRole($defaultRole);

        $form = $this->createForm(new ResourceTypeAdd($domain), $userDmRole);

        $handler = new ResourceFormHandler(
            $form,
            $this->getRequest(),
            $this->container,
            $domain
        );

        if ($handler->process()) {

            $userDmRoleInForm = $form->getData();
            $userId = $userDmRoleInForm->getUser()->getId();

            $service = $this->container->get('map_user.updatecontext4user');
            $service->refreshAvailableDomains4UserId($userId);

            $this->get('session')->getFlashBag()
                ->add('success', 'Resource added successfully !');

            return $this->redirect(
                $this->generateUrl('dm-resource_index')
            );
        }

        return $this->render(
            'MapDomainBundle:Resource:add.html.twig',
            array('form' => $form->createView())
        );
    }

    /**
     * Edit a resource
     *
     * @param int $id The resourse id.
     *
     * @return Response A Response instance
     *
     * @Secure(roles="ROLE_SUPER_ADMIN, ROLE_DM_MANAGER")
     */
    public function editAction($id)
    {
        $domain = $this->getCurrentDomainFromUser();

        if ($domain === null) {
            return $this->redirect($this->generateUrl('domain_index'));
        }

        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('MapUserBundle:UserDmRole');

        try {
            $userDmRole = $repository->findByUserIdDomainId(
                $id,
                $domain->getId()
            );
        } catch (Exception $e) {
            throw $this->createNotFoundException(
                'Resource[id='.$id.'] not found for this domain'
            );
        }

        $form = $this->createForm(
            new ResourceTypeEditDel($domain),
            $userDmRole
        );

        $handler = new ResourceFormHandler(
            $form,
            $this->getRequest(),
            $this->container,
            $domain
        );

        if ($handler->process()) {

            $service = $this->container->get('map_user.updatecontext4user');
            $service->refreshAvailableDomains4UserId($id);

            $this->get('session')->getFlashBag()
                ->add('success', 'Resource edited successfully !');

            return $this->redirect(
                $this->generateUrl('dm-resource_index')
            );
        }

        return $this->render(
            'MapDomainBundle:Resource:edit.html.twig',
            array('form' => $form->createView())
        );
    }

    /**
     * Delete a resource
     *
     * @param int $id The resourse id.
     *
     * @return Response A Response instance
     *
     * @Secure(roles="ROLE_SUPER_ADMIN, ROLE_DM_MANAGER")
     */
    public function delAction($id)
    {
        $domain = $this->getCurrentDomainFromUser();

        if ($domain === null) {
            return $this->redirect($this->generateUrl('domain_index'));
        }

        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('MapUserBundle:UserDmRole');

        try {
            $userDmRole = $repository->findByUserIdDomainId(
                $id,
                $domain->getId()
            );
        } catch (Exception $e) {
            throw $this->createNotFoundException(
                'Resource[id='.$id.'] not found for this domain'
            );
        }
        
        if ($this->get('request')->getMethod() == 'POST') {

            $em->remove($userDmRole);

            try {
                $em->flush();

                $service = $this->container->get('map_user.updatecontext4user');
                $service->refreshAvailableDomains4UserId($id);

                $this->get('session')->getFlashBag()
                    ->add('success', 'Resource removed successfully !');

                return $this->redirect(
                    $this->generateUrl('dm-resource_index')
                );
            } catch (Exception $e) {

                $this->get('session')->getFlashBag()->add(
                    'danger',
                    'Impossible to remove this item'
                    .' - Integrity constraint violation !'
                );
            }
        }

        $resourceType = new ResourceTypeEditDel($domain);
        $resourceType->setDisabled();       
        $form = $this->createForm($resourceType, $userDmRole);

        return $this->render(
            'MapDomainBundle:Resource:del.html.twig',
            array('form' => $form->createView())
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
