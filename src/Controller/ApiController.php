<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class ApiController extends AbstractController
{
    public function apiConnect()
    {
        $client = HttpClient::create();
        $response = $client->request(
            'POST',
            'https://id-sandbox.dokobit.com/api/authentication/create?access_token='.$this->getParameter('access_token'),
            ['body' => 
                ['return_url' => $this->generateUrl('api_authorize',[],UrlGeneratorInterface::ABSOLUTE_URL)]
            ]);
        $url = $response->toArray()['url'];
        return $this->redirect($url);
    }

    public function apiAuthorize(Request $request)
    {
        $client = HttpClient::create();
        $sessionToken = $request->query->get('session_token');
        $url = 'https://id-sandbox.dokobit.com/api/authentication/'.$sessionToken.'/status?access_token='.$this->getParameter('access_token');
        $response = $client->request(
            'GET',
            $url
        );
        return $this->redirectToRoute('api_mask_url', $response->toArray());
    }

    public function apiMaskUrl(Request $request)
    {
        return $this->redirectToRoute('welcome');
    }
}
