<nav>
    <ul>
        <li>
            <a href="@@baseUrl/app/index" <?= $location === "home" ? 'class="active"' : '' ?>>
                <i class="fas fa-home"></i>
            </a>
        </li>
        <li>
            <a href="@@baseUrl/app/stations" <?= $location === "stations" ? 'class="active"' : '' ?>>
                <i class="fas fa-map-marker-alt"></i>
            </a>
        </li>
        <li>
            <a href="@@baseUrl/app/routes" <?= $location === "routes" ? 'class="active"' : '' ?>>
                <i class="fas fa-route"></i>
            </a>
        </li>
        <li>
            <a href="@@baseUrl/app/account" <?= $location === "account" ? 'class="active"' : '' ?>>
                <i class="far fa-user-circle"></i>
            </a>
        </li>
    </ul>
</nav>
