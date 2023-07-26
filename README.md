Prueba Técnica

Usted es el responsable de realizar un sistema web para un sistema de ventas que utiliza una base de datos compuesta por las siguientes tablas:
    • Customers: almacena los datos de los clientes.
    • Products: almacena una lista de modelos de carros a escala
    • ProductLines: almacena una lista de categorías de líneas de productos.
    • Orders: almacena órdenes de venta realizadas por clientes. 
    • OrderDetails: almacena de detalles de los productos y cantidades vendidos para cada orden de venta. 
    • Payments: almacena pagos realizados por clientes basados en sus cuentas.
    • Employees: almacena la información de los empleados así como la estructura organizacional indicando quién le rinde cuentas a quién.
    • Offices: almacena los datos de las oficinas de ventas.
El esquema de la base de datos es el siguiente:


El sistema deberá permitir las siguientes actividades a través de una interfaz web:

    • Agregar y modificar información de los clientes.
    • Agregar y modificar nuevas órdenes de compra. 
    • Agregar y modificar informaciones de pagos. 

Con esas posibilidades, debe ser posible realizar el siguiente flujo: Cuando un cliente va a realizar una compra, primero, se debe revisar si ya está registrado en el sistema.  Esta consulta puede ser realizada por ID de cliente (customerNumber), apellido del contacto (contactLastName) o nombre del contacto (contactFirstName). Si el cliente está registrado, debe ser posible seleccionar el cliente para modificar información, agregar o modificar órdenes de compra o agregar o modificar informaciones de pagos.
 Si el cliente no está registrado, debe realizarse su registro con todos los datos. El sistema debe generar e informar un ID de cliente siguiendo la lógica de la base de datos.
Al agregar una nueva orden de compra, el sistema debe permitir la búsqueda de los productos digitando su nombre o buscando a través de una lista desplegable. Al seleccionar un producto, debe ser posible digitar la cantidad ordenada (quantityOrdered) y el precio por unidad (priceEach) de cada producto seleccionado. En esta pantalla, se deben mostrar estos campos, así como un campo de valor total por producto y el valor total de la compra. Una vez se confirme la compra, el sistema debe generar la fecha de compra (orderDate) y el número de orden de compra automáticamente.
A continuación, deberá pasar para agregar la fecha en que será enviado el pedido (shippedDate) y la fecha en que debería ser recibido (requiredDate) por el cliente. 
Al terminar, el sistema debe permitir generar un documento en PDF, llamado orden de servicio, con los siguientes elementos:

    • Logo de la empresa en la parte superior izquierda
    • Número de Orden de Compra
    • Fecha de la compra
    • Nombre del cliente (nombres y apellidos)
    • ID del cliente
    • Tabla con los productos seleccionados, indicando nombre del producto, línea del producto, cantidad, precio unitario, y precio total, y el total a pagar al final.
    • Fecha de envío.
    • Fecha en que será recibido.
    • Estado del pago (indicando valor pagado y deuda a la fecha).

Para registrar un nuevo pago deberá ser posible hacer una búsqueda por el ID del cliente, del apellido del cliente o del número de orden de compra. Una vez localizada la información de la compra para la cual se realizará el pago, deberá ser posible indicar el valor pagado. Se debe agregar también la forma de pago, siendo dinero en efectivo, tarjeta de crédito o transferencia electrónica.  Una vez confirmado el valor, debe ser posible generar un recibo de pago en PDF con la siguiente información:
 
    • Logo de la empresa en la parte superior izquierda
    • Número de Orden de Compra
    • Fecha de la compra
    • Nombre del cliente (nombres y apellidos)
    • ID del cliente
    • Forma de pago
    • Deuda a la fecha.

Instrucciones para la construcción del software

    • Deberá ser realizado utilizando php, Ajax y arquitectura MVP. Las tecnologías de front-end son de libre elección.
    • El software debe ejecutarse en apache y mysql de preferencia.   
    • Algunos elementos no están presentes en la base de datos actual. Debe identificar cuáles deben ser creados y en qué tablas.
    • Será evaluado lo siguiente: Funcionamiento del código, buenas prácticas de desarrollo y capacidad de documentación y explicación del software realizado.
    • La entrega debe ser realizada enviando un enlace de GitHub en el que estén los elementos. Debe contener, como mínimo, los siguientes elementos:
        ◦ Código
        ◦ Base de datos con los cambios realizados.
        ◦ Instrucciones de uso.
        ◦ Documentación del software realizado.
        ◦ Paso a paso para a ejecución del software, usando preferiblemente capturas del sistema de instalación y ejecución.