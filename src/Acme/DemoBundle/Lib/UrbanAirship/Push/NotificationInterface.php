<?php

namespace Acme\DemoBundle\Lib\UrbanAirship\Push;

interface NotificationInterface
{
    public function getAlias();
    public function setAlias($alias);
    public function getTags();
    public function setTags($tags);
    public function addTag($tag);
}
