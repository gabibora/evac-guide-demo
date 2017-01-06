<?php

namespace App\Http\Controllers;

use App\Models\BusinessLocations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class BusinessLocationsController extends Controller
{
    /**
     *  Business Locations Controller
     *
     * @return void
     */
    public function __construct()
    {

    }


    /**
     *  Business location main laravel view
     *
     * @return  resource
     */

    public function index(){

        return view('businessLocations');

    }



    /**
     *  Get business locations
     *
     *   At this point we get all in one array but in the future we need too implement a pagination system here .
     *
     * @return array
     */

    public function listLocations()
    {
        $all=BusinessLocations::all()->toArray();

        if(!empty($all)){

        foreach ($all as $k=> $loc){

            if(!empty($loc['pictures'])){

                $all[$k]['thumb']=[];

                foreach ($loc['pictures'] as $key =>$pic){

                    $all[$k]['thumb'][]=[

                        'thumbURL'=>  $this->getS3Url('thumbnails/'.$pic),
                        'srcURL'=>  $this->getS3Url('src/'.$pic),

                    ];

                }



            }

        }
        }

     return   response()->json(['locations'=>$all]);




    }


    /**
     *  Get business location
     *
     * @return array
     */

    public function get($id){

        $location=BusinessLocations::find($id)->toArray();

        if(isset($location)){


            if(!empty($location['pictures'])){


                $location['thumb']=[];

                foreach ($location['pictures'] as $key =>$pic){

                    $location['thumb'][]=[

                        'thumbURL'=>  $this->getS3Url('thumbnails/'.$pic),
                        'srcURL'=>  $this->getS3Url('src/'.$pic),

                    ];

                }


            }

            return response()->json(['location'=>$location]);

        } else {

            return response()->json(['error'=>'Location not found'],404);


        }

    }

    /**
     *  Create a new business location
     *
     * @return object
     */


    public function create(Request $request){

        $this->validate($request, [
            'location.name' => 'required',
            'location.address_1' => 'required',
            'location.postal_code' => 'required',
            'location.pictures'=>'array'
        ]);

        $location=BusinessLocations::create($request->location);


         if(isset($location->id)) {

             return response()->json(['id'=>$location->id]);


         } else {

             return response()->json(['error'=>'Unespected error'],500);

         }



    }


    /**
     *  Update a  business location
     *
     * @return object
     */


    public function update(Request $request){


        $this->validate($request, [
            'location.name' => 'required',
            'location.address_1' => 'required',
            'location.postal_code' => 'required',
            'location.pictures'=>'array'
        ]);

        $data=$request->toArray();

        if(isset($request['location']['id'])){

            $location=BusinessLocations::find($request['location']['id']);
            if($location) {

              $resp=  $location->update($request['location']);

            }

            return   response()->json(['success'=>$resp,'location'=>$location ]);

        } else {

            return    response()->json(['error'=>'ID not found' ],500);


        }


    }


    /**
     *  Delete a business location
     *
     * @return object
     */

    public function delete(){



    }

    /**
     *  Upload a business location image
     *
     * @return object
     */

    public function upload(Request $request){

        $image=$request->file('file');

        if(isset($image ) ){

            $image_normal = Image::make($image)->widen(800, function ($constraint) {
                $constraint->upsize();
            });

            $image_thumb = Image::make($image)->resize(100,100);
            $image_normal = $image_normal->stream();
            $image_thumb = $image_thumb->stream();


            // I have created 2 folders one for main image and one for thumbnails.
            // As convention the file name is the same for both only folder are different.
            $imageFileName =  self::generateRandomString(). '.' . $image->getClientOriginalExtension();
            $filePath = 'src/' . $imageFileName;

            Storage::disk('s3')->put($filePath, $image_normal->__toString());
            Storage::disk('s3')->put('thumbnails/'.$imageFileName, $image_thumb->__toString());


            return response()->json(['image'=>$imageFileName]);

        }







    }

    /**
     *  Get AWS S3 signed request to download or use the images
     *
     * @return object
     */


    private function getS3Url($filename){

        $s3 = Storage::disk('s3');
        $client = $s3->getDriver()->getAdapter()->getClient();
        $expiry = "+10 minutes";

        $command = $client->getCommand('GetObject', [
            'Bucket' => \Config::get('filesystems.disks.s3.bucket'),
            'Key'    => "$filename"
        ]);

        $request = $client->createPresignedRequest($command, $expiry);

        return (string) $request->getUri();

    }

    static function generateRandomString($length = 12) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString.'_'.time();
    }



}