<?php

if(!defined('_PS_VERSION_')){
	exit;
}

class mdav extends PaymentModule{

 public function __construct()  {
	$this->name='mdav';
	$this->tab='payments_gateways';
	$this->version='1.0';
	$this->author='MANZI DAVID';
	$this->controllers = array('payment', 'validation', 'callback');
	parent::__construct();
	$this->displayName=$this->l('Dave gateway');
	$this->description=$this->l('Pay cashless trial');
	$this->confirmUninstall=$this->l('SURE? TO UNINSTALL');
    $this->currencies = true;
    $this->currencies_mode= 'checkbox';
	$this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
    $this->bootstrap= true;
	$this->need_instance = 0;
 }

public function install()
{
 if (!parent::install() || !$this->registerHook('payment') || !$this->registerHook('displayPaymentReturn')) {
	 return false;
 }
 return true;
}

public function uninstall()
{
 if (!parent::uninstall() ||!Configuration::deleteByName('mdav') ) {
 return false;
 }
 return true;
}

 public function hookPayment($params){
		 if (!$this->active)
			 return;
		 if (!$this->checkCurrency($params['cart']))
			 return;
  		 $this->context->smarty->assign(
			 array(
				 'this_path' => $this->_path,
				 'this_path_mdav' => $this->_path,
				 //'my_module_link' => $this->context->link->getModuleLink('ipaymodule', 'display'),
				 'this_path_ssl' => Tools::getShopDomainSsl(true, true).__PS_BASE_URI__.'modules/'.$this->name.'/'
			 )
		 );
		 return $this->display(__FILE__, 'payment.tpl');  
	 }
	
public function getContent(){
	$html = '';
	$html .= '
	<form action="'.$_SERVER['REQUEST_URI'].'" method="post" class="defaultForm form-horizontal">
	 <div class="panel">
	 <div class="panel-heading">'.$this->l('Settings').'</div>
	 ';

	 $html .='
	 <div class="form-group">
	  <label class="control-label col-lg-3">'.$this->l('MDAV').'</label>
	   <div class="col-lg-6">
	   <input type="text" name="t1"/>
	   </div>
	   </div>
		';

	  $html .='
	  <input type="submit" name="submitUpdate" value="'.$this->l('Save').'" class="btn btn-default">
     ';

     $html .='

	 </div>
	 </form>
	';
	return $html;
}	
}
