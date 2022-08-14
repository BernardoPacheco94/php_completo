<?php

require_once "config.php";

$profile = new Profile;

$list = Profile::listProfiles();
echo json_encode($list);