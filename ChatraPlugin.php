<?php
/**
 * Chatra plugin for Craft CMS
 *
 * Powerful live chat software that helps to increase revenue and collect feedback providing an easy way for website
 * owners to talk to visitors in real time.
 *
 * @author    Superbig
 * @copyright Copyright (c) 2016 Superbig
 * @link      https://superbig.co
 * @package   Chatra
 * @since     1.0.0
 */

namespace Craft;

class ChatraPlugin extends BasePlugin
{
    /**
     * @return mixed
     */
    public function init ()
    {
        craft()->templates->hook('chatra', function (&$context) {
            if ( craft()->request->isSiteRequest() ) {
                $settings = isset($context['chatraSettings']) ? $context['chatraSettings'] : array();

                $widget = craft()->chatra->getWidgetCode($settings);

                return $widget;
            }
        });

        craft()->templates->hook('cp.users.edit.right-pane', function (&$context) {
            if ( craft()->request->isCpRequest() ) {

                $pane = craft()->chatra->getUserPane($context);

                return $pane;
            }
        });
    }

    /**
     * @return mixed
     */
    public function getName ()
    {
        return Craft::t('Chatra');
    }

    /**
     * @return mixed
     */
    public function getDescription ()
    {
        return Craft::t('Powerful live chat software that helps to increase revenue and collect feedback providing an easy way for website owners to talk to visitors in real time.');
    }

    /**
     * @return string
     */
    public function getDocumentationUrl ()
    {
        return 'https://superbig.co/plugins/chatra';
    }

    /**
     * @return string
     */
    public function getReleaseFeedUrl ()
    {
        return 'https://raw.githubusercontent.com/sjelfull/Chatra/master/releases.json';
    }

    /**
     * @return string
     */
    public function getVersion ()
    {
        return '1.0.1';
    }

    /**
     * @return string
     */
    public function getSchemaVersion ()
    {
        return '1.0.0';
    }

    /**
     * @return string
     */
    public function getDeveloper ()
    {
        return 'Superbig';
    }

    /**
     * @return string
     */
    public function getDeveloperUrl ()
    {
        return 'https://superbig.co';
    }

    /**
     * @return array
     */
    protected function defineSettings ()
    {
        return array(
            'publicApiKey' => [ AttributeType::String, 'label' => 'Public API key', 'default' => '' ],
            'secretApiKey' => [ AttributeType::String, 'label' => 'Secret API key', 'default' => '' ],
            'agents'       => [ AttributeType::Mixed, 'label' => 'Agents', 'default' => '' ],
        );
    }

    /**
     * @return mixed
     */
    public function getSettingsHtml ()
    {
        return craft()->templates->render('chatra/Chatra_Settings', array(
            'settings' => $this->getSettings()
        ));
    }

}