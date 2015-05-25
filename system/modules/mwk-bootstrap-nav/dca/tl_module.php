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

$GLOBALS['TL_DCA']['tl_module']['palettes']['mwk_bootstrap_navigation'] = '
    {title_legend},
        name,
        headline,
        type;
	{bootstrap_configuration},
        bootstrap_navigation_type,
        bootstrap_extra_css,
        bootstrap_navbar_align,
        bootstrap_mobile_menu;
    {bootstrap_options:hide},
        bootstrap_inverse;

	{logo_headline},
        bootstrap_logo_img,
        bootstrap_logo_alt,
        bootstrap_logo_url;
	{affix_headline},
        bootstrap_affix,
        bootstrap_data_offset_top,
        bootstrap_data_offset_bottom;
    {nav_legend},
        levelOffset,
        showLevel,
        hardLimit,
        showProtected;
    {reference_legend:hide},
        defineRoot;
    {protected_legend:hide},
        protected;
    {expert_legend:hide},
        guests,
        cssID,
        space
    ';

$GLOBALS['TL_DCA']['tl_module']['palettes']['mwk_bootstrap_custom_navigation'] = '
    {title_legend},
        name,
        headline,
        type,
        bootstrap_navigation_type,
        bootstrap_extra_css;
    {bootstrap_options_headline},
        bootstrap_mobile_menu,
        bootstrap_navbar_align,
        bootstrap_inverse,
        bootstrap_autohilight,
        bootstrap_logo_img,
        bootstrap_logo_alt,
        bootstrap_logo_url,
        bootstrap_affix,
        bootstrap_data_offset_top,
        bootstrap_data_offset_bottom;
    {nav_legend},
        pages,
        showProtected;
    {template_legend:hide},
        navigationTpl;
    {protected_legend:hide},
        protected;
    {expert_legend:hide},
        guests,
        cssID,
        space
    ';

$GLOBALS['TL_DCA']['tl_module']['fields']['bootstrap_navigation_type'] =
    array
    (
        'label'                   => &$GLOBALS['TL_LANG']['tl_module']['bootstrap_navigation_type'],
        'inputType'               => 'select',
        'options'                 => array(
            /*'bootstrap_tab',
            'bootstrap_pills',
            'bootstrap_pills_stacked',
            'bootstrap_tab_justified',
            'bootstrap_pills',
            'bootstrap_pills_justified',*/
            'navbar-default' 		=> 'bootstrap_navbar',
            'navbar-fixed-top' 		=> 'bootstrap_navbar_fixed_top',
            'navbar-fixed-bottom' 	=> 'bootstrap_navbar_fixed_bottom',
            'navbar-static-top' 	=> 'bootstrap_navbar_static_top'
        ),
        'reference'               => &$GLOBALS['TL_LANG']['tl_module'],
        'eval'                    => array('submitOnChange'=>true, 'tl_class'=>'w50'),
        'sql'                     => "varchar(32) NOT NULL default ''"
    );

$GLOBALS['TL_DCA']['tl_module']['fields']['bootstrap_navbar_align'] =
    array
    (
        'label'                   => &$GLOBALS['TL_LANG']['tl_module']['bootstrap_navbar_align'],
        'inputType'               => 'select',
        'options'                 => array(
            'navbar-left' => 'bootstrap_navbar_left',
            'navbar-right' => 'bootstrap_navbar_right'
        ),
		'eval'					  => array('tl_class' => 'w50'),
        'reference'               => &$GLOBALS['TL_LANG']['tl_module'],
        'sql'                     => "varchar(32) NOT NULL default ''"
    );

$GLOBALS['TL_DCA']['tl_module']['fields']['bootstrap_inverse'] =
    array
    (
        'label'                   => &$GLOBALS['TL_LANG']['tl_module']['bootstrap_inverse'],
        'inputType'               => 'checkbox',
		'eval'					  => array('tl_class' => 'w50'),
        'sql'                     => "int(1) NOT NULL default '0'"
    );

