<div id="home">
    <div class="head">
        <div class="title">
            <div class="from">
                <h5>From:</h5>
                <h4><?= $route['from']['name'] ?></h4>
            </div>
            <div class="to">
                <h5>To:</h5>
                <h4><?= $route['to']['name'] ?></h4>
            </div>
            <form class="route" action="@@baseUrl/app/addRoute" method="post">
                <input type="hidden" name="stationfromexternal" value="<?= $route['from']['id'] ?>">
                <input type="hidden" name="stationfrom" value="<?= $route['from']['name'] ?>">
                <input type="hidden" name="stationtoexternal" value="<?= $route['to']['id'] ?>">
                <input type="hidden" name="stationto" value="<?= $route['to']['name'] ?>">
                <input type="submit" value="Add to Routes">
            </form>
        </div>
    </div>
    <?php foreach($route['connections'] as $connection): ?>
    <div class="connection">
        <div class="short-view">
            <div class="from">
                <h5><?= date("H:i", $connection['from']['departureTimestamp']) ?></h5>
                <p><?= $connection['from']['station']['name'] ?></p>
            </div>
            <div class="mid">
                <?php
                $timeArr = explode(":", $connection['duration']);
                $time = mktime(explode("d", $timeArr[0])[1], $timeArr[1], $timeArr[2]);
                ?>
                <p><?= date('H:i:s', $time) ?></p>
            </div>
            <div class="to">
                <h5><?= date("H:i", $connection['to']['arrivalTimestamp']) ?></h5>
                <p><?= $connection['to']['station']['name'] ?></p>
            </div>
        </div>
        <div class="journey">
        <?php foreach($connection['sections'] as $section): ?>
            <?php if ($section['journey'] != null): ?>
            <div class="transport">
                <div class="from">
                    <p><?= $section['departure']['station']['name'] ?></p>
                    <p><?= date("H:i", $section['departure']['departureTimestamp']) ?></p>
                    <p><?= $section['departure']['platform'] == null ? "n/a" : $section['departure']['platform'] ?></p>

                </div>
                <div class="mid">
                    <p><?= $section['journey']['category'] . $section['journey']['number'] ?></p>
                </div>
                <div class="to">
                    <p><?= $section['arrival']['station']['name'] ?></p>
                    <p><?= date("H:i", $section['arrival']['arrivalTimestamp']) ?></p>
                    <p><?= $section['arrival']['platform'] == null ? "n/a" : $section['arrival']['platform'] ?></p>
                </div>
            </div>
            <?php else: ?>
            <div class="walk">
                <div class="from">
                    <p><?= $section['departure']['station']['name'] ?></p>
                </div>
                <div class="mid">
                    <p><?= gmdate("i:s", $section['walk']['duration']) ?> min</p>
                </div>
                <div class="to">
                    <p><?= $section['arrival']['station']['name'] ?></p>
                </div>
            </div>
            <?php endif; ?>

        <?php endforeach; ?>
        </div>
    </div>
    <?php endforeach; ?>
</div>
