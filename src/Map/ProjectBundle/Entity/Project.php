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

use Doctrine\ORM\Mapping as ORM;
use Map\DomainBundle\Entity\Domain;

/**
 * Project entity class.
 *
 * @category  MyAgileProject
 * @package   Project
 * @author    Francois-Xavier Soubirou <soubirou@yahoo.fr>
 * @copyright 2013 Francois-Xavier Soubirou
 * @license   http://www.gnu.org/licenses/   GPLv3
 * @link      http://www.myagileproject.org
 * @since     2
 *
 * @ORM\Table(name="map_project")
 * @ORM\Entity(repositoryClass="Map\ProjectBundle\Entity\ProjectRepository")
 */
class Project
{
    /**
     * @var integer Id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string Name
     *
     * @ORM\Column(name="name", type="string", length=50)
     */
    protected $name;

    /**
     * @var string Details
     *
     * @ORM\Column(name="details", type="text")
     */
    protected $details;

    /**
     * @var \DateTime Start date
     *
     * @ORM\Column(name="startdate", type="date")
     */
    protected $startDate;

    /**
     * @var \DateTime Finish date
     *
     * @ORM\Column(name="finishdate", type="date")
     */
    protected $finishDate;

    /**
     * @var boolean Project closed or not.
     *
     * @ORM\Column(name="closed", type="boolean")
     */
    protected $closed;

    /**
     * @var Map\DomainBundle\Entity\Domain Domain
     *
     * @ORM\ManyToOne(targetEntity="Map\DomainBundle\Entity\Domain")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $domain;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name Name of project.
     *
     * @return Project
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
     * Set details
     *
     * @param string $details Details
     *
     * @return Project
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
     * Set start date of project.
     *
     * @param \DateTime $startDate Start date of project.
     *
     * @return Project
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;

        return $this;
    }

    /**
     * Get start date of project.
     *
     * @return \DateTime
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * Set finish date of project.
     *
     * @param \DateTime $finishDate Finish date
     *
     * @return Project
     */
    public function setFinishDate($finishDate)
    {
        $this->finishDate = $finishDate;

        return $this;
    }

    /**
     * Get finish date of project.
     *
     * @return \DateTime
     */
    public function getFinishDate()
    {
        return $this->finishDate;
    }

    /**
     * Is project closed or not.
     *
     * @return integer
     */
    public function isClosed()
    {
        return $this->closed;
    }

    /**
     * Set closed status
     *
     * @param boolean $closed Closed status.
     *
     * @return Project
     */
    public function setClosed($closed)
    {
        $this->closed = $closed;

        return $this;
    }

    /**
     * Set Domain
     *
     * @param Domain $dm The domain
     *
     * @return Project
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
}
