<?php
declare(strict_types = 1);
namespace Klapuch\Log;

/**
 * Location to the directory
 */
final class DirectoryLocation implements Location {
	private $file;

	public function __construct(\SplFileInfo $file) {
		$this->file = $file;
	}

	public function path(): \SplFileInfo {
		if (!$this->file->isReadable()) {
			throw new \InvalidArgumentException(
				sprintf(
					'Path to directory "%s" does not exist',
					$this->file
				)
			);
		} elseif (!$this->file->isDir() || !$this->file->isWritable()) {
			throw new \InvalidArgumentException(
				sprintf(
					'"%s" is not a directory or is not writable',
					$this->file
				)
			);
		}
		return $this->file;
	}
}