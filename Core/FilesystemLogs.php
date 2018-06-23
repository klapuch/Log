<?php
declare(strict_types = 1);
namespace Klapuch\Log;

/**
 * Logs stored on the filesystem
 */
final class FilesystemLogs implements Logs {
	private $location;
	private $now;

	public function __construct(\SplFileInfo $location, \DateTimeInterface $now) {
		$this->location = $location;
		$this->now = $now;
	}

	public function put(Log $log): void {
		file_put_contents(
			$this->location->getPathname(),
			$this->format($log),
			LOCK_EX | FILE_APPEND
		);
	}

	private function format(Log $log): string {
		$environment = $log->environment();
		return <<<EOT
[{$this->now->format('Y-m-d H:i')}] {$log->message()}
{$log->trace()}

POST:
{$environment->post()}

GET:
{$environment->get()}

SESSION:
{$environment->session()}

COOKIE:
{$environment->cookie()}

INPUT:
{$environment->input()}

SERVER:
{$environment->server()}
EOT;
	}
}