<?php

namespace Illuminate3\Overview\Subscriber;

use Illuminate\Events\Dispatcher as Events;
use Illuminate3\Form\Element\ElementInterface;
use Illuminate3\Form\Element\Type\Choice;
use Illuminate3\Overview\Column;

/**
 *
 */
class ConvertChoiceElementToString
{
    /**
	 * Register the listeners for the subscriber.
	 *
	 * @param Events $events
	 */
	public function subscribe(Events $events)
	{
		$events->listen('overview.buildColumn', array($this, 'onBuildColumn'));
	}

	/**
	 * @param Column  $column
	 * @param ElementInterface $element
	 */
	public function onBuildColumn(Column $column, ElementInterface $element)
	{
		if (!$element instanceof Choice) {
			return;
		}

		$value = $column->getValue();
		$choices = $element->getChoices();
		$selected = array();
		foreach ($choices as $key => $label) {

			if (in_array($key, (array) $value)) {
				$selected[] = $label;
			}
		}

		$value = implode(', ', $selected);
		$column->setValue($value);
	}

}