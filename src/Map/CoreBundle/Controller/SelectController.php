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

namespace Map\CoreBundle\Controller;

use JMS\SecurityExtraBundle\Annotation\Secure;
use Map\CoreBundle\Form\MenuSelectType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * Core controller class.
 *
 * @category  MyAgileProject
 * @package   Core
 * @author    Francois-Xavier Soubirou <soubirou@yahoo.fr>
 * @copyright 2014 Francois-Xavier Soubirou
 * @license   http://www.gnu.org/licenses/   GPLv3
 * @link      http://www.myagileproject.org
 * @since     2
 *
 */
class SelectController extends Controller
{
    /**
     * Display html select object in menu.
     *
     * @return Response A Response instance
     *
     * @Secure(roles="ROLE_USER")
     */
    public function displayAction()
    {
        $securityContext = $this->get('security.context');
        $user = $securityContext->getToken()->getUser();

        $form = $this->createForm(new MenuSelectType($user));

        return $this->render(
            'MapCoreBundle:Select:display.html.twig',
            array('form' => $form->createView())
        );
    }

    /**
     * Select a project in combobox
     *
     * @return Response A Response instance
     *
     * @Secure(roles="ROLE_USER")
     */
    public function requestAction()
    {
        $request = $this->getRequest();
        $projectId = $request->request->get('map_menu_select')['search'];

        return $this->redirect(
            $this->generateUrl('project_view', array('id' => $projectId))
        );
    }
}
