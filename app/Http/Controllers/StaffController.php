<?php

namespace App\Http\Controllers;

use App\Models\Staff;

use App\Http\Resources\StaffResource;
use App\Http\Requests\StoreStaffRequest;
use App\Http\Requests\UpdateStaffRequest;
use App\Services\StaffService;
use App\Traits\HttpResponses;

class StaffController extends Controller
{
    use HttpResponses;
    protected $staff;

   

    public function __construct(StaffService $staff)
    {
        $this->staff = $staff;
    }

  /**
 * @OA\Info(
 *      title="My First API",
 *      version="0.1"
 * )
 *
 * @OA\Get(
 *     path="/api/staff",
 *     summary="Get all staff",
 *     operationId="getStaff",
 *     tags={"Staff"},
 *     @OA\Response(
 *         response=200,
 *         description="Successful operation",
 *        
 *     ),
 *     security={{"api_key": {}}}
 * )
 */
    public function index()
    {
        $staff = Staff::with('shop')->get();

        $resStaff = StaffResource::collection($staff);

        return $this->success($resStaff, 'success', 200);
        
    }

     
    public function store(StoreStaffRequest $request)
    {
       
       $validatedData = $request->validated();

       $staffCode =  "Stf_" . mt_rand(3000, 999999);

       $validatedData["staffCode"] = $staffCode;
    //    $validatedData["staff_id"] = $request->staff_id;

       $staff =  $this->staff->insert($validatedData);

       $resStaff = StaffResource::make($staff);

        if ($staff) {
            return $this->success($resStaff, "success", 200);
            
        }
    }
     
    public function show( $id)
    {
        $staff = $this->staff->getDataById($id);
        $resStaff = StaffResource::make($staff);

        if ($staff) {
            return $this->success($resStaff, 'success', 200);

        }else{
            return $this->error($staff, 'No data found', 404);
           
        }
    }


  
    public function update(UpdateStaffRequest $request, string  $id)
    {
        $staff =  $this->staff->update($request->validated(), $id);
        

        if($staff) {
            $updatedStaff = $this->staff->getDataById($id);
            return $this->success(StaffResource::make($updatedStaff), 'Updated', 200);
       }else {
            return $this->error(null, "No data found",404 );    
       }
    }

    public function destroy(string $id)
    {
        $staff =   $this->staff->destroy($id);

        if($staff) {
            return $this->success(null, 'deleted', 200);
       }else {
        return $this->error(null, "No data found",404 );    
       }
    
    }
}
