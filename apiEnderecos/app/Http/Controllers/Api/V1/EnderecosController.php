<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Endereco\SaveRequest;
use App\Http\Resources\EnderecosResourse;
use App\Models\Enderecos;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Http;

class EnderecosController extends Controller
{
    /**
     * @return AnonymousResourceCollection
     */
    public function showAll()
    {
        $enderecos = Enderecos::all();
        return EnderecosResourse::collection($enderecos);
    }

    /**
     * @param $value
     * @return AnonymousResourceCollection
     */
    public function show($value)
    {
        $value = substr($value, 0, 5) . '-' . substr($value, -3);
        $enderecos = Enderecos::where('id', $value)
            ->orWhere('cep', $value)
            ->orWhere('cep', 'like', $value . '%')
            ->orWhere('logradouro', $value)
            ->orWhere('logradouro', 'like', '%' . $value . '%')
            ->get();

        $value = str_replace('-', '', $value);
        if ($enderecos->isEmpty() && strlen($value) == 8) {
            $response = Http::get('https://viacep.com.br/ws/' . $value . '/json/')->json();
            $response['cidade'] = $response['localidade'];
            $endereco = Enderecos::create($response);
            $enderecos = Enderecos::where('id', $endereco['id'])->get();
        }

        return EnderecosResourse::collection($enderecos);
    }

    /**
     * @param SaveRequest $request
     * @return EnderecosResourse|JsonResponse
     */
    public function save(SaveRequest $request)
    {
        $data = $request->validated();
        $data['cep'] = substr($data['cep'], 0, 5) . '-' . substr($data['cep'], -3);
        $endereco = Enderecos::where('cep', $data['cep'])->first();
        if ($endereco) {
            return response()->json([
                'message' => 'Endereço já cadastrado!'
            ], 422);
        }
        $endereco = Enderecos::create($data);
        return new EnderecosResourse($endereco);
    }


    /**
     * @param Request $request
     * @param $id
     * @return EnderecosResourse | JsonResponse
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        if (isset($data['cep'])) {
            $endereco = Enderecos::where('cep', $data['cep'])->first();
            if (!empty($endereco) && $endereco['id'] != $id && $endereco['cep'] == $data['cep']) {
                return response()->json([
                    'message' => 'Endereço já cadastrado!'
                ], 422);
            }
        }
        $endereco = Enderecos::findOrFail($id);
        $endereco->update($data);
        return new EnderecosResourse($endereco);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $adress = Enderecos::findOrFail($id);
        $adress->delete();
        return response()->json([
            'message' => 'Endereço deletado com sucesso!'
        ], 200);
    }
}
