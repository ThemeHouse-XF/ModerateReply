<?php

/**
 *
 * @see XenForo_ControllerPublic_Thread
 */
class ThemeHouse_ModerateReply_Extend_XenForo_ControllerPublic_Thread extends XFCP_ThemeHouse_ModerateReply_Extend_XenForo_ControllerPublic_Thread
{

    /**
     *
     * @see XenForo_ControllerPublic_Thread::actionIndex()
     */
    public function actionIndex()
    {
        $response = parent::actionIndex();
        
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
     * @see XenForo_ControllerPublic_Thread::actionAddReply()
     */
    public function actionAddReply()
    {
        $response = parent::actionAddReply();
        
        if ($response instanceof XenForo_ControllerResponse_Redirect) {
            $xenOptions = XenForo_Application::get('options');
            
            if ($xenOptions->th_moderateReplies_moderateMessage) {
                $message = $response->redirectMessage;
                if ($message instanceof XenForo_Phrase && $message->getPhraseName() == 'your_message_has_been_posted') {
                    $target = XenForo_Link::getCanonicalLinkPrefix() .
                         XenForo_Link::convertUriToAbsoluteUri($response->redirectTarget);
                    $result = $this->parseRouteUrl($target);
                    if ($result) {
                        $match = $result['match'];
                        $controllerName = $match->getControllerName();
                        if ($controllerName == 'XenForo_ControllerPublic_Thread') {
                            $response->redirectMessage = new XenForo_Phrase('message_submitted_displayed_pending_approval');
                        } elseif ($controllerName == 'XenForo_ControllerPublic_Post') {
                            $post = $this->_getPostModel()->getPostById($result['params']['post_id']);
                            if ($post['message_state'] == 'moderated') {
                                $response->redirectMessage = new XenForo_Phrase('message_submitted_displayed_pending_approval');
                            }
                        }
                    }
                }
            }
        }
        
        return $response;
    }

    /**
     *
     * @see XenForo_ControllerPublic_Thread::actionEdit()
     */
    public function actionEdit()
    {
        $response = parent::actionEdit();
        
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
     * @see XenForo_ControllerPublic_Thread::actionSave()
     */
    public function actionSave()
    {
        $GLOBALS['XenForo_ControllerPublic_Thread'] = $this;
        
        return parent::actionSave();
    }

    /**
     *
     * @see XenForo_ControllerPublic_Thread::actionQuickUpdate()
     */
    public function actionQuickUpdate()
    {
        $GLOBALS['XenForo_ControllerPublic_Thread'] = $this;
        
        return parent::actionQuickUpdate();
    }

    protected function _updateModeratorLogThreadEdit(array $thread, XenForo_DataWriter_Discussion_Thread $dw, 
        array $skip = array())
    {
        $newData = $dw->getMergedNewData();
        if ($newData) {
            $oldData = $dw->getMergedExistingData();
            $basicLog = array();
            
            foreach ($newData as $key => $value) {
                $oldValue = (isset($oldData[$key]) ? $oldData[$key] : '-');
                switch ($key) {
                    case 'moderate_replies_th':
                        XenForo_Model_Log::logModeratorAction('thread', $thread, 
                            ($value ? 'enable_moderate_replies' : 'disable_moderate_replies'));
                        $skip[] = 'moderate_replies_th';
                        break;
                }
            }
        }
        
        return parent::_updateModeratorLogThreadEdit($thread, $dw, $skip);
    }
}