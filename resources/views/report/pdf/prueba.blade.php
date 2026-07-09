<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guía de Remisión</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            width: 300px; /* Ancho del ticket */
            border: 1px solid #000;
            border-radius: 5px;
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            font-size: 20px;
            margin: 0;
        }
        .info {
            margin: 10px 0;
        }
        .info label {
            font-weight: bold;
        }
        .items {
            margin-top: 10px;
            border-top: 1px solid #000;
            border-bottom: 1px solid #000;
            padding: 10px 0;
        }
        .items div {
            display: flex;
            justify-content: space-between;
        }
        .total {
            font-weight: bold;
            text-align: right;
            margin-top: 10px;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: gray;
        }
    </style>
</head>
<body>

    <h1>Guía de Remisión</h1>

    <div class="info">
        <label>Remitente:</label> <span>Nombre del Remitente</span><br>
        <label>Destinatario:</label> <span>Nombre del Destinatario</span><br>
        <label>Dirección:</label> <span>Dirección del Destinatario</span><br>
        <label>Fecha:</label> <span>01/01/2023</span><br>
        <label>Número:</label> <span>123456</span>
    </div>

    <div class="items">
        <h3>Productos</h3>
        <div>
            <span>Producto 1</span>
            <span>$10.00</span>
        </div>
        <div>
            <span>Producto 2</span>
            <span>$15.00</span>
        </div>
        <div>
            <span>Producto 3</span>
            <span>$20.00</span>
        </div>
    </div>

    <div class="total">
        Total: $45.00
    </div>

    <div class="footer">
        Gracias por su compra<br>
        Teléfono: (123) 456-7890
    </div>

</body>
</html>