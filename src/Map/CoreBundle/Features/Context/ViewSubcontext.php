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

use Behat\Gherkin\Node\TableNode;
use Behat\Mink\Exception\ElementNotFoundException;
use Behat\Mink\Exception\ExpectationException;
use Map\CoreBundle\Features\Context\Subcontext;

/**
 * View subcontext class.
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
class ViewSubcontext extends Subcontext
{

    /**
     * Checks that span field with specified label has specified value.
     *
     * @param string $field Field label
     * @param string $value Value
     *
     * @return void
     *
     * @throws ElementNotFoundException
     * @throws ExpectationException
     *
     * @Then /^the "([^"]*)" view field should contain "([^"]*)"$/
     */
    public function assertViewFieldContains($field, $value)
    {
        $utilSubcontext = $this->getMainContext()->getSubcontext('util');

        $spanId = $utilSubcontext->getForAttributeFromLabel($field);
        $span = $utilSubcontext->getElementById($spanId);

        $actual = $span->getText();
        $regex  = '/^'.preg_quote($value, '/').'/ui';

        if (!preg_match($regex, $actual)) {
            $message = sprintf(
                'The field "%s" value is "%s", but "%s" expected.',
                $field,
                $actual,
                $value
            );
            $session = $this->getMainContext()->getSession();
            throw new ExpectationException($message, $session);
        }
    }

    /**
     * Checks that checkbox is checked.
     *
     * @param string $checkboxName Checkbox name
     *
     * @return void
     *
     * @throws ExpectationException
     *
     * @Then /^the view checkbox "([^"]*)" should be checked$/
     */
    public function assertViewCheckboxChecked($checkboxName)
    {
        $utilSubcontext = $this->getMainContext()->getSubcontext('util');

        $checkboxId = $utilSubcontext->getForAttributeFromLabel($checkboxName);
        $checkbox = $utilSubcontext->getElementById($checkboxId);

        if (!$checkbox->hasAttribute('checked')) {
            $message = sprintf(
                'Checkbox "%s" is not checked, but it should be.',
                $checkboxName
            );
            $session = $this->getMainContext()->getSession();
            throw new ExpectationException($message, $session);
        }
    }

    /**
     * Checks that checkbox is not checked.
     *
     * @param string $checkboxName Checkbox name
     *
     * @return void
     *
     * @throws ExpectationException
     *
     * @Then /^the view checkbox "([^"]*)" should not be checked$/
     */
    public function assertViewCheckboxNotChecked($checkboxName)
    {
        $utilSubcontext = $this->getMainContext()->getSubcontext('util');

        $checkboxId = $utilSubcontext->getForAttributeFromLabel($checkboxName);
        $checkbox = $utilSubcontext->getElementById($checkboxId);

        if ($checkbox->hasAttribute('checked')) {
            $message = sprintf(
                'Checkbox "%s" is checked, but it should not be.',
                $checkboxName
            );
            $session = $this->getMainContext()->getSession();
            throw new ExpectationException($message, $session);
        }
    }

    /**
     * Checks view fields with provided table.
     *
     * @param TableNode $fields Table with labels and expected values
     *
     * @return void
     *
     * @Then /^I should see the following view form:$/
     */
    public function assertViewFieldsContains(TableNode $fields)
    {
        foreach ($fields->getRowsHash() as $field => $value) {
            $this->assertViewFieldContains($field, $value);
        }
    }
}
