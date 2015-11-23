<?php

/**
 *
 * @see XenForo_DataWriter_Discussion_Thread
 */
class ThemeHouse_ModerateReply_Extend_XenForo_DataWriter_Discussion_Thread extends XFCP_ThemeHouse_ModerateReply_Extend_XenForo_DataWriter_Discussion_Thread
{

    /**
     *
     * @see XenForo_DataWriter_Discussion_Thread::_getFields()
     */
    protected function _getFields()
    {
        $fields = parent::_getFields();
        
        $fields['xf_thread']['moderate_replies_th'] = array(
            'type' => self::TYPE_UINT,
            'default' => 0
        );
        
        return $fields;
    }

    protected function _discussionPreSave()
    {
        parent::_discussionPreSave();
        
        $forum = $this->_getForumData();
        $canEnableDisableModerateReplies = XenForo_Model::create('XenForo_Model_Forum')->canEnableDisableModerateRepliesInForum(
            $forum);
        
        if (isset($GLOBALS['XenForo_ControllerPublic_Thread'])) {
            /* @var $controller XenForo_ControllerPublic_Thread */
            $controller = $GLOBALS['XenForo_ControllerPublic_Thread'];
            
            $input = $controller->getInput()->filter(
                array(
                    'moderate_replies_th' => XenForo_Input::UINT,
                    '_set' => XenForo_Input::ARRAY_SIMPLE,
                    'set' => XenForo_Input::ARRAY_SIMPLE
                ));
            
            if ((!empty($input['set']['moderate_replies_th']) ||
                 !empty($input['_set']['moderate_replies_th'])) && $canEnableDisableModerateReplies) {
                $this->set('moderate_replies_th', $input['moderate_replies_th']);
            }
        }
        
        if (isset($GLOBALS['XenForo_ControllerPublic_Forum'])) {
            /* @var $controller XenForo_ControllerPublic_Forum */
            $controller = $GLOBALS['XenForo_ControllerPublic_Forum'];
            
            $input = $controller->getInput()->filter(
                array(
                    'moderate_replies_th' => XenForo_Input::UINT,
                    '_set' => XenForo_Input::ARRAY_SIMPLE
                ));
            
            if ((!empty($input['_set']['moderate_replies_th'])) && $canEnableDisableModerateReplies) {
                $this->set('moderate_replies_th', $input['moderate_replies_th']);
            }
        }
    }
}