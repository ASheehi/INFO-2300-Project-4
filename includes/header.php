<header>
    <nav class="navigation_bar_style">
        <ul>
            <li><a class="<?php echo $index ?>" href="index.php"> Home </a></li>
            <li><a class="<?php echo $about ?>" href="about.php"> About Us</a></li>
            <li><a class="<?php echo $events ?>" href="events.php"> Events </a></li>
            <li><a class="<?php echo $resources ?>" href="resources.php"> Resources </a></li>

<?php
 if (is_user_logged_in()){
   ?>
<li><a class="<?php echo $listserve ?>" href="listserve.php"> Listserve </a></li>
   <?php
 }
?>
        </ul>
    </nav>
</header>
