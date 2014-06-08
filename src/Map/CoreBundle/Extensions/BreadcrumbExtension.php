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
     * @return string
     */
    public function domainBreadcrumb()
    {
        $user = $this->securityContext->getToken()->getUser();

        $domain = $user->getCurrentDomain();
        $domainUrl = $this->router->generate(
            'domain_view',
            array('id' => $domain->getId())
        );
        $domainName = htmlspecialchars($domain->getName());
        $domainLink  = '<a  id="b_domain" href="';
        $domainLink .= $domainUrl.'">'.$domainName.'</a>';

        return $domainLink;
    }

    /**
     * Display project breadcrumb.
     *
     * @return string
     */
    public function projectBreadcrumb()
    {
        $user = $this->securityContext->getToken()->getUser();

        $domain = $user->getCurrentDomain();
        $domainUrl = $this->router->generate('dm-project_index');
        $domainName = htmlspecialchars($domain->getName());
        $domainLink  = '<a id="b_domain" href="';
        $domainLink .= $domainUrl.'">'.$domainName.'</a>';

        $project = $user->getCurrentProject();
        $projectUrl = $this->router->generate(
            'project_view',
            array('id' => $project->getId())
        );
        $projectName = htmlspecialchars($project->getName());
        $projectLink  = '<a id="b_project" href="';
        $projectLink .= $projectUrl.'">'.$projectName.'</a>';

        return $domainLink.' > '.$projectLink;
    }

    /**
     * Returns a list of functions to add to the existing list.
     *
     * @return array An array of functions
     */
    public function getFunctions()
    {
        return array(
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
