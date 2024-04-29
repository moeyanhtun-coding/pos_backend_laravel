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

    public function index()
    {
        $staff = Staff::get();

        return $this->success(StaffResource::collection($staff), 'success', 200);
        
    }

    

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStaffRequest $request)
    {
       
       $validatedData = $request->validated();

       $staffCode =  "Stf_" . mt_rand(3000, 999999);

       $validatedData["staffCode"] = $staffCode;

       $staff =  $this->staff->insert($validatedData);

        if ($staff) {
            return $this->success(StaffResource::make($staff), "success", 200);
            
        }
    }

    /**
     * Display the specified resource.
     */
    public function show( $id)
    {
        $staff = $this->staff->getDataById($id);

        if ($staff) {
            return $this->success(StaffResource::make($staff), 'success', 200);

        }else{
            return $this->error($staff, 'No data found', 404);
           
        }
    }



    /**
     * Update the specified resource in storage.
     */
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $staff =   $this->staff->destroy($id);

        if($staff) {
            return $this->success(null, 'deleted', 200);
       }else {
        return $this->error($staff, "No data found",404 );    

       }
    
    }
}
