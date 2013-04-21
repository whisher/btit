<?php
namespace BtitBase\Configs;

use Zend\Stdlib\AbstractOptions;
use ArrayObject;

class ModuleConfigs extends AbstractOptions 
{
    protected $site;
    protected $fb;
    
    public function setSite($site)
    {
        $this->site = new \ArrayObject($site,ArrayObject::ARRAY_AS_PROPS);
        return $this;
    }
    
    public function getSite()
    {
        return $this->site;
    }
    
    public function setFb($fb)
    {
        $this->fb = new \ArrayObject($fb,ArrayObject::ARRAY_AS_PROPS);
        return $this;
    }
    
    public function getFb()
    {
        return $this->fb;
    }
}
