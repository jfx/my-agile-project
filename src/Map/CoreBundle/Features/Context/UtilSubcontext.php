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

namespace Map\CoreBundle\Features\Context;

use Behat\Mink\Element\NodeElement;
use Behat\Mink\Exception\ElementNotFoundException;
use Map\CoreBundle\Features\Context\Subcontext;

/**
 * Util subcontext class.
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
class UtilSubcontext extends Subcontext
{

    /**
     * Checks that span field with specified label has specified value.
     *
     * @param integer $seconds Seconds
     *
     * @return void
     *
     * @When /^I wait for (\d+) seconds$/
     */
    public function iWaitForSeconds($seconds)
    {
        $session = $this->getMainContext()->getSession();
        $session->wait($seconds*1000);
    }

    /**
     * Get for attribute from label find by text name.
     *
     * @param string $labelName Label name
     *
     * @return string Field/Span id
     *
     * @throws ElementNotFoundException
     */
    public function getForAttributeFromLabel($labelName)
    {
        $session = $this->getMainContext()->getSession();
        $page = $session->getPage();

        $label = $page->find('xpath', '//label[text()="'.$labelName.'"]');

        if (null === $label) {
            throw new ElementNotFoundException(
                $session,
                'label',
                'text',
                $labelName
            );
        }

        return $label->getAttribute('for');
    }

    /**
     * Get a HTML element by its id.
     *
     * @param string $id Id of element
     *
     * @return NodeElement Span|Checkbox id
     *
     * @throws ElementNotFoundException
     */
    public function getElementById($id)
    {
        $session = $this->getMainContext()->getSession();
        $page = $session->getPage();

        $element = $page->findById($id);
        if (null === $element) {
            throw new ElementNotFoundException(
                $session,
                'span|checkbox',
                'id',
                $id
            );
        }

        return $element;
    }
}
