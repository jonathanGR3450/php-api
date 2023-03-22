<?php
spl_autoload_register(function ($className) {
    $prefixes = [
        'Api\\' => __DIR__ . '/../',
        // 'Api\\Models\\' => __DIR__ . '/src/Models/',
        // 'Api\\Controllers\\' => __DIR__ . '/src/Controllers/',
        // Agregar aquí otros namespaces que quieras cargar
    ];

    foreach ($prefixes as $prefix => $baseDir) {
        // Verificar si la clase utiliza el prefijo de namespace
        $len = strlen($prefix);
        if (strncmp($prefix, $className, $len) !== 0) {
            // Si no usa el prefijo de namespace, pasar al siguiente
            continue;
        }

        // Obtener el nombre de la clase sin el prefijo
        $relativeClass = substr($className, $len);

        // Reemplazar el prefijo de namespace con la ruta base
        $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';

        // Verificar si el archivo existe
        if (file_exists($file)) {
            // Incluir el archivo
            require_once $file;
        }
    }
});
