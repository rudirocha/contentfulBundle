# Contentful API Reader Bundle
This is a bundle for https://www.contentful.com API. Just create a Contentful account and follow the instructions.
Add it for your app from packagist https://packagist.org/packages/rudirocha/contentful-bundle
 ### Instructions
 Add necessary parameters
 ```sh
    #parameters.yml
    rubius_contentful_accesstoken: YOUR_PRODUCTION_ACCESS_TOKEN
 ```
 Enable Necessary bundles
 ```
    //AppKernel.php
    public function registerBundles()
    {
        $bundles = array(
            #...
            new Rubius\ContentfulBundle\RubiusContentfulBundle(),
            new Misd\GuzzleBundle\MisdGuzzleBundle()
            #...
        ); 
    }
 ```
 Now at your controller (or where you want)
 ```
    public function indexAction()
    {
        $contentClient = $this->get('rubius.contentful.delivery');
        
        //get all entries from one space
        $contentObj = json_decode(
            (string) ($contentClient->getAllContentOfSpace('your_contentful_space_id')->getBody())
            );
        //get all entries from one content type of a space
        $contentResponseObject = json_decode(
        (string) ($contentClient->getContentOfType('your_contentful_space_id','content_type_id')->getBody())
        );
        
        /**
        * Query Entries 
        * ['fields.slug' => 'post-slug'] -> content type has field called slug
        */
        $content = (string)($contentClient->getContentEntryBy('your_contentful_space_id','content_type', ['fields.slug' => 'post-slug'])->getBody());
    }
 ```

#### Notes
This bundle is just a simple content reader! Have suggestions? ping me :)


