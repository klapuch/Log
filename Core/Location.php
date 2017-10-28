<?php
declare(strict_types = 1);
namespace Klapuch\Log;

interface Location {
	/**
	 * Path to the location
	 * @return \SplFileInfo
	 */
	public function path(): \SplFileInfo;
}