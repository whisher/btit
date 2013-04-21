<?php

namespace BtitUser\Authentication\Adapter;

interface ChainableAdapter
{
    public function authenticate(AdapterChainEvent $e);
}
