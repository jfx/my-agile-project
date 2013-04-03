<?php
/**
 * UserDmRole entity class.
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

namespace Map\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Map\UserBundle\Entity\User;
use Map\DomainBundle\Entity\Domain;
use Map\UserBundle\Entity\Role;

/**
 * @ORM\Table(name="map_user_dm_role")
 * @ORM\Entity(repositoryClass="Map\UserBundle\Entity\UserDmRoleRepository")
 */
class UserDmRole
{
    
    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Map\UserBundle\Entity\User")
     */
    protected $user;

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Map\DomainBundle\Entity\Domain")
     */
    protected $domain;

    /**
     * @var string $role
     *
     * @ORM\ManyToOne(targetEntity="Map\UserBundle\Entity\Role")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $role;
    
    /**
     * Set User
     *
     * @param User $user
     * 
     * @return UserDmRole
     */
    public function setUser(User $user)
    {
        $this->user = $user;
    
        return $this;
    }

    /**
     * Get User
     *
     * @return User 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set Domain
     *
     * @param Domain $dm
     * 
     * @return UserDmRole
     */
    public function setDomain(Domain $dm)
    {
        $this->domain = $dm;
    
        return $this;
    }

    /**
     * Get Domain
     *
     * @return Domain
     */
    public function getDomain()
    {
        return $this->domain;
    }

    /**
     * Set role
     *
     * @param Role $role
     * 
     * @return User
     */
    public function setRole(Role $role)
    {
        $this->role = $role;
    
        return $this;
    }

    /**
     * Get role
     *
     * @return Role 
     */
    public function getRole()
    {
        return $this->role;
    }    
}