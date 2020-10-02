<?php
    class AppController {

        function __construct() {
            global $confArray;
            if(!Auth::getInstance()->auth()) {
                $this->redirect("guest/index");
            }
        }
        function indexAction() {
            return new View("home.index", "Useless Timetable", [
                'location' => "home",
                'stations' => Station::getFromUser(),
            ]);
        }
        function stationsAction() {
            if (isset($_GET['station'])) {
                $station = Station::get($_GET['station']);
                return new View("home.station", $station->name, [
                    'location' => "stations",
                    'station' => $station,
                ]);
            } else {
                return new View("home.stations", "Stations", [
                    'location' => "stations",
                    'stations' => Station::getFromUser(),
                ]);
            }
        }
        function routesAction() {
            $from = null;
            $to = null;
            if (isset($_GET['from'])) {
                $from = Station::get($_GET['from']) ;
            }
            if (isset($_GET['to'])) {
                $to = Station::get($_GET['to']);
            }
            return new View("home.routes", "Routes", [
                'location' => "routes",
                'from' => $from,
                'to' => $to,
                'routes' => Route::getFromUser(),
            ]);
        }
        function accountAction() {
            return new View("home.account", "Account", [
                'location' => "account",
            ]);
        }
        function addStationAction() {
            $data = [];
            foreach($_POST as $key => $value) {
                $data[htmlspecialchars($key)] = htmlspecialchars($value);
            }
            $data['user_FK'] = Auth::getInstance()->getUser()->id;
            new Station($data);

        }
        function deleteStationAction() {
            if (isset($_GET['station'])) {
                $station = Station::get($_GET['station']);
                $station->delete();
            }
            $this->redirect("app/stations");
        }
        function addRouteAction() {
            $data = [];
            foreach($_POST as $key => $value) {
                $data[htmlspecialchars($key)] = htmlspecialchars($value);
            }
            $data['user_FK'] = Auth::getInstance()->getUser()->id;
            new Route($data);
            $this->redirect("app/routes");
        }
        function routeAction() {
            $route = null;
            if (isset($_POST['from'], $_POST['to'])) {
                $route = json_decode(file_get_contents("http://transport.opendata.ch/v1/connections?limit=10&" . "from=" . $_POST['from'] . "&to=" . $_POST['to']), true);
            } else {
                $route = ["HALLO", "HURENSOHN"];
            }
            return new View("home.route", "Route", [
                'location' => 'routes',
                'route' => $route,
            ]);
        }

        private function redirect($location) {
            global $confArray;
            header("Location: " . $confArray['protocol'] . "://" . $confArray['base_url'] . "/" . $location);
        }
    }
?>
