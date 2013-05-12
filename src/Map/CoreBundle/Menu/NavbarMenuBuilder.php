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

namespace Map\CoreBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Mopa\Bundle\BootstrapBundle\Navbar\AbstractNavbarMenuBuilder;
use Map\UserBundle\Entity\Role;

/**
 * Menu builder class.
 *
 * @category  MyAgileProject
 * @package   Core
 * @author    Francois-Xavier Soubirou <soubirou@yahoo.fr>
 * @copyright 2012 Francois-Xavier Soubirou
 * @license   http://www.gnu.org/licenses/   GPLv3
 * @link      http://www.myagileproject.org
 * @since     2
 */
class NavbarMenuBuilder extends AbstractNavbarMenuBuilder
{
    /**
     * @var Symfony\Component\Security\Core\SecurityContextInterface
     */
    protected $securityContext;

    /**
     * {@inheritDoc}
     *
     * @param FactoryInterface         $factory         Factory.
     * @param SecurityContextInterface $securityContext Security context.
     */
    public function __construct(
        FactoryInterface $factory,
        SecurityContextInterface $securityContext
    ) {
        parent::__construct($factory);

        $this->securityContext = $securityContext;
    }

    /**
     * {@inheritDoc}
     *
     * @param Request $request Request.
     *
     * @return Knp\Menu\MenuItem
     */
    public function createMainMenu(Request $request)
    {
        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav');

        $menu->addChild('Home', array('route' => 'home_index'));

        $this->addDivider($menu, true);

        $dropdownAdmin = $this->createDropdownMenuItem(
            $menu,
            "Admin",
            false,
            array('caret' => true)
        );
        $dropdownAdmin->addChild('Profile', array('route' => 'user_profile'));

        $this->addDivider($dropdownAdmin);

        $dropdownAdmin->addChild('Users', array('route' => 'user_index'));
        $dropdownAdmin->addChild('Domains', array('route' => 'domain_index'));

        $this->addDivider($menu, true);

        return $menu;
    }

    /**
     * {@inheritDoc}
     *
     * @param Request $request Request.
     *
     * @return Knp\Menu\MenuItem
     */
    public function createRightSideDropdownMenu(Request $request)
    {
        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav pull-right');

        $user = $this->securityContext->getToken()->getUser();
        $username = ucfirst($user->getUsername());
        $roleLabel = $user->getCurrentRoleLabel();

        if (($roleLabel != null)
            && (strlen($roleLabel) > 0)
            && ($roleLabel != Role::LABEL_NONE)
        ) {
            $roleLabel2Display = '('.$roleLabel.')';
        } else {
            $roleLabel2Display = '';
        }
        if ($user->isSuperAdmin()) {
            $star = '*';
        } else {
            $star ='';
        }
        $menu->addChild(
            $username.$star.' '.$roleLabel2Display,
            array('route' => 'user_profile')
        );

        $this->addDivider($menu, true);

        $menu->addChild('Log out', array('route' => 'fos_user_security_logout'));

        return $menu;
    }
}
