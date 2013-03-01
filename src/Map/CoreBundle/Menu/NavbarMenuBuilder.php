<?php
/**
 * Menu builder class.
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
 * @package   Core
 * @author    Francois-Xavier Soubirou <soubirou@yahoo.fr>
 * @copyright 2012 Francois-Xavier Soubirou
 * @license   http://www.gnu.org/licenses/   GPLv3
 * @link      http://www.myagileproject.org
 * @since     2
 *
 */

namespace Map\CoreBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Mopa\Bundle\BootstrapBundle\Navbar\AbstractNavbarMenuBuilder;

class NavbarMenuBuilder extends AbstractNavbarMenuBuilder
{
    protected $securityContext;
    
    public function __construct(FactoryInterface $factory, SecurityContextInterface $securityContext)
    {
        parent::__construct($factory);
    
        $this->securityContext = $securityContext;
    }
    
    public function createMainMenu(Request $request)
    {
        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav');
    
        $menu->addChild('Home', array('route' => 'home_index'));
        
        $this->addDivider($menu, true);
                
        $dropdownAdmin = $this->createDropdownMenuItem(
            $menu, "Admin", false, array('icon' => 'caret')
        );
        $dropdownAdmin->addChild('Profile', array('route' => 'user_profile'));

        $this->addDivider($dropdownAdmin);
        
        $dropdownAdmin->addChild('Users', array('route' => 'user_index'));
        $dropdownAdmin->addChild('Applications', array('route' => 'adminApplication_index'));
        
        $this->addDivider($menu, true);
    
        return $menu;
    }
    
    public function createRightSideDropdownMenu(Request $request)
    {
        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav pull-right');
        
        $user = $this->securityContext->getToken()->getUser();
        $username = ucfirst($user->getUsername());
        
        $menu->addChild($username.' (user++)', array('route' => 'user_profile'));
        
        $this->addDivider($menu, true);
    
        $menu->addChild('Log out', array('route' => 'fos_user_security_logout'));
    
        return $menu;
    }
}
