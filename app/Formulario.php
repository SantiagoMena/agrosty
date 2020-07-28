<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\Formulario as FormularioMail;

class Formulario extends Model
{
    public function esSpam(){
        $palabras = [
            'viagra' => 5, 
            'oferta' => 4, 
            'ofertas' => 4, 
            'buy' => 5, 
            'contactanos' => 3, 
            'tarifas' => 2, 
            'stock' => 1
        ];

        $texto = $this->mensaje;

        $limiteScore = 2.5;
        $apariciones = 0;
        $totalApariciones = 0;
        $total = 0;

        foreach ($palabras as $palabra => $valor) {
            preg_match("/($palabra)/", strtolower($texto), $aparicionesSpam, PREG_OFFSET_CAPTURE);
            if (count($aparicionesSpam) > 0) {
                $total += $valor;
                $apariciones++;
            }
        }

        if($total && $apariciones) {
            $promedio = $total / $apariciones;

            return $promedio > $limiteScore;
        }

        return false;
    }

    public static function inbox($request): array
    {
        header("Access-Control-Allow-Origin: *");
        try {
            $formulario = new self;
            $formulario->nombre = $request->nombre;
            $formulario->email = $request->email;
            $formulario->asunto = $request->asunto;
            $formulario->mensaje = $request->mensaje;
            $formulario->es_spam = $formulario->esSpam();

            if( $formulario->save() ) {
                // send mail
                $email = 'santiagomenape@gmail.com';
                Mail::to($email)->send(new FormularioMail($formulario));

                $formularios = DB::table('formularios')
                                ->select('es_spam', 'asunto', DB::raw('count(asunto) as cantidad'))
                                ->groupBy('asunto', 'es_spam')
                                ->get();
                return [
                    'error' => false,
                    'Formularios' => $formularios
                ];
            } else {
                return [
                    'error' => true,
                    'mensaje' => 'Error al intentar guardar el formulario',
                ];
            }
            
        } catch (\Throwable $e) {
            return [
                'error' => true,
                'mensaje' => $e
            ];
        }
    }
}
