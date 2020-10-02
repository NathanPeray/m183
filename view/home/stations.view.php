<div id="home">
    <div class="station-search">
        <div class="title">
            <h4>Search</h4>
        </div>
        <form id="station-form" method="post">
            <input type="hidden" name="external" value="">
            <input type="text" class="station-field" list="station-hints" name="station" placeholder="Station...">
            <datalist id="station-hints"></datalist>
            <button type="button"><i class="fas fa-route"></i></button>
            <button type="button"><i class="fas fa-map-marker-alt"></i></button>
        </form>
    </div>
    @@partial(module.stations)
</div>
