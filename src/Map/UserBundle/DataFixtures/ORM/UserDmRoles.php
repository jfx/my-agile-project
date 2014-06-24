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

namespace Map\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Map\UserBundle\Entity\UserDmRole;

/**
 * Load user domain role data class.
 *
 * @category  MyAgileProject
 * @package   User
 * @author    Francois-Xavier Soubirou <soubirou@yahoo.fr>
 * @copyright 2013 Francois-Xavier Soubirou
 * @license   http://www.gnu.org/licenses/   GPLv3
 * @link      http://www.myagileproject.org
 * @since     2
 */
class UserDmRoles extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager The entity manager
     *
     * @return void
     * 
     * @codeCoverageIgnore
     */
    public function load(ObjectManager $manager)
    {
        $dataArray = array(
            array(
                'user'   => 'user-user',
                'domain' => 'domainone-domain',
                'role'   => 'user-role'
            ),
            array(
                'user'   => 'user-user',
                'domain' => 'domaintwo-domain',
                'role'   => 'user+-role'
            ),
            array(
                'user'   => 'd1-none-user',
                'domain' => 'domainone-domain',
                'role'   => 'none-role'
            ),
            array(
                'user'   => 'd1-guest-user',
                'domain' => 'domainone-domain',
                'role'   => 'guest-role'
            ),
             array(
                'user'   => 'd1-user+-user',
                'domain' => 'domainone-domain',
                'role'   => 'user+-role'
            ),
            array(
                'user'   => 'd1-manager-user',
                'domain' => 'domainone-domain',
                'role'   => 'manager-role'
            ),
        );

        foreach ($dataArray as $i => $data) {
            $objectList[$i] = new UserDmRole();
            $objectList[$i]->setUser($this->getReference($data['user']));
            $objectList[$i]->setDomain($this->getReference($data['domain']));
            $objectList[$i]->setRole($this->getReference($data['role']));

            $manager->persist($objectList[$i]);
        }
        $manager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     * 
     * @codeCoverageIgnore
     */
    public function getOrder()
    {
        return 30;
    }
}
