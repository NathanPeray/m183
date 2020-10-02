<div class="station">
    <h2>Station suche</h2>
    <div class="field">
        <input type="text" id="yolo" list="hints" name="" value="">
        <datalist id="hints">

        </datalist>
    </div>
    <button type="button">Route von Hier</button>
    <button type="button">Meine Stationen</button>
</div>
<script>
    var input = document.getElementById("yolo");
    yolo.onkeyup = function(e) {
        var req = new XMLHttpRequest();
        req.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var stations = JSON.parse(this.responseText);
                var hintcontainer = document.getElementById("hints");
                hintcontainer.innerHTML = "";
                stations['stations'].forEach((v) => {
                    console.log(v);
                    var h = document.createElement("option");
                    h.value = v['name'];
                    h.setAttribute('station-id', v['id']);
                    hintcontainer.appendChild(h);
                });
            }
        }
        req.open("GET", "http://transport.opendata.ch/v1/locations?type=station&query=" + e.target.value);
        req.send();
    }
    function addHint(hint) {1

    }
</script>
