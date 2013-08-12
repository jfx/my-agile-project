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
use Behat\Mink\Exception\ExpectationException;
use Map\CoreBundle\Features\Context\Subcontext;

require_once 'PHPUnit/Autoload.php';
require_once 'PHPUnit/Framework/Assert/Functions.php';

/**
 * Table subcontext class.
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
class TableSubcontext extends Subcontext
{
    const ACTION_ADD    = 'icon-plus-sign';
    const ACTION_EDIT   = 'icon-edit';
    const ACTION_VIEW   = 'icon-eye-open';
    const ACTION_DELETE = 'icon-trash';

    /**
     * Checks, that the table containts action button.
     *
     * @param string $action Action button title.
     *
     * @return void
     *
     * @throws ExpectationException
     *
     * @Then /^I should see "([^"]*)" action button$/
     */
    public function iShouldSeeActionButton($action)
    {
        $found = $this->isActionButtonFound($action);

        assertEquals(true, $found, 'Action button "'.$action.'" not found');
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
        $found = $this->isActionButtonFound($action);

        assertEquals(false, $found, 'Action button "'.$action.'" found');
    }

    /**
     * Checks number of rows in table.
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
     *
     * @return void
     *
     * @Then /^the data of the table should match:$/
     */
    public function theDataOfTheTableShouldMatch(TableNode $tableNode)
    {
        $table = $this->getExtractTableMatching($tableNode);

        $hash = $tableNode->getHash();

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
        $table = $this->getExtractTableMatching($tableNode);

        $hash = $tableNode->getHash();

        sort($hash);
        sort($table);

        assertEquals($hash, $table);
    }

    /**
     * Checks that the data of the table matches with the reference row.
     *
     * @param TableNode $tableNode Table with labels and expected values
     *
     * @return void
     *
     * @Then /^the table should contain the row:$/
     */
    public function theTableShouldContainTheRow(TableNode $tableNode)
    {
        $table = $this->getExtractTableMatching($tableNode);

        $hash = $tableNode->getHash();

        $found = false;

        foreach ($table as $idx => $row) {

            if ($hash[0] == $row) {
                $found = true;
            }
        }
        assertEquals(
            true,
            $found,
            json_encode($hash).' Row not found in table ...'
        );
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
     * Return if a specific action button is found.
     *
     * @param string $action Action button title.
     *
     * @return boolean
     *
     * @throws ExpectationException
     */
    public function isActionButtonFound($action)
    {
        $session = $this->getMainContext()->getSession();
        $page = $session->getPage();

        switch ($action) {
            case "Add":
                $actionButton = TableSubcontext::ACTION_ADD;
                break;
            case "Edit":
                $actionButton = TableSubcontext::ACTION_EDIT;
                break;
            case "View":
                $actionButton = TableSubcontext::ACTION_VIEW;
                break;
            case "Delete":
                $actionButton = TableSubcontext::ACTION_DELETE;
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

        return $found;
    }

    /**
     * Get the table from html page with only columns given.
     *
     * @param TableNode $tableNode Table with labels and expected values
     *
     * @return array
     */
    public function getExtractTableMatching(TableNode $tableNode)
    {
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

        return $table;
    }
}
