<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

Use App\Routers;
class RouterController extends Controller{
    /**
     * Create a new controller instance.
     *
     * @return void
   */
    public function __construct()
    {
        //$this->middleware('auth');
    }
    /*
    * @return list router view
    *
    */
    public function listEmployee(){
       $Routers=Routers::where('is_deleted','=','0')->paginate(5);
       return view('routers.list',compact('Routers'));
    }
     /*
     * @return create new router view
     *
     */
     public function createRouter(){
        //$Companies=Companies::all();
        return view('routers.create');
     }
     /*
     * @param Request $request
     * @return void
     *
     */
     public function storeRouter(Request $request){
          $validator = Validator::make($request->all(),[
                           'txtDnsRecord' => 'required|integer|max:255',
                           'txtInternetHostName' => 'required',
                           'txtClientIpAddress' => 'required',
                           'txtMacAddress' => 'required',
                        ]);
          if ($validator->fails()) {
            return response()->json(['status'=>'errors', 'message'=>$validator->errors()]);
            // return redirect()->route('employee.create')
            //             ->withErrors($validator)
            //             ->withInput();
          }else{
              $Routers=new Routers();
              $Routers->dns_records=$request->txtDnsRecord;
              $Routers->internet_host_name=$request->txtInternetHostName;
              $Routers->client_ip_address=$request->txtClientIpAddress;
              $Routers->mac_address=$request->txtClientIpAddress;
              $Routers->save();
              return response()->json(['status'=>'success', 'message'=>'Router added successfully.']);

         }

     }
     /*
     * @param $id
     * @return edit router view
     *
     */
     public function editRouter($id){

        $id=$id."==";
        $routerId=base64_decode(trim($id));
        $router=Routers::where('id','=',$routerId)->where('is_deleted','=','0')->get()->first();

        if(empty($router)){
           abort(404);
        }

        return view('routers.edit',compact('router'));
     }

     /*
     * @param Request $request
     * @return void
     *
     */
     public function updateRouter(Request $request){
       $validator = Validator::make($request->all(),[
                        'txtDnsRecord' => 'required|integer|max:255',
                        'txtInternetHostName' => 'required',
                        'txtClientIpAddress' => 'required',
                        'txtMacAddress' => 'required',
                     ]);
         if ($validator->fails()) {
           return response()->json(['status'=>'errors', 'message'=>$validator->errors()]);
           // return redirect()->route('employee.create')
           //             ->withErrors($validator)
           //             ->withInput();
         }else{
            try{
                $id=trim($request->txtHiddenRouterId);
                $id=$id."==";
                $routerId=base64_decode(trim($id));
                $router=Routers::where('id','=',$routerId)->where('is_deleted','=','0')->get()->first();
                if(empty($router)){
                   return response()->json(['status'=>'error', 'message'=>'something went wrong.']);
                }
                $router->dns_records=$request->txtDnsRecord;
                $router->internet_host_name=$request->txtInternetHostName;
                $router->client_ip_address=$request->txtClientIpAddress;
                $router->mac_address=$request->txtMacAddress;
                $router->save();
                return response()->json(['status'=>'success', 'message'=>'Router updated successfully.']);
            }catch(\Illuminate\Database\QueryException $ex){

                 abort(404);
            }
         }

     }

     /*
     * @param $id
     * @return void
     *
     */
     public function deleteRouter($id){
         try{
             $id=trim($id);
             $id=$id."==";
             $routerId=base64_decode(trim($id));
             $routers=Routers::where('id','=',$routerId)->where('is_deleted','=','0')->get()->first();
             if(empty($routers)){
                return response()->json(['status'=>'error', 'message'=>'Something went wrong.']);
             }
             $routers->is_deleted='1';
             $routers->save();
             return response()->json(['status'=>'success','message'=>'Router deleted Successfully.']);
        }catch(\Illuminate\Database\QueryException $ex){
             abort(404);
        }
     }
}
