<?php namespace TypiCMS\Services;

use DB;
use Route;
use Input;
use Config;
use Request;

use TypiCMS\Services\Helpers;

class Html {

	/**
	 * th
	 *
	 * @param string $field
	 * @param boolean $sortable
	 * @return string
	 */
	public function th($field, $sortable = true, $label = true)
	{
		$th[] = '<th class="' . $field . '">';
		if ($sortable) {
			$direction = 'asc';
			$iconDir = ' text-muted';
			if (Input::get('order') == $field) {
				if (Input::get('direction') == 'asc') {
					$direction = 'desc';
				}
				$iconDir = '-' . $direction;
			}
			$th[] = '<a href="?order=' . $field . '&direction=' . $direction . '">';
			$th[] = '<i class="fa fa-sort' . $iconDir . '"></i> ';
		}
		if ($label) {
			$th[] = trans('validation.attributes.' . $field);
		}
		if ($sortable) {
			$th[] = '</a>';
		}
		$th[] = '</th>';
		$th[] = "\r\n";
		return implode($th);
	}

}
