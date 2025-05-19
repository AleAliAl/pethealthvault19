protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\VerifyCsrfToken::class,
        ],

        'api' => [
            'cors',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];