<?php
require __DIR__ . '/../push_config.php';
header('Content-Type: text/plain');
echo VAPID_PUBLIC_KEY;
