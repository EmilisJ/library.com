<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpClient\HttpClient;
use App\Security\AccessToken;

class ApiController extends AbstractController
{
    public function apiConnect()
    {
        $client = HttpClient::create();
        $response = $client->request(
            'POST',
            'https://id-sandbox.dokobit.com/api/authentication/create?access_token='.AccessToken::getAccessToken(),
            ['body' => 
                ['return_url' => 'http://library.com/api/authorize']
            ]);
        $url = $response->toArray()['url'];
        // dump($response->toArray()['url']);die();
        return $this->redirect($url);
    }

    public function apiAuthorize(Request $request)
    {
        $client = HttpClient::create();
        $sessionToken = $request->query->get('session_token');
        $url = 'https://id-sandbox.dokobit.com/api/authentication/'.$sessionToken.'/status?access_token='.AccessToken::getAccessToken();
        $response = $client->request(
            'GET',
            $url
        );
        // dump($response->getContent());die();
        
        return $this->redirectToRoute('api_mask_url', $response->toArray());
    }

    public function apiMaskUrl(Request $request)
    {
        return $this->redirectToRoute('welcome');
    }
}