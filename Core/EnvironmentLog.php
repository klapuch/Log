<?php
declare(strict_types = 1);
namespace Klapuch\Log;

final class EnvironmentLog implements Log {
	private $environment;

	public function __construct(Environment $environment) {
		$this->environment = $environment;
	}

	public function content(): array {
		return [
			'logged_at' => (new \DateTimeImmutable())->format('Y-m-d H:i:s'),
			'cookie' => $this->environment->cookie(),
			'get' => $this->environment->get(),
			'input' => $this->environment->input(),
			'post' => $this->environment->post(),
			'server' => $this->environment->server(),
			'session' => $this->environment->session(),
		];
	}
}