<?php
declare(strict_types=1);

namespace App\Controller;

use App\Model\HighlanderApiDTO;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

#[Route('/weather')]
 class WeatherController  extends AbstractController
 {
   // #[Route('/highlander-says/{threshold<\d+>?50}', host: 'api.localhost', methods:['GET','POST'])]   //, priority: 2
    #[Route('/highlander-says/api')]
    public function highlenderSaysApi(
        #[MapRequestPayload] ?HighlanderApiDTO $dto = null): Response  // for default parameter we do highlenderSays(int $threshold = 50)
    {
        if(!$dto){
        $dto = new HighlanderApiDTO();
        $dto->threshold = 50;
        $dto->trials = 1;
        }

        for ($i = 0; $i < $dto->trials; $i++){
            $draw = random_int(0, 100);
            $forecast = $draw < $dto->threshold ? "It's going to rain" : "It's going to be sunny" ;
            $forecasts[] = $forecast;
        }

        $json = [
            'forecasts' => $forecasts,
            'threshold' => $dto->threshold,
        ];

        return new JsonResponse($json);

    }

    #[Route('/highlander-says/{threshold<\d+>}',  methods:['GET','POST'])]   //, priority: 2
    public function highlenderSays(
       Request $request,
       RequestStack $requestStack,
       ?int $threshold = null
    ): Response  // for default parameter we do highlenderSays(int $threshold = 50)
    {
        $session = $requestStack->getSession();
        if ($threshold){
            $session->set('threshold', $threshold);
        }else{
            $threshold = $session->get('threshold');
        }

        $trials = $request->get('trials',1);

        $forecasts = [];

        for ($i = 0; $i < $trials ; $i++){
        $draw = random_int(0, 100);
        $forecast = $draw < $threshold ? "It's going to rain" : "It's going to be sunny" ;
        $forecasts[] = $forecast;
        }

        return $this->render('weather/highlander-says.html.twig',[    //return new Response("<html><body>$forecast</body></html>"); 
                'forecasts' => $forecasts,
                'threshold' => $threshold,
        ]);

    }







    #[Route('/highlander-says/{guess}',  methods:['GET','POST'] )] //, priority: 1
    public function highlenderSaysGuess(string $guess): Response  
    {
        $availableGuesses = ['snow','rain','hail'];

        if(!in_array($guess,$availableGuesses)){
             throw  $this->createNotFoundException('This guess is not found');
            //  throw new NotFoundHttpException('This guess is not found (manually)');
            //  throw new BadRequestHttpException('Bad request');
            //  throw new \Exception("Base exception");

        }
       
        $forecast = "It's going to $guess" ;

        //return response 
        return $this->render('weather/highlander-says.html.twig',[    
                'forcasts' => [$forecast],
        ]);

    }


 }