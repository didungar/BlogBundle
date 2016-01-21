<?php

namespace DidUngar\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use DidUngar\BlogBundle\Services\PostService;

class DefaultController extends Controller
{
    /**
     * @Route("/{id_post}-{slug}.html")
     * @Template()
     */
    public function getPostAction($id_post, $slug)
    {
	$oPostService = new PostService($this->get('service_container'));
	$oPost = $oPostService->getPost($id_post);
        return ['oPost'=>$oPost,];
    }
}
