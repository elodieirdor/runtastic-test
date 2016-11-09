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


$loginData = Yaml::parse(file_get_contents(__DIR__ . '/../parameters/account.yml'))['loginData'];

$r = new Runtastic();
$r->setUsername($loginData['username'])
    ->setPassword($loginData['password']);

if (false === $r->login()) {
    die('An error occured for login ' . $loginData['username']);
};

echo "Uid : " . $r->getUid() . " username : " . $r->getUsername();


$activities = $r->getActivities();
echo "Total Number of activities: " . count($activities) . PHP_EOL;
$i = 0;
foreach ($activities as $activity) {
    $i++;
    if ($i > 1) {
        $url = "https://hubs.runtastic.com/samples/v2/users/{$r->getUid()}/samples/{$activity->id}";
        $data = $r->get($url, [], true);

        $fatest_paths = (array) $data->data->attributes->fastest_paths;
        var_dump($fatest_paths);
        foreach ($fatest_paths as $key => $msValue) {
            if (null === $msValue) {
                continue;
            }
            $input = $msValue;

            $uSec = $input % 1000;
            $input = floor($input / 1000);

            $seconds = $input % 60;
            $input = floor($input / 60);

            $minutes = $input % 60;
            $input = floor($input / 60);

            $hours = $input % 60;
            $input = floor($hours / 60);

            $minValue = "$hours:$minutes:$seconds:$uSec";
            echo "Best $key in $minValue \n";
        }
    }
    echo $activity->id . PHP_EOL;
}
