<?php
/**
 * Created by PhpStorm.
 * User: joalissonbarros
 * Date: 2019-04-20
 * Time: 10:05
 */

namespace App\Traits;


use Symfony\Component\HttpFoundation\JsonResponse;

trait ResponseTrait
{

    /**
     * @param \stdClass $data
     * @return JsonResponse
     */
    public function responseOK($data) : JsonResponse
    {
        $response = new JsonResponse();
        $response->setData($data);
        $response->setStatusCode(200);
        $response->setCharset('UTF-8');
        $response->setEncodingOptions(JSON_PRETTY_PRINT);
        return $response;

        // return (new JsonResponse())
        //         ->setData($data)
        //         ->setStatusCode(200);
    }

    public function responseNotOK($data) : JsonResponse
    {
        $response = new JsonResponse();
        $response->setData($data);
        $response->setStatusCode(400);
        $response->setCharset('UTF-8');
        $response->setEncodingOptions(JSON_PRETTY_PRINT);
        return $response;
        // return (new JsonResponse())
        //         ->setData($data)
        //         ->setStatusCode(400);
    }

     public function obj2array (&$objeto ) {
        $clone = (array) $objeto;
        $rtn = array ();
        $retorno = array ();
        $rtn['___SOURCE_KEYS_'] = $clone;
    
        while ( list ($key, $value) = each ($clone) ) {
            $aux = explode ("\0", $key);
            $newkey = $aux[count($aux)-1];
            $theValue = &$rtn['___SOURCE_KEYS_'][$key];
            if (is_object($theValue) && get_class($theValue) == 'DateTime' ) {
                
                 $theValue = $theValue->format('Y-m-d H:i:s');
                
            }
            if (is_array($theValue) ) {
                $t =[];
                foreach($theValue as $v){
                    $t[] = $this->obj2array($v);
                }
                $theValue = $t;
           }
            

            

            $retorno[$newkey] = $theValue;
        }
    
        return $retorno;
    }

}