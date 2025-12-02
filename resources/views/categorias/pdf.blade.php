<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte pdf Categorias</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f8f9fa;
            font-family: 'Segoe UI', Arial, sans-serif;
            color: #212529;
        }
        .report-header {
            background: #003366;
            color: #fff;
            padding: 20px 0;
            text-align: center;
            margin-bottom: 30px;
            border-radius: 8px 8px 0 0;
        }
        .report-title {
            font-size: 2rem;
            font-weight: 600;
            margin-bottom: 10px;
        }
        .author {
            font-size: 1.1rem;
            color: #003366;
            margin-bottom: 20px;
            text-align: right;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }
        th, td {
            padding: 12px 15px;
            border: 1px solid #dee2e6;
            text-align: left;
        }
        th {
            background: #e9ecef;
            font-weight: 600;
        }
        tr:nth-child(even) {
            background: #f2f6fc;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            color: #6c757d;
            font-size: 0.95rem;
        }
    </style>
</head>
<body>
    <main>
        <section class="report-header">
            <div class="report-title">Reporte PDF Categorías</div>
        </section>

        <div class="author">
            Diego Sanchez
        </div>

        <section>
            <h2 style="color:#003366; font-weight:500;">Reporte Categorías</h2>
            <table>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Estado</th>
                        <th>Fecha Creación</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ( $categorias as $item)
                        <tr>
                            <td>{{ $item->nombre_categoria }}</td>
                            <td>{{ $item->descripcion }}</td>
                            <td>{{ $item->estado }}</td>
                            <td>{{ $item->created_at }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">No hay Datos</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </section>
                    
        <section class="footer">
            &copy; {{ date('Y') }} Senati - Todos los derechos reservados.
        </section>
    </main>
</body>
</html>