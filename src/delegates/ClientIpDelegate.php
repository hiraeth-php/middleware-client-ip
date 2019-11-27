<?php

namespace Hiraeth\Middleware;

use Hiraeth;
use Middlewares\ClientIp;

/**
 * {@inheritDoc}
 */
class ClientIpDelegate implements Hiraeth\Delegate
{
	/**
	 * {@inheritDoc}
	 */
	static public function getClass(): string
	{
		return ClientIp::class;
	}


	/**
	 * {@inheritDoc}
	 */
	public function __invoke(Hiraeth\Application $app): object
	{
		$instance   = new ClientIp();
		$middleware = $app->getConfig('*', 'middleware.class', NULL);
		$collection = array_search(ClientIp::class, $middleware);
		$options    = $app->getConfig($collection, 'middleware', [
			'attribute' => '_client-ip',
			'proxies'   => [],
			'headers'   => [
				'Forwarded',
				'Forwarded-For',
				'X-Forwarded',
				'X-Forwarded-For',
				'X-Cluster-Client-Ip',
				'Client-Ip'
			]
		]);

		$instance->proxy($options['proxies'], $options['headers']);

		return $instance;
	}
}
