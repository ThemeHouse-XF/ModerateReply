<?php

class ThemeHouse_ModerateReply_Install_Controller extends ThemeHouse_Install
{

    protected $_resourceManagerUrl = 'https://xenforo.com/community/resources/moderate-replies.4249/';

    protected $_minVersionId = 1020000;

    protected $_minVersionString = '1.2.0';

    protected function _getTableChanges()
    {
        return array(
            'xf_thread' => array(
                'moderate_replies_th' => 'tinyint UNSIGNED NOT NULL DEFAULT 0'
            )
        );
    }


    protected function _postInstall()
    {
        $addOn = $this->getModelFromCache('XenForo_Model_AddOn')->getAddOnById('YoYo_');
        if ($addOn) {
            $db->query("
                UPDATE xf_thread
                    SET moderate_replies_th=moderate_replies_waindigo");
        }
    }
}