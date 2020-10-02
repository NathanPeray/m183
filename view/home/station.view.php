<?php
    $board = json_decode(file_get_contents('http://transport.opendata.ch/v1/stationboard?limit=10&id=' . $station->external), true);
?>
<div id="home">
    <div class="station-board">
        <div class="title">
            <h4>Stationboard</h4>
        </div>
        <?php foreach ($board['stationboard'] as $dep): ?>
        <div class="departure">
            <div class="time">
                <?= date("h:m" ,strtotime($dep['stop']['departure'])) ?>

            </div>
            <div class="name">
                <?= $dep['category'] . $dep['number'] ?>
            </div>
            <div class="destination">
                <?= $dep['to'] ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <div class="route-linker">
        <div class="title">
            <h4>Route</h4>
        </div>
        <div class="route-from-here">
            <a href="@@baseUrl/app/routes?from=<?= $station->id ?>">Departure</a>
        </div>
        <div class="route-to-here">
            <a href="@@baseUrl/app/routes?to=<?= $station->id ?>">Destination</a>
        </div>

    </div>
    <div class="options">
        <div class="title">
            <h4>Options</h4>
        </div>
        <div class="delete">
            <a class="delete" href="@@baseUrl/app/deleteStation?station=<?= $station->id ?>">Delete</a>
        </div>
    </div>
</div>
