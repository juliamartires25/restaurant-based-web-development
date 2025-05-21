<?php
if (isset($_GET['show']))
    {
    extract($_GET);
    echo "<h1>You have chosen $show</h1>";
}