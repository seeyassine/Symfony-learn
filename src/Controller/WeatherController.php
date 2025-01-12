<?php
declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


 class WeatherController  extends AbstractController
 {
    #[Route('/weather/highlander-says')]
    public function highlenderSays(): Response
    {
        //draw an int from 0 to 100
        $draw = random_int(0, 100);
        //if the value is < 50 (%)  then say it's ganna rain
        // otherwise say it's ganna be sunny 
        $forecast = $draw < 50 ? "It's going to rain" : "It's going to be sunny" ;

        //return response 
        return $this->render('weather/highlander-says.html.twig',[    //return new Response("<html><body>$forecast</body></html>"); 
                'forcast' => $forecast,
        ]);

    }
 }