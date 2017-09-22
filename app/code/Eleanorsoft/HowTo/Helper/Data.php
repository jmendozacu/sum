<?php

namespace Eleanorsoft\HowTo\Helper;

use \Magento\Framework\App\Helper\AbstractHelper;

class Data extends AbstractHelper
{
    public function prepareHowToGrid($howToCollection)
    {
        return json_decode($howToCollection);
    }
}
