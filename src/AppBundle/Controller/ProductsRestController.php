<?php

namespace AppBundle\Controller;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Products;
use AppBundle\Form\ProductsType;
use Doctrine\Common\Util\Inflector;
Use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Put;

class ProductsRestController extends FOSRestController
{

    public function getProductAction($id){

        $product = $this->getDoctrine()->getRepository('AppBundle:Products')->find($id);

        if(!is_object($product)){
            throw $this->createNotFoundException();
        }

        return $product;
    }

    public function getProductsAction(){
        $products = $this->getDoctrine()->getRepository('AppBundle:Products')->findAll();

        if(count($products) == 0){
            throw $this->createNotFoundException();
        }

        return $products;
    }

    public function postProductsAction(Request $request){

    }

    /**
     *
     * @Put("/products/{id}")
     */
    public function putProductsAction(Request $request, $id){

        $putItems = json_decode($request->getContent(),true);

        $product = $this->getDoctrine()->getRepository('AppBundle:Products')->find($id);

        foreach($putItems as $field=> $value)
        {
            $setter = sprintf('set%s', ucfirst(Inflector::camelize($field)));
            if(preg_match('/\d{4}-\d{2}-\d{2}/',$value)){
                $value = new \DateTime($value);
            }
            $product->$setter($value);
        }
        $form = $this->createForm(new ProductsType(),$product);

        $form->submit($request->getContent());

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();
        }

        return $product;
    }


}
