<div id="home">
    <div class="routing">
        <div class="route-planer">
            <div class="title">
                <h4>Route</h4>
            </div>
            <form method="post" id="route-form">
                <div class="row">
                    <h5>From</h5>
                    <input type="hidden" name="stationfromexternal" value="<?= isset($from) ? $from->external : '' ?>">
                    <input type="text" list="fromHint" name="stationfrom" value="<?= isset($from) ? $from->name : '' ?>">
                    <datalist id="fromHint"></datalist>
                </div>
                <div class="row">
                    <h5>To</h5>
                    <input type="hidden" name="stationtoexternal" value="<?= isset($to) ? $to->external : '' ?>">
                    <input type="text" list="toHint" name="stationto" value="<?= isset($to) ? $to->name : '' ?>">
                    <datalist id="toHint"></datalist>
                </div>
                <button type="button" name="go">get Route</button>
                <button type="button" name="add">Add to Routes</button>
            </form>
        </div>
    </div>
    <div class="quick-route">
        <div class="title">
            <h4>My Routes</h4>
        </div>
        <?php foreach($routes as $route): ?>
            <form class="route" method="post" action="@@baseUrl/app/route">
                <div class="from">
                    <h5>From:</h5>
                    <p><?= $route->stationfrom ?></p>
                    <input type="hidden" name="from" value="<?= $route->stationfromexternal ?>">
                </div>
                <div class="to">
                    <h5>To:</h5>
                    <p><?= $route->stationto ?></p>
                    <input type="hidden" name="to" value="<?= $route->stationtoexternal ?>">
                </div>
                <div class="go">
                    <input type="submit" value="GO!">
                </div>
            </form>
        <?php endforeach; ?>
    </div>
</div>
<script>
    var currentField;
    var currentRequest;
    var form = document.getElementById("route-form");
    form.stationfrom.addEventListener("keyup", getHints);
    form.stationto.addEventListener("keyup", getHints);
    form.add.addEventListener("click", addToRoutes);
    function getHints(e) {
        if (e.keyCode != null) {
            if (App.currentRequest != null) {
                App.currentRequest.abort();
            }
            App.GET("http://transport.opendata.ch/v1/locations?type=station&query=" + e.target.value, setHints);
            currentField = e.target;
            currentField.addEventListener("change", selectHint);
        }
    }
    function setHints(response) {
        stations = JSON.parse(response);
        var container = currentField.list;
        container.innerHTML = "";
        stations['stations'].forEach((station) => {
            var hint = document.createElement("option");
            hint.value = station['name'];
            hint.setAttribute("external", station['id']);
            container.appendChild(hint);
        });
    }
    function selectHint(e) {
        var field = currentField;
        var container = currentField.list;
        container.children.forEach((opt) => {
            if (opt.value == e.target.value) {
                e.target.form[e.target.name + 'external'].value = opt.getAttribute("external");
            }
        });
        container.innerHTML = "";
    }
    function addToRoutes(e) {
        var data = [];
        form = e.target.form;
        fields = form.getElementsByTagName("input");
        fields.forEach((field) => {
            data[field.name] = field.value;
        });
        App.POST(App.url + "/app/addRoute", data, (response) => {location.reload()});
    }
    function getRoute(e) {

    }
</script>
