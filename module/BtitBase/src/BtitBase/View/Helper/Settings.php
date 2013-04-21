<?php
namespace BtitBase\View\Helper;
 
use Zend\View\Helper\AbstractHelper;
use BtitBase\Configs\ModuleConfigs;

class Settings extends AbstractHelper
{
    protected $config;
    public function __construct(ModuleConfigs  $config)
    {
        $this->config = $config;
    }
 
    public function __invoke($key)
    {
        return  $this->config->$key;
    }
}