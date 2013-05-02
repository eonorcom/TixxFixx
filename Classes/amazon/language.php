<?php
//language.php
//Language translation module.
//20030717/wjvg
//20040715/wjvg: added some things that Wim Roffel suggested
//20040920/wjvg: thanks to Dr. Jan-Hendrik Doerner for correcting some of the German translations
//20041114/wjvg: Norwegian translations by Bjoern Boerresen added
//20060309/wjvg: added the Portuguese translation six month after I got it, shame on me!
//20060309/wjvg: did put English first in the $Alanguage array again and added the comment
//20091129/wjvg: added italian

//$logfile='data/language.log';  //make sure that this exists and is writable by the httpd, 20040715: changed the path
//i have disabled this in the user version, it's a way of logging strings that still have to be translated

//all the possible languages
$Alanguage=array(
  'en' => 'English',     //also spoken in the USA and Australia and parts of Canada
  //keep English first in the list when you want it to be the default language
  //someone had a problem with this after I sorted the list in ABC order
  'de' => 'German',      //also spoken in Austria and part of Switzerland
  'eo' => 'Esperanto',
  'fr' => 'French',      //also spoken by the Walonians in South-East Belgium and in parts of Switzerland and Canada
  'nl' => 'Dutch',       //also spoken by the Flemish in North-West Belgium
  'no' => 'Norwegian',
  'pt' => 'Portuguese',  //also spoken in Brasil
  'it' => 'Italian',
);

//To have individual text parts translated, write them in English as a string
//that is given as an argument to the function xl() or xu().
//These functions will try to translate the text part
//to the language given in $language ('de', 'en', 'eo', 'fr', 'nl', 'no').
//xl() will keep the text part in the case it is given in and xu() will
//convert the first character to uppercase.

//If you have any non-text characters at the end of the string they will
//be stripped off before the string is being translated and later added again.

