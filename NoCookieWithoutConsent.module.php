<?php namespace ProcessWire;

/**
 * Class to prevent ProcessWire to set frontend cookies without users consent.
 * Autoloaded with ProcessWire and with almost zero configuration.
 */
class NoCookieWithoutConsent extends WireData implements Module {
	/**
  	* Add hook after page render to inject cookie consent dialogue on frontend pages.
  	* @return void
  	*/
	public function ready() : void {
    	// Include cookie consent dialogue on frontend pages only.
		if ($this->page->template == 'admin') return;
		$this->addHookAfter('Page::render', $this, 'process');
  	}

	/**
	 * Access ProcessWire API to overwrite $config->sessionAllow.
	 * @return void
 	*/
	 public function wired() : void {
		$config = $this->wire()->config;
		if (!empty($config)) $config->sessionAllow = function($session) {
			return $this->allowSession($session);
		};
	}

	/**
	 * Hook to allow or disable frontend sessions by this module.
	 * @param \ProcessWire\Session $session
	 * @return bool
	 */
	public function ___allowSession($session) {
		$config = $this->wire()->config;
		$pages = $this->wire()->pages;

		// Always allow sessions if a valid session already exists.
		if (!empty($session) && $session->hasCookie()) return true;

		// Always allow session for backend pages.
		$adminPath = $pages->getPath($config->adminRootPageID);
		if (isset($_SERVER['REQUEST_URI']) && strpos($_SERVER['REQUEST_URI'], $adminPath) > 0) return true;

		// Allow session if user gave consent to use frontend cookies.
		if (array_key_exists('nocowoco', $_COOKIE) && $_COOKIE['nocowoco'] == 'allow_necessary') return true;

		// Disable frontend session.
		return false;
	}

	/**
	 * Display Cookie Consent dialogue on all frontend templates.
	 * @param \ProcessWire\HookEvent $event
	 */
	protected function process(HookEvent $event) : void {
		// Only proceed if modules javascript and CSS files exists.
		$html = $this->addModuleFilesToHead($event->return);
		if ($html == $event->return) return;

		// Inject Cookie Consent template to end of body tag.
		$html = str_replace('</body>', $this->getTemplate(), $html);
		$event->return = $html;
  	}

	/**
	 * Helper method to add required module CSS and Javascript files into page head.
	 * @param string $html
	 * @return string
	 */
	private function addModuleFilesToHead(string $html) : string {
		// Only proceed if module files exist.
		if (!is_readable(__DIR__ . DIRECTORY_SEPARATOR . 'js' . DIRECTORY_SEPARATOR . 'nocowoco.js')) return $html;
		if (!is_readable(__DIR__ . DIRECTORY_SEPARATOR . 'css' . DIRECTORY_SEPARATOR . 'nocowoco.css')) return $html;

		// Inject required module CSS into pages <head> section.
		$cssPath = basename(__DIR__) . '/css/nocowoco.css';
		$jsPath = basename(__DIR__) . '/js/nocowoco.js';

		$cssLink = "<link rel='stylesheet' type='text/css' href='{$this->config->urls->siteModules}{$cssPath}' />";
		$jsLink = "<script defer src='{$this->config->urls->siteModules}{$jsPath}'></script>";

		$html = str_replace('</head>', $cssLink . "\n" . $jsLink . "\n</head>", $html); 
		return $html;
	}

	/**
	 * Helper method to get content of module template file.
	 * @return string Template HTML.
	 */
	private function getTemplate() : string {
		$templatePath = __DIR__ . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'CookieConsentDialogue.tpl.php';
		if (is_readable($templatePath)) {
			include $templatePath;
			if (isset($template)) {
				return "{$template}\n</body>";
			}
		}
		return '</body>';
	}
}