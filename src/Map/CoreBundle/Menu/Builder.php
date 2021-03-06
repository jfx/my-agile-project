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
use Map\UserBundle\Entity\Role;
use Symfony\Component\DependencyInjection\ContainerAware;

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
class Builder extends ContainerAware
{
    /**
     * Create main menu
     *
     * @param FactoryInterface $factory Factory interface.
     * @param array            $options Options.
     *
     * @return Knp\Menu\ItemInterface
     */
    public function mainMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root', array('navbar' => true));

        $menu->addChild('Home', array('route' => 'home_index'));

        $dropdownAdmin = $menu->addChild(
            'Admin',
            array(
                'dropdown' => true,
                'caret' => true,
            )
        );

        $dropdownAdmin->addChild('Profile', array('route' => 'user_profile'));

        $dropdownAdmin->addChild('divider_1', array('divider' => true));

        $dropdownAdmin->addChild('Users', array('route' => 'user_index'));
        $dropdownAdmin->addChild('Domains', array('route' => 'domain_index'));

        return $menu;
    }

    /**
     * Create right menu
     *
     * @param FactoryInterface $factory Factory interface.
     * @param array            $options Options.
     *
     * @return Knp\Menu\ItemInterface
     */
    public function rightMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem(
            'root',
            array(
                'navbar' => true,
                'pull-right' => true,
            )
        );

        $securityContext = $this->container->get('security.context');
        $user = $securityContext->getToken()->getUser();
        $username = ucfirst($user->getUsername());
        $roleLabel = $user->getCurrentRoleLabel();

        if (($roleLabel !== null)
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
        $menu->addChild(
            'Log out',
            array('route' => 'fos_user_security_logout')
        );

        return $menu;
    }
}
