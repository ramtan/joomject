<?php


defined('_JEXEC') or die;

class LinkProtectHelper{

	public $params = null;

	public function __construct($params = null){
		$this->params = $params;
	}

	public function replaceLinks(){

		$link = $matches[2];
		if(strpos($link, JUri::root())){
			return $link;
		}else{
			$warningPage = $this->params->get('warning_page');
			$external = base64_encode($link);
			$newLink = 'href="'.JRoute::_(ContentHelpRoute::getArticleRoute($warningPage).'&external='.$external.'"');
			return $newLink;
		}

	}


	public function leaveSite($article, $external){
		$target  = $this->params->get('new_window') ? 'target="_blank"' : '';
		$link = base64_decode($external);
		$article->text = str_ireplace('{linkprotecturl}', '<a href="'.$link.'"'.$target.'</a>', $article->text);
	}

}

