<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 *
 * @category   Cammino
 * @package    Cammino_Wallet
 * @author     Cammino Digital <suporte@cammino.com.br>
 *
 */

class Cammino_Wallet_Model_Sales_Quote_Address_Total_Tax extends Mage_Sales_Model_Quote_Address_Total_Abstract 
{

  protected $_code = 'cammino_wallet';
  
  public function collect(Mage_Sales_Model_Quote_Address $address)
  {
    parent::collect($address);
    $data = Mage::app()->getRequest()->getPost();
    $items = $this->_getAddressItems($address);

    $_checkoutSession = Mage::getModel('checkout/session');
    $_session         = Mage::getSingleton('core/session');
    
    $grandTotal       = $_checkoutSession->getQuote()->getGrandTotal();

    if (!count($items)) {
      return $this;
    }

    $wallet = $this->getWallet() * -1;

    // Magento Default
    $address->setGrandTotal($wallet);
    $address->setBaseGrandTotal($wallet);

    $address->setWalletDebit($wallet);
    $address->setBaseWalletDebit($wallet);

    return $this;
  }

  
  public function fetch(Mage_Sales_Model_Quote_Address $address) 
  {
    $tax = $address->getWalletDebit();
    $address->addTotal(array(
      'code' => $this->getCode(),
      'title' => Mage::helper('checkout')->__('Wallet'),
      'value' => $tax
    ));
    return $this;
  }

  private function getWallet()
  {
    $_modelWallet  = Mage::getModel("cammino_wallet/wallet");
    
    
    return $_modelWallet->getWallet();
  }

}