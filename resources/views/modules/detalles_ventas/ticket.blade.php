<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ticket de compra</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif
        }
        .ticket {
            width: 300px;
            margin: auto;
            padding: 10px;
            border: 1px solid #000;
        }
        .titulo {
            font-size: 18px; 
            font-weight: bold;
        }
        .detalle {
            text-align: left;
            margin-top: 10px;
        }
        .total {
            font-size: 16px;
            font-weight: bold;
            margin-top: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border-bottom: 1px solid #000;
            padding: 5px;
            text-align: left;
        }
    </style>
</head>
<body>
    <div class="ticket">
        <p class="titulo">Ticket de compra en "Mi Tiendita"</p>
        <p><strong>Cajero: </strong>{{ $venta->nombre_usuario }}</p>
        <p><strong>Fecha </strong>{{ $venta->created_at }}</p>

        <div class="detalle">
            <table border="1">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Cant.</th>
                        <th>Precio</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($detalles as $item)
                    <tr>
                        <td class="text-center"> {{ $item->nombre_producto }}</td>
                        <td class="text-center"> {{ $item->cantidad }}</td>
                        <td class="text-center"> ${{ $item->precio_unitario }}</td>
                        <td class="text-center"> ${{ $item->sub_total }} </td>  
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <p class="total"><strong>Total de venta: </strong> ${{ $venta->total_venta }}</p>
        <p>¡Gracias por su compra!</p> 
    </div>
</body>
</html>