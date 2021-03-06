<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Client.php";
    require_once "src/Stylist.php";

    $server = 'mysql:host=localhost:8889;dbname=hair_salon_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class ClientTest extends PHPUnit_Framework_TestCase {

        protected function tearDown()
        {
            Client::deleteAll();
            Stylist::deleteAll();
        }

        function testSave()
        {
            //ARRANGE
            $name = "Lisa Marie";
            $stylist_id = 1;
            $id = null;
            $new_client_test = new Client($name, $stylist_id, $id);
            $new_client_test->save();

            //ACT
            $result = $new_client_test::getAll();

            //ASSERT

            $this->assertEquals($new_client_test, $result[0]);
        }

        function testGetId()
        {
            // ARRANGE
                // ---- save a new stylist so that it has an id ----
            $id = null;
            $name = "Kyle Krieger";
            $new_stylist = new Stylist($id, $name);
            $new_stylist->save();
            $new_stylist_id = $new_stylist->getId();

                // ---- save a new client ----
            $name= "Jane Doe";
            $id = 1;
            $new_client = new Client($name, $new_stylist_id, $id);

            // ACT
            $result = $new_client->getId();

            // ASSERT
            $this->assertEquals($id, $result);
        }

        function testGetAll()
        {
            //ARRANGE
                // ---- save a new client ----
            $name_1 = "Lisa Marie";
            $stylist_id = 1;
            $id = null;
            $new_client_1 = new Client($name_1, $stylist_id, $id);
            $new_client_1->save();

                // ---- save another new client ----
            $id = null;
            $name_2 = "Jane Doe";
            $stylist_id = 1;
            $new_client_2 = new Client($name_2, $stylist_id, $id);
            $new_client_2->save();

            //ACT
            $result = Client::getAll();

            //ASSERT
            $this->assertEquals([$new_client_1, $new_client_2], $result);
        }

        function testDeleteAll()
        {
            //ARRANGE
                // ---- save a new client ----
            $name_1 = "Lisa Marie";
            $stylist_id = 1;
            $id = null;
            $new_client_1 = new Client($name_1, $stylist_id, $id);
            $new_client_1->save();

                // ---- save another new client ----
            $id = null;
            $name_2 = "Jane Doe";
            $stylist_id = 1;
            $new_client_2 = new Client($name_2, $stylist_id, $id);
            $new_client_2->save();
            //ACT
            Client::deleteAll();
            $result = Client::getAll();

            //ASSERT
            $this->assertEquals([], $result);
        }

        function testFind()
        {
            //ARRANGE
            $name = "Lisa Marie";
            $stylist_id = 1;
            $id = null;
            $new_client = new Client($name, $stylist_id, $id);
            $new_client->save();

            //ACT
            $result = Client::find($new_client->getId());

            //ASSERT
            $this->assertEquals($new_client, $result);
        }

        function testUpdateClient()
        {
            // ARRANGE
            $name = "Lisa Marie";
            $stylist_id = 1;
            $id = null;
            $new_client = new Client($name, $stylist_id, $id);
            $new_client->save();

            $new_client_name = "Frances";

            // ACT
            $new_client->updateClient($new_client_name);

            // ASSERT
            $this->assertEquals($new_client_name, $new_client->getClientName());
        }

        function testDelete()
        {
            // ARRANGE
                // ---- save a new client ----
            $name_1 = "Lisa Marie";
            $stylist_id = 1;
            $id = null;
            $new_client_1 = new Client($name_1, $stylist_id, $id);
            $new_client_1->save();

                // ---- save another new client ----
            $name_2 = "Jane Doe";
            $stylist_id = 1;
            $id = null;
            $new_client_2 = new Client($name_2, $stylist_id, $id);
            $new_client_2->save();

                // ---- save a new stylist ----
            $name = "Kyle Krieger";
            $id = null;
            $new_stylist = new Stylist($name, $id);
            $new_stylist->save();

            // ACT
            $new_client_1->delete();

            // ASSERT
            $this->assertEquals([$new_client_2], Client::getAll());
        }
    }


?>
