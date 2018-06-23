<?php
declare(strict_types = 1);
namespace Klapuch\Log;

/**
 * Logs stored on the filesystem
 */
final class FilesystemLogs implements Logs {
	private $location;

	public function __construct(\SplFileInfo $location) {
		$this->location = $location;
	}

	public function put(\Throwable $exception, Environment $environment): void {
		file_put_contents(
			$this->location->getPathname(),
			$this->format($exception, $environment, new \DateTimeImmutable()),
			LOCK_EX | FILE_APPEND
		);
	}

	private function format(\Throwable $exception, Environment $environment, \DateTimeInterface $now): string {
		return <<<TXT
[{$now->format('Y-m-d H:i')}] {$exception->getMessage()}
{$exception->getTraceAsString()}

POST:
{$this->dump($environment->post())}

GET:
{$this->dump($environment->get())}

SESSION:
{$this->dump($environment->session())}

COOKIE:
{$this->dump($environment->cookie())}

INPUT:
{$environment->input()}

SERVER:
{$this->dump($environment->server())}
TXT;
	}

	private function dump(array $expression): string {
		return var_export($expression, true);
	}
}