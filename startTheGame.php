#! /usr/bin/env php

<?php
use Symfony\Component\Console\Application;

require 'vendor/autoload.php';

$app = new Application('Domino', '1.0');

$app->add(new DominoGame\StartTheGameCommand());

$app->run();
