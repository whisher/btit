<?php
namespace BtitBase\View\Helper;
 
use Zend\View\Helper\AbstractHelper;
use ArrayObject;

class OgMetaTags extends AbstractHelper
{
    protected $fbData;
    public function __construct(\ArrayObject $fbData)
    {
        $this->fbData = $fbData;
    }
 
    public function __invoke()
    {
        return  $this->getView()->headMeta()
                    ->setProperty('fb:app_id',$this->fbData->id)
                    ->setProperty('og:type', $this->fbData->type)
                    ->setProperty('og:title',$this->fbData->title)
                    ->setProperty('og:description',$this->fbData->description)
                    ->setProperty('og:url',$this->fbData->url)
                    ->setProperty('og:image',$this->fbData->image);
       
    }
}