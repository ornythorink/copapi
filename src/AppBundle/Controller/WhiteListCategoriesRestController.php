<?php

namespace AppBundle\Controller;
use FOS\RestBundle\Controller\Annotations\Delete;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Put;
use FOS\RestBundle\Controller\FOSRestController;


class WhiteListCategoriesRestController extends FOSRestController
{
    /**
     *
     * @Get("/whitelistcategories/{id}")
     */
    public function getWhiteListCategoriesAction($id){

    }

    /**
     *
     * @Post("/whitelistcategories")
     */
    public function postWhiteListCategoriesAction(){

    }

    /**
     *
     * @Put("/whitelistcategories/{id}")
     */
    public function putWhiteListCategoriesAction($id){

    }

    /**
     *
     * @Delete("/whitelistcategories/{id}")
     */
    public function deleteWhiteListCategoriesAction($id){

    }
}
