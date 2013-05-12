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

use Doctrine\ORM\Mapping as ORM;

/**
 * Role entity class.
 *
 * @category  MyAgileProject
 * @package   User
 * @author    Francois-Xavier Soubirou <soubirou@yahoo.fr>
 * @copyright 2013 Francois-Xavier Soubirou
 * @license   http://www.gnu.org/licenses/   GPLv3
 * @link      http://www.myagileproject.org
 * @since     2
 *
 * @ORM\Table(name="map_role")
 * @ORM\Entity(repositoryClass="Map\UserBundle\Entity\RoleRepository")
 */
class Role
{
    const DEFAULT_ROLE = 'ROLE_DM_USER';
    const MANAGER_ROLE = 'ROLE_DM_MANAGER';
    const LABEL_NONE   = 'None';

    /**
     * @var string
     *
     * @ORM\Column(name="id", type="string", length=20)
     * @ORM\Id
     */
    private $id;

    /**
     * @var string $label
     *
     * @ORM\Column(name="label", type="string", length=20)
     */
    private $label;

    /**
     * @var integer $order
     *
     * @ORM\Column(name="r_order", type="integer", unique=true)
     */
    private $order;

    /**
     * Set id.
     *
     * @param string $id Id.
     *
     * @return Role
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get id
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set label
     *
     * @param string $label The label.
     *
     * @return Role
     */
    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * Get label
     *
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Set order
     *
     * @param integer $order The order.
     *
     * @return Domain
     */
    public function setOrder($order)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * Get order
     *
     * @return integer
     */
    public function geOrder()
    {
        return $this->order;
    }
}
