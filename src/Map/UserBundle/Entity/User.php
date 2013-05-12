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

use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Map\DomainBundle\Entity\Domain;

/**
 * User entity class.
 *
 * @category  MyAgileProject
 * @package   User
 * @author    Francois-Xavier Soubirou <soubirou@yahoo.fr>
 * @copyright 2013 Francois-Xavier Soubirou
 * @license   http://www.gnu.org/licenses/   GPLv3
 * @link      http://www.myagileproject.org
 * @since     2
 *
 * @ORM\Entity
 * @ORM\Table(name="map_user")
 * @ORM\Entity(repositoryClass="Map\UserBundle\Entity\UserRepository")
 */
class User extends BaseUser
{
    /**
     * @var integer
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=50)
     */
    protected $name;

    /**
     * @var string
     *
     * @ORM\Column(name="firstname", type="string", length=50)
     */
    protected $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="displayname", type="string", length=50, unique=true)
     */
    protected $displayname;

    /**
     * @var string
     *
     * @ORM\Column(name="details", type="text", nullable=true)
     */
    private $details;

    /**
     * @ORM\ManyToOne(targetEntity="Map\DomainBundle\Entity\Domain")
     */
    private $currentDomain;

    /**
     * @var string
     *
     * @ORM\Column(name="current_role_label", type="text", length=25, nullable=true)
     */
    private $currentRoleLabel;

    /**
     * @var array
     *
     * @ORM\Column(name="available_domains", type="array")
     */
    private $availableDomains;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->availableDomains = array();
    }

    /**
     * Set name
     *
     * @param string $name The name
     *
     * @return User
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set firstname
     *
     * @param string $firstname The firstname
     *
     * @return User
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set displayname
     *
     * @param string $displayname The displayname
     *
     * @return User
     */
    public function setDisplayname($displayname)
    {
        $this->displayname = $displayname;

        return $this;
    }

    /**
     * Get displayname
     *
     * @return string
     */
    public function getDisplayname()
    {
        return $this->displayname;
    }

    /**
     * Set details
     *
     * @param string $details The details
     *
     * @return User
     */
    public function setDetails($details)
    {
        $this->details = $details;

        return $this;
    }

    /**
     * Get details
     *
     * @return string
     */
    public function getDetails()
    {
        return $this->details;
    }

    /**
     * Set current domain
     *
     * @param Domain $dm The current domain
     *
     * @return User
     */
    public function setCurrentDomain(Domain $dm)
    {
        $this->currentDomain = $dm;

        return $this;
    }

    /**
     * Get current domain
     *
     * @return Domain
     */
    public function getCurrentDomain()
    {
        return $this->currentDomain;
    }

    /**
     * unset current domain
     *
     * @return User
     */
    public function unsetCurrentDomain()
    {
        $this->currentDomain = null;

        return $this;
    }

    /**
     * Set current role label
     *
     * @param string $crl Label of the role.
     *
     * @return User
     */
    public function setCurrentRoleLabel($crl)
    {
        $this->currentRoleLabel = $crl;

        return $this;
    }

    /**
     * Get current role label
     *
     * @return string
     */
    public function getCurrentRoleLabel()
    {
        return $this->currentRoleLabel;
    }

    /**
     * Set available domains
     *
     * @param array $domains List of domains
     *
     * @return User
     */
    public function setAvailableDomains($domains)
    {
        $this->availableDomains = $domains;

        return $this;
    }

    /**
     * Get available domains
     *
     * @return array
     */
    public function getAvailableDomains()
    {
        return $this->availableDomains;
    }

    /**
     * unset domain role
     *
     * @return User
     */
    public function unsetDomainRole()
    {
        $this->currentRoleLabel = null;

        foreach ($this->getRoles() as $key => $role) {

            if (substr($role, 0, 7) == 'ROLE_DM') {
                $this->removeRole($role);
            }
        }

        return $this;
    }

    /**
     * Set password
     *
     * @param string $password The new password
     *
     * @return User
     */
    public function setUpdatedPassword($password)
    {
        if (!empty($password)) {
            $this->setPlainPassword($password);
        }

        return $this;
    }

    /**
     * Get an empty password
     *
     * @return string
     */
    public function getUpdatedPassword()
    {
        return '';
    }

    /**
     * Get Name and firstname
     *
     * @return string
     */
    public function getNameFirstname()
    {
        return $this->getName().' '.$this->getFirstname();
    }
}
