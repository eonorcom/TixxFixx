<?php
//amazon/data.php
//this file contains the static data about product categories and search types at Amazon
//(the name may be a bit unclear)
//Source: http://www.chipdir.nl/amazon/
//20030717/Jaap van Ganswijk <ganswijk@xs4all.nl>, released under the GNU GPL
//20040408/Jaap van Ganswijk, UK modes added
//20040408/Jaap van Ganswijk, Japanese locale enabled
//20040408/Jaap van Ganswijk, More search types added
//20040720/JvG, removed the slashes after the server URL's so the slash can be used within a string

//countries with a local Amazon
$Alocale=array(
  'ca' => 'Canada' ,  // (since 2005-01-21)
  'de' => 'Germany',
  'fr' => 'France' ,  // (since 2005-01-21)
  'jp' => 'Japan'  ,
  'uk' => 'UK'     ,
  'us' => 'USA'    ,
);
//You can remove or disable the local Amazon's here that you don't want to support.

//servers per country
$Aserver=array(
  'ca' => array(
    'ext' => 'ca'                      ,  //Canadian normal server
    'nor' => 'http://www.amazon.ca'    ,  //Canadian normal server
    'xml' => 'http://xml.amazon.com'   ,  //Canadian xml server
  ),
  'de' => array(
    'ext' => 'de'                      ,  //German normal server
    'nor' => 'http://www.amazon.de'    ,  //German normal server
    'xml' => 'http://xml-eu.amazon.com',  //German xml server
  ),
  'fr' => array(
    'ext' => 'fr'                      ,  //French normal server
    'nor' => 'http://www.amazon.fr'    ,  //French normal server
    'xml' => 'http://xml-eu.amazon.com',  //French xml server
  ),
  'jp' => array(
    'ext' => 'jp'                      ,  //Japanese normal server, not co.jp!
    'nor' => 'http://www.amazon.co.jp' ,  //Japanese normal server
    'xml' => 'http://xml.amazon.com'   ,  //Japanese xml server
  ),
  'uk' => array(
    'ext' => 'co.uk'                   ,  //UK normal server
    'nor' => 'http://www.amazon.co.uk' ,  //UK normal server
    'xml' => 'http://xml-eu.amazon.com',  //UK xml server
  ),
  'us' => array(
    'ext' => 'com'                     ,  //USA normal server
    'nor' => 'http://www.amazon.com'   ,  //USA normal server
    'xml' => 'http://xml.amazon.com'   ,  //USA xml server
  ),
);

