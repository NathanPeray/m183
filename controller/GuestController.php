<?php
    class GuestController {

        public function indexAction() {
            return new View("guest.index", "Useless Timetable", [
                'location' => 'guest',
            ]);
        }
        public function registerAction() {
            return new View("auth.register", "Signup", [
                'location' => 'guest',
            ]);
        }
    }
?>
