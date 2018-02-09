<?php
/**
 * NewRelic plugin for Magento
 *
 * @package     Yireo_NewRelic
 * @author      Yireo (https://www.yireo.com/)
 * @copyright   Copyright 2016 Yireo (https://www.yireo.com/)
 * @license     Simplified BSD License
 */

/**
 * Class Yireo_NewRelic_Model_Observer
 */
class Yireo_NewRelic_Model_Observer
{
    /**
     * Listen to the event adminhtml_cache_flush_all
     *
     * @param Varien_Event_Observer $observer
     *
     * @return $this
     * @deprecated Use Yireo_NewRelic_Model_Observer_Adminhtml_Cache_FlushAll::execute()
     */
    public function adminhtmlCacheFlushAll(Varien_Event_Observer $observer)
    {
        return $this;
    }

    /**
     * Listen to the event adminhtml_cache_flush_system
     *
     * @param Varien_Event_Observer $observer
     *
     * @return $this
     * @deprecated Use Yireo_NewRelic_Model_Observer_Adminhtml_Cache_FlushSystem::execute()
     */
    public function adminhtmlCacheFlushSystem(Varien_Event_Observer $observer)
    {
        return $this;
    }

    /**
     * Listen to the event adminhtml_cache_refresh_type
     *
     * @param Varien_Event_Observer $observer
     *
     * @return $this
     * @deprecated Use Yireo_NewRelic_Model_Observer_Adminhtml_Cache_RefreshType::execute()
     */
    public function adminhtmlCacheRefreshType(Varien_Event_Observer $observer)
    {
        return $this;
    }

    /**
     * Listen to the event controller_action_postdispatch_adminhtml_process_reindexProcess
     *
     * @param Varien_Event_Observer $observer
     *
     * @return $this
     * @deprecated Use Yireo_NewRelic_Model_Observer_Adminhtml_Process_ReindexProcess::execute()
     */
    public function controllerActionPostdispatchAdminhtmlProcessReindexProcess(Varien_Event_Observer $observer)
    {
        return $this;
    }

    /**
     * Listen to the event controller_action_postdispatch_adminhtml_process_massReindex
     *
     * @param Varien_Event_Observer $observer
     *
     * @return $this
     * @deprecated Use Yireo_NewRelic_Model_Observer_Adminhtml_Process_ReindexProcess::execute()
     */
    public function controllerActionPostdispatchAdminhtmlProcessMassReindex(Varien_Event_Observer $observer)
    {
        return $this;
    }

    /**
     * Listen to the event controller_action_predispatch
     *
     * @param Varien_Event_Observer $observer
     *
     * @return $this
     * @deprecated Use Yireo_NewRelic_Model_Observer_Initialise::execute()
     */
    public function controllerActionPredispatch(Varien_Event_Observer $observer)
    {
        if (!$this->_isEnabled()) {
            return $this;
        }

        $this->_setupAppName();
        $this->_trackControllerAction($observer->getEvent()->getControllerAction());

        // Ignore Apdex for Magento Admin Panel pages
//        if (Mage::app()->getStore()->isAdmin()) {
//            if(function_exists('newrelic_ignore_apdex')) {
//                newrelic_ignore_apdex();
//            }
//        }

        // Common settings
        if(function_exists('newrelic_capture_params')) {
            newrelic_capture_params(true);
        }

        return $this;
    }

    /**
     * Method to setup the app-name
     *
     * @return $this
     */
    protected function _setupAppName() 
    {
        $helper = $this->_getHelper();
        $appname = trim($helper->getAppName());
        $license = trim($helper->getLicense());
        $xmit = $helper->isUseXmit();

        if (!empty($appname) && function_exists('newrelic_set_appname')) {
            newrelic_set_appname($appname, $license, $xmit);
        }

        return $this;
    }

    /**
     * Method to track the controller-action
     *
     * @param Mage_Core_Controller_Front_Action $action
     * @return $this
     */
    protected function _trackControllerAction($action) 
    {
        if (!$this->_getHelper()->isTrackController()) {
            return $this;
        }

        $actionName = $action->getFullActionName('/');
        if (function_exists('newrelic_name_transaction')) {
            newrelic_name_transaction($actionName);
        }

        return $this;
    }

    /**
     * Post dispatch observer for user tracking
     *
     * @param Varien_Event_Observer $observer
     *
     * @return $this
     * @deprecated Use Yireo_NewRelic_Model_Observer_AddRequestData::execute()
     */
    public function controllerActionPostdispatch(Varien_Event_Observer $observer)
    {
        return $this;
    }

    /**
     * Listen to the event model_save_after
     *
     * @param Varien_Event_Observer $observer
     *
     * @return $this
     * @deprecated Use Yireo_NewRelic_Model_Observer_Model_SaveAfter::execute()
     */
    public function modelSaveAfter(Varien_Event_Observer $observer)
    {
        return $this;
    }

    /**
     * Listen to the event model_delete_after
     *
     * @param Varien_Event_Observer $observer
     *
     * @return $this
     * @deprecated Use Yireo_NewRelic_Model_Observer_Model_DeleteAfter::execute()
     */
    public function modelDeleteAfter(Varien_Event_Observer $observer)
    {
        return $this;
    }

    /**
     * Listen to the cron event always
     *
     * @param Varien_Event_Observer $observer
     *
     * @return $this
     * @deprecated Use Yireo_NewRelic_Model_Observer_Crontab::execute()
     */
    public function crontab($observer)
    {
        return $this;
    }
}
