<?php
namespace DidUngar\BlogBundle\Services;

class PostService {
	protected $container;
	public function __construct($service_container) {
		$this->container = $service_container;
	}
	public function getPost($id_post) {
		return null; // TODO
	}
}



