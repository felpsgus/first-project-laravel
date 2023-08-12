<?php

namespace App\Http\Controllers;

use App\Http\Requests\Adress\SaveRequest;
use App\Models\Adress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AdressController extends Controller
{
    public function index()
    {
        $adresses = Adress::all();
        return view('home', compact('adresses'));
    }

    public function search(Request $request)
    {
        $cep = $request->input('postalCode');
        $cep = substr($cep, 0, 5) . '-' . substr($cep, -3);
        $adress = Adress::where('postalCode', $cep)->first();

        if (!$adress) {
            $cep = $request->input('postalCode');
            $cep = str_replace('-', '', $cep);
            $response = Http::get("viacep.com.br/ws/$cep/json/")->json();

            return view('add', array(
                'response' => array(
                    'postalCode' => $response['cep'],
                    'street' => $response['logradouro'],
                    'number' => '',
                    'neighborhood' => $response['bairro'],
                    'complement' => $response['complemento'],
                    'city' => $response['localidade'],
                    'state' => $response['uf']
                )
            ));
        }

        $response = $adress->attributesToArray();
        return view('add', compact('response'));
    }

    public function save(SaveRequest $request)
    {
        $data = $request->all();
        if (isset($data['idAdress'])){
            unset($data['_token']);
            $adress = Adress::where('idAdress', $data['idAdress'])->update($data);

            return redirect()->route('home')->with('success', 'Endereço atualizado com sucesso!');
        }

        $adress = Adress::create($data);
        return redirect()->route('home')->with('success', 'Endereço cadastrado com sucesso!');
    }
}
