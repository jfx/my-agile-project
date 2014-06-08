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

namespace Map\CoreBundle\Form;

use Map\CoreBundle\Form\DefaultType;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Default form with date class.
 *
 * @category  MyAgileProject
 * @package   Core
 * @author    Francois-Xavier Soubirou <soubirou@yahoo.fr>
 * @copyright 2013 Francois-Xavier Soubirou
 * @license   http://www.gnu.org/licenses/   GPLv3
 * @link      http://www.myagileproject.org
 * @since     2
 *
 */
abstract class DefaultDateType extends DefaultType
{
    /**
     * @var ContainerInterface Container
     */
    protected $container;

    /**
     * Constructor
     *
     * @param ContainerInterface $containerInterface The container.
     */
    public function __construct(ContainerInterface $containerInterface)
    {
        $this->container = $containerInterface;
    }

    /**
     * Returns the date in ICU format.
     *
     * @return string The format
     */
    public function getIcuFormat()
    {
        $format = $this->container->getParameter('app.formatDate');

        $formatICU = str_replace(
            ['d', 'm', 'Y'],
            ['dd', 'MM', 'yyyy'],
            $format
        );

        return $formatICU;
    }

    /**
     * Returns the date format for datepicker.
     *
     * @return string The format
     */
    public function getDatepickerFormat()
    {
        $format = $this->container->getParameter('app.formatDate');

        $formatDatepicker = str_replace(
            ['d', 'm', 'Y'],
            ['dd', 'mm', 'yyyy'],
            $format
        );

        return $formatDatepicker;
    }
}
