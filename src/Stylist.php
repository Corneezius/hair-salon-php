 <!-- __construct, getters and setters, save, getAll, deleteAll, find, update, and delete. -->
<?php

    class Stylist {

        private $id;
        private $name;

        function __construct($id = null, $stylist_name_input) {
            $this->id = $id;
            $this->name = $stylist_name_input;
        }

        function getid() {
            return $this->id;
        }

        function setStylistName($stylist_name_input) {
            $this->name = $stylist_name_input;
        }

        function getStylistName() {
            return $this->name;
        }

        function save() {
            $GLOBALS['DB']->exec("INSERT INTO stylists (name) VALUES ('{$this->getStylistName()}');");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function getAll() {
            $returned_stylists = $GLOBALS['DB']->query("SELECT * FROM stylists;");
            $stylists = array();
            foreach ($returned_stylists as $stylist) {
                $id = $stylist['id'];
                $name = $stylist['name'];
                $new_stylist = new Stylist($id, $name);
                array_push($stylists, $new_stylist);
            }
            return $stylists;
        }

        static function deleteAll() {
            $GLOBALS['DB']->exec("DELETE FROM stylists;");
        }



    }



?>
