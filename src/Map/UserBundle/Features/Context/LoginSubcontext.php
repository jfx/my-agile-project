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
use Behat\Behat\Context\Step\Given;
use Behat\Behat\Context\Step\Then;
use Behat\Behat\Context\Step\When;
use Behat\Symfony2Extension\Context\KernelAwareInterface;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 * Login subcontext class.
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
class LoginSubcontext extends BehatContext implements KernelAwareInterface
{
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
     * Reusable action method.
     *
     * @return void
     *
     * @Given /^I am an anonymous user$/
     */
    public function iAmAnAnonymousUser()
    {

    }

    /**
     * Reusable action method.
     *
     * @return array
     *
     * @Given /^I am a user$/
     */
    public function iAmAUser()
    {
        return $this->iAmLoggedInAsWithThePassword('useruser', 'user');
    }

    /**
     * Reusable action method.
     *
     * @return array
     *
     * @Given /^I am a super-admin$/
     */
    public function iAmAnSuperAdmin()
    {
        return $this->iAmLoggedInAsWithThePassword('useradmin', 'admin');
    }

    /**
     * Reusable action method.
     *
     * @param string $username Username
     * @param string $password Password
     *
     * @return array
     *
     * @Given /^I am logged in as "([^"]*)" with the password "([^"]*)"$/
     */
    public function iAmLoggedInAsWithThePassword($username, $password)
    {
        return array(
            new Given('I am on "/login"'),
            new When('I fill in "Username:" with "'.$username.'"'),
            new When('I fill in "Password:" with "'.$password.'"'),
            new When('I press "Login"'),
            new Then('I should be on "/"')
        );
    }

    /**
     * Reusable action method.
     *
     * @return array
     *
     * @Given /^I logout$/
     */
    public function iLogout()
    {
        return array(
            new When('I go to "/logout"'),
            new Then('I should be on "/login"')
        );
    }

    /**
     * Reusable action method.
     *
     * @return array
     *
     * @Given /^I am disconnected$/
     */
    public function iAmDisconnected()
    {
        return array(
            new When('I go to "/"'),
            new Then('I should be on "/login"')
        );
    }
}
