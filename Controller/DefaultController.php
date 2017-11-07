<?php

namespace DidUngar\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DefaultController extends Controller
{
	/**
	 * @Route("/articles/{id_post}-{slug}.html", name="DidBlog_Article")
	 * @Template()
	 */
	public function getPostAction($id_post, $slug)
	{
		$oPostService = $this->get('didungar_blog_post_service');
		$oPost = $oPostService->getPost($id_post);
		$aData = ['oPost' => $oPost,];
		if ($this->getParameter('DidUngarBlogBundle_DateService')) {
			$sDateService = $this->getParameter('DidUngarBlogBundle_DateService');
			$aData['oDateService'] = new $sDateService($this->get('service_container'));
		}
		if ($this->getParameter('DidUngarBlogBundle_getPostTpl')) {
			return $this->render($this->getParameter('DidUngarBlogBundle_getPostTpl'), $aData);
		}

		return $aData;
	}

	/**
	 * @Route("/articles", name="DidBlog_Articles")
	 * @Route("/articles/")
	 * @Template()
	 */
	public function getPostsAction()
	{
		$oPostService = $this->get('didungar_blog_post_service');
		$aPosts = $oPostService->getPosts();
		$aData = ['aPosts' => $aPosts,];
		if ($this->getParameter('DidUngarBlogBundle_DateService')) {
			$sDateService = $this->getParameter('DidUngarBlogBundle_DateService');
			$aData['oDateService'] = new $sDateService($this->get('service_container'));
		}
		if ($this->getParameter('DidUngarBlogBundle_getPostsTpl')) {
			return $this->render($this->getParameter('DidUngarBlogBundle_getPostsTpl'), $aData);
		}

		return $aData;
	}

	/**
	 * @Route("/articles-{slug}", name="DidBlog_ArticlesOfCateg")
	 * @Route("/articles-{slug}/")
	 * @Template()
	 */
	public function getPostsOfCategAction($slug)
	{
		$em = $this->get('service_container')->get('doctrine')->getManager();
		$oCateg = $em->getRepository('DidUngarBlogBundle:Categ')->findOneBy(
			['slug' => $slug,]
		);
		if (empty($oCateg)) {
			throw new NotFoundHttpException('$oCateg not found');
		}

		$oPostService = $this->get('didungar_blog_post_service');
		$aPosts = $oPostService->getPosts(['id_categ' => $oCateg->getId(),]);
		$aData = ['aPosts' => $aPosts,];
		if ($this->getParameter('DidUngarBlogBundle_DateService')) {
			$sDateService = $this->getParameter('DidUngarBlogBundle_DateService');
			$aData['oDateService'] = new $sDateService($this->get('service_container'));
		}
		if ($this->getParameter('DidUngarBlogBundle_getPostsTpl')) {
			return $this->render($this->getParameter('DidUngarBlogBundle_getPostsTpl'), $aData);
		}

		return $aData;
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
		if (empty($oAuthor)) {
			throw new NotFoundHttpException('$oAuthor not found');
		}

		return ['oAuthor' => $oAuthor,];
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
