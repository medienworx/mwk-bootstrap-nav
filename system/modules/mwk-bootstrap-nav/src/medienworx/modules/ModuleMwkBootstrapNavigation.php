<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2015 - 2015 Agentur medienworx
 *
 * @package     mwk-bootstrap-nav
 * @author      Christian Kienzl <christian.kienzl@medienworx.eu>
 * @author      Peter Ongyert <peter.ongyert@medienworx.eu>
 * @link        http://www.medienworx.eu
 * @license     http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */

/**
 * Run in a custom namespace, so the class can be replaced
 */

namespace medienworx;

/**
 * Class ModuleMwkAssociationContent
 * @package medienworx
 */
class ModuleMwkBootstrapNavigation extends \Module
{

    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'mod_mwk_bootstrap_navigation';

    /**
     * Display a wildcard in the back end
     * @return string
     */
    public function generate()
    {
        if (TL_MODE == 'BE') {
            $objTemplate = new \BackendTemplate('be_wildcard');
            $objTemplate->title = '### BOOTSTRAP NAVIGATION ###';
            $objTemplate->wildcard = '';
            return $objTemplate->parse();
        }
        return parent::generate();
    }

    /**
     * start function
     */
    protected function compile()
    {
        global $objPage;

        $this->navigationTpl = 'nav_mwk_bootstrap_navigation';

        // Set the trail and level
        if ($this->defineRoot && $this->rootPage > 0)
        {
            $trail = array($this->rootPage);
            $level = 0;
        }
        else
        {
            $trail = $objPage->trail;
            $level = ($this->levelOffset > 0) ? $this->levelOffset : 0;
        }

        $lang = null;
        $host = null;

        // Overwrite the domain and language if the reference page belongs to a differnt root page (see #3765)
        if ($this->defineRoot && $this->rootPage > 0) {
            $objRootPage = \PageModel::findWithDetails($this->rootPage);

            // Set the language
            if ($GLOBALS['TL_CONFIG']['addLanguageToUrl'] && $objRootPage->rootLanguage != $objPage->rootLanguage) {
                $lang = $objRootPage->rootLanguage;
            }

            // Set the domain
            if ($objRootPage->rootId != $objPage->rootId && $objRootPage->domain != '' && $objRootPage->domain != $objPage->domain) {
                $host = $objRootPage->domain;
            }
        }
        $this->Template->request = ampersand(\Environment::get('indexFreeRequest'));
        $this->Template->skipId = 'skipNavigation' . $this->id;
        $this->Template->skipNavigation = specialchars($GLOBALS['TL_LANG']['MSC']['skipNavigation']);
        $this->Template->items = $this->renderNavigationBS($trail[$level], 1, $host, $lang);

        $dataOffsetTop = ($this->bootstrap_data_offset_top != '' && $this->bootstrap_affix == 1)?' data-offset-top="'.$this->bootstrap_data_offset_top.'"':'';
        $dataOffsetBottom = ($this->bootstrap_data_offset_bottom != '' && $this->bootstrap_affix == 1)?' data-offset-bottom="'.$this->bootstrap_data_offset_bottom.'"':'';

        $this->Template->bootstrapNavigationType = ' '.$this->bootstrap_navigation_type;
        $this->Template->bootstrapNavigationInverse = ($this->bootstrap_inverse == 1)?' navbar-inverse':'';

        $this->Template->bootstrapAffix = ($this->bootstrap_affix == 1)?'data-spy="affix"':'';
        $this->Template->bootstrapDataOffsetTop = $dataOffsetTop;
        $this->Template->bootstrapDataOffsetBottom = $dataOffsetBottom;

        $this->Template->bootstrapExtraCss = ' '.$this->bootstrap_extra_css;
        $this->Template->mobileMenu = $this->getMobileMenu($this->bootstrap_mobile_menu);

        $this->Template->bootstrapNavbarAlign = ' '.$this->bootstrap_navbar_align;
        $this->Template->bootstrapInverse = $this->bootstrap_inverse;

        $this->Template->bootstrapAutoHighLight = $this->bootstrap_autohilight;
        $this->Template->brand = $this->getBrand($this->bootstrap_logo_img, $this->bootstrap_logo_alt, $this->bootstrap_logo_url);

        \MwkCoreHelper::insertScriptToGlobals('/system/modules/mwk-bootstrap-nav/assets/bootstrap/css/bootstrap.min.css');
        \MwkCoreHelper::insertScriptToGlobals('/system/modules/mwk-bootstrap-nav/assets/jquery/1.11.2/jquery.min.js');
        \MwkCoreHelper::insertScriptToGlobals('/system/modules/mwk-bootstrap-nav/assets/bootstrap/js/bootstrap.min.js');
		//\MwkCoreHelper::insertScriptToGlobals('/system/modules/mwk-bootstrap-nav/assets/font-awesome/css/font-awesome.min.css');
    }

