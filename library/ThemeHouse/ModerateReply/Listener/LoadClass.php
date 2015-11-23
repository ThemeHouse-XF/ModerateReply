<?php

class ThemeHouse_ModerateReply_Listener_LoadClass extends ThemeHouse_Listener_LoadClass
{

    protected function _getExtendedClasses()
    {
        return array(
            'ThemeHouse_ModerateReply' => array(
                'datawriter' => array(
                    'XenForo_DataWriter_Discussion_Thread'
                ),
                'controller' => array(
                    'XenForo_ControllerPublic_Thread',
                    'XenForo_ControllerPublic_Forum'
                ),
                'model' => array(
                    'XenForo_Model_Post',
                    'XenForo_Model_Forum'
                ),
            ),
        );
    }

    public static function loadClassDataWriter($class, array &$extend)
    {
        $extend = self::createAndRun('ThemeHouse_ModerateReply_Listener_LoadClass', $class, $extend, 'datawriter');
    }

    public static function loadClassController($class, array &$extend)
    {
        $extend = self::createAndRun('ThemeHouse_ModerateReply_Listener_LoadClass', $class, $extend, 'controller');
    }

    public static function loadClassModel($class, array &$extend)
    {
        $extend = self::createAndRun('ThemeHouse_ModerateReply_Listener_LoadClass', $class, $extend, 'model');
    }
}