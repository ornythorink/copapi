<?php

namespace AppBundle\Controller;
use AppBundle\Entity\Categories;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations\Get;

class CategoriesRestController extends FOSRestController
{
    public function getCategoriesAction($id){
        $categories = $this->getDoctrine()->getRepository('AppBundle:Categories')->find($id);

        if(!is_object($categories)){
            throw $this->createNotFoundException();
        }

        return $categories;
    }

    public function getAllCategoriesAction(){
        $categories = $this->getDoctrine()->getRepository('AppBundle:Categories')->findAll();

        if(!is_object($categories)){
            throw $this->createNotFoundException();
        }

        return $categories;
    }

    /**
     *
     * @Get("/root/categories")
     */
    public function getRootCategoriesAction(){
        $categories = $this->getDoctrine()->getRepository('AppBundle:Categories')->findRootCategories();

        return $categories;
    }



    public function postCategoriesAction(Request $request){
        $json = $request->request->all();

        $categories = new Categories();

        $form = $this->createForm(WhiteListCategoriesType::class, $categories);

        $form->handleRequest($request);
        $form->submit($request);

        if ($form->isValid()) {
            foreach($json as $field=> $value)
            {
                $setter = sprintf('set%s', ucfirst(Inflector::camelize($field)));
                if(preg_match('/\d{4}-\d{2}-\d{2}/',$value)){
                    $value = new \DateTime($value);
                }
                $categories->$setter($value);
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($categories);
            $em->flush();
        }
        return $categories;
    }

    public function putCategoriesAction(Request $request, $id){
        $putItems = json_decode($request->getContent() ,true);

        $categories = $this->getDoctrine()->getRepository('AppBundle:Categories')->find($id);

        foreach($putItems as $field=> $value)
        {
            $setter = sprintf('set%s', ucfirst(Inflector::camelize($field)));
            if(preg_match('/\d{4}-\d{2}-\d{2}/',$value)){
                $value = new \DateTime($value);
            }
            $categories->$setter($value);
        }

        if(!is_object($categories)){
            throw $this->createNotFoundException();
        }
        $form = $this->createForm(new WhiteListCategoriesType(),$categories);

        $form->handleRequest($request);
        $form->submit($request->getContent());

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($categories);
            $em->flush();
        }

        return $categories;
    }

    public function deleteCategoriesAction($id){

    }
}
