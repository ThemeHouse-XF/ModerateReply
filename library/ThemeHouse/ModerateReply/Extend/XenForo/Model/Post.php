<?php

/**
 *
 * @see XenForo_Model_Post
 */
class ThemeHouse_ModerateReply_Extend_XenForo_Model_Post extends XFCP_ThemeHouse_ModerateReply_Extend_XenForo_Model_Post
{

    public function getPostInsertMessageState(array $thread, array $forum, array $nodePermissions = null, 
        array $viewingUser = null)
    {
        $this->standardizeViewingUserReferenceForNode($forum['node_id'], $viewingUser, $nodePermissions);
        
        if ($viewingUser['user_id'] && XenForo_Permission::hasContentPermission($nodePermissions, 'approveUnapprove')) {
            // do nothing
        } elseif ($viewingUser['user_id'] &&
             XenForo_Permission::hasContentPermission($nodePermissions, 'enableModerateReplies')) {
            // do nothing
        } elseif (XenForo_Permission::hasPermission($viewingUser['permissions'], 'general', 'followModerationRules')) {
            if (!empty($thread['thread_id']) && $thread['moderate_replies_th']) {
                return 'moderated';
            }
        }
        
        return parent::getPostInsertMessageState($thread, $forum, $nodePermissions, $viewingUser);
    }
}