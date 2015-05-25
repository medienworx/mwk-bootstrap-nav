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
 * Register the namespaces
 */
ClassLoader::addNamespaces(array
(
    'medienworx',
));


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
    // Modules
    'medienworx\ModuleMwkBootstrapNavigation'           => 'system/modules/mwk-bootstrap-nav/src/medienworx/modules/ModuleMwkBootstrapNavigation.php',
    'medienworx\ModuleMwkBootstrapCustomNavigation'     => 'system/modules/mwk-bootstrap-nav/src/medienworx/modules/ModuleMwkBootstrapCustomNavigation.php'
));

/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
    'mod_mwk_bootstrap_navigation'      		     => 'system/modules/mwk-bootstrap-nav/templates',
    'nav_mwk_bootstrap_navigation'    		         => 'system/modules/mwk-bootstrap-nav/templates'
));