$GLOBALS['TL_DCA']['tl_module']['fields']['bootstrap_mobile_menu'] =
    array
    (
        'label'                   => &$GLOBALS['TL_LANG']['tl_module']['bootstrap_mobile_menu'],
        'inputType'               => 'checkbox',
		'eval'					  => array('tl_class' => 'w50 m12'),
        'sql'                     => "int(1) NOT NULL default '1'"
    );

$GLOBALS['TL_DCA']['tl_module']['fields']['bootstrap_autohilight'] =
    array
    (
        'label'                   => &$GLOBALS['TL_LANG']['tl_module']['bootstrap_autohilight'],
        'inputType'               => 'checkbox',
		'eval'					  => array('tl_class' => 'w50'),
        'sql'                     => "int(1) NOT NULL default '1'"
    );

$GLOBALS['TL_DCA']['tl_module']['fields']['bootstrap_logo_img'] =
    array
    (
        'label'                   => &$GLOBALS['TL_LANG']['tl_module']['bootstrap_logo_img'],
        'exclude'                 => true,
        'inputType'               => 'fileTree',
        'eval'                    => array('filesOnly'=>true, 'fieldType'=>'radio', 'tl_class'=>'clr'),
        'sql'                     => "binary(16) NULL",
        'load_callback' => array
        (
            array('tl_mwk_module', 'setSingleSrcFlags')
        ),
        'save_callback' => array
        (
            array('tl_mwk_module', 'storeFileMetaInformation')
        )
    );

$GLOBALS['TL_DCA']['tl_module']['fields']['bootstrap_logo_alt'] =
    array
    (
        'label'                   => &$GLOBALS['TL_LANG']['tl_module']['bootstrap_logo_alt'],
        'exclude'                 => true,
        'search'                  => true,
        'inputType'               => 'text',
        'eval'                    => array('maxlength'=>255, 'tl_class'=>'w50'),
        'sql'                     => "varchar(255) NOT NULL default ''"
    );

$GLOBALS['TL_DCA']['tl_module']['fields']['bootstrap_logo_url'] =
    array
    (
        'label'                   => &$GLOBALS['TL_LANG']['tl_module']['bootstrap_logo_url'],
        'exclude'                 => true,
        'search'                  => true,
        'inputType'               => 'text',
        'eval'                    => array('rgxp'=>'url', 'decodeEntities'=>true, 'maxlength'=>255, 'tl_class'=>'w50 wizard'),
        'wizard' => array
        (
            array('tl_mwk_module', 'pagePicker')
        ),
        'sql'                     => "varchar(255) NOT NULL default ''"
    );

$GLOBALS['TL_DCA']['tl_module']['fields']['bootstrap_affix'] =
    array
    (
        'label'                   => &$GLOBALS['TL_LANG']['tl_module']['bootstrap_affix'],
        'inputType'               => 'checkbox',
        'eval'					  => array('tl_class' => 'long'),
        'sql'                     => "int(1) NOT NULL default '0'"
    );

$GLOBALS['TL_DCA']['tl_module']['fields']['bootstrap_data_offset_top'] =
    array
    (
        'label'                   => &$GLOBALS['TL_LANG']['tl_module']['bootstrap_data_offset_top'],
        'inputType'               => 'text',
        'eval'                    => array('tl_class'=>'w50'),
        'sql'                     => "varchar(255) NOT NULL default ''"
    );

$GLOBALS['TL_DCA']['tl_module']['fields']['bootstrap_data_offset_bottom'] =
    array
    (
        'label'                   => &$GLOBALS['TL_LANG']['tl_module']['bootstrap_data_offset_bottom'],
        'inputType'               => 'text',
        'eval'                    => array('tl_class'=>'w50'),
        'sql'                     => "varchar(255) NOT NULL default ''"
    );

