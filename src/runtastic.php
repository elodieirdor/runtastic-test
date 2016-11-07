<?php
/**
 * Created by PhpStorm.
 * User: elodie
 * Date: 07/11/16
 * Time: 18:22
 */
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/autoload.php';

use Runtastic\Runtastic;
use Symfony\Component\Yaml\Yaml;


$loginData = Yaml::parse(file_get_contents(__DIR__.'/../parameters/account.yml'))['loginData'];

$r = new Runtastic();
$r->setUsername($loginData['username'])
->setPassword($loginData['password']);

if (false === $r->login()) {
    die('An error occured for login');
};

$activities = $r->getActivities();
echo "Total Number of activities: " . count($activities) . PHP_EOL;

foreach ($activities as $activity) {
    echo $activity->id . PHP_EOL;
}
