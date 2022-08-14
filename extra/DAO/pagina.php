<?php

require_once "config.php";

$profile = new Profile;

$profile->loadById(10);
$profile->delete();

$profile = Profile::listProfiles();

echo $profile;