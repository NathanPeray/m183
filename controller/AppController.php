<?php
    class AppController {

        function indexAction() {
            if (Auth::getInstance()->auth()) {
                new View("home.index", "Unnützer Fahrplan", [
                    'location' => str_replace("Controller", "", get_class($this)),
                ]);
            } else {
                header("Location: ./app/guest");
            }
        }
        function guestAction() {
            new View("home.guest");
        }
    }
?>
