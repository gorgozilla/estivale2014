<?php
/**
 * Joomla! System plugin - jQuery Fancybox
 *
 * @author Yireo (info@yireo.com)
 * @copyright Copyright 2014 Yireo.com. All rights reserved
 * @license GNU Public License
 * @link http://www.yireo.com
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

// Import the parent class
jimport( 'joomla.plugin.plugin' );

/**
 * Fancybox System Plugin
 */
class plgSystemFancybox extends JPlugin
{
    /**
     * Event onAfterRender
     *
     * @access public
     * @param null
     * @return null
     */
    public function onAfterDispatch()
    {
        // Dot not load if this is not the right document-class
        $document = JFactory::getDocument();
        if($document->getType() != 'html') {
            return false;
        }

        // Perform actions on the frontend
        $application = JFactory::getApplication();
        if($application->isSite()) {

            $elements = $this->getElements();
            if(empty($elements)) return null;

            // Get and parse the components from the plugin parameters
            $components = $this->getParams()->get('exclude_components');
            if(empty($components)) {
                $components= array();
            } elseif(!is_array($components)) {
                $components = array($components);
            }

            // Don't do anything if the current component is excluded
            if(in_array(JRequest::getCmd('option'), $components)) {
                return;
            }

            $js_folder = 'media/plg_fancybox/js/';
            $transition = $this->getParams()->get('transition', '');
            $namespace = $this->getParams()->get('namespace', '');

            $this->loadStylesheet('jquery.fancybox.css', $this->getParams()->get('load_css', 1));
            $this->jquery();

            // Load CSS and JavaScript
            $this->loadStylesheet('jquery.fancybox-buttons.css', $this->getParams()->get('load_buttons', 0));
            $this->loadStylesheet('jquery.fancybox-thumbs.css', $this->getParams()->get('load_thumbs', 0));
            $this->loadScript('jquery.fancybox.pack.js', $this->getParams()->get('load_fancybox', 1));
            $this->loadScript('jquery.mousewheel-3.0.6.pack.js', $this->getParams()->get('load_mousewheel', 0));
            $this->loadScript('jquery.fancybox-buttons.js', $this->getParams()->get('load_buttons', 0));
            $this->loadScript('jquery.fancybox-media.js', $this->getParams()->get('load_media', 0));
            $this->loadScript('jquery.fancybox-thumbs.js', $this->getParams()->get('load_thumbs', 0));

            // Construct basic options
            $options = array(
            );

            // Enable mouse-wheel
            $options['mouseWheel'] = true;
            if($this->getParams()->get('enable_mousewheel', 0) == 0) {
                $options['mouseWheel'] = false;
            }

            // Determine the content-type
            $content_type = $this->getParams()->get('content_type');
            if(!empty($content_type)) {
                $options['type'] = $content_type;
            }

            if(!in_array($transition, array('', 'fade', 'elastic', 'none'))) {
            
                $this->loadScript('jquery.easing-1.3.pack.js', $this->getParams()->get('load_easing', 1));

                if(in_array($transition, array('swing', 'linear'))) {
                    $options['openEasing'] = $transition;
                    $options['closeEasing'] = $transition;
                } else {
                    $options['openEasing'] = 'easeInOut'.ucfirst($transition);
                    $options['closeEasing'] = 'easeInOut'.ucfirst($transition);
                }

                $options['openSpeed'] = $this->getParams()->get('speed', 200);
                $options['closeSpeed'] = $this->getParams()->get('speed', 200);
                $options['nextSpeed'] = $this->getParams()->get('speed', 200);
                $options['prevSpeed'] = $this->getParams()->get('speed', 200);

            } else {
                $options['openEffect'] = $transition;
                $options['closeEffect'] = $transition;
                $options['nextEffect'] = $transition;
                $options['prevEffect'] = $transition;
                $options['openSpeed'] = $this->getParams()->get('speed', 200);
                $options['closeSpeed'] = $this->getParams()->get('speed', 200);
                $options['nextSpeed'] = $this->getParams()->get('speed', 200);
                $options['prevSpeed'] = $this->getParams()->get('speed', 200);
            }

            // Load the extra options
            $extraOptions = trim($this->getParams()->get('options'));
            if(!empty($extraOptions)) {
                $extraOptions = explode("\n", $extraOptions);
                foreach($extraOptions as $extraOption) {
                    $extraOption = explode('=', $extraOption);
                    if(!empty($extraOption[0]) && !empty($extraOption[1])) {
                        $options[$extraOption[0]] = trim($extraOption[1]);
                    }
                }
            }

            // Sanitize the options
            foreach($options as $name => $value) {
                if(is_bool($value)) {
                    $bool = ($value) ? "true" : "false";
                    $options[$name] = "'$name':$bool";
                } elseif(is_numeric($value)) {
                    $options[$name] = "'$name':$value";
                } elseif(empty($value)) {
                    unset($options[$name]);
                } else {
                    if($value != 'true' && $value != 'false') $value = "'$value'";
                    if($value == "'true'") $value = 'true';
                    if($value == "'false'") $value = 'false';
                    $options[$name] = "'$name':$value";
                }
            }

            // Helper options
            $helpers = array();

            // Overlay helper
            $closeClick = (bool)$this->getParams()->get('hide_on_click', true);
            $closeClick = ($closeClick) ? 'true' : 'false';
            $helpers[] = 'overlay: {closeClick:'.$closeClick.'}';

            // Buttons helper
            if($this->getParams()->get('load_buttons', 0) == 1) {
                $options[] = 'closeBtn: false';
                $helpers[] = 'buttons: {}';
            }

            // Media helper
            if($this->getParams()->get('load_media', 0)) {
                $helpers[] = 'media: {}';
            }

            // Thumbs helper
            if($this->getParams()->get('load_thumbs', 0)) {
                $helpers[] = 'thumbs: {width:50, height:50}';
            }

            $options[] = 'helpers: {'.implode(', ', $helpers).'}';

            // Construct the script-lines
            $script_lines = array('<!--//--><![CDATA[//><!--');
            if(empty($namespace)) {
                $script_lines[] = 'jQuery.noConflict();';
                $script_lines[] = 'jQuery(document).ready(function() {';
                foreach($elements as $element) {
                    $script_lines[] = 'if(jQuery("'.$element.'")) { jQuery("'.$element.'").fancybox({'.implode(",", $options).'}); }';
                }

            } else {
                $script_lines[] = $namespace.' = jQuery.noConflict();';
                $script_lines[] = $namespace.'(document).ready(function() {';
                foreach($elements as $element) {
                    $script_lines[] = $namespace.'("'.$element.'").fancybox({'.implode(',', $options).'});';
                }
            }
            $script_lines[] = '});';
            $script_lines[] = '//--><!]]>';

            // Add the script-declaration
            $document = JFactory::getDocument();
            $document->addScriptDeclaration(implode("\n", $script_lines)); 

        }
    }

