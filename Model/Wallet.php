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

class Cammino_Wallet_Model_Wallet extends Mage_Core_Model_Abstract {


  /**
  * @var singleton $_session Carrega singleton de sessao do magento.
  */
  private $_session;

  protected $_canAuthorize = true;
  protected $_canCapture = true;
  protected $_canCapturePartial = false;
  
  protected $_code          = 'cammino_wallet';
  protected $_formBlockType = 'cammino_wallet/form';
  protected $_infoBlockType = 'cammino_wallet/info';

  /**
  * Método que popula variaveis privadas para serem utilizadas.
  *
  * @return void
  */
  function __construct() {
    parent::__construct();
    
    $this->_session = Mage::getSingleton('core/session');
    $this->_init('cammino_wallet/wallet');
  }


  /**
  * Retorna id do cliente caso ele esteja logado.
  *
  * @return Int|Boolean id do cliente ou false.
  **/
  protected function getCustomerId()
  {
    $_customerSession = Mage::getSingleton('customer/session');
    
    if ($_customerSession->isLoggedIn())
      return $_customerSession->getCustomer()->getId();

    return false;
  }

  /**
  * Retorna id do cliente caso ele esteja logado.
  *
  * @return Collection|Boolean collection da wallet e caso não exista retorna false.
  **/
  public function getWallet()
  {

    $customerId = $this->getCustomerId();
    
    if ($customerId) {
      $_wallet = Mage::getModel('cammino_wallet/wallet')->getCollection()
        ->addFieldToFilter('entity_id', array('eq' => $customerId));

      return $_wallet->getFirstItem();
    }
    
    return false;
  }

}