//These are the translation tables to be used. For the time being they are
//encoded in the PHP source code, but they should be put in seperate data
//structures of course. For example in the ASCII '.csv' (comma seperated value)
//spreadsheet format. If you want to add more words or tables for other languages,
//see at the end of the file.
$Axl=array(
  //German translations by Markus Wannemacher, Jaap van Ganswijk and Jan-Hendrik Doerner
  'de' => array(
    'actor/actress'               => 'Schauspieler(in)',
    'artist/musician'             => 'K&uuml;nstler/Musiker',
    'ASIN/ISBN'                   => 'ASIN/ISBN',
    'author'                      => 'Autor',
    'baby'                        => 'Baby',
    'books'                       => 'B&uuml;cher',
    'browse node'                 => 'browse Node',
    'by'                          => 'durch',
    'camera and photo'            => 'Kamera und Photo',
    'classical music'             => 'Klassische Musik',
    'computer and video games'    => 'Computer- und Videospiele',
    'computers'                   => 'Computer',
    'customer rating'             => 'Kundenbewertung',
    'director'                    => 'Regisseur',
    'Dutch'                       => 'Holl&auml;ndisch',
    'DVD'                         => 'DVD',
    'electronics and foto'        => 'elektronische Ger&auml;te und Photos',
    'electronics'                 => 'elektronische Ger&auml;te',
    'English'                     => 'Englisch',
    'Esperanto'                   => 'Esperanto',
    'exchange'                    => 'Austausch',
    'German'                      => 'Deutsch',
    'Germany'                     => 'Deutschland',
    'Japan'                       => 'Japan',
    'keyword'                     => 'Schl&uuml;esselwort',
    'kitchen and housewares'      => 'K&uuml;chen und Haushalt',
    'language for page'           => 'Sprache f&uuml;r Seite',
    'listmania'                   => 'listmania',
    'magazines'                   => 'Zeitschriften',
    'manufacturer'                => 'Hersteller',
    'music'                       => 'Musik',
    'new'                         => 'neu',
    'next results'                => 'weitere Ergebnisse',
    'next search results'         => 'weitere Suchergebnisse',
    'number of products found'    => 'Anzahl der gefundenen Produkte',
    'number of products'          => 'Anzahl der Produkte',
    'of'                          => 'von',
    'outdoor living'              => 'Garten und Freizeit',
    'page'                        => 'Seite',
    'popular music'               => 'Popmusik',
    'power'                       => 'Kraft',
    'previous results'            => 'vorhergehende Ergebnisse',
    'previous search results'     => 'vorhergehende Suchergebnisse',
    'price'                       => 'Preis',
    'producer'                    => 'Produzent',
    'product category'            => 'Produktkategorie',
    'publisher'                   => 'Verlag',
    'released'                    => 'erschienen',
    'sales rank'                  => 'Verkaufsrang',
    'search string'               => 'Suchbegriff',
    'search type'                 => 'Suchtypus',
    'searching for'               => 'suchen nach',
    'seller'                      => 'Verk&auml;ufer',
    'similarity'                  => 'Gleichheit',
    'software'                    => 'Software',
    'tools and hardware'          => 'Werkzeuge',
    'toys and games'              => 'Spielzeug',

    'UK'                          => 'Vereinigtes K&ouml;nigreich',
    'universal product code'      => 'universale Produkt Code',
    'UPC'                         => 'UPC',
    'USA books'                   => 'USA B&uuml;cher',
    'USA'                         => 'USA',
    'used'                        => 'gebraucht',
    'video movies'                => 'Videofilme',
    'video'                       => 'Video',
    'which server'                => 'welcher Server',
  ),
  //Esperanto translations by Wil van Ganswijk
  'eo' => array(
    'Amazon returned the error'   => 'Amazon redonis la eraron',
    'baby'                        => 'bebo',
    'books'                       => 'libroj',
    'by'                          => 'de',
    'camera and photo'            => 'fotilo kaj foto',
    'can\'t get data from Amazon' => 'ne povas enpreni donita&jcirc;ojn de Amazon',
    'classical music'             => 'klasika muziko',
    'computer and video games'    => 'komputero- kaj videoludoj',
    'computers'                   => 'komputeroj',
    'customer rating'             => 'klientaprezo',
    'database'                    => 'donita&jcirc;aro',
    'DVD'                         => 'DVD',
    'electronics and foto'        => 'elektroniko kaj fotoj',
    'electronics'                 => 'elektroniko',
    'garden tools'                => '&gcirc;ardeniloj',
    'garden'                      => '&gcirc;ardeno',
    'gardening'                   => '&gcirc;ardenlaboro',
    'kitchen and housewares'      => 'kuirejo- kaj domiloj',
    'magazines'                   => 'revuoj',
    'manufacturer'                => 'fabrikisto',
    'music'                       => 'muziko',
    'new'                         => 'nova',
    'next results'                => 'sekvantaj rezultoj',
    'next search results'         => 'sekvantaj ser&ccirc;rezultoj',
    'number of products found'    => 'nombro de travitaj produktoj',
    'number of products'          => 'nombro de produktoj',
    'of'                          => 'de',
    'outdoor living'              => 'kampara vivo',
    'page'                        => 'pa&gcirc;o',
    'please add this error message to the ' => 'bonvolu aligi chi tiun erarmesa&gcirc;on al la',
    'popular music'               => 'populara muziko',
    'previous results'            => 'antauaj rezultoj',
    'previous search results'     => 'antauaj ser&ccirc;rezultoj',
    'price'                       => 'prezo',
    'producer'                    => 'produkisto',
    'publisher'                   => 'eldonisto',
    'released'                    => 'eldonita',
    'sales rank'                  => 'vendrango',
    'software'                    => 'komputerprogramoj',
    'tools and hardware'          => 'iloj',
    'toys and games'              => 'ludiloj kaj ludoj',
    'USA books'                   => 'USA libroj',
    'used'                        => 'uzita',
    'video movies'                => 'videofilmoj',
    'video'                       => 'video',
    //still to check:
    'ASIN/ISBN'                   => 'ASIN/ISBN',
    'UPC'                         => 'UPC',
    'esperanto'                   => 'esperanto',
    'USA'                         => 'USA',
/*
    //still to do:
    'actor/actress'               => '',
    'artist/musician'             => '',
    'author'                      => '',
    'browse node'                 => '',
    'director'                    => '',
    'Dutch'                       => '',
    'exchange'                    => '',
    'Germany'                     => '',
    'Japan'                       => '',
    'keyword'                     => '',
    'language for page'           => '',
    'listmania'                   => '',
    'manufacturer'                => '',
    'power'                       => '',
    'product category'            => '',
    'search string'               => '',
    'search type'                 => '',
    'seller'                      => '',
    'similarity'                  => '',
    'UK'                          => '',
    'universal product code'      => '',
    'which server'                => '',
*/
  ),
  //French translations by Jean-Christophe Peyrard and Jaap van Ganswijk (comments by Jaap)
  'fr' => array(
    'actor/actress'               => 'acteur/actrice',
    'artist/musician'             => 'artiste/musicien',
    'ASIN/ISBN'                   => 'ASIN/ISBN',
    'author'                      => 'auteur',
    'baby'                        => 'enfant',                    //bebe?
    'books'                       => 'livres',                    //added an 's'
    'browse node'                 => 'passer en revue',           //browse node?
    'by'                          => 'par',
    'camera and photo'            => 'appareil-photo et photo',
    'classical music'             => 'musique classique',
    'computer and video games'    => 'jeux ordinateur et video',  //changed this, Jaap
    'computers'                   => 'ordinateurs',               //added an 's'
    'customer rating'             => 'estimation du client',      //changed estination into estimation
    'director'                    => 'directeur',
    'Dutch'                       => 'Néerlandais',
    'DVD'                         => 'DVD',
    'electronics and foto'        => 'appareil-electronique et photo',  //Added 'appareil-'
    'electronics'                 => 'appareil-electronique',           //Added 'appareil-'
    'English'                     => 'Anglais',
    'Esperanto'                   => 'Esperanto',
    'exchange'                    => 'echanger',
    'German'                      => 'Allemand',
    'Germany'                     => 'Allemagne',
    'Japan'                       => 'Japon',
    'keyword'                     => 'mot clef',
    'kitchen and housewares'      => 'cuisine et ustensiles',
    'language for page'           => 'Language par page',      //pour?
    'listmania'                   => 'listmania',              //amazon.fr uses the English name for this
    'magazines'                   => 'magasines',
    'manufacturer'                => 'fabriquant',
    'music'                       => 'musique',
    'new'                         => 'nouveau',
    'next results'                => 'résultats suivants',
    'next search results'         => 'résultats suivants du cherche',  //I added du cherche, is that correct?
    'number of products found'    => 'nombre de produit trouvé',
    'number of products'          => 'nombre de produit',
    'of'                          => 'de',
    'outdoor living'              => 'vie exterieur',                   //is it clear that this is about gardening?
    'page'                        => 'page',
    'popular music'               => 'musique populaire',
    'power'                       => 'puissance',                       //was puissant
    'previous results'            => 'résultats précédant',
    'previous search results'     => 'résultats précédant du cherche',
    'price'                       => 'prix',
    'producer'                    => 'producteur',
    'product category'            => 'catégorie du produit',
    'publisher'                   => 'éditeur',
    'released'                    => 'edité',
    'sales rank'                  => 'taux de vente',
    'search string'               => 'mot clef',           //Is this correct?
    'search type'                 => 'type de recherche',
    'searching for'               => 'recherche de',
    'seller'                      => 'vendeur',
    'similarity'                  => 'similaire',          //similarité?
    'software'                    => 'logiciel',
    'tools and hardware'          => 'outils et matériel',
    'toys and games'              => 'jeux et jouets',
    'UK'                          => 'UK',
    'universal product code'      => 'code universel de produits',  //added: de produits
    'UPC'                         => 'UPC',
    'USA books'                   => 'livre USA',  //changed Americain into USA
    'USA'                         => 'USA',
    'used'                        => 'utilisé',
    'video movies'                => 'films',    //should be added: 'de/sur video'?
    'video'                       => 'video',
    'which server'                => 'quel serveur',
  ), 
  //Italian translations by Carlo Scornajenghi from the site musicsense.it
  'it' => array(
    'actor/actress'               => 'attore',
    'artist/musician'             => 'artista/musicista',
    'ASIN/ISBN'                   => 'ASIN/ISBN',
    'author'                      => 'autore',
    'baby'                        => 'baby',
    'books'                       => 'libri',
    'browse node'                 => 'browse nodo',
    'by'                          => 'di',
    'camera and photo'            => 'foto',
    'classical music'             => 'musica classica',
    'computer and video games'    => 'computer e video games',
    'computers'                   => 'computer',
    'customer rating'             => 'voto',
    'director'                    => 'regista',
    'Dutch'                       => 'Olandese',
    'DVD'                         => 'DVD',
    'electronics and foto'        => 'elettronica e foto',
    'electronics'                 => 'elettronica',
    'English'                     => 'Inglese',
    'Esperanto'                   => 'Esperanto',
    'exchange'                    => 'scambio',
    'German'                      => 'Tedesco',
    'Germany'                     => 'Germania',
    'Japan'                       => 'Giappone',
    'keyword'                     => 'parola chiave',
    'kitchen and housewares'      => 'cucina e casa',
    'language for page'           => 'lingua',
    'listmania'                   => 'listmania',
    'magazines'                   => 'riviste',
    'manufacturer'                => 'manufatti',
    'music'                       => 'musica',
    'new'                         => 'nuovo',
    'next results'                => 'prossimi risultati',
    'next search results'         => 'prossimi risultati cercati',
    'number of products found'    => 'numero prodotti trovati',
    'number of products'          => 'numero prodotti ',
    'of'                          => 'di',
    'outdoor living'              => 'outdoor living',
    'page'                        => 'pagina',
    'popular music'               => 'musica popolare',
    'power'                       => 'potere',
    'previous results'            => 'risultati precedenti',
    'previous search results'     => 'risultati cercati precedentemente',
    'price'                       => 'prezzo',
    'producer'                    => 'produttore',
    'product category'            => 'categoria di prodotto',
    'publisher'                   => 'editore',
    'released'                    => 'rilasciato',
    'sales rank'                  => 'rank di vendita',
    'search string'               => 'testo ricercato',
    'search type'                 => 'tipo di ricerca',
    'searching for'               => 'ricerca per',
    'seller'                      => 'venditore',
    'similarity'                  => 'similare',
    'software'                    => 'software',
    'tools and hardware'          => 'strumenti e hardware',
    'toys and games'              => 'giochi',
    'UK'                          => 'Regno Unito',
    'universal product code'      => 'codice universale di prodotto',
    'UPC'                         => 'UPC',
    'USA books'                   => 'libri USA',
    'USA'                         => 'USA',
    'used'                        => 'usato',
    'video movies'                => 'film',
    'video'                       => 'video',
    'which server'                => 'quale server'
  ),
  //Dutch translations by Jaap van Ganswijk
  'nl' => array(
    'actor/actress'               => 'acteur/actrice',
    'Amazon returned the error'   => 'Amazon gaf de fout terug',
    'artist/musician'             => 'artiest/muzikant',
    'ASIN/ISBN'                   => 'ASIN/ISBN',
    'author'                      => 'auteur',
    'baby'                        => 'baby',
    'books'                       => 'boeken',
    'browse node'                 => 'browse node',
    'by'                          => 'door',
    'camera and photo'            => 'camera en foto',
    'can\'t get data from Amazon' => 'kan geen gegevens van Amazon laden',
    'classical music'             => 'klassieke muziek',
    'computer and video games'    => 'computer- en videospelen',
    'computers'                   => 'computers',
    'customer rating'             => 'klantenwaardering',
    'database'                    => 'gegevensbestand',
    'director'                    => 'regiseur',
    'Dutch'                       => 'Nederlands',
    'DVD'                         => 'DVD',
    'electronics and foto'        => "electronica en foto's",
    'electronics'                 => 'electronica',
    'English'                     => 'Engels',
    'Esperanto'                   => 'Esperanto',
    'exchange'                    => 'ruil',
    'German'                      => 'Duits',
    'Germany'                     => 'Duitsland',
    'Japan'                       => 'Japan',
    'keyword'                     => 'sleutelwoord',
    'kitchen and housewares'      => 'keuken- en huishoudspul',
    'language for page'           => 'taal voor de pagina',
    'listmania'                   => 'top-zoveels',
    'magazines'                   => 'bladen',
    'manufacturer'                => 'fabrikant',
    'manufacturer'                => 'fabrikant',
    'music'                       => 'muziek',
    'new'                         => 'nieuw',
    'next results'                => 'volgende resultaten',
    'next search results'         => 'volgende zoekresultaten',
    'number of products found'    => 'aantal gevonden produkten',
    'number of products'          => 'aantal produkten',
    'of'                          => 'van',
    'outdoor living'              => 'buitenleven',
    'page'                        => 'pagina',
    'please add this error message to the ' => 'voeg deze foutboodschap svp. toe aan het',
    'popular music'               => 'popmuziek',
    'power'                       => 'kracht',
    'previous results'            => 'vorige resultaten',
    'previous search results'     => 'vorige zoekresultaten',
    'price'                       => 'prijs',
    'producer'                    => 'producent',
    'product category'            => 'produktcategorie',
    'publisher'                   => 'uitgever',
    'released'                    => 'uitgegeven',
    'sales rank'                  => 'verkoopsrang',
    'search string'               => 'zoekstring',
    'search type'                 => 'zoektype',
    'searching for'               => 'zoekend naar',
    'seller'                      => 'verkoper',
    'similarity'                  => 'overeenkomst',
    'software'                    => 'software',
    'tools and hardware'          => 'gereedschap',
    'toys and games'              => 'speelgoed en spelen',
    'UK'                          => 'Verenigd Koninkrijk',
    'universal product code'      => 'universele produktcode',
    'UPC'                         => 'UPC',
    'USA books'                   => 'USA boeken',
    'USA'                         => 'USA',
    'used'                        => 'gebruikt',
    'video movies'                => 'videofilms',
    'video'                       => 'video',
    'which server'                => 'welke server',
  ),
  //Norwegian translations by Bjoern Boerresen (2 times oe=&oslash)
  'no' => array(
    'actor/actress'               => 'skuespiller',
    'artist/musician'             => 'artist/musiker',
    'ASIN/ISBN'                   => 'ASIN/ISBN',
    'author'                      => 'forfatter',
    'baby'                        => 'baby',
    'books'                       => 'b&oslash;ker',
    'browse node'                 => 'browse Node',
    'by'                          => 'av',
    'camera and photo'            => 'kamera og foto',
    'classical music'             => 'klassisk musikk',
    'computer and video games'    => 'PC og videospill',
    'computers'                   => 'PC',
    'customer rating'             => 'kunde rating',
    'director'                    => 'regiss&oslash;r',
    'Dutch'                       => 'Nederlandsk',
    'DVD'                         => 'DVD',
    'electronics and foto'        => 'elektronikk og foto',
    'electronics'                 => 'elektronikk',
    'English'                     => 'Engelsk',
    'Esperanto'                   => 'Esperanto',
    'exchange'                    => 'utveksling',
    'German'                      => 'Tysk',
    'Germany'                     => 'Tyskland',
    'Japan'                       => 'Japan',
    'keyword'                     => 's&oslash;keord',
    'kitchen and housewares'      => 'Kj&oslash;kken og hvitevarer',
    'language for page'           => 'spr&aring;k p&aring; siden',
    'listmania'                   => 'listmania',
    'magazines'                   => 'magasin',
    'manufacturer'                => 'produsent',
    'music'                       => 'musikk',
    'new'                         => 'ny',
    'next results'                => 'neste resultat',
    'next search results'         => 'neste s&oslash;keresultat',
    'number of products found'    => 'antall produkter funnet',
    'number of products'          => 'antall produkter',
    'of'                          => 'av',
    'outdoor living'              => 'utend&oslash;rsliv',
    'page'                        => 'side',
    'popular music'               => 'popmusikk',
    'power'                       => 'kraft',
    'previous results'            => 'forrige resultat',
    'previous search results'     => 'forrige s&oslash;keresultat',
    'price'                       => 'pris',
    'producer'                    => 'produsent',
    'product category'            => 'produktkategori',
    'publisher'                   => 'forlag',
    'released'                    => 'utgitt',
    'sales rank'                  => 'antall solgte',
    'search string'               => 's&oslash;kestreng',
    'search type'                 => 's&oslash;ketype',                  
    'searching for'               => 's&oslash;k etter',
    'seller'                      => 'kj&oslash;per',
    'similarity'                  => 'likhet',
    'software'                    => 'programvare',
    'tools and hardware'          => 'verkt&oslash;y og jernvare',
    'toys and games'              => 'leker og spill',
    'UK'                          => 'UK',
    'universal product code'      => 'universell produkt kode',
    'UPC'                         => 'UPC',
    'USA books'                   => 'USA b&oslash;ker',
    'USA'                         => 'USA',
    'used'                        => 'brukt',
    'video movies'                => 'videofilmer',
    'video'                       => 'video',
    'which server'                => 'hvilken tjener',
  ),
  //Portuguese translations by Marcelo C. Plaza
  //I havened HTML-ized the characters yet, Jaap
  'pt' => array(
    'actor/actress'               => 'ator/atriz',
    'artist/musician'             => 'artista/músico',
    'ASIN/ISBN'                   => 'ASIN/ISBN',
    'author'                      => 'Autor',
    'baby'                        => 'Bebê',
    'books'                       => 'Livros',
    'browse node'                 => 'browse Node',
    'by'                          => 'por',
    'camera and photo'            => 'camera e foto',
    'classical music'             => 'Música Clássica',
    'computer and video games'    => 'Computadores e Vídeo Games',
    'computers'                   => 'Computadores',
    'customer rating'             => 'Avaliação dos clientes',
    'director'                    => 'Diretor',
    'Dutch'                       => 'Holandes',
    'DVD'                         => 'DVD',
    'electronics and foto'        => 'Eletrônicos e Fotografia',
    'electronics'                 => 'Eletrônicos',
    'English'                     => 'Inglês',
    'Esperanto'                   => 'Esperanto',
    'exchange'                    => 'cambio',
    'German'                      => 'Alemão',
    'Germany'                     => 'Alemanha',
    'Japan'                       => 'Japão',
    'keyword'                     => 'palavra chave',
    'kitchen and housewares'      => 'Cozinha e acessórios',
    'language for page'           => 'Linguagem da Página',
    'listmania'                   => 'listmania',
    'magazines'                   => 'revistas',
    'manufacturer'                => 'fabricante',
    'music'                       => 'música',
    'new'                         => 'novo',
    'next results'                => 'próximos',
    'next search results'         => 'anteriores',
    'number of products found'    => 'Número de produtos encontrados',
    'number of products'          => 'Número de produtos',
    'of'                          => 'de',
    'outdoor living'              => 'Vivendo ao ar livre',
    'page'                        => 'página',
    'popular music'               => 'Música Popular',
    'power'                       => 'Poder',
    'previous results'            => 'Resultados anteriores',
    'previous search results'     => 'Resultados de buscas anteriores',
    'price'                       => 'Preço',
    'producer'                    => 'Produtor',
    'product category'            => 'Categoria do Produto',
    'publisher'                   => 'Editora',
    'released'                    => 'lançamento',
    'sales rank'                  => 'rank de vendas',
    'search string'               => 'buscar frase',
    'search type'                 => 'tipo de busca',
    'searching for'               => 'procurando por',
    'seller'                      => 'vendedor',
    'similarity'                  => 'similaridade',
    'software'                    => 'Software',
    'tools and hardware'          => 'Ferramentas',
    'toys and games'              => 'Brinquedos e Jogos',
    'UK'                          => 'Reino Unido',
    'universal product code'      => 'Codigo Universal de Produto',
    'UPC'                         => 'UPC',
    'USA books'                   => 'Livros Americanos',
    'USA'                         => 'EUA',
    'used'                        => 'usados',
    'video movies'                => 'Video filme',
    'video'                       => 'Video',
    'which server'                => 'qual Servidor',
  ),
);

