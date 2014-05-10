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

use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Project controller class.
 *
 * @category  MyAgileProject
 * @package   Domain
 * @author    Francois-Xavier Soubirou <soubirou@yahoo.fr>
 * @copyright 2013 Francois-Xavier Soubirou
 * @license   http://www.gnu.org/licenses/   GPLv3
 * @link      http://www.myagileproject.org
 * @since     2
 */
class ProjectController extends Controller
{
    /**
     * List of projects
     *
     * @return Response A Response instance
     *
     * @Secure(roles="ROLE_USER")
     */
    public function indexAction()
    {
        $user = $this->container->get('security.context')->getToken()
            ->getUser();
        $domain = $user->getCurrentDomain();

        if (is_null($domain)) {
            return $this->redirect($this->generateUrl('domain_index'));
        }

        $repository = $this->getDoctrine()
            ->getManager()
            ->getRepository('MapProjectBundle:Project');

        $projects = $repository->findProjectsByDomain($domain);

        $service = $this->container->get('map_user.domaininfo');
        $child   = $service->getChildCount($domain);

        return $this->render(
            'MapDomainBundle:Project:index.html.twig',
            array(
                'projects' => $projects,
                'domain' => $domain,
                'child' => $child
            )
        );
    }
}
