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

namespace Map\ProjectBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Map\DomainBundle\Entity\Domain;

/**
 * Project entity repository class.
 *
 * @category  MyAgileProject
 * @package   Project
 * @author    Francois-Xavier Soubirou <soubirou@yahoo.fr>
 * @copyright 2013 Francois-Xavier Soubirou
 * @license   http://www.gnu.org/licenses/   GPLv3
 * @link      http://www.myagileproject.org
 * @since     2
 */
class ProjectRepository extends EntityRepository
{
    /**
     * Get all projects for a domain.
     *
     * @param Domain $domain The domain.
     *
     * @return array List of projects.
     */
    public function findProjectsByDomain(Domain $domain)
    {
        $qb = $this->createQueryBuilder('p')
            ->innerJoin('p.domain', 'd')
            ->where('d.id = :domainId')
            ->setParameter('domainId', $domain->getId())
            ->orderBy('p.startDate', 'ASC');

        $results = $qb->getQuery()->getResult();

        return $results;
    }
}
