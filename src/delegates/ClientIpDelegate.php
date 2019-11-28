<?php

namespace Hiraeth\Middleware;

use Hiraeth;
use Middlewares\ClientIp;

/**
 * {@inheritDoc}
 */
class ClientIpDelegate extends AbstractDelegate
{
	/**
	 * {@inheritDoc}
	 */
	protected static $defaultOptions = [
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
	];


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
		$instance = new ClientIp();
		$options  = $this->getOptions();

		$instance->attribute($options['attribute']);

		if ($options['proxies']) {
			$instance->proxy($options['proxies'], $options['headers']);
		}

		return $instance;
	}
}
