<?php
/**
 * @package     Joomla.Plugin
 * @subpackage  Content.Contact
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

class PlgContentLinkprotect extends JPlugin{


	public function __construct(&$subject, $config = array()){

		parent::__construct($subject , $config);

		require_once __DIR__.'/helper/helper.php';
		$helper = new LinkProtectHelper($this->params);
	}



	// Initiate the plugin
	public function onContentBeforeDisplay($context, $article, $params){

		$parts = explode(".", $context);
		if($parts[0] != 'com_content'){
			return;
		}

		if(stripos($article->text, '{linkprotect=off}') === true){
			$article->text = str_ireplace('{linkprotect=off}', '', $article->text);
		}

		$app = JFactory::getApplication();
		$external = $app->input->get('external', NULL);

		if($external){
			LinkProtectHelper::leaveSite($article , $external);
		}else{
			$pattern = '@href=("|\)(https?://([-\w\.]+)+(:\d+)?(/([\w/_\.]*(\?\S+)?)?)?)("|\')@';
			$article->text = preg_replace_callback($pattern, $this->callbackFunction, $article->text);
		}


	}

}



?>