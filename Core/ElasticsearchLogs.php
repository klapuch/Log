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
	private $now;

	public function __construct(
		Elasticsearch\Client $elasticsearch,
		\DateTimeInterface $now
	) {
		$this->elasticsearch = $elasticsearch;
		$this->now = $now;
	}

	public function put(Log $log): void {
		$this->elasticsearch->index(self::OPTIONS + ['body' => $this->body($log)]);
	}

	private function body(Log $log): array {
		$environment = $log->environment();
		return [
			'logged_at' => $this->now->format('Y-m-d H:i'),
			'message' => $log->message(),
			'trace' => $log->trace(),
			'cookie' => $environment->cookie(),
			'get' => $environment->get(),
			'input' => $environment->input(),
			'post' => $environment->post(),
			'server' => $environment->server(),
			'session' => $environment->session(),
		];
	}
}