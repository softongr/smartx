<?php

namespace App\Livewire\Orders\Phone;

use App\Models\PhoneOrder;
use App\Models\Setting;
use Dflydev\DotAccessData\Data;
use Livewire\Component;
use function Pest\Laravel\json;

class Form extends Component
{
    public $id = 0;
    public $object;

    public $firstname;
    public $lastname;
    public $phone;
    public $mobile;
    public $email;
    public $address;
    public $city;

    public $zip;
    public $note;
    public $status;

    public $payment_method;
    public $error= false;
    public $error_message= '';
    public $carrier_id;
    public $document_type ;
    public $vatnumber;
    public $flag =false;

    public $invoices = [];

    public $isEdit = false;

    public function mount($id = null)
    {
        if ($id) {
            $this->object = PhoneOrder::findOrFail($id);
            $this->id = $this->object->id;
            $this->firstname = $this->object->firstname;
            $this->lastname = $this->object->lastname;
            $this->document_type = $this->object->document_type;
            $this->isEdit = true;
        }else {
            $this->document_type = 'receipt';
        }
    }


    public function selectDocumentType(string $type): void
    {
        $this->document_type = $type;


    }
    public function render()
    {
        return view('livewire.orders.phone.form');
    }

    public function save()
    {

        $fields = [

            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'document_type' => $this->document_type,

        ];

        if ($this->isEdit) {
            $item = PhoneOrder::findOrFail($this->id);
            $item->fill($fields);
            $item->save();
        } else {
            $item = PhoneOrder::create($fields);
        }

        session()->flash('success', $this->isEdit ? __('Updated') : __('Saved'));


        return redirect()->route('orderphone.edit', ['id' => $item->id]);

    }


    public function aade()
    {
        $this->validate([
            'vatnumber' => ['required', 'regex:/^\d{9}$/'],
        ]);

        $aade = new \App\Services\AadeAfmService(Setting::get('aade_username'), Setting::get('aade_password'));
        $info = $aade->info($this->vatnumber);
        if ($info['success']) {
            $this->flag = true;
            $this->invoices = [
                'business_activity' =>  $info['business']['drastiriotita'],
                'company' => $info['business']['onomasia'],
                'doy'   => $info['business']['doyDescr'],
                'zip' =>    $info['business']['postalZipCode'],
                'address' =>  $info['business']['postalAddress'],
                'address_number' =>  $info['business']['postalAddressNo'],
            ];

//            $this->business_activity = $info['business']['drastiriotita'];
//            $this->company = $info['business']['onomasia'];
//            $this->doy = $info['business']['doyDescr'];
//            $this->zip = $info['business']['postalZipCode'];
//            $this->address = $info['business']['postalAddress'];
            $this->error = false;
            $this->error_message = '';
        }else{

            $this->error = true;
            $this->error_message = $info['reason'];

            return;
        }
    }

    public function getShowAadeButtonProperty()
    {
        return strlen(preg_replace('/\D/', '', $this->vatnumber)) === 9;
    }

    public function finish()
    {
        $rules = [
            'firstname' => 'required',
            'lastname' => 'required',
            'document_type' => 'required',
//            'vatnumber' => 'required',
            'email' => 'nullable|email',
            'address' => 'required',
            'city' => 'required',
            'zip' => 'required',
//            'payment_method' => 'required',
//            'carrier_id' => 'required',
        ];


        $this->validate($rules);

        $fields = [
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'phone' => $this->phone,
            'mobile' => $this->mobile,
            'document_type' => $this->document_type,
            'vatnumber' => $this->vatnumber,
            'email' => $this->email,
            'address' => $this->address,
            'city' => $this->city,
            'zip' => $this->zip,
            'payment_method' => 'cod',
            'invoices_data' =>  json_encode($this->invoices),
            'carrier_id' => 1,
            'shipping_cost' => 1,
            'total' => 1
        ];



         PhoneOrder::create($fields);


    }
}
