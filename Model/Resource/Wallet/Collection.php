<?php
class Cammino_Wallet_Model_Resource_Wallet_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract {

    protected function _construct()
    {
		$this->_init('cammino_wallet/wallet');
    }
}