    /**
     * Load a script
     *
     * @access private
     * @param null
     * @return null
     */
    private function loadScript($file = null, $condition = true)
    {
        $condition = (bool)$condition;
        if($condition == true) {

            if(preg_match('/^jquery-([0-9\.]+).min.js$/', $file, $match) && $this->getParams()->get('use_google_api', 0) == 1) {

                if(JURI::getInstance()->isSSL() == true) {
                    $script = 'https://ajax.googleapis.com/ajax/libs/jquery/'.$match[1].'/jquery.min.js';
                } else {
                    $script = 'http://ajax.googleapis.com/ajax/libs/jquery/'.$match[1].'/jquery.min.js';
                }

                JFactory::getDocument()->addScript($script);
                return;
            }

            $folder = 'media/plg_fancybox/js/';

            // Check for overrides
            $template = JFactory::getApplication()->getTemplate();
            if(file_exists(JPATH_SITE.'/templates/'.$template.'/html/plg_fancybox/js/'.$file)) {
                $folder = 'templates/'.$template.'/html/plg_fancybox/js/';
            }

            JFactory::getDocument()->addScript($folder.$file);
        }
    }

    /**
     * Load a stylesheet
     *
     * @access private
     * @param null
     * @return null
     */
    private function loadStylesheet($file = null, $condition = true)
    {
        $condition = (bool)$condition;
        if($condition == true) {

            $folder = 'media/plg_fancybox/css/';

            // Check for overrides
            $template = JFactory::getApplication()->getTemplate();
            if(file_exists(JPATH_SITE.'/templates/'.$template.'/html/plg_fancybox/css/'.$file)) {
                $folder = 'templates/'.$template.'/html/plg_fancybox/css/';
            }

            JFactory::getDocument()->addStylesheet($folder.$file);
        }
    }

    /**
     * Load the parameters
     *
     * @access private
     * @param null
     * @return JParameter
     */
    private function getParams()
    {
        jimport('joomla.version');
        $version = new JVersion();
        if(version_compare($version->RELEASE, '1.5', 'eq')) {
            $plugin = JPluginHelper::getPlugin('system', 'fancybox');
            $params = new JParameter($plugin->params);
            return $params;
        } else {
            return $this->params;
        }
    }

    /**
     * Get the HTML elements
     *
     * @access private
     * @param null
     * @return JParameter
     */
    private function getElements()
    {
        $elements = $this->getParams()->get('elements');
        $elements = trim($elements);
        $elements = explode(",", $elements);
        if(!empty($elements)) {
            foreach($elements as $index => $element) {
                $element = trim($element);
                $element = preg_replace('/([^a-zA-Z0-9\[\]\=\-\_\.\#\ ]+)/', '', $element);
                if(empty($element)) {
                    unset($elements[$index]);
                } else {
                    $elements[$index] = $element;
                }
            }
        }

        return $elements;
    }

    /**
     * Simple method to load jQuery
     *
     * @access private
     * @param null
     * @return JParameter
     */
    private function jquery()
    {
        JLoader::import( 'joomla.version' );
        $version = new JVersion();
        if (version_compare( $version->RELEASE, '2.5', '<=')) {
            if(JFactory::getApplication()->get('jquery') == false) {
                $this->loadScript('jquery-1.9.0.min.js', $this->getParams()->get('load_jquery', 1));
                JFactory::getApplication()->set('jquery', true);
            }
        } else {
            JHtml::_('jquery.framework');
        }
    }
}

