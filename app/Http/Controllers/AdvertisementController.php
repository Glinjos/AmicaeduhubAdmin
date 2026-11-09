<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;

use Illuminate\Http\Request;

use DB;

use App\Models\advertisementsModel;

use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Session;

class AdvertisementController extends Controller
{
   
    public function __construct()
    {

        date_default_timezone_set("Asia/Calcutta");   //India time (GMT+5:30)

        $currentDateTime = date('Y-m-d H:i:s');
        $currentDate = date('Y-m-d');
        $currentTime = date('H:i:s');

        $this->currentDate = $currentDate;
        $this->currentTime = $currentTime;
        $this->currentDateTime = $currentDateTime;
        
    }
    


// Add Advertisement

    public function add_advertisements(Request $request)
    {
        
      
        $heading = $request->get('heading');
        $contenttype = $request->get('contentType');


        if(request()->hasFile('image'))
        {
            $image = request()->file('image');
            $extension = $image->getClientOriginalExtension();
            $fileName = 'ads_pic_' . time() . '.' . $extension;
            $image->move(public_path('assets/ad_images'), $fileName);
            $input['image'] = 'assets/ad_images/' . $fileName;


        }
        
        else
        {
            $fileName="0";
            
        }
        
        if($request->get('videos'))
        {
            $videos= $request->get('videos');
        }
        else
        {
            $videos="0";
        }

        
        
        if($request->has('addType'))
        {
            $addtype=$request->get('addType');

        }
        else
        {
            $addtype="1";
        }

        
        $isAvail='0';
        $createdBy= request('user_id');
        $updatedBy='0';
        $createdAt= $this->currentDateTime;
        $updatedAt= $this->currentDateTime;
        
        
        $advertisement['heading'] = $heading;
        $advertisement['contentType'] = $contenttype;
        $advertisement['image'] =$fileName;
        $advertisement['videos'] = $videos;
        $advertisement['addType'] =$addtype ;
        $advertisement['isAvail'] =$isAvail ;
        $advertisement['created_by'] = $createdBy;
        $advertisement['created_at'] = $createdAt;
        $advertisement['updated_by'] = $updatedBy;
        $advertisement['updated_at'] = $updatedAt;

         $advertisementsave = new advertisementsModel($request->input());
         $advertisementsave->fill($advertisement);
         $advertisementsave->save();
         
        return redirect()->back()->with('success','Advertisement Added Successfully');


    }


// Advertisement Add Form 

    function AdvertisementForm(Request $request)
    {
        $select=DB:: select("SELECT `adId`, `heading`, `contentType`, `image`, `videos`, `addType`, `isAvail` FROM `advertisements` ORDER BY `isAvail`='1' ");

        return view('ads/advertisement', compact('select'));
    }

// Advertisement Update Form

    public function updateAdvertisementForm($adId)
    {
        
        $advertisements = advertisementsModel::select('adId','heading','contentType','image','videos','addType')->where('adId',$adId)->get();
        
        return view('ads/AdvertisementUpdate', compact('advertisements'));

    }



// Update Advertisement

    public function updateAdvertisements(Request $request,$adId)
    {
        

        $heading = $request->get('heading');
        
        $contenttype = $request->get('contentType');


        if(request()->hasFile('image'))
        {
            $image = request()->file('image');
            $extension = $image->getClientOriginalExtension();
            $fileName = 'ads_pic_' . time() . '.' . $extension;
            $image->move(public_path('assets/ad_images'), $fileName);
            $input['image'] = 'assets/ad_images/' . $fileName;

            $images = DB::table('advertisements')
                ->where('adId', $adId)
                ->get(['image']);

                foreach ($images as $image) {

                    $filePath = public_path('assets/ad_images/'.$image->image);
            
                    if (file_exists($filePath)) {
                        unlink($filePath);
                    }
                 }



                if($request->get('videos'))
                {
                    if( $contenttype == '1')
                    {
                        $videos= $request->get('videos');
                    }
                    else
                    {
                        $videos="0";
                    }
                }
                else
                {
                $videos="0";
                }

                if($request->has('addType'))
                {
                    $addtype=$request->get('addType');

                }
                else
                {
                    $addtype="1";
                }


                $updatedBy= request('user_id');
                $isAvail='0';
                $updatedAt= $this->currentDateTime;


        

        

                $advertisements = advertisementsModel::find($adId);

                $advertisements->update([
                    'adId' => $adId,
                    'heading' => $heading,
                    'contentType' => $contenttype,
                    'image' => $fileName,
                    'addType' => $addtype,
                    'isAvail' => $isAvail,
                    'videos' => $videos,
                    'updated_by' => $updatedBy,
                    'updated_at' => $updatedAt
                ]);


                return redirect("/advertisements")->with('success', 'Advertisement Updated');
            
        }
        else
        {
            if($request->get('videos'))
            {
                if( $contenttype == '1')
                {
                    $videos= $request->get('videos');
                    $addtype="1";
                        
                }
                else
                {
                    $videos="0";
                }
            }
            else
            {
                $videos="0";
            }

            if($request->has('addType'))
            {
                $addtype=$request->get('addType');

            }
            else
            {
                $addtype="1";
            }

            $updatedBy= request('user_id');
            $isAvail='0';
            $updatedAt= $this->currentDateTime;
        

            $advertisements = advertisementsModel::find($adId);

            $advertisements->update([
                'adId' => $adId,
                'heading' => $heading,
                'contentType' => $contenttype,
                
                'addType' => $addtype,
                'isAvail' => $isAvail,
                'videos' => $videos,
                'updated_by' => $updatedBy,
                'updated_at' => $updatedAt
            ]);


            return redirect("/advertisements")->with('success', 'Advertisement Updated');
            
        }
        
        
        
    }


// Active Advertisement

    public function advertisementInactive($adId)
    {
        $isAvail='1';
        $advertisements = advertisementsModel::find($adId);

        $advertisements->update([
            'adId'=>$adId,
            'isAvail' => $isAvail,
        ]);
        return redirect()->back()->with('success','Advertisement Deactivated');
    }
    public function advertisementActive($adId)
    {
        $isAvail='0';
        $advertisements = advertisementsModel::find($adId);

        $advertisements->update([
            'adId'=>$adId,
            'isAvail' => $isAvail,
        ]);
        return redirect()->back()->with('success','Advertisement Activated');
    }


// Delete Advertisement 

    public function deleteAdvertisement($adId)
    {
        $images = DB::table('advertisements')
         ->where('adId', $adId)
         ->get(['image']);
         
       
        DB::table('advertisements')->where('adId', $adId)->delete();

        foreach ($images as $image) {

        $filePath = public_path('assets/ad_images/'.$image->image);

        if (file_exists($filePath)) {
            unlink($filePath);
        }
     }

        return redirect()->back()->with('success','Advertisement Deleted');
    }

    
}

