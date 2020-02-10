<?php
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

$collection = new RouteCollection();
$collection->add('new', new Route('/new', array(
    '_controller' => 'SponsorsBundle:Sponsor:new',
)));

$collection->add('edit', new Route('/edit', array(
    '_controller' => 'SponsorsBundle:Sponsor:edit',
)));

$collection->add('index', new Route('/index', array(
    '_controller' => 'SponsorsBundle:Sponsor:index',
)));

$collection->add('show', new Route('/show', array(
    '_controller' => 'SponsorsBundle:Sponsor:show',
)));

return $collection;