<?php
/**
 * Load role data class.
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
 * @package   User
 * @author    Francois-Xavier Soubirou <soubirou@yahoo.fr>
 * @copyright 2013 Francois-Xavier Soubirou
 * @license   http://www.gnu.org/licenses/   GPLv3
 * @link      http://www.myagileproject.org
 * @since     2
 *
 */

namespace Map\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Map\UserBundle\Entity\Role;

class Roles extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $dataArray = array(
            array('id' => 'ROLE_DM_NONE', 'label' => 'None', 'order' => 1),
            array('id' => 'ROLE_DM_GUEST', 'label' => 'Guest', 'order' => 2),
            array('id' => 'ROLE_DM_USER', 'label' => 'User', 'order' => 3),
            array('id' => 'ROLE_DM_USERPLUS', 'label' => 'User+', 'order' => 4),
            array('id' => 'ROLE_DM_MANAGER', 'label' => 'Manager', 'order' => 5)
        );
        
        foreach ($dataArray as $i => $data) {
            $objectList[$i] = new Role();
            $objectList[$i]->setId($data['id']);
            $objectList[$i]->setLabel($data['label']);
            $objectList[$i]->setOrder($data['order']);
            
            $manager->persist($objectList[$i]);
            
            // In lowercase and no whitespace
            $ref = strtolower(str_replace(' ', '', $data['label'])).'-role';
            $this->addReference($ref, $objectList[$i]);
        }
        $manager->flush();
    }
    
    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 10;
    }
}