<?php

namespace AppBundle\Controller;
use FOS\RestBundle\Controller\Annotations\Delete;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Put;
use FOS\RestBundle\Controller\FOSRestController;


class BlackListCategoriesRestController extends FOSRestController
{
    /**
     *
     * @Get("/blacklistcategories/{id}")
     */
    public function getBlackListCategoriesAction($id){

    }

    /**
     *
     * @Post("/blacklistcategories")
     */
    public function postBlackListCategoriesAction(){

    }

    /**
     *
     * @Put("/blacklistcategories/{id}")
     */
    public function putBlackListCategoriesAction($id){

    }

    /**
     *
     * @Delete("/blacklistcategories/{id}")
     */
    public function deleteBlackListCategoriesAction($id){

    }
}