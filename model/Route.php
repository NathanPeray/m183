<?php
    class Route extends Model {

        public $id;
        public $stationfromexternal;
        public $stationfrom;
        public $stationtoexternal;
        public $stationto;
        public $user_FK;

        public function __construct($data = null) {
            parent::__construct($data);
        }
    }
?>
