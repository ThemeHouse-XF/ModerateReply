<?php

/**
 *
 * @see XenForo_Model_Forum
 */
class ThemeHouse_ModerateReply_Extend_XenForo_Model_Forum extends XFCP_ThemeHouse_ModerateReply_Extend_XenForo_Model_Forum
{

    /**
     * Determines if a moderation of replies in a thread can be enabled or
     * disabled in the specified forum with the given permissions.
     *
     * @param array $forum
     * @param string $errorPhraseKey
     * @param array|null $nodePermissions
     * @param array|null $viewingUser
     *
     * @return boolean
     */
    public function canEnableDisableModerateRepliesInForum(array $forum, &$errorPhraseKey = '', 
        array $nodePermissions = null, array $viewingUser = null)
    {
        $this->standardizeViewingUserReferenceForNode($forum['node_id'], $viewingUser, $nodePermissions);
        
        if (!$viewingUser['user_id']) {
            return false;
        }

        if ($forum['moderate_replies']) {
            return false;
        }
        
        return XenForo_Permission::hasContentPermission($nodePermissions, 'enableModerateReplies');
    }
}