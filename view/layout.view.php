<!DOCTYPE html>
<html>
    <head>
        @@partial(layout.head)
    </head>
    <body>

        <div id="app">
            @@auth
                @@partial(layout.header)
            @@endauth

            <main>
                @@content
            </main>
            @@auth
                @@partial(layout.footer)
            @@endauth
        </div>
        @@auth
            @@partial(layout.nav)
        @@endauth
        <script>
            var app;
            var s = document.createElement("script");
            s.src = "@@baseUrl/js/App.js";
            document.head.appendChild(s);
            s.onload = function() {
                app = App.init("@@baseUrl");
            }
        </script>
    </body>
</html>
