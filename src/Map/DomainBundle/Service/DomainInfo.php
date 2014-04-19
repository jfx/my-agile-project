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

namespace Map\DomainBundle\Service;

use Doctrine\ORM\EntityManager;

/**
 * Domain info service class.
 *
 * @category  MyAgileProject
 * @package   Domain
 * @author    Francois-Xavier Soubirou <soubirou@yahoo.fr>
 * @copyright 2014 Francois-Xavier Soubirou
 * @license   http://www.gnu.org/licenses/   GPLv3
 * @link      http://www.myagileproject.org
 * @since     2
 */
class DomainInfo
{
    /**
     * @var Doctrine\ORM\EntityManager Entity manager
     */
    protected $entityManager;

    /**
     * Constructor
     *
     * @param EntityManager $entityManager The entity manager.
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager   = $entityManager;
    }

    /**
     * Set the current domain for a user and set role.
     *
     * @param Domain $domain The domain.
     *
     * @return array
     */
    public function getChildCount($domain)
    {
        $results = array();

        $repositoryPr = $this->entityManager->getRepository(
            'MapProjectBundle:Project'
        );

        $repositoryUDR = $this->entityManager->getRepository(
            'MapUserBundle:UserDmRole'
        );

        $results['projects']  = $repositoryPr->countProjectsByDomain($domain);
        $results['resources'] = $repositoryUDR->countUsersByDomain($domain);

        return $results;
    }
}
