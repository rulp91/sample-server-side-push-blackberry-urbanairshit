<?php

namespace Acme\DemoBundle\Lib\UrbanAirship\Device;

interface RegisterableDeviceInterface
{
    public function createPayload();
    public function hasPayload();
    public function getPayload();
}
