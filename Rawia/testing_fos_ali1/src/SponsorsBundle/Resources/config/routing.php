<?php
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

$collection = new RouteCollection();
$collection->add('send', new Route('/send', array(
    '_controller' => 'SponsorsBundle:Mail:send',
)));

return $collection;