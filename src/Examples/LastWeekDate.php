<?php

function getLastWeeksDate() {
    $date = new DateTime();
    $date->modify('-7 days');
    return $date;
}

function lwdFastGetter() {
    $lwd = new DateTime('now');
    $iv = new DateInterval('P0Y0M7DT0H0M0S');
    $lwd->sub($iv);
    return $lwd;
}