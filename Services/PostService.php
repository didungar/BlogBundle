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

	/**
	 * @param array $aArgs = []
	 *	- array|integer id_categ optional
	 *	- integer max_result optional
	 * @return lstPost
	**/
	public function getPosts(array $aArgs = []) {
		// Initialisation :
		$iFirstResult = 0;
		$iMaxResults = 10;
		$aWhere = [];
		$aParameters = [];
		$em = $this->container->get('doctrine')->getManager();
		$sOrder = ' ORDER BY p.dateAdd DESC';

		// Analyse de la demande :
		if ( !empty($aArgs['max_result']) ) {
			if ( ! is_numeric($aArgs['max_result']) ) {
				throw new \Exception('max_result bad value (not numeric)');
			}
			if ( $aArgs['max_result']<=0 ) {
				throw new \Exception('max_result bad-value : negatif');
			}
			$iMaxResults = (int)$aArgs['max_result'];
		}
		if ( !empty($aArgs['id_categ']) ) {
			if ( !is_array($aArgs['id_categ']) ) {
				$aArgs['id_categ'] = [$aArgs['id_categ']];
			}
			foreach($aArgs['id_categ'] as $id_categ) {
				if ( ! is_numeric($id_categ) ) {
					throw new \Exception('id_categ bad value (not array / numeric)');
				}
				if ( $id_categ<=0 ) {
					throw new \Exception('id_categ not positive : '.$id_categ);
				}
				$oCateg = $em->getRepository('DidUngarBlogBundle:Categ')->findOneBy(['id'=>$aArgs['id_categ']]);
				if ( empty($oCateg) ) {
					throw new \Exception('id_categ not found : '.$id_categ);
				}
			}
			$aWhere[] = 'p.idCateg IN(:id_categ)';
			$aParameters[':id_categ'] = $aArgs['id_categ'];
			$sOrder = 'ORDER BY p.'.$oCateg->getOrderCols().' '.$oCateg->getOrderSens();
		}

		// Query :
		$sWhere = empty($aWhere) ? '' : ' WHERE '.implode(' AND ', $aWhere);
		$query = $em->createQuery(
			'SELECT p
			FROM DidUngarBlogBundle:Post p
			'.$sWhere
			.$sOrder
			)
			->setFirstResult($iFirstResult)
                	->setMaxResults($iMaxResults);
		if ( ! empty($aParameters) ) {
			$query->setParameters($aParameters);
		}
		// Résultat :
		return $query->getResult();//$em->getRepository('DidUngarBlogBundle:Post')->findBy([],['dateAdd'=>'DESC']);
	}
}



