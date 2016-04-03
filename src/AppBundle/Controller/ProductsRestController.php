<?php

namespace AppBundle\Controller;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Products;
use AppBundle\Form\ProductsType;
use Doctrine\Common\Util\Inflector;
Use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Put;
use AppBundle\Utils\Sources;

class ProductsRestController extends FOSRestController
{

    /**
     *
     * @Get("/products/{id}")
     */
    public function getProductAction($id){

        $product = $this->getDoctrine()->getRepository('AppBundle:Products')->find($id);

        if(!is_object($product)){
            throw $this->createNotFoundException();
        }

        return $product;
    }

    /**
     *
     * @Get("/products")
     */
    public function getProductsAction(){
        $products = $this->getDoctrine()->getRepository('AppBundle:Products')->findAll();

        if(count($products) == 0){
            throw $this->createNotFoundException();
        }

        return $products;
    }

    /**
     *
     * @Post("/products/import/{source}/{feedId}")
     */
    public function importProductsAction(Request $request, $source, $feedId){

        $produits = $request->request->all();

        $prefix= Sources::getSourceKey($source,'prefix');
        $method = $prefix . 'ImportCsv';
        $products = $this->getDoctrine()->getRepository('AppBundle:Products')->$method($produits,$feedId);

        return $products;
    }

}
