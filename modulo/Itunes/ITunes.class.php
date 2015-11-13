<?php

/*namespace Meteorum\API\ITunes;*/

/**
 * iTunes API Class
 * Interacts with iTunes to get information
 *
 * @package    Meteorum
 * @subpackage API
 * @author     Erich Seidl Roveda <erich@meteorum.com.br>
 */
final class ITunes
{
    /**
     * @var string 
     */
    private $search_url = 'https://itunes.apple.com/search?';

    /**
     * @var string 
     */
    private $lookup_url = 'https://itunes.apple.com/lookup?';

    /**
     * @var array Avaiable values
     */
    private $values = array(
        'media' => array(
            'all', 'audiobook', 'ebook', 'movie',
            'music', 'musicVideo', 'podcast', 'shortFilm',
            'software', 'tvShow'
        ),
        'entity' => array(
            'album',
            'allArtist', 'allTrack', 'audiobook', 'audiobookAuthor',
            'ebook', 'iPadSoftware', 'macSoftware', 'mix',
            'movie', 'movieArtist', 'musicArtist', 'musicTrack',
            'musicVideo', 'podcast', 'podcastAuthor', 'shortFilm',
            'shortFilmArtist', 'software', 'song', 'tvEpisode',
            'tvSeason'
        ),
        'attribute' => array(
            'actorTerm', 'albumTerm', 'allArtistTerm', 'allTrackTerm',
            'artistTerm', 'authorTerm', 'composerTerm', 'descriptionTerm',
            'directorTerm', 'featureFilmTerm', 'genreIndex', 'keywordsTerm',
            'languageTerm', 'mixTerm', 'movieArtistTerm', 'movieTerm',
            'producerTerm', 'ratingIndex', 'ratingTerm', 'releaseYearTerm',
            'shortFilmTerm', 'showTerm', 'softwareDeveloper', 'songTerm',
            'titleTerm', 'titleTerm', 'tvEpisodeTerm', 'tvSeasonTerm'
        )
    );

    /**
     * @var mixed
     */
    private $result;

    /**
     * @var mixed
     */
    public $attribute;

    /**
     * @var string
     */
    public $callback;

    /**
     * @var string
     */
    public $country = 'US';

    /**
     * @var string
     */
    public $entity;

    /**
     * @var string
     */
    public $explicit;

    /**
     * @var string
     */
    public $lang;

    /**
     * @var integer
     */
    public $limit;

    /**
     * @var string
     */
    public $media;

    /**
     * @var mixed
     */
    public $term;

    /**
     * @var integer
     */
    public $version = 2;

    /**
     * Constants
     */
    const ITUNES_RETURN_ARTIST_ID           = 'artistId';
    const ITUNES_RETURN_ARTIST_NAME         = 'artistName';
    const ITUNES_RETURN_COLLECTION_ID       = 'collectionId';
    const ITUNES_RETURN_COLLECTION_NAME     = 'collectionName';
    const ITUNES_RETURN_TRACK_ID            = 'trackId';
    const ITUNES_RETURN_TRACK_NAME          = 'trackName';
    const ITUNES_RETURN_TRACK_NUMBER        = 'trackNumber';
    const ITUNES_RETURN_TRACK_TIME          = 'trackTimeMillis';
    const ITUNES_RETURN_TRACK_URL           = 'trackViewUrl';
    const ITUNES_RETURN_GENRE               = 'primaryGenreName';
    const ITUNES_RETURN_PREVIEW_URL         = 'previewUrl';
    const ITUNES_RETURN_ARTWORK_MIN_URL     = 'artworkUrl30';
    const ITUNES_RETURN_ARTWORK_MED_URL     = 'artworkUrl60';
    const ITUNES_RETURN_ARTWORK_MAX_URL     = 'artworkUrl100';
    //@TODO verificar se não vai dar conflito com as mensagens de erro das outras classes
    const E_ITUNES_INVALID_ATTRIBUTE        = 0;
    const E_ITUNES_INVALID_VALUE            = 1;
    const E_ITUNES_INVALID_RETURN_ATTRIBUTE = 2;
    const E_ITUNES_EMPTY_ARTIST             = 3;
    const E_ITUNES_EMPTY_TRACK              = 4;

