<?php
declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

#[Route('/weather')]
 class WeatherController  extends AbstractController
 {
    #[Route('/highlander-says/{threshold<\d+>?50}', host: 'api.localhost', methods:['GET','POST'])]   //, priority: 2
    public function highlenderSaysApi(int $threshold ): Response  // for default parameter we do highlenderSays(int $threshold = 50)
    {
       
        $draw = random_int(0, 100);
        
        $forecast = $draw < $threshold ? "It's going to rain" : "It's going to be sunny" ;

        $json = [
            'forecast' => $forecast,
        ];

        return new JsonResponse($json);

    }





    #[Route('/highlander-says/{threshold<\d+>?50}',  methods:['GET','POST'])]   //, priority: 2
    public function highlenderSays(int $threshold ): Response  // for default parameter we do highlenderSays(int $threshold = 50)
    {
        //draw an int from 0 to 100
        $draw = random_int(0, 100);
        //if the value is < 50 (%)  then say it's ganna rain
        // otherwise say it's ganna be sunny 
        $forecast = $draw < $threshold ? "It's going to rain" : "It's going to be sunny" ;

        //return response 
        return $this->render('weather/highlander-says.html.twig',[    //return new Response("<html><body>$forecast</body></html>"); 
                'forcast' => $forecast,
        ]);

    }







    #[Route('/highlander-says/{guess}',  methods:['GET','POST'] )] //, priority: 1
    public function highlenderSaysGuess(string $guess): Response  
    {
       
        $forecast = "It's going to $guess" ;

        //return response 
        return $this->render('weather/highlander-says.html.twig',[    
                'forcast' => $forecast,
        ]);

    }


 }