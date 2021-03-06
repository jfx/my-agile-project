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

namespace Map\UserBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Map\DomainBundle\Entity\Domain;

/**
 * User entity repository class.
 *
 * @category  MyAgileProject
 * @package   User
 * @author    Francois-Xavier Soubirou <soubirou@yahoo.fr>
 * @copyright 2013 Francois-Xavier Soubirou
 * @license   http://www.gnu.org/licenses/   GPLv3
 * @link      http://www.myagileproject.org
 * @since     2
 */
class UserRepository extends EntityRepository
{
    /**
     * Get all users ordered by name, firstname.
     *
     * @return array List of users.
     */
    public function findAllOrderByNameFirstname()
    {
        $queryBuilder = $this->createQueryBuilder('u')
            ->orderBy('u.name, u.firstname');

        $results = $queryBuilder->getQuery()->getResult();

        return $results;
    }

    /**
     * Get count of all available user for a domain (new resource).
     *
     * @param Domain $domain The domain.
     *
     * @return int.
     */
    public function getCountAvailableUserByDomain(Domain $domain)
    {
        $subQuery = $this->getDQLAddedUserByDomain();

        $qb = $this->createQueryBuilder('u');
        $qb->select('count(u.id)')
            ->where($qb->expr()->notIn('u.id', $subQuery))
            ->andWhere('u.locked = false')
            ->setParameter('domainId', $domain->getId());

        $count = $qb->getQuery()->getSingleScalarResult();

        return $count;
    }

    /**
     * Get the query builder of all available user for a domain (new resource).
     *
     * @param Domain $domain The domain.
     *
     * @return QueryBuilder.
     */
    public function getQBAvailableUserByDomain(Domain $domain)
    {
        $subQuery = $this->getDQLAddedUserByDomain();

        $qb = $this->createQueryBuilder('u');
        $qb->where($qb->expr()->notIn('u.id', $subQuery))
            ->andWhere('u.locked = false')
            ->orderBy('u.name, u.firstname', 'ASC')
            ->setParameter('domainId', $domain->getId());

        return $qb;
    }

    /**
     * Get the DQL query of all added user for a domain.
     *
     * @return DQL query.
     */
    private function getDQLAddedUserByDomain()
    {
        $udrRepository = $this->_em->getRepository('MapUserBundle:UserDmRole');

        $subQuery = $udrRepository
            ->getQBUserIdByDomainParam('domainId')
            ->getDQL();

        return $subQuery;
    }
}
