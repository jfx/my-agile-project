<?php
/**
 * Load domain data class.
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
 * @package   Domain
 * @author    Francois-Xavier Soubirou <soubirou@yahoo.fr>
 * @copyright 2013 Francois-Xavier Soubirou
 * @license   http://www.gnu.org/licenses/   GPLv3
 * @link      http://www.myagileproject.org
 * @since     2
 *
 */

namespace Map\DomainBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Map\DomainBundle\Entity\Domain;

class Domains extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $dataArray = array(
            array('name' => 'Domain One', 'details' => 'Details 4 domain 1'),
            array('name' => 'Domain Two', 'details' => 'Details 4 domain 2'),
            array('name' => 'Domain Three', 'details' => 'Details 4 domain 3'),
            array('name' => 'Domain Four', 'details' => 'Details 4 domain 4'),
            array('name' => 'Domain Five', 'details' => 'Details 4 domain 5')
        );
        
        foreach ($dataArray as $i => $data) {
            $objectList[$i] = new Domain();
            $objectList[$i]->setName($data['name']);
            $objectList[$i]->setDetails($data['details']);
            
            $manager->persist($objectList[$i]);

            // In lowercase and no whitespace
            $ref = strtolower(str_replace(' ', '', $data['name'])).'-domain';
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