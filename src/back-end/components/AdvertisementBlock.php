<?php

include('ComponentBase.php');
include('../types/advertisement_t.php');

class AdvertisementBlock extends ComponentBase{
    private advertisement_t $advertisement;

    public function __construct(advertisement_t $advertisement){
        parent::__construct('../templates/advertisement_block.php');
        
        $this->advertisement = $advertisement;
    }
}

?>