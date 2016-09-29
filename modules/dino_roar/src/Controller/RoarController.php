<?php 

namespace Drupal\dino_roar\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\dino_roar\Jurassic\RoarGenerator;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Logger\LoggerChannelFactory;
use Drupal\Core\Logger\LoggerChannelFactoryInterface;

class RoarController extends ControllerBase
{

	/*
	* @var RoarGenerator
	*/
	private $roarGenerator;

	public function __construct(RoarGenerator $roarGenerator, LoggerChannelFactoryInterface $loggerFactory)
	{
		$this->roarGenerator = $roarGenerator;
		$this->loggerFactory = $loggerFactory;
	}

	public static function create(ContainerInterface $container)
	{
		$roarGenerator = $container->get('dino_roar.roar_generator');
		$loggerFactory = $container->get('logger.factory');

		return new static($roarGenerator, $loggerFactory);
	}

	public function roar($count)
	{
		//$roarGenerator = new RoarGenerator();
		$roar = $this->roarGenerator->getRoar($count);
		$this->loggerFactory->get('default')
			->debug($roar);

		return new Response($roar);
	}
}