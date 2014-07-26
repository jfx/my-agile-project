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

namespace Map\CoreBundle\Extensions;

use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Twig_Extension;
use Twig_Function_Method;

/**
 * Display breadcrumb for a project or domain.
 *
 * @category  MyAgileProject
 * @package   Project
 * @author    Francois-Xavier Soubirou <soubirou@yahoo.fr>
 * @copyright 2014 Francois-Xavier Soubirou
 * @license   http://www.gnu.org/licenses/   GPLv3
 * @link      http://www.myagileproject.org
 * @since     2
 */
class BreadcrumbExtension extends Twig_Extension
{
    /**
     * @var SecurityContextInterface S. Context
     */
    protected $securityContext;

    /**
     * @var Router Router service
     */
    protected $router;

    /**
     * Constructor
     *
     * @param SecurityContextInterface $securityContext The security context.
     * @param Router                   $router          The router service.
     */
    public function __construct(
        SecurityContextInterface $securityContext,
        Router $router
    ) {
        $this->securityContext = $securityContext;
        $this->router      = $router;
    }

        /**
     * Display domain breadcrumb.
     *
     * @param array $levels Label of levels.
     *
     * @return string
     */
    public function breadcrumb(array $levels)
    {
        $breadcrumb  = '<ol class="breadcrumb">';

        $lvl_count = 0;

        foreach ($levels as $level) {

            $id = 'br_lvl'.++$lvl_count;

            if (is_array($level)) {
                $breadcrumb .= '  <li><a id="'.$id.'" href="';
                $breadcrumb .= $level[1].'">'.$level[0].'</a></li>';
            } else {
                $breadcrumb .= '  <li id="'.$id.'" class="active">';
                $breadcrumb .= $level.'</li>';
            }

        }
        $breadcrumb .= '</ol>';

        return $breadcrumb;
    }

    /**
     * Display domain breadcrumb.
     *
     * @param string $action Label of action displayed.
     *
     * @return string
     */
    public function domainBreadcrumb($action)
    {
        $user = $this->securityContext->getToken()->getUser();

        $domain = $user->getCurrentDomain();
        $domainUrl = $this->router->generate(
            'domain_view',
            array('id' => $domain->getId())
        );
        $domainName = htmlspecialchars($domain->getName());

        $breadcrumb = $this->breadcrumb(
            array(
                array($domainName, $domainUrl),
                $action
            )
        );

        return $breadcrumb;
    }

    /**
     * Display project breadcrumb.
     *
     * @param string $action Label of action displayed.
     *
     * @return string
     */
    public function projectBreadcrumb($action)
    {
        $user = $this->securityContext->getToken()->getUser();

        $domain = $user->getCurrentDomain();
        $domainUrl = $this->router->generate('dm-project_index');
        $domainName = htmlspecialchars($domain->getName());

        $project = $user->getCurrentProject();
        $projectUrl = $this->router->generate(
            'project_view',
            array('id' => $project->getId())
        );
        $projectName = htmlspecialchars($project->getName());

        $breadcrumb = $this->breadcrumb(
            array(
                array($domainName, $domainUrl),
                array($projectName, $projectUrl),
                $action
            )
        );

        return $breadcrumb;
    }

    /**
     * Returns a list of functions to add to the existing list.
     *
     * @return array An array of functions
     */
    public function getFunctions()
    {
        return array(
            'breadcrumb' => new Twig_Function_Method(
                $this,
                'breadcrumb',
                array('is_safe' => array('html'))
            ),
            'domain_breadcrumb' => new Twig_Function_Method(
                $this,
                'domainBreadcrumb',
                array('is_safe' => array('html'))
            ),
            'project_breadcrumb' => new Twig_Function_Method(
                $this,
                'projectBreadcrumb',
                array('is_safe' => array('html'))
            )
        );
    }

    /**
     * Returns the name of this extension.
     *
     * @return string
     */
    public function getName()
    {
        return "map_corebundle_breadcrumb";
    }
}
