<?php
declare(strict_types = 1);
namespace Klapuch\Log;

use Elasticsearch;

/**
 * Logs stored in elasticsearch
 */
final class ElasticsearchLogs implements Logs {
	private const OPTIONS = [
		'index' => 'logs',
		'type' => 'pile',
	];
	private $elasticsearch;

	public function __construct(Elasticsearch\Client $elasticsearch) {
		$this->elasticsearch = $elasticsearch;
	}

	public function put(\Throwable $exception, Environment $environment, \DateTimeInterface $now): void {
		$this->elasticsearch->index(self::OPTIONS + ['body' => $this->body($exception, $environment, $now)]);
	}

	private function body(\Throwable $exception, Environment $environment, \DateTimeInterface $now): array {
		return [
			'logged_at' => $now->format('Y-m-d H:i'),
			'message' => $exception->getMessage(),
			'trace' => $exception->getTraceAsString(),
			'cookie' => $environment->cookie(),
			'get' => $environment->get(),
			'input' => $environment->input(),
			'post' => $environment->post(),
			'server' => $environment->server(),
			'session' => $environment->session(),
		];
	}
}