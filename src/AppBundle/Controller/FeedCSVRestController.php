<?php

namespace AppBundle\Controller;
use FOS\RestBundle\Controller\FOSRestController;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class FeedCSVRestController extends FOSRestController
{
    public function getFeedAction($id){
        $feed = $this->getDoctrine()->getRepository('AppBundle:FeedCSV')->find($id);
        if(!is_object($feed)){
            throw $this->createNotFoundException();
        }
        return $feed;
    }
}
