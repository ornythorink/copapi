<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Put;
use AppBundle\Form\FeedCSVType;
use Doctrine\Common\Util\Inflector;


class FeedCSVRestController extends FOSRestController
{

    public function getFeedAction($id){

        $feed = $this->getDoctrine()->getRepository('AppBundle:FeedCSV')->find($id);



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

    public function postFeedsAction(Request $request){

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
        $feeds = $this->getDoctrine()->getRepository('AppBundle:FeedCSV')->getActiveFeeds($source, $locale);

        return $feeds;
    }

    /**
     *
     * @Get("/feeds/next/{source}/{locale}")
     */
    public function getFeedsNextToProcessAction($source,$locale){
        $feeds = $this->getDoctrine()->getRepository('AppBundle:FeedCSV')->retrieveNextCsvFeed($source, $locale);

        return $feeds;
    }

    /**
     *
     * @Put("/feeds/unflag/{id}")
     */
    public function unflagFeedsAction(Request $request, $id){

        $putItems = json_decode($request->getContent() ,true);

        $feed = $this->getDoctrine()->getRepository('AppBundle:FeedCSV')->find($id);
        $feed->setFlagbatched('N');
        $em = $this->getDoctrine()->getManager();
        $em->persist($feed);
        $em->flush();

        return $feed;
    }

    /**
     *
     * @Put("/feeds/flag/{id}")
     */
    public function flagFeedsAction(Request $request, $id){

        $feed = $this->getDoctrine()->getRepository('AppBundle:FeedCSV')->find($id);
        $feed->setFlagbatched('Y');
        $em = $this->getDoctrine()->getManager();
        $em->persist($feed);
        $em->flush();

        return $feed;
    }
}


