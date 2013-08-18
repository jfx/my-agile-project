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

namespace Map\ProjectBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Map\ProjectBundle\Entity\Project;

/**
 * Load user domain role data class.
 *
 * @category  MyAgileProject
 * @package   Project
 * @author    Francois-Xavier Soubirou <soubirou@yahoo.fr>
 * @copyright 2013 Francois-Xavier Soubirou
 * @license   http://www.gnu.org/licenses/   GPLv3
 * @link      http://www.myagileproject.org
 * @since     2
 */
class Projects extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager The entity manager
     *
     * @return void
     */
    public function load(ObjectManager $manager)
    {
        $dataArray = array(
            array(
                'name'       => 'Project One',
                'details'    => 'details 4 project one',
                'startDate'  => new \DateTime("- 2 months"),
                'finishDate' => new \DateTime("+ 1 months"),
                'closed'     => false,
                'domain'     => 'domainone-domain',
            ),
            array(
                'name'       => 'Project Two',
                'details'    => 'details 4 project two',
                'startDate'  => new \DateTime("- 1 months"),
                'finishDate' => new \DateTime("+ 2 months"),
                'closed'     => false,
                'domain'     => 'domainone-domain',
            ),
            array(
                'name'       => 'Project Closed',
                'details'    => 'details 4 project closed',
                'startDate'  => new \DateTime("2013-05-02 12:00:00"),
                'finishDate' => new \DateTime("2013-07-31 12:00:00"),
                'closed'     => true,
                'domain'     => 'domainone-domain',
            ),
            array(
                'name'       => 'Project Three',
                'details'    => 'details 4 project three',
                'startDate'  => new \DateTime("- 3 months"),
                'finishDate' => new \DateTime("+ 3 months"),
                'closed'     => false,
                'domain'     => 'domaintwo-domain',
            ),
        );

        foreach ($dataArray as $i => $data) {
            $objectList[$i] = new Project();
            $objectList[$i]->setName($data['name']);
            $objectList[$i]->setDetails($data['details']);
            $objectList[$i]->setStartDate($data['startDate']);
            $objectList[$i]->setFinishDate($data['finishDate']);
            $objectList[$i]->setClosed($data['closed']);
            $objectList[$i]->setDomain($this->getReference($data['domain']));

            $manager->persist($objectList[$i]);
            
            // In lowercase and no whitespace
            $ref = strtolower(str_replace(' ', '', $data['name'])).'-project';
            $this->addReference($ref, $objectList[$i]);
        }
        $manager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 20;
    }
}
