<!DOCTYPE html>
<html>
    <head>
        @@partial(layout.head)
    </head>
    <body>
        <header>
            @@auth
            <nav>
                @@partial(layout.nav)
            </nav>
            @@endauth
        </header>
        <main>
            <div id="app">
                @@content
            </div>
        </main>
        @@auth
        <footer>
            @@partial(layout.footer)
        </footer>
        @@endauth
    </body>
</html>
