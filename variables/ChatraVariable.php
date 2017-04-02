<?php
/**
 * Chatra plugin for Craft CMS
 *
 * Chatra Variable
 *
 * @author    Superbig
 * @copyright Copyright (c) 2016 Superbig
 * @link      https://superbig.co
 * @package   Chatra
 * @since     1.0.0
 */

namespace Craft;

class ChatraVariable
{
    /**
     */
    public function widget ($settings = [ ])
    {
        $widget = craft()->chatra->getWidgetCode($settings);

        return $widget;
    }
}