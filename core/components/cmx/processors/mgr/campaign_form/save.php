<?php

FB::log($_POST);

$name = $modx->getOption('name', $_POST, '');
$subject = $modx->getOption('subject', $_POST, '');
$from_name = $modx->getOption('from_name', $_POST, '');
$from_email = $modx->getOption('from_email', $_POST, '');
$replyto = $modx->getOption('replyto', $_POST, '');
$lists = $modx->getOption('lists', $_POST, array());
$content = $modx->getOption('content', $_POST, '');

