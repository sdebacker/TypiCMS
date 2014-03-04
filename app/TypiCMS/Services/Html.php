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
	public function th($field, $sortable = true)
	{
		if ($sortable) {
			$direction = 'asc';
			$iconDir = ' text-muted';
			if (Input::get('order') == $field) {
				if (Input::get('direction') == 'asc') {
					$direction = 'desc';
				}
				$iconDir = '-' . $direction;
			}
			$th[] = "\r\n" . '						<a href="?order=' . $field . '&direction=' . $direction . '">';
			$th[] = '							<i class="fa fa-sort' . $iconDir . '"></i>';
		}
		$th[] = '							' . trans('validation.attributes.' . $field);
		if ($sortable) {
			$th[] = '						</a>' . "\r\n" . '					';
		}
		return implode("\r\n", $th);
	}

}
