<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::get();
        return view('backend.config.customer', compact('customers'));
    }

    public function store(Request $request)
    {
        $names = $request->input('name');
        $descriptions = $request->input('description');
        $images = $request->file('image');
        $old_images = $request->input('old_image');
        $customer_ids = $request->input('customer_id') ?? [];


        $currentIds = Customer::pluck('id')->toArray();


        $formIds = array_filter($customer_ids, fn($id) => !empty($id));


        $deletedIds = array_diff($currentIds, $formIds);


        foreach ($deletedIds as $delId) {
            $customer = Customer::find($delId);
            if ($customer) {

                if ($customer->image && file_exists(public_path('storage/' . $customer->image))) {
                    unlink(public_path('storage/' . $customer->image));
                }
                $customer->delete();
            }
        }

        $count = count($names);

        for ($i = 0; $i < $count; $i++) {
            $customer = null;


            if (!empty($customer_ids[$i])) {
                $customer = Customer::find($customer_ids[$i]);
                if (!$customer) {

                    $customer = new Customer();
                }
            } else {

                $customer = new Customer();
            }

            $customer->name = $names[$i];
            $customer->description = $descriptions[$i];



            if (isset($images[$i])) {
                $image = $images[$i];
                $filename = time() . '_' . $image->getClientOriginalName();

                $destinationPath = public_path('storage/customer');
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }


                if (!empty($customer->image) && file_exists(public_path('storage/' . $customer->image))) {
                    unlink(public_path('storage/' . $customer->image));
                }

                $image->move($destinationPath, $filename);
                $customer->image = 'storage/customer/' . $filename;
            } else {

                if (!empty($old_images[$i])) {
                    $customer->image = $old_images[$i];
                } else {

                    $customer->image = null;
                }
            }

            $customer->save();
        }

        return redirect()->back()->with('success', 'Cập nhật  thành công!');
    }
}