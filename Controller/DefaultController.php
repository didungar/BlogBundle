<?php

namespace DidUngar\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use DidUngar\BlogBundle\Services\PostService;

class DefaultController extends Controller
{
    /**
     * @Route("/articles/{id_post}-{slug}.html", name="DidBlog_Article")
     * @Template()
     */
    public function getPostAction($id_post, $slug)
    {
	$oPostService = new PostService($this->get('service_container'));
	$oPost = $oPostService->getPost($id_post);
        return ['oPost'=>$oPost,];
    }
    /**
     * @Route("/articles", name="DidBlog_Articles")
     * @Template()
     */
    public function getPostsAction()
    {
	$oPostService = new PostService($this->get('service_container'));
	$aPosts = $oPostService->getPosts();
        return ['aPosts'=>$aPosts,];
    }
    /**
     * @Route("/author/{id_author}.html")
     * @Template()
     */
    public function getAuthorAction($id_author)
    {
	$em = $this->getDoctrine()->getManager();
	$repAuthors = $em->getRepository('DidUngarBlogBundle:Author');
	$oAuthor = $repAuthors->find($id_author);

        return ['oAuthor'=>$oAuthor,];
    }
    /**
     * @Route("/author/{id_post}-{name}.html")
     * @Template()
     */
    public function getAuthorNameAction($id_author, $name)
    {
        return $this->getAuthorAction($id_author);
    }
}