    /**
     * Disable direct setting of attributes
     * @param string $name
     * @param string $value
     * @return false
     */
    public function __set($attribute, $value)
    {
        return false;
    }

    /**
     * Request the data from iTunes 
     * @param string $url iTunes url
     * @return string
     */
    private function send($url)
    {
        $curl = curl_init($url.http_build_query($this->toArray()));
        curl_setopt($curl, CURLOPT_FRESH_CONNECT, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $exec = curl_exec($curl);
        if ($no   = curl_errno($curl)) {
            throw new ITunesException(curl_error($curl), $no);
        }
        curl_close($curl);
        return $exec;
    }

    /**
     * Return object as an array 
     */
    private function toArray()
    {
        $arr      = array();
        $excluded = array('search_url', 'lookup_url', 'values', 'result');
        foreach ($this as $key => $value) {
            if (!in_array($key, $excluded)) {
                $arr[$key] = trim((is_array($value)) ? implode(' ', $value) : $value);
            }
        }
        return array_filter($arr);
    }

    /**
     * Add attributes do requisition
     * @param string $attribute Attribute name
     * @param string $value Attribute value
     * 
     */
    public function addAttr($attribute, $value)
    {
        if (property_exists($this, $attribute)) {
            // Invalid value
            if (isset($this->values[$attribute]) && !in_array($value,
                    $this->values[$attribute])
            ) {
                throw new ITunesException(self::E_ITUNES_INVALID_VALUE);
            }
            // Append values if more than on is added
            if (!empty($this->$attribute)) {
                if (!is_array($this->$attribute)) {
                    $this->$attribute = array($this->$attribute);
                }
                return array_push($this->$attribute, trim($value));
            }
            return $this->$attribute = trim($value);
        }
        // Invalid Attribute
        throw new ITunesException(self::E_ITUNES_INVALID_ATTRIBUTE);
    }

    /**
     * Search and return the data obtained
     * @return mixed
     */
    public function search()
    {
        $result       = $this->send($this->search_url);
        $json         = json_decode($result, true);
        return $this->result = ($json['resultCount']) ? $json : false;
    }

    /**
     * Check if attribute exists on the result and return it
     * @param string $attribute Return Attribute name
     * @return string
     */
    public function getReturnAttribute($attribute, $account = null, $category = null)
    {


        $sufx = '';

        if (!is_null($account))
           $sufx .= '&at='.$account;

        if (!is_null($category))
           $sufx .= '&ct='.$category;

        if ($this->result['resultCount'] == 1) {
            if (!isset($this->result['results']['0'][$attribute])) {
                throw new ITunesException(self::E_ITUNES_INVALID_RETURN_ATTRIBUTE);
            }
            return $this->result['results']['0'][$attribute].$sufx;
        }
    }

    /**
     * Searches for an track
     * @param string $artist Artist name
     * @param string $track_name Track name
     * @param string $album [optional] Album name
     * @param integer $return [optional] Return attribute name
     * @return mixed
     */
    public static function searchTrack($artist, $track_name, $album = null, $return = null, $account = null, $category = null)
    {
        if (empty($artist)) {
            throw new ITunesException(self::E_ITUNES_EMPTY_ARTIST);
        }
        if (empty($track_name)) {
            throw new ITunesException(self::E_ITUNES_EMPTY_TRACK);
        }
        $obj = new self();
        $obj->addAttr('entity', 'musicTrack');
        $obj->addAttr('limit', '1');
        $obj->addAttr('term', $artist);
        $obj->addAttr('term', $track_name);
        if (!is_null($album)) {
            $obj->addAttr('term', $album);
        }
        $result = $obj->search();
        if (!is_null($return)) {
            return $obj->getReturnAttribute($return,$account, $category);
        }

        $sufx = '';

        if (!is_null($account))
           $sufx .= '&at='.$account;

        if (!is_null($category))
           $sufx .= '&ct='.$category;

       $result_f = $result['results'][0];

       if(is_null($result_f))
            return null;

        return $result_f.$sufx;
    }
}

/**
 * ITunes Exception Class
 * Handles ITunes Exceptions
 *
 * @package    Meteorum
 * @subpackage ITunes
 * @author     Erich Seidl Roveda <erich@meteorum.com.br>
 */
final class ITunesException extends \ErrorException
{
    
}
?>