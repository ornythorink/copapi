<?php

namespace AppBundle\Controller;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations\Get;
use AppBundle\Form\FeedCSVType;
use Doctrine\Common\Util\Inflector;


class FeedCSVRestController extends FOSRestController
{

    public function getFeedAction($id){

        $feed = $this->getDoctrine()->getRepository('AppBundle:FeedCSV')->findBy($id);

        if(!is_object($feed)){
            throw $this->createNotFoundException();
        }

        return $feed;
    }

    public function getFeedsAction(){
        $feeds = $this->getDoctrine()->getRepository('AppBundle:FeedCSV')->findAll();

        if(count($feeds) == 0){
            throw $this->createNotFoundException();
        }

        return $feeds;
    }

    /**
     *
     * @Get("/feeds/toprocess/{source}/{locale}")
     */
    public function getToProcessAction($source, $locale){
        $feeds = $this->getDoctrine()->getRepository('AppBundle:FeedCSV')->getFeedsToProcess($source, $locale);

        return $feeds;
    }


    /**
     *
     * @Get("/feeds/active/{source}/{locale}")
     */
    public function getFeedsActiveAction($source,$locale){
        $feeds = $this->getDoctrine()->getRepository('AppBundle:FeedCSV')->getFeedsToProcess($source, $locale);

        if(count($feeds) == 0){
            throw $this->createNotFoundException();
        }

        return $feeds;
    }

    /**
     *
     * @Get("/feeds/next/{source}/{locale}")
     */
    public function getFeedsNextToProcessAction($source,$locale){
        $feeds = $this->getDoctrine()->getRepository('AppBundle:FeedCSV')->getActiveFeeds($source, $locale);

        if(count($feeds) == 0){
            throw $this->createNotFoundException();
        }

        return $feeds;
    }

    public function putFeedsAction(Request $request, $id){

        $putItems = json_decode($request->getContent() ,true);


        $feed = $this->getDoctrine()->getRepository('AppBundle:FeedCSV')->find($id);

        foreach($putItems as $field=> $value)
        {
            $setter = sprintf('set%s', ucfirst(Inflector::camelize($field)));
            if(preg_match('/\d{4}-\d{2}-\d{2}/',$value)){
                $value = new \DateTime($value);
            }
            $feed->$setter($value);
        }

        if(!is_object($feed)){
            throw $this->createNotFoundException();
        }
        $form = $this->createForm(new FeedCSVType(),$feed);

        $form->handleRequest($request);
        $form->submit($request->getContent());

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($feed);
            $em->flush();
        }

        return $feed;
    }

}


