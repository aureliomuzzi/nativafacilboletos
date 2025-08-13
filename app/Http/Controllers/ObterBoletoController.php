<?php

namespace App\Http\Controllers;

use App\Services\OmieApiService;
use Illuminate\Http\Request;
use Throwable;

class ObterBoletoController extends Controller
{
    /**
     * GET /api/omie/contas-receber
     * Ex.: /api/omie/contas-receber?pagina=1&registros_por_pagina=50&apenas_importado_api=N&dt_inicio=2025-08-01&dt_fim=2025-08-31
     */
    public function index(Request $request, OmieApiService $api)
    {
        $paginaInicial   = (int) $request->query('pagina', 1);
        $porPagina       = (int) $request->query('registros_por_pagina', 50);
        $apenasImportado = (string) $request->query('apenas_importado_api', 'N');

        // Tudo que não for os parâmetros padrão vai como filtro extra
        $filtrosExtras = collect($request->query())
            ->except(['pagina','registros_por_pagina','apenas_importado_api'])
            ->toArray();

        try {
            $pagina = $paginaInicial;
            $todos  = [];
            $totalPaginas = null;

            do {
                // Chama seu Service (assumindo assinatura sugerida)
                $res = $api->listarContasReceber($pagina, $porPagina, $apenasImportado, $filtrosExtras);

                // Tenta detectar o array de registros (varia conforme método da Omie)
                $registros = $res['conta_receber']    // Omie costuma usar esta chave
                    ?? $res['registros']             // fallback comum
                    ?? $res['data']                  // fallback comum
                    ?? [];

                // Garante que é array
                if (is_array($registros)) {
                    $todos = array_merge($todos, $registros);
                }

                // Detecta total de páginas (se a Omie retornar)
                if ($totalPaginas === null) {
                    $totalPaginas = $res['total_de_paginas'] ?? null;
                }

                // Se a API informar total_de_paginas, usa; senão, para quando vier vazio
                if ($totalPaginas) {
                    $pagina++;
                } else {
                    // Para se não veio nada na página atual (modelo "até esvaziar")
                    $pagina++;
                    if (empty($registros)) {
                        break;
                    }
                }

            } while($totalPaginas ? ($pagina <= (int) $totalPaginas) : true);

            return response()->json([
                'pagina_inicial'         => $paginaInicial,
                'registros_por_pagina'   => $porPagina,
                'apenas_importado_api'   => $apenasImportado,
                'filtros'                => $filtrosExtras,
                'total_registros'        => count($todos),
                'dados'                  => $todos,
            ]);

        } catch (Throwable $e) {
            return response()->json([
                'message' => 'Falha ao consultar a Omie.',
                'error'   => app()->environment('local') ? $e->getMessage() : null,
            ], 502);
        }
    }
}
