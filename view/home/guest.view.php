<div id="content" class="split auth">
    <div class="login form-toggler">
        <div class="head" target="loginform">
            <h2>Melden Sie sich an</h2>
            <p>um den Service des unnützlichen Fahrplans zu nutzen</p>
        </div>
        @@partial(auth.login)
    </div>
    <div class="splitter">

    </div>
    <div class="register form-toggler">
        <div class="head" target="registerform">
            <h2>Jetzt registrieren</h2>
            <p>Für den super unnützlichen Fahrplan</p>
        </div>
        @@partial(auth.register)
    </div>
</div>
<script>
    var togglers = document.getElementsByClassName("form-toggler");
    for (var i = 0; i < togglers.length; i++) {
        togglers[i].getElementsByClassName("head")[0].onclick = function(e) {
            var target = e.target.classList.contains("head") ? e.target : e.target.closest(".head");
            var form = document.getElementById(target.getAttribute("target"));
            if (form.classList.contains("active")) {
                form.classList.remove("active");
            } else {
                form.classList.add("active");
            }
        }
    }
</script>
