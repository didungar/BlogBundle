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
	public function getPosts(array $aArgs = []) {
		$iFirstResult = 0;
		$iMaxResults = 10;
		$em = $this->container->get('doctrine')->getManager();
		$query = $em->createQuery(
			    'SELECT p
			    FROM DidUngarBlogBundle:Post p
			    ORDER BY p.dateAdd DESC'
			)
			->setFirstResult($iFirstResult)
                	->setMaxResults($iMaxResults);

		return $query->getResult();//$em->getRepository('DidUngarBlogBundle:Post')->findBy([],['dateAdd'=>'DESC']);
	}
}



