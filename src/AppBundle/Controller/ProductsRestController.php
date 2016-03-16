<?php

namespace AppBundle\Controller;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Products;
use AppBundle\Form\ProductsType;

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
        $product->createFromArray($json);
        $form = $this->createForm(ProductsType::class, $product);

        $form->handleRequest($request);
        $form->submit($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();
        }
        return $product;
    }
}
