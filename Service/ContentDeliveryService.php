<?php
/**
 * @Author Rúdi Rocha <rudi.rocha@gmail.com>
 */

namespace Rubius\ContentfulBundle\Service;


use Guzzle\HTTP\Client;

class ContentDeliveryService
{

    /**
     * Contentful base URL
     */
    const CONTENTFUL_BASE_URL = 'https://cdn.contentful.com';

    /**
     * ENTRIES PATH
     */
    const CONTENTFUL_ENTRIES_URL = '/spaces/%s/entries?access_token=%s';

    /**
     * HEADER Json v1
     */
    const CONTENTFUL_HEADERS_V1_JSON = "'Content-Type:application/vnd.contentful.delivery.v1+json'";

    /**
     * @var Client
     */
    private $guzzleClient;

    /*
     * Make it secret! and renew it!
     */
    private $accessToken;

    public function __construct($guzzleClientSvc, $accessToken)
    {
        $this->guzzleClient = $guzzleClientSvc;
        $this->accessToken = $accessToken;

        $this->guzzleClient->setBaseUrl(self::CONTENTFUL_BASE_URL);
    }

    /**
     * @param $spaceId
     * @return \Guzzle\Http\Message\RequestInterface
     */
    public function getAllContentOfSpace($spaceId)
    {

        $request = $this->guzzleClient
            ->get(
                //path
                sprintf(
                    self::CONTENTFUL_ENTRIES_URL,
                    $spaceId,
                    $this->accessToken
                ),

                //headers
                [
                    self::CONTENTFUL_HEADERS_V1_JSON
                ]
            );

        $response = $this->guzzleClient->send($request);
        return $response;
    }

    /**
     * @param $spaceId
     * @param $contentType
     * @return array|\Guzzle\Http\Message\Response|null
     */
    public function getContentOfType($spaceId, $contentType)
    {
        $request = $this->guzzleClient
            ->get(
                //path
                sprintf(
                    self::CONTENTFUL_ENTRIES_URL."&content_type=%s",
                    $spaceId,
                    $this->accessToken,
                    $contentType
                ),

                //headers
                [
                    self::CONTENTFUL_HEADERS_V1_JSON
                ]
            );

        $response = $this->guzzleClient->send($request);
        return $response;

    }

    /**
     * @param $spaceId
     * @param array $attributes
     * @return array|\Guzzle\Http\Message\Response|null
     */
    public function getContentEntryBy($spaceId, $contentType, $attributes = [])
    {
        $path = sprintf(
            self::CONTENTFUL_ENTRIES_URL. "&content_type=%s",
            $spaceId,
            $this->accessToken,
            $contentType
        );
        foreach ($attributes as $attr => $value) {
            $path .= sprintf("&%s=%s", $attr, $value);
        }

        $request = $this->guzzleClient
            ->get(
            //path
                $path,
                //headers
                [
                    self::CONTENTFUL_HEADERS_V1_JSON
                ]
            );

        $response = $this->guzzleClient->send($request);
        return $response;
    }
}