//product categories per country server
//source for this array: kit3_1/AmazonWebServices/API%20Guide/using_international_data.htm
//they are kept in the order of that list
$Amode=array(
  'us' => array(
    'books'           => 'books'                   ,
    'music'           => 'popular music'           ,
    'classical'       => 'classical music'         ,
    'dvd'             => 'DVD'                     ,
    'vhs'             => 'video movies'            ,
    'electronics'     => 'electronics'             ,
    'kitchen'         => 'kitchen and housewares'  ,
    'restaurants'     => 'Restaurants'             ,
    'software'        => 'software'                ,
    'videogames'      => 'computer and video games',
    'magazines'       => 'magazines'               ,
    'toys'            => 'toys and games'          ,
    'photo'           => 'camera and photo'        ,
    'baby'            => 'baby'                    ,
    'garden'          => 'outdoor living'          ,
    'pc-hardware'     => 'computers'               ,
    'tools'           => 'tools and hardware'      ,
    'hpc'             => 'Health and personal care',  //20050412: new, suggested by DvH
    'gourmet'         => 'Gourmet'                 ,  //20050412: new, suggested by DvH
  ),
  'uk' => array(
    'books-uk'        => 'books'                   ,
    'music'           => 'popular music'           ,
    'classical'       => 'classical music'         ,
    'dvd-uk'          => 'DVD'                     ,
    'vhs-uk'          => 'video movies'            ,
    'electronics-uk'  => 'electronics'             ,
    'kitchen-uk'      => 'kitchen and housewares'  ,
    'software-uk'     => 'software'                ,
    'video-games-uk'  => 'computer and video games',
    'toys-uk'         => 'toys and games'          ,
  ),
  'de' => array(
    'books-de'        => 'books'                   ,
    'pop-music-de'    => 'popular music'           ,
    'classical-de'    => 'classical music'         ,
    'dvd-de'          => 'DVD'                     ,
    'vhs-de'          => 'video movies'            ,
    'ce-de'           => 'electronics and foto'    ,
    'kitchen-de'      => 'kitchen and housewares'  ,
    'software-de'     => 'software'                ,
    'video-games-de'  => 'computer and video games',
    'magazines-de'    => 'Magazines'               ,
    'books-de-intl-us'=> 'USA books'               ,
  ),
  'jp' => array(
    'books-jp'        => 'books'                   ,
    'music-jp'        => 'music'                   ,
    'classical-jp'    => 'classical music'         ,
    'dvd-jp'          => 'DVD'                     ,
    'vhs-jp'          => 'video movies'            ,
    'electronics-jp'  => 'electronics'             ,
    'software-jp'     => 'software'                ,
    'videogames-jp'   => 'computer and video games',
    'books-us'        => 'USA books'               ,
  ),
  'fr' => array(
    'blended'         => 'Tous les produits'        ,
    'books-fr'        => 'Livres en fran&ccedil;ais',
    'books-fr-intl-us'=> 'livres en anglais'        ,
    'music-fr'        => 'Pop, V.F., Jazz...'       ,
    'classical-fr'    => 'Musique classique'        ,
    'dvd-fr'          => 'DVD'                      ,
    'vhs-fr'          => 'Vid&eacute;o'             ,
    'sw-vg-fr'        => 'Logiciels et consommables',
    'video-games-fr'  => 'Jeux vid&eacute;o'        ,
  ),
);

//search types
//see for example kit3_1/AmazonWebServices/API%20Guide/index.html
$Asearchtype=array(
  'ActorSearch'        => 'Actor/Actress'  ,
  'ArtistSearch'       => 'Artist/Musician',
  'AsinSearch'         => 'ASIN/ISBN'      ,  //give an ASIN as the search string
  'AuthorSearch'       => 'Author'         ,
  'BlendedSearch'      => 'Blended'        ,  //this will search in several categories (modes)
  'BrowseNodeSearch'   => 'Browse node'    ,
  'DirectorSearch'     => 'Director'       ,
  'ExchangeSearch'     => 'Exchange'       ,
  'KeywordSearch'      => 'Keyword'        ,
  'ListmaniaSearch'    => 'Listmania'      ,
  'ManufacturerSearch' => 'Manufacturer'   ,
  'MarketplaceSearch'  => 'Marketplace'    ,
  'PowerSearch'        => 'Power'          ,
  'SellerSearch'       => 'Seller'         ,
  'SimilaritySearch'   => 'Similarity'     ,
  'TextStreamSearch'   => 'TextStream'     ,  //will search inside of books?
  'UpcSearch'          => 'UPC'            ,
  'WishlistSearch'     => 'Wishlist'       ,
);
//or is this also locale dependend?
//Yes, a lot of search types are only valid on the USA locale.
//A lot of search types only work on certain categories (modes).

//search types
$Asearchtype_restaurant=array(
  'American'  => 'American',
  'Bulgarian' => 'Bulgarian',
  'Chinese'   => 'Chinese',
  'Danish'    => 'Danish',
  'English'   => 'English',
  'French'    => 'French',
  'Italian'   => 'Italian',
);
//or is this also locale dependend?
//Yes, a lot of search types are only valid on the USA locale.
//A lot of search types only work on certain categories (modes).

//error messages
//and how to handle them
$Aerror=array(
  'There are no exact matches for the search.'=>'print',
);

//end
