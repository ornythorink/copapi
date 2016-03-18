<?php

namespace AppBundle\Controller;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Products;
use AppBundle\Form\ProductsType;
use Doctrine\Common\Util\Inflector;


class ProductsRestController extends FOSRestController
{

    public function getProductAction($id){

        $product = $this->getDoctrine()->getRepository('AppBundle:Products')->find($id);
        if(!is_object($product)){
            throw $this->createNotFoundException();
        }
        return array($product);
    }

    public function postProductAction(Request $request){
        $json = $request->request->all();

        $product = new Products();

        $form = $this->createForm(ProductsType::class, $product);

        $form->handleRequest($request);
        $form->submit($request);

        if ($form->isValid()) {
            foreach($json as $field=> $value)
            {
                $setter = sprintf('set%s', ucfirst(Inflector::camelize($field)));
                if(preg_match('/\d{4}-\d{2}-\d{2}/',$value)){
                    $value = new \DateTime($value);
                }
                $product->$setter($value);
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();
        }
        return $product;
    }

    public function putProductsAction(Request $request, $id){

        $putItems = json_decode($request->getContent() ,true);

        $products = $this->getDoctrine()->getRepository('AppBundle:Products')->find($id);

        foreach($putItems as $field=> $value)
        {
            $setter = sprintf('set%s', ucfirst(Inflector::camelize($field)));
            if(preg_match('/\d{4}-\d{2}-\d{2}/',$value)){
                $value = new \DateTime($value);
            }
            $products->$setter($value);
        }

        if(!is_object($products)){
            throw $this->createNotFoundException();
        }
        $form = $this->createForm(new ProductsType(),$products);

        $form->handleRequest($request);
        $form->submit($request->getContent());

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($products);
            $em->flush();
        }

        return $products;
    }

}
