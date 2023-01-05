<div class="border-end bg-white col-lg-3 col-md-4 col-sm-5 col-xs-5" id="sidebar-wrapper">
    <h2>Nos offres</h2>
    <nav>
        <ul>
            <?php
            foreach($categories as $cat)
            {
                $name = $cat["name"];
                $path = "?action=select_products&category=".$name;
                echo "<li><a href='$path'>$name</a></li>";
            }
            ?>
        </ul>
    </nav>
</div>