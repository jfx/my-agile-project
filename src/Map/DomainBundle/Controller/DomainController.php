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
use Map\CoreBundle\Form\FormHandler;
use Map\DomainBundle\Entity\Domain;
use Map\DomainBundle\Form\DomainType;
use Map\UserBundle\Entity\Role;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Domain controller class.
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
class DomainController extends Controller
{
    /**
     * List of domains
     *
     * @return Response A Response instance
     *
     * @Secure(roles="ROLE_USER")
     */
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
            $this->container
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
     * View a domain
     *
     * @param Domain $domain The domain to view.
     *
     * @return Response A Response instance
     *
     * @Secure(roles="ROLE_USER")
     */
    public function viewAction(Domain $domain)
    {
        $serviceUpdate = $this->container->get('map_user.updatecontext4user');
        $serviceUpdate->setCurrentDomain($domain);

        $serviceInfo = $this->container->get('map_user.domaininfo');
        $child       = $serviceInfo->getChildCount($domain);

        $domainType = new DomainType();
        $domainType->setDisabled();
        $form = $this->createForm($domainType, $domain);

        return $this->render(
            'MapDomainBundle:Domain:view.html.twig',
            array(
                'form' => $form->createView(),
                'domain' => $domain,
                'child' => $child
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
        $service = $this->container->get('map_user.updatecontext4user');
        $service->setCurrentDomain($domain);

        $sc = $this->container->get('security.context');

        if (!($sc->isGranted('ROLE_SUPER_ADMIN')
            || $sc->isGranted(Role::MANAGER_ROLE))
        ) {
            throw new AccessDeniedException(
                'You are not allowed to access this resource'
            );
        }

        $form    = $this->createForm(new DomainType(), $domain);

        $handler = new FormHandler(
            $form,
            $this->getRequest(),
            $this->container
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
        $service = $this->container->get('map_user.updatecontext4user');

        if ($this->get('request')->getMethod() == 'POST') {

            $em = $this->getDoctrine()->getManager();

            $service->setCurrentDomain(null);

            $em->remove($domain);

            try {
                $em->flush();

                $this->get('session')->getFlashBag()
                    ->add('success', 'Domain removed successfully !');

                return $this->redirect(
                    $this->generateUrl('domain_index')
                );

            } catch (Exception $e) {

                $this->get('session')->getFlashBag()->add(
                    'danger',
                    'Impossible to remove this item'
                    .' - Integrity constraint violation !'
                );

                return $this->redirect(
                    $this->generateUrl(
                        'domain_del',
                        array('id' => $domain->getId())
                    )
                );
            }
        }
        $service->setCurrentDomain($domain);

        $domainType = new DomainType();
        $domainType->setDisabled();
        $form = $this->createForm($domainType, $domain);

        return $this->render(
            'MapDomainBundle:Domain:del.html.twig',
            array('form' => $form->createView(), 'domain' => $domain)
        );
    }
}
