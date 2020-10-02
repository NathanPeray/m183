HTMLCollection.prototype.forEach = function(func) {
    for (var i = 0; i < this.length; i++) {
        func(this[i]);
    }
}
function App() {
    App.prepareEvents();
}
App.init = function(url) {
    App.url = url;
    App.instance = new App();
    App.loadScript("sha512.js");
}
App.loadScript = function(name) {
    let s = document.createElement("script");
    s.src = App.url + "/js/" + name;
    document.head.appendChild(s);
}
App.POST = function(target, data, callback) {
    let request = new XMLHttpRequest();
    request.open("POST", target, true);
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            callback(this.responseText);
        }
    }
    request.send(App.prepData(data));
}
App.GET = function(target, callback) {
    var request = new XMLHttpRequest();
    request.open("GET", target, true);
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            callback(this.responseText);
        }
    }
    request.send();
    return request;
}
App.prepData = function(data) {
    var dataString = "";
    for (var key in data) {
        dataString += key + "=" + data[key] + "&";
    }
    return dataString.substring(0, dataString.length - 1);
}
App.prepareEvents = function() {
    var auth = document.getElementsByClassName("auth");
    auth.forEach((form) => {
        form.addEventListener('submit', form.id == "login" ? App.submitLogin : App.submitRegister);
    });
    var stationFields = document.getElementsByClassName("station-field");
    stationFields.forEach((field) => {
        field.addEventListener("keyup", App.stationSearch);
    });
    var form = document.getElementById("station-form");
    if (form != null) {
        var btns = form.getElementsByTagName("button");
        btns[0].addEventListener("click", App.startRouteFromStation);
        btns[1].addEventListener("click", App.addStationToStations);
    }
}

/** AJAX CALLBACKS **/
App.verifyLogin = function(response) {
    response = JSON.parse(response);
    if (response[0]) {
        window.location.href = App.url;
    } else {
        document.getElementById("login").classList.add("invalid");
    }
}
App.verifyRegister = function(response) {
    response = JSON.parse(response);
    if (response[0]){
        window.location.href = App.url;
    } else {
        var form = document.getElementById("register");
        response[1].forEach((val) => {
            form[val].classList.add("invalid");
        });
    }
}
App.setStationHints = function(response) {
    var stations = JSON.parse(response);
    var container = document.getElementById("station-hints");
    container.innerHTML = "";
    stations['stations'].forEach((station) => {
        var hint = document.createElement("option");
        hint.value = station['name'];
        hint.setAttribute("external", station['id']);
        container.appendChild(hint);
    });
    App.currentSelector.addEventListener("change", App.selectHint);
}
App.stationAddSuccess = function(response) {
    location.reload();
}

/** EVENTS **/
App.submitLogin = function(e) {
    e.preventDefault();
    var form = e.target;
    var data = [];
    data['hash'] = sha512(form.password.value);
    data['email'] = form.email.value;
    App.POST(form.getAttribute("reciever"), data, App.verifyLogin);
}
App.submitRegister = function(e) {
    e.preventDefault();
    var form = e.target;
    var data = [];
    var status = true;
    form.children.forEach((input) => {
        input.classList.remove("invalid");
    });
    form.children.forEach((input) => {
        if (input.value == "") {
            status = false;
            input.classList.add("invalid");
        }
    });
    if (form.password.value != form.confirm.value) {
        status = false;
        form.password.classList.add("invalid");
        form.confirm.classList.add("invalid");
    }
    if (status) {
        data['username'] = form.username.value;
        data['prename'] = form.prename.value;
        data['lastname'] = form.lastname.value;
        data['email'] = form.email.value;
        data['hash'] = sha512(form.password.value);
        App.POST(form.getAttribute("reciever"), data, App.verifyRegister);
    }
}
App.stationSearch = function(e) {
    if (e.keyCode != null) {
        if (App.hintRequest != null) {
            App.hintRequest.abort();
        }
        App.hintRequest = App.GET("http://transport.opendata.ch/v1/locations?type=station&query=" + e.target.value, App.setStationHints);
        App.currentSelector = e.target;
    }
}
App.selectHint = function(e) {
    var field = App.currentSelector;
    var container = document.getElementById("station-hints");
    container.children.forEach((opt) => {
        if (opt.value == e.target.value) {
            e.target.parentNode.external.value = opt.getAttribute("external");
        }
    });
    container.innerHTML = "";
}
App.addStationToStations = function(e) {
    var data = [];
    var form = e.target.form;
    if (App.currentSelector == "") {
        e.target.classList.add("invalid");
        return;
    }
    data['name'] = form.station.value;
    data['external'] = form.external.value;
    App.POST(App.url + "/app/addStation", data, App.stationAddSuccess);
}
App.startRouteFromStation = function(e) {

}
App.startRouteTo = function(e) {

}