//translate a given string, when a translation is known
//otherwise return the original English text
//20040715: rewrote this function quite a lot
function xl($s) {  //$s=string to convert
  global $Axl;
  global $language;
  global $logfile;   //20040715: added this

  if ($language=='en') {                    //source text is already in 'en' so it doesn't have to be translated?
    $s0=$s;
  }
  else {
    for ($i=strlen($s);$i and !is_alpha(substr($s,$i-1,1));--$i);
    $s0=substr($s,0,$i);                    //first part
    $s9=substr($s,$i);                      //end part
    if (isset($Axl[$language][$s0])) {      //20040715: isset() added
      $s0=$Axl[$language][$s0];             //really translate
    }
    else {
//    if (is_writable($logfile)) {          //can we log? 20040715: this function doesn't seem to work correctly under Windows
//      error_log("$language: $s0\n",3,$logfile);  //log all not-yet translated sentences, you don't really need this...
//    }
    }
    if ($language=='eo') {                  //for Esperanto
      $s0=str_replace('&ccirc;','cx',$s0);
      $s0=str_replace('&gcirc;','gx',$s0);
      $s0=str_replace('&jcirc;','jx',$s0);
    }
    $s0.=$s9;
  }
  return $s0;
}

//translate a given string, when a translation is known
//and convert first character to uppercase
function xu($s) {  //$s=string to convert
  return ucfirst(xl($s));
}

//is character a regular abc or ABC letter?
function is_alpha($c) {
  return $c>='A' and $c<='Z' or $c>='a' and $c<='z';
}

//Please send me (ganswijk@xs4all.nl) more translations.
//Try to translate as literally as possible.
//When you don't like the original English text, change that first.

//- please send more translations
//- also translate them to other languages
//- search for 'ql(' in the code for more texts to translate
//- start by translating the nl part because it is usually the most complete one (guess why?)
//- only use capital letters for names and where your language requires it (like for nouns in German)
//- send it to ganswijk@xs4all.nl

//end
