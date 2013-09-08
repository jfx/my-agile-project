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
use Behat\Mink\Element\NodeElement;
use Behat\Mink\Exception\ElementNotFoundException;
use Behat\Mink\Exception\ExpectationException;
use DateTime;
use Exception;
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
     * Checks access to URL for different roles.
     *
     * @param TableNode $tableNode Table with URL and granted access for role
     *
     * @return void
     *
     * @Given /^I check the following ACL table:$/
     */
    public function iCheckTheFollowingAclTable(TableNode $tableNode)
    {
        $hash = $tableNode->getHash();

        $mainContext = $this->getMainContext();
        $session = $mainContext->getSession();

        $loginSubContext = $this->getMainContext()->getSubcontext('login');

        $roles = array_keys($hash[0]);

        for ($i = 1; $i <= 6; $i++) {

            $role = $roles[$i];
            $credentials = $loginSubContext->getCredentialsFromRole($role);

            $session->restart();

            // Login
            $session->visit($mainContext->locatePath('/login'));
            $loginPage = $session->getPage();
            $loginPage->fillField('Username:', $credentials['username']);
            $loginPage->fillField('Password:', $credentials['password']);
            $loginPage->pressButton('Login');
            try {
                $mainContext->assertPageAddress('/');
            } catch (\Exception $e) {
                $message  = 'Role : '.$role;
                $message .= ' > '.$e->getMessage();
                throw new ExpectationException($message, $session);
            }
            foreach ($hash as $idx => $row) {

                if (strlen($row['Prerequisite']) > 0) {

                    $session->visit(
                        $mainContext->locatePath($row['Prerequisite'])
                    );
                    try {
                        $mainContext->assertPageAddress($row['Prerequisite']);
                    } catch (\Exception $e) {
                        $message  = 'Prerequisite : '.$row['Prerequisite'];
                        $message .= ' - '.'Role : '.$role;
                        $message .= ' > '.$e->getMessage();
                        throw new ExpectationException($message, $session);
                    }
                }
                $session->visit($mainContext->locatePath($row['URL']));
                try {
                    $mainContext->assertPageAddress($row['URL']);
                } catch (\Exception $e) {
                    $message  = 'URL : '.$row['URL'].' - '.'Role : '.$role;
                    $message .= ' > '.$e->getMessage();
                    throw new ExpectationException($message, $session);
                }

                if ($row[$role] == 'Y') {
                    try {
                        $mainContext->assertPageNotContainsText(
                            '403 Forbidden'
                        );
                    } catch (\Exception $e) {
                        $message  = 'URL : '.$row['URL'].' - '.'Role : '.$role;
                        $message .= ' > '.$e->getMessage();
                        throw new ExpectationException($message, $session);
                    }

                } else {
                    try {
                        $mainContext->assertPageContainsText('403 Forbidden');
                    } catch (\Exception $e) {
                        $message  = 'URL : '.$row['URL'].' - '.'Role : '.$role;
                        $message .= ' > '.$e->getMessage();
                        throw new ExpectationException($message, $session);
                    }
                }
            }
        }
    }

    /**
     * Fills in form fields with provided table containing dynamic date.
     *
     * @param TableNode $tableNode Table with labels and expected values
     *
     * @return void
     *
     * @When /^(?:|I )fill in the following with dynamic date:$/
     */
    public function fillFieldsWithDynamicDate(TableNode $tableNode)
    {
        $this->dynamicDateFormatTable($tableNode);
        
        $mainContext = $this->getMainContext();
        $mainContext->fillFields($tableNode);
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
    
    /**
     * Convert a dynamic date like @date("+ 1 months") to a real date.
     *
     * @param string $dynDate Dynamic date
     *
     * @return string|false a formated date or false if it is not a dynamic
     * date.
     *
     * @throws Exception
     */
    public function dynamicDateFormat($dynDate)
    {
        if (is_string($dynDate) && (substr($dynDate, 0, 5) == '@date')) {
            preg_match_all('/\((.*)\)/', $dynDate, $matches);
            $paramDateTime =  str_replace('"', '', $matches[1])[0];

            try {
                $date = new DateTime($paramDateTime);
            } catch (Exception $e) {
                $msg  = 'Wrong date format : '.$dynDate.' - '.$e->getMessage();

                throw new Exception($msg);
            }

            return $date->format('d/m/Y');
        }

        return false;
    }
    
    /**
     * Parse table and convert a dynamic date like @date("+ 1 months") 
     * to a real date.
     *
     * @param TableNode $tableNode Table that contains dynamic date
     *
     * @return TableNode Table node with real date.
     */
    public function dynamicDateFormatTable(TableNode $tableNode)
    {
        $rows = $tableNode->getRows();

        foreach ($rows as $rowId => $row) {
            foreach ($row as $cellId => $value) {

                $dynamicDateFormat = $this->dynamicDateFormat($value);

                if ($dynamicDateFormat) {

                    $row[$cellId] = $dynamicDateFormat;
                }
            }
            $rows[$rowId] = $row;
        }
        return $tableNode->setRows($rows);
    }
}
