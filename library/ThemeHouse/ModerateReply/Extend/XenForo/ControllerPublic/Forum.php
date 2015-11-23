<?php

/**
 *
 * @see XenForo_ControllerPublic_Forum
 */
class ThemeHouse_ModerateReply_Extend_XenForo_ControllerPublic_Forum extends XFCP_ThemeHouse_ModerateReply_Extend_XenForo_ControllerPublic_Forum
{

    /**
     *
     * @see XenForo_ControllerPublic_Forum::actionCreateThread()
     */
    public function actionCreateThread()
    {
        $response = parent::actionCreateThread();
        
        if ($response instanceof XenForo_ControllerResponse_View) {
            if (isset($response->params['forum'])) {
                $forum = $response->params['forum'];
                $response->params['canEnableDisableModerateReplies'] = $this->_getForumModel()->canEnableDisableModerateRepliesInForum(
                    $forum);
            }
        }
        
        return $response;
    }

    /**
     *
     * @see XenForo_ControllerPublic_Forum::actionAddThread()
     */
    public function actionAddThread()
    {
        $GLOBALS['XenForo_ControllerPublic_Forum'] = $this;
        
        return parent::actionAddThread();
    }
}