$GLOBALS['TL_DCA']['tl_module']['fields']['bootstrap_extra_css'] =
    array
    (
        'label'                   => &$GLOBALS['TL_LANG']['tl_module']['bootstrap_extra_css'],
        'exclude'                 => true,
        'search'                  => true,
        'inputType'               => 'text',
        'eval'                    => array('maxlength'=>255, 'tl_class'=>'w50'),
        'sql'                     => "varchar(255) NOT NULL default ''"
    );

/**
 * Class tl_mwk_module
 */
class tl_mwk_module extends \Backend
{
    /**
     * Return the link picker wizard
     * @param \DataContainer
     * @return string
     */
    public function pagePicker(DataContainer $dc)
    {
        return ' <a href="contao/page.php?do=' . Input::get('do') . '&amp;table=' . $dc->table . '&amp;field=' . $dc->field . '&amp;value=' . str_replace(array('{{link_url::', '}}'), '', $dc->value) . '" title="' . specialchars($GLOBALS['TL_LANG']['MSC']['pagepicker']) . '" onclick="Backend.getScrollOffset();Backend.openModalSelector({\'width\':768,\'title\':\'' . specialchars(str_replace("'", "\\'", $GLOBALS['TL_LANG']['MOD']['page'][0])) . '\',\'url\':this.href,\'id\':\'' . $dc->field . '\',\'tag\':\'ctrl_'. $dc->field . ((Input::get('act') == 'editAll') ? '_' . $dc->id : '') . '\',\'self\':this});return false">' . Image::getHtml('pickpage.gif', $GLOBALS['TL_LANG']['MSC']['pagepicker'], 'style="vertical-align:top;cursor:pointer"') . '</a>';
    }

    /**
     * Dynamically add flags to the "singleSRC" field
     * @param mixed
     * @param \DataContainer
     * @return mixed
     */
    public function setSingleSrcFlags($varValue, DataContainer $dc)
    {
        if ($dc->activeRecord)
        {
            switch ($dc->activeRecord->type)
            {
                case 'text':
                case 'hyperlink':
                case 'image':
                case 'accordionSingle':
                    $GLOBALS['TL_DCA'][$dc->table]['fields'][$dc->field]['eval']['extensions'] = Config::get('validImageTypes');
                    break;

                case 'download':
                    $GLOBALS['TL_DCA'][$dc->table]['fields'][$dc->field]['eval']['extensions'] = Config::get('allowedDownload');
                    break;
            }
        }

        return $varValue;
    }

    /**
     * Pre-fill the "alt" and "caption" fields with the file meta data
     * @param mixed
     * @param \DataContainer
     * @return mixed
     */
    public function storeFileMetaInformation($varValue, DataContainer $dc)
    {
        if ($dc->activeRecord->singleSRC == $varValue)
        {
            return $varValue;
        }

        $objFile = \FilesModel::findByUuid($varValue);

        if ($objFile !== null)
        {
            $arrMeta = deserialize($objFile->meta);

            if (!empty($arrMeta))
            {
                $objPage = $this->Database->prepare("SELECT * FROM tl_page WHERE id=(SELECT pid FROM " . ($dc->activeRecord->ptable ?: 'tl_article') . " WHERE id=?)")
                    ->execute($dc->activeRecord->pid);

                if ($objPage->numRows)
                {
                    $objModel = new PageModel();
                    $objModel->setRow($objPage->row());
                    $objModel->loadDetails();

                    // Convert the language to a locale (see #5678)
                    $strLanguage = str_replace('-', '_', $objModel->rootLanguage);

                    if (isset($arrMeta[$strLanguage]))
                    {
                        \Input::setPost('alt', $arrMeta[$strLanguage]['title']);
                        \Input::setPost('caption', $arrMeta[$strLanguage]['caption']);
                    }
                }
            }
        }

        return $varValue;
    }

}