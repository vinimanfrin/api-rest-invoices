<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\api\InvoiceResource;
use App\Models\Invoice;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InvoiceController extends Controller
{
    use HttpResponses;

    public function index(Request $request)
    {
        return InvoiceResource::collection(Invoice::with('user')->get());
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(),[
            'user_id' => 'required',
            'type' => 'required|max:1',
            'paid' => 'required|numeric|between:0,1',
            'payment_date' => 'nullable',
            'value' => 'required|numeric|between:1,9999.99'
        ]);
        if ($validator->fails()){
            return $this->error('Data Invalid',422,$validator->errors());
        }

        $created = Invoice::create($validator->validated());

        if ($created){
            return $this->response('Invoice created', 200,new InvoiceResource($created->load('user')));
        }
        return $this->error('Invoice not created',400);
    }

    public function show(Invoice $invoice)
    {
        return new InvoiceResource($invoice);
    }

    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(),[
            'user_id' => 'required',
            'type' => 'required|max:1|in:' . implode(',',['B','C','P']),
            'paid' => 'required|numeric|between:0,1',
            'value' => 'required|numeric',
            'payment_date' => 'nullable|date_format:Y-m-d H:i:s'
        ]);
        if ($validator->fails()){
            return $this->error('Validation failed',422,$validator->errors());
        }
        $validated = $validator->validated();

        $invoice = Invoice::find($id);

        $updated = $invoice->update([
            'user_id' => $validated['user_id'],
            'type' => $validated['type'],
            'paid' => $validated['paid'],
            'value' => $validated['value'],
            'payment_date' => $validated['paid'] != 0 ? $validated['payment_date'] : null
        ]);

        if ($updated){
            return  $this->response('Invoice updated',200,new InvoiceResource($invoice->load('user')));
        }

        return $this->error('Invoice not Updated', 400);
    }

    public function destroy(Invoice $invoice)
    {
        $deleted = $invoice->delete();

        if ($deleted){
            return $this->response('Invoice deleted',204);
        }
        return $this->error('Invoice not deleted', 400);

    }
}
