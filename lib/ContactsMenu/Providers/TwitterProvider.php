<?php

/**
 * @copyright 2017 Christoph Wurst <christoph@winzerhof-wurst.at>
 *
 * @author 2017 Christoph Wurst <christoph@winzerhof-wurst.at>
 *
 * @license GNU AGPL version 3 or any later version
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 */

namespace OCA\ContactsMenuSocial\ContactsMenu\Providers;

use OCP\Contacts\ContactsMenu\IActionFactory;
use OCP\Contacts\ContactsMenu\IEntry;
use OCP\Contacts\ContactsMenu\IProvider;
use OCP\IURLGenerator;

/**
 * @todo move to contacts app
 */
class TwitterProvider implements IProvider {

	/** @var IActionFactory */
	private $actionFactory;

	/** @var IURLGenerator */
	private $urlGenerator;

	/**
	 * @param IActionFactory $actionFactory
	 * @param IURLGenerator $urlGenerator
	 */
	public function __construct(IActionFactory $actionFactory, IURLGenerator $urlGenerator) {
		$this->actionFactory = $actionFactory;
		$this->urlGenerator = $urlGenerator;
	}

	/**
	 * @param IEntry $entry
	 */
	public function process(IEntry $entry) {
		$social = $entry->getProperty('X-SOCIALPROFILE');

		if (is_null($social) || !isset($social['TWITTER'])) {
			return;
		}

		$iconUrl = $this->urlGenerator->getAbsoluteURL($this->urlGenerator->imagePath('core', 'places/contacts-dark.svg'));
		// TODO: handle different formats, like @user and full URLs
		$twitterHandle = $social['TWITTER'];
		$url = "https://twitter.com/$twitterHandle";
		$entry->addAction($this->actionFactory->newLinkAction($iconUrl, 'Twitter profile', $url));
	}

}
