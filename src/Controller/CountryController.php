<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Country;

class CountryController extends AbstractController
{
    /**
     * @Route("/country", name="country")
     */
    public function index()
    {
        //Retrieve all the entities within the database
        $repository = $this->getDoctrine()->getRepository(Country::class);
        
        //Use the corresponding function to store them all in a variable
        $countries = $repository->findAll();
        
        //Create an array and insert a string for each country. Format it accordingly.
        $array = [];
        foreach ($countries as $country) {
            array_push($array, '{name:' . $country->getName() . ', code: ' . $country->getCode() . '},');
        };

        //Since the original file contains strings and not array items, implode the array
        $countries_string = implode($array);
        
        //return the string in an array just like in the original file
        return $this->json([
            'message' => 'Here is the content of the database, formatted as close as possible to the original file.',
            'countries' => [$countries_string],
        ]);
    }
}
