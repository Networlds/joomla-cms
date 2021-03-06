<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_contact
 *
 * @copyright   Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * Contact component helper.
 *
 * @package     Joomla.Administrator
 * @subpackage  com_contact
 * @since       1.6
 */
class ContactHelper
{
	/**
	 * Configure the Linkbar.
	 *
	 * @param	string	$vName	The name of the active view.
	 *
	 * @return	void
	 * @since	1.6
	 */
	public static function addSubmenu($vName)
	{
		JHtmlSidebar::addEntry(
			JText::_('COM_CONTACT_SUBMENU_CONTACTS'),
			'index.php?option=com_contact&view=contacts',
			$vName == 'contacts'
		);
		JHtmlSidebar::addEntry(
			JText::_('COM_CONTACT_SUBMENU_CATEGORIES'),
			'index.php?option=com_categories&extension=com_contact',
			$vName == 'categories'
		);

		if ($vName == 'categories')
		{
			JToolbarHelper::title(
				JText::sprintf('COM_CATEGORIES_CATEGORIES_TITLE', JText::_('com_contact')),
				'contact-categories');
		}
	}

	/**
	 * Gets a list of the actions that can be performed.
	 *
	 * @param	int		The category ID.
	 * @param	int		The contact ID.
	 *
	 * @return	JObject
	 * @since	1.6
	 */
	public static function getActions($categoryId = 0, $contactId = 0)
	{
		$user	= JFactory::getUser();
		$result	= new JObject;

		if (empty($contactId) && empty($categoryId)) {
			$assetName = 'com_contact';
			$level = 'component';
		}
		elseif (empty($contactId)) {
			$assetName = 'com_contact.category.'.(int) $categoryId;
			$level = 'category';
		}
		else {
			$assetName = 'com_contact.contact.'.(int) $contactId;
			$level = 'category';
		}

		$actions = JAccess::getActions('com_contact', $level);

		foreach ($actions as $action) {
			$result->set($action->name,	$user->authorise($action->name, $assetName));
		}

		return $result;
	}

	public static function getAssociations($pk)
	{
		$associations = array();
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->from('#__contact_details as c');
		$query->innerJoin('#__associations as a ON a.id = c.id AND a.context='.$db->quote('com_contact.item'));
		$query->innerJoin('#__associations as a2 ON a.key = a2.key');
		$query->innerJoin('#__contact_details as c2 ON a2.id = c2.id');
		$query->innerJoin('#__categories as ca ON c2.catid = ca.id AND ca.extension = '.$db->quote('com_contact'));
		$query->where('c.id =' . (int) $pk);
		$select = array(
			'c2.language',
			$query->concatenate(array('c2.id', 'c2.alias'), ':') . ' AS id',
			$query->concatenate(array('ca.id', 'ca.alias'), ':') . ' AS catid'
		);
		$query->select($select);
		$db->setQuery($query);
		$contactitems = $db->loadObjectList('language');

		// Check for a database error.
		if ($error = $db->getErrorMsg()) {
			JError::raiseWarning(500, $error);
			return false;
		}

		foreach ($contactitems as $tag => $item) {
			$associations[$tag] = $item;
		}

		return $associations;
	}
}
