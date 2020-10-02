<div class="stations">
    <div class="title">
        <h4>My Stations</h4>
    </div>
    <div class="grid">
        <?php foreach($stations as $station): ?>
        <a href="@@baseUrl/app/stations?station=<?= $station->id ?>">
            <div class="station">
                <p external="<?= $station->external ?>"><?= $station->name ?></p>
            </div>
        </a>
        <?php endforeach; ?>
    </div>
</div>
