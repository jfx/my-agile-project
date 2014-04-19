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
use Map\UserBundle\Entity\User;

/**
 * User Domain Role entity repository class.
 *
 * @category  MyAgileProject
 * @package   User
 * @author    Francois-Xavier Soubirou <soubirou@yahoo.fr>
 * @copyright 2013 Francois-Xavier Soubirou
 * @license   http://www.gnu.org/licenses/   GPLv3
 * @link      http://www.myagileproject.org
 * @since     2
 */
class UserDmRoleRepository extends EntityRepository
{
    /**
     * Get all resources with role for a domain.
     *
     * @param Domain $domain The domain.
     *
     * @return array List of users and role.
     */
    public function findUsersByDomain(Domain $domain)
    {
        $qb = $this->createQueryBuilder('udr')
            ->innerJoin('udr.user', 'u')
            ->select('u.id, u.name, u.firstname, u.displayname')
            ->innerJoin('udr.role', 'r')
            ->addSelect('r.label')
            ->innerJoin('udr.domain', 'd')
            ->addSelect('d.name as domain_name')
            ->where('d.id = :domainId')
            ->setParameter('domainId', $domain->getId())
            ->orderBy('u.name, u.firstname', 'ASC');

        $results = $qb->getQuery()->getResult();

        return $results;
    }

    /**
     * Count all resources with role for a domain.
     *
     * @param Domain $domain The domain.
     *
     * @return int
     */
    public function countUsersByDomain(Domain $domain)
    {
        $qb = $this->createQueryBuilder('udr')
            ->innerJoin('udr.user', 'u')
            ->select('count(u.id)')
            ->innerJoin('udr.domain', 'd')
            ->where('d.id = :domainId')
            ->setParameter('domainId', $domain->getId());

        $count = $qb->getQuery()->getSingleScalarResult();

        return $count;
    }

    /**
     * Get all domains for a user as a resource.
     *
     * @param User $user The user.
     *
     * @return array List of domains.
     */
    public function findAvailableDomainsByUser(User $user)
    {
        $qb = $this->createQueryBuilder('udr')
            ->innerJoin('udr.domain', 'd')
            ->select('d.id, d.name')
            ->innerJoin('udr.user', 'u')
            ->where('u.id = :userId')
            ->setParameter('userId', $user->getId())
            ->innerJoin('udr.role', 'r')
            ->addSelect('r.label')
            ->andWhere('r.id != \'ROLE_DM_NONE\'')
            ->orderBy('d.name', 'ASC');

        $results = $qb->getQuery()->getResult();

        return $results;
    }

    /**
     * Get a role for a user and domain.
     *
     * @param int $userId   The user id.
     * @param int $domainId The domain id.
     *
     * @return array role.
     */
    public function findByUserIdDomainId($userId, $domainId)
    {
        $qb = $this->createQueryBuilder('udr')
            ->join('udr.user', 'u')
            ->join('udr.domain', 'd')
            ->where('u.id = :userId')
            ->andWhere('d.id = :domainId')
            ->setParameter('userId', $userId)
            ->setParameter('domainId', $domainId);

        $result = $qb->getQuery()->getSingleResult();

        return $result;
    }

    /**
     * Get the query builder of all user if for a domain id.
     *
     * @param int $param The domain id.
     *
     * @return QueryBuilder.
     */
    public function getQBUserIdByDomainParam($param)
    {
        $qb = $this->_em->createQueryBuilder();

        $qb ->select('userqb.id')
            ->from($this->_entityName, 'udr')
            ->join('udr.user', 'userqb')
            ->join('udr.domain', 'domainqb')
            ->where('domainqb.id = :'.$param);

        return $qb;
    }
}
