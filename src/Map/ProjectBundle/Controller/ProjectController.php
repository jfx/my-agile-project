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

use Exception;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Map\CoreBundle\Form\FormHandler;
use Map\DomainBundle\Entity\Domain;
use Map\ProjectBundle\Entity\Project;
use Map\ProjectBundle\Form\ProjectType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

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
     * Add a project.
     *
     * @return Response A Response instance
     *
     * @Secure(roles="ROLE_DM_MANAGER")
     */
    public function addAction()
    {
        $domain = $this->getCurrentDomainFromUser();

        if (is_null($domain)) {
            return $this->redirect($this->generateUrl('domain_index'));
        }
        $project = new Project();
        $project->setDomain($domain);

        $form   = $this->createForm(
            new ProjectType($this->container),
            $project
        );

        $handler = new FormHandler(
            $form,
            $project,
            $this->getRequest(),
            $this->container
        );

        if ($handler->process()) {

            $id = $project->getId();

            $this->get('session')->getFlashBag()
                ->add('success', 'Project added successfully !');

            return $this->redirect(
                $this->generateUrl('project_view', array('id' => $id))
            );
        }

        return $this->render(
            'MapProjectBundle:Project:add.html.twig',
            array('form' => $form->createView(), 'domain' => $domain)
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
     * Edit a project
     *
     * @param int $id Id of the project to edit.
     *
     * @return Response A Response instance
     *
     * @Secure(roles="ROLE_DM_MANAGER")
     */
    public function editAction($id)
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

        $form = $this->createForm(new ProjectType($this->container), $project);

        $handler = new FormHandler(
            $form,
            $project,
            $this->getRequest(),
            $this->container
        );

        if ($handler->process()) {

            $id = $project->getId();

            $this->get('session')->getFlashBag()
                ->add('success', 'Project edited successfully !');

            return $this->redirect(
                $this->generateUrl('project_view', array('id' => $id))
            );
        }

        return $this->render(
            'MapProjectBundle:Project:edit.html.twig',
            array(
                'form' => $form->createView(),
                'project' => $project,
                'domain' => $domain
            )
        );
    }

    /**
     * Delete a project
     *
     * @param int $id Id of the project to delete.
     *
     * @return Response A Response instance
     *
     * @Secure(roles="ROLE_DM_MANAGER")
     */
    public function delAction($id)
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
        $success = true;

        if ($this->get('request')->getMethod() == 'POST') {

            $em->remove($project);

            try {
                $em->flush();

            } catch (Exception $e) {
                $success = false;

                $this->get('session')->getFlashBag()->add(
                    'error',
                    'Impossible to remove this item'
                    .' - Integrity constraint violation !'
                );
            }
            if ($success) {
                $this->get('session')->getFlashBag()
                    ->add('success', 'Project removed successfully !');

                return $this->redirect(
                    $this->generateUrl('dm-project_index')
                );
            }
        }

        return $this->render(
            'MapProjectBundle:Project:del.html.twig',
            array('project' => $project, 'domain' => $domain)
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
