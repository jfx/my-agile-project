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

namespace Map\UserBundle\Features\Context;

use Behat\Behat\Context\BehatContext;
use Behat\Gherkin\Node\TableNode;
use Behat\Mink\Exception\ElementNotFoundException;
use Behat\Mink\Exception\ExpectationException;
use Behat\Symfony2Extension\Context\KernelAwareInterface;
use Symfony\Component\HttpKernel\KernelInterface;

require_once 'PHPUnit/Autoload.php';
require_once 'PHPUnit/Framework/Assert/Functions.php';

/**
 * HTML GUI subcontext class.
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
class GuiSubcontext extends BehatContext implements KernelAwareInterface
{
    const ACTION_ADD    = 'icon-plus-sign';
    const ACTION_EDIT   = 'icon-edit';
    const ACTION_VIEW   = 'icon-eye-open';
    const ACTION_DELETE = 'icon-trash';

    /**
     * @var KernelInterface Kernel
     */
    private $kernel;

    /**
     * @var array parameters
     */
    private $parameters;

    /**
     * Initializes context with parameters from behat.yml.
     *
     * @param array $parameters Parameters
     */
    public function __construct(array $parameters)
    {
        $this->parameters = $parameters;
    }

    /**
     * Sets HttpKernel instance.
     * This method will be automatically called by Symfony2Extension
     * ContextInitializer.
     *
     * @param KernelInterface $kernel Kernel
     *
     * @return void
     */
    public function setKernel(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

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
        $spanId = $this->getForAttributeFromLabel($field);

        $span = $this->getElementById($spanId);

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
        $checkboxId = $this->getForAttributeFromLabel($checkboxName);

        $checkbox = $this->getElementById($checkboxId);

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
        $checkboxId = $this->getForAttributeFromLabel($checkboxName);

        $checkbox = $this->getElementById($checkboxId);

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

    /**
     * Checks, that the table does not containt action button.
     *
     * @param string $action Action button title.
     *
     * @return void
     *
     * @throws ExpectationException
     *
     * @Then /^I should not see "([^"]*)" action button$/
     */
    public function iShouldNotSeeActionButton($action)
    {
        $session = $this->getMainContext()->getSession();
        $page = $session->getPage();

        switch ($action) {
            case "Add":
                $actionButton = GuiSubcontext::ACTION_ADD;
                break;
            case "Edit":
                $actionButton = GuiSubcontext::ACTION_EDIT;
                break;
            case "View":
                $actionButton = GuiSubcontext::ACTION_VIEW;
                break;
            case "Delete":
                $actionButton = GuiSubcontext::ACTION_DELETE;
                break;
            default:
                $message = sprintf(
                    'The action button has "%s" value, but "%s" expected.',
                    $action,
                    'Add|Edit|View|Delete'
                );
                throw new ExpectationException($message, $session);
        }

        $nodeElements = $page->findAll('css', 'table i');

        $found = false;
        foreach ($nodeElements as $nodeElement) {

            if ($nodeElement->getAttribute('class') == $actionButton) {
                $found = true;
            }
        }
        assertEquals(false, $found, 'Action button "'.$action.'" found');
    }

    /**
     * Check snumber of rows in table.
     *
     * @param integer $rowCount Number of rows
     *
     * @return void
     *
     * @Then /^I should see (\d+) rows in the table$/
     */
    public function iShouldSeeRowsInTheTable($rowCount)
    {
        $session = $this->getMainContext()->getSession();
        $page = $session->getPage();

        $rows = $page->findAll('css', 'table tbody tr');

        assertEquals($rowCount, count($rows));
    }

    /**
     * Checks that the dispayed table matches with the reference table.
     *
     * @param TableNode $tableNode Table with labels and expected values
     * @param boolean   $ordered   Indicates if table rows are ordered
     *
     * @return void
     *
     * @Then /^the data of the table should match:$/
     */
    public function theDataOfTheTableShouldMatch(
        TableNode $tableNode,
        $ordered = true
    ) {
        $hash = $tableNode->getHash();

        $session = $this->getMainContext()->getSession();
        $page = $session->getPage();

        $nodeElementHeads = $page->findAll('css', 'table thead tr th');

        $column2Check = array();

        foreach ($nodeElementHeads as $nodeElementHead) {
            if (array_key_exists($nodeElementHead->getText(), $hash[0])) {
                $column2Check[$nodeElementHead->getText()] = true;
            } else {
                $column2Check[$nodeElementHead->getText()] = false;
            }
        }
        $nodeElementRows = $page->findAll('css', 'table tbody tr');

        $table = array();

        foreach ($nodeElementRows as $nodeElementRow) {

            $row = array();
            $columnIdx = 0;
            $column2CheckKeys = array_keys($column2Check);

            $nodeElements = $nodeElementRow->findAll('css', 'td');

            foreach ($nodeElements as $nodeElement) {

                $columnName = $column2CheckKeys[$columnIdx];

                if ($column2Check[$columnName]) {
                    $row[$columnName] = trim(
                        preg_replace(
                            "/[^[:print:]]/",
                            "",
                            $nodeElement->getText()
                        )
                    );
                }
                $columnIdx++;
            }
            $table[] = $row;
        }
        if (! $ordered) {
            sort($hash);
            sort($table);
        }
        assertEquals($hash, $table);
    }

    /**
     * Checks that the dispayed table matches with the reference table. Rows
     * are not ordered.
     *
     * @param TableNode $tableNode Table with labels and expected values
     *
     * @return void
     *
     * @Then /^the data not ordered of the table should match:$/
     */
    public function theDataNotOrderedOfTheTableShouldMatch(
        TableNode $tableNode
    ) {
        $this->theDataOfTheTableShouldMatch($tableNode, false);
    }

    /**
     * Checks that the specified table's columns match the given schema
     *
     * @param TableNode $tableNode Table with labels and expected values
     *
     * @return void
     *
     * @Then /^the columns of the table should match:$/
     */
    public function theColumnsShouldMatch(TableNode $tableNode)
    {
        $session = $this->getMainContext()->getSession();
        $page = $session->getPage();

        $nodeElements = $page->findAll('css', 'table thead tr th');

        $tableHeader = array();

        foreach ($nodeElements as $key => $nodeElement) {

            $tableHeader[] = trim(
                preg_replace("/[^[:print:]]/", "", $nodeElement->getText())
            );
        }
        assertEquals($tableNode->getRow(0), $tableHeader);
    }

    /**
     * Checks if the table contains the specified value.
     *
     * @param string $value The value to check
     *
     * @return void
     *
     * @Then /^the table should contain "([^"]*)"$/
     */
    public function theTableShouldContain($value)
    {
        $session = $this->getMainContext()->getSession();
        $page = $session->getPage();

        $nodeElements = $page->findAll('css', 'table tbody tr td');

        $cells = array();
        foreach ($nodeElements as $nodeElement) {
            $cells[] = $nodeElement->getText();
        }
        assertContains(
            $value,
            $cells,
            'The table does not containt "'.$value.'"'
        );
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
