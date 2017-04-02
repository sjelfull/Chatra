<?php
/**
 * Chatra plugin for Craft CMS
 *
 * Chatra Model
 *
 * @author    Superbig
 * @copyright Copyright (c) 2016 Superbig
 * @link      https://superbig.co
 * @package   Chatra
 * @since     1.0.0
 */

namespace Craft;

class ChatraModel extends BaseModel
{
    /**
     * @return array
     */
    protected function defineAttributes ()
    {
        return array_merge(parent::defineAttributes(), array(
            'clientId' => array( AttributeType::String, 'default' => null, 'required' => true ),
        ));
    }

}