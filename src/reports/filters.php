<?php
/**
 * @package      Tjreports
 * @subpackage   com_api
 *
 * @author       Techjoomla <extensions@techjoomla.com>
 * @copyright    Copyright (C) 2009 - 2018 Techjoomla. All rights reserved.
 * @license      GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

/**
 * Tjreports API report class
 *
 * @since  1.0.0
 */
class ReportsApiResourceFilters extends ApiResource
{
	/**
	 * Function get filters data
	 *
	 * @return boolean
	 */
	public function get()
	{
		$app         = JFactory::getApplication();
		$jinput      = $app->input;
		$reportName  = $jinput->getString('id');

		if (!isset($reportName))
		{
			ApiError::raiseError(400, JText::_('PLG_API_REPORTS_REPORT_NAME_MISSSING'), 'APIValidationException');
		}

		JLoader::import('plugins.tjreports.' . $reportName . "." . $reportName, JPATH_SITE);
		$className = 'TjreportsModel' . ucfirst($reportName);

		if (!class_exists($className))
		{
			ApiError::raiseError(400, JText::_('PLG_API_REPORTS_REPORT_NAME_INVALID'), 'APIValidationException');
		}

		$reportPlugin = new $className;

		$filters = $reportPlugin->displayFilters();

		$this->plugin->setResponse($filters);
	}
}
