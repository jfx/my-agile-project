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

namespace Map\HomeBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Test controller class.
 *
 * @category  MyAgileProject
 * @package   Core
 * @author    Francois-Xavier Soubirou <soubirou@yahoo.fr>
 * @copyright 2014 Francois-Xavier Soubirou
 * @license   http://www.gnu.org/licenses/   GPLv3
 * @link      http://www.myagileproject.org
 * @since     2
 *
 */
class DefaultControllerTest extends WebTestCase
{
    /**
     * Test method
     *
     * @return void
     */
    public function testIndex()
    {
        $client = static::createClient();
        $client->followRedirects();

        $crawler = $client->request('GET', '/login');

        $elt = $crawler->filter('html:contains("Username")');
        $eltCount = $elt->count();
        $this->assertGreaterThan(0, $eltCount);

        $form = $crawler->selectButton('login')->form();
        $form['_username'] = 'useruser';
        $form['_password'] = 'user';

        $client->submit($form);

        $statusCode  = $client->getResponse()->getStatusCode();
        $this->assertTrue(200 === $statusCode);

        $content = $client->getResponse()->getContent();

        $logger = $client->getContainer()->get('logger');
        $logger->info($content);

        $count = substr_count($content, 'Hello Firstuser User !');
        $this->assertGreaterThan(0, $count);
    }
}