    /**
     * Recursively compile the navigation menu and return it as HTML string
     * @param integer
     * @param integer
     * @param string
     * @param string
     * @return string
     */
    protected function renderNavigationBS($pid, $level=1, $host=null, $language=null)
    {
        // Get all active subpages
        $objSubpages = \PageModel::findPublishedSubpagesWithoutGuestsByPid($pid, $this->showHidden, $this instanceof \ModuleSitemap);

        if ($objSubpages === null) {
            return '';
        }

        $items = array();
        $groups = array();

        // Get all groups of the current front end user
        if (FE_USER_LOGGED_IN) {
            $this->import('FrontendUser', 'User');
            $groups = $this->User->groups;
        }

        // Layout template fallback
        if ($this->navigationTpl == '') {
            $this->navigationTpl = 'nav_default';
        }

        $objTemplate = new \FrontendTemplate($this->navigationTpl);

        $objTemplate->type = get_class($this);
        $objTemplate->cssID = $this->cssID; // see #4897
        $objTemplate->level = 'level_' . $level++;

        $dataOffsetTop = ($this->bootstrap_data_offset_top != '' && $this->bootstrap_affix == 1)?' data-offset-top="'.$this->bootstrap_data_offset_top.'"':'';
        $dataOffsetBottom = ($this->bootstrap_data_offset_bottom != '' && $this->bootstrap_affix == 1)?' data-offset-bottom="'.$this->bootstrap_data_offset_bottom.'"':'';

        $objTemplate->bootstrapNavigationType = ' '.$this->bootstrap_navigation_type;
        $objTemplate->bootstrapNavigationInverse = ($this->bootstrap_inverse == 1)?' navbar-inverse':'';

        $objTemplate->bootstrapAffix = ($this->bootstrap_affix == 1)?'data-spy="affix"':'';
        $objTemplate->bootstrapDataOffsetTop = $dataOffsetTop;
        $objTemplate->bootstrapDataOffsetBottom = $dataOffsetBottom;

        $objTemplate->bootstrapExtraCss = ' '.$this->bootstrap_extra_css;
        $objTemplate->mobileMenu = $this->getMobileMenu($this->bootstrap_mobile_menu);

        $objTemplate->bootstrapNavbarAlign = ' '.$this->bootstrap_navbar_align;
        $objTemplate->bootstrapInverse = $this->bootstrap_inverse;

        $objTemplate->bootstrapAutoHighLight = $this->bootstrap_autohilight;
        $objTemplate->brand = $this->getBrand($this->bootstrap_logo_img, $this->bootstrap_logo_alt, $this->bootstrap_logo_url);



        // Get page object
        global $objPage;

        // Browse subpages
        while ($objSubpages->next()) {
            // add cssClass
            #$objTemplate->cssClass = $this->cssClass;

            // Skip hidden sitemap pages
            if ($this instanceof \ModuleSitemap && $objSubpages->sitemap == 'map_never') {
                continue;
            }

            $subitems = '';
            $_groups = deserialize($objSubpages->groups);

            // Override the domain (see #3765)
            if ($host !== null) {
                $objSubpages->domain = $host;
            }

            // Do not show protected pages unless a back end or front end user is logged in
            if (!$objSubpages->protected || BE_USER_LOGGED_IN || (is_array($_groups) && count(array_intersect($_groups, $groups))) || $this->showProtected || ($this instanceof \ModuleSitemap && $objSubpages->sitemap == 'map_always')) {
                // Check whether there will be subpages
                if ($objSubpages->subpages > 0 && (!$this->showLevel || $this->showLevel >= $level || (!$this->hardLimit && ($objPage->id == $objSubpages->id || in_array($objPage->id, $this->Database->getChildRecords($objSubpages->id, 'tl_page')))))) {
                    $subitems = $this->renderNavigation($objSubpages->id, $level, $host, $language);
                }

                // Get href
                switch ($objSubpages->type) {
                    case 'redirect':
                        $href = $objSubpages->url;

                        if (strncasecmp($href, 'mailto:', 7) === 0) {
                            $href = \String::encodeEmail($href);
                        }
                        break;

                    case 'forward':
                        if ($objSubpages->jumpTo) {
                            $objNext = $objSubpages->getRelated('jumpTo');
                        } else {
                            $objNext = \PageModel::findFirstPublishedRegularByPid($objSubpages->id);
                        }

                        if ($objNext !== null) {
                            $strForceLang = null;
                            $objNext->loadDetails();

                            // Check the target page language (see #4706)
                            if ($GLOBALS['TL_CONFIG']['addLanguageToUrl']) {
                                $strForceLang = $objNext->language;
                            }

                            $href = $this->generateFrontendUrl($objNext->row(), null, $strForceLang);

                            // Add the domain if it differs from the current one (see #3765)
                            if ($objNext->domain != '' && $objNext->domain != \Environment::get('host')) {
                                $href = (\Environment::get('ssl') ? 'https://' : 'http://') . $objNext->domain . TL_PATH . '/' . $href;
                            }
                            break;
                        }
                    // DO NOT ADD A break; STATEMENT

                    default:
                        $href = $this->generateFrontendUrl($objSubpages->row(), null, $language);

                        // Add the domain if it differs from the current one (see #3765)
                        if ($objSubpages->domain != '' && $objSubpages->domain != \Environment::get('host')) {
                            $href = (\Environment::get('ssl') ? 'https://' : 'http://') . $objSubpages->domain . TL_PATH . '/' . $href;
                        }
                        break;
                }

                // Active page
                if (($objPage->id == $objSubpages->id || $objSubpages->type == 'forward' && $objPage->id == $objSubpages->jumpTo) && !$this instanceof \ModuleSitemap && !\Input::get('articles')) {
                    // Mark active forward pages (see #4822)
                    $strClass = (($objSubpages->type == 'forward' && $objPage->id == $objSubpages->jumpTo) ? 'forward' . (in_array($objSubpages->id, $objPage->trail) ? ' trail' : '') : 'active') . (($subitems != '') ? ' submenu' : '') . ($objSubpages->protected ? ' protected' : '') . (($objSubpages->cssClass != '') ? ' ' . $objSubpages->cssClass : '');
                    $row = $objSubpages->row();

                    $row['isActive'] = true;
                    $row['subitems'] = $subitems;
                    $row['class'] = trim($strClass);
                    $row['cssClass'] = trim($objSubpages->cssClass);
                    $row['title'] = specialchars($objSubpages->title, true);
                    $row['pageTitle'] = specialchars($objSubpages->pageTitle, true);
                    $row['link'] = $objSubpages->title;
                    $row['href'] = $href;
                    $row['nofollow'] = (strncmp($objSubpages->robots, 'noindex', 7) === 0);
                    $row['target'] = '';
                    $row['description'] = str_replace(array("\n", "\r"), array(' ', ''), $objSubpages->description);

                    // Override the link target
                    if ($objSubpages->type == 'redirect' && $objSubpages->target) {
                        $row['target'] = ($objPage->outputFormat == 'xhtml') ? ' onclick="return !window.open(this.href)"' : ' target="_blank"';
                    }

                    $items[] = $row;
                } // Regular page
                else {
                    $strClass = (($subitems != '') ? 'submenu' : '') . ($objSubpages->protected ? ' protected' : '') . (in_array($objSubpages->id, $objPage->trail) ? ' trail' : '') . (($objSubpages->cssClass != '') ? ' ' . $objSubpages->cssClass : '');

                    // Mark pages on the same level (see #2419)
                    if ($objSubpages->pid == $objPage->pid) {
                        $strClass .= ' sibling';
                    }

                    $row = $objSubpages->row();

                    $row['isActive'] = false;
                    $row['subitems'] = $subitems;
                    $row['class'] = trim($strClass);
                    $row['cssClass'] = trim($objSubpages->cssClass);
                    $row['title'] = specialchars($objSubpages->title, true);
                    $row['pageTitle'] = specialchars($objSubpages->pageTitle, true);
                    $row['link'] = $objSubpages->title;
                    $row['href'] = $href;
                    $row['nofollow'] = (strncmp($objSubpages->robots, 'noindex', 7) === 0);
                    $row['target'] = '';
                    $row['description'] = str_replace(array("\n", "\r"), array(' ', ''), $objSubpages->description);

                    // Override the link target
                    if ($objSubpages->type == 'redirect' && $objSubpages->target) {
                        $row['target'] = ($objPage->outputFormat == 'xhtml') ? ' onclick="return !window.open(this.href)"' : ' target="_blank"';
                    }

                    $items[] = $row;
                }
            }
        }

        // Add classes first and last
        if (!empty($items)) {
            $last = count($items) - 1;

            $items[0]['class'] = trim($items[0]['class'] . ' first');
            $items[$last]['class'] = trim($items[$last]['class'] . ' last');
        }

        $objTemplate->items = $items;
        return !empty($items) ? $objTemplate->parse() : '';
    }

    /**
     * @param $showMobileMenu
     * @return string
     */
    private function getMobileMenu($showMobileMenu)
    {
        if ($showMobileMenu == 1) {
            return '<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>';
        }
    }

    /**
     * @param $bootstrap_logo_img
     * @param $bootstrap_logo_alt
     * @param $bootstrap_logo_url
     * @return string
     */
    private function getBrand($bootstrap_logo_img, $bootstrap_logo_alt, $bootstrap_logo_url)
    {
        if ($bootstrap_logo_img) {
            $bootstrap_logo_url = ($bootstrap_logo_url == '')?'#':$bootstrap_logo_url;
            $listRow = \String::binToUuid($bootstrap_logo_img);
            $configData = \FilesModel::findByUuid($listRow);
            return '<a class="navbar-brand" href="'.$bootstrap_logo_url.'">
                    <img alt="'.$bootstrap_logo_alt.'" src="'.$configData->path.'">
                </a>';
        }
    }

}