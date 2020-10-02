<?php
    class Station extends Model {

        public $id;
        public $external;
        public $name;
        public $user_FK;

        public function __construct($data = null) {
            parent::__construct($data);
        }
    }
?>
