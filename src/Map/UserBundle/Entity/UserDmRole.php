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

/**
 * @ORM\Entity
 * @ORM\Table(name="map_user_dm_role")
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
     * @ORM\ManyToOne(targetEntity="Map\AdminBundle\Entity\Domain")
     */
    protected $domain;

    /**
     * @var string $role
     *
     * @ORM\Column(name="role", type="string", length=20)
     */
    protected $role;
    
    /**
     * Set User
     *
     * @param User $user
     * 
     * @return UserDmRole
     */
    public function setUser(Map\UserBundle\Entity\User $user)
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
    public function setDomain(Map\AdminBundle\Entity\Domain $dm)
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
     * @param string $role
     * 
     * @return User
     */
    public function setRole($role)
    {
        $this->role = $role;
    
        return $this;
    }

    /**
     * Get role
     *
     * @return string 
     */
    public function getRole()
    {
        return $this->role;
    }
}