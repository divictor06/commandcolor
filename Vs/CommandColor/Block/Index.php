<?php

namespace Vs\CommandColor\Block;

use Magento\Framework\View\Element\Template;

class Index extends Template {

    protected $storeManager;

    protected $varObj;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Variable\Model\Variable $varObj,
        array $data = []
    ) {
        $this->storeManager = $storeManager;
        $this->varObj = $varObj;
        parent::__construct($context, $data);
    }

    public function getIdStore(){

        return $this->storeManager->getStore()->getId();
    }

    public function getConfig(){

        $id = $this->getIdStore();

        $var = $this->varObj->setStoreId($id);
        $var->loadByCode('color_button_gral');
        $varValue = $var->getValue('plain');
        
        return $varValue;

    }

}