<?php
namespace DidUngar\BlogBundle\Services;

class PostService {
	protected $container;
	public function __construct($service_container) {
		$this->container = $service_container;
	}
	public function getPost($id_post) {
		if ( ! is_numeric($id_post) ) {
			throw new \Exception('$id_post not a number');
		}
		$em = $this->container->get('doctrine')->getManager();
		return $em->getRepository('DidUngarBlogBundle:Post')->findOneBy(
			['id'=>$id_post]
		);
	}
}



